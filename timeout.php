<?php

    //source: Lingma Acheson

    // auto log out in 1 hour ( 60 m )

    // also log time info

    echo "<script type='text/javascript'>
              console.log('===TIME INFO OF:   " .$g_page. "'); 
              console.log('time start: " .$_SESSION['timeout']. "'); 
              console.log('time end: " .($_SESSION['timeout'] + 1 * 60 * 60). "'); 
              console.log('current time: " .time(). "'); 
          </script>";

	if (!isset($_SESSION['email'])){
        echo "<script type='text/javascript'> console.log('TIMEOUT:  logout via email not set'); </script>";
        header ("Location:logout.php");
        exit();
    }else{
        if ( is_illegal($_SESSION['email']) ){
            echo "<script type='text/javascript'> console.log('TIMEOUT:  logout via email illegal'); </script>";
            header ("Location:logout.php");
            exit();
        }
    }
        
	
	//session time out 1 minutes after login. The timeout variable is set in the login page
	//keep refreshing the process.php page to see the behavior
	if(!isset($_SESSION['timeout'])){
        echo "<script type='text/javascript'> console.log('TIMEOUT:  logout via timeout not set'); </script>";
        header ("Location:logout.php") ;
        exit();
    }else{ 
		if ($_SESSION['timeout'] + 1 * 60 * 60 < time()){
            echo "<script type='text/javascript'> console.log('TIMEOUT:  logout; account inactive for at least 1 hour.'); </script>";
            header ("Location:logout.php") ;
            exit();
        }else{
            $_SESSION['timeout'] = time();
        }
    }

?>