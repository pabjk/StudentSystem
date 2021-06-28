<?php
/*SERVER CODE*/
session_start();
if ( !isset( $_SESSION[ 'user' ] ) || empty( $_SESSION[ 'user' ] ))header( "location:nopermission.php" );
require_once('../function.php');
$db = new DataSourceResult();
$sql="select * from user where userTypeID='1' and status='1'";
$admin_num=$db->select($sql);
$sql="select * from user where userTypeID='2' and status='1'";
$teacher_num=$db->select($sql);
$sql="select * from user where userTypeID='3' and status='1'";
$student_num=$db->select($sql);
if(isset($_POST) && !empty($_POST)):
/*BEGIN*/
switch($_POST['mode']):
endswitch;
/*END BEGIN*/
unset( $db );
exit();
endif;
/*END SERVER CODE*/
?>
<!doctype html>
<html lang="<?=$_SESSION['setting']['lang']?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Developer Mr.Vilerswat Noosaeng srel90@gmail.com 0840900050">
    <meta name="author" content="Vilerswat Noosaeng">
    <title>Student Grouping System | Sign in</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../kendoui/styles/kendo.common.min.css" rel="stylesheet" />
    <link href="../kendoui/styles/kendo.common-material.min.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet">
    <style>
    </style>
</head>

<body>
    <?php require_once('header.php');?>
    <div class="container-fluid">
        <div class="row">
            <?php require_once('nav.php');?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"><?=$_SESSION['setting']['lang']=='en'?'Dashboard':'แผงควบคุม';?></h1>

                </div>
                <div class="">
                <button type="button" class="btn btn-info">
                    <?=$_SESSION['setting']['lang']=='en'?'Number of administrators :':'จำนวนผู้ดูแลระบบ :';?> <span
                        class="badge bg-primary"><?=$admin_num['total']?></span>
                </button>
                </div>
                <div class="mt-1">
                <button type="button" class="btn btn-info">
                    <?=$_SESSION['setting']['lang']=='en'?'Number of teachers :':'จำนวนอาจารย์ :';?> <span
                        class="badge bg-primary"><?=$teacher_num['total']?></span>
                </button>
                </div>
                <div class="mt-1">
                <button type="button" class="btn btn-info">
                    <?=$_SESSION['setting']['lang']=='en'?'Number of students :':'จำนวนนักศึกษา :';?> <span
                        class="badge bg-primary"><?=$student_num['total']?></span>
                </button>
                </div>
            </main>
        </div>
    </div>
    <div class="loader-wrapper" style="display:none">
        <div class="loader"></div>
    </div>
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

        }
        page.prototype.eventhandle = function() {

        }
    }
    </script>
</body>

</html>