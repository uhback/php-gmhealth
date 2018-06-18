<!doctype html>
<html>
  <head>
      <meta charset="utf-8">
      <title>Category</title>
      <script src="Libraries/bootstrap/css/bootstrap.js" type="text/javascript"></script>
      <script src="Libraries/jquery-1.10.2.js" type="text/javascript"></script>
      <script src="Libraries/modernizr-2.6.2.js" type="text/javascript"></script>
      <script src="Libraries/respond.js" type="text/javascript"></script>
      <link href="Libraries/bootstrap.css" rel="stylesheet" type="text/css"></script>

      <script>
        $(document).ready(function(){
            $("input[type=checkbox]").click(function () {
                $.ajax({
                    type: "POST",
                    url: "MembersUpdate.php",
                    data: {
                        value: $(this).prop("checked") ? 1 : 0,
                        id: $(this).attr('id')
                    }
                });
            });
        });
      </script>
  </head>
  <body>
    <h2>Member List</h2>
    <div style="margin-top: 20px">
      <?php
        require_once 'config.php';
        // create connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        $sql="SELECT  UserID as user_id,
                      UserName as user_name,
                      Email as user_email,
                      City as user_city,
                      Phone as user_phone,
                      Enabled as user_enabled,
                      EmailConfirmed as email_confirmed
              FROM Users WHERE UserName != 'admin'";
        $rs = $mysqli -> query($sql);
        if (!$rs)
        {
            exit("Error in SQL");
        }
        ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">UserID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">City</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email Confirmed</th>
                    <th scope="col">Enabled</th>
                </tr>
            </thead>
            <?php
                while ($row = $rs->fetch_assoc())
                { ?>
                    <tbody>
                        <tr>
                          <td>
                              <?php echo $row["user_id"]; ?>
                          </td>
                          <td>
                              <?php echo $row["user_name"]; ?>
                          </td>
                          <td>
                              <?php echo $row["user_email"]; ?>
                          </td>
                          <td>
                              <?php echo $row["user_city"]; ?>
                          </td>
                          <td>
                              <?php echo $row["user_phone"]; ?>
                          </td>
                          <td>
                              <?php if($row["email_confirmed"] == 0) echo "Waiting";
                                    if($row["email_confirmed"] == 1) echo "Confirmed";
                              ?>
                          </td>
                          <td>
                            <input type="checkbox" id="<?=$row['user_id']?>" name="Enabled" value="Enabled"
                            <?php if ($row['user_enabled'] == 1) { echo "checked='checked'"; } ?>>
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