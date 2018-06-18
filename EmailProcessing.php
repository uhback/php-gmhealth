<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- PHP Tutorial WebEstilo.com --> 
<html> 
<head> 
   <title>PHP Processing Email Example</title> 
</head> 
<body> 
<H1>Processing email</H1> 
<?php 
   date_default_timezone_set("Pacific/Auckland");
   $address=$_GET['address']; 
   $type=$_GET['type']; 
    
   if ($address!=""){ 
   if ($type=="plain"){ 
      // Send in plain format 
      mail($address,"Enjoy your email","Enjoy your email in plain text","FROM: $address"); 
   } else { 
      // Send in HTML format 
      mail($address,"Enjoy your email","<html><head><title>PHP Email</title></head><body>Enjoy your email in HTML</body></html>", "FROM: $address",  "Content-type: text/html\n"); 
   }       
echo "You have sent an email to: ",$address," in format <b>",$type,"</b>."; 
} 
?> 
<br> 
</body> 
</html>

