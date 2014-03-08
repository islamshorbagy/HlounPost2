<?php 
ini_set('max_execution_time', 0); 


/**
 * remove under line if you need to use this file
 */

 die('remove this line if you need to use this script :) '); // remove this line
$OLDDABE['server'] = 'localhost';
$OLDDABE['db_name'] = 'gurankar_last';
$OLDDABE['db_user'] = 'gurankar_last';
$OLDDABE['db_pass'] = '05308252';


$NEWDABE['server'] = 'localhost';
$NEWDABE['db_name'] = 'gurankar_last2';
$NEWDABE['db_user'] = 'gurankar_last2';
$NEWDABE['db_pass'] = '05308252';



function old_connect(){
	global $OLDDABE;
	$OLDDABE['connect'] = mysql_connect($OLDDABE['server'],$OLDDABE['db_user'],$OLDDABE['db_pass']);
	$old = mysql_select_db($OLDDABE['db_name']);
}
function new_connect(){
	global $NEWDABE;
	$NEWDABE['connect'] = mysql_connect($NEWDABE['server'],$NEWDABE['db_user'],$NEWDABE['db_pass']);
	$new = mysql_select_db($NEWDABE['db_name'],$NEWDABE['connect']);
}

echo '<meta charset="utf-8">';


old_connect();
$SQLUSERS = mysql_query("select * from `users`") or die(mysql_error());
new_connect();
while($data=mysql_fetch_object($SQLUSERS)){
	/*cho $data->id.'<br />';
	sleep(1);*/
	$fb_id = $data->user_id;
	$fb_access = $data->access;
	$reg_date	 = $data->date;
	$fb_name	 = $data->name;
	
	if(mysql_query("insert into `users` (`fb_id`,`fb_access`,`reg_date`,`fb_name`,`fb_gander`,`fb_email`,`last_login`,`country_code`,`last_share`) 
								 values ('$fb_id','$fb_access','$reg_date','$fb_name','m','old@noemail.com','$reg_date','jo','1')")){
		echo 'user copyed '.$data->name.'<br />';
	}
	
	flush();
    ob_flush();
}

echo 'user copy done';


old_connect();
$SQLPOSTS = mysql_query("select * from `posts`") or die(mysql_error());
new_connect();
while($data=mysql_fetch_object($SQLPOSTS)){
		
	$text = $data->text;
	
	$date = $data->date;
	
	$link = $data->link;
	
	if($data->type==0)
	$type = 1;
	else if($data->type==1)
	$type = 2;
	else if($data->type==2)
	$type = 3;
	
	if(mysql_query("insert into `posts` (`text`,`date`,`link`,`type`) values ('$text','$date','$link','$type')")){
		echo 'post copyed '.$data->text.'<br />';
	}
	
	flush();
    ob_flush();

}
echo '<script>alert("upgarde done delete upgarde file");</script>';


?>
