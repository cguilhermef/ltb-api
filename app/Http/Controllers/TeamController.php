<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Http\Resources\TeamResource;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TeamResource::collection(Team::all());
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
        return Team::with(['modes', 'vacancies'])->find($id);
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
