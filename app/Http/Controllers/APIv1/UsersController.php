<?php

namespace App\Http\Controllers\APIv1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;


class UsersController extends Controller
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
    *--------------------------------------------------------------------
    * Route: /projects/{project}/users
    *--------------------------------------------------------------------
    * @param int $id - project's id
    */
    public function projectUsers($id) {
    //select u.first_name, u.last_name, n.* from user_notes un inner join notes n on un.note_id = n.id inner join users u on un.user_id = u.id where n.project_id = 1;

        //TODO verify params & error handling

        $users = DB::table('user_project')
            ->join('users', 'users.id', '=', 'user_project.user_id')
            ->join('projects', 'projects.id', '=', 'user_project.project_id')
            ->select('users.id', 'users.username', 'users.first_name', 'users.last_name', 'users.email', 'users.user_role')
            ->where('projects.id', $id)
            // ->orderby('notes.created_at', 'desc')
            ->get();

        return response()->json($users);
    }
}
