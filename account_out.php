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
        <link rel="stylesheet" href="css/account_out_style.css"/> 
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
                <li class="register">
                    <a id="reg_btn">
                        <span class="icon"><i aria-hidden="true" class="icon-user-plus"></i></span><span>Register</span>
                    </a>
                </li>
                <form id="reg_form" class="reg_form" name="reg_form" method="POST">
                    Full Name               <br><input type="text" name="full_name" id="reg_full_name" size="40" required>
                    Email Address           <br><input type="text" name="email" id="reg_email" size="40" required>
                    Confirm Email Address   <br><input type="text" name="conf_email" id = "reg_conf_email" size="40" required> 
                    Password                <br><input type="password" name="pass" id="reg_pass" size="40" required>
                    Confirm Password        <br><input type="password" name="conf_pass" id="reg_conf_pass" size="40" required>
                    <p id="reg_msg" class="reg_msg" style="display: none"></p>
                    <input type="button" name="sign_up" id="sign_up_btn" value="Sign-up">
                </form>
                <li class="sign_in">
                    <a id="log_btn">
                        <span class="icon"><i aria-hidden="true" class="icon-enter"></i></span><span>Sign-in</span>
                    </a>
                </li>
                <form id="log_form" class="log_form" name="log_form" method="POST">
                    Email Address           <br><input type="text" name="email" id="log_email" size="40" required>
                    Password                <br><input type="password" name="pass" id="log_pass" size="40" required>
                    <p id="log_msg" class="log_msg" style="display: none"></p>
                    <input type="button" name="sign_in" id="sign_in_btn" value="Sign-in">
                </form>
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
        document.getElementById('reg_btn').onclick = function () {
            document.getElementById('log_form').style.display = "none";
            reset();
            var form = document.getElementById('reg_form');
            form.style.display = form.style.display === "block" ? "none" : "block";
        };
        document.getElementById('log_btn').onclick = function () {
            document.getElementById('reg_form').style.display = "none";
            reset();
            var form = document.getElementById('log_form');
            form.style.display = form.style.display === "block" ? "none" : "block";
        };
        var reset = function () {
            reg_msg.style.display = "none";
            log_msg.style.display = "none";
            document.getElementById('reg_pass').value = "";
            document.getElementById('reg_conf_pass').value = "";
            document.getElementById('log_pass').value = "";
        };
        
        document.getElementById('sign_up_btn').onclick = function () {
            if(validate()) {
                $.post("php/register.php", { fullname: $('#reg_full_name').val(), email: $('#reg_email').val(), password: document.getElementById('reg_pass').value },  
                    function(result) {  
                        if(result == 1) {
                            reset();
                            document.getElementById('reg_form').style.display = "none";
                            document.getElementById('log_form').style.display = "block";
                            document.getElementById('log_email').value = $('#reg_email').val();
                            
                            document.getElementById('reg_full_name').value = "";
                            document.getElementById('reg_email').value = "";
                            document.getElementById('reg_conf_email').value = "";  
                        } else if(result == 0) {
                            reset();
                            document.getElementById('err_msg').style.display = "block";
                            document.getElementById('err_msg').innerHTML = "Email is already in use.";
                        } else {
                            alert(result);
                        }
                    }); 
            }
        };
        var validate = function () {
            var fullname = $('#reg_full_name').val(),
                email = $('#reg_email').val(),
                conf_email = $('#reg_conf_email').val(),
                password = document.getElementById('reg_pass').value,
                conf_password = document.getElementById('reg_conf_pass').value;
              
            reg_msg.style.display = "block";
            if(fullname === "" || email === "" || conf_email === "" || password === "" || conf_password === ""){
                reg_msg.innerHTML = "All fields must be completed.";
                return false;
            }
            if(email !== conf_email) {
                reg_msg.innerHTML = "Emails entered do not match.";
                return false;
            }
            if(!email.includes("@")){
                reg_msg.innerHTML = "Email entered is the wrong format.";
                return false;
            }
            if(password !== conf_password) {
                reg_msg.innerHTML = "Passwords entered do not match.";
                return false;
            }
            reg_msg.style.display = "none";
            return true;
        };
        
        document.getElementById('sign_in_btn').onclick = function () {
            var email = $('#log_email').val(),
                password = document.getElementById('log_pass').value;           
            $.post("php/sign_in.php", { email: email, password: password },
                function(result) {
                    if(result == 1) {
                        window.location = "index.php";
                    } else {
                        reset();
                        log_msg.style.display = "block";
                        log_msg.innerHTML = "Wrong Email or Password. Try again.";
                    }
                });
        };
    </script>
</html>