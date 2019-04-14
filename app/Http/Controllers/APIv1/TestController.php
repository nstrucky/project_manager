<?php

namespace App\Http\Controllers\APIv1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use \App\Events\TestNoteCreated;

use \App\Note;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function makeNote(Request $request) {
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
        $note->user_id = 1;
        $note->save();

        if ($note->id != null && $note->id != 0) { //success
           // return response()->json($note); 
        	event(new TestNoteCreated($note));
        }
    }


    public function test(Request $request) {
    	return response()->json(['message' => 'You are connected!']);
    }
}
