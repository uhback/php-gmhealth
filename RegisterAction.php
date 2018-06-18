<?php
    function addUser() {
        $admin = "admin@gmhealth.com";
        // create connection
        require_once './config.php';
        // create connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        // Define roles depends on the type of user (Members / Admin)
        if ($_POST['register_email'] != $admin){
            
            // variables for sending email
            $confirmCode = rand();

            // create SQL statement 
            $sql = "INSERT INTO Users(UserName,Email,Password,Address,City,Region,PostalCode,Country,Phone,ConfirmCode)
            VALUES('" . $_POST['register_username'] . "','" 
                    . $_POST['register_email'] . "','" 
                    . $_POST['register_password'] . "','" 
                    . $_POST['register_address'] . "','" 
                    . $_POST['register_city'] . "','" 
                    . $_POST['register_region'] . "','"
                    . $_POST['register_postal'] . "','"
                    . $_POST['register_country'] . "','"
                    . $_POST['register_phone'] . "',".$confirmCode.")";
            // execute SQL statement and get results 
            if (!$mysqli->query($sql)) {
                echo "SQL operation failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }

            $rs = $mysqli->query("SELECT UserID as user_id FROM Users WHERE Email = '".$_POST['register_email']."'");
            $user = $rs -> fetch_assoc();

            $sql = "INSERT INTO UserRoles(UserID, RoleID) VALUES(". $user['user_id'].", 2)";
            if (!$mysqli->query($sql)) {
                echo "SQL operation failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }

            sendConfirmEmail($_POST['register_username'], $_POST['register_email'], $confirmCode);            

            mysqli_close($mysqli);
        } else {
            // create SQL statement 
            $sql = "INSERT INTO Users(UserName,Email,Password,Address,City,Region,PostalCode,Country,Phone)
            VALUES('" . $_POST['register_username'] . "','" 
                    . $_POST['register_email'] . "','" 
                    . $_POST['register_password'] . "','" 
                    . $_POST['register_address'] . "','" 
                    . $_POST['register_city'] . "','" 
                    . $_POST['register_region'] . "','"
                    . $_POST['register_postal'] . "','"
                    . $_POST['register_country'] . "','"
                    . $_POST['register_phone'] . "')";
            // execute SQL statement and get results 
            if (!$mysqli->query($sql)) {
                echo "SQL operation failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
    
            $rs = $mysqli->query("SELECT UserID as user_id FROM Users WHERE Email = '".$_POST['register_email']."'");
            $user = $rs -> fetch_assoc();
    
            $sql = "INSERT INTO UserRoles(UserID, RoleID) VALUES(". $user['user_id'].", 1)";
            if (!$mysqli->query($sql)) {
                echo "SQL operation failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            mysqli_close($mysqli);
        }
    }
?>
<?php
    function sendConfirmEmail($userName, $userEmail, $confirmCode)
    {
        if($userName && $userEmail)
        {
            // Send Email to confirm account
            $message =
            "
            Confirm Your Email
            Click the link below to verify your account
            http://dochyper.unitec.ac.nz/backu01/gmhealth/emailconfirm.php?username=$userName&code=$confirmCode
            ";

            mail($userEmail, "GMHealth Confirm EMail", $message, "From: DoNotReply@gmhealth.com");

            echo "Registration Complete! Please confirm your email.";
        }
    }