<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Jrean\UserVerification\Traits\VerifiesUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use VerifiesUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
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

//        $this->validator($request->all())->validate();
//
//        $user = $this->create($request->all());

        event(new Registered($user));

        $this->guard()->login($user);

        UserVerification::generate($user);

        UserVerification::send($user, 'My Custom E-mail Subject');



        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
