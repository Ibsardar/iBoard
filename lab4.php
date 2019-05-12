<!-- 

        Name:    lab4.php (index)

        Auth:    Ibrahim Sardar

        Desc:    Home page of iBoard.com

-->

<!-- include session/globals getter file,
     include custom php utils,
     let the server know what page we're on -->
<?php
    include "get_sessions.php";
    include "php/BE_functions.php";
    $g_page = 'home';
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>iBoard - Home</title>
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
                        Hello, this website is in progress...
                    </div>
                </h2>

                <div class="my_vpad"></div>
                <div class="my_vpad"></div>
                <div class="my_vpad"></div>

                <h4>
                    iBoard is a website were users can enjoy making, sharing, and storing online notes with ease.
                </h4>
                
                <div class="my_vpad_great"></div>
                <div class="my_vpad_great"></div>
                <div class="my_vpad_great"></div>
                <div class="my_vpad_great"></div>
                
                <div>
                    Icons made by <a href="http://www.flaticon.com/authors/gregor-cresnar" title="Gregor Cresnar">Gregor Cresnar</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a>
                </div>
                
            </div>
            
        </div>
        
        
















    </body>
</html>