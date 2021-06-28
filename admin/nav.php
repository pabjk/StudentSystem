<?php
function checkpage($page){
    return basename($_SERVER['PHP_SELF'])==$page;
}
?>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?=checkpage('main.php')?' active':''?>" aria-current="page" href="main.php">
                    <span class="material-icons">home</span>
                    <?=$_SESSION['setting']['lang'] == 'en' ? 'Dashboard' : 'แผงควบคุม';?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=checkpage('user_type.php')?' active':''?>" href="user_type.php">
                    <span class="material-icons">account_box</span>
                    <?=$_SESSION['setting']['lang'] == 'en' ? 'User type' : 'ข้อมูลประเภทผู้ใช้';?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=checkpage('user.php')?' active':''?>" href="user.php">
                    <span class="material-icons">account_circle</span>
                    <?=$_SESSION['setting']['lang'] == 'en' ? 'Users' : 'ข้อมูลผู้ใช้งานระบบ';?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=checkpage('course_information.php')?' active':''?>" href="course_information.php">
                    <span class="material-icons">assignment</span>
                    <?=$_SESSION['setting']['lang'] == 'en' ? 'Course information' : 'ข้อมูลรายวิชา';?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=checkpage('registration_information.php')?' active':''?>"
                    href="registration_information.php">
                    <span class="material-icons">assignment</span>
                    <?=$_SESSION['setting']['lang'] == 'en' ? 'Register information' : 'ข้อมูลการลงทะเบียน รายวิชาที่เปิดสอน';?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=checkpage('group_type.php')?' active':''?>" href="group_type.php">
                    <span class="material-icons">group_work</span>
                    <?=$_SESSION['setting']['lang'] == 'en' ? 'Group type' : 'ข้อมูลประเภทการจับกลุ่ม';?>
                </a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?=checkpage('assignment.php')?' active':''?>" href="assignment.php">
                    <span class="material-icons">assignment</span>
                    <?=$_SESSION['setting']['lang'] == 'en' ? 'Assignment' : 'ข้อมูลการมอบหมายงาน';?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=checkpage('group_information.php')?' active':''?>" href="group_information.php">
                    <span class="material-icons">group_work</span>
                    <?=$_SESSION['setting']['lang'] == 'en' ? 'Group information' : 'ข้อมูลการจับกลุ่มของนักศึกษา';?>
                </a>
            </li>
            
            <li class="nav-item">
            <a class="nav-link <?=checkpage('discussion.php')?' active':''?>" href="discussion.php">
                    <span class="material-icons">question_answer</span>
                    <?=$_SESSION['setting']['lang'] == 'en' ? 'Discussion' : 'ข้อมูลการอภิปรายผล';?>
                </a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?=checkpage('mbti_question.php')?' active':''?>" href="mbti_question.php">
                    <span class="material-icons">help</span>
                    <?=$_SESSION['setting']['lang'] == 'en' ? 'Personality Test (MBTI)' : 'แบบทดสอบบุคลิกภาพ (MBTI)';?>
                </a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?=checkpage('mbti_answer.php')?' active':''?>" href="mbti_answer.php">
                    <span class="material-icons">help</span>
                    <?=$_SESSION['setting']['lang'] == 'en' ? 'Personality Test Result (MBTI)' : 'ผลการทดสอบบุคลิกภาพ (MBTI)';?>
                </a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?=checkpage('evaluation_question.php')?' active':''?>" href="evaluation_question.php">
                    <span class="material-icons">help</span>
                    <?=$_SESSION['setting']['lang'] == 'en' ? 'Teamwork evaluation' : 'แบบประเมินผลการปฏิบัติงาน';?>
                </a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?=checkpage('evaluation_answer.php')?' active':''?>" href="evaluation_answer.php">
                    <span class="material-icons">help</span>
                    <?=$_SESSION['setting']['lang'] == 'en' ? 'Teamwork evaluation result' : 'ผลประเมินผลการปฏิบัติงาน';?>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="#">
                    <span class="material-icons">assessment</span>
                    Report 1
                </a>
            </li> -->
        </ul>

    </div>
</nav>