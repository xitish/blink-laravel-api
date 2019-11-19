<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shreaders</title>
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
</head>
<body>
    @include('partials.header')

    @yield('content')

    <!--The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#config-web-app -->

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyBA3r4ZiJAXqP1LRGafMYLtnJ1Cv7UId0M",
    authDomain: "blink-project-88c43.firebaseapp.com",
    databaseURL: "https://blink-project-88c43.firebaseio.com",
    projectId: "blink-project-88c43",
    storageBucket: "",
    messagingSenderId: "248391694243",
    appId: "1:248391694243:web:241aea5dad2cbd44"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
</script>
</body>
</html>