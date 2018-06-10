<?php

namespace App\Http\Controllers;

use App\Summoner;
use App\Tier;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use App\Region;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request) {

        $summoner = Summoner::where('name', $request->name)->first();
        if ($summoner) {
            return response([
                'errors' => [
                    [
                        'details' => 'Nome de invocador já cadastrado!'
                    ]
                ]
            ], 400);
        }

        $region = Region::where('id', $request->region_id)->first();
        $client = new Client([
            'base_uri' => "https://" . $region->riot_id . ".api.riotgames.com/lol/",
            'query' => [
                'api_key' => env('RIOT_API_KEY')
            ]
        ]);
        try {
            $summonerResponse = $client->get("summoner/v3/summoners/by-name/$request->nickname");
        } catch (ClientException $exception) {
            return response([
                'errors' => [
                    [
                        'status' => 404,
                        'detail' => 'Nome de invocador não encontrado!'
                    ]
                ],
            ], 400);
        }
        $riot_summoner = json_decode($summonerResponse->getBody());
        $rankingResponse = $client->get("league/v3/positions/by-summoner/$riot_summoner->id");
        $rankings = json_decode($rankingResponse->getBody());

        if (sizeof($rankings) == 0) {
            $ranking = (object) [
                'tier' => 1
            ];

        } else {
            $ranking = $rankings[0];
            foreach ($rankings as $r) {
                if ($this->tierToInt($r->tier) > $this->tierToInt($ranking->tier)) {
                    $ranking->tier = $r->id;
                }
            }
        }

        $tier = Tier::where('riot_id', $ranking->tier)->first();

        $summoner = new Summoner;
        $summoner->id = $riot_summoner->id;
        $summoner->profile_icon_id = $riot_summoner->profileIconId;
        $summoner->name = $riot_summoner->name;
        $summoner->level = $riot_summoner->summonerLevel;
        $summoner->revision_date = $riot_summoner->revisionDate;
        $summoner->account_id = $riot_summoner->accountId;
        $summoner->tier_id = $tier['id'] || 1;
        $summoner->save();

        $user = User::create([
            'email' => $request->email,
            'nickname' => $request->nickname,
            'region_id' => $request->region_id,
            'password' => bcrypt($request->password),
            'summoner_id' => $riot_summoner->id
        ]);

        $token = auth()->login($user);
        return response()->json([
            'data' => [
                'user' => $user,
                'summoner' => $summoner
            ],
            'token' => $token
        ]);
    }

    public function login(Request $request) {
        $credentials = $request->only(['email', 'password']);
        if(!$token = auth()->attempt($credentials)) {
            return response([
                'errors' => [
                    [
                        'status' => 404,
                        'detail' => 'Usuário ou senha incorretos!'
                    ]
                ],
            ], 401);
        }
        $user = auth()->user();
        $summoner = Summoner::where('id', $user->summoner_id)->first();
        return response()->json([
            'data' => [
                'user' => $user,
                'summoner' => $summoner
            ],
            'token' => $token
        ]);
    }

    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    protected function tierToInt($tier) {
        $tiers = [
            'UNRANKED' => 1,
            'BRONZE' => 2,
            'SILVER' => 3,
            'GOLD' => 4,
            'PLATINUM' => 5,
            'DIAMOND' => 6,
            'MASTER' => 7,
            'CHALLENGER' => 8
        ];
        return $tiers[$tier];
    }
}
