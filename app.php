<?php
session_start();
require_once 'function.php';
if (isset($_POST) && !empty($_POST)):
    $db = new DataSourceResult();
    switch ($_POST['mode']):
    case 'login':
        $sql = "select * from user where email=:email and status=1";
        $param['email'] = $_POST['login_username'];
        $user = $db->select($sql, $param);
        
        if ($user['total'] != 0 ){
            $passhashindb = substr($user['data'][0]['password'],0,32);
            $salt = substr($user['data'][0]['password'],32);
            $passhashinput = md5($_POST['login_password'] . $salt);
            if($passhashindb == $passhashinput){
                $_SESSION['user'] = $user;
                $setting=json_decode($_SESSION[ 'user' ]['data'][0]['setting']);
                if(!empty($setting)){
                    $_SESSION['setting']['lang']=$setting->{'lang'};
                }else{
                    $_SESSION['setting']['lang']='en';
                }
                echo json_encode($user);
            }else{
                echo 0;
            }
                
        }else{
            echo 0;
        }
        break;
    case 'logout':
        unset($_SESSION['user']);
        echo 1;
        break;

    case 'verifyUserName':
        try {
            $strsql = "select * from user where username='" . $_POST['username'] . "'";
            $data = $db->select($strsql);
            if ($data['total'] != 0) {
                echo 0;
            } else {
                echo 1;
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'registerNewUser':
        try {
            $value['userTypeID'] = 0;
            $value['userCode'] = $_POST['register_userCode'];
            $value['fullName'] = $_POST['register_fullname'];
            $value['username'] = $_POST['register_username'];
            if (!empty($_POST['register_password'])) {
                $salt = md5(time());
                $passhash = md5($_POST['register_password'] . $salt);
                $value['password'] = $passhash . ':' . $salt;
            }
            $value['email'] = $_POST['register_email'];
            $value['status'] = 0;
            $request = json_decode(json_encode($value), false);
            $result = $db->create('user', array_keys($value), $request, 'userID');
            if (isset($result['errors'])) {
                throw new Exception($result['errors']);
            } else {
                echo 1;
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'updateProfile':
        try {
            $value['userID'] = $_SESSION[ 'user' ]['data'][0]['userID'];
            $value['fullName'] = $_POST['fullName'];
            if (!empty($_POST['password'])) {
                $salt = md5(time());
                $passhash = md5($_POST['password'] . $salt);
                $value['password'] = $passhash. $salt;
            }
            $request = json_decode(json_encode($value), false);
            $result = $db->update('user', array_keys($value), $request, 'userID');
            if (isset($result['errors'])) {
                throw new Exception($result['errors'][0]);
            } else {
                $_SESSION[ 'user' ]['data'][0]['fullName']= $_POST['fullName'];
                echo 1;
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'updateMBTI':
        try {
            $value['userID'] = $_SESSION[ 'user' ]['data'][0]['userID'];
            $value['mbti'] = $_POST['mbti'];
            $request = json_decode(json_encode($value), false);
            $result = $db->update('user', array_keys($value), $request, 'userID');
            if (isset($result['errors'])) {
                throw new Exception($result['errors'][0]);
            } else {
                $_SESSION[ 'user' ]['data'][0]['mbti']=$_POST['mbti'];
                echo true;
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'selectAllGroupInformation':
        try {
            $value['gi.groupInfoID'] = null;
            $value['ci.courseCode'] = null;
            $value['ci.courseName'] = null;
            $value['ass.assignID'] = null;
            $value['ass.assignTitle'] = null;
            $value['ass.assignDescription'] = null;
            $value['ass.assignDate'] = null;
            $value['ass.deadline'] = null;
            $value['ass.numGroup'] = null;
            $value['ass.status'] = null;
            $value['us2.fullName as instructor'] = null;
            $value['gt.groupType'] = null;
            $value['gi.groupNum'] = null;
            $value['gi.responsibility'] = null;
            $value['gi.userID'] = null;
            $value['us.userCode'] = null;
            $value['us.fullName'] = null;
            $value['ri.classGroup'] = null;
            $value['ri.year'] = null;
            $value['ri.semester'] = null;
            buildstring($_POST, $value);
            $request = json_decode(json_encode($_POST), false);
            $data = $db->read('group_information gi 
            LEFT OUTER JOIN user us ON gi.userID=us.userID
            LEFT OUTER JOIN assignment ass ON gi.assignID=ass.assignID
            LEFT OUTER JOIN group_type gt ON ass.groupTypeID=gt.groupTypeID
            LEFT OUTER JOIN registration_information ri ON ass.regisID=ri.regisID
            LEFT OUTER JOIN user us2 ON ri.userID=us2.userID
            LEFT OUTER JOIN course_information ci ON ri.courseID=ci.courseID', array_keys($value), $request);
            echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'selectGroupInformation':
        try {
            $sql="select 
            gi.groupInfoID,
            ci.courseCode,
            ci.courseName,
            ass.assignID,
            ass.assignTitle,
            ass.assignDescription,
            ass.assignDate,
            ass.deadline,
            ass.numGroup,
            us2.fullName as instructor,
            gt.groupType,
            gi.groupNum,
            gi.responsibility,
            gi.userID,
            us.userCode,
            us.fullName,
            ri.classGroup,
            ri.year,
            ri.semester
            from group_information gi 
            LEFT OUTER JOIN user us ON gi.userID=us.userID
            LEFT OUTER JOIN assignment ass ON gi.assignID=ass.assignID
            LEFT OUTER JOIN group_type gt ON ass.groupTypeID=gt.groupTypeID
            LEFT OUTER JOIN registration_information ri ON ass.regisID=ri.regisID
            LEFT OUTER JOIN user us2 ON ri.userID=us2.userID
            LEFT OUTER JOIN course_information ci ON ri.courseID=ci.courseID 
            where gi.assignID='".$_POST['assignID']."' and gi.groupNum='".$_POST['groupNum']."'";
            $data = $db->select($sql);
            echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'insertGroupInformation':
        try {
            $sql="select * from group_information where assignID='".$_POST['assignID']."' and userID='".$_SESSION[ 'user' ]['data'][0]['userID']."'";
            $result=$db->select($sql);
            if($result['total']!=0){
                throw new Exception($_SESSION['setting']['lang'] == 'en' ? 'This student has already made the groupings and unable to repeat the groupings.' : 'นักศึกษาได้ทำการจัดกลุ่มไว้แล้วไม่สามารถทำการจัดกลุ่มซ้ำได้อีก');
            }
            $value['assignID'] = $_POST['assignID'];
            $value['groupNum'] = $_POST['groupNum'];
            $value['userID'] = $_SESSION[ 'user' ]['data'][0]['userID'];
            //$value['responsibility'] = $_POST['responsibility'];
            $request = json_decode(json_encode($value), false);
            $result = $db->create('group_information', array_keys($value), $request, 'groupInfoID');
            if (isset($result['errors'])) {
                throw new Exception($result['errors'][0]);
            } else {
                echo 1;
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'updateGroupInformation':
        try {
            $value['groupInfoID'] = $_POST['groupInfoID'];
            $value['responsibility'] = $_POST['responsibility'];
            $request = json_decode(json_encode($value), false);
            $result = $db->update('group_information', array_keys($value), $request, 'groupInfoID');
            if (isset($result['errors'])) {
                throw new Exception($result['errors'][0]);
            } else {
                echo 1;
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'selectAllAssignment':
        try {
            $value['ass.assignID'] = null;
            $value['ass.regisID'] = null;
            $value['ass.groupTypeID'] = null;
            $value['ass.assignTitle'] = null;
            $value['ass.assignDescription'] = null;
            $value['ass.assignDate'] = null;
            $value['ass.deadline'] = null;
            $value['ass.numGroup'] = null;
            $value['ass.status'] = null;
            $value['ci.courseCode'] = null;
            $value['ci.courseName'] = null;
            $value['us.fullName'] = null;
            $value['ri.classGroup'] = null;
            $value['ri.year'] = null;
            $value['ri.semester'] = null;
            $value['gt.groupType'] = null;
            buildstring($_POST, $value);
            $request = json_decode(json_encode($_POST), false);
            $data = $db->read('assignment ass 
            LEFT OUTER JOIN group_type gt ON ass.groupTypeID=gt.groupTypeID
            LEFT OUTER JOIN registration_information ri ON ass.regisID=ri.regisID
            LEFT OUTER JOIN course_information ci ON ri.courseID=ci.courseID
            LEFT OUTER JOIN user us ON ri.userID=us.userID', array_keys($value), $request);
            echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'selectAssignment':
        try {
            $sql="select ass.assignID,ass.regisID,ass.groupTypeID,ass.assignTitle,ass.assignDescription,ass.assignDate,
            ass.deadline,ass.numGroup,ass.status,ci.courseCode,ci.courseName,us.fullName,ri.classGroup,ri.year,ri.semester,gt.groupType,us.userID
                from assignment ass 
            LEFT OUTER JOIN group_type gt ON ass.groupTypeID=gt.groupTypeID
            LEFT OUTER JOIN registration_information ri ON ass.regisID=ri.regisID
            LEFT OUTER JOIN course_information ci ON ri.courseID=ci.courseID
            LEFT OUTER JOIN user us ON ri.userID=us.userID where ass.assignID='".$_POST['assignID']."'";
            $data = $db->select($sql);
            echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'calGroupInformation':
        try {
            $sql="SELECT ass.*,ri.classGroup FROM assignment ass 
            LEFT OUTER JOIN registration_information ri ON ass.regisID=ri.regisID
            where ass.assignID='".$_POST['assignID']."'";
            $data = $db->select($sql);
            $numGroup=$data['data'][0]['numGroup'];

            $sql="SELECT * FROM user WHERE classGroup='".$data['data'][0]['classGroup']."'";
            $data = $db->select($sql);
                $totalStudent=$data['total'];
            
            $studentEachTeam=floor($totalStudent/$numGroup);
            $studentLeft=$totalStudent%$numGroup;
            $studentNumEachTeam=[];
            for($i=0;$i<$numGroup;$i++){
                $sql="select * from group_information where assignID='".$_POST['assignID']."' and groupNum='".($i+1)."'";
                $data = $db->select($sql);
                $studentNumEachTeam[]=array("groupNum"=>($i+1), "member"=>($studentEachTeam+(($i+1)<=$studentLeft?1:0)), "totalMember"=>($data['total']),"avaliable"=>($studentEachTeam+(($i+1)<=$studentLeft?1:0))-($data['total']));
            }
            echo json_encode($studentNumEachTeam);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'checkAlreadyJoinGroup':
        $sql="select * from group_information where assignID='".$_POST['assignID']."' and userID='".$_SESSION[ 'user' ]['data'][0]['userID']."'";
        $result=$db->select($sql);
        echo json_encode($result);
        break;
    case 'selectAllMBTIQuestion':
        try {
                $value['questionID'] = null;
                $value['questionNo'] = null;
                $value['question'] = null;
                $value['choiceA'] = null;
                $value['choiceB'] = null;
                
                $request = json_decode(json_encode($_POST), false);
                $data = $db->read('mbti_question', array_keys($value), $request);
                echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'selectAllEvaluationQuestion':
        try {
                $value['questionID'] = null;
                $value['questionNo'] = null;
                $value['question'] = null;              
                $request = json_decode(json_encode($_POST), false);
                $data = $db->read('evaluation_question', array_keys($value), $request);
                echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'insertEvaluationAnswer':
        try {
            foreach($_POST['answer'] as $i=>$v):
                $sql="delete from evaluation_answer where questionNo='".$v['questionNo']."'
                and assignID='".$v['assignID']."'
                and groupNum='".$v['groupNum']."'
                and assessorID='".$_SESSION[ 'user' ]['data'][0]['userID']."'
                and userID='".$v['userID']."'
                ";
                $db->execute($sql);
                $value['questionNo'] = $v['questionNo'];
                $value['assignID'] = $v['assignID'];
                $value['groupNum'] = $v['groupNum'];
                $value['assessorID'] = $_SESSION[ 'user' ]['data'][0]['userID'];
                $value['userID'] = $v['userID'];
                $value['answer'] = $v['answer'];
                $value['suggestion'] = $v['suggestion'];
                $request = json_decode(json_encode($value), false);
                $result = $db->create('evaluation_answer', array_keys($value), $request, 'answerID');
                if (isset($result['errors'])) {
                    throw new Exception($result['errors'][0]);
                }
            endforeach;
            echo 1;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'selectAllEvaluationResult':
        try {
                $sql="SELECT ans.questionNo,que.question ,cast(avg(ans.answer)as decimal(10, 2)) AS result
                FROM evaluation_answer ans 
                LEFT OUTER JOIN evaluation_question que ON ans.questionNo=que.questionNo 
                WHERE ans.assignID='".$_POST['assignID']."' AND ans.groupNum='".$_POST['groupNum']."' AND ans.userID='".$_POST['userID']."' AND ans.questionNo=1  
                UNION ALL
                SELECT ans.questionNo,que.question ,cast(avg(ans.answer)as decimal(10, 2)) AS result
                FROM evaluation_answer ans 
                LEFT OUTER JOIN evaluation_question que ON ans.questionNo=que.questionNo 
                WHERE ans.assignID='".$_POST['assignID']."' AND ans.groupNum='".$_POST['groupNum']."' AND ans.userID='".$_POST['userID']."' AND ans.questionNo=2 
                UNION ALL
                SELECT ans.questionNo,que.question ,cast(avg(ans.answer)as decimal(10, 2)) AS result
                FROM evaluation_answer ans 
                LEFT OUTER JOIN evaluation_question que ON ans.questionNo=que.questionNo 
                WHERE ans.assignID='".$_POST['assignID']."' AND ans.groupNum='".$_POST['groupNum']."' AND ans.userID='".$_POST['userID']."' AND ans.questionNo=3 
                UNION ALL
                SELECT ans.questionNo,que.question ,cast(avg(ans.answer)as decimal(10, 2)) AS result
                FROM evaluation_answer ans 
                LEFT OUTER JOIN evaluation_question que ON ans.questionNo=que.questionNo 
                WHERE ans.assignID='".$_POST['assignID']."' AND ans.groupNum='".$_POST['groupNum']."' AND ans.userID='".$_POST['userID']."' AND ans.questionNo=4  
                UNION ALL
                SELECT ans.questionNo,que.question ,cast(avg(ans.answer)as decimal(10, 2)) AS result
                FROM evaluation_answer ans 
                LEFT OUTER JOIN evaluation_question que ON ans.questionNo=que.questionNo 
                WHERE ans.assignID='".$_POST['assignID']."' AND ans.groupNum='".$_POST['groupNum']."' AND ans.userID='".$_POST['userID']."' AND  ans.questionNo=5 
                UNION ALL
                SELECT ans.questionNo, que.question ,GROUP_CONCAT(ans.suggestion SEPARATOR ',') AS result
                FROM evaluation_answer ans 
                LEFT OUTER JOIN evaluation_question que ON ans.questionNo=que.questionNo 
                WHERE ans.assignID='".$_POST['assignID']."' AND ans.groupNum='".$_POST['groupNum']."' AND ans.userID='".$_POST['userID']."' AND ans.questionNo=6  ";
                $data = $db->select($sql);
                echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'selectAllChat':
        try {
            $sql = "SELECT di.*,us.fullName FROM discussion di LEFT OUTER JOIN user us ON di.userID=us.userID WHERE di.assignID='" . $_POST['assignID'] . "' AND di.groupNum='" . $_POST['groupNum'] . "'";
            $data = $db->select($sql);
            echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'postMessage':
        try {
            $strsql="SELECT AUTO_INCREMENT AS lastID FROM information_schema.tables WHERE table_name='discussion' AND table_schema='".TABLE_SCHEMA."'";
            $data=$db->select($strsql);
            $lastID= $data['data'][0]['lastID'];
            if ( !empty( $_FILES[ 'photo' ] ) ){
                $path = $_SERVER['DOCUMENT_ROOT'] . "/studentgroupingsystem/images/chat_images/assignID" . $_POST['assignID'] . "/groupNum". $_POST['groupNum']."/" ;              
                $name = $_FILES[ 'photo' ][ "name" ];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $name=$lastID.'.'.$ext;
                if ( $_FILES[ 'photo' ][ "error" ]== 1 ) {
                    throw new Exception('The file size exceeds the limit allowed and cannot be saved');
                }
                if ( !file_exists( $path ) ){mkdir( $path, 0755, true ) or die("cannot create directory".$path);}
                if ( move_uploaded_file( $_FILES[ 'photo' ][ "tmp_name" ], $path . $name ) ){
                    $value[ 'photo' ]  = $name;
                }else{
                    throw new Exception("Not uploaded because of error #".$_FILES["photo"]["error"]);
                }
            }
            $value['discussID'] = $lastID;
            $value['assignID'] = $_POST['assignID'];
            $value['groupNum'] = $_POST['groupNum'];
            $value['userID'] = $_POST['userID'];
            $value['message'] = $_POST['message'];
            
            $value['dateTimeSend'] = date("Y-m-d h:i:s");
            $request = json_decode(json_encode($value), false);
            $result = $db->create('discussion', array_keys($value), $request, 'discussID');
            if (isset($result['errors'])) {
                throw new Exception($result['errors'][0]);
            } else {
                echo json_encode($result);
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'deleteMessage':
        try {
            $strsql="select * from discussion where discussID='".$_POST["discussID"]."'";
            $data=$db->select($strsql);
            if($data['total']!=0 && $data['data'][0]['photo']!=null || $data['data'][0]['photo']!=""){
                $path = $_SERVER['DOCUMENT_ROOT'] . "/studentgroupingsystem/images/chat_images/assignID" . $data['data'][0]['assignID'] . "/groupNum". $data['data'][0]['groupNum']."/".$data['data'][0]['photo'] ;              
                unlink($path);
            }
            $value['discussID'] = $_POST["discussID"];
            $request = json_decode(json_encode($value), false);
            $result = $db->destroy('discussion', $request, 'discussID');
            if (isset($result['errors'])) {
                throw new Exception($result['errors'][0]);
            } else {
                echo 1;
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'selectAllRegistrationInformation':
        try {
            $value['ri.regisID'] = null;
            $value['ri.courseID'] = null;
            $value['ci.courseCode'] = null;
            $value['ci.courseName'] = null;
            $value['ri.userID'] = null;
            $value['us.fullName'] = null;
            $value['ri.classGroup'] = null;
            $value['ri.year'] = null;
            $value['ri.semester'] = null;
            $value['ri.status'] = null;
            buildstring($_POST, $value);
            $request = json_decode(json_encode($_POST), false);
            $data = $db->read('registration_information ri left outer join course_information ci on ri.courseID=ci.courseID left outer join user us on ri.userID=us.userID', array_keys($value), $request);
            echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'selectRegistrationInformation':
        try {
            $data = $db->select("select ri.regisID,ri.courseID,ci.courseCode,ci.courseName,ri.userID,us.fullName,ri.classGroup,ri.year,ri.semester from registration_information ri left outer join course_information ci on ri.courseID=ci.courseID left outer join user us on ri.userID=us.userID where ri.regisID='".$_POST['regisID']."'");
            echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'selectAllGroupType':
        try {
            $value['groupTypeID'] = null;
            $value['groupType'] = null;
            $value['status'] = null;
            $request = json_decode(json_encode($_POST), false);
            $data = $db->read('group_type', array_keys($value), $request);
            echo json_encode($data);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'insertAssignment':
        try {
            $value['assignID'] = null;
            $value['regisID'] = $_POST['regisID'];
            $value['groupTypeID'] = $_POST['groupTypeID'];
            $value['assignTitle'] = $_POST['assignTitle'];
            $value['assignDescription'] = $_POST['assignDescription'];
            $value['assignDate'] = $_POST['assignDate'];
            $value['deadline'] = $_POST['deadline'];
            $value['numGroup'] = $_POST['numGroup'];
            $value['status'] = 1;
            $request = json_decode(json_encode($value), false);
            $result = $db->create('assignment', array_keys($value), $request, 'assignID');

            //check MBTI assignment
            if($_POST['groupTypeID']==3){
                //collect all student that assign to classgroup
                $sql="select * from user where classGroup='".$_POST['classGroup']."'";
                $student=$db->select($sql);
                $groupNum=$_POST['numGroup'];
                $groupArray=array();
                $type1=array('ENTJ','ENTP','INTJ','INTP');
                $type2=array('ENFJ','ENFP','INFJ','INFP');
                $type3=array('ESTJ','ESFJ','ISTJ','ISFJ');
                $type4=array('ESTP','ESFP','ISTP','ISFP');

                foreach($student['data'] as $i=>$v){
                    if(array_search($v['mbti'], $type1)!==false){
                        $mbtiTable[]=array("type"=>1,"userID"=>$v['userID'],"mbti"=>$v['mbti']);
                    }else if(array_search($v['mbti'], $type2)!==false){
                        $mbtiTable[]=array("type"=>2,"userID"=>$v['userID'],"mbti"=>$v['mbti']);
                    }else if(array_search($v['mbti'], $type3)!==false){
                        $mbtiTable[]=array("type"=>3,"userID"=>$v['userID'],"mbti"=>$v['mbti']);
                    }else if(array_search($v['mbti'], $type4)!==false){
                        $mbtiTable[]=array("type"=>4,"userID"=>$v['userID'],"mbti"=>$v['mbti']);
                    }else{
                        $mbtiTable[]=array("type"=>5,"userID"=>$v['userID'],"mbti"=>$v['mbti']);
                    }
                }
                usort($mbtiTable, function($a, $b) {
                    return $a['type'] <=> $b['type'];
                });
                $count=1;
                foreach($mbtiTable as $i=>$v){
                    $groupArray[$count][]=$mbtiTable[$i];
                    if($count%$groupNum==0)$count=0;
                    $count++;
                }
                $value=array();
                foreach($groupArray as $i=>$v){
                    foreach($v as $ii=>$vv){
                        $value['assignID'] = $result['data'][0]->assignID;
                        $value['groupNum'] = $i;
                        $value['userID'] = $vv['userID'];                       
                        $request = json_decode(json_encode($value), false);
                        $db->create('group_information', array_keys($value), $request, 'groupInfoID');
                    }
                }
                
            }//---

            if (isset($result['errors'])) {
                throw new Exception($result['errors'][0]);
            } else {
                echo 1;
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        break;
    case 'nonGroupInformation':
        $groupUser=array();
        $nonGroupUser=array();
        
        $sql="SELECT gi.userID,ri.classGroup FROM group_information gi
        LEFT  OUTER JOIN assignment ass ON ass.assignID=gi.assignID
        LEFT OUTER JOIN registration_information ri ON ass.regisID=ri.regisID
        WHERE gi.assignID='".$_POST['assignID']."'";
        $data=$db->select($sql);
        foreach($data['data'] as $i=>$v){
            $groupUser[]=$v['userID'];
        }

        $sql="select userID from user where classGroup='".$_POST['classGroup']."' and userTypeID='3'";
        $data=$db->select($sql);
        foreach($data['data'] as $i=>$v){
            $nonGroupUser[]=$v['userID'];
        }

        //print_r($groupUser);
        //print_r($nonGroupUser);

        $result = array_diff($nonGroupUser,$groupUser);
        $sql="select * from user where userID in('".join("','",$result)."')";
        echo json_encode($db->select($sql));
        break;
endswitch;
unset($db);
endif;
exit();
