<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Email Confirm</title>
    </head>
    <body>
        <?php
            $username = $_GET['username'];
            $code = $_GET['code'];

            // create connection
            require_once './config.php';
            // create connection
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }

            $sql_user = "SELECT UserID as user_id, 
                                ConfirmCode as confirm_code 
                            FROM Users
                            WHERE ConfirmCode = ". $code;

            $rs = $mysqli->query($sql_user);
            $user = $rs -> fetch_assoc();
            
            if($code == $user['confirm_code'])
            {
                // create SQL statement 
                $sql = "UPDATE Users SET EmailConfirmed = 1 WHERE UserID = ". $user['user_id']; 
                // execute SQL statement and get results 
                if (!$mysqli->query($sql)) {
                    echo "SQL operation failed: (" . $mysqli->errno . ") " . $mysqli->error;
                }
                $link_address = "http://dochyper.unitec.ac.nz/backu01/gmhealth/index.php?content_page=Login";
                echo "Thank you. Your email has been confirmed and you may now login.</br>";
                echo "<a href='".$link_address."'>Move to Login</a>";
                
                mysqli_close($mysqli);
                exit;
            }
            else
            {
                echo "Username and code dont match";
            }
            
        ?>
    </body>
</html>
