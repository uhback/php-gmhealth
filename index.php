<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>goodmorningHealth</title>
        <script src="Libraries/bootstrap.js" type="text/javascript"></script>
        <script src="Libraries/jquery-1.10.2.js" type="text/javascript"></script>
        <script src="Libraries/modernizr-2.6.2.js" type="text/javascript"></script>
        <script src="Libraries/respond.js" type="text/javascript"></script>
        <link href="Libraries/bootstrap.css" rel="stylesheet" type="text/css"></script>
        <link href="Libraries/CustomStyle/site.css" rel="stylesheet" type="text/css" />
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    </head>
    <body>
    <?php
        //Retrieve the requested content page name and construct the file name
        if (isset($_GET['content_page']))
        {
            $page_name = $_GET['content_page'];
            $page_content = $page_name.'.php';
        }
        elseif (isset($_POST['content_page']))
        {
            $page_name = $_POST['content_page'];
            $page_content = $page_name.'.php';
        }
        else
        {
            $page_content = 'Home.php';
        }
        //This must be below the setting of $page_content 
        include('MasterIndex.php');
    ?>
</html>
