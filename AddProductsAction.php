<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Manage AddProduct Action</title>
    </head>

    <body>
        <?php
            if (isset($_FILES["product_imageurl"]) && ($_FILES["product_imageurl"]["error"] > 0))
            {
                echo "Error: " . $_FILES["product_imageurl"]["error"] . "<br />";
            }
            elseif (isset($_FILES["product_imageurl"]))
            {
                move_uploaded_file($_FILES["product_imageurl"]["tmp_name"], "./Images/Products/" . $_FILES["product_imageurl"]["name"]); //Save the file as the supplied name
                $fileName = $_FILES["product_imageurl"]["name"];
                $imageUrl = "/Images/Products/".$fileName;
            }
        ?>
        <?php
            // create connection
            require_once './config.php';
            // create connection
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }

            // create SQL statement 
            $sql = "INSERT INTO Products(ProductName,CategoryID,UnitPrice,UnitsInStock,Description,ImageUrl)
                    VALUES('" . $_POST['product_name'] . "','" 
                            . $_POST['category_id'] . "','" 
                            . $_POST['product_unitprice'] . "','" 
                            . $_POST['product_stockq'] . "','" 
                            . $_POST['product_description'] . "','" 
                            . $imageUrl . "')"; 
            echo $sql;
            // execute SQL statement and get results 
            if (!$mysqli->query($sql)) {
                echo "SQL operation failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            mysqli_close($mysqli);
            header("Location: index.php?content_page=Products");
            exit;
        ?>
    </body>
</html>
