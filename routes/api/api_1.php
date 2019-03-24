<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Parser;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();/*For this middleware, authorization in header must be in the form of "Bearer [access_token]}*/
// The Access Token (Password Grant Token) returned will be unique to the user and will be how you find the authenticated user Auth::user();
});

Route::middleware('auth:api')->get('/logout', function (Request $request) {
	$value = $request->bearerToken();
	$id = (new Parser())->parse($value)->getHeader('jti');
	$token = $request->user()->tokens->find($id);
	$token->revoke(); //note this does not remove token from oauth_access_tokens table, it changes 'revoked' column to 1
	$response = 'You have been successfully logged out.';
	return response($response, 200);
});

Route::middleware('auth:api')->get('/projects/{project}/notes', 'APIv1\NotesController@projectNotes');