<?php
    ob_start();
    session_start();
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Cart</title>
        <script>
            $(document).ready(function(){
                $('#show_order_form').click(function(){
                    $('#order_form').toggle('show');
                });
            });
        </script>
    </head>
    <body>
    <div style="margin-top: 20px">
      <?php
        require_once 'config.php';
        $totalPrice = 0;
        $totalQuantity = 0;

        // create connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        if (!$_SESSION['current_user']) {
            header("Location: index.php?content_page=Login");
        } else {
            $sql = "SELECT UserID AS user_id FROM Users WHERE Email = '".$_SESSION['current_user']."'";
            $rs = $mysqli -> query($sql);
            if (!$rs)
            {
                exit("Error in SQL");
            }
            $user = $rs -> fetch_assoc();

            $sql="SELECT P.ProductID as product_id,
                    P.ProductName as product_name,
                    P.UnitPrice as product_price,
                    CP.Quantity as product_quantity,
                    CP.CreatedDate as cart_add_date
                    FROM CartProducts CP 
                        INNER JOIN Cart CT 
                            ON CP.CartID = CT.CartID
                        INNER JOIN Products P 
                            ON CP.ProductID = P.ProductID                    
                    WHERE CP.State = 1 
                    AND CT.State = 1 
                    AND CT.UserID = ". $user['user_id']."";
            $rs = $mysqli -> query($sql);
            if (!$rs)
            {
                exit("Error in SQL");
            }
        }
        
        ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Add Date</th>
                </tr>
            </thead>
            <?php
                while ($row = $rs->fetch_assoc())
                { ?>
                    <tbody>
                        <tr>
                          <td>
                              <?php echo $row["product_name"]; ?>
                          </td>
                          <td>
                              $<?php echo $row["product_price"]; ?>
                          </td>
                          <td>
                              <?php echo $row["product_quantity"]; ?>
                          </td>
                          <td>
                              <?php echo $row["cart_add_date"]; ?>
                          </td>
                        </tr>
                    </tbody>
                <?php
                    $totalPrice = $totalPrice + ($row['product_price'] * $row['product_quantity']);
                    $totalQuantity = $totalQuantity + $row['product_quantity'];
                }
                ?>
                <tr>
                    <td><label>Total(include GST):</label></td>
                    <td style="color: red; font-weight: bold;">$<?php echo $totalPrice ?></td>
                    <td style="color: red; font-weight: bold;"><?php echo $totalQuantity ?></td>
                </tr>
        </table>
    </div>
        <form method="post">
            <button type="submit" class="btn btn-default" name="clear_cart">Clear All</button>
        </form>
        <?php
            if (isset($_POST['clear_cart']))
            {
                require("CartAction.php"); // cartAction - add_CArt / clear cart /
                clearCart($user['user_id']);
            }
        ?>
        <!-- ORDER -->
        <div style="margin-top: 20px">
            <input type="button" id="show_order_form" value="Show Order Form" class="btn btn-default">
        </div>
        <div id="order_form" class="col-md-6">
            <form method="post">
                <div class="form-group">
                    <label for="quantity">Reciever</label>
                    <input type="text" name="ship_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="quantity">Address</label>
                    <input type="text" name="ship_address" class="form-control">
                </div>
                <div class="form-group">
                    <label for="quantity">City</label>
                    <input type="text" name="ship_city" class="form-control">
                </div>
                <div class="form-group">
                    <label for="quantity">Region</label>
                    <input type="text" name="ship_region" class="form-control">
                </div>
                <div class="form-group">
                    <label for="quantity">Country</label>
                    <input type="text" name="ship_country" class="form-control">
                </div>
                <div class="form-group">
                    <label for="quantity">Postal Code</label>
                    <input type="text" name="ship_postal" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary" name="order_checkout">Check Out</button>
            </form>
        </div>
        <?php
            if (isset($_POST['order_checkout']) && $totalPrice != 0)
            {
                // Add Order and Reduce Stock of products
                require("OrderAction.php");
                addOrder($user['user_id'],$totalPrice,$totalQuantity,$_POST['ship_name'],$_POST['ship_address'],$_POST['ship_city'],$_POST['ship_region'],$_POST['ship_country'],$_POST['ship_postal']);
                addOrderDetails($user['user_id']);

                // Make cart empty
                require("CartAction.php");
                clearCart($user['user_id']);

                header("Location: index.php?content_page=MembersOrders");
            } elseif (isset($_POST['order_checkout']) && $totalPrice == 0) {
                $message = "Need to add products";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
        ?>
    </body>
</html>