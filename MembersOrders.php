<!doctype html>
<html>
  <head>
      <meta charset="utf-8">
      <title>My Orders</title>
  </head>
  <body>
    <h2>My Orders</h2>
    <div style="margin-top: 20px">
      <?php
        require_once 'config.php';
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

        $sql=" SELECT OD.OrderDate as order_date, 
                        MAX(P.ProductName) as product_name, 
                        OD.TotalPrice as total_price, 
                        OD.TotalQuantity as total_quantity,
                        OD.State as order_state
                from orders OD
                inner join OrderDetails ODS on OD.OrderID = ODS.OrderID
                inner join Products P on ODS.ProductID = P.ProductID
                where OD.userID = ". $user['user_id']."
                GROUP BY OD.OrderID, OD.TotalPrice, OD.TotalQuantity";

        $rs = $mysqli -> query($sql);
        if (!$rs)
        {
            exit("Error in SQL");
        }
        ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Order Date</th>
                    <th scope="col">Products</th>
                    <th scope="col">Total Quantity</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <?php
                while ($row = $rs->fetch_assoc())
                { ?>
                    <tbody>
                        <tr>
                          <td>
                              <?php echo $row["order_date"]; ?>
                          </td>
                          <td>
                              <?php echo $row["product_name"]; ?>...
                          </td>
                          <td>
                              <?php echo $row["total_quantity"]; ?>
                          </td>
                          <td>
                              $<?php echo $row["total_price"]; ?>
                          </td>
                          <td>
                              <?php 
                                if ($row["order_state"] == 0)
                                    echo "Waiting";
                                if ($row["order_state"] == 1)
                                    echo "Delievered";
                                ?>
                          </td>
                        </tr>
                    </tbody>
                <?php
                }
                ?>
        </table>
      </div>
  </body>
</html>