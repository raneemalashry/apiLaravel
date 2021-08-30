<!doctype html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <title>Login</title>

    </head>
    <body>
      <div class="container">
      <p> home  welcome {{auth()->user()->name}}</p>
      <form id="frm-logout" action="{{ route('logout') }}" method="POST" >
        {{ csrf_field() }}
        <button class="btn btn-primary">Logout</button>
    </form>
   
    
</html>

