<?php
    function addCart($productId, $quantatity)
    {
        session_start(); //starting session
        if (!$_SESSION['current_user']){
            header("Location: index.php?content_page=Login");
        } else {
            require_once './config.php';
            // create connection
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);
    
            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }

            $sql = "SELECT UserID AS user_id FROM Users WHERE Email = '".$_SESSION['current_user']."'";
            $rs = $mysqli -> query($sql);
            if (!$rs)
            {
                exit("Error in SQL");
            }
            $user = $rs -> fetch_assoc();
            
            // Check Cart has been existed or not
            $sql_checkCart = "SELECT CartID AS cart_id FROM Cart WHERE UserID = ".$user['user_id']." AND State = 1";
            $rs = $mysqli -> query($sql_checkCart);
            if ($rs->num_rows == 0)
            {
                $sql_addCart = "INSERT INTO Cart(UserID) VALUES(".$user['user_id'].")";
                $rs = $mysqli -> query($sql_addCart);
                if (!$rs)
                {
                    exit("Error in SQL");
                }
            }

            // Get Cart ID
            $sql_selCart = "SELECT CartID AS cart_id FROM Cart WHERE UserID = ".$user['user_id']." AND State = 1";
            $rs = $mysqli -> query($sql_selCart);
            if (!$rs)
            {
                exit("Error in SQL");
            }
            $cart = $rs -> fetch_assoc();

            //$sql_addCart = "INSERT INTO Cart(UserID) VALUES((SELECT UserID AS user_id FROM Users WHERE Email = '".$_SESSION['current_user']."'))";
            $sql_addCart = "INSERT INTO CartProducts(CartID, ProductID, CreatedDate, Quantity, State) VALUES(".$cart['cart_id'].", ". $productId.", NOW(), ". $quantatity.", 1)";
            $rs = $mysqli -> query($sql_addCart);
            if (!$rs)
            {
                exit("Error in SQL");
            }
            header("Location: index.php?content_page=MembersProducts");
            exit();
        }
    }
?>
<?php
    function clearCart($userID)
    {
        session_start();
        require_once './config.php';
        // create connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        // Get Cart ID
        $sql_selCart = "SELECT CartID AS cart_id FROM Cart WHERE UserID = ".$userID." AND State = 1";
        $rs = $mysqli -> query($sql_selCart);
        if (!$rs)
        {
            exit("Error in SQL");
        }
        $cart = $rs -> fetch_assoc();

        // Delete CartProducts (State = 0)
        $sql_clearCartProducts = "UPDATE CartProducts SET State = 0 WHERE CartID = ".$cart['cart_id'];
        $sql_clearCart = "UPDATE Cart SET State = 0 WHERE CartID = ".$cart['cart_id'];

        $mysqli -> query($sql_clearCartProducts);
        $mysqli -> query($sql_clearCart);

        header("Location:index.php?content_page=Cart");
    }
?>

