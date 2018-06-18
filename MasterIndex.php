<script src="Libraries/bootstrap.js" type="text/javascript"></script>
<script src="Libraries/jquery-1.10.2.js" type="text/javascript"></script>
<script src="Libraries/modernizr-2.6.2.js" type="text/javascript"></script>
<script src="Libraries/respond.js" type="text/javascript"></script>
<link href="Libraries/bootstrap.css" rel="stylesheet" type="text/css"></script>
<link href="Libraries/CustomStyle/site.css" rel="stylesheet" type="text/css" />

    <div class="container">    
    <!-- Navigation bar-->
        <div class="navbar navbar-default navbar-expand-lg bg-light navbar-fixed-top">
            <!--Collapse button-->
            <div class="navbar-header" style="margin-left: 40px">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- <a class="navbar-brand" runat="server" href="index.php?content_page=Introduction">GoodmorningHealth</a> -->
                <a class="navbar-brand" runat="server" href="index.php?content_page=Home"><img src="./Images/gmhealth_logo.jpg" /></a>
            </div>
            <!--links-->
            <div class="navbar-collapse collapse" style="margin-right: 60px">
                <ul class="nav navbar-nav">
                    <?php
                        session_start();                        
                        if (isset($_SESSION['current_user']))
                        {                           
                            $user_email = $_SESSION['current_user'];
                            // For Admin
                            if ($user_email == 'admin@gmhealth.com')
                            {
                                echo '<li><a runat="server" href="index.php?content_page=Products">Products</a></li>';  // Products list for admin
                                echo '<li><a runat="server" href="index.php?content_page=Category">Category</a></li>';  // for admin
                                echo '<li><a runat="server" href="index.php?content_page=Members">Members</a></li>';    // for admin
                                echo '<li><a runat="server" href="index.php?content_page=AdminOrders">Orders</a></li>';      // Order List for admin
                            }
                            // For Members
                            else
                            {
                                echo '<li><a runat="server" href="index.php?content_page=MembersProducts">Products</a></li>';   // Products list for members
                                echo '<li><a runat="server" href="index.php?content_page=Cart">Cart</a></li>';
                                echo '<li><a runat="server" href="index.php?content_page=MembersOrders">My Orders</a></li>';   // Individual Order List
                            }
                        }
                        else 
                        {
                            echo '<li><a runat="server" href="index.php?content_page=MembersProducts">Products</a></li>';
                            echo '<li><a runat="server" href="index.php?content_page=Cart">Cart</a></li>';                           
                        }
                    ?>
                    <li><a runat="server" href="index.php?content_page=ContactUs">ContactUs</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php
                       if (isset($_SESSION['current_user']))
                       {                           
                           $user_email = $_SESSION['current_user'];
                           echo '<li><a href="#">'. $user_email. '</a></li>';
                           echo '<li><a runat="server" href="index.php?content_page=Logout">Logout</a></li>';
                       } else {
                           echo '<li><a runat="server" href="index.php?content_page=Register">Register</a></li>';
                           echo '<li><a runat="server" href="index.php?content_page=Login">Login</a></li>';                                                       
                       }
                    ?>
                </ul>
            </div>
        </div>

        <!-- Body Contents -->
        <div>
            <?php include($page_content);?>
        </div>
    </div>
