<!doctype html>
<html>
  <head>
      <meta charset="utf-8">
      <title>Category</title>
  </head>
  <body>
    <h2>Category List</h2>
    <div style="margin-top: 20px">
      <?php
        require_once 'config.php';
        // create connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        $sql="SELECT  CategoryID as category_id,
                      CategoryName as category_name,
                      Description as category_description
              FROM Categories";
        $rs = $mysqli -> query($sql);
        if (!$rs)
        {
            exit("Error in SQL");
        }
        ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">CategoryID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                </tr>
            </thead>
            <?php
                while ($row = $rs->fetch_assoc())
                { ?>
                    <tbody>
                        <tr>
                          <td>
                              <?php echo $row["category_id"]; ?>
                          </td>
                          <td>
                              <?php echo $row["category_name"]; ?>
                          </td>
                          <td>
                              <?php echo $row["category_description"]; ?>
                          </td>
                        </tr>
                    </tbody>
                <?php
                }
                ?>
        </table>
      </div>
      <div>
        <a href="index.php?content_page=AddCategory" class="btn btn-primary">Add New Category</a>
      </div>
  </body>
</html>