<?php
   function checkUserCredentals($inputEmail, $inputPassword)
   {
    require_once './config.php';
    // create connection
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    $sql="SELECT UserName as user_name 
            FROM Users WHERE Enabled = 1 AND EmailConfirmed = 1 AND Email = '".$inputEmail."' AND Password = '".$inputPassword."'";

	//Execute query
	$rs=$mysqli->query($sql);
	if (!$rs)
	  {exit("Error in SQL");}

	//Count the record number
	$counter = $rs->num_rows;
      
	  if ($counter>0)
	  {
		  //authentication succeeded
		  return (true);
	  }
	  else
	  {
		  //authentication failed
		  return (false);	
	  }
   }
   
?>