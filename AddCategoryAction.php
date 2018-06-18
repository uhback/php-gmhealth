<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Manage AddCategory Action</title>
    </head>
    <body>
        <?php
            // create connection
            require_once './config.php';
            // create connection
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }

            // create SQL statement 
            $sql = "INSERT INTO Categories(CategoryName,Description)
                    VALUES('" . $_POST['category_name'] . "','" 
                            . $_POST['category_description'] . "')"; 
            // execute SQL statement and get results 
            if (!$mysqli->query($sql)) {
                echo "SQL operation failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            
            mysqli_close($mysqli);
            header("Location: index.php?content_page=Category");
            exit;
        ?>
    </body>
</html>
