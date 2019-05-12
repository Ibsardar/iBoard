<!--NAME:   BE_functions.php
    AUTH:   Ibrahim Sardar
    DESC:   Back end function(s) for iBoard.com (CSCIN342 final project)
    
        *** NOTE: $g_illegals, $g_errors has to be defined before using many of these functions! ***
-->

<?php

    /*  FUNCTION: 
     *  
     *  Checks if input string matches with any string within
     *  the global list: $g_illegals. Returns true if found.
     */
    function is_illegal( $str ) {
        
        //get from higher scope
        global $g_illegals;
        
        //check
        if (in_array( $str, $g_illegals ))
            return true;
        return false;
    }

    /*  FUNCTION:
     * 
     *  Checks for spammed, multiple emails. Then checks if the email is a valid email.
     *  Returns false if email is invalid. Returns true if email is valid.
     */
    function handle_email_2( $email, $confirm_email ) {
        
        //get from higher scope
        global $s_errors;
        
        // CHECK IF LEGAL
        if (is_illegal($email) || is_illegal($confirm_email)){
            $err = "Illegal email.";
            array_push($s_errors, $err);
            return false;
        }
        
        //remove spam/illegal characters
        $email = filter_var( $email, FILTER_SANITIZE_EMAIL);
        
        //check for valid e_mail
        if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            array_push($s_errors, "Invalid email.");
            return false;
        }

        //check if confirm email the same as email
        if ( $confirm_email == $email ) {
            return true;
        } else {
            array_push($s_errors, "Emails do not match.");
            return false;
        }
        
    }

    /*  FUNCTION:
     * 
     *  Same as above except only 1 email is checked
     */
    function handle_email( $email ) {
        
        //get from higher scope
        global $s_errors;
        
        // CHECK IF LEGAL
        if (is_illegal($email)){
            $err = "Illegal email.";
            array_push($s_errors, $err);
            return false;
        }
        
        //remove spam/illegal characters
        $email = filter_var( $email, FILTER_SANITIZE_EMAIL);
        
        //check for valid e_mail
        if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            array_push($s_errors, "Invalid email.");
            return false;
        }

        //since nothing is wrong till here, email is valid!
        return true;
        
    }


    /*  FUNCTION:
     * 
     *  Checks if password is between 10 to 50 characters and is equal to the confirm pass.
     *  Must be only letters and numbers.
     *  Returns false if pass is invalid. Returns true if pass is valid.
     */
    function handle_pass( $pass, $confirm_pass ) {
        
        //get from higher scope
        global $s_errors;
        
        // CHECK IF LEGAL
        if (is_illegal($pass) || is_illegal($confirm_pass)){
            $err = "Illegal password.";
            array_push($s_errors, $err);
            return false;
        }
        
        //check for length bounds 10-50
        if ( strlen($pass) < 10 || strlen($pass) > 50 ) {
            array_push($s_errors, "Password has an incorrect length.");
            return false;
        }
        
        // check match for
        //  - letters, (at least 1)
        //  - numbers, (at least 1)
        //  - upper or lower case,
        //  - 10-50 in length
        if (!preg_match('/^(?=.*(?:[A-Za-z].*[0-9]|[0-9].*[A-Za-z]))[A-Za-z0-9]{10,50}$/', $pass)){
            array_push($s_errors, "Password has an incorrect format.");
            return false;
        }

        //check if confirm pass the same as pass
        if ( $confirm_pass == $pass ) {
            return true;
        } else {
            array_push($s_errors, "Passwords do not match.");
            return false;
        }
        
    }


    /*  FUNCTION:
     * 
     *  This function generates a random code with letters and digits of length '$length'
     */
    function get_code( $length ){
        $code = "";
        for($i=0; $i<$length; $i++){
            //random number 1 to 36
            $rnd = mt_rand(1,36);
            //if rnd is 1 to 26: A-Z (only uppercase)
            //if rnd is 27 to 36: 0-9
            if ($rnd >= 27) {
                $rnd = $rnd - 27;
                $code = $code.$rnd;
            } else {
                // rnd=1 means 1+64=65 where 65 is the ASCII decimal of 'A'
                $rnd = $rnd + 64;
                // convert ASCII decimal to character
                $code = $code.( chr($rnd) );
            }
        }
        return $code;
    }//end get_code

    /*  FUNCTION: 
     *  
     *  This function checks if the code is in the right format (A-Z,0-9,length is 50)
     *  uses regex and preq_match()
     */
    function handle_code( $code ){
        
        //get from higher scope
        global $s_errors;
        
        //check
        if (preg_match('/^[A-Z0-9]{50}$/', $code)){
            return true;
        }
        
        //err
        array_push($s_errors, "Invalid activation code.");
        return false;
    }

    /*  FUNCTION: 
     *  
     *  true if correct phone format: (xxx)xxx-xxxx OR EMPTY
     *  false if not
     */
    function handle_phone( $number ){
        
        //get from higher scope
        global $s_errors;
        
        // CHECK IF LEGAL
        if (is_illegal($number)){
            $err = "Illegal phone number.";
            array_push($s_errors, $err);
            return false;
        }
        
        // CHECK IF EMPTY
        if ($number == "")
            return true;
        
        // Where x is any digit:   full regex: \(\d{3}\)\d{3}-\d{4}
        // part: (xxx)
        $p1 = '\(\d{3}\)';
        // part: xxx-
        $p2 = '\d{3}-';
        // part: xxxx
        $p3 = '\d{4}';
        
        if (preg_match('/^' .$p1.$p2.$p3. '$/', $number)){
            return true;
        }
        
        array_push($s_errors, "Phone number is in incorrect format.");
        return false;
    }

    /*  FUNCTION: 
     *  
     *  converts input to a table (in HTML)
     *  input has to be a 2Dim array (1st array is title)
     */
    function matrix_to_table( $data, $class="", $exclude=array() ){
    
        //vars
        $table = "";
        $cols = 0;
        $rows = 0;
        $type = "";
        $ex = array();  //indices of excluded columns
        
        //begin table
        //==========================>
        $table = "<table align='center' class='$class'>";
        
        //gather exclusions via 1st row
        for ( $i=0; $i<count($data[0]); $i++ ) {
            //check if header matches any in 'exclude'
            if ( in_array($data[0][$i], $exclude) ) {
                //store index
                array_push($ex, $i);
            }
        }
        
        //loop thru rows
        for ( $rows=0; $rows<sizeof($data); $rows++ ) {
            $table = $table . "<tr>";
            if($rows==0){
                $type = "th";
            }else{
                $type = "td";
            }
            //loop thru cols
            for ( $cols=0; $cols<sizeof($data[0]); $cols++ ) {
                
                //check if this index should be excluded
                if ( !in_array($cols,$ex) ) {
                    //cell value
                    $table = $table . "<".$type.">";
                    $table = $table . $data[$rows][$cols];
                    $table = $table . "</".$type.">";
                }
                    
            }//end of row
            $table = $table . "</tr>";
        }//end of col
        
        $table = $table . "</table>";
        //==========================>
        //end table
                
        //HTML
        $out = <<<HERE
        <div class="my_center">
        $table
        </div>
HERE;
        
        return $out;
    }//end func

    /*  FUNCTION:
     *  
     *  This function returns the result of a query done on the input connection
     *  Return type: 2D array
     */
    function db_do( $con, $sql, $type="get" ){
        
        //get from higher scope
        global $s_errors;
        
        //vars
        $bridge;
        $result;
        $final = array();
        
        //get
        $bridge = mysqli_query( $con, $sql ) or die( mysqli_error($con) );
        
        //check
        if ($bridge){
            
            if ($type == "get") {
                //cleanse into 2D array
                while ($result = mysqli_fetch_array( $bridge )) {
                    //push row into array
                    $final[] = $result;
                }
            }
            
        }else{
            //err
            array_push($s_errors, "Unable to execute a passed query.");
            return -1;
        }
        
        //return
        return $final;
    }

    /*  FUNCTION:
     *
     *  This function prints an option list of column names from the input table
     *  Optional parameter is a list of column names to be excluded
     *
     */
    function db_print_options( $con, $tbl, $exclusions=array() ) {
        
        //get from higher scope
        global $s_errors;
        
        $sql = "show columns from $tbl";

        $arr = db_do($con,$sql);

        if ($arr != -1) {
            
            // print columns as options
            foreach($arr as $row){
                $col_name = $row[0];
                if (!in_array($col_name, $exclusions)) {
                    print "<option value='$col_name'>$col_name</option>";
                }
            }
            
        } else {
            array_push($s_errors, "Unable to obtain database options.");
        }
        
    }

    /*  FUNCTION: 
     *  
     *  This function returns #rows if '$str' is searched in column '$col'
     *  using the '$con' connection. If error, returns -1.
     *
     *  Only works with varchars.
     *
     */
    function db_check_acc( $con, $col, $str, $col2="none ", $str2="none" ){
        
        //get from higher scope
        global $s_errors;
        
        //vars
        $sql;
        $bridge;
        
        //create query
        if ( is_illegal($col2) || is_illegal($str2) ){
            $sql = "select *
            from ibr_accounts a
            where a.$col = '$str'";
        } else {
            $sql = "select *
            from ibr_accounts a
            where a.$col = '$str' and a.$col2 = '$str2'";
        }
        
        //get
        $bridge = mysqli_query( $con, $sql ) or die( mysqli_error($con) );
        
        //check
        if ($bridge) {
            
            //echo mysqli_num_rows($bridge); debug
            return mysqli_num_rows($bridge);
            
        } else {
            array_push($s_errors, "Unable to execute internal query.");
            return -1;
        }
        
        //return
        array_push($s_errors, "Unexpected error while checking our databases.");
        return -1;
    }
    
    /*  FUNCTION: 
     *  
     *  Customized check for register
     *
     */
    function db_check_acc_2( $con, $em, $un ){
        
        //get from higher scope
        global $s_errors;
        
        //vars
        $sql;
        $bridge;
        
        //create query
        $sql = "select count(*)
        from ibr_accounts a
        where a.Email = $em or
              a.Username = $un ";
        
        //get
        $bridge = mysqli_query( $con, $sql ) or die( mysqli_error($con) );
        
        //check
        if ($bridge) {
            
            return mysqli_num_rows($bridge);
            
        } else {
            array_push($s_errors, "Unable to execute internal query.");
            return -1;
        }
        
        //return
        array_push($s_errors, "Unexpected error while checking our databases.");
        return -1;
    }

    /*  FUNCTION: 
     *  
     *  This function adds an account record to 'ibr_test_accounts'
     *  table using a stored procedure.
     *
     *  SP NOT YET IMPLEMENTED!!!
     */
    function db_add_acc( $con, $email, $pwd, $fname, $lname, $sex, $num, $active, $code ){
        
        //get from higher scope
        global $s_errors;
        
        //vars
        $sql;
        $bridge;
        
        //create query
        $sql = "insert into ibr_accounts
                    (Email,
                     Password,
                     First_Name,
                     Last_Name,
                     Gender,
                     Phone,
                     Active,
                     A_Code)
                values  
                    ('$email',
                     '$pwd',
                     '$fname',
                     '$lname',
                     '$sex',
                     '$num',
                     '$active',
                     '$code' )";
        
        //get
        $bridge = mysqli_query( $con, $sql ) or die( mysqli_error($con) );
        
        //check
        if ($bridge) {
            
            return true;
            
        } else {
            
            array_push($s_errors, "Unable to execute internal query.");
            return false;
            
        }
        
    }//end db function
    
    /*  FUNCTION:
     *  
     *  This function does a query to a the 'ibr_test_accounts' table
     *  that sets some value to some column of the input user.
     *
     *  SP NOT YET IMPLEMENTED!!!
     *
     *  Only works with varchar
     *
     *  return true if query succeeds
     */
    function db_set_acc( $con, $usr, $col, $str ){
        
        //get from higher scope
        global $s_errors;
        
        //vars
        $sql;
        $bridge;
        
        //create query
        $sql = "update ibr_accounts
                set $col = '$str'
                where Email = '$usr'";
        
        //get
        $bridge = mysqli_query( $con, $sql ) or die( mysqli_error($con) );
        
        //check
        if ($bridge) {
            
            return true;
            
        } else {
            
            array_push($s_errors, "Unable to execute internal query.");
            return false;
            
        }
        
        //return
        array_push($s_errors, "Unexpected error while checking our databases.");
        return false;
        
    }

    /*  FUNCTION: 
     *  
     *  This function returns query result as array
     *
     *  Only works with varchars.
     *  '$col' parameter should be 'Email' but will still work otherwise
     *
     *  SP NOT YET IMPLEMENTED!!!
     */
    function db_get_acc( $con, $col="none", $str="none", $col2="none ", $str2="none" ){
        
        //get from higher scope
        global $s_errors;
        
        //vars
        $sql;
        $bridge;
        $final;
        
        //validator vars
        $vc  = is_illegal($col);
        $vs  = is_illegal($str);
        $vc2 = is_illegal($col2);
        $vs2 = is_illegal($str2);
        
        //create query
        //$sql = "Call ibr_sp_get_acc(...)";
        if ( $vc && $vs && $vc2 && $vs2 ) {
            $sql = "select *
                    from ibr_accounts";
            
        } elseif ( !$vc && $vs && $vc2 && $vs2 ) {
            $sql = "select $col
                    from ibr_accounts";
                
        } elseif ( !$vc && !$vs && $vc2 && $vs2 ) {
            $sql = "select *
                    from ibr_accounts
                    where $col = '$str'";
            
        } elseif ( !$vc && !$vs && !$vc2 && $vs2 ) {
            $sql = "select $col2
                    from ibr_accounts
                    where $col = '$str'";
            
        } elseif ( !$vc && !$vs && !$vc2 && !$vs2 ) {
            $sql = "select *
                    from ibr_accounts a
                    where $col = '$str' and $col2 = '$str2'";
        } else {
            array_push($s_errors, "Invalid arguments.");
            return null;
            
        }
        
        //get
        $bridge = mysqli_query( $con, $sql ) or die( mysqli_error($con) );
        
        //check
        if ($bridge) {
            
            //cleanse
            $final = mysqli_fetch_array( $bridge );
            
        } else {
            
            //err
            array_push($s_errors, "Unable to execute internal query.");
            return null;
            
        }
        
        //return
        return $final;
    }

    /*  FUNCTION
     *
     *  time limit for user logged in (1hr) ***DOES NOT WORK
     */
    function auto_logout($field) {
        $t = time();
        $t0 = $_SESSION[$field];
        $diff = $t - $t0;
        if ($diff > 6000 || !isset($t0))
        {          
            return true;
        }
        else
        {
            $_SESSION[$field] = time();
        }
    }

?>