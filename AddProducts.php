<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Add Product</title>
    </head>
    <body>
       <h1>Add Product</h1>
       <div class="col-lg-6">
        <form method="post" enctype="multipart/form-data" action="index.php?content_page=AddProductsAction">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="product_name" class="form-control" placeholder="Product Name">
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category_id" class="form-control">                    
                        <?php
                            // create connection
                            require_once './config.php';
                            // create connection
                            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

                            if ($mysqli->connect_errno) {
                                echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
                            }
                            $sql = "SELECT * FROM Categories";
                            $rs = $mysqli -> query($sql);
                            if (!$rs)
                            {
                                exit("Error in SQL");
                            }
                            while($cat = $rs->fetch_assoc())
                            {?>
                            <option value="<?php echo $cat['CategoryID']; ?>"><?php echo $cat['CategoryName']; ?></option>
                            <?php 
                            }?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Unit Price</label>
                    <input type="text" name="product_unitprice" class="form-control" placeholder="Unit Price">
                </div>
                <div class="form-group">
                    <label>Stock Quantity</label>
                    <input type="text" name="product_stockq" class="form-control" placeholder="Stock Quantity">
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="File" name="product_imageurl" class="form-control" value="" size="30">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="product_description" class="form-control" rows="5" placeholder="Write Description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </body>
</html>