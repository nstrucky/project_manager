<?php

namespace App\Http\Controllers\APIv1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use \App\Note;
use App\Http\Controllers\Controller;
use Auth;

class NotesController extends Controller {

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

        $validator = Validator::make($request->all(), [
            'project_id' => 'required|numeric',
            'content' => 'required|min:3|max:500'
        ]);

        if ($validator->fails()) { // failure
            $errors = $validator->errors();

            return response()->json([
                'error' => 'Validation Error, check variables input',
                'project_id' => $errors->first('project_id'),
                'content' => $errors->first('content')
            ], 422);
        }

        $note = new Note();
        $note->project_id = $request->project_id;
        $note->content = $request->content;

        $note->save();

        if ($note->id != null && $note->id != 0) { //success

           $id = DB::table('user_notes')->insertGetId([
                'user_id' => Auth::user()->id, 
                'note_id' => $note->id,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()

           ]);

           return response()->json($note); 
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
        $note = \App\Note::find($id);
        if (is_null($note)) {
            return response()->json(['error' => 'Note does not exist'], 404);
        }

        return response()->json($note);
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
                if (!Auth::check()) {
            return response()->json(['error' => 'user not authenticated'], 422);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|min:3|max:500'
        ]);

        if ($validator->fails()) { // failure
            $errors = $validator->errors();

            return response()->json([
                'error' => 'Validation Error, check variables input',
                'content' => $errors->first('content')
            ], 422);
        }

        $note = \App\Note::find($id);
        if (is_null($note)) {
            return response()->json(['error' => 'Note does not exist'], 404);
        }
        $note->content = $request->content;
        $note->save();

        return response()->json($note); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'user not authenticated'], 422);
        }

        $note = \App\Note::find($id);

        if (is_null($note)) {
            return response()->json(['error' => 'Note does not exist'], 404);
        }

        if ($note->delete()) { //success
            return response()->json(['message' => 'Successfully deleted note: '.$id], 200);
        }
        
        return response()->json(['error' => 'Error removing note'], 400);
        
    }


    /**
    *--------------------------------------------------------------------
    * Route: /projects/{project}/notes
    *--------------------------------------------------------------------
    * @param int $id - projects's id
    */
    public function projectNotes($id) {
        //select u.first_name, u.last_name, n.* from user_notes un inner join notes n on un.note_id = n.id inner join users u on un.user_id = u.id where n.project_id = 1;

        $project = \App\Project::find($id);

        if (is_null($project)) {
            return response()->json(['error' => 'could not find project'], 404);
        }

        $notes = $project->notes;

        // $notes = DB::table('user_notes')
        //     ->join('users', 'users.id', '=', 'user_notes.user_id')
        //     ->join('notes', 'notes.id', '=', 'user_notes.note_id')
        //     ->select('notes.*', 'users.first_name', 'users.last_name')
        //     ->where('notes.project_id', $id)
        //     ->orderby('notes.created_at', 'desc')
        //     ->get();

        return response()->json($notes);
    }


    /**
    *--------------------------------------------------------------------
    * Route: /users/{user}/notes
    *--------------------------------------------------------------------
    * @param int $id - user's id
    */
    public function userNotes($id) {
        $user = \App\User::find($id);

        if (is_null($user)) {
            return response()->json(['error' => 'Could not find user'], 422);
        }

        $notes = $user->notes;

        return response()->json($notes);
    }

}
?>