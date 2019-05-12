<!-- The side menu should be on every page but its content will change depending on who is logged in -->
<div id="side_menu" class="sidenav">
       
    <!-- change content depending on user -->
    <?php
    
    
    //include timeout functionality if logged in
    if ($s_usertype == "user" || $s_usertype == "admin" || $s_usertype == "super_admin") {
        if ($g_page != "logout"){
            include "timeout.php";
        }
    }
    
    
    //gohome if trying to access any internal/account page
    if ($s_usertype != "user" && $s_usertype != "admin" && $s_usertype != "super_admin") {
        if($g_page == "settings" || $g_page == "send_act" || $g_page == "change_setting"
           || $g_page == "tools" || $g_page == "tools2" || $g_page == "ajax_item"){
            header ("location: login.php");
            exit();
        }
    }
    
    
    //menu
    $out = "";

    
    //normal account
    if ($s_usertype == "user") {
        $name = ucfirst($s_uname);
        $out = <<<HERE
        <div style='color:white;text-align:center;font-style:italic;'>Welcome $s_uname.</div>
        <a href="lab4.php">Home</a>
        <a href="tools.php">Tools</a>
        <a href="settings.php">Settings</a>
        <a href="logout.php">Logout</a>
        <a href="register.php">Register Another</a>
HERE;
    }
    

    //admin account
    elseif ($s_usertype == "admin") {
        $out = <<<HERE
        <div style='color:white;text-align:center;font-style:italic;'>Welcome $s_uname.</div>
        <a href="lab4.php">Home</a>
        <a href="tools.php">Tools</a>
        <a href="settings.php">Settings</a>
        <a href="logout.php">Logout</a>
        <a href="register.php">Register Another</a>
HERE;
    }
        
    //super admin account
    elseif ($s_usertype == "super_admin") {
        $out = <<<HERE
        <div style='color:white;text-align:center;font-style:italic;'>Welcome $s_uname.</div>
        <a href="lab4.php">Home</a>
        <a href="tools.php">Tools</a>
        <a href="settings.php">Settings</a>
        <a href="logout.php">Logout</a>
        <a href="register.php">Register Another</a>
HERE;
    }
    

    //anonymous
    else {
        $out = <<<HERE
        <a href="lab4.php">Home</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
HERE;
    }//end check who
    

    //print menu
    print $out;
        
    
    ?>
    
</div>