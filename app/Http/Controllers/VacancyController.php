<?php

namespace App\Http\Controllers;

use App\Http\Resources\VacancyResource;
use App\Member;
use App\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function teamVacancies($teamId)
    {
        if (!$teamId) {
            return response()->json([
                'errors' => [
                    [
                        'status' => 400,
                        'details' => 'É necessário informar uma equipe para listar suas vagas.'
                    ]
                ]
            ], 400);
        }

        $vacancies = Vacancy::where('team_id', $teamId)->get();
        return response()->json([
            'data' => $vacancies
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            $vacancies = Vacancy::leftJoin('teams', 'vacancies.team_id', '=', 'teams.id')->get();
            return response()->json([
                'data' => $vacancies
            ]);
        }
        $summoner = DB::table('summoners')->where('id', $user->summoner_id)->first();
        $result = Vacancy::leftJoin('teams', 'vacancies.team_id', '=', 'teams.id')
            ->where('teams.tier_min', '<=', $summoner->tier_id)
            ->where('teams.user_id', '<>', $user->id)
            ->get();
        $alreadyMember = Member::where('user_id', $user->id)->get();
        $vacancies = [];
        if (sizeof($alreadyMember) === 0) {
            $vacancies = $result;
        } else {

            foreach ($result as $r) {
                foreach ($alreadyMember as $m) {
                    if ($m->team_id !== $r->team_id) {
                        array_push($vacancies, $r);
                    }
                }
            }
        }
        return response()->json([
            'data' => $vacancies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $teamId)
    {
        $vacancy = new Vacancy;
        $vacancy->team_id = $teamId;
        $vacancy->role_id = $request->role_id;
        $vacancy->save();

        return response()->json([
            'data' => $this->show($vacancy->id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Vacancy::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($teamId, $id)
    {
        $vacancy = Vacancy::find($id);
        $vacancy->delete();
        return response()->json([], 204);
    }
}
