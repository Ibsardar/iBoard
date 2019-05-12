<?php   

// ------------------------------------
//
// Add item for iBoard's Accounts' add tool:
//  1. Connect to Resources
//  2. Get
//  3. Trim/Validate
//  4. Security
//  5. Vaidate if user already has this item with the same name
//  6. Query
//  7. Print
//
// ------------------------------------

// 1.
include "get_sessions.php";
include "php/BE_functions.php";
include_once "dbconnect.php";
$g_page = 'ajax_item';

// 2.
$q1 = $_REQUEST["q1"];     //table
$q2 = $_REQUEST["q2"];     //name
$res = null;

// 3.
$q2 = trim($q2);
if (strlen($q2) < 6) {
    array_push($s_errors, "<span style='color:red'>Name must be at lest 6 characters.<span>");
} else {

    // 4.
    $q2 = mysqli_real_escape_string($con,$q2);
    
    // 5.
    //......................................................    FIX!!!

    // 6.
    if ($q1=="Group") {
        $sql = "call ibr_sp_add_grp('$q2','$s_id')";
    } else
    if ($q1=="Whiteboard") {
        $sql = "call ibr_sp_add_brd_indv('$q2','',1,'$s_id')";
    } else
    if ($q1=="Group_Whiteboard") {
        //$sql = "call ibr_sp_add_brd_grp('$q3','',1,'$s_id')";          FIX!!!
    }

    $res = db_do($con,$sql,"SP");
    
}

// 7.
$out = "";
$out = "<br><div style='text-align:center'>";
foreach($s_errors as $err) {
    $out .= "<br>" . $err;
}
if ($res != -1 && count($s_errors)==0){
    $out .= "<br> A New $q1 was successfully added to your account.";
}
$out .= "</div>";

print $out;

?>


