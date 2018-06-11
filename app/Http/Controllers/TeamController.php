<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Http\Resources\TeamResource;
use Illuminate\Http\Resources\Json\Resource;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $teams = Team::leftJoin('members', 'teams.id', '=', 'members.team_id')
            ->select('teams.*')
            ->where('teams.user_id', $user->id)
            ->orWhere('members.user_id', $user->id)
            ->get();
//            ->filter(function($team) use ($user) {
//                return $team->id
//            })
//        $teams = TeamResource::collection(Team::all());
//        $teas->filter(function($team) {
//          return $team->user->id == $user->id ? $team : null;
//        });

        return response()->json([
            'data' => $teams
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $team = Team::create([
            'abbreviation' => $request->abbreviation,
            'name' => $request->name,
            'user_id' => $request->user()->id,
            'tier_min' => $request->tier_min
        ]);

        $team->modes()->attach($request->modes);

        return $this->show($team->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Team::with([
            'modes',
            'vacancies.candidates.user.summoner',
            'members.user.summoner',
            'user.summoner'
        ])->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $team = $this->show($id);
        $team->modes()->detach();
        $team->modes()->attach($request->modes);
        $team->name = $request->name;
        $team->abbreviation = $request->abbreviation;
        $team->tier_min = $request->tier_min;
        $team->save();
        return $this->show($team->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
