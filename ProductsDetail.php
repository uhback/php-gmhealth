<?php
    require_once './config.php';
    // create connection
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    $sql = "SELECT P.ProductID AS product_id,
                P.ProductName As product_name,
                C.CategoryName As category_name,
                P.UnitPrice As unit_price,
                P.UnitsInStock As unit_stock,
                P.Description As descrtiption,
                P.ImageUrl As img_url
            FROM Products P INNER JOIN Categories C ON P.CategoryID = C.CategoryID WHERE P.ProductID = ".$_GET['product_id']."";
    $rs = $mysqli -> query($sql);
    $row = $rs -> fetch_assoc();
    if (!$rs)
    {
        exit("Error in SQL");
    }
?>
<?php
    if (isset($_POST['add_cart']))
    {
        if ($_POST['quantity'] > $row['unit_stock']) {
            $message = "The quantity is over the current stock!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {
            require("CartAction.php"); // cartAction - add_CArt / clear cart /
            addCart($row['product_id'], $_POST['quantity']);
        }
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Product Detail</title>
    </head>
    <body>
        <div class="Container" style="margin: 30px">
            <div class="row">
                <div class="col-md-4">
                    <img src="./<?php echo $row['img_url']?>" class="thumbnail img-responsive center-block">                
                </div>
                <div class="col-md-8">
                    <h3><?php echo $row['product_name']?></h3>
                    <p><?php echo $row['descrtiption']?></p>
                    <form method="post">
                        <div class="form-group">
                            <h4>Current Stock: <?php echo $row['unit_stock']?></h4>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantatiy</label>
                            <input type="text" name="quantity" class="form-control">                                                 
                        </div>
                        <button type="submit" class="btn btn-default" name="add_cart">Add Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>