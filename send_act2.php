<!-- send activation link based on $GET input -->
<!-- once complete, print message -->
<?php 

// 1.
include "get_sessions.php";
include "php/BE_functions.php";
require_once "mail/mail.class.php";
include_once "dbconnect.php";
$g_page = 'ajax_item';

// 2.
$uname = $_REQUEST["q1"];    //uname
$v_acc = false;              //account valid?
$email = "";                 //email
$info = "";                  //confirmation message

// 3.
$uname = trim($uname);

// 4.
$uname = mysqli_real_escape_string($con,$uname);

// 5.
if (strlen($uname) > 0) {
    
    $sql = "select Email from ibr_accounts a
            where a.Username='$uname' and
                  a.Acc_Status_ID != 3";

    $arr = db_do($con,$sql);

    if ($arr != -1) {
        if (count($arr) == 1) {
            $v_acc = true;
            $email = $arr[0][0];
        } else {
            array_push($s_errors, "Account does not exist");
        }
    }
    
} else {
    array_push($s_errors, "Please enter a valid username");
}

// 6.
if ($v_acc) {
    
    $code = get_code(50);
    $subject = "iBoard Account Activation";
    $activate_link = "http://corsair.cs.iupui.edu:20241/final_experimental/activate.php?code=$code&user=$uname";  //<-- for my corsair server
    
    // set code
    $sql = "update ibr_accounts
            set Activation_Code = '$code'
            where Username='$uname' and
                  Email='$email'";
    
    $arr = db_do($con,$sql,"update");
    
    //if success in db
    if ($arr != -1) {

        // email content
        $body = <<<HERE
        <h2> iBoard Account Activation </h2>
        <h4>
        Thank you for registering at iBoard! <br>
        Click on the link below to activate your account: <br><br>
        <a href=$activate_link> $activate_link </a> <br><br>
        Activation Code: <h3>$code</h3> <br>
        If you did not sign up for an account at iBoard, please ignore and discard this email. <br><br>
         -iBoard Overseer | Auto NO-REPLY Emailer
        </h4>
HERE;

        // email the activation link
        $mailer = new Mail();
        if (($mailer->sendMail($email, /* name */$uname, $subject, $body))==true) {

            //set notification
            $info = "<b>A new activation email has been sent.</b>";

        } else {

            // error
            array_push($s_errors, 'Email failed to send.<br>Info: <'.$email.', '. $uname.', '.$subject.'>');

        }//end send mail
        
    }//end success in db
    
}

// 7.
$out = "";
foreach($s_errors as $err) {
    $out .= "<span style='color:red;'>" . $err . " </span>";
}

print $out;
print $info;

?>