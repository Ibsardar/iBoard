/*
 *
 *  Name:       FE_function.js
 *
 *  Auth:       W3schools, Ibrahim Sardar
 *  Source:     W3schools Tutorials   =>   http://www.w3schools.com/howto
 *
 *  Desc:       Front end function(s) for iBoard.com (CSCIN342 final project)
 *
 */



/*  FUNCTION:   closes the registration/login pop-up when
 *              user clicks anywhere off the pop-up
 *              automatically shows the HOME page
 */
window.onclick = function(event) {
    // get
    var modal_log = document.getElementById('login_modal');
    var modal_reg = document.getElementById('register_modal');
    var modal_chg = document.getElementById('change_modal');
    var gohome = false;
    
    // close
    if (event.target == modal_reg) {
        modal_reg.style.display = "none";
        gohome = true;
    }
    if (event.target == modal_log) {
        modal_log.style.display = "none";
        gohome = true;
    }
    if (event.target == modal_chg) {
        modal_log.style.display = "none";
        gohome = false;
    }
    
    //show home
    if (gohome) {
        window.location.href="lab4.php";
    }
}

/*  FUNCTION:   opens side menu
 *
 */
function open_menu() {
    document.getElementById("side_menu").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

/*  FUNCTION:   closes side menu
 *
 */
function close_menu() {
    document.getElementById("side_menu").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
}

/*  FUNCTION:   live password validation
 *
 */
function live_pwd_check(){
    
    var pass = document.getElementById("pwd");
    var vpass = document.getElementById("vpwd");
    
    if(pass.value != vpass.value) {
        vpass.setCustomValidity("Passwords Do Not Match");
    } else {
        vpass.setCustomValidity('');
    }
}

/*  FUNCTION:   live password validation using input session vars ***DOESN'T WORK!
 *
 */
function live_pwd_check2( u, p ){
    
    var user = document.getElementById("uname");
    var opass = document.getElementById("opwd");
    var npass = document.getElementById("npwd");
    
    if(user.value != u) {
        user.setCustomValidity("Wrong Username");
    } else if(opass.value != p) {
        opass.setCustomValidity("Wrong Password");
    } else if (opass.value == npass.value){
        npass.setCustomValidity("Choose A Different Password");
    } else {
        user.setCustomValidity("");
        opass.setCustomValidity("");
        npass.setCustomValidity("");
    }
    
}