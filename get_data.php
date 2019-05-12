<?php   

// ------------------------------------
//
// Print results for iBoard's Accounts' search tool:
//  1. Connect to Resources
//  2. Get
//  3. Decrypt
//  4. Security
//  5. Query
//     a) get
//     b) translate
//     c) permissions
//  6. Make Array
//  7. Print
//
// ------------------------------------

// 1.
include "get_sessions.php";
include "php/BE_functions.php";
include_once "dbconnect.php";
$g_page = 'ajax_item';

// 2.
$q1 = $_REQUEST["q1"];     //search term
$q2 = $_REQUEST["q2"];     //limit amount
$q3 = $_REQUEST["q3"];     //sort column
$q4 = $_REQUEST["q4"];     //search column
$q5 = $_REQUEST["q5"];     //search table

// 3.
$q1 = trim($q1);

// 3.
$lim;
if ($q2 == 'r10') { $lim = ' limit 10 '; } else
if ($q2 == 'r20') { $lim = ' limit 20 '; } else
if ($q2 == 'r50') { $lim = ' limit 50 '; }
else { $lim = ''; }

// 3.
if ($q5=="Accounts") {
    $q5 = "ibr_accounts";
} else
if ($q5=="Groups") {
    $q5 = "ibr_groups";
} else
if ($q5=="Whiteboards") {
    $q5 = "ibr_whiteboards";
}

// 4.
$q1 = mysqli_real_escape_string($con,$q1);
$q3 = mysqli_real_escape_string($con,$q3);
$q4 = mysqli_real_escape_string($con,$q4);

// 5.
$sql = "show columns from $q5";

$table_info = db_do($con,$sql);

//////////////////////////////////////////////////////////////////     add permissions and translations

$sql = "select *
        from $q5
        where $q4 like '%$q1%'
        order by $q3 $lim";

$body = db_do($con,$sql);

// 6.
$headers = array();
foreach($table_info as $row){
    array_push($headers, $row[0]);
}
$matrix = array($headers);
foreach($body as $row) {
    array_push($matrix, $row);
}
$len = count($body);

// 7.
$exclusions = array("Password","Data","Activation_Code");
print "<br>$len Results Found.<br><br>";
print matrix_to_table($matrix,'bigtbl',$exclusions);

?>


