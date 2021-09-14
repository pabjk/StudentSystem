<?php
session_start();
require_once 'function.php';
$db = new DataSourceResult();
$sql="select * from user where classGroup='A'";
$student=$db->select($sql);
$groupNum=3;
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

unset($db);
exit();
