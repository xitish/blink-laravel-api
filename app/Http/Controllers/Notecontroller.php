<?php

namespace App\Http\Controllers;

use App\Note;
use App\Vote;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;

class Notecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes =  Note::orderby('created_at', 'desc')->with('user')->take(10)->get();
        return response()->json(['feeds' => $notes]);
    }

    public function search(Request $request)
    {
        $notes = Note::where('name', 'like', '%' . $request->input('note_name') . '%')->with('user')->get();
        return response()->json(['notes' => $notes]);
    }

    public function upvote(Request $request)
    {
        $id = $request->input('id');
        if(! $user = JWTAuth::parseToken()->authenticate()){
            return response()->json(['msg' => 'User Not Found'], 200);
        }
        $note = Note::where('id', $id)->first();
        $vote = new Vote([
            'user_id' => $user->id,
        ]);
        $note->votes()->save($vote);
        $note->increment('votes');

        //Find the user to whom the note belongs (To increase his credit)
        $note_user = User::where('id', $note->user_id);
        $note_user->increment('credit', 4);

        return response()->json(['msg' => 'Upvote Done']);
    }

    public function downvote(Request $request)
    {
        $id = $request->input('id');
        if(! $user = JWTAuth::parseToken()->authenticate()){
            return response()->json(['msg' => 'User Not Found'], 200);
        }

        //Find the note with supplied id
        $note = Note::where('id', $id)->first();

        $vote = new Vote([
            'user_id' => $user->id,
        ]);

        $note->votes()->save($vote);

        $note->decrement('votes');

        //Find the user to whom the note belongs (To increase his credit)
        $note_user = User::where('id', $note->user_id);
        $note_user->decrement('credit', 2);
    
        return response()->json(['msg' => 'Down Vote Done']);
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
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $name = $request->input('name');
        $desc = $request->input('description');

        if(! $user = JWTAuth::parseToken()->authenticate()){
            return response()->json(['msg' => 'User Not Found'], 200);
        }

        Note::create([
            'name' => $name,
            'description' => $desc,
            'votes' => 0,
            'user_id' => $user->id,
        ]);

        $reponse = [
            'message' => 'New Note Added',
            'success' => true
        ];

        return response()->json($reponse, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note  = Note::where('id', $id)->with('user')->first();
        return response()->json($note, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        //
    }
}
