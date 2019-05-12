<!-- 

        Name:    login.php

        Auth:    Ibrahim Sardar

        Desc:    Login page of iBoard.com

-->

<!-- include session/globals getter file,
     include custom php utils,
     let the server know what page we're on -->
<?php
    include "get_sessions.php";
    include "php/BE_functions.php";
    $g_page = 'login';
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>iBoard - Accounts</title>
        <link rel="stylesheet" href="css/ibr_custom2.css" type="text/css">
        <script src="js/FE_functions.js" type="text/javascript"></script>
        
        
        <script>
        
            function activateAcc() {
                
                //show loading animation
                document.getElementById("act_msg").innerHTML="";
                document.getElementById("loader").style.display = "inline-block";
                
                var usr = document.getElementById("uname").value; // typed username
                
                //-------------------------------
                // AJAX CHUNK
                var xmlhttp;

                // code for IE7+, Firefox, Chrome, Opera, Safari
                if (window.XMLHttpRequest) {
                    xmlhttp=new XMLHttpRequest();

                // code for IE6, IE5
                } else {
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }

                xmlhttp.onreadystatechange=function() {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                        document.getElementById("act_msg").innerHTML=xmlhttp.responseText;
                        
                        //hide loading animation
                        document.getElementById("loader").style.display = "none";
                    }
                }

                xmlhttp.open("GET","send_act2.php?q1="+usr,true);

                xmlhttp.send();
                // END OF AJAX CHUNK
                //-------------------------------
                
            }
        
        </script>
        
        
    </head>
    <body>















        
        <!-- include side menu data -->
        <?php
            include "header.php";
        ?>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">
            
            <!-- show side menu -->
            <script>
                open_menu();
            </script>
        
            <!--
                   
                    Create Login Modal
                    
            -->
            <div id="login_modal" class="modal">
             
                <span onclick="document.getElementById('login_modal').style.display='none';
                               window.location.href='lab4.php';"
                      class="close"
                      title="Close Modal">&times;</span>

                <!-- Content -->
                <form class="modal-content animate"
                      method="post"
                      action="check_login.php">
                      
                    <div class="imgcontainer">
                        <img src="user_icon_01.png"
                             alt="Avatar"
                             class="avatar">
                    </div>

                    <div class="container">
                      
                        <div class="my_center">
                             
                            <?php
                            if (count($s_errors) > 0) {
                                //print errors under avatar in modal
                                print "
                                <label><b style='color:red'>Error(s): </b></label>
                                <label><b> ";
                                foreach($s_errors as $e){
                                    print "<br>" . $e;
                                }
                                print " </b></label> ";
                            }
                            ?>
                            
                        </div>
                       
                        <label><b>Username</b></label>
                        <input type="text"
                               maxlength="50"
                               placeholder="Enter Your Username"
                               name="uname"
                               id="uname"
                               required>

                        <label><b>Password</b></label>
                        <input type="password"
                               maxlength="50"
                               placeholder="Enter Your Password"
                               name="pwd"
                               id="pwd"
                               required>
                        <br>

                        <button type="submit"
                                name="submit_login">Login</button>
                        <!--<input type="checkbox"
                               name="remember"
                               checked="checked"> Remember me-->
                        
                    </div>

                    <div class="container"
                         style="background-color: #f1f1f1">
                         
                        <button type="button"
                                onclick="document.getElementById('login_modal').style.display='none';
                                         window.location.href='lab4.php';"
                                class="cancelbtn">Cancel</button>
                        
                        <span class="psw">Forgot <a href="email_pass.php">Password?</a>&nbsp;&nbsp;&nbsp;&nbsp;Resend <a href="#" onclick="activateAcc()">Activation Code?</a></span>
                        
                    </div>
                    
                    <div class="container"
                         style="background-color: #d1d1d1;
                                text-align:center;">
                                
                            <div id="loader" class="loader"></div>
                             
                            <span id="act_msg"></span>
                             
                    </div>
                    
                </form>
                
                <!-- show login modal -->
                <script>
                    document.getElementById('login_modal').style.display='block';
                    document.getElementById('loader').style.display='none';
                </script>
              
            </div>
            <!-- End Of Pop-Up -->
            
        </div>

















    </body>
</html>