<!-- 

        Name:    tools2.php

        Auth:    Ibrahim Sardar

        Desc:    Tools page of any account on iBoard.com

-->

<!-- include session/globals getter file,
     include custom php utils,
     let the server know what page we're on -->
<?php
    include "get_sessions.php";
    include "php/BE_functions.php";
    include_once "dbconnect.php";
    $g_page = 'tools2';
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>iBoard - Tools</title>
        <link rel="stylesheet" href="css/ibr_custom2.css" type="text/css">
        <script src="js/FE_functions.js" type="text/javascript"></script>
        
        <!-- Script For AJAX Utilization -->
        <script>
        
            function showData() {

                var str = document.getElementById("user_input").value;  // string
                var lim = document.getElementById("limit_by").value;    // number
                var sor = document.getElementById("sort_by").value;     // column
                var sby = document.getElementById("search_by").value;   // column
                var sfr = document.getElementById("search_from").value; // table


                //-------------------------------
                // AJAX CHUNK
                var xmlhttp;

                // code for IE7+, Firefox, Chrome, Opera, Safari
                if (window.XMLHttpRequest) {
                    xmlhttp=new XMLHttpRequest();

                // code for IE6, IE5
                } else {
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }

                xmlhttp.onreadystatechange=function() {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                        document.getElementById("output_area").innerHTML=xmlhttp.responseText;
                    }
                }

                //... term, limit, sortby, column, table
                xmlhttp.open("GET","get_data.php?q1="+str+"&q2="+lim+"&q3="+sor+"&q4="+sby+"&q5="+sfr,true);

                xmlhttp.send();
                // END OF AJAX CHUNK
                //-------------------------------

            }
            
            function getDrops() {
                
                var sfr = document.getElementById("search_from").value; // table
                
                //-------------------------------
                // AJAX CHUNK
                var xmlhttp;

                // code for IE7+, Firefox, Chrome, Opera, Safari
                if (window.XMLHttpRequest) {
                    xmlhttp=new XMLHttpRequest();

                // code for IE6, IE5
                } else {
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }

                xmlhttp.onreadystatechange=function() {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                        document.getElementById("sort_by").innerHTML=xmlhttp.responseText;
                        document.getElementById("search_by").innerHTML=xmlhttp.responseText;
                        //update current selection
                        showData();
                    }
                }

                xmlhttp.open("GET","get_drops.php?q="+sfr,true);

                xmlhttp.send();
                // END OF AJAX CHUNK
                //-------------------------------
                
            }
            
            function submitAdd() {
                
                var nam = document.getElementById("add_input").value;   // column name
                var tbl = document.getElementById("what_to_add").value; // table
                
                //-------------------------------
                // AJAX CHUNK
                var xmlhttp;

                // code for IE7+, Firefox, Chrome, Opera, Safari
                if (window.XMLHttpRequest) {
                    xmlhttp=new XMLHttpRequest();

                // code for IE6, IE5
                } else {
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }

                xmlhttp.onreadystatechange=function() {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                        document.getElementById("output_area").innerHTML=xmlhttp.responseText;
                    }
                }

                xmlhttp.open("GET","submit_add.php?q1="+tbl+"&q2="+nam,true);

                xmlhttp.send();
                // END OF AJAX CHUNK
                //-------------------------------
                
            }
            
            function getDelList() {
                
                var tbl = document.getElementById("what_to_del").value; // table
                
                //-------------------------------
                // AJAX CHUNK
                var xmlhttp;

                // code for IE7+, Firefox, Chrome, Opera, Safari
                if (window.XMLHttpRequest) {
                    xmlhttp=new XMLHttpRequest();

                // code for IE6, IE5
                } else {
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }

                xmlhttp.onreadystatechange=function() {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                        document.getElementById("output_area").innerHTML=xmlhttp.responseText;
                    }
                }

                xmlhttp.open("GET","get_del_list.php?q1="+tbl,true);

                xmlhttp.send();
                // END OF AJAX CHUNK
                //-------------------------------
                
            }
            
            function delList() {
                
                var tbl = document.getElementById("what_to_del").value; // table
                //get all IDs to delete
                var checks = [];
                var boxes = document.getElementsByName('to_del_cell');
                for (var i=0;i<boxes.length;i++) {
                    if (boxes[i].checked) {
                        checks.push(boxes[i]);
                        console.log("checked of ID: "+boxes[i].value);
                     }
                }
                
                //-------------------------------
                // AJAX CHUNK
                var xmlhttp;

                // code for IE7+, Firefox, Chrome, Opera, Safari
                if (window.XMLHttpRequest) {
                    xmlhttp=new XMLHttpRequest();

                // code for IE6, IE5
                } else {
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }

                xmlhttp.onreadystatechange=function() {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                        document.getElementById("output_area").innerHTML=xmlhttp.responseText;
                    }
                }

                xmlhttp.open("GET","del_items.php?q1="+tbl+"&q2="+checks+"[]",true);

                xmlhttp.send();
                // END OF AJAX CHUNK
                //-------------------------------
                
            }
        
        </script>
        
    </head>
    <body>















        
        <!-- include side menu data -->
        <?php
            include "header.php";
        ?>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">
            
            <!-- show the side menu -->
            <script>
                open_menu();
            </script>
            
            <!-- get variables -->
            <?php
            
            //get picked tool
            $tool = "";
            if (isset($_GET['tool']))
                $tool = $_GET['tool'];
            
            //check tool
            if ($tool == "edit") {
                
                //...
                
            } else if ($tool == "add") {
                
                //...
                
            } else if ($tool == "srch") {
                
                //...
                
            } else if ($tool == "del") {
                
                //...
                
            }
            
            ?>
        
            <div class="my_center">
                <h2>
                    <div style="text-align: center;">
                        Account Tools:
                    </div>
                </h2>

                <div class="my_vpad"></div>
                <div class="my_vpad"></div>
                <div class="my_vpad"></div>
            </div>
            
            <!--
                   
                    Show Account Tools
                    
            -->
            <div id="data_area">
                
                
                
                
                <div id="edit_area" style="display:none">
            
                </div>
                
                <div id="add_area" style="display:none; text-align:center">
            
                    <h3>Add an iBoard Item:</h3>
                    
                    Pick an Item:
                    <select id="what_to_add" onchange=updateAdd()>
                        <option value="Group">Group</option>
                        <option value="Whiteboard">Whiteboard</option>
                    </select>
                    
                    <br><br>
                    
                    <div style="display:inline-block; position:relative;">
                        <table class="bigtbl" style="text-align:center;">
                            <tr>
                                <td style="text-align:center;padding:25px;">
                                Name:
                                <input id="add_input"
                                       type="text"
                                       name="add_input"
                                       value=""
                                       placeholder="New Item's Name..."/>
                                </td>
                            </tr>
                            <tr>
                                <td style="test-align:center; padding:50px">
                                    <button onclick="submitAdd()">CREATE</button>
                                </td>
                            </tr>
                        </table>
                    </div>
               
                    <script>
                        function updateAdd() {
                            var choice = document.getElementById('what_to_add').value;
                            var name = document.getElementById('add_input')
                            
                            if (choice=="Group") {
                                name.placeholder = "New Group's Name...";
                                name.value = "";
                            } else if (choice=="Whiteboard") {
                                name.placeholder = "New Whiteboard's Name...";
                                name.value = "";
                            }
                        }
                    </script>
                
                </div>
                
                <div id="srch_area" style="display:none">
                
                    <h3>Search iBoard Data Dump:</h3>
                    
                    Pick A Data Set:
                    <select id="search_from" onchange=getDrops()>
                        <option value="Accounts">Accounts</option>
                        <option value="Groups">Groups</option>
                        <option value="Whiteboards">Whiteboards</option>
                    </select>
                    
                    <br>
                    
                    (You can narrow your seach by choosing different parameters below)
                    <input id="user_input"
                           type="text"
                           list="browsers"
                           name="search_bar"
                           value=""
                           placeholder="Search..."
                           onkeyup=showData()/>
                    
                    <button onclick="showData()">SEARCH</button>

                    <br><br>

                    (search to apply) Search By:
                    <select id="search_by" onchange=showData()>
                        <?php   db_print_options($con,"ibr_accounts",array("Password","Activation_Code"));   ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    (search to apply) Sort By:
                    <select id="sort_by" onchange=showData()>
                        <?php   db_print_options($con,"ibr_accounts",array("Password","Activation_Code"));   ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    (search to apply) Records Per Page:
                    <select id="limit_by" onchange=showData()>
                      <option value="r10">10</option>
                      <option value="r20">20</option>
                      <option value="r50">50</option>
                      <option value="rall">All</option>
                    </select>
            
                </div>
                
                <div id="del_area" style="display:none; text-align:center;">
                
                    <h3>Delete an iBoard Item:</h3>
                    
                    <div style="display:inline-block; position:relative;">
                        <table class="bigtbl" style="text-align:center;">
                            <tr>
                                <td style="text-align:center;padding:25px;">
                                Pick A Data Set:
                                <select id="what_to_del" onchange=getDelList()>
                                    <option value="Groups">Groups</option>
                                    <option value="Whiteboards">Whiteboards</option>
                                </select>
                            </tr>
                            <tr>
                                <td style="test-align:center; padding:50px">
                                    <button onclick="delList()" style="background-color:red">DELETE</button>
                                </td>
                            </tr>
                        </table>
                    </div>
            
                </div>
                
                <div id="output_area">
                    
                </div>
                
                <!-- Script for controlling module visibility -->
                <script>
                    function moduleController ( tool="" ) {
                        document.getElementById('output_area').innerHTML = "";
                        if (tool == "edit"){
                            document.getElementById('edit_area').style.display = "block";
                            document.getElementById('add_area').style.display = "none";
                            document.getElementById('srch_area').style.display = "none";
                            document.getElementById('del_area').style.display = "none";
                        }                         
                        if (tool == "add"){
                            document.getElementById('add_area').style.display = "block";
                            document.getElementById('edit_area').style.display = "none";
                            document.getElementById('srch_area').style.display = "none";
                            document.getElementById('del_area').style.display = "none";
                        }                         
                        if (tool == "srch"){
                            document.getElementById('srch_area').style.display = "block";
                            document.getElementById('add_area').style.display = "none";
                            document.getElementById('edit_area').style.display = "none";
                            document.getElementById('del_area').style.display = "none";
                        }                         
                        if (tool == "del"){
                            document.getElementById('del_area').style.display = "block";
                            document.getElementById('add_area').style.display = "none";
                            document.getElementById('srch_area').style.display = "none";
                            document.getElementById('edit_area').style.display = "none";
                        }
                    }
                    
                    
                    //show correct module
                    moduleController( <?php echo $tool ?> );
                    
                </script>
                
                
                
                
                
            </div>

            <div class="my_vpad_great"></div>
            <div class="my_vpad_great"></div>
              
            <div style="text-align:center"> 
            All rights reserved. Copyright 2016. Licensed under CC by-sa 3.0 with attribution required.
            </div>
                
        </div>













    </body>
</html>