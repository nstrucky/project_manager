<?php

namespace App\Http\Controllers\APIv1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;

class TasksController extends Controller
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
        //TODO check that status entered matches one in database

        $validator = Validator::make($request->all(), [
            'status' => 'required|min:3|max:255',
            'title' => 'required|min:1|max:255',
            'start_date' => 'required|date_format:Y-m-d',
            'due_date' => 'required|date_format:Y-m-d',
            'user_id' => 'required|integer',
            'project_id' => 'required|integer',
            'task_template_id' => 'integer'

        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            $status = $errors->first('status');
            $title = $errors->first('title');
            $start_date = $errors->first('start_date');
            $due_date = $errors->first('due_date');
            $user_id = $errors->first('user_id');
            $project_id = $errors->first('project_id');
            $task_template_id = $errors->first('task_template_id');


            return response()->json([
                'status' => $status,
                 'title' => $title,
                  'start_date' => $start_date,
                  'due_date' => $due_date,
                  'user_id' => $user_id,
                  'project_id' => $project_id,
                  'task_template_id' => $task_template_id,
              ], 422);
        } else {
            $task = new \App\Task();
            $task->status = $request->status;
            $task->title = $request->title;
            $task->start_date = $request->start_date;
            $task->due_date = $request->due_date;
            $task->user_id = $request->user_id;
            $task->project_id = $request->project_id;
            $task->task_template_id = 0; //TODO take from request in next API version, defaulting all to 0 for now

            if($task->save()) {
                return response()->json(['message' => 'Task saved to DB'], 200);
            }
        }

            return response()->json(['error' => 'Problem saving task to DB'], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = \App\Task::find($id);

        if (is_null($task)) {
            return response()->json(['error' => 'Could not find task: ' . $id], 404);
        }

        return response()->json($task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
            'status' => 'required|min:3|max:255',
            'title' => 'required|min:1|max:255',
            'start_date' => 'required|date_format:Y-m-d',
            'due_date' => 'required|date_format:Y-m-d',
            'user_id' => 'required|integer',
            'project_id' => 'required|integer',
            'task_template_id' => 'integer'

        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            $status = $errors->first('status');
            $title = $errors->first('title');
            $start_date = $errors->first('start_date');
            $due_date = $errors->first('due_date');
            $user_id = $errors->first('user_id');
            $project_id = $errors->first('project_id');
            $task_template_id = $errors->first('task_template_id');


            return response()->json([
                'status' => $status,
                 'title' => $title,
                  'start_date' => $start_date,
                  'due_date' => $due_date,
                  'user_id' => $user_id,
                  'project_id' => $project_id,
                  'task_template_id' => $task_template_id,
              ], 422);
        } 

        $task = \App\Task::find($id);
        if (is_null($task)) {
            return response()->json(['error' => 'Task ' . $id .' does not exist'], 404);
        }
        $task->status = $request->status;
        $task->title = $request->title;
        $task->start_date = $request->start_date;
        $task->due_date = $request->due_date;
        $task->user_id = $request->user_id;
        $task->project_id = $request->project_id;
        $task->task_template_id = 0; //TODO take from request in next API version, defaulting all to 0 for now

        if($task->save()) {
            return response()->json(['message' => 'Task saved to DB'], 200);
        }

        return response()->json(['error' => 'Problem saving task to DB'], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = \App\Task::find($id);

        if (is_null($task)) {
            return response()->json(['error' => 'Project does not exist'], 404);
        }

        if ($task->delete()) { //success
            return response()->json(['message' => 'Successfully deleted task',
                                        'id' => $id,
                                        'task_name' => $task->title], 200);
        }
        
        return response()->json(['error' => 'Error removing task'], 400);
    }


    /**
    *--------------------------------------------------------------------
    * Route: /users/{user}/tasks
    *--------------------------------------------------------------------
    * @param int $id - user's id
    */
    public function userTasks($id) {
        //TODO validate params & error handling

        // $userTasks = \App\User::find($id)->tasks;

        $userTasks = DB::table('tasks')
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->join('projects', 'projects.id', '=', 'tasks.project_id')
            ->select('tasks.id', 'tasks.status', 'tasks.completed', 'tasks.title', 'tasks.start_date',
                'tasks.due_date', 'tasks.completed_on',
             'users.first_name', 'users.last_name', 'projects.name', 'tasks.project_id')
            ->where('tasks.user_id', $id)
            ->orderby('tasks.due_date', 'desc')
            ->get();


        return response()->json($userTasks);
    }


    /**
    *--------------------------------------------------------------------
    * Route: /projects/{project}/tasks
    *--------------------------------------------------------------------
    * @param int $id - projects's id
    */
    public function projectTasks($id) {
        //TODO validate params & error handling

        // $projectTasks = \App\Project::find($id)->tasks;

        $projectTasks = DB::table('tasks')
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->join('projects', 'projects.id', '=', 'tasks.project_id')
            ->select('tasks.id', 'tasks.status', 'tasks.completed', 'tasks.title', 'tasks.start_date', 'tasks.due_date', 'tasks.completed_on',
             'users.first_name', 'users.last_name', 'projects.name', 'tasks.project_id')
            ->where('tasks.project_id', $id)
            ->orderby('tasks.due_date', 'desc')
            ->get();

        return response()->json($projectTasks);
    }
}
