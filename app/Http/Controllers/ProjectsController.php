<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('project.index');
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'account_name' => 'required|min:3|max:255',
            'account_number' => 'required|min:1|max:6',
            'description' => 'required|min:3|max:500',
            'work_orders' => 'required|unique:projects|min:1|max:6',
            'due_date' => 'required',
            'status' => 'required'

        ]);


        if ($validator->fails()) {

            $errors = $validator->errors();

            $name = $errors->first('name');
            $account_name = $errors->first('account_name');
            $account_number = $errors->first('account_number');
            $description = $errors->first('description');
            $work_orders = $errors->first('work_orders');
            $due_date = $errors->first('due_date');
            $status = $errors->first('status');

            return response()->json([
                'name' => $name,
                 'account_name' => $account_name,
                  'account_number' => $account_number,
                  'description' => $description,
                  'work_orders' => $work_orders,
                  'due_date' => $due_date,
                  'status' => $status
              ], 422);
        } else {
            $project = new \App\Project();
            $project->name = $request->name;
            $project->account_name = $request->account_name;
            $project->account_number = $request->account_number;
            $project->description = $request->description;
            $project->work_orders = $request->work_orders;
            $project->due_date = $request->due_date;
            $project->status = $request->status;
            $project->save();
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
}
