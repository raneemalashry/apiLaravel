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
     
         <form method="POST" action="{{url('/login')}}">
            @csrf
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email"  name="email" class="form-control" id="email">
              
            </div>

         
            <div class="form-group">
               <label for="password">Password:</label>
               <input type="password" name="password" class="form-control" id="password">
             </div>
            <button class="btn btn-primary">login</button>
          </form>
      </div>
    </body>
   
    
</html>

