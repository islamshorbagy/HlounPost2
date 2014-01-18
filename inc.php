<?php
include ('class/db.php');
include ('class/Settings.php');
include ('class/Users.php');
include ('class/lang.php');
include ('src/facebook.php');
$ST = new Settings('settings');

$USERS = new User();
$USERS->setTable('users');

$PAGES = new User();
$PAGES->setTable('pages');

$POSTS = new User();
$POSTS->setTable('posts');

$config = array();
$config['appId'] = $ST->get('app_id');
$config['secret'] = $ST->get('app_key');
$config['fileUpload'] = true; // optional
$facebook = new Facebook($config);


if($ST->get('site_status') == 2){
		echo '<html>
				<head><meta charset="utf-8"/><title>'.$ST->get('title').'</title>
				</head>
				<body>
				'.html_entity_decode($ST->get('close_msg')).'
				</body>
     		</html>';
		
	die();
}

?>
