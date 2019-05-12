<!-- 

        Name:    lab4.php (index)

        Auth:    Ibrahim Sardar

        Desc:    Activation page of iBoard.com

-->

<!-- include session/globals getter file,
     include back end, php functions,
     include connection once to 'ibsardar' database on mySQL,
     let the server know what page we're on -->
<?php
    include "get_sessions.php";
    include "php/BE_functions.php";
    include_once "dbconnect.php";
    $g_page = 'activated';
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>iBoard - Activation</title>
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
            
            <!-- activate account if code is valid -->
            <?php
            
            
            //init
            $info  = "";
            $uname = "";
            $code  = "";
            
            //get
            if (isset($_GET['user'])) $uname = $_GET['user'];
            if (isset($_GET['code'])) $code  = $_GET['code'];
            
            //if required data is in $_GET, if not redirect
            if ( $uname != "" && $code != "" ) {
                
                $sql1 = "select count(*) from ibr_accounts
                         where Activation_Code = '$code' and Username = '$uname'";
                $sql2 = "update ibr_accounts
                         set Activated = 'yes', Acc_Status_ID = 1
                         where Username = '$uname'";
                
                $arr1 = db_do($con,$sql1);
                
                if ($arr1 != -1) {
                    if ($arr1[0][0] == 1) {
                        db_do($con,$sql2,"update");
                        $info = "Success!";
                    } else {
                        array_push($s_errors, "Access Denied.");
                    }
                }
            
                /*
                //check account with activation code
                if ( db_check_acc( $con,"Email",$uname,"A_Code",$code ) == 1 ) {
            
                    //check if active
                    if ( db_check_acc( $con,"Email",$uname,"Active","yes" ) == 0 ) {
                        //set active & notify
                        if (db_set_acc( $con,$uname,"Active","yes" ) )
                            $info = "success!";
                    }
                    
                } else {
                    
                    //wrong info
                    array_push($s_errors, "Access Denied.");
                    
                }*/
                    
            } else {  
                //empty info
                array_push($s_errors, "Access Denied - nothing was found.");
            }

            
            ?>
        
            <div class="my_center">
                <h2>
                    <div style='text-align: center;'>
                        <?php
                        

                        //notify
                        if ($info == "Success!") {
                            print "Thank You, Your Account Has Been Activated.";
                            $_SESSION['active'] = "yes";
                        } else {
                            print "<span style='color:red;'>Activation Failed.</span>";
                        }//end notify
                        
                        //show any errors
                        echo "<br><br><h4 style='color:red'>";
                        foreach($s_errors as $e){
                            print "<br>" . $e;
                        }
                        echo "</h4";
                        

                        ?>
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