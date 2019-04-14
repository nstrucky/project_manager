<?php

namespace App\Http\Controllers\APIv1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use Auth;

class UsersController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Handled by Auth registration
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = \App\User::find($id);

        if (is_null($user)) {
            return response()->json(['error' => 'Could not find user: ' . $id], 404);
        }

        return response()->json($user);
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
        $validator = Validator::make($request->all(), [
            'username' => 'min:3|max:255',
            'first_name' => 'min:3|max:255',
            'last_name' => 'min:1|max:255',
            'email' => 'min:3|max:500',
            'user_role' => 'min:1|max:255', 
        ]);

        if ($validator->fails()) { // failure
            $errors = $validator->errors();

            $username = $errors->first('username');
            $first_name = $errors->first('first_name');
            $last_name = $errors->first('last_name');
            $email = $errors->first('email');
            $user_role = $errors->first('user_role');

            return response()->json([
                'error' => 'Validation Error, check variables input',
                'username' => $username,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'user_role' => $user_role,
            ], 422);
        }

        $user = \App\User::find($id);
        if (is_null($user)) {
            return response()->json(['error' => 'User ' . $id .' does not exist'], 404);
        }

        if (!is_null($request->username)) $user->username = $request->username;
        if (!is_null($request->first_name)) $user->first_name = $request->first_name;
        if (!is_null($request->last_name)) $user->last_name = $request->last_name;
        if (!is_null($request->email)) $user->email = $request->email;
        if (!is_null($request->user_role)) $user->user_role = $request->user_role;

        if($user->save()) {
            return response()->json(['message' => 'User saved to DB', 'user' => $user], 200, [], JSON_NUMERIC_CHECK);
        }

        return response()->json(['error' => 'Problem saving user to DB'], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Handled by registration...?
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

        $project = \App\Project::find($id);

        if (is_null($project)) {
            return response()->json(['error' => 'Could not find project'], 404);
        }

        // $users = $project->users;

        $users = DB::table('user_project')
            ->join('users', 'users.id', '=', 'user_project.user_id')
            ->join('projects', 'projects.id', '=', 'user_project.project_id')
            ->select('users.id', 'users.username', 'users.first_name', 'users.last_name', 'users.email', 'users.user_role')
            ->where('projects.id', $id)
            // ->orderby('notes.created_at', 'desc')
            ->get();

        return response()->json($users);
    }


    public function addProjectUser(Request $request, \App\Project $project) {
        
        $projectId = $project->id;

        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'integer', 'exists:users,id', 
                Rule::unique('user_project', 'user_id')->where(function ($query) use ($projectId) {
                    return $query->where('project_id', $projectId);
                })
            ],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $user_id = $errors->first('user_id');
            return response()->json([
                'error' => $user_id
            ], 409);
        }

        $addUser = \App\User::find($request->user_id);

        if (is_null($addUser)) {
            return response()->json(['error' => 'could not find user id to add to project',
                'user_id' => $request->user_id], 404);
        }

        $addUserId = $addUser->id;

        $userProjectId = DB::table('user_project')->insertGetId([
            'user_id' => $addUserId,
            'project_id' => $projectId
        ]);

        if (is_null($userProjectId) || $userProjectId == 0) {
            return response()->json(['error' => 'could not create user_project record'], 500);
        }

        return response()->json(['message' => 'successfully added user to project',
                                'id' => $userProjectId,
                                'added_user' => $addUser
                                ], 200);
    }

    public function removeProjectUser(Request $request, \App\Project $project) {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:user_project|exists:users,id' 
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $user_id = $errors->first('user_id');
            return response()->json([
                'error' => $user_id
            ], 422);
        }

        $query = DB::table('user_project')
            
            ->where('project_id', '=', $project->id);
        $records = $query->select()->get();

        if ($records->count() <= 1) {
            return response()->json(['error' => 'Could not remove user, only one user assigned to project'], 422);
        }

        $success = $query->where('user_id', '=', $request->user_id)->delete();

        if ($success) {
            return response()->json(['user_id' => $request->user_id,
                'message' => 'user successfully removed from project'], 200);
        }

        return response()->json(['error' => 'could not remove user from project'], 500);

    }




}
