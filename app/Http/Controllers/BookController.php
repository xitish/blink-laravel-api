<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Book;
use App\User;
use App\Brequest;
use JWTAuth;
define('API_ACCESS_KEY', 'AAAA2UgpZzo:APA91bFHHaDjPR1ULAo6zBhYXPCBX57jHPxqbnqMaRl5V40MNDXZVw-k0Gfu5eB6GsXgicthsvDEsnPbUTGsXmiUSySL_bzf2PkbSJh6tAJcWnZVZmxBm6o-5gstf_DXLcdpZnspaKG2');

class BookController extends Controller
{
    public function sendNotification($bookname,$username,$token) {
    	$msg = array
    	          (
    			'body' 	=> $username.', Get this book now',
    			'title'	=> $bookname . ' is now available'
    	          );
    		$fields = array
    				(
    					'to'		=> $token,
    					'notification'	=> $msg
    				);
    		
    		
    		$headers = array
    				(
    					'Authorization: key=' . API_ACCESS_KEY,
    					'Content-Type: application/json'
    				);
    			$ch = curl_init();
    			curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    			curl_setopt( $ch,CURLOPT_POST, true );
    			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt($ch, CURLOPT_VERBOSE, true);
    			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                $result = curl_exec($ch);
                curl_close( $ch );
                return $result;
                

    }

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(! $user = JWTAuth::parseToken()->authenticate()){
            return response()->json(['msg' => 'User Not Found'], 200);
        }

        $books = Book::join('users', 'books.user_id', '=', 'users.id')->orderBy('users.credit', 'desc')->where([
            ['status' , '=', '0'],
            ['user_id' , '<>', $user->id]
        ])->with('user')->get(['books.*']);

        return response()->json(['feeds' => $books]);
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'book_name' => 'required',
        ]);   
        $books = Book::where('name', 'like', '%' . $request->input('book_name') . '%')->with('user')->get();
        return response()->json(['books' => $books]);
    }

    public function buy(Request $request)
    {
        $this->validate($request, [
            'book_id' => 'required',
        ]);

        $book = Book::find($request->input('book_id'))->update(['status' => 1]);

        return response()->json(['success' => true]);
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
            'author' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $name = $request->input('name');
        $author = $request->input('author');
        $desc = $request->input('description');
        $price = $request->input('price');

        if(! $user = JWTAuth::parseToken()->authenticate()){
            return response()->json(['msg' => 'User Not Found'], 200);
        }

        Book::create([
            'name' => $name,
            'author' => $author,
            'description' => $desc,
            'price' => $price,
            'status' => 0,
            'user_id' => $user->id,
        ]);

        $response = [
            'message' => 'New Book Added',
            'success' => true
        ];

        $users = User::all();

        //$requests = Brequest::select('firebase_token')->where([['status', '=',0],['book_name', 'like', $name]])->join('users', 'brequests.user_id', '=', 'users.id')->get();

        //$arrays= array();
        foreach($users as $user)
        {
            if($user->firebase_token != null){
                $a = $this->sendNotification($name, $user->name, $user->firebase_token);
                //array_push($arrays,$request->firebase_token);
            }
        }

        /* $requests = Brequest::select('firebase_token')->where([['status', '=',0],['book_name', 'like', $name]])->join('users', 'brequests.user_id', '=', 'users.id')->get();

        $arrays= array();
        foreach($requests as $user)
        {
            if($user->firebase_token != null){
                $a = $this->sendNotification($name, '', $request->firebase_token);
                //array_push($arrays,$request->firebase_token);
            }
        } */


        return response()->json($a, 200);
    }

    public function request(Request $request)
    {
        if(! $user = JWTAuth::parseToken()->authenticate()){
            return response()->json(['msg' => 'User Not Found'], 200);
        }

        $book_name = $request->input('book_name');

        DB::table('brequests')->insert([
            [
                'book_name' => $book_name,
                'user_id' => $user->id,
                'status' => 0,
            ],
        ]);
        return response()->json(['msg' => 'success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book  = Book::where('id', $id)->with('user')->first();
        return response()->json($book, 200);
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

    public function shop($id)
    {

    }

}
