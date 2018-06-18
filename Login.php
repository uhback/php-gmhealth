<!doctype html>
<html>
  <head>
      <meta charset="utf-8">
      <title>Login</title>
      <script src="Libraries/bootstrap.js" type="text/javascript"></script>
      <script src="Libraries/jquery-1.10.2.js" type="text/javascript"></script>
      <script src="Libraries/modernizr-2.6.2.js" type="text/javascript"></script>
      <script src="Libraries/respond.js" type="text/javascript"></script>
      <link href="Libraries/bootstrap.css" rel="stylesheet" type="text/css"></script>
      <link href="Libraries/CustomStyle/site.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <h1>Login</h1>
    <?php
      session_start(); //starting session
      
      // include username and password array and the function
      require("UserDetails.php");
        
      // if the user has input username and password
      if (isset($_POST['form_email']) and isset($_POST['form_password']))
        {			
        //The login is not successful, set the login flag to false
              $_SESSION['flag'] = false;
          
          // call the pre-defined function and check if user is authenticated
          if (checkUserCredentals($_POST['form_email'], $_POST['form_password']))
          {
            //The login is successful, set the login flag to true and save the current user name
            $_SESSION['flag'] = true;
            $_SESSION['current_user'] = $_POST['form_email'];
                
            //redirect the user to the correct page	
            //find out where to go after login
            if (isset($_SESSION['request_page']))
            $redirect_page = "index.php?content_page=".$_SESSION['request_page'];
            else
            $redirect_page = "index.php";
              
            //redirect the user to the correct page after login
            header("Location: ".$redirect_page);
          } else {
            echo '<div style="margin-bottom: 10px; color: red">Input the correct Email address or Ask to the Admin</div>';
          }
      } //Otherwise, stay in the login page
      
    ?>
    <!-- User credential form -->
    <div class="col-md-6">
      <form method="post">
        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input type="email" name="form_email" class="form-control" aria-describedby="emailHelp" placeholder="name@example.com">
          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" name="form_password" class="form-control" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary">Sign in</button>
      </form>
    </div>
  </body>
</html>