<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Student Grouping System</title>
    <link rel="stylesheet" href="kendoui/styles/kendo.common.min.css" />
    <link rel="stylesheet" href="kendoui/styles/kendo.default-v2.min.css" />
    <link rel="stylesheet" href="kendoui/styles/kendo.mobile.all.min.css" />
    <link rel="stylesheet" href="app.css" />
</head>

<body>
    <!-- view landing-->
    <div id="landing" data-role="view" data-layout="default_layout" data-transition="slide"
        data-after-show="page.refreshLanding">
        <div data-role="content">
            <div class="loader-wrapper" style="display:none">
                <div class="loader"></div>
            </div>
            <div style="text-align: center;margin-top: 80px;height: 100vh;">
                <img src="images/studentGroupingLogo.png" alt="Student Grouping System" width="128" height="128">
            </div>
        </div>
    </div>
    <!-- view login-->
    <div id="login" data-role="view" data-layout="default_layout" data-use-native-scrolling="true"
        data-transition="slide" style="background-image: url(images/bg.jpeg);background-size: cover;">
        <div data-role="content" style="display: flex;align-items: center;justify-content: center;">
            <main class="form-signin" style="width: 100%;max-width: 400px;padding: 15px;margin: auto;text-align: center;">
            <img style="margin-bottom: 1.5rem!important;" src="images/studentGroupingLogo.png" alt="" width="72" height="72">
            <h1 class="h3" style="margin-bottom: 1rem!important;">Student Grouping System</h1>
            <h1 class="h1" style="margin-bottom: 1rem!important;">Student\Teacher Login</h1>
                <form id="login_form">
                    <div class="row">
                        <div>
                            <input type="text" id="login_username" name="login_username" placeholder="Email address"
                                style="width: 300px;height: 60px;border: solid 1px #ccc;border-radius: 10px 10px 0 0;font-size: 18pt;text-indent: 5px;" />
                        </div>
                        <div>
                            <input type="password" id="login_password" name="login_password" placeholder="Password"
                                style="width: 300px;height: 60px;border: solid 1px #ccc;border-radius:0 0 10px 10px ;font-size: 18pt;text-indent: 5px;" />
                        </div>
                        <div>
                            <a data-click="page.login" data-role="button"
                                style="width: 300px;margin-top: 20px;background-color: #0d6efd;color: #fff;">L
                                O G I N</a>
                        </div>
                    </div>
                </form>
            </main>
        </div>
    </div>
    <!-- view register -->
    <div id="register" data-role="view" data-layout="register_layout" data-title="REGISTER"
        data-init="page.initRegister" data-after-show="page.refreshRegister" data-use-native-scrolling="true"
        data-transition="slide">
        <div data-role="content">
            <div style="margin-top:50px;padding-bottom: 20px;" class="roundbox1">
                <div style="text-align:center">
                    <div class="circle" style="background-color:#fe8e5f;min-width:120px;min-height:120px;">
                        <div class="material-icons textshadow"
                            style="font-size: 72px;color: #ffffff;position: relative;top: 14px;">person
                        </div>
                    </div>
                </div>
                <div
                    style="text-align:center;margin-top:20px;color:#333333;font-size:12.0pt;">
                    Register new user</div>
                <div style="text-align:center;color: #333333;font-size: 10.0pt;"></div>
                <div style="overflow-y: auto;max-height: 60vh;">
                    <form id="register_form">
                        <div style="text-align:left;margin-top:20px;margin-left:10px;width: 100%;padding-right: 20px;">
                            <div style="color: #333333;font-size: 8.0pt;">
                                F U L L&nbsp;&nbsp;N A M E</div>
                            <input type="text" id="register_fullname" name="register_fullname"
                                style="text-align:left;margin-top:10px;color: #333333;font-size: 18pt;width:100%;height: 46px;border: solid 1px #ccc;border-radius: 10px;text-indent: 5px;" />
                        </div>
                        <div style="text-align:left;margin-top:20px;margin-left:10px;width: 100%;padding-right: 20px;">
                            <div style="color: #333333;font-size: 8.0pt;">
                                U S E R N A M E</div>
                            <input type="text" id="register_username" name="register_username"
                                style="text-align:left;margin-top:10px;color: #333333;font-size: 18pt;width:100%;height: 46px;border: solid 1px #ccc;border-radius: 10px;text-indent: 5px;" />
                        </div>
                        <div style="text-align:left;margin-top:20px;margin-left:10px;width: 100%;padding-right: 20px;">
                            <div style="color: #333333;font-size: 8.0pt;">
                                S T U D E N T&nbsp;&nbsp;C O D E</div>
                            <input type="text" id="register_userCode" name="register_userCode"
                                style="text-align:left;margin-top:10px;color: #333333;font-size: 18pt;width:100%;height: 46px;border: solid 1px #ccc;border-radius: 10px;text-indent: 5px;" />
                        </div>
                        <div style="text-align:left;margin-top:20px;margin-left:10px;width: 100%;padding-right: 20px;">
                            <div style="color: #333333;font-size: 8.0pt;">
                                P A S S W O R D</div>
                            <input type="password" id="register_password" name="register_password"
                                style="text-align:left;margin-top:10px;color: #333333;font-size: 18pt;width:100%;height: 46px;border: solid 1px #ccc;border-radius: 10px;text-indent: 5px;" />
                        </div>
                        <div style="text-align:left;margin-top:20px;margin-left:10px;width: 100%;padding-right: 20px;">
                            <div style="color: #333333;font-size: 8.0pt;">
                                R E T Y P E&nbsp;&nbsp;P A S S W O R D</div>
                            <input type="password" id="register_repassword" name="register_repassword"
                                style="text-align:left;margin-top:10px;color: #333333;font-size: 18pt;width:100%;height: 46px;border: solid 1px #ccc;border-radius: 10px;text-indent: 5px;" />
                        </div>
                        <div style="text-align:left;margin-top:20px;margin-left:10px;width: 100%;padding-right: 20px;">
                            <div style="color: #333333;font-size: 8.0pt;">
                                E - M A I L</div>
                            <input type="email" id="register_email" name="register_email"
                                validationMessage="E-mail is not valid email format!"
                                style="text-align:left;margin-top:10px;color: #333333;font-size: 18pt;width:100%;height: 46px;border: solid 1px #ccc;border-radius: 10px;text-indent: 5px;" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div data-role="footer">
            <div style="margin-left:10px;width:100%;padding-right:20px;position:fixed;bottom:10px;">
                <a data-role="button" data-click="page.registerFormSubmit"
                    style="background-color:#282828;border-color:#282828;color:#fff;width:100%;">R E G I S T E R</a>
            </div>
        </div>
    </div>
    <!--/ view  ------------------------------------------------------------------------------------------------------>
    <!-- template -->
    <section data-role="layout" data-id="default_layout">
    </section>
    <!-- template -->
    <section data-role="layout" data-id="register_layout">
        <div data-role="header">
            <a href="#login"><i class="material-icons" style="position: fixed;left: 10px;top: 10px;">arrow_back</i></a>
            <div id="register_layout_title"
                style="position: fixed;top: 10px;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;color: #493D45;font-size: 14.0pt;;">
                &nbsp;</div>
        </div>
    </section>
    <!-- /template -->
    <script src="kendoui/js/jquery.min.js"></script>
    <script src="kendoui/js/kendo.all.min.js"></script>
    <script src="app.js"></script>
    <script>
    var app = new kendo.mobile.Application(document.body, {
            skin: "nova"
        }),
        page = new page();

    function page() {
        page.prototype.refreshLanding = function(e) {
            $('.loader-wrapper').show();
            setTimeout(function() {
                $('.loader-wrapper').hide();
                app.navigate('#login');
            }, 1000);
        }
        page.prototype.login = function() {
            ajax("app.php", "POST", "json", ({
                mode: 'login',
                login_username: $('#login_username').val(),
                login_password: $('#login_password').val()
            }), true, true, function(response) {
                if (response != false) {
                    redirect('main.php');
                } else {
                    kendo.alert('Username or Password is invlid!');
                }

            });
        }
    }
    </script>
</body>

</html>