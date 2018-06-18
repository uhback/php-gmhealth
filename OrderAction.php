<?php
    function addOrder($userID,$totalPrice,$totalQuantity,$shipName,$shipAddress,$shipCity,$shipRegion,$sihpCountry,$shipPostal)
    {
        require_once './config.php';
        // create connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        // Insert Order
        $sql = "INSERT INTO Orders(UserID, OrderDate, TotalPrice, TotalQuantity, ShipName, ShipAddress, ShipCity, ShipRegion, ShipCountry, ShipPostalCode) 
                    Values(". $userID. ", NOW(), ".$totalPrice.", ".$totalQuantity.", '".$shipName."', '".$shipAddress."', '".$shipCity."', '".$shipRegion."', '".$sihpCountry."', '".$shipPostal."')";
        $rs = $mysqli -> query($sql);
        if (!$rs)
        {
            exit("Error in SQL");
        }
    }
?>
<?php
    function addOrderDetails($userID)
    {
        require_once './config.php';
        // create connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        $sql_maxOrder = "SELECT MAX(OrderID) AS order_id FROM Orders WHERE UserID = ".$userID;
        $rs = $mysqli -> query($sql_maxOrder);
        if (!$rs)
        {
            exit("Error in SQL");
        }
        $order = $rs->fetch_assoc();

        $sql_getCartProducts = "SELECT CT.CartID AS cart_id,
                                        P.ProductID AS product_id,
                                        P.UnitPrice AS product_price,
                                        CP.Quantity AS cart_quantity,
                                        P.UnitsInStock AS current_stock
                                FROM CartProducts CP 
                                    INNER JOIN Products P 
                                        ON CP.ProductID = P.ProductID
                                    INNER JOIN Cart CT
                                        ON CP.CartID = CT.CartID
                                WHERE CT.State = 1
                                    AND CP.state = 1
                                    AND CT.UserID = ".$userID;

        $rs = $mysqli -> query($sql_getCartProducts);
        if (!$rs)
        {
            exit("Error in SQL");
        }

        // Add Order Details
        while ($row = $rs->fetch_assoc())
        {
            $sql_addOrderDetails = "INSERT INTO OrderDetails(OrderID, ProductID, UnitPrice, Quantity)
                                    VALUES(".$order['order_id'].", ".$row['product_id'].", ".$row['product_price'].", ".$row['cart_quantity'].")";
            $rs_addOrderDetails = $mysqli -> query($sql_addOrderDetails);
            if (!$rs_addOrderDetails)
            {
                exit("Error in SQL");
            }
            else{
                // Update Products' Stock
                $mysqli -> query("UPDATE Products SET UnitsInStock = UnitsInStock - ".$row['cart_quantity']." WHERE ProductID = ".$row['product_id']);
                // // Delete CartID (State = 0)
                // $mysqli -> query("UPDATE Cart SET State = 0 WHERE CartID = ".$row['cart_id']);
            }
        }

        //  // Update Products' Stock
        //  while ($row = $rs->fetch_assoc())
        //  {
        //      // echo "UPDATE Products SET UnitsInStock = UnitsInStock - ".$row['cart_quantity']." WHERE ProductID = ".$row['product_id'];
        //      $mysqli -> query("UPDATE Products SET UnitsInStock = UnitsInStock - ".$row['cart_quantity']." WHERE ProductID = ".$row['product_id']);            
        //  } 
        
    }
?>

    