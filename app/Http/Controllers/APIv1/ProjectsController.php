<?php

namespace App\Http\Controllers\APIv1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use Auth;

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
        if (!Auth::check()) {
            return response()->json(['error' => 'user not authenticated'], 422);
        }

        $userId = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'account_name' => 'required|min:3|max:255',
            'account_number' => 'required|min:1|max:6',
            'description' => 'required|min:3|max:500',
            'work_order' => 'required|unique:projects|min:1|max:6',
            'due_date' => 'required|date_format:Y-m-d',
            'status' => 'required|min:1|max:25'

        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            $name = $errors->first('name');
            $account_name = $errors->first('account_name');
            $account_number = $errors->first('account_number');
            $description = $errors->first('description');
            $work_order = $errors->first('work_order');
            $due_date = $errors->first('due_date');
            $status = $errors->first('status');

            return response()->json([
                'name' => $name,
                 'account_name' => $account_name,
                  'account_number' => $account_number,
                  'description' => $description,
                  'work_order' => $work_order,
                  'due_date' => $due_date,
                  'status' => $status
              ], 422);
        } else {
            $project = new \App\Project();
            $project->name = $request->name;
            $project->account_name = $request->account_name;
            $project->account_number = $request->account_number;
            $project->description = $request->description;
            $project->work_order = $request->work_order;
            $project->due_date = $request->due_date;
            $project->status = $request->status;
            
            if($project->save()) {
                $userProjectId = DB::table('user_project')->insertGetId([
                    'user_id' => $userId,
                    'project_id' => $project->id
                ]);

                if (is_null($userProjectId) || $userProjectId == 0) {
                    return response()->json(['error' => 'could not create user_project record'], 500);
                }

                return response()->json(['id' => $project->id,
                                        'user_id' => $userId,
                                        'message' => 'Project saved to DB'], 200);
            }

            return response()->json(['error' => 'Problem saving project to DB'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = \App\Project::find($id);

        if (is_null($project)) {
            return response()->json(['error' => 'Could not find project: ' . $id], 404);
        }

        return response()->json($project);
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

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'account_name' => 'required|min:3|max:255',
            'account_number' => 'required|min:1|max:6',
            'description' => 'required|min:3|max:500',
            'work_order' => 'required|min:1|max:6', // this just ignores the fact that you can name a work order the same as another
            'due_date' => 'required|date_format:Y-m-d',
            'status' => 'required|min:1|max:25'
        ]);

        if ($validator->fails()) { // failure
            $errors = $validator->errors();

            $name = $errors->first('name');
            $account_name = $errors->first('account_name');
            $account_number = $errors->first('account_number');
            $description = $errors->first('description');
            $work_order = $errors->first('work_order');
            $due_date = $errors->first('due_date');
            $status = $errors->first('status');

            return response()->json([
                'error' => 'Validation Error, check variables input',
                'name' => $name,
                'account_name' => $account_name,
                'account_number' => $account_number,
                'description' => $description,
                'work_order' => $work_order,
                'due_date' => $due_date,
                'status' => $status
            ], 422);
        }

        $project = \App\Project::find($id);
        if (is_null($project)) {
            return response()->json(['error' => 'Project ' . $id .' does not exist'], 404);
        }

        $project->name = $request->name;
        $project->account_name = $request->account_name;
        $project->account_number = $request->account_number;
        $project->description = $request->description;
        $project->work_order = $request->work_order;
        $project->due_date = $request->due_date;
        $project->status = $request->status;

        if($project->save()) {
            return response()->json(['message' => 'Project saved to DB'], 200);
        }

        return response()->json(['error' => 'Problem saving project to DB'], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = \App\Project::find($id);

        if (is_null($project)) {
            return response()->json(['error' => 'Project does not exist'], 404);
        }

        if ($project->delete()) { //success
            return response()->json(['message' => 'Successfully deleted project',
                                        'id' => $id, 
                                        'project_name' => $project->name], 200);
        }
        
        return response()->json(['error' => 'Error removing project'], 400);
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
