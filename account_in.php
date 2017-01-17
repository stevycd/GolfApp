<?php
    //Start the session
    session_start();
?> 

<!DOCTYPE HTML>

<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <link href='//fonts.googleapis.com/css?family=Coda' rel='stylesheet'>
        <link rel="stylesheet" href="css/account_in_style.css"/> 
<!--
        <link rel="icon" href="img/favicon.ico"/>
        <link rel="shortcut icon" href="img/favicon.ico"/>
        <link rel="apple-touch-icon" href="img/icon.fw.png"/>
-->
        <title>Golf Caddie</title>
    </head>
    <body background="img/background.jpg">
        <h1 align="center">Account</h1>
        <nav class="nav">
            <ul>
                <li class="settings">
                    <a id="set_btn">
                        <span class="icon"><i aria-hidden="true" class="icon-cogs"></i></span><span>Settings</span>
                    </a>
                </li>
                <form id="set_form" class="set_form" name="set_form" method="POST">
                    Change Name         <br><p id="name_err_msg" class="name_err_msg" style="display: none"></p>
                                            <input type="text" name="full_name" id="set_full_name" size="40" placeholder="New Name" required>
                                            <input type="button" name="conf_name" id="conf_name_btn" value="Confirm">
                    Change Password     <br><p id="pass_err_msg" class="pass_err_msg" style="display: none"></p>
                                            <input type="password" name="old_pass" id="old_pass" size="40" placeholder="Old Password" required>
                                            <input type="password" name="new_pass" id = "new_pass" size="40" placeholder="New Password" required> 
                                            <input type="button" name="conf_pass" id="conf_pass_btn" value="Confirm">
                    <input type="button" name="del_acc" id="del_acc_btn" value="Delete Account">
                </form>
                <li class="sign_out">
                    <a href="php/sign_out.php">
                        <span class="icon"><i aria-hidden="true" class="icon-exit"></i></span><span>Sign-out</span>
                    </a>
                </li>
                <li class="home">
                    <a href="index.php">
                        <span class="icon"><i aria-hidden="true" class="icon-home"></i></span><span>Home</span>
                    </a>
                </li>
            </ul>
        </nav>
    </body>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript">                
        document.getElementById('set_btn').onclick = function () {
            reset();            
            set_form.style.display = set_form.style.display === "block" ? "none" : "block";
        };
        var reset = function () {
            name_err_msg.style.display = "none";
            pass_err_msg.style.display = "none";
            
            set_full_name.value = "";
            old_pass.value = "";
            new_pass.value = "";
        };
        document.getElementById('conf_name_btn').onclick = function () {
            name_err_msg.style.display = "block";
            if($('#set_full_name').val() === ""){
                name_err_msg.style.color = "#e60000";
                name_err_msg.innerHTML = "New name must not be empty.";
            } else {
                $.post("php/change_name.php", { fullname: $('#set_full_name').val() },  
                    function(result) {  
                        if(result == 1) {
                            name_err_msg.style.color = "white";
                            name_err_msg.innerHTML = "Name change sucessful.";
                            set_full_name.value = "";
                            pass_err_msg.style.display = "none";
                        } else {
                            name_err_msg.style.color = "#e60000";
                            name_err_msg.innerHTML = "Name change failed.";
                        }
                    }); 
            }
        };
        document.getElementById('conf_pass_btn').onclick = function () {
            pass_err_msg.style.display = "block";
            if(old_pass.value === "" || new_pass.value === ""){
                pass_err_msg.style.color = "#e60000";
                pass_err_msg.innerHTML = "Password fields must not be empty.";
            } else {
                $.post("php/change_password.php", { old_password: old_pass.value, new_password: new_pass.value },  
                    function(result) {  
                        if(result == 1) {
                            pass_err_msg.style.color = "white";
                            pass_err_msg.innerHTML = "Password change sucessful.";
                            old_pass.value = "";
                            new_pass.value = "";
                            name_err_msg.style.display = "none";
                        } else {
                            pass_err_msg.style.color = "#e60000";
                            pass_err_msg.innerHTML = "Password change failed.";
                        }
                    }); 
            }
        };
        document.getElementById('del_acc_btn').onclick = function () {
            var confirmed = confirm("Are you sure you want to Delete your Account?");
            if(confirmed) {
                $.post("php/delete_account.php", 
                    function(result) {
                        if(result == 1) {
                            window.location = "index.php";
                        } else {
                            alert(result);
                        }
                    });
            }
        };
    </script>
</html>