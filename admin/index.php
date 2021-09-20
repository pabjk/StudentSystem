<?php
/*SERVER CODE*/
error_reporting(E_ALL); ini_set('display_errors', 1); 
session_start();
require_once('../function.php');
$db = new DataSourceResult();
if(isset($_POST) && !empty($_POST)):
/*BEGIN*/
switch($_POST['mode']):
    case 'checkLogin':
          $sql="select * from user where email=:inputEmail and status=1 and userTypeID=1";
          $param['inputEmail']=$_POST['inputEmail'];
          $user=$db->select($sql,$param);
          $passhashindb = substr($user['data'][0]['password'],0,32);
          $salt = substr($user['data'][0]['password'],32);
          $passhashinput = md5($_POST['inputPassword'].$salt);
          if($user['total']!=0 && $passhashindb == $passhashinput){
                $_SESSION['user'] = $user;
                $setting=json_decode($_SESSION[ 'user' ]['data'][0]['setting']);
                if(!empty($setting)){
                    $_SESSION['setting']['lang']=$setting->{'lang'};
                }else{
                    $_SESSION['setting']['lang']='en';
                }
              echo true;
          }else{
              unset($_SESSION['user']);
              echo false;
          }
        break;
endswitch;
/*END BEGIN*/
unset( $db );
exit();
endif;
/*END SERVER CODE*/
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Developer 3Spines">
    <meta name="author" content="3Spine">
    <meta name="generator" content="Hugo 0.80.0">
    <title>Student Grouping System | Sign in</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../kendoui/styles/kendo.common.min.css" rel="stylesheet" />
    <link href="../kendoui/styles/kendo.common-material.min.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet">
    <style>
    html,
    body {
        height: 100%;
        font-family: 'Prompt', sans-serif!important;
    }
    text{
        font-family: 'Prompt', sans-serif!important;
    }

    body {
        display: flex;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
    }

    .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
    }

    .form-signin .checkbox {
        font-weight: 400;
    }

    .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }

    .form-signin .form-control:focus {
        z-index: 2;
    }

    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    </style>
</head>

<body class="text-center" style="background-image: url(../images/bg.jpeg);background-size: cover;">
    <div class="loader-wrapper" style="display:none">
        <div class="loader"></div>
    </div>
    <main class="form-signin" >
        <form action="index.php" method="post" class="form-signin" id="form-signin" role="form">
            <img class="mb-4" src="../images/studentGroupingLogo.png" alt="" width="72" height="72">
            <h1 class="h3 mb-3 fw-normal">Student Grouping System</h1>
            <h1 class="h3 mb-3 fw-normal">Admin Login</h1>
            <label for="inputEmail" class="visually-hidden">Email address</label>
            <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address"
                required validationMessage="Please Enter valid email!" autofocus>
            <label for="inputPassword" class="visually-hidden">Password</label>
            <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password"
                required validationMessage="Please Enter password!">

            <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
        </form>
    </main>
    <script src="../kendoui/js/jquery.min.js"></script>
    <script src="../jquery.form.min.js"></script>
    <script src="../kendoui/js/kendo.all.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="function.js"></script>
    <script>
    var page = new page();
    $(function() {
        page.initial();
        page.eventhandle();
    });

    function page() {
        this.validator;
        this.options;
        page.prototype.initial = function() {
            page.validator = $('#form-signin').kendoValidator().data("kendoValidator");
        }
        page.prototype.eventhandle = function() {
            $('#form-signin').submit(function(e) {
                e.preventDefault();
                page.options = {
                    data: {
                        mode: 'checkLogin'
                    },
                    success: function(response) {
                        kendo.ui.progress($("#loader-wrapper"), false);
                        if ($.trim(response) == true) {
                            redirect('main.php');
                        } else {
                            kendo.alert('Email or Password is invalid!');
                        }
                    }
                }
                if (page.validator.validate()) {
                    kendo.ui.progress($("#loader-wrapper"), true);
                    $("#form-signin").ajaxSubmit(page.options);
                }
            });
        }
    }
    </script>

</body>

</html>