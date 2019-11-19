<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admin Overview</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
                <div class="container mt-5">
                <h1 class="text-danger text-center">Admin Panel Overview</h1><hr>
                    <div class="row mt-5">
                        <div class="col-md-4">
                        <h3>Users <span style="float:right;" class="badge badge-secondary">{{$ucount}}</span> </h3>
                        <hr>
                        @foreach($users as $user)
                            <div class="card card-body p-3 mt-3" style="border-radius:10px; border:1px solid #c3c3c3;" >
                                <h4 style="font-weight:bold">{{$user->first_name}} {{$user->last_name}} <span style="float:right" class="badge badge-primary">{{$user->credit}}</span> </h4><hr>
                                <span>Books &nbsp;<span class="badge badge-primary">{{$user->books_count}}</span> <span style="float:right;s"> Notes &nbsp; <span class="badge badge-success"> {{$user->notes_count}} </span></span></span>
                                
                            </div>
                        @endforeach
                        </div>

                        <div class="col-md-4">
                        <h3> <span class="text-success">Books</span><span style="float:right;" class="badge badge-success">{{$bcount}}</span> </h3>
                        <hr>
                        @foreach($books as $book)
                            <div class="card card-body p-3 mt-3" style="border-radius:10px; border:1px solid #c3c3c3;" >
                                <h4 style="font-weight:bold">{{$book->name}} @if($book->status) <span class="badge badge-danger">Sold</span> @endif</h4>
                                <h5 style="font-weight:bold">Author : {{$book->author}}</h5>
                                <span>Posted by: &nbsp;<span class="badge badge-primary">{{$book->user->first_name}}</span> <span style="float:right;s"> Price &nbsp; <span class="badge badge-success"> Rs. {{$book->price}} </span></span></span>
                                
                            </div>
                        @endforeach
                        </div>

                        <div class="col-md-4">
                        <h3> <span class="text-primary">Notes</span><span style="float:right;" class="badge badge-primary">{{$ncount}}</span> </h3>
                        <hr>
                        @foreach($notes as $note)
                            <div class="card card-body p-3 mt-3" style="border-radius:10px; border:1px solid #c3c3c3;" >
                                <h4 style="font-weight:bold">{{$note->name}}</h4>
                                <h5 style="font-weight:bold">By : {{$note->user->first_name}}</h5>
                                <span>Votes &nbsp;<span class="badge badge-primary">{{$note->votes}}</span></span>
                                
                            </div>
                        @endforeach
                        </div>

                        
                    </div>
                </div>
    </body>
</html>
