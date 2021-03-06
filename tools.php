<!-- 

        Name:    tools.php

        Auth:    Ibrahim Sardar

        Desc:    Tools page of any account on iBoard.com

-->

<!-- include session/globals getter file,
     include custom php utils,
     let the server know what page we're on -->
<?php
    include "get_sessions.php";
    include "php/BE_functions.php";
    $g_page = 'tools';
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>iBoard - Tools</title>
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
                        Account Tools:
                    </div>
                </h2>

                <div class="my_vpad"></div>
                <div class="my_vpad"></div>
                <div class="my_vpad"></div>
            </div>
            
            <!--
                   
                    Show Account Tool Buttons
                    
            -->
            <div style="text-align:center;">
                  
                <div style='display:inline-block;
                            position:relative;'
                     class='pnltbl'>
                    <table>
                        <tr style="padding:25px">
                            <td style='text-align:center; padding:15px'>
                                <a href='tools2.php?tool="edit"'
                                   class='button icon edit'
                                   id='edit'> Edit Item
                                </a>
                            </td>
                            <td style='text-align:center padding:15px'>
                                <a href='tools2.php?tool="srch"'
                                   class='button icon search'
                                   id='srch'> Search Item
                                </a>
                            </td>
                        </tr>
                        <tr style="padding:25px">
                            <td style='text-align:center padding:15px'>
                                <a href='tools2.php?tool="add"'
                                   class='button icon add'
                                   id='add'> Add Item
                                </a>
                            </td>
                            <td style='text-align:center padding:15px'>
                                <a href='tools2.php?tool="del"'
                                   class='button icon trash'
                                   id='del'> Delete Item
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