<?php   

// ------------------------------------
//
// Print options for iBoard's Accounts' search tool:
//  1. Connect to Resources
//  2. Get
//  3. Decrypt
//  4. Security
//  5. Print
//
// ------------------------------------

// 1.
include "get_sessions.php";
include "php/BE_functions.php";
include_once "dbconnect.php";
$g_page = 'ajax_item';

// 2.
$q=$_REQUEST["q"];  // table name

// 3.
if ($q=="Accounts") {
    $q = "ibr_accounts";
} else
if ($q=="Groups") {
    $q = "ibr_groups";
} else
if ($q=="Whiteboards") {
    $q = "ibr_whiteboards";
}

// 4.
$q = mysqli_real_escape_string($con,$q);

// 5.
db_print_options($con,$q,array("Password","Activation_Code"));

?>


