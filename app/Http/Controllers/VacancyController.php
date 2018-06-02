<?php

namespace App\Http\Controllers;

use App\Role;
use App\Team;
use App\Vacancy;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($teamId)
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
    public function destroy($id)
    {
        //
    }
}
