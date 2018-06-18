<?php
    ob_start();
    session_start();
?>

<?php
    if (isset($_POST['register_btn']))
    {          
        $err = [];
        require_once './config.php';
        // create connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        $rs = $mysqli->query("SELECT * FROM Users WHERE Email = '".$_POST["register_email"]."'");
        $user = $rs -> fetch_assoc();

        // Form Validation
        if (empty($_POST["register_username"]) || !preg_match("/^[a-zA-Z ]*$/",$_POST["register_username"])) {
            $err['name'] = "Enter the valid User Name";
        }
        elseif (empty($_POST["register_email"]) || !preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$_POST["register_email"])) {
            $err['email'] = "Only allows characters and whitespaces";
        }
        elseif (strlen($_POST["register_password"]) < 6) {
            $err['pwd'] = "Password must be more than 6 characters";
        }
        elseif (strlen($user['UserID']) != 0) {
            $err['email'] = "The email has been already existed";
        }
        // Passed validation
        elseif (empty($err)) {
            require("RegisterAction.php");
            addUser();
            header("Location: index.php?content_page=RegisterComplete");
        }
    }
?>

<!doctype html>
<html>
  <head>
        <meta charset="utf-8">
        <title>Register</title>
  </head>
  <body>
    <h2>Register Form</h2>
    <div class="col-lg-6">
        <form method="post">
            <div class="form-group">
                <label>* Email</label>
                <input type="email" name="register_email" class="form-control" placeholder="Email" required />
                <span class="error"><?php if(!empty($err['email'])) echo "* ".$err['email'];?></span>
            </div>
            <div class="form-group">
                <label>* Password</label>
                <input type="password" name="register_password" class="form-control" placeholder="Password" required/>
                <span class="error"><?php if(!empty($err['pwd'])) echo "* ".$err['pwd'];?></span>                
                <small id="emailHelp" class="form-text text-muted">Password must be more than 6 characters.</small>
            </div>
            <div class="form-group">
                <label>* User Name</label>
                <input type="text" name="register_username" class="form-control" placeholder="User Name" required/>
                <span class="error"><?php if(!empty($err['name'])) echo "* ".$err['name'];?></span>
            </div>
            <div class="form-group">
                <label>Phone</label>                
                <input type="text" name="register_phone" class="form-control"/>
                <small id="emailHelp" class="form-text text-muted">Enter the only number (ex) 0211432310</small>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="register_address" class="form-control"/>
            </div>
            <div class="form-group">
                <label>City</label>
                <input type="text" name="register_city" class="form-control"/>
            </div>
            <div class="form-group">
                <label>Region</label>
                <input type="text" name="register_region" class="form-control"/>
            </div>
            <div class="form-group">
                <label>Country</label>
                <input type="text" name="register_country" class="form-control"/>
            </div>
            <div class="form-group">
                <label>Postal Code</label>
                <input type="text" name="register_postal" class="form-control"/>
            </div>
            <button type="submit" class="btn btn-primary" name="register_btn">Register</button>
        </form>
    </div>

  </body>
</html>