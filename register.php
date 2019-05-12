<!-- 

        Name:    register.php

        Auth:    Ibrahim Sardar

        Desc:    New user registration page of iBoard.com

-->

<!-- include session/globals getter file,
     include custom php utils,
     let the server know what page we're on -->
<?php
    include "get_sessions.php";
    include "php/BE_functions.php";
    $g_page = 'register';
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>iBoard - Registration</title>
        <link rel="stylesheet" href="css/ibr_custom2.css" type="text/css">
        <script src="js/FE_functions.js" type="text/javascript"></script>
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
                   
                    Create Registeration Modal
                    
            -->
            <div id="register_modal" class="modal">
             
                <span onclick="document.getElementById('register_modal').style.display='none';
                               window.location.href='lab4.php';"
                      class="close"
                      title="Close Modal">&times;</span>

                <!-- Content -->
                <form class="modal-content animate"
                      method="post"
                      action="check_register.php">
                      
                    <div class="imgcontainer">
                        <img src="user_icon_01.png"
                             alt="Avatar"
                             class="avatar">
                    </div>

                    <div class="container">
                       
                        <label><b>Username</b></label>
                        <input type="text"
                               pattern=".{8,50}"
                               required title="8 to 50 characters"
                               placeholder="Enter Username   |   Format: 8 to 50 characters"
                               name="uname"
                               required>
                               
                        <label><b>Email</b></label>
                        <input type="text"
                               pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
                               required title="user@domain.institution"
                               placeholder="Enter Email"
                               name="email"
                               required>

                        <label><b>Password</b></label>
                        <input type="password"
                               pattern="^(?=.*(?:[A-Za-z].*[0-9]|[0-9].*[A-Za-z]))[A-Za-z0-9]{10,50}$"
                               required title="10-50 characters; letters and numbers"
                               placeholder="Enter Password   |   Format: 10-50 characters; letters and numbers"
                               name="pwd"
                               id="pwd"
                               required>
                               
                        <label><b>Verify Password</b></label>
                        <input type="password"
                               pattern="^(?=.*(?:[A-Za-z].*[0-9]|[0-9].*[A-Za-z]))[A-Za-z0-9]{10,50}$"
                               placeholder="Verify Password"
                               name="vpwd"
                               id="vpwd"
                               required>
                               
                        <!-- live password match check -->
                        <script>
                            var pass = document.getElementById("pwd");
                            var vpass = document.getElementById("vpwd");
                            pass.onchange = live_pwd_check;
                            vpass.onkeyup = live_pwd_check;
                        </script>
                              
                        <!-- About Me Text Box -->
                        <label><b>About Me</b></label><br>
                        <textarea name="about" rows="5" cols="40"
                             id="about" placeholder="Max 350 Characters..."></textarea>
                               
                        <br><br>
                        <div class="my_center">
                            <input type="checkbox"
                                   name="agree"
                                   value="yes"
                                   required>
                            <label><b>Agree to Terms and Conditions</b></label>
                        </div>
                        <br>

                        <button type="submit"
                                name="submit_register">Register</button>
                        <!--<input type="checkbox"
                               checked="checked"> Remember me-->
                        
                    </div>

                    <div class="container"
                         style="background-color: #f1f1f1">
                         
                        <button type="button"
                                onclick="document.getElementById('register_modal').style.display='none';
                                         window.location.href='lab4.php';"
                                class="cancelbtn">Cancel</button>
                                
                        <!--<span class="psw">Forgot <a href="#">password?</a></span>-->
                        
                    </div>
                    
                </form>
                
                <!-- show registration modal -->
                <script>
                    document.getElementById('register_modal').style.display='block';
                </script>
              
            </div>
            <!-- End Of Pop-Up -->
            
        </div>

















    </body>
</html>