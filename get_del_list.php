<?php   

// ------------------------------------
//
// Print results with checkboxes for iBoard's Accounts' delete tool:
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
$q1 = $_REQUEST["q1"];     //table

// 3.
if ($q1=="Accounts") {
    $q1 = "ibr_accounts";
} else
if ($q1=="Groups") {
    $q1 = "ibr_groups";
} else
if ($q1=="Whiteboards") {
    $q1 = "ibr_whiteboards";
}

// 4.
$q1 = mysqli_real_escape_string($con,$q1);

// 5.
$sql = "show columns from $q1";

$table_info = db_do($con,$sql);

//////////////////////////////////////////////////////////////////     add permissions and translations

$sql = "select *
        from $q1";

$body = db_do($con,$sql);

// 6.
$headers = array("Delete?");
foreach($table_info as $row){
    array_push($headers, $row[0]);
}
$matrix = array($headers);

//add a checkbox to leftmost cell in each row
// - value matches leftmost column value in row (typically ID)
for ($i=0;$i<count($body);$i++) {
    array_splice($body[$i], 0, 0, "<input type='checkbox' name='to_del_cell' value='" . $body[$i][0] . "'>");
}
//add data
foreach($body as $row) {
    array_push($matrix, $row);
}

$len = count($body);

// 7.
$exclusions = array("Password","Data","Activation_Code");
print "<br><div style='text-align:center'>";
print "<br>$len Items Found.<br><br>";
print "<br>Choose All Items You Want to Delete.<br><br>";
print matrix_to_table($matrix,'smltbl',$exclusions);
foreach($s_errors as $err) {
    print "<br>" . $err;
}
print "</div>";

?>


