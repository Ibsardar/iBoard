<!-- Retrieves all session variables -->
<?php

    include "adv_debug.php";

    //continue/create session
    if (session_id() == "")
        session_start();

    //set time
    $_SESSION['user_time'] = time();

    //init vars (illusion of "session")
    $s_usertype;
    $s_userstatus;
    $s_errors;   //list of errors
    $s_uname;
    $s_about;
    $s_email;
    $s_active;
    $s_pwd;

    //init other vars (illusion of "global")
    $g_page = "none";
    $g_illegals = array( "n/a", "none" );   //illegal user inputs



    //Put all session variable data into
    //global variables to be used in each file
    // note: "none" if not set yet

    // - user type
    if ( isset($_SESSION['ac_type']) ) {
        if ($_SESSION['ac_type'] == 1) {
            $s_usertype = "user";
        }elseif($_SESSION['ac_type'] == 2){
            $s_usertype = "admin";
        }else{
            $s_usertype = "super_admin";
        }
    } else {
        $s_usertype = "none";
    }

    // - user status
    if ( isset($_SESSION['ac_status']) ) {
        if ($_SESSION['ac_status'] == 1) {
            $s_userstatus = "normal";
        }elseif($_SESSION['ac_status'] == 2){
            $s_userstatus = "locked";
        }else{
            $s_userstatus = "terminated";
        }
    } else {
        $s_userstatus = "none";
    }

    // - error list
    if ( isset($_SESSION['errors']) ) {
        $s_errors = $_SESSION['errors'];
    } else {
        $s_errors = array();
    }

    // - account ID
    if ( isset($_SESSION['ac_id']) ) {
        $s_id = $_SESSION['ac_id'];
    } else {
        $s_id = "none";
    }

    // - username
    if ( isset($_SESSION['uname']) ) {
        $s_uname = $_SESSION['uname'];
    } else {
        $s_uname = "none";
    }

    // - email
    if ( isset($_SESSION['email']) ) {
        $s_email = $_SESSION['email'];
    } else {
        $s_email = "none";
    }

    // - about
    if ( isset($_SESSION['about']) ) {
        $s_about = $_SESSION['about'];
    } else {
        $s_about = "none";
    }

    // - is account active?
    if ( isset($_SESSION['active']) ) {
        $s_active = $_SESSION['active'];
    } else {
        $s_active = "none";
    }

    // - activation code
    if ( isset($_SESSION['a_code']) ) {
        $s_a_code = $_SESSION['a_code'];
    } else {
        $s_a_code = "none";
    }

    // - password
    if ( isset($_SESSION['pass']) ) {
        $s_pwd = $_SESSION['pass'];
    } else {
        $s_pwd = "none";
    }
    

?>