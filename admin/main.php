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
$mbti_cover_bg = json_decode(file_get_contents("../var.json"));

$sql="select * from assignment where groupTypeID='1'";
$voluntaryGroup=$db->select($sql);
$sql="select * from assignment where groupTypeID='2'";
$randomGroup=$db->select($sql);
$sql="select * from assignment where groupTypeID='3'";
$MBTIGroup=$db->select($sql);


$sql="SELECT COUNT(*)AS count,mbti FROM user WHERE userTypeID='3' GROUP BY mbti";
$mbtiCount=$db->select($sql);

$sql="SELECT COUNT(*) as assignmentAmount,ri.regisID,ri.courseID,ci.courseCode,ci.courseName,ri.userID,us.fullName,ri.classGroup,ri.year,ri.semester,ri.status 
FROM registration_information ri 
LEFT OUTER JOIN course_information ci on ri.courseID=ci.courseID 
LEFT OUTER JOIN user us on ri.userID=us.userID
INNER JOIN assignment ass ON ass.regisID=ri.regisID  
WHERE ri.year=YEAR(CURDATE()) GROUP BY ri.regisID ORDER BY assignmentAmount DESC LIMIT 10";
$assignmentAmount=$db->select($sql);

$sql="SELECT COUNT(*) AS discussionAmount,ri.regisID,ri.courseID,ci.courseCode,ci.courseName,ri.userID,us.fullName,ri.classGroup,ri.year,ri.semester,ri.status 
FROM registration_information ri 
LEFT OUTER JOIN course_information ci on ri.courseID=ci.courseID 
LEFT OUTER JOIN user us on ri.userID=us.userID
INNER JOIN assignment ass ON ass.regisID=ri.regisID 
INNER JOIN discussion di ON ass.assignID=di.assignID
WHERE ri.year=YEAR(CURDATE()) GROUP BY ass.assignID ORDER BY discussionAmount DESC LIMIT 10";
$discussionAmount=$db->select($sql);

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
    <meta name="description" content="3Spines">
    <meta name="author" content="3Spines">
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
                <div class="row row-cols-2">
                    <div class="col-md-4">
                        <div class="card mb-3 ">
                            <div class="card-header text-center bg-primary text-white fw-bold">
                                <div class="card-title"></div>
                                <?=$_SESSION['setting']['lang']=='en'?'Usage statistic':'สถิติการเข้าใช้งาน';?>
                            </div>
                            <div class="card-body bg-info text-white text-center">
                                <div class="row">
                                    <div class="col">
                                        <span class="material-icons" style="font-size:48px">account_circle</span>
                                        <div class="fw-bold">
                                            <?=$_SESSION['setting']['lang']=='en'?'Total: ':'รวม : ';?><?=$student_num['total']+$teacher_num['total']+$admin_num['total']?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div><?=$_SESSION['setting']['lang']=='en'?'Student':'นักศึกษา';?></div>
                                        <div class="fw-bold fs-3"><?=$student_num['total']?></div>

                                    </div>
                                    <div class="col">
                                        <div><?=$_SESSION['setting']['lang']=='en'?'Teacher':'อาจารย์';?></div>
                                        <div class="fw-bold fs-3"><?=$teacher_num['total']?></div>
                                    </div>
                                    <div class="col">
                                        <div><?=$_SESSION['setting']['lang']=='en'?'Administrator':'ผู้ดูแลระบบ';?>
                                        </div>
                                        <div class="fw-bold fs-3"><?=$admin_num['total']?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3 ">
                            <div class="card-body">
                                <div id="chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card ">
                            <div class="card-header text-center bg-primary text-white fw-bold">
                                <div class="card-title"></div>
                                <?=$_SESSION['setting']['lang']=='en'?'Number of students in each MBTI type':'จำนวนนักศึกษาในแต่ละประเภท MBTI';?>
                            </div>
                            <div class="card-body">
                                <div class="row row-cols-6 ">
                                    <?php foreach($mbti_cover_bg->cover_bg as $index=>$value):?>
                                    <?php
                                        $sql="select * from user where mbti='$value->type' and userTypeID='3'";
                                        $data=$db->select($sql);
                                 
                                            ?>
                                    <div class="card col mb-2">
                                        <img class="card-img-top" src="../images/<?=$value->introduction?>"
                                            class="img-fluid rounded-start" alt="<?=$value->introduction?>">
                                        <div class="card-body">
                                            <h5 class="card-title text-center"><?=$value->type?></h5>
                                            <p class="card-text text-center fs-3"><?=$data['total']?></p>
                                        </div>
                                    </div>
                                    <?php endforeach;?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card mb-3 ">
                            <div class="card-body">
                                <div id="bar-chart"></div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered caption-top">
                                <caption>
                                    <?=$_SESSION['setting']['lang']=='en'?'Show the top 10 subjects with the most assignments of the year ':'แสดง 10 ลำดับวิชาที่มีการมอบหมายงานมากที่ในสุดปี ';?><?=date("Y")?>
                                </caption>
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <?=$_SESSION['setting']['lang']=='en'?'Amount':'จำนวน';?>
                                        </th>
                                        <th scope="col">
                                            <?=$_SESSION['setting']['lang']=='en'?'Course Code':'รหัสวิชา';?></th>
                                        <th scope="col">
                                            <?=$_SESSION['setting']['lang']=='en'?'Course Name':'ชื่อวิชา';?></th>
                                        <th scope="col"><?=$_SESSION['setting']['lang']=='en'?'Instructor':'ผู้สอน';?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($assignmentAmount['data'] as $index=>$value):?>
                                    <tr>
                                        <th scope="row"><?=$value['assignmentAmount']?></th>
                                        <td><?=$value['courseCode']?></td>
                                        <td><?=$value['courseName']?></td>
                                        <td><?=$value['fullName']?></td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered caption-top">
                                <caption>
                                    <?=$_SESSION['setting']['lang']=='en'?'Showing the 10 most discussed subjects of the year ':'แสดง 10 ลำดับวิชาที่มีการหารือมากที่สุด ';?><?=date("Y")?>
                                </caption>
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <?=$_SESSION['setting']['lang']=='en'?'Amount':'จำนวน';?>
                                        </th>
                                        <th scope="col">
                                            <?=$_SESSION['setting']['lang']=='en'?'Course Code':'รหัสวิชา';?></th>
                                        <th scope="col">
                                            <?=$_SESSION['setting']['lang']=='en'?'Course Name':'ชื่อวิชา';?></th>
                                        <th scope="col"><?=$_SESSION['setting']['lang']=='en'?'Instructor':'ผู้สอน';?>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($discussionAmount['data'] as $index=>$value):?>
                                    <tr>
                                        <th scope="row"><?=$value['discussionAmount']?></th>
                                        <td><?=$value['courseCode']?></td>
                                        <td><?=$value['courseName']?></td>
                                        <td><?=$value['fullName']?></td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div> -->
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
        this.chat;
        this.barchat;
        page.prototype.initial = function() {
            page.chart = $("#chart").kendoChart({
                theme: 'material',
                title: {
                    text: "<?=$_SESSION['setting']['lang']=='en'?'A graph showing the proportion of redstone\n selection in each assignment.':'กราฟแสดงสัดส่วนของการเลือกจับกลุ่มในแต่ละการมอบหมายงาน';?>"
                },
                legend: {
                    position: "top"
                },
                seriesDefaults: {
                    labels: {
                        template: "#= category # - #= kendo.format('{0:P}', percentage)#",
                        position: "outsideEnd",
                        visible: true,
                        background: "transparent"
                    }
                },
                series: [{
                    type: "donut",
                    data: [{
                        category: "<?=$_SESSION['setting']['lang']=='en'?'Voluntary':'สมัครใจ';?>",
                        value: <?=$voluntaryGroup['total']?>
                    }, {
                        category: "<?=$_SESSION['setting']['lang']=='en'?'Random':'สุ่ม';?>",
                        value: <?=$randomGroup['total']?>
                    }, {
                        category: "<?=$_SESSION['setting']['lang']=='en'?'MBTI':'MBTI';?>",
                        value: <?=$MBTIGroup['total']?>
                    }, ]
                }],
                tooltip: {
                    visible: true,
                    template: "#= category # - #= kendo.format('{0:P}', percentage) #"
                }
            }).data('kendoChart');
            page.chart.options.series[0].labels.align = 'circle';


            page.barchat = $("#bar-chart").kendoChart({
                theme: 'material',
                title: {
                    text: "<?=$_SESSION['setting']['lang']=='en'?'Compare the number of students\n for each MBTI type.':'เปรียบเทียบจำนวนนักศึกษาในแต่ละ MBTI';?>"
                },
                legend: {
                    visible: false,
                },
                seriesDefaults: {
                    type: "column",
                    labels: {
                        template: "#= series.name #",
                        position: "outsideEnd",
                        visible: true,
                        background: "transparent"
                    }
                },
                series: [
                    <?php foreach($mbtiCount['data'] as $index=>$value):?> {
                        name: "<?=$value['mbti']?>",
                        data: "<?=$value['count']?>",

                    },
                    <?php endforeach;?>
                ],
                valueAxis: {

                    line: {
                        visible: false
                    },
                    minorGridLines: {
                        visible: true
                    },
                    labels: {
                        rotation: "auto"
                    }
                },
                tooltip: {
                    visible: true,
                    template: "#= series.name #: #= value #"
                }
            }).data('kendoChart');

        }
        page.prototype.eventhandle = function() {

        }
    }
    </script>
</body>

</html>