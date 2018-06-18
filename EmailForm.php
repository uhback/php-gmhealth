<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- PHP Sending Email Form Example --> 
<html> 
<head> 
   <title>PHP Sending Email Form Example</title> 
</head> 
<body> 
<H1>Sending emails</H1> 
Insert your email: 
<FORM ACTION="EmailProcessing.php" METHOD="GET"> 
<INPUT TYPE="text" NAME="address"><BR><BR> 
Format: <BR> 
<INPUT TYPE="radio" NAME="type" VALUE="plain" CHECKED> Text plain<BR> 
<INPUT TYPE="radio" NAME="type" VALUE="html"> HTML<BR><BR> 
<INPUT TYPE="submit" VALUE="Send"> 
</FORM> 
</body> 
</html> 

