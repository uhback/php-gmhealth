<?php
    require_once 'config.php';
    // create connection
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    $orderId = $_POST['id'];

    if(isset($orderId)){
        $sql="UPDATE Orders Set State = 1 WHERE OrderId = $orderId";
        $rs = $mysqli -> query($sql);
        if (!$rs)
        {
            exit("Error in SQL");
        }
    }
?>
