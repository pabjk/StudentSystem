<?php
require_once( 'db/DataSourceResult.php' );
date_default_timezone_set("Asia/Bangkok");

function array_find_deep($array, $search, $keys = array()){
    foreach($array as $key => $value) {
        if (is_array($value)) {
            $sub = array_find_deep($value, $search, array_merge($keys, array($key)));
            if (count($sub)) {
                return $sub;
            }
        } elseif ($value === $search) {
            return array_merge($keys, array($key));
        }
    }
	return array();
}
function buildstring(&$post,&$array){//กรณีมีการ join table สำหรับหาค่า ที่ส่งมาจาก ui ของ kendo ซึ่งจะไม่ส่ง alias มา 
	foreach(array_keys($array) as $item=>$value){
		$alias=explode('.',$value)[0];
		$field=explode('.',$value)[1];
		$index=array_find_deep($post,$field);
		if(!empty($index)&&$index[0]=='sort')$post[$index[0]][$index[1]]['field']="$alias.$field";
        if(!empty($index)&&$index[0]=='group')$post[$index[0]][$index[1]]['field']="$alias.$field";
		if(!empty($index)&&$index[0]=='filter')$post[$index[0]][$index[1]][$index[2]]['field']="$alias.$field";
		
	}
}
function deleteDir($dirPath) {
    if (is_dir($dirPath)) {
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}
}
function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
    
    $interval = date_diff($datetime1, $datetime2);
	
	if( $interval->invert)
               return -1 * $interval->format($differenceFormat);
       else    return $interval->format($differenceFormat);
    
    //return $interval->format($differenceFormat);
    
}
?>