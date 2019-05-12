<!-- 

        Name:    change_setting.php

        Auth:    Ibrahim Sardar

        Desc:    Change Setting page of iBoard.com

-->

<!-- include session/globals getter file,
     include back end, php functions,
     include once the mail class,
     include connection once to 'ibsardar' database on mySQL,
     let the server know what page we're on -->
<?php
    include "get_sessions.php";
    include "php/BE_functions.php";
	require_once "mail/mail.class.php";
    include_once "dbconnect.php";
    $g_page = 'change_setting';
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>iBoard - Settings</title>
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

            <!-- show the side menu -->
            <script>
                open_menu();
            </script>

            <!--

                    Create Change Modal   ***   USES LIVE FORMAT VALIDATION   ***NOT DONE :(

            -->
            <div id="change_modal" class="modal">

                <span onclick="document.getElementById('change_modal').style.display='none';
                               window.location.href = 'settings.php'"
                      class="close"
                      title="Close Modal">&times;</span>

                <!-- Content -->
                <form class="modal-content animate"
                      method="post"
                      action="check_new_pass.php">

                    <div class="imgcontainer">
                        <img src="user_icon_01.png"
                             alt="Avatar"
                             class="avatar">
                    </div>

                    <div class="container">

                        <label><b>Current Username</b></label>
                        <input type="text"
                               maxlength="50"
                               placeholder="Enter Your Current Username"
                               name="uname"
                               id="uname"
                               required>

                        <label><b>Current Password</b></label>
                        <input type="password"
                               maxlength="50"
                               placeholder="Enter Your Current Password"
                               name="opwd"
                               id="opwd"
                               required>

                        <label><b>New Password</b></label>
                        <input type="password"
                               pattern="^(?=.*(?:[A-Za-z].*[0-9]|[0-9].*[A-Za-z]))[A-Za-z0-9]{10,50}$"
                               placeholder="Enter Your New Password"
                               name="npwd"
                               id="npwd"
                               required>
                        <br>

                        <button type="submit"
                                name="submit_change"
                                id="submit_change">Change</button>

                    </div>

                    <div class="container"
                         style="background-color: #f1f1f1">

                        <button type="button"
                                onclick="document.getElementById('change_modal').style.display='none';
                                         window.location.href = 'settings.php'"
                                class="cancelbtn">Cancel</button>

                    </div>

                </form>
            </div>
            
            <script>
                document.getElementById('change_modal').style.display='block';
            </script>

            <div class="my_center" id="changing">

                <h2>
                    Change Password
                </h2>

                <div class="my_vpad"></div>
                <div class="my_vpad"></div>
                <div class="my_vpad"></div>

            </div>
        </div>
        
        
        
        
        
        
        
        
















    </body>
</html>