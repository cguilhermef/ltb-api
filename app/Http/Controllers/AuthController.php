<?php

namespace App\Http\Controllers;

use App\Summoner;
use App\Tier;
use GuzzleHttp\Client;
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
        $summonerResponse = $client->get("summoner/v3/summoners/by-name/$request->nickname");
        if($summonerResponse->getStatusCode() !== 200) {
            return response([
                'errors' => [
                    [
                        'details' => 'Problema!'
                    ]
                ],
                'riot' => $summonerResponse->getBody()
            ], 400);
        }
        $riot_summoner = json_decode($summonerResponse->getBody());
        $rankingResponse = $client->get("league/v3/positions/by-summoner/$riot_summoner->id");
        $rankings = json_decode($rankingResponse->getBody());

        if (sizeof($rankings) == 0) {
            $ranking = [
                'tier_id' => 8
            ];
        } else {
            $ranking = $rankings[0];
            foreach ($rankings as $r) {
                if ($this->tierToInt($r->tier) > $this->tierToInt($ranking->tier)) {
                    $ranking = $r;
                }
            }
        }

        $tier = Tier::where('riot_id', $ranking['tier_id'])->first();

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
            'data' => $user,
            'token' => $token
        ]);
    }

    public function login(Request $request) {
        $credentials = $request->only(['email', 'password']);
        if(!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = auth()->user();
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
//        return $this->respondWithToken($token);
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
            'BRONZE' => 1,
            'SILVER' => 2,
            'GOLD' => 3,
            'PLATINUM' => 4,
            'DIAMOND' => 5,
            'MASTER' => 6,
            'CHALLENGER' => 7
        ];
        return $tiers[$tier];
    }
}
