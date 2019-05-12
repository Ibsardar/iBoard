<!-- 

        Name:    settings.php

        Auth:    Ibrahim Sardar

        Desc:    Settings page of any account on iBoard.com

-->

<!-- include session/globals getter file,
     include custom php utils,
     let the server know what page we're on -->
<?php
    include "get_sessions.php";
    include "php/BE_functions.php";
    $g_page = 'settings';
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
        
            <div class="my_center">
                <h2>
                    <div style="text-align: center;">
                        Account Settings:
                    </div>
                </h2>

                <div class="my_vpad"></div>
                <div class="my_vpad"></div>
                <div class="my_vpad"></div>
            </div>
            
            <!-- about me -->
            <div style="text-align:center;">
                <div style='display:inline-block;
                            position:relative;'
                     class='smltbl'>
                    <b>About Me:</b><br>
                    <table style="margin-left:30%;margin-right:30%;">
                        <tr style="padding:15px">
                            <td style='text-align:center; padding:15px;'>
                                <?php   echo "$s_about$s_about$s_about$s_about$s_about$s_about$s_about$s_about$s_about$s_about$s_about";   ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="my_vpad"></div>
            
            <!-- account information table -->
            <div>
                <?php
                if($s_active != "yes"){
                    echo "<div style='color:red;text-align:center'>
                        Your account is not active, check for an email by iBoard.com and follow the instructions. Otherwise, click below to send a new activation link.
                    </div>";
                    echo "<br>
                          Send Activation Link: 
                          <a href='send_act.php'
                             class='button icon mail'
                             id='send_act'> SEND
                          </a>
                          <div class='my_vpad_great'></div>
                         ";
                }
                // Account Info
                $arr = array( array("Username","Email","Account Type","Account Status","Activated?","Official ID"),
                              array( $s_uname,$s_email,$s_usertype,$s_userstatus,$s_active,$s_id ) );
                echo matrix_to_table( $arr,"smltbl" );
                ?>
            </div>
            
            <div class="my_vpad"></div>
            
            <!-- change password button -->
            <div style="text-align:center;">
                <div style='display:inline-block;
                            position:relative;'
                     class='pnltbl'>
                    <table>
                        <tr style="padding:25px">
                            <td style='text-align:center; padding:15px'>
                                <a href="change_setting.php?which='Password'" 
                                   class='button icon key'
                                   id='edit'> Change Password
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="my_vpad_great"></div>
            <div class="my_vpad_great"></div>
              
            <div style="text-align:center"> 
            All rights reserved. Copyright 2016. Licensed under CC by-sa 3.0 with attribution required.
            </div>
                
        </div>
        
        
















    </body>
</html>