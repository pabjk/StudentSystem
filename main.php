<?php
session_start();
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("location:index.php");
}

if ((empty($_SESSION['user']['data'][0]['mbti']) || $_SESSION['user']['data'][0]['mbti'] == null) && !isset($_GET['mbti']) && $_SESSION['user']['data'][0]['userTypeID'] == 3) {
    header("location:main.php?mbti#mbti");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Student Grouping System</title>
    <link rel="stylesheet" href="kendoui/styles/kendo.common.min.css" />
    <link rel="stylesheet" href="kendoui/styles/kendo.default.min.css" />
    <link rel="stylesheet" href="kendoui/styles/kendo.mobile.all.min.css" />
    <link rel="stylesheet" href="app.css" />
</head>

<body>
    <!-- view main menu-->
    <div id="mainmenu" data-role="view" data-layout="mainmenu_layout"
        data-title="<?=$_SESSION['setting']['lang'] == 'en' ? 'MAIN MENU' : 'เมนูหลัก';?>" data-transition="slide">
        <div data-role="content" style="background-image: url(images/bg.jpeg);">
            <div style="margin-top:50px" class="roundbox1">
                <div style="float:left;font-size: 56px;color:#252838" class="material-icons">person</div>
                <div>
                    <div style="color: #493D45;font-size: 20.0pt;">
                        <?=$_SESSION['user']['data'][0]['fullName']?>
                    </div>
                    <div style="color: #493D45;font-size: 10.0pt;">
                        <?php if($_SESSION['user']['data'][0]['userTypeID']==3):?>
                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Code :' : 'รหัสนักศึกษา :';?>
                        <?=$_SESSION['user']['data'][0]['userCode']?>
                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Group :' : 'กลุ่มเรียน :';?>
                        <?=$_SESSION['user']['data'][0]['classGroup']?>
                        <?php else:?>
                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Code :' : 'รหัสอาจารย์ :';?>
                        <?=$_SESSION['user']['data'][0]['userCode']?>
                        <?php endif;?>
                    </div>

                </div>
            </div>
            <div
                style="margin-top:10px;margin-left:10px;color: #493D45;font-size: 14.0pt;;">
                <?=$_SESSION['setting']['lang'] == 'en' ? 'MAIN MENU' : 'เมนูหลัก';?></div>
            <?php if ($_SESSION['user']['data'][0]['userTypeID'] == 3): ?>
            <div style="margin-top:10px" class="roundbox1">
                <div class="divTable">
                    <div class="divTableBody">
                        <div class="divTableRow">
                            <div class="divTableCell" style="text-align:center">
                                <a href="#profile">
                                    <div class="circle"
                                        style="background-color:#252838;min-width:60px;min-height:60px;">
                                        <div class="material-icons textshadow"
                                            style="font-size: 32px;color: #ffffff;position: relative;top: 14px;">
                                            account_circle</div>
                                    </div>
                                    <div style="color: #493D45;font-size: 10.0pt;;">
                                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Profile' : 'ข้อมูลผู้ใช้';?>
                                    </div>
                                </a>
                            </div>
                            <div class="divTableCell">
                                <a href="#myAssignment">
                                    <div class="circle"
                                        style="background-color:#252838;min-width:60px;min-height:60px;">
                                        <div class="material-icons textshadow"
                                            style="font-size: 32px;color: #ffffff;position: relative;top: 14px;">
                                            assignment_turned_in</div>
                                    </div>
                                    <div style="color: #493D45;font-size: 10.0pt;;">
                                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Assignment' : 'มอบหมายงาน';?>
                                    </div>
                                </a>
                            </div>
                            <div class="divTableCell">
                                <a href="#evaluation">
                                    <div class="circle"
                                        style="background-color:#252838;min-width:60px;min-height:60px;">
                                        <div class="material-icons textshadow"
                                            style="font-size: 32px;color: #ffffff;position: relative;top: 14px;">
                                            live_help
                                        </div>
                                    </div>
                                    <div style="color: #493D45;font-size: 10.0pt;;">
                                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Evaluations' : 'การประเมิน';?>
                                    </div>
                                </a>
                            </div>
                            <!-- <div class="divTableCell">
                                <a href="#">
                                    <div class="circle"
                                        style="background-color:#252838;min-width:60px;min-height:60px;">
                                        <div class="material-icons textshadow"
                                            style="font-size: 32px;color: #ffffff;position: relative;top: 14px;">
                                            help_outline</div>
                                    </div>
                                    <div style="color: #493D45;font-size: 10.0pt;;">
                                        <?=$_SESSION['setting']['lang'] == 'en' ? 'My Evaluation' : 'ผลการประเมิน';?>
                                    </div>
                                </a>
                            </div> -->
                            <div class="divTableCell">
                                <a href="#mbti">
                                    <div class="circle"
                                        style="background-color:#252838;min-width:60px;min-height:60px;">
                                        <div class="material-icons textshadow"
                                            style="font-size: 32px;color: #ffffff;position: relative;top: 14px;">
                                            assignment
                                        </div>
                                    </div>
                                    <div style="color: #493D45;font-size: 10.0pt;;">mbti
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="divTableRow">
                            <!-- <div class="divTableCell">
                                <a href="#mbti">
                                    <div class="circle"
                                        style="background-color:#252838;min-width:60px;min-height:60px;">
                                        <div class="material-icons textshadow"
                                            style="font-size: 32px;color: #ffffff;position: relative;top: 14px;">
                                            assignment
                                        </div>
                                    </div>
                                    <div style="color: #493D45;font-size: 10.0pt;;">mbti
                                    </div>
                                </a>
                            </div> -->
                            <div class="divTableCell">
                                <a href="#discuss">
                                    <div class="circle"
                                        style="background-color:#252838;min-width:60px;min-height:60px;">
                                        <div class="material-icons textshadow"
                                            style="font-size: 32px;color: #ffffff;position: relative;top: 14px;">
                                            question_answer</div>
                                    </div>
                                    <div style="color: #493D45;font-size: 10.0pt;;">
                                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Discussion' : 'ช่องการสนทนา';?>
                                    </div>
                                </a>
                            </div>
                            <div class="divTableCell">
                                <a href="#setting">
                                    <div class="circle"
                                        style="background-color:#252838;min-width:60px;min-height:60px;">
                                        <div class="material-icons textshadow"
                                            style="font-size: 32px;color: #ffffff;position: relative;top: 14px;">
                                            settings
                                        </div>
                                    </div>
                                    <div style="color: #493D45;font-size: 10.0pt;;">
                                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Setting' : 'ตั้งค่า';?>
                                    </div>
                                </a>
                            </div>
                            <div class="divTableCell">
                                <a href="javascript:page.logout();">
                                    <div class="circle"
                                        style="background-color:#252838;min-width:60px;min-height:60px;">
                                        <div class="material-icons textshadow"
                                            style="font-size: 32px;color: #ffffff;position: relative;top: 14px;">
                                            exit_to_app
                                        </div>
                                    </div>
                                    <div style="color: #493D45;font-size: 10.0pt;;">
                                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Logout' : 'ออกจากระบบ';?>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- <div class="divTableRow">
                            <div class="divTableCell">
                                <ul id="switchLanguage" data-role="buttongroup" data-index="0">
                                    <li onclick="page.switchLanguage('en')">EN</li>
                                    <li onclick="page.switchLanguage('en')">TH</li>
                                </ul>
                            </div>

                        </div> -->
                    </div>
                </div>
            </div>
            <?php elseif ($_SESSION['user']['data'][0]['userTypeID'] == 2): ?>
            <div style="margin-top:10px" class="roundbox1">
                <div class="divTable">
                    <div class="divTableBody">
                        <div class="divTableRow">
                            <div class="divTableCell" style="text-align:center">
                                <a href="#profile">
                                    <div class="circle"
                                        style="background-color:#8b95ca;min-width:60px;min-height:60px;">
                                        <div class="material-icons textshadow"
                                            style="font-size: 32px;color: #ffffff;position: relative;top: 14px;">
                                            account_circle</div>
                                    </div>
                                    <div style="color: #493D45;font-size: 10.0pt;;">
                                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Profile' : 'ข้อมูลผู้ใช้';?>
                                    </div>
                                </a>
                            </div>
                            <div class="divTableCell">
                                <a href="#my_registration_information">
                                    <div class="circle"
                                        style="background-color:#8b95ca;min-width:60px;min-height:60px;">
                                        <div class="material-icons textshadow"
                                            style="font-size: 32px;color: #ffffff;position: relative;top: 14px;">
                                            assignment_turned_in</div>
                                    </div>
                                    <div style="color: #493D45;font-size: 10.0pt;;">
                                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Assignment' : 'มอบหมายงาน';?>
                                    </div>
                                </a>
                            </div>
                            <div class="divTableCell">
                                <a href="#my_registration_information_evaluation">
                                    <div class="circle"
                                        style="background-color:#8b95ca;min-width:60px;min-height:60px;">
                                        <div class="material-icons textshadow"
                                            style="font-size: 32px;color: #ffffff;position: relative;top: 14px;">
                                            live_help
                                        </div>
                                    </div>
                                    <div style="color: #493D45;font-size: 10.0pt;;">
                                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Evaluations' : 'การประเมิน';?>
                                    </div>
                                </a>
                            </div>
                            <div class="divTableCell">
                                <a href="#my_registration_information_discussion">
                                    <div class="circle"
                                        style="background-color:#8b95ca;min-width:60px;min-height:60px;">
                                        <div class="material-icons textshadow"
                                            style="font-size: 32px;color: #ffffff;position: relative;top: 14px;">
                                            question_answer</div>
                                    </div>
                                    <div style="color: #493D45;font-size: 10.0pt;;">
                                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Discussion' : 'ช่องการสนทนา';?>
                                    </div>
                                </a>
                            </div>

                        </div>

                        <div class="divTableRow">

                            <div class="divTableCell">
                                <a href="#setting">
                                    <div class="circle"
                                        style="background-color:#8b95ca;min-width:60px;min-height:60px;">
                                        <div class="material-icons textshadow"
                                            style="font-size: 32px;color: #ffffff;position: relative;top: 14px;">
                                            settings
                                        </div>
                                    </div>
                                    <div style="color: #493D45;font-size: 10.0pt;;">
                                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Setting' : 'ตั้งค่า';?>
                                    </div>
                                </a>
                            </div>
                            <div class="divTableCell">
                                <a href="javascript:page.logout();">
                                    <div class="circle"
                                        style="background-color:#8b95ca;min-width:60px;min-height:60px;">
                                        <div class="material-icons textshadow"
                                            style="font-size: 32px;color: #ffffff;position: relative;top: 14px;">
                                            exit_to_app
                                        </div>
                                    </div>
                                    <div style="color: #493D45;font-size: 10.0pt;;">
                                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Logout' : 'ออกจากระบบ';?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>
    <!-- view profile -->
    <div id="profile" data-role="view" data-layout="profile_layout" data-title="PROFILE"
        data-after-show="page.refreshProfile" data-transition="slide">
        <div data-role="content" style="background-image: url(images/bg.jpeg);">
            <div style="margin-top:50px;padding-bottom: 20px;" class="roundbox1">
                <div style="text-align:center">
                    <div class="circle" style="background-color:#fe8e5f;min-width:120px;min-height:120px;">
                        <div class="material-icons textshadow"
                            style="font-size: 72px;color: #ffffff;position: relative;top: 14px;">person</div>
                    </div>
                </div>
                <div
                    style="text-align:center;margin-top:20px;color: #333333;font-size: 12.0pt;">
                    <?=$_SESSION['user']['data'][0]['fullName']?></div>
                <div style="text-align:center;color: #333333;font-size: 10.0pt;">
                    <?=$_SESSION['setting']['lang'] == 'en' ? 'Code :' : 'รหัสนักศึกษา :';?>
                    <?=$_SESSION['user']['data'][0]['userCode']?>
                    <?=$_SESSION['setting']['lang'] == 'en' ? 'Group :' : 'กลุ่มเรียน :';?>
                    <?=$_SESSION['user']['data'][0]['classGroup']?>
                </div>

                <div style="overflow-y: auto;max-height: 60vh;">
                    <form id="profile_form">
                        <div style="text-align:left;margin-top:20px;margin-left:10px;padding-right: 20px;">
                            <div style="color: #333333;font-size: 10pt;">
                                <?=$_SESSION['setting']['lang'] == 'en' ? 'F U L L&nbsp;&nbsp;N A M E' : 'ชื่อ สกุล';?>
                            </div>
                            <input type="text" value="<?=$_SESSION['user']['data'][0]['fullName']?>"
                                id="profile_fullName"
                                style="text-align:left;margin-top:10px;color: #333333;font-size: 18pt;width:100%;height: 46px;border: solid 1px #ccc;border-radius: 10px;text-indent: 5px;" />
                        </div>
                        <div style="text-align:left;margin-top:20px;margin-left:10px;padding-right: 20px;">
                            <div style="color: #333333;font-size: 8.0pt;">
                                <?=$_SESSION['setting']['lang'] == 'en' ? 'U S E R&nbsp;&nbsp;C O D E' : 'รหัสนักศึกษา/รหัสอาจารย์';?>
                            </div>
                            <input type="text" value="<?=$_SESSION['user']['data'][0]['userCode']?>" readonly
                                style="text-align:left;margin-top:10px;color: #333333;font-size: 18pt;width:100%;height: 46px;border: solid 1px #ccc;border-radius: 10px;text-indent: 5px;" />
                        </div>
                        <div style="text-align:left;margin-top:20px;margin-left:10px;padding-right: 20px;">
                            <div style="color: #333333;font-size: 8.0pt;">
                                <?=$_SESSION['setting']['lang'] == 'en' ? 'E - M A I L' : 'อีเมล';?></div>
                            <input type="email" value="<?=$_SESSION['user']['data'][0]['email']?>" readonly
                                style="text-align:left;margin-top:10px;color: #333333;font-size: 18pt;width:100%;height: 46px;border: solid 1px #ccc;border-radius: 10px;text-indent: 5px;" />
                        </div>
                        <div style="text-align:left;margin-top:20px;margin-left:10px;padding-right: 20px;">
                            <div style="color: #333333;font-size: 8.0pt;">
                                <?=$_SESSION['setting']['lang'] == 'en' ? 'P A S S W O R D' : 'รหัสผ่าน';?></div>
                            <input type="password" id="profile_password" name="profile_password"
                                style="text-align:left;margin-top:10px;color: #333333;font-size: 18pt;width:100%;height: 46px;border: solid 1px #ccc;border-radius: 10px;text-indent: 5px;" />
                        </div>


                    </form>
                </div>
            </div>



        </div>

    </div>
    <!-- view myassignment -->
    <div id="myAssignment" data-role="view" data-layout="myassignment_layout" data-title="MY ASSIGNMENT"
        data-init="page.initMyAssignment" data-after-show="page.refreshMyAssignment" data-transition="slide">
        <ul id="filterable-listview-my-assignment"></ul>
    </div>
    <!-- view allassignment -->
    <div id="allAssignment" data-role="view" data-layout="allassignment_layout" data-title="ALL ASSIGNMENT"
        data-init="page.initAllAssignment" data-after-show="page.refreshAllAssignment" data-transition="slide">
        <ul id="filterable-listview-all-assignment"></ul>
    </div>
    <!-- view assignment detail -->
    <div id="assignmentDetail" data-role="view" data-layout="assignment_detail_layout" data-title="DETAIL"
        data-after-show="page.refreshAssignmentDetail" data-transition="slide">
        <div data-role="content" style="background-image: url(images/bg.jpeg);">
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">

                <h5 id="assignmentDetail_courseCode"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Course Name : </b>' : '<b>วิชา : </b>';?><span>#:courseCode# #:courseName#</span></h5>
                <p id="assignmentDetail_assignTitle"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Title : </b>' : '<b>หัวข้อ : </b>';?><span>#:assignTitle#</span></p>
                <p id="assignmentDetail_assignDate"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Assignment Date : </b>' : '<b>วันที่มอบหมาย : </b>';?><span>#:assignDate# #:semester#/#:year#</span></p>
                <p id="assignmentDetail_groupType"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Group Type : </b>' : '<b>ประเภทการจับกลุ่ม : </b>';?><span>#:groupType#</span></p>

            </div>
            <div
                style="margin-top:10px;margin-left:10px;color: #493D45;font-size: 14.0pt;;">
                <?=$_SESSION['setting']['lang'] == 'en' ? 'Team Member' : 'สมาชิกกลุ่ม';?> 
                <span id="assignmentDetail_groupNum">#:groupNum#</span></div>
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <ul data-role="listview" id="assignment_detail_teammember"></ul>
            </div>

        </div>

    </div>
    <!-- view pickup -->
    <div id="pickupTeam" data-role="view" data-layout="pickupTeam_layout" data-title="PICK UP TEAM"
        data-after-show="page.refreshPickupTeam" data-transition="slide">
        <div data-role="content" style="background-image: url(images/bg.jpeg);">
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <h5 id="pickupTeam_courseCode"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Course Name : </b>' : '<b>วิชา : </b>';?><span>#:courseCode# #:courseName#</span></h5>
                <p id="pickupTeam_assignTitle"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Title : </b>' : '<b>หัวข้อ : </b>';?><span>#:assignTitle#</span></p>
                <p id="pickupTeam_assignDescription"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Description : </b>' : '<b>รายละเอียด : </b>';?><span>#:assignDescription#</span></p>
                <p id="pickupTeam_assignDate"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Assignment Date : </b>' : '<b>วันที่มอบหมาย : </b>';?><span>#:assignDate# #:semester#/#:year#</span> </p>
                <p id="pickupTeam_deadline"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Time Out : </b>' : '<b>หมดเวลาจับกลุ่ม : </b>';?><span>#:deadline#</span></p>
                <p id="pickupTeam_numGroup"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Number of group : </b>' : '<b>จำนวนกลุ่ม : </b>';?><span>#:numGroup#</span>
                </p>


            </div>
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <div id="pickupTeam_group"></div>
            </div>
            <div
                style="margin-top:10px;margin-left:10px;color: #493D45;font-size: 14.0pt;;">
                <?=$_SESSION['setting']['lang'] == 'en' ? 'Avalaible Team' : 'เลือกกลุ่ม';?></div>
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1" id="pickupTeam_avalaible_group">

            </div>

        </div>

    </div>
    <!-- view pickup detail-->
    <div id="pickupTeamDetail" data-role="view" data-layout="pickupTeam_detail_layout" data-title="PICK UP TEAM"
        data-after-show="page.refreshPickupTeamDetail" data-transition="slide">
        <div data-role="content" style="background-image: url(images/bg.jpeg);">
            <div style="margin-top:10px;padding-bottom: 20px;overflow: hidden;" class="roundbox1">
                <div class="circle"
                    style="float:left;background-color:#252838;min-width:60px;min-height:60px;text-align:center">
                    <i class="material-icons"
                        style="font-size: 32px;color: #ffffff;position: relative;top: 14px;">group</i>
                </div>
                <div id="pickupTeamDetail_title" style="float: left;margin-left: 10px;">test</div>
            </div>

            <div
                style="margin-top:10px;margin-left:10px;color: #493D45;font-size: 14.0pt;;">
                <?=$_SESSION['setting']['lang'] == 'en' ? 'Team member' : 'สมาชิกกลุ่ม';?>
            </div>
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <ul data-role="listview" id="pickupTeam_detail_teammember"></ul>
            </div>
        </div>
    </div>
    <!-- view random -->
    <div id="randomTeam" data-role="view" data-layout="randomTeam_layout" data-title="RANDOM TEAM"
        data-after-show="page.refreshRandomTeam" data-transition="slide">
        <div data-role="content" style="background-image: url(images/bg.jpeg);">
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <h5 id="randomTeam_courseCode"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Course Name : </b>' : '<b>วิชา : </b>';?><span>#:courseCode# #:courseName#</span></h5>
                <p id="randomTeam_assignTitle"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Title : </b>' : '<b>หัวข้อ : </b>';?><span>#:assignTitle#</span></p>
                <p id="randomTeam_assignDescription"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Description : </b>' : '<b>รายละเอียด : </b>';?><span>#:assignDescription#</span></p>
                <p id="randomTeam_assignDate"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Assignment Date : </b>' : '<b>วันที่มอบหมาย : </b>';?><span>#:assignDate# #:semester#/#:year#</span></p>
                <p id="randomTeam_deadline"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Time Out : </b>' : '<b>หมดเวลาจับกลุ่ม : </b>';?><span>#:deadline#</span></p>
                <p id="randomTeam_numGroup"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Number of group : </b>' : '<b>จำนวนกลุ่ม : </b>';?><span>#:numGroup#</span>
                </p>

            </div>
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <div id="randomTeam_group"></div>
            </div>
            <div
                style="margin-top:10px;margin-left:10px;color: #493D45;font-size: 14.0pt;;">
                <?=$_SESSION['setting']['lang'] == 'en' ? 'Avalaible Team' : 'เลือกกลุ่ม';?></div>
            <div style="margin-top:10px;padding-bottom: 20px;text-align:center" class="roundbox1">

                <canvas id='canvas' width='330' height='450' class="the_wheel">Canvas not supported, use another
                    browser.</canvas>
                <h3 id="randomTeam_avalaible_group"></h3>
            </div>

        </div>

    </div>
    <!-- view MBTI Team -->
    <div id="MBTITeam" data-role="view" data-layout="MBTITeam_layout" data-title="MBTI TEAM"
        data-after-show="page.refreshMBTITeam" data-transition="slide">
        <div data-role="content" style="background-image: url(images/bg.jpeg);">
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <h5 id="MBTITeam_courseCode"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Course Name : </b>' : '<b>วิชา : </b>';?><span>#:courseCode# #:courseName#</span></h5>
                <p id="MBTITeam_assignTitle"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Title : </b>' : '<b>หัวข้อ : </b>';?><span>#:assignTitle#</span></p>
                <p id="MBTITeam_assignDescription"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Description : </b>' : '<b>รายละเอียด : </b>';?><span>#:assignDescription#</span></p>
                <p id="MBTITeam_assignDate"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Assignment Date : </b>' : '<b>วันที่มอบหมาย : </b>';?><span>#:assignDate# #:semester#/#:year#</span></p>
                <p id="MBTITeam_deadline"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Time Out : </b>' : '<b>หมดเวลาจับกลุ่ม : </b>';?><span>#:deadline#</span></p>
                <p id="MBTITeam_numGroup"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Number of group : </b>' : '<b>จำนวนกลุ่ม : </b>';?><span>#:numGroup#</span>
                </p>

            </div>
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <div id="MBTITeam_group"></div>
            </div>
        </div>
    </div>
    <!-- view discuss -->
    <div id="discuss" data-role="view" data-layout="discuss_layout" data-title="DISCUSSION"
        data-after-show="page.refreshDiscuss" data-transition="slide">
        <ul id="discuss-listview-my-assignment"></ul>
    </div>
    <!-- view discuss room -->
    <div id="discussroom" data-role="view" data-layout="discuss_room_layout" data-title="DISCUSSION ROOM"
        data-init="page.initDiscussRoom" data-after-show="page.refreshDiscussRoom" data-transition="slide">
        <div id="chatTitle"></div>
        <div id="chatDescription"></div>
        <div data-role="content" style="background-image: url(images/bg.jpeg);">

            <div class="chat-list"></div>

        </div>
        <div style="/* position: fixed; *//* height: 70px; */width: 100%;background-color: #F2F2F2;/* bottom: 0; */">
            <div class="divTable">
                <div class="divTableBody">
                    <div class="divTableRow">
                        <div class="divTableCell" style="width: 10%;vertical-align: middle;">
                            <div id="btn-photo" class="material-icons textshadow"
                                style="font-size: 32px;color: #fff;cursor:pointer;">photo_camera
                            </div>
                            <input name="photo" id="photo" type="file" accept="image/*" capture
                                style="display:none"><span class="name"></span>
                        </div>
                        <div class="divTableCell" style="width: 80%;vertical-align: middle;">
                            <input type="text" id="chat_input" placeholder="Type your message here..."
                                style="color: #333333;font-size: 16pt;;height: 40px;width: 100%;border: solid 1px #ccc;border-radius: 10px;text-indent: 5px;" />

                        </div>
                        <div class="divTableCell" style="width: 10%;vertical-align: middle;">
                            <div id="btn-send" class="material-icons textshadow"
                                style="font-size: 32px;color: #CBCBCB;cursor:pointer;">send
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div id="dialog"></div>
    </div>
    <!-- view mbti -->
    <div id="mbti" data-role="view" data-layout="mbti_layout" data-title="mbti" data-init="page.initMBTI"
        data-after-show="page.refreshMBTI" data-transition="slide">
        <div data-role="content" style="background-image: url(images/bg.jpeg);">
            <div id="mbti_cover_bg" style="margin-top:10px;text-align: center;background-image: url(images/analysts_Architect_INTJ_personality_header.svg);background-repeat: no-repeat;
        background-size: cover;background-position-y: center;opacity: 1;" class="roundbox1">
                <div
                    style="color: #493D45;font-size: 14.0pt;;margin-top: 116px;background-color: #ffffff;opacity: 0.8;">
                    <?=$_SESSION['setting']['lang'] == 'en' ? 'Your Personality Type is:' : 'บุคลิกภาพของคุณคือ';?>
                    <span id="mbti_type"
                        style="color: #493D45;font-size: 20.0pt;;">????</span>
                </div>
            </div>
            <div id="takethetest" 
                style="margin-top:10px;margin-left:10px;color: #493D45;font-size: 14.0pt;;">
                Take the Test</div>
            <div style="margin-top:10px" class="roundbox1">
                <form id="MBTIForm">
                    <ul data-role="listview" id="listview_mbti_question"></ul>
                </form>
            </div>
        </div>
    </div>
    <!-- view setting -->
    <div id="setting" data-role="view" data-layout="default_layout" data-title="SETTING"
        data-after-show="page.refreshSetting">
        <div data-role="content">
            <div style="margin-top:10px;padding-bottom: 20px;overflow-y: auto;max-height: 60vh;" class="roundbox1">
                <ul data-role="listview" data-style="inset" data-type="group">
                    <li>
                        <?=$_SESSION['setting']['lang'] == 'en' ? 'Switch language' : 'เปลี่ยนภาษา';?>
                        <ul>
                            <li>
                                <label>
                                    <input name="radio" type="radio"
                                        <?=$_SESSION['setting']['lang'] == 'en' ? 'checked="checked"' : ''?>
                                        onclick="page.switchLanguage('en')" />
                                    English
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input name="radio" type="radio"
                                        <?=$_SESSION['setting']['lang'] == 'th' ? 'checked="checked"' : ''?>
                                        onclick="page.switchLanguage('th')" />
                                    ภาษาไทย
                                </label>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- view evaluation -->
    <div id="evaluation" data-role="view" data-layout="evaluation_layout" data-title="EVALUATION"
        data-init="page.initEvaluation" data-after-show="page.refreshEvaluation" data-transition="slide">
        <ul id="evaluation-listview"></ul>
    </div>
    <!-- view evaluation detail -->
    <div id="evaluationDetail" data-role="view" data-layout="default_layout" data-title="EVALUATION DETAIL"
        data-after-show="page.refreshEvaluationDetail" data-transition="slide">
        <ul id="evaluation-detail-listview"></ul>
    </div>
    <!-- view evaluation check -->
    <div id="evaluationCheck" data-role="view" data-layout="evaluation_check_layout" data-title="EVALUATION CHECK"
        data-after-show="page.refreshEvaluationCheck" data-transition="slide">
        <div data-role="content" style="background-image: url(images/bg.jpeg);">
            <div id="evaluationCheck-title"
                style="text-align:center;margin-top:10px;margin-left:10px;color: #493D45;font-size: 14.0pt;;">
            </div>
            <div style="text-align:center;"><a id="btnEvaluationResult" data-role="button"
                    class="km-primary"><?=$_SESSION['setting']['lang'] == 'en' ? 'Evaluation result' : 'ผลการประเมิน';?></a>
            </div>
            <div style="margin-top:10px;" class="roundbox1">
                <form id="EvaluationForm">
                    <ul data-role="listview" id="listview_evaluation_question"></ul>
                </form>
            </div>
        </div>
    </div>
    <!-- view evaluation check -->
    <div id="evaluationResult" data-role="view" data-layout="default_layout" data-title="EVALUATION RESULT"
        data-after-show="page.refreshEvaluationResult" data-transition="slide">
        <div data-role="content" style="background-image: url(images/bg.jpeg);">
            <div id="evaluationResult-title"
                style="text-align:center;margin-top:10px;margin-left:10px;color: #493D45;font-size: 14.0pt;;">
            </div>
            <div
                style="text-align:center;margin-top:10px;margin-left:10px;color: #493D45;font-size: 14.0pt;;">
            </div>
            <div style="margin-top:10px;" class="roundbox1" id="evaluationResult-panel">

            </div>
        </div>
    </div>
    <!-- view registration information รายวิชาต่างๆที่อาจารย์ท่านนี้สอน-->
    <div id="my_registration_information" data-role="view" data-layout="registration_information_layout"
        data-title="REGISTRATION INFORMATION" data-after-show="page.refreshMyRegistrationInformation"
        data-transition="slide">
        <ul id="listview_my_registration_information"></ul>
    </div>
    <!-- view teacher assignment การมอบหมายงานต่างๆในแต่ละรายวิชา-->
    <div id="teacherAssignment" data-role="view" data-layout="teacher_assignment_layout" data-title="MY ASSIGNMENT"
        data-after-show="page.refreshTeacherAssignment" data-transition="slide">
        <ul id="listview_teacher_assignment"></ul>
    </div>
    <!-- view teacher assignment group กลุ่มทั้งหมดในแต่ละรายวิชา-->
    <div id="teacherAssignmentGroup" data-role="view" data-layout="teacher_assignment_group_layout"
        data-title="MY ASSIGNMENT GROUP" data-after-show="page.refreshTeacherAssignmentGroup" data-transition="slide">
        <div data-role="content" style="background-image: url(images/bg.jpeg);">
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <h5 id="teacherAssignmentGroup_courseCode"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Course Name : </b>' : '<b>วิชา : </b>';?><span>#:courseCode# #:courseName#</span></h5>
                <p id="teacherAssignmentGroup_assignTitle"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Title : </b>' : '<b>หัวข้อ : </b>';?><span>#:assignTitle#</span></p>
                <p id="teacherAssignmentGroup_assignDescription"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Description : </b>' : '<b>รายละเอียด : </b>';?><span>#:assignDescription#</span></p>
                <p id="teacherAssignmentGroup_assignDate"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Assignment Date : </b>' : '<b>วันที่มอบหมาย : </b>';?><span>#:assignDate# #:semester#/#:year#</span></p>
                <p id="teacherAssignmentGroup_deadline"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Time Out : </b>' : '<b>หมดเวลาจับกลุ่ม : </b>';?><span>#:deadline#</span></p>
                <p id="teacherAssignmentGroup_numGroup"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Number of group : </b>' : '<b>จำนวนกลุ่ม : </b>';?><span>#:numGroup#</span>
                </p>

            </div>
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <div id="teacherAssignmentGroupList"></div>
            </div>
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <div id="teacherAssignmentGroupListNonGroup"></div>
            </div>
        </div>
    </div>
    <!-- view registration information รายวิชาทั้งหมด-->
    <div id="all_registration_information" data-role="view" data-layout="all_registration_information_layout"
        data-title="All REGISTRATION INFORMATION" data-after-show="page.refreshAllRegistrationInformation"
        data-transition="slide">
        <ul id="listview_all_registration_information"></ul>
    </div>
    <!-- view teacher assignment detail สร้างการมอบหมายงาน-->
    <div id="teacherAssignmentDetail" data-role="view" data-layout="teacher_assignment_detail_layout"
        data-title="MAKE ASSIGNMENT " data-init="page.initTeacherAssignmentDetail"
        data-after-show="page.refreshTeacherAssignmentDetail" data-transition="slide">
        <div data-role="content" style="background-image: url(images/bg.jpeg);">
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <div id="teacherAssignmentDetailList"></div>
            </div>
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <form id="assignmentForm">
                
                    <ul data-role="listview" data-style="inset">
                        <li>
                            <label class="km-label-above"><?=$_SESSION['setting']['lang'] == 'en' ? 'Group type' : 'ประเภทการจับกลุ่ม';?><span style="color:red">*</span>
                                <select id="groupTypeID" required="required" validationMessage="<?=$_SESSION['setting']['lang'] == 'en' ? 'Please select group type' : 'กรุณาเลือกประเภทการจับกลุ่ม';?>"></select>
                            </label>
                        </li>
                        <li>
                            <label
                                class="km-label-above"><?=$_SESSION['setting']['lang'] == 'en' ? 'Number of group' : 'จำนวนกลุ่ม';?><span style="color:red">*</span>
                                <input type="number" id="numGroup" name="numGroup" value="1" min="1" required validationMessage="<?=$_SESSION['setting']['lang'] == 'en' ? 'Please enter number of group' : 'กรุณากรอกจำนวนกลุ่ม';?>">
                            </label>
                        </li>
                        <li>
                            <label
                                class="km-label-above "><?=$_SESSION['setting']['lang'] == 'en' ? 'Grouping start date' : 'วันที่เริ่มจับกลุ่ม';?><span style="color:red">*</span>
                                <input type="date" id="assignDate" name="assignDate" style="left:0" format="yyyy-mm-dd"
                                    required validationMessage="<?=$_SESSION['setting']['lang'] == 'en' ? 'Please enter assignment date' : 'กรุณากรอกวันที่มอบหมาย';?>">
                            </label>
                        </li>
                        <li>
                            <label
                                class="km-label-above "><?=$_SESSION['setting']['lang'] == 'en' ? 'Grouping start time' : 'เวลาที่เริ่มจับกลุ่ม';?><span style="color:red">*</span>
                                <input type="time" id="assignTime" name="assignTime" style="left:0" required validationMessage="<?=$_SESSION['setting']['lang'] == 'en' ? 'Please enter assignment time' : 'กรุณากรอกเวลามอบหมาย';?>">
                            </label>
                        </li>
                        <li>
                            <label
                                class="km-label-above "><?=$_SESSION['setting']['lang'] == 'en' ? 'Grouping end date' : 'วันที่สิ้นสุดจับกลุ่ม';?><span style="color:red">*</span>
                                <input type="date" id="deadline" name="deadline" style="left:0" required validationMessage="<?=$_SESSION['setting']['lang'] == 'en' ? 'Please enter deadline' : 'กรุณากรอกกำหนดส่ง';?>">
                            </label>
                        </li>
                        <li>
                            <label
                                class="km-label-above "><?=$_SESSION['setting']['lang'] == 'en' ? 'Grouping end time' : 'เวลาที่สิ้นสุดจับกลุ่ม';?><span style="color:red">*</span>
                                <input type="time" id="timeout" name="timeout" style="left:0" required validationMessage="<?=$_SESSION['setting']['lang'] == 'en' ? 'Please enter timeout' : 'กรุณากรอกหมดเวลา';?>">
                            </label>
                        </li>
                        <li>
                            <label
                                class="km-label-above "><?=$_SESSION['setting']['lang'] == 'en' ? 'Assignment Title' : 'หัวข้อการมอบหมายงาน';?><span style="color:red">*</span>
                                <input type="text" value="" id="assignTitle" name="assignTitle" required validationMessage="<?=$_SESSION['setting']['lang'] == 'en' ? 'Please enter assignment Title' : 'กรุณากรอกหัวข้อการมอบหมายงาน';?>"/>
                            </label>
                        </li>
                        <li>
                            <label
                                class="km-label-above"><?=$_SESSION['setting']['lang'] == 'en' ? 'Description' : 'รายละเอียดการมอบหมายงาน';?>
                                <textarea style="resize: none;left:0" id="assignDescription"
                                    name="assignDescription"></textarea>
                            </label>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
    <!-- view registration information discussion รายวิชาต่างๆที่อาจารย์ท่านนี้สอน-->
    <div id="my_registration_information_discussion" data-role="view"
        data-layout="registration_information_discussion_layout" data-title="REGISTRATION INFORMATION"
        data-after-show="page.refreshMyRegistrationInformationDiscussion" data-transition="slide">
        <ul id="listview_my_registration_information_discussion"></ul>
    </div>
    <!-- view teacher assignment discussion การมอบหมายงานต่างๆในแต่ละรายวิชา-->
    <div id="teacherAssignment_discussion" data-role="view" data-layout="teacher_assignment_layout"
        data-title="MY ASSIGNMENT" data-after-show="page.refreshTeacherAssignmentDiscussion" data-transition="slide">
        <ul id="listview_teacher_assignment_discussion"></ul>
    </div>
    <!-- view teacher assignment group discussion กลุ่มทั้งหมดในแต่ละรายวิชา-->
    <div id="teacherAssignmentGroupDiscussion" data-role="view" data-layout="teacher_assignment_group_layout"
        data-title="MY ASSIGNMENT GROUP" data-after-show="page.refreshTeacherAssignmentGroupDiscussion"
        data-transition="slide">
        <div data-role="content" style="background-image: url(images/bg.jpeg);">
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <h5 id="teacherAssignmentGroupDiscussion_courseCode"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Course Name : </b>' : '<b>วิชา : </b>';?><span>#:courseCode# #:courseName#</span></h5>
                <p id="teacherAssignmentGroupDiscussion_assignTitle"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Title : </b>' : '<b>หัวข้อ : </b>';?><span>#:assignTitle#</span></p>
                <p id="teacherAssignmentGroupDiscussion_assignDescription"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Description : </b>' : '<b>รายละเอียด : </b>';?><span>#:assignDescription#</span></p>
                <p id="teacherAssignmentGroupDiscussion_assignDate"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Assignment Date : </b>' : '<b>วันที่มอบหมาย : </b>';?><span>#:assignDate# #:semester#/#:year#</span></p>
                <p id="teacherAssignmentGroupDiscussion_deadline"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Time Out : </b>' : '<b>หมดเวลาจับกลุ่ม : </b>';?><span>#:deadline#</span></p>
                <p id="teacherAssignmentGroupDiscussion_numGroup"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Number of group : </b>' : '<b>จำนวนกลุ่ม : </b>';?><span>#:numGroup#</span>
                </p>

            </div>
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <div id="teacherAssignmentGroupDiscussionList"></div>
            </div>
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <div id="teacherAssignmentGroupDiscussionListNonGroup"></div>
            </div>
        </div>
    </div>
    <!-- view registration information Evaluation รายวิชาต่างๆที่อาจารย์ท่านนี้สอน-->
    <div id="my_registration_information_evaluation" data-role="view"
        data-layout="registration_information_evaluation_layout" data-title="REGISTRATION INFORMATION"
        data-after-show="page.refreshMyRegistrationInformationEvaluation" data-transition="slide">
        <ul id="listview_my_registration_information_evaluation"></ul>
    </div>
    <!-- view teacher assignment Evaluation การมอบหมายงานต่างๆในแต่ละรายวิชา-->
    <div id="teacherAssignment_evaluation" data-role="view" data-layout="teacher_assignment_layout"
        data-title="MY ASSIGNMENT" data-after-show="page.refreshTeacherAssignmentEvaluation" data-transition="slide">
        <ul id="listview_teacher_assignment_evaluation"></ul>
    </div>
    <!-- view teacher assignment group Evaluation กลุ่มทั้งหมดในแต่ละรายวิชา-->
    <div id="teacherAssignmentGroupEvaluation" data-role="view" data-layout="teacher_assignment_group_layout"
        data-title="MY ASSIGNMENT GROUP" data-after-show="page.refreshTeacherAssignmentGroupEvaluation"
        data-transition="slide">
        <div data-role="content" style="background-image: url(images/bg.jpeg);">
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <h5 id="teacherAssignmentGroupEvaluation_courseCode"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Course Name : </b>' : '<b>วิชา : </b>';?><span>#:courseCode# #:courseName#</span></h5>
                <p id="teacherAssignmentGroupEvaluation_assignTitle"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Title : </b>' : '<b>หัวข้อ : </b>';?><span>#:assignTitle#</span></p>
                <p id="teacherAssignmentGroupEvaluation_assignDescription"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Description : </b>' : '<b>รายละเอียด : </b>';?><span>#:assignDescription#</span></p>
                <p id="teacherAssignmentGroupEvaluation_assignDate"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Assignment Date : </b>' : '<b>วันที่มอบหมาย : </b>';?><span>#:assignDate# #:semester#/#:year#</span></p>
                <p id="teacherAssignmentGroupEvaluation_deadline"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Time Out : </b>' : '<b>หมดเวลาจับกลุ่ม : </b>';?><span>#:deadline#</span></p>
                <p id="teacherAssignmentGroupEvaluation_numGroup"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Number of group : </b>' : '<b>จำนวนกลุ่ม : </b>';?><span>#:numGroup#</span>
                </p>

            </div>
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <div id="teacherAssignmentGroupEvaluationList"></div>
            </div>
            <div style="margin-top:10px;padding-bottom: 20px;" class="roundbox1">
                <div id="teacherAssignmentGroupEvaluationListNonGroup"></div>
            </div>
        </div>
    </div>
    <!--/ view  ------------------------------------------------------------------------------------------------------>
    <!-- template -->
    <section data-role="layout" data-id="default_layout">
        <div data-role="header">
            <div data-role="navbar">
                <a data-role="backbutton" data-align="left"></a>
                <div id="default_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="#mainmenu"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">home</i></a>
            </div>
        </div>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="MBTITeam_layout">
        <div data-role="header">
            <div data-role="navbar">
                <a data-role="backbutton" data-align="left"></a>
                <div id="MBTITeam_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="#mainmenu"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">home</i></a>
            </div>
        </div>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="pickupTeam_layout">
        <div data-role="header">
            <div data-role="navbar">
                <a data-role="backbutton" data-align="left"></a>
                <div id="pickupTeam_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="#mainmenu"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">home</i></a>
            </div>
        </div>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="randomTeam_layout">
        <div data-role="header">
            <div data-role="navbar">
                <a data-role="backbutton" data-align="left"></a>
                <div id="randomTeam_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="#mainmenu"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">home</i></a>
            </div>
        </div>
        <div data-role="footer">
            <button data-role="button" id="spin_button" onclick="page.startSpin()"
                style="background-color: #282828;border-color: #282828;color: #fff;width: 100%;">
                <?=$_SESSION['setting']['lang'] == 'en' ? 'S P I N' : 'หมุน';?></button>
        </div>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="pickupTeam_detail_layout">
        <div data-role="header">
            <div data-role="navbar">
                <a data-role="backbutton" data-align="left"></a>
                <div id="pickupTeam_detail_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="#mainmenu"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">home</i></a>
            </div>
        </div>
        <div data-role="footer">
            <button data-role="button" id="btnPickupTeamApply" onclick="page.pickupTeamApply()"
                style="background-color: #282828;border-color: #282828;color: #fff;width: 100%;">
                <?=$_SESSION['setting']['lang'] == 'en' ? 'A P P L Y' : 'สมัครร่วมกลุ่ม';?></button>
        </div>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="mainmenu_layout">
        <div data-role="header">
            <div>
                <img style="position:fixed;left:10px;top:10px;" src="images/studentGroupingLogo.png"
                    alt="Student Grouping System" width="32">
                <div
                    style="position: fixed;top: 10px;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;color: #493D45;font-size: 16.0pt;;">
                    Student Grouping System</div>

                <a href="javascript:page.logout();">
                    <div class="material-icons" style="position: fixed;right: 10px;top: 10px;">exit_to_app</div>
                </a>
            </div>
        </div>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="profile_layout">
        <div data-role="header">
            <div data-role="navbar">
                <a data-role="backbutton" data-align="left"></a>
                <div id="profile_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="javascript:page.logout();"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">exit_to_app</i></a>
            </div>
        </div>
        <div data-role="footer">
            <button data-role="button" id="btnUpdateProfile"
                style="background-color: #282828;border-color: #282828;color: #fff;width: 100%;">
                <?=$_SESSION['setting']['lang'] == 'en' ? 'U P D A T E' : 'บันทึก';?></button>
        </div>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="assignment_detail_layout">
        <div data-role="header">
            <div data-role="navbar">
                <a data-role="backbutton" data-align="left"></a>
                <div id="assignment_detail_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="#mainmenu"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">home</i></a>
            </div>
        </div>
        <div data-role="footer">
            <button data-role="button" onclick="page.updateGroupInformation()"
                style="background-color: #282828;border-color: #282828;color: #fff;width: 100%;">
                <?=$_SESSION['setting']['lang'] == 'en' ? 'U P D A T E' : 'บันทึก';?></button>
        </div>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="myassignment_layout">
        <header data-role="header">
            <div data-role="navbar">
                <a href="#mainmenu" data-role="backbutton" data-align="left"></a>
                <div id="myassignment_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="javascript:page.logout();"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">exit_to_app</i></a>
            </div>
            <div data-role="tabstrip">
                <a href="#myAssignment"
                    data-icon="assignment_turned_in"><?=$_SESSION['setting']['lang'] == 'en' ? 'My Assignment' : 'การมอบหมายงานของฉัน';?></a>
                <a href="#allAssignment"
                    data-icon="assignment_turned_in"><?=$_SESSION['setting']['lang'] == 'en' ? 'ALL Assignment' : 'การมอบหมายงานทั้งหมด';?></a>
            </div>
            <input type="search" placeholder="<?=$_SESSION['setting']['lang'] == 'en' ? 'Search...' : 'ค้นหา...';?>"
                class="k-textbox" onkeyup="javascript:page.searchMyAssignment(this.value);"
                style="width:100%;height:32px" />
        </header>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="allassignment_layout">
        <header data-role="header">
            <div data-role="navbar">
                <a href="#mainmenu" data-role="backbutton" data-align="left"></a>
                <div id="allassignment_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="javascript:page.logout();"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">exit_to_app</i></a>
            </div>
            <div data-role="tabstrip">
                <a href="#myAssignment"
                    data-icon="assignment_turned_in"><?=$_SESSION['setting']['lang'] == 'en' ? 'My Assignment' : 'การมอบหมายงานของฉัน';?></a>
                <a href="#allAssignment"
                    data-icon="assignment_turned_in"><?=$_SESSION['setting']['lang'] == 'en' ? 'ALL Assignment' : 'การมอบหมายงานทั้งหมด';?></a>
            </div>
            <input type="search" placeholder="<?=$_SESSION['setting']['lang'] == 'en' ? 'Search...' : 'ค้นหา...';?>"
                class="k-textbox" onkeyup="javascript:page.searchAllAssignment(this.value);"
                style="width:100%;height:32px" />
        </header>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="discuss_layout">
        <div data-role="header">
            <div data-role="navbar">
                <a data-role="backbutton" data-align="left"></a>
                <div id="discuss_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="javascript:page.logout();"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">exit_to_app</i></a>
            </div>
            <input type="search" placeholder="<?=$_SESSION['setting']['lang'] == 'en' ? 'Search...' : 'ค้นหา...';?>"
                class="k-textbox" onkeyup="javascript:page.searchMyAssignment(this.value);"
                style="width:100%;height:32px" />
        </div>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="discuss_room_layout">
        <div data-role="header">
            <div data-role="navbar">
                <a data-role="backbutton" data-align="left"></a>
                <div id="discuss_room_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="javascript:page.logout();"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">exit_to_app</i></a>
            </div>
        </div>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="mbti_layout">
        <div data-role="header">
            <div data-role="navbar">
                <a data-role="backbutton" data-align="left"></a>
                <div id="mbti_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="javascript:page.logout();"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">exit_to_app</i></a>
            </div>
        </div>
        <div data-role="footer">
            <button data-role="button" id="btnUpdateMBTI"
                style="background-color: #282828;border-color: #282828;color: #fff;width: 100%;">
                <?=$_SESSION['setting']['lang'] == 'en' ? 'U P D A T E' : 'บันทึก';?></button>
        </div>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="evaluation_layout">
        <header data-role="header">
            <div data-role="navbar">
                <a href="#mainmenu" data-role="backbutton" data-align="left"></a>
                <div id="evaluation_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="javascript:page.logout();"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">exit_to_app</i></a>
            </div>
            <input type="search" placeholder="<?=$_SESSION['setting']['lang'] == 'en' ? 'Search...' : 'ค้นหา...';?>"
                class="k-textbox" onkeyup="javascript:page.searchEvaluation(this.value);"
                style="width:100%;height:32px" />
        </header>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="evaluation_check_layout">
        <div data-role="header">
            <div data-role="navbar">
                <a data-role="backbutton" data-align="left"></a>
                <div id="evaluation_check_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="#mainmenu"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">home</i></a>
            </div>
        </div>
        <div data-role="footer">
            <button data-role="button" id="btnUpdateEvaluation"
                style="background-color: #282828;border-color: #282828;color: #fff;width: 100%;">
                <?=$_SESSION['setting']['lang'] == 'en' ? 'U P D A T E' : 'บันทึก';?></button>
        </div>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="registration_information_layout">
        <header data-role="header">
            <div data-role="navbar">
                <a href="#mainmenu" data-role="backbutton" data-align="left"></a>
                <div id="registration_information_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="javascript:page.logout();"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">exit_to_app</i></a>
            </div>
            <div data-role="tabstrip">
                <a href="#my_registration_information"
                    data-icon="assignment_turned_in"><?=$_SESSION['setting']['lang'] == 'en' ? 'My Assignment' : 'การมอบหมายงานของฉัน';?></a>
                <a href="#all_registration_information"
                    data-icon="assignment_turned_in"><?=$_SESSION['setting']['lang'] == 'en' ? 'ALL Course Information' : 'รายวิชาทั้งหมด';?></a>
            </div>
            <input type="search" placeholder="<?=$_SESSION['setting']['lang'] == 'en' ? 'Search...' : 'ค้นหา...';?>"
                class="k-textbox" onkeyup="javascript:page.searchMyRegistrationInformation(this.value);"
                style="width:100%;height:32px" />
        </header>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="registration_information_discussion_layout">
        <header data-role="header">
            <div data-role="navbar">
                <a href="#mainmenu" data-role="backbutton" data-align="left"></a>
                <div id="registration_information_discussion_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="javascript:page.logout();"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">exit_to_app</i></a>
            </div>
            <input type="search" placeholder="<?=$_SESSION['setting']['lang'] == 'en' ? 'Search...' : 'ค้นหา...';?>"
                class="k-textbox" onkeyup="javascript:page.searchMyRegistrationInformationDiscussion(this.value);"
                style="width:100%;height:32px" />
        </header>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="all_registration_information_layout">
        <header data-role="header">
            <div data-role="navbar">
                <a href="#mainmenu" data-role="backbutton" data-align="left"></a>
                <div id="all_registration_information_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="javascript:page.logout();"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">exit_to_app</i></a>
            </div>
            <div data-role="tabstrip">
                <a href="#my_registration_information"
                    data-icon="assignment_turned_in"><?=$_SESSION['setting']['lang'] == 'en' ? 'My Assignment' : 'การมอบหมายงานของฉัน';?></a>
                <a href="#all_registration_information"
                    data-icon="assignment_turned_in"><?=$_SESSION['setting']['lang'] == 'en' ? 'ALL Course Information' : 'รายวิชาทั้งหมด';?></a>
            </div>
            <input type="search" placeholder="<?=$_SESSION['setting']['lang'] == 'en' ? 'Search...' : 'ค้นหา...';?>"
                class="k-textbox" onkeyup="javascript:page.searchAllRegistrationInformation(this.value);"
                style="width:100%;height:32px" />
        </header>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="teacher_assignment_layout">
        <div data-role="header">
            <div data-role="navbar">
                <a data-role="backbutton" data-align="left"></a>
                <div id="teacher_assignment_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="#mainmenu"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">home</i></a>
            </div>
        </div>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="teacher_assignment_group_layout">
        <div data-role="header">
            <div data-role="navbar">
                <a data-role="backbutton" data-align="left"></a>
                <div id="teacher_assignment_group_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="#mainmenu"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">home</i></a>
            </div>
        </div>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="teacher_assignment_detail_layout">
        <div data-role="header">
            <div data-role="navbar">
                <a data-role="backbutton" data-align="left"></a>
                <div id="teacher_assignment_detail_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="#mainmenu"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">home</i></a>
            </div>
        </div>
        <div data-role="footer">
            <button data-role="button" id="btnUpdateAssignment"
                style="background-color: #282828;border-color: #282828;color: #fff;width: 100%;">
                <?=$_SESSION['setting']['lang'] == 'en' ? 'SAVE ASSIGNMENTS' : 'บันทึกมอบหมาย';?></button>
        </div>
    </section>
    <!-- template -->
    <section data-role="layout" data-id="registration_information_evaluation_layout">
        <header data-role="header">
            <div data-role="navbar">
                <a href="#mainmenu" data-role="backbutton" data-align="left"></a>
                <div id="registration_information_evaluation_layout_title"
                    style="position: fixed;top: 0;left: 50%;-webkit-transform: translate(-50%, 0);transform: translate(-50%, 0);width: fit-content;font-size: 14.0pt;;">
                    &nbsp;</div>
                <a href="javascript:page.logout();"><i class="material-icons"
                        style="position: fixed;right: 10px;top: 10px;">exit_to_app</i></a>
            </div>
            <input type="search" placeholder="<?=$_SESSION['setting']['lang'] == 'en' ? 'Search...' : 'ค้นหา...';?>"
                class="k-textbox" onkeyup="javascript:page.searchMyRegistrationInformationEvaluation(this.value);"
                style="width:100%;height:32px" />
        </header>
    </section>
    <!-- /template -->
    <script type="text/x-kendo-tmpl" id="filterable-listview-my-assignment-template">
        <a class="km-listview-link">
            <h5>#:courseCode# #:courseName#</h5>
            <p id="assignmentDetail_assignTitle"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Title : </b>' : '<b>หัวข้อ : </b>';?><span>#:assignTitle#</span></p>
            <p id="assignmentDetail_assignDate"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Assignment Date : </b>' : '<b>วันที่มอบหมาย : </b>';?><span>#:assignDate# #:semester#/#:year#</span></p>
            <p>#:groupType# <?=$_SESSION['setting']['lang'] == 'en' ? ' Group: ' : 'กลุ่มที่ : ';?> #:groupNum#</p>
        </a>
    </script>
    <script type="text/x-kendo-tmpl" id="filterable-listview-all-assignment-template">
        <a class="km-listview-link">
            <h5>#:courseCode# #:courseName#</h5>
            <p id="assignmentDetail_assignTitle"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Title : </b>' : '<b>หัวข้อ : </b>';?><span>#:assignTitle#</span></p>
            <p id="assignmentDetail_assignDate"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Assignment Date : </b>' : '<b>วันที่มอบหมาย : </b>';?><span>#:assignDate# #:semester#/#:year#</span></p>
            <p>#:groupType#</p>
        </a>
    </script>
    <script type="text/x-kendo-tmpl" id="listview-mbti-question-template">
        <h3>#:questionNo# #:question# </h3>
        <div class="divTable">
        <div class="divTableBody">
        <div class="divTableRow">
        <div class="divTableCell" style="width: 1%;"><input type="radio" name="answer#:questionID#" id="choiceA#:questionID#" value="a" required /></div>
        <div class="divTableCell" style="width: 99%;font-size: 14px;vertical-align: top;text-align: left;">#:choiceA#</div>
        </div>
        <div class="divTableRow">
        <div class="divTableCell" style="width: 1%;"><input type="radio" name="answer#:questionID#" id="choiceB#:questionID#" value="b" required /></div>
        <div class="divTableCell" style="width: 99%;font-size: 14px;vertical-align: top;text-align: left;">#:choiceB#</div>
        </div>
        </div>
        </div>
    </script>
    <script type="text/x-kendo-tmpl" id="evaluation-listview-template">
        <a class="km-listview-link">
            <h5>#:courseCode# #:courseName#</h5>
            <p>#:assignTitle#</p>
            <p>#:assignDate# #:semester#/#:year# </p>
            <p>#:groupType# <?=$_SESSION['setting']['lang'] == 'en' ? ' Group: ' : 'กลุ่มที่ : ';?> #:groupNum#</p>
        </a>
    </script>
    <script type="text/x-kendo-tmpl" id="evaluation-detail-listview-template">
        <a class="km-listview-link">
            <div>#:fullName#</div>
            <small>#:responsibility#</small
        </a>
    </script>
    <script type="text/x-kendo-tmpl" id="listview-evaluation-question-template">
        <h3>#:questionNo# #:question# </h3>
        #if(questionNo==6){#

            <fieldset>
                    <textarea id="ev_answer6" style="height: 100px;border: solid 1px;margin-top: 20px;"></textarea>
                </fieldset>
        #}else{#
        <div class="divTable">
            <div class="divTableBody">
                <div class="divTableRow">
                    <div class="divTableCell" style="font-size:14px;">ปรับปรุง</div>
                    <div class="divTableCell" style="font-size:14px;">ไม่พอใจ</div>
                    <div class="divTableCell" style="font-size:14px;">พอใจ</div>
                    <div class="divTableCell" style="font-size:14px;">พอใจมาก</div>
                    <div class="divTableCell" style="font-size:14px;">ดีเด่น</div>
                </div>
                <div class="divTableRow">
                    <div class="divTableCell"><input type="radio" name="ev_answer#:questionID#" id="choice1_#:questionID#" value="0" required /></div>
                    <div class="divTableCell"><input type="radio" name="ev_answer#:questionID#" id="choice2_#:questionID#" value="1" required /></div>
                    <div class="divTableCell"><input type="radio" name="ev_answer#:questionID#" id="choice3_#:questionID#" value="2" required /></div>
                    <div class="divTableCell"><input type="radio" name="ev_answer#:questionID#" id="choice4_#:questionID#" value="3" required /></div>
                    <div class="divTableCell"><input type="radio" name="ev_answer#:questionID#" id="choice5_#:questionID#" value="4" required /></div>
                </div>

            </div>
        </div>
        #}#
    </script>
    <script type="text/x-kendo-tmpl" id="listview_my_registration_information_template">
        <a class="km-listview-link">
            <h5>#:courseCode# #:courseName#</h5>
            <p><?=$_SESSION['setting']['lang'] == 'en' ? 'Section : ' : 'กลุ่มเรียน : ';?>#:classGroup# #:semester#/#:year#</p>
        </a>
    </script>
    <script type="text/x-kendo-tmpl" id="listview_all_registration_information_template">
        <a class="km-listview-link">
            <h5>#:courseCode# #:courseName#</h5>
            <p><?=$_SESSION['setting']['lang'] == 'en' ? 'Section : ' : 'กลุ่มเรียน : ';?>#:classGroup# #:semester#/#:year#</p>
        </a>
    </script>
    <script type="text/x-kendo-tmpl" id="listview_teacher_assignment_template">
        <a class="km-listview-link">
            <h5>#:courseCode# #:courseName#</h5>
            <p id="teacherAssignmentGroup_assignTitle"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Title : </b>' : '<b>หัวข้อ : </b>';?><span>#:assignTitle#</span></p>
            <p id="teacherAssignmentGroup_assignDate"><?=$_SESSION['setting']['lang'] == 'en' ? '<b>Assignment Date : </b>' : '<b>วันที่มอบหมาย : </b>';?><span>#:assignDate# #:semester#/#:year#</span></p>
            <p>#:groupType#</p>
        </a>
    </script>

    <script src="kendoui/js/jquery.min.js"></script>
    <script src="kendoui/js/kendo.all.min.js"></script>
    <script src="Winwheel.min.js"></script>
    <script src="TweenMax.min.js"></script>
    <script src="app.js"></script>
    <script>
    var app = new kendo.mobile.Application(document.body, {
            skin: "nova",
            hideAddressBar: true,
            initial: '#mainmenu'
        }),
        page = new page();

    function page() {
        this.mbti_cover_bg;
        this.myAssignmentDataSource;
        this.allAssignmentDataSource;
        this.MBTIQuestionDataSource;
        this.evaluationDataSource;
        this.evaluationDetailDataSource;
        this.evaluationQuestionDataSource;
        this.MyRegistrationInformationDataSource;
        this.AllRegistrationInformationDataSource;
        this.teacherAssignmentDataSource;

        this.groupInfoID = [];
        this.assignID;
        this.groupNum;
        this.userID;
        this.lastUserID;
        this.lastDiscussID;
        this.dialogData;
        this.audio = new Audio('sounds/tick.mp3');
        this.wheelSpinning = false;
        this.theWheel;
        this.MBTIvalidator;
        this.evaluationValidator;
        this.assignmentValidator;

        this.clicked = false;
        page.prototype.startSpin = function() {
            if (page.wheelSpinning == false) {
                page.theWheel.animation.spins = 6;
                page.theWheel.startAnimation();
                page.wheelSpinning = true;
            }
        }
        page.prototype.playSound = function() {
            // Stop and rewind the sound if it already happens to be playing.
            page.audio.pause();
            page.audio.currentTime = 0;

            // Play the sound.
            page.audio.play();
        }
        page.prototype.alertPrize = function(indicatedSegment) {
            if (!page.clicked) {
                page.clicked = true;
                ajax("app.php", "POST", "json", ({
                    mode: 'insertGroupInformation',
                    assignID: indicatedSegment.assignID,
                    groupNum: indicatedSegment.groupNum,
                    // userID: '<?=$_SESSION['user']['data'][0]['userID']?>'
                }), true, true, function(response) {
                    if (response == '1') {
                        $('#randomTeam_avalaible_group').html(
                            '<?=$_SESSION['setting']['lang'] == 'en' ? 'Your group is :' : 'กลุ่มของคุณคือ :';?>' +
                            indicatedSegment.text);
                        kendo.alert(
                            '<?=$_SESSION['setting']['lang'] == 'en' ? 'Your group is :' : 'กลุ่มของคุณคือ :';?>' +
                            indicatedSegment.text);
                    } else {
                        kendo.alert(response.responseText);
                    }
                    // reset
                    // page.theWheel.stopAnimation(false);  // Stop the animation, false as param so does not call callback function.
                    // page.theWheel.rotationAngle = 0;     // Re-set the wheel angle to 0 degrees.
                    // page.theWheel.draw();                // Call draw to render changes to the wheel.
                    // page.wheelSpinning = false;
                    page.clicked = false;
                });
            }
        }
        page.prototype.logout = function() {
            if (!page.clicked) {
                page.clicked = true;
                ajax("app.php", "Post", "json", ({
                    mode: "logout"
                }), true, true, function(response) {
                    if (response) {
                        redirect('index.php');
                    }
                    page.clicked = false;
                });
            }
        }
        page.prototype.switchLanguage = function(lang) {
            if (!page.clicked) {
                page.clicked = true;
                ajax("switchLanguage.php", "POST", "json", ({
                    lang: lang
                }), true, false, function() {
                    page.clicked = false;
                    window.location.reload();
                });
            }
        }
        page.prototype.refreshProfile = function(e) {
            e.view.element.find("#profile_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'P R O F I L E' : 'ข้อมูลผู้ใช้';?>");
            $('#btnUpdateProfile').click(function() {
                if (!page.clicked) {
                    page.clicked = true;
                    ajax("app.php", "POST", "json", ({
                        mode: 'updateProfile',
                        // userID: '<?=$_SESSION['user']['data'][0]['userID']?>',
                        fullName: $('#profile_fullName').val(),
                        password: $('#profile_password').val()
                    }), true, true, function(response) {
                        alert(
                            '<?=$_SESSION['setting']['lang'] == 'en' ? "Successful operation." : "การดำเนินการเสร็จสมบูรณ์"?>'
                        );
                        page.clicked = false;
                        window.location.reload();
                    });
                }
            });
        }
        page.prototype.initMyAssignment = function(e) {
            page.myAssignmentDataSource = new kendo.data.DataSource({
                transport: {
                    read: {
                        dataType: 'json',
                        type: 'POST',
                        data: ({
                            mode: 'selectAllGroupInformation'
                        }),
                        url: 'app.php'
                    }
                },
                autoSync: false,
                schema: {
                    data: 'data',
                    total: 'total'
                },
                sort: {
                    field: "gi.groupInfoID",
                    dir: "desc"
                },
                filter: [{
                    field: "gi.userID",
                    operator: "eq",
                    value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                },{
                    field: "ass.status",
                    operator: "eq",
                    value: '1'
                }],
                serverPaging: true,
                serverSorting: true,
                serverFiltering: true,
                pageSize: 20
            });
            $("#filterable-listview-my-assignment").kendoMobileListView({
                dataSource: page.myAssignmentDataSource,
                endlessScroll: true,
                pullToRefresh: true,
                template: $("#filterable-listview-my-assignment-template").text(),
            }).kendoTouch({
                filter: ">li",
                tap: function(e) {
                    var itemUID = $(e.touch.target).data("uid");
                    var data;
                    for (var i = 0; i < page.myAssignmentDataSource._data.length; i++) {
                        if (page.myAssignmentDataSource._data[i].uid == itemUID) {
                            data = page.myAssignmentDataSource._data[i];
                            break;
                        }
                    }
                    app.navigate('#assignmentDetail?assignID=' + data.assignID +
                        '&groupNum=' + data.groupNum);
                },

            });

        }
        page.prototype.refreshMyAssignment = function(e) {
            e.view.element.find("#myassignment_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'M Y&nbsp;&nbsp;A S S I G N M E N T' : 'การมอบหมายงานของฉัน';?>"
            );
            page.myAssignmentDataSource.filter({
                field: "gi.userID",
                operator: "eq",
                value: '<?=$_SESSION['user']['data'][0]['userID']?>'
            });

        }
        page.prototype.searchMyAssignment = function(searchstring) {
            var searchstring = searchstring.toUpperCase();
            var searchword = searchstring.split(' ');
            if (searchstring.length != 0) {
                var orfilter = {
                    logic: 'or',
                    filters: []
                };
                var andfilter = {
                    logic: 'and',
                    filters: []
                };
                $.each(searchword, function(i, v1) {
                    if (v1.trim() != '') {
                        if (v1.trim() != '') {
                            orfilter.filters.push({
                                field: 'ci.courseCode',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ci.courseName',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ass.assignTitle',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ass.assignDescription',
                                operator: 'contains',
                                value: v1
                            }, );
                            andfilter.filters.push(orfilter);
                            andfilter.filters.push({
                                field: "gi.userID",
                                operator: "eq",
                                value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                            });
                            andfilter.filters.push({
                                field: "ass.status",
                                operator: "eq",
                                value: '1'
                            });
                            orfilter = {
                                logic: 'or',
                                filters: []
                            };
                        }
                    }
                });
                page.myAssignmentDataSource.filter(andfilter);
            } else {
                page.myAssignmentDataSource.filter({
                    field: "gi.userID",
                    operator: "eq",
                    value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                });
            }
            var scroller = $('#filterable-listview-my-assignment').data('kendoMobileListView').scroller();
            scroller.reset();
        }
        page.prototype.initAllAssignment = function(e) {
            page.allAssignmentDataSource = new kendo.data.DataSource({
                transport: {
                    read: {
                        dataType: 'json',
                        type: 'POST',
                        data: ({
                            mode: 'selectAllAssignment'
                        }),
                        url: 'app.php'
                    }
                },
                autoSync: false,
                schema: {
                    data: 'data',
                    total: 'total'
                },
                sort: {
                    field: "ass.assignID",
                    dir: "desc"
                },
                filter: [{
                    field: "ri.classGroup",
                    operator: "eq",
                    value: '<?=$_SESSION['user']['data'][0]['classGroup']?>'
                }],
                serverPaging: true,
                serverSorting: true,
                serverFiltering: true,
                pageSize: 20
            });
            $("#filterable-listview-all-assignment").kendoMobileListView({
                dataSource: page.allAssignmentDataSource,
                endlessScroll: true,
                pullToRefresh: true,
                template: $("#filterable-listview-all-assignment-template").text(),
            }).kendoTouch({
                filter: ">li",
                tap: function(e) {
                    var itemUID = $(e.touch.target).data("uid");
                    var data;
                    for (var i = 0; i < page.allAssignmentDataSource._data.length; i++) {
                        if (page.allAssignmentDataSource._data[i].uid == itemUID) {
                            data = page.allAssignmentDataSource._data[i];
                            break;
                        }
                    }
                    switch (data.groupTypeID) {
                        case '1':
                            app.navigate('#pickupTeam?assignID=' + data.assignID);
                            break;
                        case '2':
                            app.navigate('#randomTeam?assignID=' + data.assignID);
                            break;
                        case '3':
                            app.navigate('#MBTITeam?assignID=' + data.assignID);
                            break;
                    }
                },

            });
        }
        page.prototype.refreshAllAssignment = function(e) {
            e.view.element.find("#allassignment_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'A L L&nbsp;&nbsp;A S S I G N M E N T' : 'การมอบหมายงานทั้งหมด';?>"
            );
            page.allAssignmentDataSource.filter({
                field: "ri.classGroup",
                operator: "eq",
                value: '<?=$_SESSION['user']['data'][0]['classGroup']?>'
            });
        }
        page.prototype.searchAllAssignment = function(searchstring) {
            var searchstring = searchstring.toUpperCase();
            var searchword = searchstring.split(' ');
            if (searchstring.length != 0) {
                var orfilter = {
                    logic: 'or',
                    filters: []
                };
                var andfilter = {
                    logic: 'and',
                    filters: []
                };
                $.each(searchword, function(i, v1) {
                    if (v1.trim() != '') {
                        if (v1.trim() != '') {
                            orfilter.filters.push({
                                field: 'ci.courseCode',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ci.courseName',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ass.assignTitle',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ass.assignDescription',
                                operator: 'contains',
                                value: v1
                            }, );
                            andfilter.filters.push(orfilter);
                            andfilter.filters.push({
                                field: "ri.classGroup",
                                operator: "eq",
                                value: '<?=$_SESSION['user']['data'][0]['classGroup']?>'
                            });
                            orfilter = {
                                logic: 'or',
                                filters: []
                            };
                        }
                    }
                });
                page.allAssignmentDataSource.filter(andfilter);
            } else {
                page.allAssignmentDataSource.filter({
                    field: "ri.classGroup",
                    operator: "eq",
                    value: '<?=$_SESSION['user']['data'][0]['classGroup']?>'
                });
            }
            var scroller = $('#filterable-listview-all-assignment').data('kendoMobileListView').scroller();
            scroller.reset();
        }
        page.prototype.refreshAssignmentDetail = function(e) {
            ajax("app.php", "POST", "json", ({
                mode: 'selectGroupInformation',
                assignID: e.view.params.assignID,
                groupNum: e.view.params.groupNum
            }), true, true, function(response) {
                e.view.element.find("#assignment_detail_layout_title").html(response.data[0]['groupType']);
                $('#assignmentDetail_courseCode span').html(response.data[0]['courseCode'] + ' ' + response.data[0]['courseName']);
                $('#assignmentDetail_assignTitle span').html(response.data[0]['assignTitle']);
                $('#assignmentDetail_assignDate span').html(response.data[0]['assignDate'] + ' ' + response.data[0]['semester'] + '/' + response.data[0]['year']);
                $('#assignmentDetail_groupNum').html(e.view.params.groupNum);
                $('#assignmentDetail_groupType span').html(response.data[0]['groupType']);
                var html = '';
                page.groupInfoID = [];
                $.each(response.data, function(i, v) {
                    html += '<li>';
                    html += '<label class="km-label-above" style="font-size:18px">' + (i + 1) +
                        '.' + v['fullName'];
                    html += '<input value="' + v['responsibility'] + '" id="responsibility' + v[
                        'groupInfoID'] + '" type="text" />';
                    html += '</label>';

                    html += '</li>';
                    page.groupInfoID.push(v['groupInfoID']);
                });
                $('#assignment_detail_teammember').html(html);
                $('#assignment_detail_teammember').kendoMobileListView();
            });

        }
        page.prototype.refreshPickupTeam = function(e) {
            ajax("app.php", "POST", "json", ({
                mode: 'selectAssignment',
                assignID: e.view.params.assignID,
            }), true, true, function(response) {
                e.view.element.find("#pickupTeam_layout_title").html(
                    '<?=$_SESSION['setting']['lang'] == 'en' ? 'P I C K&nbsp;&nbsp;U P&nbsp;&nbsp;T E A M' : 'เลือกกลุ่มแบบสมัครใจ';?>'
                );
                $('#pickupTeam_courseCode span').html(response.data[0]['courseCode'] + ' ' + response.data[0]['courseName']);
                $('#pickupTeam_assignTitle span').html(response.data[0]['assignTitle']);
                $('#pickupTeam_assignDescription span').html(response.data[0]['assignDescription']);
                $('#pickupTeam_assignDate span').html(response.data[0]['assignDate'] + ' ' + response.data[0]['semester'] + '/' + response.data[0]['year']);
                $('#pickupTeam_deadline span').html(response.data[0]['deadline']);
                $('#pickupTeam_numGroup span').html(response.data[0]['numGroup']);
                var html = '';
                html += '<div class="divTable">';
                html += '<div class="divTableBody">';
                var numGroup = response.data[0]['numGroup'];
                for (var i = 1; i <= numGroup; i++) {
                    if (i % 4 == 1) {
                        html += '<div class="divTableRow">';
                    }
                    html += '<div class="divTableCell"><a href="#pickupTeamDetail?assignID=' + e.view.params
                        .assignID + '&groupNum=' + (i) +
                        '"><div class="circle" style="background-color:#252838;min-width:60px;min-height:60px;"><i class="material-icons" style="font-size: 32px;color: #ffffff;position: relative;top: 14px;">group</i></div><div style="color: #493D45;font-size: 10.0pt;"><?=$_SESSION['setting']['lang'] == 'en' ? 'Group:' : 'กลุ่มที่:';?>' +
                        (i) + '</div></a></div>';
                    if (i % 4 == 0) {
                        html += '</div>';
                    }
                }
                html += '</div>';
                html += '</div>';

                var datenow = Date.now();
                var deadline = Date.parse(response.data[0]['deadline']);
                if(datenow.valueOf()>deadline.valueOf()){
                    html='<?=$_SESSION['setting']['lang'] == 'en' ? 'The time for applying for this assignment has been reached. Please contact the system administrator.' : 'หมดเวลาสำหรับการสมัครการมอบหมายงานนี้แล้ว กรุณาติดต่อผู้ดูแลระบบ';?>';
                }
                $('#pickupTeam_avalaible_group').html(html);

                //--
                ajax("app.php", "POST", "json", ({
                    mode: 'calGroupInformation',
                    assignID: e.view.params.assignID,
                }), true, true, function(response) {
                    var segments = [];
                    var html = '';
                    $.each(response, function(i, v) {
                        html +=
                            '<p><?=$_SESSION['setting']['lang'] == 'en' ? 'Group : ' : 'กลุ่มที่ : ';?> ' +
                            v.groupNum +
                            ' <?=$_SESSION['setting']['lang'] == 'en' ? 'for : ' : 'จำนวนสมาชิก : ';?> ' +
                            v.member +
                            ' <?=$_SESSION['setting']['lang'] == 'en' ? 'people' : 'คน ';?>';
                        html +=
                            '<?=$_SESSION['setting']['lang'] == 'en' ? 'Total member : ' : 'จำนวนสมาชิกทั้งหมด : ';?>' +
                            v.totalMember + ' ';
                        html +=
                            '<?=$_SESSION['setting']['lang'] == 'en' ? 'Avaliable : ' : 'สามารถรับสมาชิกได้อีก : ';?>' +
                            v.avaliable + ' <hr></p>';
                    });
                    $('#pickupTeam_group').html(html);
                });
            });
        }
        page.prototype.refreshPickupTeamDetail = function(e) {
            page.assignID = e.view.params.assignID;
            page.groupNum = e.view.params.groupNum;
            e.view.element.find("#pickupTeam_detail_layout_title").html(
                '<?=$_SESSION['setting']['lang'] == 'en' ? 'P I C K&nbsp;&nbsp;U P&nbsp;&nbsp;T E A M : ' : 'เลือกกลุ่มแบบสมัครใจกลุ่มที่ : ';?> ' +
                page.groupNum
            );
            ajax("app.php", "POST", "json", ({
                mode: 'calGroupInformation',
                assignID: page.assignID,
            }), true, true, function(response) {
                var html = '';
                html += '<p><?=$_SESSION['setting']['lang'] == 'en' ? 'Group : ' : 'กลุ่มที่ : ';?> ' + page
                    .groupNum + ' <?=$_SESSION['setting']['lang'] == 'en' ? 'for : ' : 'จำนวนสมาชิก : ';?> ' +
                    response[page.groupNum - 1].member +
                    ' <?=$_SESSION['setting']['lang'] == 'en' ? 'people' : 'คน';?></p>';
                html +=
                    '<p><?=$_SESSION['setting']['lang'] == 'en' ? 'Total member : ' : 'จำนวนสมาชิกทั้งหมด : ';?>' +
                    response[page.groupNum - 1].totalMember + '</p>';
                html +=
                    '<p><?=$_SESSION['setting']['lang'] == 'en' ? 'Avaliable : ' : 'สามารถรับสมาชิกได้อีก : ';?>' +
                    response[page.groupNum - 1].avaliable + '</p>';
                $('#pickupTeamDetail_title').html(html);

                if (response[page.groupNum - 1].avaliable <= 0) {
                    $('#btnPickupTeamApply').hide();
                } else {
                    $('#btnPickupTeamApply').show();
                }

                ajax("app.php", "POST", "json", ({
                    mode: 'selectGroupInformation',
                    assignID: page.assignID,
                    groupNum: page.groupNum
                }), true, true, function(response) {
                    var html = '';
                    page.groupInfoID = [];
                    $.each(response.data, function(i, v) {
                        html += '<li>';
                        html += '<h4>' + (i + 1) + '.' + v['fullName'];
                        html += '</h4>';
                        html += '<p>' + v['responsibility'] + '</p>';
                        html += '</li>';
                        page.groupInfoID.push(v['groupInfoID']);
                    });
                    $('#pickupTeam_detail_teammember').html(html);
                    $('#pickupTeam_detail_teammember').kendoMobileListView();
                });

            });
        }
        page.prototype.pickupTeamApply = function() {
            page.assignID;
            page.groupNum;
            if (!page.clicked) {
                page.clicked = true;
                ajax("app.php", "POST", "json", ({
                    mode: 'insertGroupInformation',
                    assignID: page.assignID,
                    groupNum: page.groupNum,
                    // userID: '<?=$_SESSION['user']['data'][0]['userID']?>'
                }), true, true, function(response) {
                    if (response == '1') {
                        kendo.alert(
                            '<?php echo $_SESSION['setting']['lang'] == 'en' ? "Successful operation." : "การดำเนินการเสร็จสมบูรณ์" ?>'
                            );
                        window.location.reload();
                    } else {
                        kendo.alert(response.responseText);
                    }
                    page.clicked = false;
                });
            }

        }
        page.prototype.refreshRandomTeam = function(e) {
            page.assignID = e.view.params.assignID;
            ajax("app.php", "POST", "json", ({
                mode: 'selectAssignment',
                assignID: e.view.params.assignID,
            }), true, true, function(response1) {
                e.view.element.find("#randomTeam_layout_title").html(
                    '<?=$_SESSION['setting']['lang'] == 'en' ? 'R A N D O M&nbsp;&nbsp;T E A M' : 'เลือกกลุ่มแบบสุ่ม';?>'
                );
                $('#randomTeam_courseCode span').html(response1.data[0]['courseCode'] + ' ' + response1.data[0]['courseName']);
                $('#randomTeam_assignTitle span').html(response1.data[0]['assignTitle']);
                $('#randomTeam_assignDescription span').html(response1.data[0]['assignDescription']);
                $('#randomTeam_assignDate span').html(response1.data[0]['assignDate'] + ' ' + response1.data[0]['semester'] + '/' + response1.data[0]['year']);
                $('#randomTeam_deadline span').html(response1.data[0]['deadline']);
                $('#randomTeam_numGroup span').html(response1.data[0]['numGroup']);

                ajax("app.php", "POST", "json", ({
                    mode: 'checkAlreadyJoinGroup',
                    assignID: e.view.params.assignID,
                }), true, true, function(response2) {

                    if (response2.total != 0) {
                        $('#randomTeam_avalaible_group').html(
                            '<?=$_SESSION['setting']['lang'] == 'en' ? 'Your group is : Group ' : 'กลุ่มของคุณคือ : กลุ่มที่ ';?>' +
                            response2.data[0]['groupNum']);
                        $('#spin_button').hide();
                    } else {
                        var datenow = Date.now();
                        var deadline = Date.parse(response1.data[0]['deadline']);
                        if(datenow.valueOf()>deadline.valueOf()){
                            var html='<?=$_SESSION['setting']['lang'] == 'en' ? 'The time for applying for this assignment has been reached. Please contact the system administrator.' : 'หมดเวลาสำหรับการสมัครการมอบหมายงานนี้แล้ว กรุณาติดต่อผู้ดูแลระบบ';?>';
                            $('#randomTeam_avalaible_group').html(html);
                            $('#spin_button').hide();
                        }else{
                            $('#randomTeam_avalaible_group').html('');
                            $('#spin_button').show();
                        }

                        
                    }
                    ajax("app.php", "POST", "json", ({
                        mode: 'calGroupInformation',
                        assignID: page.assignID,
                    }), true, true, function(response3) {
                        var segments = [];
                        var html = '';
                        $.each(response3, function(i, v) {
                            html +=
                                '<p><?=$_SESSION['setting']['lang'] == 'en' ? 'Group : ' : 'กลุ่มที่ : ';?> ' + v
                                .groupNum +
                                ' <?=$_SESSION['setting']['lang'] == 'en' ? 'for : ' : 'จำนวนสมาชิก : ';?> ' + v
                                .member + ' <?=$_SESSION['setting']['lang'] == 'en' ? 'people' : 'คน ';?>';
                            html +=
                                '<?=$_SESSION['setting']['lang'] == 'en' ? 'Total member : ' : 'จำนวนสมาชิกทั้งหมด : ';?>' +
                                v.totalMember + ' ';
                            html +=
                                '<?=$_SESSION['setting']['lang'] == 'en' ? 'Avaliable : ' : 'สามารถรับสมาชิกได้อีก : ';?>' +
                                v.avaliable + ' <hr></p>';
                            $('#randomTeam_group').html(html);
                            var randomColor = get_random_color();
                            if (v.avaliable != 0) {
                                segments.push({
                                    'textFontWeight': 'bold',
                                    'textFontSize': 20,
                                    'textFillStyle': '#fff',
                                    'fillStyle': randomColor,
                                    'text': '<?=$_SESSION['setting']['lang'] == 'en' ? 'Group : ' : 'กลุ่ม : ';?> ' + v.groupNum,
                                    'groupNum': v.groupNum,
                                    'assignID': page.assignID
                                });
                            }
                        });
                        page.wheelSpinning = false;
                        page.theWheel = new Winwheel({
                            'outerRadius': 150, // Set outer radius so wheel fits inside the background.
                            'innerRadius': 25, // Make wheel hollow so segments dont go all way to center.
                            'textFontSize': 32, // Set default font size for the segments.
                            'textOrientation': 'horizontal', // Make text vertial so goes down from the outside of wheel.
                            'textAlignment': 'inner', // Align text to outside of wheel.
                            'numSegments': segments.length, // Specify number of segments.
                            'segments': segments,
                            'lineWidth': 2,
                            'animation': // Specify the animation to use.
                            {
                                'type': 'spinToStop',
                                'duration': 5,
                                'spins': 3,
                                'callbackFinished': page.alertPrize, // Function to call whent the spinning has stopped.
                                'callbackSound': page.playSound, // Called when the tick sound is to be played.
                                'soundTrigger': 'pin' // Specify pins are to trigger the sound.
                            },
                            'pins': // Turn pins on.
                            {
                                'number': segments.length,
                                'fillStyle': 'silver',
                                'outerRadius': 4,
                            }
                        });
                    });
                });

            });

            

            
        }
        page.prototype.refreshMBTITeam = function(e) {
            ajax("app.php", "POST", "json", ({
                mode: 'selectAssignment',
                assignID: e.view.params.assignID,
            }), true, true, function(response) {
                e.view.element.find("#MBTITeam_layout_title").html(
                    '<?=$_SESSION['setting']['lang'] == 'en' ? 'M B T I&nbsp;&nbsp;T E A M' : 'เลือกกลุ่มตามบุคลิกภาพ';?>'
                );
                $('#MBTITeam_courseCode span').html(response.data[0]['courseCode'] + ' ' + response.data[0]['courseName']);
                $('#MBTITeam_assignTitle span').html(response.data[0]['assignTitle']);
                $('#MBTITeam_assignDescription span').html(response.data[0]['assignDescription']);
                $('#MBTITeam_assignDate span').html(response.data[0]['assignDate'] + ' ' + response.data[0]['semester'] + '/' + response.data[0]['year']);
                $('#MBTITeam_deadline span').html(response.data[0]['deadline']);
                $('#MBTITeam_numGroup span').html(response.data[0]['numGroup']);

                //--
                ajax("app.php", "POST", "json", ({
                    mode: 'calGroupInformation',
                    assignID: e.view.params.assignID,
                }), true, true, function(response) {
                    var html = '';
                    $.each(response, function(i, v) {
                        html +=
                            '<p><b><?=$_SESSION['setting']['lang'] == 'en' ? 'Group : ' : 'กลุ่มที่ : ';?> ' +
                            v.groupNum +
                            '</b> <br><?=$_SESSION['setting']['lang'] == 'en' ? 'for : ' : 'จำนวนสมาชิก : ';?> ' +
                            v.member +
                            ' <?=$_SESSION['setting']['lang'] == 'en' ? 'people' : 'คน ';?><br>';
                        html +=
                            '<?=$_SESSION['setting']['lang'] == 'en' ? 'Total member : ' : 'จำนวนสมาชิกทั้งหมด : ';?>' +
                            v.totalMember +
                            ' <?=$_SESSION['setting']['lang'] == 'en' ? 'people' : 'คน ';?><br>';
                        html +=
                            '<?=$_SESSION['setting']['lang'] == 'en' ? 'Avaliable : ' : 'สามารถรับสมาชิกได้อีก : ';?>' +
                            v.avaliable +
                            ' <?=$_SESSION['setting']['lang'] == 'en' ? 'people' : 'คน ';?><br>';
                        ajax("app.php", "POST", "json", ({
                            mode: 'selectGroupInformation',
                            assignID: e.view.params.assignID,
                            groupNum: v.groupNum
                        }), false, true, function(response) {
                            html += '<ol>';
                            $.each(response['data'], function(ii, vv) {
                                html += '<li>';
                                html += vv['fullName'];
                                html += '</li>';
                            });
                            html += '</ol>';
                        });
                        html += '<hr></p>';
                    });
                    $('#MBTITeam_group').html(html);
                });
            });
        }
        page.prototype.updateGroupInformation = function() {
            try {
                $.each(page.groupInfoID, function(i, v) {
                    ajax("app.php", "POST", "json", ({
                        mode: 'updateGroupInformation',
                        groupInfoID: v,
                        responsibility: $('#responsibility' + v).val()
                    }), true, true, function(response) {
                        if (response != '1') throw "Cannot update record:" + v;
                    });
                });
            } catch (err) {
                kendo.alert(err.message);
            } finally {
                kendo.alert(
                    '<?php echo $_SESSION['setting']['lang'] == 'en' ? "Successful operation." : "การดำเนินการเสร็จสมบูรณ์" ?>'
                );
            }
        }
        page.prototype.refreshDiscuss = function(e) {
            e.view.element.find("#discuss_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'D I S C U S S I O N' : 'ช่องการสนทนา';?>");
            page.myAssignmentDataSource = new kendo.data.DataSource({
                transport: {
                    read: {
                        dataType: 'json',
                        type: 'POST',
                        data: ({
                            mode: 'selectAllGroupInformation'
                        }),
                        url: 'app.php'
                    }
                },
                autoSync: false,
                schema: {
                    data: 'data',
                    total: 'total'
                },
                sort: {
                    field: "gi.groupInfoID",
                    dir: "desc"
                },
                filter: [{
                    field: "gi.userID",
                    operator: "eq",
                    value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                }],
                serverPaging: true,
                serverSorting: true,
                serverFiltering: true,
                pageSize: 20
            });
            $("#discuss-listview-my-assignment").kendoMobileListView({
                dataSource: page.myAssignmentDataSource,
                endlessScroll: true,
                pullToRefresh: true,
                template: $("#filterable-listview-my-assignment-template").text(),
            }).kendoTouch({
                filter: ">li",
                tap: function(e) {
                    var itemUID = $(e.touch.target).data("uid");
                    var data;
                    for (var i = 0; i < page.myAssignmentDataSource._data.length; i++) {
                        if (page.myAssignmentDataSource._data[i].uid == itemUID) {
                            data = page.myAssignmentDataSource._data[i];
                            break;
                        }
                    }
                    app.navigate('#discussroom?assignID=' + data.assignID + '&groupNum=' + data
                        .groupNum + '&courseCode=' + data.courseCode + '&courseName=' + data
                        .courseName + '&assignTitle=' + data.assignTitle + '&userID=' + data.userID);
                },

            });
        }
        page.prototype.initDiscussRoom = function(e) {
            $('#dialog').kendoDialog({
                Title :  "<?php echo $_SESSION['setting']['lang'] == 'en' ? "What do you want to do?" : "คุณต้องการที่จะ" ?>",
                closable: true,
                modal: true,
                visible: false,
                actions: [{
                        text: '<?php echo $_SESSION['setting']['lang'] == 'en' ? "View photo" : "ดูรูปภาพ" ?>',
                        primary: true,
                        visible: false,
                        action: function() {
                            window.open('images/chat_images/assignID' + page.dialogData.assignID +
                                '/groupNum' + page.dialogData.groupNum + '/' + page.dialogData
                                .photo);
                        }
                    },
                    {
                        text: '<?php echo $_SESSION['setting']['lang'] == 'en' ? "Delete" : "ลบ" ?>',
                        action: function() {
                            page.deleteMessage(page.dialogData.discussID);
                        }
                    },
                ],
            });
        }
        page.prototype.refreshDiscussRoom = function(e) {
            e.view.element.find("#discuss_room_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'D I S C U S S I O N&nbsp;&nbsp;R O O M' : 'ช่องการสนทนา';?>"
            );
            $('.chat-list').html('');
            $("#btn-photo").click(function() {
                $("#photo").trigger('click');
            });
            $('#photo').on('change', function() {
                var val = $(this).val();
                $(this).siblings('span').text(val);
            });
            $('#chat_input').on('keypress', function(a) {
                if (a.which == 13) {
                    if ($.trim($('#chat_input').val()) != '' && $('#photo').val() != '' || $.trim($(
                            '#chat_input').val()) == '' && $('#photo').val() !=
                        '') { //มีทั้งรูปและข้อความ หรือ ไม่มีข้อความมีรูป
                        page.postMessageWithAttach(e.view.params.assignID, e.view.params.groupNum, e.view
                            .params.userID, $('#chat_input').val(), null);
                    } else if ($.trim($('#chat_input').val()) != '' && $('#photo').val() ==
                        '') { //มีแต่ข้อความ
                        page.postMessage(e.view.params.assignID, e.view.params.groupNum, e.view.params
                            .userID, $('#chat_input').val(), null);
                    }
                }
            });
            $("#btn-send").click(function() {
                if ($.trim($('#chat_input').val()) != '' && $('#photo').val() != '' || $.trim($(
                        '#chat_input').val()) == '' && $('#photo').val() !=
                    '') { //มีทั้งรูปและข้อความ หรือ ไม่มีข้อความมีรูป
                    page.postMessageWithAttach(e.view.params.assignID, e.view.params.groupNum, e.view.params
                        .userID, $('#chat_input').val(), null);
                } else if ($.trim($('#chat_input').val()) != '' && $('#photo').val() == '') { //มีแต่ข้อความ
                    page.postMessage(e.view.params.assignID, e.view.params.groupNum, e.view.params.userID,
                        $('#chat_input').val(), null);
                }
            });

            ajax("app.php", "POST", "json", ({
                mode: 'selectAllChat',
                assignID: e.view.params.assignID,
                groupNum: e.view.params.groupNum,
            }), true, true, function(response) {
                $('#chatTitle').html(e.view.params.courseCode + ' ' + e.view.params.courseName);
                $('#chatDescription').html(e.view.params.assignTitle +' <?=$_SESSION['setting']['lang'] == 'en' ? "Group" : "กลุ่มที่"?>: ' + e.view.params.groupNum);
                if (response.total != 0) {
                    
                    page.lastUserID = '';
                    $.each(response.data, function(i, v) {
                        page.userID = v.userID;
                        if (v.userID != e.view.params.userID) {
                            page.renderMessage(v, 'him');
                        } else {
                            page.renderMessage(v, 'me');
                        }
                    });
                    e.view.scroller.animatedScrollTo(0, -($('.chat-list').prop("scrollHeight") - window
                        .innerHeight + 150));
                }
            });
        }
        page.prototype.renderMessage = function(obj, who) {
            var html = '';
            if (who == 'him') {
                if (page.userID != page.lastUserID) {
                    html += '<div class="row" id="discussID' + obj.discussID + '">';
                    html += '<span class="text-muted" style="font-size: 0.6rem;">' + obj.fullName + '</span>';
                    html +=
                        '<div class="km-thumbnail"style="margin-right:0;background-color:#FCA9C4;max-width:40px;max-height:40px;text-align: center;"><i class="material-icons" style="padding-top: 8px;">face</i></div>';
                } else {
                    html += '<div class="row" style="padding-left: 40px;" id="discussID' + obj.discussID + '">';
                }
                if (obj.message != null && obj.message != '') {
                    html += '<span class="col-sm-auto ' + who + '" onclick="page.more_option(' + obj.discussID +
                        ',\'\')">' + obj.message + '</span>';
                    html += '<span class="col-sm-auto more_option" id="more_option' + obj.discussID + '">';
                    html += '<div style="padding-left: 5px;">';
                    html += '<div class="text-muted" style="font-size: 0.6rem;">' + obj.dateTimeSend + '</div>';
                    html += '</div>';
                    html += '</span>';
                }
                if (obj.photo != null && obj.photo != '') {
                    if (obj.message != null && obj.photo != null) html += '<div>';
                    html += '<span class="col-sm-auto photo" onclick="page.more_option(' + obj.discussID + ',\'' +
                        'images/chat_images/assignID' + obj.assignID + '/groupNum' + obj.groupNum + '/' + obj
                        .photo + '\')"><img src="images/chat_images/assignID' + obj.assignID + '/groupNum' + obj
                        .groupNum + '/' + obj.photo + '"/></span>';
                    html += '<span class="col-sm-auto more_option" id="more_option' + obj.discussID + '">';
                    html += '<div style="padding-left: 5px;">';
                    html += '<span class="material-icons">more_horiz</span>';
                    html += '<div class="text-muted" style="font-size: 0.6rem;">' + obj.dateTimeSend + '</div>';
                    html += '</div>';
                    html += '</span>';
                    if (obj.message != null && obj.photo != null) html += '</div>';
                }
                html += '</div>';
            } else { //me
                html = '<div class="row" id="discussID' + obj.discussID + '">';
                if (obj.message != null && obj.message != '') {
                    html += '<div style="display: flex;flex-direction: row-reverse;">';
                    html += '<span class="col-sm-auto ' + who + '" onclick="page.more_option(' + obj.discussID +
                        ',\'\')">' + obj.message + '</span>';
                    html += '<span class="col-sm-auto more_option" id="more_option' + obj.discussID +
                        '" onclick="page.more_option_action(\'' + obj.discussID + '\',\'' + obj.photo + '\',\'' +
                        obj.assignID + '\',\'' + obj.groupNum + '\')">';
                    html += '<div style="padding-right: 5px;text-align: right;">';
                    html += '<i class="material-icons" >more_horiz</i>';
                    html += '<div class="text-muted" style="font-size: 0.6rem;">' + obj.dateTimeSend + '</div>';
                    html += '</div>';
                    html += '</span>';
                    html += '</div>';
                }
                if (obj.photo != null && obj.photo != '') {
                    html += '<div style="display: flex;flex-direction: row-reverse;">';
                    html += '<span class="col-sm-auto photo" onclick="page.more_option(' + obj.discussID + ',\'' +
                        'images/chat_images/assignID' + obj.assignID + '/groupNum' + obj.groupNum + '/' + obj
                        .photo + '\')"><img src="images/chat_images/assignID' + obj.assignID + '/groupNum' + obj
                        .groupNum + '/' + obj.photo + '"/></span>';
                    html += '<span class="col-sm-auto more_option" id="more_option' + obj.discussID +
                        '" onclick="page.more_option_action(\'' + obj.discussID + '\',\'' + obj.photo + '\',\'' +
                        obj.assignID + '\',\'' + obj.groupNum + '\')">';
                    html += '<div style="padding-right: 5px;text-align: right;">';
                    html += '<span class="material-icons">more_horiz</span>';
                    html += '<div class="text-muted" style="font-size: 0.6rem;">' + obj.dateTimeSend + '</div>';
                    html += '</div>';
                    html += '</span>';
                    html += '</div>';
                }
                html += '</div>';
            }

            $('.chat-list').append(html);
            page.lastUserID = page.userID;
            page.lastDiscussID = obj.discussID;
        }
        page.prototype.postMessage = function(assignID, groupNum, userID, message, photo) {
            if (!page.clicked) {
                page.clicked = true;
                ajax("app.php", "POST", "json", ({
                    mode: 'postMessage',
                    assignID: assignID,
                    groupNum: groupNum,
                    userID: userID,
                    message: message,
                    photo: photo
                }), true, true, function(response) {
                    var html = '<div class="row g-0" id="discussID' + response.data[0].discussID + '">';
                    html += '<div style="display: flex;flex-direction: row-reverse;">';
                    html += '<span class="col-sm-auto me"  onclick="page.more_option(' + response.data[0]
                        .discussID + ',\'\')">' + response.data[0].message + '</span>';
                    html += '<span class="col-sm-auto more_option" id="more_option' + response.data[0]
                        .discussID + '" onclick="page.more_option_action(\'' + response.data[0].discussID +
                        '\',\'' + response.data[0].photo + '\',\'' + response.data[0].assignID + '\',\'' +
                        response.data[0].groupNum + '\')">';
                    html += '<div style="padding-right: 5px;text-align: right;">';
                    html += '<i class="material-icons">more_horiz</i>';
                    html += '<div class="text-muted" style="font-size: 0.6rem;">' + response.data[0]
                        .dateTimeSend + '</div>';
                    html += '</div>';
                    html += '</span>';
                    html += '</div>';
                    html += '</div>';
                    $('.chat-list').append(html);
                    $('#chat_input').val('');
                    page.lastUserID = page.userID;
                    page.lastDiscussID = response.data[0].discussID;
                    $("#discussroom").data("kendoMobileView").scroller.animatedScrollTo(0, -($('.chat-list')
                        .prop("scrollHeight") - window.innerHeight + 150));
                    page.clicked = false;
                });
            }

        }
        page.prototype.postMessageWithAttach = function(assignID, groupNum, userID, message, photo) {
            var myFormData = new FormData();
            myFormData.append('photo', $("#photo")[0].files[0]);
            myFormData.append('mode', 'postMessage');
            myFormData.append('assignID', assignID);
            myFormData.append('groupNum', groupNum);
            myFormData.append('userID', userID);
            myFormData.append('message', message);
            if (!page.clicked) {
                page.clicked = true;
                $.ajax({
                    url: 'app.php',
                    type: 'POST',
                    async: true,
                    processData: false, // important
                    contentType: false, // important
                    dataType: 'json',
                    data: myFormData,
                    success: function(response) {
                        var html = '<div class="row g-0" id="discussID' + response.data[0].discussID +
                            '">';
                        if (response.data[0].message != null && response.data[0].message != '') {
                            html += '<div style="display: flex;flex-direction: row-reverse;">';
                            html += '<span class="col-sm-auto me"  onclick="page.more_option(' +
                                response.data[0].discussID + ',\'\')">' + response.data[0].message +
                                '</span>';
                            html += '<span class="col-sm-auto more_option" id="more_option' + response
                                .data[0].discussID + '" onclick="page.more_option_action(\'' + response
                                .data[0].discussID + '\',\'' + response.data[0].photo + '\',\'' +
                                response.data[0].assignID + '\',\'' + response.data[0].groupNum +
                                '\')">';
                            html += '<div style="padding-right: 5px;text-align: right;">';
                            html += '<i class="material-icons">more_horiz</i>';
                            html += '<div class="text-muted" style="font-size: 0.6rem;">' + response
                                .data[0].dateTimeSend + '</div>';
                            html += '</div>';
                            html += '</span>';
                            html += '</div>';
                        }
                        if (response.data[0].photo != null && response.data[0].photo != '') {
                            html += '<div style="display: flex;flex-direction: row-reverse;">';
                            html += '<span class="col-sm-auto photo"  onclick="page.more_option(' +
                                response.data[0].discussID + ',\'' + 'images/chat_images/assignID' +
                                response.data[0].assignID + '/groupNum' + response.data[0].groupNum +
                                '/' + response.data[0].photo +
                                '\')"><img src="images/chat_images/assignID' + response.data[0]
                                .assignID + '/groupNum' + response.data[0].groupNum + '/' + response
                                .data[0].photo + '"/></span>';
                            html += '<span class="col-sm-auto more_option" id="more_option' + response
                                .data[0].discussID + '" onclick="page.more_option_action(\'' + response
                                .data[0].discussID + '\',\'' + response.data[0].photo + '\',\'' +
                                response.data[0].assignID + '\',\'' + response.data[0].groupNum +
                                '\')">';
                            html += '<div style="padding-right: 5px;text-align: right;">';
                            html += '<span class="material-icons">more_horiz</span>';
                            html += '<div class="text-muted" style="font-size: 0.6rem;">' + response
                                .data[0].dateTimeSend + '</div>';
                            html += '</div>';
                            html += '</span>';
                            html += '</div>';
                        }
                        html += '</div>';
                        $('.chat-list').append(html);

                        $("#photo").val('');
                        $("#photo").siblings('span').text('');
                        $('#chat_input').val('');

                        // $("#teacherDiscussRoom_photo").val('');
                        // $("#teacherDiscussRoom_photo").siblings('span').text('');
                        // $('#teacherDiscussRoom_chat_input').val('');

                        page.lastUserID = page.userID;
                        page.lastDiscussID = response.data[0].discussID;
                        $("#discussroom").data("kendoMobileView").scroller.animatedScrollTo(0, -($(
                            '.chat-list').prop("scrollHeight") - window.innerHeight + 200));
                        page.clicked = true;
                    },
                });
            }
        }
        page.prototype.deleteMessage = function(discussID) {
            if (!page.clicked) {
                page.clicked = true;
                ajax("app.php", "POST", "json", ({
                    mode: 'deleteMessage',
                    discussID: discussID
                }), true, true, function(response) {
                    if (response == true) {
                        $('#discussID' + discussID).remove();
                    } else {
                        kendo.alert(response);
                    }
                    page.clicked = false;
                });
            }
        }
        page.prototype.more_option = function(id, image) {
            $('.more_option').css("display", "none");
            $('#more_option' + id).css("display", "flex");
            if (image != '') {
                window.open(image);
            }
        }
        page.prototype.more_option_action = function(discussID, photo, assignID, groupNum) {
            page.dialogData = {
                discussID,
                photo,
                assignID,
                groupNum
            };
            $('#dialog').data("kendoDialog").open();
            if ((photo === '' || photo == 'null')) {
                $('#dialog').data("kendoDialog").content(
                    '<p><?php echo $_SESSION['setting']['lang'] == 'en' ? "Would you like to delete them?" : "คุณต้องการที่จะลบข้อมูลหรือไม่" ?><p>'
                    );
                $("#dialog").closest(".k-window").find(".k-button.k-primary").hide();
            } else {
                $('#dialog').data("kendoDialog").content(
                    '<p><?php echo $_SESSION['setting']['lang'] == 'en' ? "Would you like to view pictures or delete them?" : "คุณต้องการที่จะ ดูรูปภาพ หรือ ลบข้อมูล" ?><p>'
                    );
                $("#dialog").closest(".k-window").find(".k-button.k-primary").show();
            }
        }
        page.prototype.initMBTI = function(e) {
            page.MBTIQuestionDataSource = new kendo.data.DataSource({
                transport: {
                    read: {
                        dataType: 'json',
                        type: 'POST',
                        data: ({
                            mode: 'selectAllMBTIQuestion'
                        }),
                        url: 'app.php'
                    }
                },
                autoSync: false,
                schema: {
                    data: 'data',
                    total: 'total'
                },
                sort: {
                    field: "questionNo",
                    dir: "asc"
                },
                serverSorting: true,
                pageSize: 32
            });
            $("#listview_mbti_question").kendoMobileListView({
                dataSource: page.MBTIQuestionDataSource,
                template: $("#listview-mbti-question-template").text(),
            });
            page.MBTIvalidator = $("#MBTIForm").kendoValidator({
                rules: {
                    radio: function(input) {
                        if (input.filter("[type=radio]") && input.attr("required")) {
                            return $("#MBTIForm").find("[type=radio][name=" + input.attr("name") + "]")
                                .is(":checked");
                        }
                        return true;
                    }
                },
                messages: {
                    radio: "This is a required field"
                }
            }).getKendoValidator();
        }
        page.prototype.refreshMBTI = function(e) {
            ajax("var.json", "POST", "json", ({}), false, true, function(response) {
                page.mbti_cover_bg = response;
            });
            e.view.element.find("#mbti_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'M B T I&nbsp;&nbsp;T E S T' : 'แบบทดสอบบุคลิกภาพ';?>");
            e.view.element.find("#takethetest").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'Take the Test' : 'ทำแบบทดสอบ';?>");
                
            var index = 0;
            $.each(page.mbti_cover_bg.cover_bg, function(i, v) {
                if (v.type == '<?=$_SESSION['user']['data'][0]['mbti']?>')
                    index = i;
            });
            $('#mbti_cover_bg').css('background-image', 'url(images/' + page.mbti_cover_bg.cover_bg[index].header +
                ')');
            if ('<?=$_SESSION['user']['data'][0]['mbti']?>' == '') {
                $('#mbti_type').html('????');
            } else {
                $('#mbti_type').html(page.mbti_cover_bg.cover_bg[index].type);
            }
            $('#btnUpdateMBTI').click(function() {
                if (page.MBTIvalidator.validate()) {
                    var i = 0,
                        e = 0,
                        s = 0,
                        n = 0,
                        t = 0,
                        f = 0,
                        j = 0,
                        p = 0;
                    var mbti, mbti1, mbti2, mbti3, mbti4;
                    $('input[name="answer1"]:checked').val() == 'a' ? n++ : s++;
                    $('input[name="answer2"]:checked').val() == 'a' ? i++ : e++;
                    $('input[name="answer3"]:checked').val() == 'a' ? t++ : f++;
                    $('input[name="answer4"]:checked').val() == 'a' ? j++ : p++;
                    $('input[name="answer5"]:checked').val() == 'a' ? t++ : f++;
                    $('input[name="answer6"]:checked').val() == 'a' ? i++ : e++;
                    $('input[name="answer7"]:checked').val() == 'a' ? j++ : p++;
                    $('input[name="answer8"]:checked').val() == 'a' ? p++ : j++;
                    $('input[name="answer9"]:checked').val() == 'a' ? j++ : p++;
                    $('input[name="answer10"]:checked').val() == 'a' ? n++ : s++;
                    $('input[name="answer11"]:checked').val() == 'a' ? i++ : e++;
                    $('input[name="answer12"]:checked').val() == 'a' ? t++ : f++;
                    $('input[name="answer13"]:checked').val() == 'a' ? s++ : n++;
                    $('input[name="answer14"]:checked').val() == 'a' ? f++ : t++;
                    $('input[name="answer15"]:checked').val() == 'a' ? e++ : i++;
                    $('input[name="answer16"]:checked').val() == 'a' ? s++ : n++;
                    $('input[name="answer17"]:checked').val() == 'a' ? s++ : n++;
                    $('input[name="answer18"]:checked').val() == 'a' ? p++ : j++;
                    $('input[name="answer19"]:checked').val() == 'a' ? e++ : i++;
                    $('input[name="answer20"]:checked').val() == 'a' ? t++ : f++;
                    $('input[name="answer21"]:checked').val() == 'a' ? s++ : n++;
                    $('input[name="answer22"]:checked').val() == 'a' ? i++ : e++;
                    $('input[name="answer23"]:checked').val() == 'a' ? p++ : j++;
                    $('input[name="answer24"]:checked').val() == 'a' ? f++ : t++;
                    $('input[name="answer25"]:checked').val() == 'a' ? t++ : f++;
                    $('input[name="answer26"]:checked').val() == 'a' ? j++ : p++;
                    $('input[name="answer27"]:checked').val() == 'a' ? e++ : i++;
                    $('input[name="answer28"]:checked').val() == 'a' ? n++ : s++;
                    $('input[name="answer29"]:checked').val() == 'a' ? f++ : t++;
                    $('input[name="answer30"]:checked').val() == 'a' ? n++ : s++;
                    $('input[name="answer31"]:checked').val() == 'a' ? j++ : p++;
                    $('input[name="answer32"]:checked').val() == 'a' ? e++ : i++;
                    //console.log('i='+i,'e='+e,'s='+s,'n='+n,'t='+t,'f='+f,'j='+j,'p='+p);
                    if (i == e) {
                        $('input[name="answer11"]:checked').val() == 'a' ? i-- : e--;
                    }
                    if (s == n) {
                        $('input[name="answer16"]:checked').val() == 'a' ? s-- : n--;
                    }
                    if (t == f) {
                        $('input[name="answer24"]:checked').val() == 'a' ? f-- : t--;
                    }
                    if (j == p) {
                        $('input[name="answer23"]:checked').val() == 'a' ? p-- : j--;
                    }
                    //console.log('i='+i,'e='+e,'s='+s,'n='+n,'t='+t,'f='+f,'j='+j,'p='+p);
                    mbti1 = (i > e) ? 'I' : 'E';
                    mbti2 = (s > n) ? 'S' : 'N';
                    mbti3 = (t > f) ? 'T' : 'F';
                    mbti4 = (j > p) ? 'J' : 'P';
                    mbti = mbti1 + mbti2 + mbti3 + mbti4;
                    //console.log(mbti);
                    if (!page.clicked) {
                        page.clicked = true;
                        ajax("app.php", "POST", "json", ({
                            mode: 'updateMBTI',
                            mbti: mbti
                        }), true, true, function() {
                            kendo.alert(
                                '<?=$_SESSION['setting']['lang'] == 'en' ? "Successful operation." : "การดำเนินการเสร็จสมบูรณ์"?>'
                            );
                            //app.navigate('#mainmenu');
                            page.clicked = false;
                        });
                    }
                }
            });

        }
        page.prototype.refreshSetting = function(e) {
            e.view.element.find("#default_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'S E T T I N G' : 'ตั้งค่าภาษา';?>");
        }
        page.prototype.initEvaluation = function(e) {
            page.evaluationDataSource = new kendo.data.DataSource({
                transport: {
                    read: {
                        dataType: 'json',
                        type: 'POST',
                        data: ({
                            mode: 'selectAllGroupInformation'
                        }),
                        url: 'app.php'
                    }
                },
                autoSync: false,
                schema: {
                    data: 'data',
                    total: 'total'
                },
                sort: {
                    field: "gi.groupInfoID",
                    dir: "desc"
                },
                filter: [{
                    field: "gi.userID",
                    operator: "eq",
                    value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                }],
                serverPaging: true,
                serverSorting: true,
                serverFiltering: true,
                pageSize: 20
            });
            $("#evaluation-listview").kendoMobileListView({
                dataSource: page.evaluationDataSource,
                endlessScroll: true,
                pullToRefresh: true,
                template: $("#evaluation-listview-template").text(),
            }).kendoTouch({
                filter: ">li",
                tap: function(e) {
                    var itemUID = $(e.touch.target).data("uid");
                    var data;
                    for (var i = 0; i < page.evaluationDataSource._data.length; i++) {
                        if (page.evaluationDataSource._data[i].uid == itemUID) {
                            data = page.evaluationDataSource._data[i];
                            break;
                        }
                    }
                    app.navigate('#evaluationDetail?assignID=' + data.assignID + '&groupNum=' + data
                        .groupNum + '&assignTitle=' + data.assignTitle);
                },

            });

        }
        page.prototype.refreshEvaluation = function(e) {
            e.view.element.find("#evaluation_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'E V A L U A T I O N' : 'การประเมิน';?>");
            page.evaluationDataSource.filter({
                field: "gi.userID",
                operator: "eq",
                value: '<?=$_SESSION['user']['data'][0]['userID']?>'
            });
        }
        page.prototype.refreshEvaluationDetail = function(e) {
            e.view.element.find("#default_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'G R O U P ' : 'สมาชิกกลุ่ม ';?>" + e.view.params
                .groupNum + ' : ' + e.view.params.assignTitle);
            page.evaluationDetailDataSource = new kendo.data.DataSource({
                transport: {
                    read: {
                        dataType: 'json',
                        type: 'POST',
                        data: ({
                            mode: 'selectGroupInformation',
                            assignID: e.view.params.assignID,
                            groupNum: e.view.params.groupNum
                        }),
                        url: 'app.php'
                    }
                },
                autoSync: false,
                schema: {
                    data: 'data',
                    total: 'total'
                },
                sort: {
                    field: "gi.groupInfoID",
                    dir: "desc"
                },
                filter: [{
                    field: "gi.userID",
                    operator: "eq",
                    value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                }],
                serverPaging: true,
                serverSorting: true,
                serverFiltering: true,
                pageSize: 20

            });
            $("#evaluation-detail-listview").kendoMobileListView({
                dataSource: page.evaluationDetailDataSource,
                endlessScroll: true,
                pullToRefresh: true,
                template: $("#evaluation-detail-listview-template").text(),
            }).kendoTouch({
                filter: ">li",
                tap: function(e) {
                    var itemUID = $(e.touch.target).data("uid");
                    var data;
                    for (var i = 0; i < page.evaluationDetailDataSource._data.length; i++) {
                        if (page.evaluationDetailDataSource._data[i].uid == itemUID) {
                            data = page.evaluationDetailDataSource._data[i];
                            break;
                        }
                    }
                    app.navigate('#evaluationCheck?assignID=' + data.assignID + '&groupNum=' + data
                        .groupNum + '&userID=' + data.userID + '&fullName=' + data.fullName);
                },

            });
        }
        page.prototype.refreshEvaluationCheck = function(e) {
            e.view.element.find("#evaluation_check_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'Evaluation from' : 'แบบฟอร์มการประเมิน';?>");
            $('#evaluationCheck-title').html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'Evaluation for' : 'แบบฟอร์มการประเมินสำหรับ';?><br>" + e
                .view.params.fullName);
            $('#btnEvaluationResult').click(function() {
                app.navigate('#evaluationResult?assignID=' + e.view.params.assignID + '&groupNum=' + e.view
                    .params.groupNum + '&userID=' + e.view.params.userID + '&fullName=' + e.view.params
                    .fullName);
            });
            $('#btnUpdateEvaluation').click(function() {
                if (page.evaluationValidator.validate()) {
                    var answer = [];
                    answer.push({
                        "questionNo": 1,
                        "assignID": e.view.params.assignID,
                        "groupNum": e.view.params.groupNum,
                        "userID": e.view.params.userID,
                        "answer": $('input[name="ev_answer1"]:checked').val(),
                        "suggestion": null
                    });
                    answer.push({
                        "questionNo": 2,
                        "assignID": e.view.params.assignID,
                        "groupNum": e.view.params.groupNum,
                        "userID": e.view.params.userID,
                        "answer": $('input[name="ev_answer2"]:checked').val(),
                        "suggestion": null
                    });
                    answer.push({
                        "questionNo": 3,
                        "assignID": e.view.params.assignID,
                        "groupNum": e.view.params.groupNum,
                        "userID": e.view.params.userID,
                        "answer": $('input[name="ev_answer3"]:checked').val(),
                        "suggestion": null
                    });
                    answer.push({
                        "questionNo": 4,
                        "assignID": e.view.params.assignID,
                        "groupNum": e.view.params.groupNum,
                        "userID": e.view.params.userID,
                        "answer": $('input[name="ev_answer4"]:checked').val(),
                        "suggestion": null
                    });
                    answer.push({
                        "questionNo": 5,
                        "assignID": e.view.params.assignID,
                        "groupNum": e.view.params.groupNum,
                        "userID": e.view.params.userID,
                        "answer": $('input[name="ev_answer5"]:checked').val(),
                        "suggestion": null
                    });
                    answer.push({
                        "questionNo": 6,
                        "assignID": e.view.params.assignID,
                        "groupNum": e.view.params.groupNum,
                        "userID": e.view.params.userID,
                        "answer": null,
                        "suggestion": $('#ev_answer6').val()
                    });
                    //console.log(answer);
                    if (!page.clicked) {
                        page.clicked = true;
                        ajax("app.php", "POST", "json", ({
                            mode: 'insertEvaluationAnswer',
                            answer: answer
                        }), true, true, function() {
                            kendo.alert(
                                '<?=$_SESSION['setting']['lang'] == 'en' ? "Successful operation." : "การดำเนินการเสร็จสมบูรณ์"?>'
                            );
                            page.clicked = false;
                            //app.navigate('#evaluation');
                        });
                    }
                }
            });
            page.evaluationQuestionDataSource = new kendo.data.DataSource({
                transport: {
                    read: {
                        dataType: 'json',
                        type: 'POST',
                        data: ({
                            mode: 'selectAllEvaluationQuestion'
                        }),
                        url: 'app.php'
                    }
                },
                autoSync: false,
                schema: {
                    data: 'data',
                    total: 'total'
                },
                sort: {
                    field: "questionNo",
                    dir: "asc"
                },
                serverSorting: true,
                pageSize: 6
            });
            $("#listview_evaluation_question").kendoMobileListView({
                dataSource: page.evaluationQuestionDataSource,
                template: $("#listview-evaluation-question-template").text(),
            });
            page.evaluationValidator = $("#EvaluationForm").kendoValidator({
                rules: {
                    radio: function(input) {
                        if (input.filter("[type=radio]") && input.attr("required")) {
                            return $("#EvaluationForm").find("[type=radio][name=" + input.attr("name") +
                                "]").is(":checked");
                        }
                        return true;
                    }
                },
                messages: {
                    radio: "This is a required field"
                }
            }).getKendoValidator();
        }
        page.prototype.searchEvaluation = function(searchstring) {
            var searchstring = searchstring.toUpperCase();
            var searchword = searchstring.split(' ');
            if (searchstring.length != 0) {
                var orfilter = {
                    logic: 'or',
                    filters: []
                };
                var andfilter = {
                    logic: 'and',
                    filters: []
                };
                $.each(searchword, function(i, v1) {
                    if (v1.trim() != '') {
                        if (v1.trim() != '') {
                            orfilter.filters.push({
                                field: 'ci.courseCode',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ci.courseName',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ass.assignTitle',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ass.assignDescription',
                                operator: 'contains',
                                value: v1
                            }, );
                            andfilter.filters.push(orfilter);
                            andfilter.filters.push({
                                field: "gi.userID",
                                operator: "eq",
                                value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                            });
                            orfilter = {
                                logic: 'or',
                                filters: []
                            };
                        }
                    }
                });
                page.evaluationDataSource.filter(andfilter);
            } else {
                page.evaluationDataSource.filter({
                    field: "gi.userID",
                    operator: "eq",
                    value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                });
            }
            var scroller = $('#evaluation-listview').data('kendoMobileListView').scroller();
            scroller.reset();
        }
        page.prototype.refreshEvaluationResult = function(e) {
            e.view.element.find("#default_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'Evaluation result' : 'ผลการประเมิน';?>");
            $('#evaluationResult-title').html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'Evaluation result for' : 'ผลการประเมินสำหรับ';?><br>" + e
                .view.params.fullName);
            ajax("app.php", "POST", "json", ({
                mode: 'selectAllEvaluationResult',
                assignID: e.view.params.assignID,
                groupNum: e.view.params.groupNum,
                userID: e.view.params.userID,
            }), true, true, function(response) {
                var html = '';
                var result = '';
                html += '<div class="divTable">';
                html += '<div class="divTableBody">';
                $.each(response.data, function(i, v) {
                    result = '';
                    if (v['result'] >= 0 && v['result'] < 1) {
                        result = 'ปรับปรุง';
                    } else if (v['result'] >= 1 && v['result'] < 2) {
                        result = 'ไม่พอใจ';
                    } else if (v['result'] >= 2 && v['result'] < 3) {
                        result = 'พอใจ';
                    } else if (v['result'] >= 3 && v['result'] < 4) {
                        result = 'พอใจมาก';
                    } else if (v['result'] >= 4) {
                        result = 'ดีเด่น';
                    }
                    html += '<div class="divTableRow">';
                    html += '<div class="divTableCell">' + v['questionNo'] + '</div>';
                    html += '<div class="divTableCell" style="text-align:left">' + v['question'] +
                        '</div>';
                    html += '<div class="divTableCell">' + v['result'] + '</div>';
                    if (v['questionNo'] != '6') html += '<div class="divTableCell">' + result +
                        '</div>';
                    html += '</div>';
                });
                html += '</div>';
                html += '</div>';
                $('#evaluationResult-panel').html(html);
            });
        }
        page.prototype.refreshMyRegistrationInformation = function(e) {
            e.view.element.find("#registration_information_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'R E G I S T R A T I O N&nbsp;&nbsp;I N F O R M A T I O N' : 'รายวิชาที่เปิดสอน';?>"
            );
            page.MyRegistrationInformationDataSource = new kendo.data.DataSource({
                transport: {
                    read: {
                        dataType: 'json',
                        type: 'POST',
                        data: ({
                            mode: 'selectAllRegistrationInformation'
                        }),
                        url: 'app.php'
                    }
                },
                autoSync: false,
                schema: {
                    data: 'data',
                    total: 'total'
                },
                sort: {
                    field: "regisID",
                    dir: "desc"
                },
                filter: [{
                    field: "userID",
                    operator: "eq",
                    value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                }],
                serverPaging: true,
                serverSorting: true,
                serverFiltering: true,
                pageSize: 20
            });
            $("#listview_my_registration_information").kendoMobileListView({
                dataSource: page.MyRegistrationInformationDataSource,
                endlessScroll: true,
                pullToRefresh: true,
                template: $("#listview_my_registration_information_template").text(),
            }).kendoTouch({
                filter: ">li",
                tap: function(e) {
                    var itemUID = $(e.touch.target).data("uid");
                    var data;
                    for (var i = 0; i < page.MyRegistrationInformationDataSource._data.length; i++) {
                        if (page.MyRegistrationInformationDataSource._data[i].uid == itemUID) {
                            data = page.MyRegistrationInformationDataSource._data[i];
                            break;
                        }
                    }
                    app.navigate('#teacherAssignment?regisID=' + data.regisID);
                },

            });
        }
        page.prototype.searchMyRegistrationInformation = function(searchstring) {
            var searchstring = searchstring.toUpperCase();
            var searchword = searchstring.split(' ');
            if (searchstring.length != 0) {
                var orfilter = {
                    logic: 'or',
                    filters: []
                };
                var andfilter = {
                    logic: 'and',
                    filters: []
                };
                $.each(searchword, function(i, v1) {
                    if (v1.trim() != '') {
                        if (v1.trim() != '') {
                            orfilter.filters.push({
                                field: 'ci.courseCode',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ci.courseName',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'us.fullName',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ri.classGroup',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ri.year',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ri.semester',
                                operator: 'contains',
                                value: v1
                            }, );
                            andfilter.filters.push(orfilter);
                            andfilter.filters.push({
                                field: "ri.userID",
                                operator: "eq",
                                value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                            });
                            orfilter = {
                                logic: 'or',
                                filters: []
                            };
                        }
                    }
                });
                page.MyRegistrationInformationDataSource.filter(andfilter);
            } else {
                page.MyRegistrationInformationDataSource.filter({
                    field: "ri.userID",
                    operator: "eq",
                    value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                });
            }
            var scroller = $('#listview_my_registration_information').data('kendoMobileListView').scroller();
            scroller.reset();
        }
        page.prototype.refreshTeacherAssignment = function(e) {
            e.view.element.find("#teacher_assignment_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'M Y&nbsp;&nbsp;A S S I G N M E N T' : 'การมอบหมายงานของฉัน';?>"
            );
            page.teacherAssignmentDataSource = new kendo.data.DataSource({
                transport: {
                    read: {
                        dataType: 'json',
                        type: 'POST',
                        data: ({
                            mode: 'selectAllAssignment'
                        }),
                        url: 'app.php'
                    }
                },
                autoSync: false,
                schema: {
                    data: 'data',
                    total: 'total'
                },
                sort: {
                    field: "assignID",
                    dir: "desc"
                },
                filter: [{
                    field: "regisID",
                    operator: "eq",
                    value: e.view.params.regisID
                }],
                serverPaging: true,
                serverSorting: true,
                serverFiltering: true,
                pageSize: 20
            });
            $("#listview_teacher_assignment").kendoMobileListView({
                dataSource: page.teacherAssignmentDataSource,
                endlessScroll: true,
                pullToRefresh: true,
                template: $("#listview_teacher_assignment_template").text(),
            }).kendoTouch({
                filter: ">li",
                tap: function(e) {
                    var itemUID = $(e.touch.target).data("uid");
                    var data;
                    for (var i = 0; i < page.teacherAssignmentDataSource._data.length; i++) {
                        if (page.teacherAssignmentDataSource._data[i].uid == itemUID) {
                            data = page.teacherAssignmentDataSource._data[i];
                            break;
                        }
                    }
                    app.navigate('#teacherAssignmentGroup?assignID=' + data.assignID + '&classGroup=' +
                        data.classGroup);
                },
            });
        }
        page.prototype.refreshTeacherAssignmentGroup = function(e) {
            ajax("app.php", "POST", "json", ({
                mode: 'selectAssignment',
                assignID: e.view.params.assignID,
            }), true, true, function(response) {
                e.view.element.find("#teacher_assignment_group_layout_title").html(
                    "<?=$_SESSION['setting']['lang'] == 'en' ? 'A S S I G N M E N T&nbsp;&nbsp;G R O U P' : 'กลุ่มทั้งหมด';?>"
                );
                $('#teacherAssignmentGroup_courseCode span').html(response.data[0]['courseCode'] + ' ' + response.data[0]['courseName']);
                $('#teacherAssignmentGroup_assignTitle span').html(response.data[0]['assignTitle']);
                $('#teacherAssignmentGroup_assignDescription span').html(response.data[0]['assignDescription']);
                $('#teacherAssignmentGroup_assignDate span').html(response.data[0]['assignDate'] + ' ' + response.data[0]['semester'] + '/' + response.data[0]['year']);
                $('#teacherAssignmentGroup_deadline span').html(response.data[0]['deadline']);
                $('#teacherAssignmentGroup_numGroup span').html(response.data[0]['numGroup']);

                //--
                ajax("app.php", "POST", "json", ({
                    mode: 'calGroupInformation',
                    assignID: e.view.params.assignID,
                }), true, true, function(response) {
                    var html = '';
                    $.each(response, function(i, v) {
                        html +=
                            '<p><b><?=$_SESSION['setting']['lang'] == 'en' ? 'Group : ' : 'กลุ่มที่ : ';?> ' +
                            v.groupNum +
                            '</b> <br><?=$_SESSION['setting']['lang'] == 'en' ? 'for : ' : 'จำนวนสมาชิก : ';?> ' +
                            v.member +
                            ' <?=$_SESSION['setting']['lang'] == 'en' ? 'people' : 'คน ';?><br>';
                        html +=
                            '<?=$_SESSION['setting']['lang'] == 'en' ? 'Total member : ' : 'จำนวนสมาชิกทั้งหมด : ';?>' +
                            v.totalMember +
                            ' <?=$_SESSION['setting']['lang'] == 'en' ? 'people' : 'คน ';?><br>';
                        html +=
                            '<?=$_SESSION['setting']['lang'] == 'en' ? 'Avaliable : ' : 'สามารถรับสมาชิกได้อีก : ';?>' +
                            v.avaliable +
                            ' <?=$_SESSION['setting']['lang'] == 'en' ? 'people' : 'คน ';?><br>';
                        ajax("app.php", "POST", "json", ({
                            mode: 'selectGroupInformation',
                            assignID: e.view.params.assignID,
                            groupNum: v.groupNum
                        }), false, true, function(response) {
                            html += '<ol>';
                            $.each(response['data'], function(ii, vv) {
                                html += '<li>';
                                html += vv['fullName'] + ' ' + vv[
                                    'responsibility'];
                                html += '</li>';
                            });
                            html += '</ol>';
                        });
                        html += '<hr></p>';

                    });
                    $('#teacherAssignmentGroupList').html(html);
                });
                ajax("app.php", "POST", "json", ({
                    mode: 'nonGroupInformation',
                    assignID: e.view.params.assignID,
                    classGroup: e.view.params.classGroup
                }), true, true, function(response) {
                    var html = '';
                    html +=
                        '<p><b><?=$_SESSION['setting']['lang'] == 'en' ? 'Students who do not yet have a group  : ' : 'นักศึกษาที่ยังไม่มีกลุ่ม : ';?> </b>' +
                        response.total + '</p>';
                    html += '<ol>';
                    $.each(response.data, function(i, v) {
                        html += '<li>';
                        html += v['userCode'] + ' ' + v['fullName'];
                        html += '</li>';
                    });

                    html += '</ol>';
                    $('#teacherAssignmentGroupListNonGroup').html(html);

                });
            });
        }
        page.prototype.refreshAllRegistrationInformation = function(e) {
            e.view.element.find("#all_registration_information_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'R E G I S T R A T I O N&nbsp;&nbsp;I N F O R M A T I O N' : 'รายวิชาที่เปิดสอน';?>"
            );
            page.MyRegistrationInformationDataSource = new kendo.data.DataSource({
                transport: {
                    read: {
                        dataType: 'json',
                        type: 'POST',
                        data: ({
                            mode: 'selectAllRegistrationInformation'
                        }),
                        url: 'app.php'
                    }
                },
                autoSync: false,
                schema: {
                    data: 'data',
                    total: 'total'
                },
                sort: {
                    field: "regisID",
                    dir: "desc"
                },
                filter: [{
                    field: "userID",
                    operator: "eq",
                    value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                }],
                serverPaging: true,
                serverSorting: true,
                serverFiltering: true,
                pageSize: 20
            });
            $("#listview_all_registration_information").kendoMobileListView({
                dataSource: page.MyRegistrationInformationDataSource,
                endlessScroll: true,
                pullToRefresh: true,
                template: $("#listview_all_registration_information_template").text(),
            }).kendoTouch({
                filter: ">li",
                tap: function(e) {
                    var itemUID = $(e.touch.target).data("uid");
                    var data;
                    for (var i = 0; i < page.MyRegistrationInformationDataSource._data.length; i++) {
                        if (page.MyRegistrationInformationDataSource._data[i].uid == itemUID) {
                            data = page.MyRegistrationInformationDataSource._data[i];
                            break;
                        }
                    }
                    app.navigate('#teacherAssignmentDetail?regisID=' + data.regisID + '&classGroup=' +
                        data.classGroup);
                },

            });
        }
        page.prototype.initTeacherAssignmentDetail = function(e) {
            $("#groupTypeID").kendoDropDownList({
                optionLabel: "<?=$_SESSION['setting']['lang'] == 'en' ? "Select group type..." : "เลือกประเภทการจับกลุ่ม"?>",
                dataTextField: "groupType",
                dataValueField: "groupTypeID",
                dataSource: {
                    transport: {
                        read: {
                            dataType: "json",
                            type: "POST",
                            data: ({
                                mode: 'selectAllGroupType'
                            }),
                            url: 'app.php'
                        }
                    },
                    schema: {
                        data: "data",
                        total: "total"
                    },
                    serverFiltering: true,
                    filter: [{
                        field: "status",
                        operator: "eq",
                        value: '1'
                    }]
                }
            });
        }
        page.prototype.refreshTeacherAssignmentDetail = function(e) {
            e.view.element.find("#teacher_assignment_detail_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'M A K E&nbsp;&nbsp;A N&nbsp;&nbsp;A S S I G N M E N T' : 'สร้างการมอบหมายงาน';?>"
            );
            ajax("app.php", "POST", "json", ({
                mode: 'selectRegistrationInformation',
                regisID: e.view.params.regisID,
            }), true, true, function(response) {
                var html = '';
                html += '<div>' +
                    '<b><?=$_SESSION['setting']['lang'] == 'en' ? 'Course Name : ' : 'วิชา : ';?></b>' + response
                    .data[0].courseCode + ' ' + response.data[0].courseName + '</div>';
                html += '<div>' +
                    '<b><?=$_SESSION['setting']['lang'] == 'en' ? 'Instructure : ' : 'ผู้สอน : ';?></b>' +
                    response.data[0].fullName + '</div>';
                html += '<div>' +
                    '<b><?=$_SESSION['setting']['lang'] == 'en' ? 'Section : ' : 'กลุ่มเรียน : ';?></b>' +
                    response.data[0].classGroup + '</div>';
                html += '<div>' +
                    '<b><?=$_SESSION['setting']['lang'] == 'en' ? 'Year : ' : 'ปีการศึกษา : ';?></b>' + response
                    .data[0].year + '</div>';
                html += '<div>' +
                    '<b><?=$_SESSION['setting']['lang'] == 'en' ? 'Semester : ' : 'ภาคการศึกษา : ';?></b>' +
                    response.data[0].semester + '</div>';
                $('#teacherAssignmentDetailList').html(html);
            });
            $('#btnUpdateAssignment').click(function() {
                if (!page.clicked) {
                    page.clicked = true;
                    if (page.assignmentValidator.validate()) {
                        ajax("app.php", "POST", "json", ({
                            mode: 'insertAssignment',
                            regisID: e.view.params.regisID,
                            classGroup: e.view.params.classGroup,
                            groupTypeID: $('#groupTypeID').val(),
                            assignTitle :  $('#assignTitle').val(),
                            assignDescription :  $('#assignDescription').val(),
                            assignDate: $('#assignDate').val() + ' ' + $('#assignTime').val(),
                            deadline: $('#deadline').val() + ' ' + $('#timeout').val(),
                            numGroup: $('#numGroup').val(),
                        }), true, true, function(response) {
                            if (response == '1') {
                                kendo.alert(
                                    '<?php echo $_SESSION['setting']['lang'] == 'en' ? "Successful operation." : "การดำเนินการเสร็จสมบูรณ์" ?>'
                                    );
                                HTMLFormElement.prototype.reset.call($('#assignmentForm')[0]);
                                app.navigate('#my_registration_information');
                            }
                            page.clicked = false;
                        });
                    }
                }

            });
            page.assignmentValidator = $("#assignmentForm").kendoValidator({
                rules: {

                },
                messages: {

                }
            }).getKendoValidator();

        }
        page.prototype.refreshMyRegistrationInformationDiscussion = function(e) {
            e.view.element.find("#registration_information_discussion_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'D I S C U S S I O N' : 'ช่องการสนทนา';?>"
            );
            page.MyRegistrationInformationDataSource = new kendo.data.DataSource({
                transport: {
                    read: {
                        dataType: 'json',
                        type: 'POST',
                        data: ({
                            mode: 'selectAllRegistrationInformation'
                        }),
                        url: 'app.php'
                    }
                },
                autoSync: false,
                schema: {
                    data: 'data',
                    total: 'total'
                },
                sort: {
                    field: "regisID",
                    dir: "desc"
                },
                filter: [{
                    field: "userID",
                    operator: "eq",
                    value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                }],
                serverPaging: true,
                serverSorting: true,
                serverFiltering: true,
                pageSize: 20
            });
            $("#listview_my_registration_information_discussion").kendoMobileListView({
                dataSource: page.MyRegistrationInformationDataSource,
                endlessScroll: true,
                pullToRefresh: true,
                template: $("#listview_my_registration_information_template").text(),
            }).kendoTouch({
                filter: ">li",
                tap: function(e) {
                    var itemUID = $(e.touch.target).data("uid");
                    var data;
                    for (var i = 0; i < page.MyRegistrationInformationDataSource._data.length; i++) {
                        if (page.MyRegistrationInformationDataSource._data[i].uid == itemUID) {
                            data = page.MyRegistrationInformationDataSource._data[i];
                            break;
                        }
                    }
                    app.navigate('#teacherAssignment_discussion?regisID=' + data.regisID);
                },

            });
        }
        page.prototype.searchMyRegistrationInformationDiscussion = function(searchstring) {
            var searchstring = searchstring.toUpperCase();
            var searchword = searchstring.split(' ');
            if (searchstring.length != 0) {
                var orfilter = {
                    logic: 'or',
                    filters: []
                };
                var andfilter = {
                    logic: 'and',
                    filters: []
                };
                $.each(searchword, function(i, v1) {
                    if (v1.trim() != '') {
                        if (v1.trim() != '') {
                            orfilter.filters.push({
                                field: 'ci.courseCode',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ci.courseName',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'us.fullName',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ri.classGroup',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ri.year',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ri.semester',
                                operator: 'contains',
                                value: v1
                            }, );
                            andfilter.filters.push(orfilter);
                            andfilter.filters.push({
                                field: "ri.userID",
                                operator: "eq",
                                value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                            });
                            orfilter = {
                                logic: 'or',
                                filters: []
                            };
                        }
                    }
                });
                page.MyRegistrationInformationDataSource.filter(andfilter);
            } else {
                page.MyRegistrationInformationDataSource.filter({
                    field: "ri.userID",
                    operator: "eq",
                    value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                });
            }
            var scroller = $('#listview_my_registration_information_discussion').data('kendoMobileListView')
                .scroller();
            scroller.reset();
        }
        page.prototype.refreshTeacherAssignmentDiscussion = function(e) {
            e.view.element.find("#teacher_assignment_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'D I S C U S S I O N' : 'ช่องการสนทนา';?>"
            );
            page.teacherAssignmentDataSource = new kendo.data.DataSource({
                transport: {
                    read: {
                        dataType: 'json',
                        type: 'POST',
                        data: ({
                            mode: 'selectAllAssignment'
                        }),
                        url: 'app.php'
                    }
                },
                autoSync: false,
                schema: {
                    data: 'data',
                    total: 'total'
                },
                sort: {
                    field: "assignID",
                    dir: "desc"
                },
                filter: [{
                    field: "regisID",
                    operator: "eq",
                    value: e.view.params.regisID
                }],
                serverPaging: true,
                serverSorting: true,
                serverFiltering: true,
                pageSize: 20
            });
            $("#listview_teacher_assignment_discussion").kendoMobileListView({
                dataSource: page.teacherAssignmentDataSource,
                endlessScroll: true,
                pullToRefresh: true,
                template: $("#listview_teacher_assignment_template").text(),
            }).kendoTouch({
                filter: ">li",
                tap: function(e) {
                    var itemUID = $(e.touch.target).data("uid");
                    var data;
                    for (var i = 0; i < page.teacherAssignmentDataSource._data.length; i++) {
                        if (page.teacherAssignmentDataSource._data[i].uid == itemUID) {
                            data = page.teacherAssignmentDataSource._data[i];
                            break;
                        }
                    }
                    app.navigate('#teacherAssignmentGroupDiscussion?assignID=' + data.assignID +
                        '&classGroup=' + data.classGroup);
                },
            });
        }
        page.prototype.refreshTeacherAssignmentGroupDiscussion = function(e) {
            ajax("app.php", "POST", "json", ({
                mode: 'selectAssignment',
                assignID: e.view.params.assignID,
            }), true, true, function(response) {
                e.view.element.find("#teacher_assignment_group_layout_title").html(
                    "<?=$_SESSION['setting']['lang'] == 'en' ? 'D I S C U S S I O N' : 'ช่องการสนทนา';?>"
                );
                $('#teacherAssignmentGroupDiscussion_courseCode span').html(response.data[0]['courseCode'] +' ' + response.data[0]['courseName']);
                $('#teacherAssignmentGroupDiscussion_assignTitle span').html(response.data[0]['assignTitle']);
                $('#teacherAssignmentGroupDiscussion_assignDescription span').html(response.data[0]['assignDescription']);
                $('#teacherAssignmentGroupDiscussion_assignDate span').html(response.data[0]['assignDate'] +' ' + response.data[0]['semester'] + '/' + response.data[0]['year']);
                $('#teacherAssignmentGroupDiscussion_deadline span').html(response.data[0]['deadline']);
                $('#teacherAssignmentGroupDiscussion_numGroup span').html(response.data[0]['numGroup']);

                //--
                ajax("app.php", "POST", "json", ({
                    mode: 'calGroupInformation',
                    assignID: e.view.params.assignID,
                }), true, true, function(ret) {
                    var html = '';
                    $.each(ret, function(i, v) {
                        html += '<a class="listlink" href="#discussroom?assignID=' +
                            e.view.params.assignID + '&groupNum=' + v.groupNum +
                            '&courseCode=' + response.data[0].courseCode + '&courseName=' +
                            response.data[0].courseName + '&assignTitle=' + response.data[0]
                            .assignTitle + '&userID=' + response.data[0].userID + '">';
                        html +=
                            '<b><?=$_SESSION['setting']['lang'] == 'en' ? 'Group : ' : 'กลุ่มที่ : ';?> ' +
                            v.groupNum +
                            '</b> <br><?=$_SESSION['setting']['lang'] == 'en' ? 'for : ' : 'จำนวนสมาชิก : ';?> ' +
                            v.member +
                            ' <?=$_SESSION['setting']['lang'] == 'en' ? 'people' : 'คน ';?><br>';
                        html +=
                            '<?=$_SESSION['setting']['lang'] == 'en' ? 'Total member : ' : 'จำนวนสมาชิกทั้งหมด : ';?>' +
                            v.totalMember +
                            ' <?=$_SESSION['setting']['lang'] == 'en' ? 'people' : 'คน ';?><br>';
                        html +=
                            '<?=$_SESSION['setting']['lang'] == 'en' ? 'Avaliable : ' : 'สามารถรับสมาชิกได้อีก : ';?>' +
                            v.avaliable +
                            ' <?=$_SESSION['setting']['lang'] == 'en' ? 'people' : 'คน ';?><br>';
                        ajax("app.php", "POST", "json", ({
                            mode: 'selectGroupInformation',
                            assignID: e.view.params.assignID,
                            groupNum: v.groupNum
                        }), false, true, function(rets) {
                            html += '<ol>';
                            $.each(rets['data'], function(ii, vv) {
                                html += '<li>';
                                html += vv['fullName'] + ' ' + vv[
                                    'responsibility'];
                                html += '</li>';
                            });
                            html += '</ol>';
                        });
                        html += '<hr></a>';
                    });
                    $('#teacherAssignmentGroupDiscussionList').html(html);
                });
                ajax("app.php", "POST", "json", ({
                    mode: 'nonGroupInformation',
                    assignID: e.view.params.assignID,
                    classGroup: e.view.params.classGroup
                }), true, true, function(response) {
                    var html = '';
                    html +=
                        '<p><b><?=$_SESSION['setting']['lang'] == 'en' ? 'Students who do not yet have a group  : ' : 'นักศึกษาที่ยังไม่มีกลุ่ม : ';?> </b>' +
                        response.total + '</p>';
                    html += '<ol>';
                    $.each(response.data, function(i, v) {

                        html += '<li>';
                        html += v['userCode'] + ' ' + v['fullName'];
                        html += '</li>';

                    });

                    html += '</ol>';

                    $('#teacherAssignmentGroupDiscussionListNonGroup').html(html);

                });
            });
        }
        page.prototype.refreshMyRegistrationInformationEvaluation = function(e) {
            e.view.element.find("#registration_information_evaluation_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'E V A L U A T I O N' : 'การประเมิน';?>"
            );
            page.MyRegistrationInformationDataSource = new kendo.data.DataSource({
                transport: {
                    read: {
                        dataType: 'json',
                        type: 'POST',
                        data: ({
                            mode: 'selectAllRegistrationInformation'
                        }),
                        url: 'app.php'
                    }
                },
                autoSync: false,
                schema: {
                    data: 'data',
                    total: 'total'
                },
                sort: {
                    field: "regisID",
                    dir: "desc"
                },
                filter: [{
                    field: "userID",
                    operator: "eq",
                    value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                }],
                serverPaging: true,
                serverSorting: true,
                serverFiltering: true,
                pageSize: 20
            });
            $("#listview_my_registration_information_evaluation").kendoMobileListView({
                dataSource: page.MyRegistrationInformationDataSource,
                endlessScroll: true,
                pullToRefresh: true,
                template: $("#listview_my_registration_information_template").text(),
            }).kendoTouch({
                filter: ">li",
                tap: function(e) {
                    var itemUID = $(e.touch.target).data("uid");
                    var data;
                    for (var i = 0; i < page.MyRegistrationInformationDataSource._data.length; i++) {
                        if (page.MyRegistrationInformationDataSource._data[i].uid == itemUID) {
                            data = page.MyRegistrationInformationDataSource._data[i];
                            break;
                        }
                    }
                    app.navigate('#teacherAssignment_evaluation?regisID=' + data.regisID);
                },

            });
        }
        page.prototype.searchMyRegistrationInformationEvaluation = function(searchstring) {
            var searchstring = searchstring.toUpperCase();
            var searchword = searchstring.split(' ');
            if (searchstring.length != 0) {
                var orfilter = {
                    logic: 'or',
                    filters: []
                };
                var andfilter = {
                    logic: 'and',
                    filters: []
                };
                $.each(searchword, function(i, v1) {
                    if (v1.trim() != '') {
                        if (v1.trim() != '') {
                            orfilter.filters.push({
                                field: 'ci.courseCode',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ci.courseName',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'us.fullName',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ri.classGroup',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ri.year',
                                operator: 'contains',
                                value: v1
                            }, {
                                field: 'ri.semester',
                                operator: 'contains',
                                value: v1
                            }, );
                            andfilter.filters.push(orfilter);
                            andfilter.filters.push({
                                field: "ri.userID",
                                operator: "eq",
                                value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                            });
                            orfilter = {
                                logic: 'or',
                                filters: []
                            };
                        }
                    }
                });
                page.MyRegistrationInformationDataSource.filter(andfilter);
            } else {
                page.MyRegistrationInformationDataSource.filter({
                    field: "ri.userID",
                    operator: "eq",
                    value: '<?=$_SESSION['user']['data'][0]['userID']?>'
                });
            }
            var scroller = $('#listview_my_registration_information_evaluation').data('kendoMobileListView')
                .scroller();
            scroller.reset();
        }
        page.prototype.refreshTeacherAssignmentEvaluation = function(e) {
            e.view.element.find("#teacher_assignment_layout_title").html(
                "<?=$_SESSION['setting']['lang'] == 'en' ? 'E V A L U A T I O N' : 'การประเมิน';?>"
            );
            page.teacherAssignmentDataSource = new kendo.data.DataSource({
                transport: {
                    read: {
                        dataType: 'json',
                        type: 'POST',
                        data: ({
                            mode: 'selectAllAssignment'
                        }),
                        url: 'app.php'
                    }
                },
                autoSync: false,
                schema: {
                    data: 'data',
                    total: 'total'
                },
                sort: {
                    field: "assignID",
                    dir: "desc"
                },
                filter: [{
                    field: "regisID",
                    operator: "eq",
                    value: e.view.params.regisID
                }],
                serverPaging: true,
                serverSorting: true,
                serverFiltering: true,
                pageSize: 20
            });
            $("#listview_teacher_assignment_evaluation").kendoMobileListView({
                dataSource: page.teacherAssignmentDataSource,
                endlessScroll: true,
                pullToRefresh: true,
                template: $("#listview_teacher_assignment_template").text(),
            }).kendoTouch({
                filter: ">li",
                tap: function(e) {
                    var itemUID = $(e.touch.target).data("uid");
                    var data;
                    for (var i = 0; i < page.teacherAssignmentDataSource._data.length; i++) {
                        if (page.teacherAssignmentDataSource._data[i].uid == itemUID) {
                            data = page.teacherAssignmentDataSource._data[i];
                            break;
                        }
                    }
                    app.navigate('#teacherAssignmentGroupEvaluation?assignID=' + data.assignID +
                        '&classGroup=' + data.classGroup);
                },
            });
        }
        page.prototype.refreshTeacherAssignmentGroupEvaluation = function(e) {
            ajax("app.php", "POST", "json", ({
                mode: 'selectAssignment',
                assignID: e.view.params.assignID,
            }), true, true, function(response) {
                e.view.element.find("#teacher_assignment_group_layout_title").html(
                    "<?=$_SESSION['setting']['lang'] == 'en' ? 'E V A L U A T I O N' : 'การประเมิน';?>"
                );
                $('#teacherAssignmentGroupEvaluation_courseCode span').html(response.data[0]['courseCode'] +' ' + response.data[0]['courseName']);
                $('#teacherAssignmentGroupEvaluation_assignTitle span').html(response.data[0]['assignTitle']);
                $('#teacherAssignmentGroupEvaluation_assignDescription span').html(response.data[0]['assignDescription']);
                $('#teacherAssignmentGroupEvaluation_assignDate span').html(response.data[0]['assignDate'] +' ' + response.data[0]['semester'] + '/' + response.data[0]['year']);
                $('#teacherAssignmentGroupEvaluation_deadline span').html(response.data[0]['deadline']);
                $('#teacherAssignmentGroupEvaluation_numGroup span').html(response.data[0]['numGroup']);

                //--
                ajax("app.php", "POST", "json", ({
                    mode: 'calGroupInformation',
                    assignID: e.view.params.assignID,
                }), true, true, function(ret) {
                    var html = '';
                    $.each(ret, function(i, v) {

                        html +=
                            '<b><?=$_SESSION['setting']['lang'] == 'en' ? 'Group : ' : 'กลุ่มที่ : ';?> ' +
                            v.groupNum +
                            '</b> <br><?=$_SESSION['setting']['lang'] == 'en' ? 'for : ' : 'จำนวนสมาชิก : ';?> ' +
                            v.member +
                            ' <?=$_SESSION['setting']['lang'] == 'en' ? 'people' : 'คน ';?><br>';
                        html +=
                            '<?=$_SESSION['setting']['lang'] == 'en' ? 'Total member : ' : 'จำนวนสมาชิกทั้งหมด : ';?>' +
                            v.totalMember +
                            ' <?=$_SESSION['setting']['lang'] == 'en' ? 'people' : 'คน ';?><br>';
                        html +=
                            '<?=$_SESSION['setting']['lang'] == 'en' ? 'Avaliable : ' : 'สามารถรับสมาชิกได้อีก : ';?>' +
                            v.avaliable +
                            ' <?=$_SESSION['setting']['lang'] == 'en' ? 'people' : 'คน ';?><br>';
                        ajax("app.php", "POST", "json", ({
                            mode: 'selectGroupInformation',
                            assignID: e.view.params.assignID,
                            groupNum: v.groupNum
                        }), false, true, function(rets) {
                            html += '<ol>';
                            $.each(rets['data'], function(ii, vv) {
                                html +=
                                    '<a class="listlink" href="#evaluationResult?assignID=' +
                                    e.view.params.assignID + '&groupNum=' +
                                    vv.groupNum + '&userID=' + vv.userID +
                                    '&fullName=' + vv.fullName + '">';
                                html += '<li>';

                                html += vv['fullName'] + ' ' + vv[
                                    'responsibility'];

                                html += '</li>';
                                html += '</a>';
                            });
                            html += '</ol><hr>';
                        });

                    });
                    $('#teacherAssignmentGroupEvaluationList').html(html);
                });
                ajax("app.php", "POST", "json", ({
                    mode: 'nonGroupInformation',
                    assignID: e.view.params.assignID,
                    classGroup: e.view.params.classGroup
                }), true, true, function(response) {
                    var html = '';
                    html +=
                        '<p><b><?=$_SESSION['setting']['lang'] == 'en' ? 'Students who do not yet have a group  : ' : 'นักศึกษาที่ยังไม่มีกลุ่ม : ';?> </b>' +
                        response.total + '</p>';
                    html += '<ol>';
                    $.each(response.data, function(i, v) {

                        html += '<li>';
                        html += v['userCode'] + ' ' + v['fullName'];
                        html += '</li>';

                    });

                    html += '</ol>';

                    $('#teacherAssignmentGroupEvaluationListNonGroup').html(html);

                });
            });
        }
    }
    </script>
</body>

</html>