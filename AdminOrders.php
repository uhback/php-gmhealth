<!doctype html>
<html>
  <head>
      <meta charset="utf-8">
      <title>My Orders</title>
      <script>
        $(document).ready(function(){
            $("input[name=status_update]").click(function () {
                var orderId = $(this).attr('id');
                $.ajax({
                    type: 'POST',
                    url: 'OrderStatusUpdate.php',
                    data: {
                        id: orderId,
                    }
                });
                $(this).attr("value" , "Delivered");
                $(this).attr("disabled", true);
            });
        });
      </script>
  </head>
  <body>
    <h2>Members' Order List</h2>
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

        $sql="SELECT OD.OrderID as order_id,
                     U.UserName as user_name,
                     U.Email as user_email, 
                     OD.OrderDate as order_date,
                     OD.TotalPrice as total_price,
                     OD.TotalQuantity as total_quantity,
                     OD.State as order_state
              FROM Orders OD INNER JOIN Users U ON OD.UserID = U.UserID";
        $rs = $mysqli -> query($sql);
        if (!$rs)
        {
            exit("Error in SQL");
        }
        ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">User Name</th>
                    <th scope="col">User Email</th>
                    <th scope="col">Order Date</th>
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
                              <?php echo $row["order_id"]; ?>
                            </td>
                            <td>
                              <?php echo $row["user_name"]; ?>
                            </td>
                            <td>
                              <?php echo $row["user_email"]; ?>
                            </td>
                            <td>
                                <?php echo $row["order_date"]; ?>
                            </td>
                            <td>
                                <?php echo $row["total_quantity"]; ?>
                            </td>
                            <td>
                                $<?php echo $row["total_price"]; ?>
                            </td>
                            <td>
                                <input type="button" 
                                    id="<?=$row['order_id']?>" 
                                    name="status_update" 
                                    value="<?php echo $row['order_state'] == 1 ? 'Delivered' : 'Waiting'; ?>" 
                                    class="btn btn-default btn-sm"
                                    <?php echo $row['order_state'] == 1 ? 'disabled' : 'enabled'; ?>>
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