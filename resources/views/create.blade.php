<!doctype html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="_token" content="{{csrf_token()}}" />

        <title>Register</title>
        <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    </head>
    <body>
      <div class="container">
     
         <form id="myForm" >
          <div class="alert alert-success" style="display:none"></div>
          <div class="error alert-danger" style="display:none"></div>
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" class="form-control" id="name">
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" id="email">
            </div>
            <div class="form-group">
               <label for="password">Password:</label>
               <input type="password" class="form-control" id="password">
             </div>
            <button class="btn btn-primary" id="ajaxSubmit">Submit</button>
          </form>
      </div>
      <script src="http://code.jquery.com/jquery-3.3.1.min.js"
               integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
               crossorigin="anonymous"></script>
      <script>
        jQuery(document).ready(function(){
          jQuery('#ajaxSubmit').click(function(e){
               e.preventDefault();
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
               });

        
        jQuery.ajax({
          url:"{{url('register')}}",
          method:"post",
          data:{
            name:jQuery('#name').val(),
            email:jQuery('#email').val(),
            password:jQuery('#password').val(),


          },
          success: function(result){
                      if (result.success == 0) {
                        jQuery('.error').show();
                     jQuery('.error').html(result.success);
                      }else{
                     jQuery('.alert').show();
                     jQuery('.alert').html(result.success);
                      }
                  }});
            // error: function(result){
            //          jQuery('.alert').show();
            //          jQuery('.alert').html(result.error);
            //       }
                  });
         
       
        });
    

      </script>
    </body>
   
    
</html>

