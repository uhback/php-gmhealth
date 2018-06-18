<html>
    <head>
        <meta charset="utf-8">
        <title>Products</title>
    </head>
    <body>
        <h2>Product List</h2>
        <form class="form-inline" method="post">
            <div class="row" style="padding: 10px">
                <div class="col-sm-6" style="text-align: left;">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" name="SearchString" />
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search">Search</button>
                </div>
                <div class="col-sm-6" style="text-align: right;">
                    <a href="index.php?content_page=AddProducts" class="btn btn-primary">Add New Product</a>
                </div>
            </div>
        </form>

        <div class="col-md-2">
            <h3>Category</h3>
            <?php
                require_once './config.php';
                // create connection
                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

                if ($mysqli->connect_errno) {
                    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
                }

                $sql="SELECT CategoryID as category_id,
                            CategoryName as category_name 
                        FROM Categories
                        ORDER BY 1";
                $rs = $mysqli -> query($sql);
                if (!$rs)
                {
                    exit("Error in SQL");
                }
            ?>
            <form method="post">
            <?php
                while ($row = $rs->fetch_assoc())
                {?>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success btn-sm" value="<?php echo $row["category_name"]; ?>" name="category_search" />    
                    </div>
                <?php
                }
                ?>                    
            </form>
        </div>
        <div class="col-md-10">
            <?php
                // Search / Category Product List
                require('ProductListAction.php');
                if (isset($_POST['search'])){
                    $rs = searchProduct($_POST['SearchString']);
                }
                elseif (isset($_POST['category_search'])){
                    $rs = categoryProduct($_POST['category_search']);
                }
                else {
                    $rs = getProductList();
                }                
            ?>
            <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock</th>
                        </tr>
                    </thead>
                    <?php
                        while ($row = $rs->fetch_assoc())
                        { ?>
                            <tbody>
                                <tr>
                                    <td>
                                        <a href="<?php echo "index.php?content_page=ProductsDetail&product_id={$row['product_id']}"; ?>">
                                            <img class="img-thumbnail" src="./<?php echo $row["img_url"]; ?>">
                                        </a>
                                    </td>
                                    <td>
                                        <?php echo $row["product_name"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row["category_name"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row["descrtiption"]; ?>
                                    </td>
                                    <td>
                                        $<?php echo $row["unit_price"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row["unit_stock"]; ?>
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