<?php

namespace App\Http\Controllers\APIv1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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


    /**
    * --------------------------------------------------------------------
    *   Route: /users/{user}/projects
    * --------------------------------------------------------------------
    * @param int $id - user's id
    */
    public function userProjects($id) {

        //TODO verify params & error handling

        $user = \App\User::find($id);

        if (is_null($user)) {
            return response()->json(['error' => 'Could not find user'], 422);
        }

        $projects = $user->projects;

        // $projects = DB::table('user_project')
        //     ->join('users', 'users.id', '=', 'user_project.user_id')
        //     ->join('projects', 'projects.id', '=', 'user_project.project_id')
        //     ->select('projects.*')
        //     ->where('users.id', $id)
        //     // ->orderby('notes.created_at', 'desc')
        //     ->get();

        return response()->json($projects);
    }
}
