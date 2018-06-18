<?php
    require_once 'config.php';
    // create connection
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    $sent_value = $_POST['value'];
    $sent_userid = $_POST['id'];
    if(isset($sent_value)){
        // Checked (Enabled)
        if ($sent_value == 1) {
            $sql="UPDATE Users Set Enabled = $sent_value WHERE UserID = $sent_userid";
            $rs = $mysqli -> query($sql);
            if (!$rs)
            {
                exit("Error in SQL");
            }
        }
        // Un-Checked (Disabled)
        else {
            $sql="UPDATE Users Set Enabled = $sent_value WHERE UserID = $sent_userid";
            $rs = $mysqli -> query($sql);
            if (!$rs)
            {
                exit("Error in SQL");
            }
        }
    }
    else{
        echo "Error" ;
    }
?>