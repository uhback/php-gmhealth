<?php
    function searchProduct($searchString){
        require_once './config.php';
        // create connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        $sql="SELECT P.ProductID AS product_id,
                    P.ProductName As product_name,
                    C.CategoryName As category_name,
                    P.UnitPrice As unit_price,
                    P.UnitsInStock As unit_stock,
                    P.Description As descrtiption,
                    P.ImageUrl As img_url
                FROM Products P INNER JOIN Categories C ON P.CategoryID = C.CategoryID
                WHERE P.ProductName like '%". $searchString. "%'";
        
        $rs = $mysqli -> query($sql);
        if (!$rs)
        {
            exit("Error in SQL");
        }
        return $rs;
    }
?>
<?php
    function getProductList(){
        require_once './config.php';
        // create connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        $sql="SELECT P.ProductID AS product_id,
                    P.ProductName As product_name,
                    C.CategoryName As category_name,
                    P.UnitPrice As unit_price,
                    P.UnitsInStock As unit_stock,
                    P.Description As descrtiption,
                    P.ImageUrl As img_url
                FROM Products P INNER JOIN Categories C ON P.CategoryID = C.CategoryID";
        
        $rs = $mysqli -> query($sql);
        if (!$rs)
        {
            exit("Error in SQL");
        }
        return $rs;
    }
?>
<?php
    function categoryProduct($categoryName){
        require_once './config.php';
        // create connection
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }

        $sql="SELECT P.ProductID AS product_id,
                    P.ProductName As product_name,
                    C.CategoryName As category_name,
                    P.UnitPrice As unit_price,
                    P.UnitsInStock As unit_stock,
                    P.Description As descrtiption,
                    P.ImageUrl As img_url
                FROM Products P INNER JOIN Categories C ON P.CategoryID = C.CategoryID
                WHERE C.CategoryName = '". $categoryName."'";
        $rs = $mysqli -> query($sql);
        if (!$rs)
        {
            exit("Error in SQL");
        }
        return $rs;
    }
?>
