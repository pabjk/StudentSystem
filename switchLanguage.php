<?php
session_start();
require_once 'function.php';
$db = new DataSourceResult();
$_SESSION['setting']['lang']=$_POST['lang'];
$_SESSION[ 'user' ]['data'][0]['setting']=json_encode($_SESSION['setting']);
$sql="update user set setting='".json_encode($_SESSION['setting'])."' where userID='".$_SESSION[ 'user' ]['data'][0]['userID']."'";
$db->execute($sql);
echo true;
?>
