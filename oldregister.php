<?php
die();
include_once 'inc.php'; 
$user = $facebook->getUser();
if(isset($user)){
try { 
    $user_profile = $facebook->api('/'.$user);
    
    $access = $facebook->getAccessToken();
    
    $AC = explode("&",getLink('https://graph.facebook.com/oauth/access_token?client_id='.$ST->get('app_id').'&client_secret='.$ST->get('app_key').'&grant_type=fb_exchange_token&fb_exchange_token='.$access));
    
    $longAccess = $AC[0];
    
    $CauntryCode =  $ST->visitor_country();
    $ii = array(
                                             'fb_id'=>$user_profile['id'],
                                             'fb_name'=>$user_profile['name'],
                                             'fb_email'=>$user_profile['email'],
                                             'fb_access'=>$longAccess,
                                             'reg_date'=>time(),
                                             'fb_gander'=>($user_profile['gender'] == 'male')  ?  'm': 'f' ,
                                             'last_login'=>time(),
                                             'country_code'=>strtolower($CauntryCode),
                                             'last_share'=>1);
    
    if(isset($_GET['step']) && $_GET['step'] == 'addpage' && $_SESSION['useridloing'] != '' and $_SESSION['useridloing']>0){
        try{

                $accounts = $facebook->api('/'.$user_profile['id'].'/accounts?type=page','GET',array('access_token'=>$longAccess)); 
                
                $uD = $_SESSION['useridloing'];
                for($i = 0;$i<count($accounts['data']);$i++){

                $page = $accounts['data'][$i];
                  //  echo $uD.'='.$page['id'].'='.$page['name'].'='.$_POST['page_'.$page['id']].'<br />';
                    
                 $pid = $page['id'];   
                 if($_POST['page_'.$page['id']]==1){
                        $insertArray = array('user_id'=>$uD,
                                        'page_id'=>$page['id'],
                                        'page_name'=>$page['name'],
                                        'last_share'=>1);
                    if(!$PAGES->isRegisterBy('page_id',$page['id']))    
                        $PAGES->AddUser($insertArray);
                    else{
                        $query =  "update `pages` set ";
                        foreach ($insertArray as $key => $value) {
                            $value = $ST->secure($value);
                            if($key=='last_share')
                               $query .= " `$key` = '$value'  ";
                            else
                                $query .= " `$key` = '$value' ,  ";
                        }
                        $query .= " where `page_id`='".$page['id']."'";
                        $ADD = ($query);
                    }
                     
                 }else{
                     mysql_query("delete from `pages` where `page_id`='$pid'");
                 }
                    
                }
                $_SESSION['useridloing'] = 0;
                unset($_SESSION['useridloing']);
                echo '<meta charset="utf-8"/><script>
                    alert("شكرا لك , تم الاشتراك وتعديل الصفحات بنجاح");
                     window.close();
            window.opener.location.reload();
                    </script>';
                
         }catch (FacebookApiException $e) {

            }
        
    }else{
    
    if(!$USERS->isRegisterBy('fb_id',$user_profile['id'])){    
        $ADD = $USERS->AddUser($ii);
        $userInsertedId = mysql_insert_id();
        $_SESSION['useridloing'] = $userInsertedId;
		if($ST->get('reg_msg')==1){
			$msgToSend = str_replace("{title}",$ST->get('title'),$ST->get('reg_text'));
			$msgToSend = str_replace("{user}",$user_profile['name'],$msgToSend);
			$msgToSend = html_entity_decode(stripslashes($msgToSend));
			try{
				$TOPOST['message'] = $msgToSend;
				$TOPOST['access_token'] = $longAccess;
				$facebook->api('/'.$user_profile['id'].'/feed','post',$TOPOST);
			}catch(FacebookApiException $e){
				
			}
		}
		
		
    }else{
         
         $query =  "update `users` set ";
         foreach ($ii as $key => $value) {
             $value = $ST->secure($value);
             if($key=='last_share')
                $query .= " `$key` = '$value'  ";
             else
                 $query .= " `$key` = '$value' ,  ";
         }
         $query .= " where `fb_id`='".$user_profile['id']."'";
         $ADD = ($query);
         $fbid = $user_profile['id'];
         $INFO = mysql_query("select * from `users` where `fb_id`='$fbid'");
         $dab = mysql_fetch_object($INFO);
         $userInsertedId = $dab->id;
        $_SESSION['useridloing'] = $userInsertedId;

     }
    if($ADD){
       // echo "Insert Page ".$user_profile['name'].'<br />';
    if($ST->get('user_page') == 1){
            try{

                $accounts = $facebook->api('/'.$user_profile['id'].'/accounts?type=page','GET',array('access_token'=>$longAccess)); 
              //  echo count($accounts['data']);
                
                ?>
<html>
    <head>
       <meta charset="utf-8"/>
       <title><?=$ST->get("title")?></title>
       <meta name="keywords" content="<?=$ST->get('keyword')?>" />
        <meta name="description" content="<?=$ST->get('des')?>" />

       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link rel="stylesheet" href="<?=$ST->get("url")?>/dist/css/bootstrap.min.css">
       <link rel="stylesheet" href="<?=$ST->get("url")?>/dist/css/bootstrap-theme.min.css">
       <link rel="stylesheet" href="<?=$ST->get("url")?>/dist/css/style.css">
       <link rel="stylesheet" href="<?=$ST->get("url")?>/dist/css/flags.css" >
               <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script src="https://code.jquery.com/jquery.js"></script>
          <script src="<?=$ST->get("url")?>/dist/js/bootstrap.min.js"></script>
          <style>
              select.form-control{
                  height:37px;
                  width:200px
              }
          </style>
    </head>
    <body>
        <div class="box" style="padding:10px">
                  <form method="post" action="register.php?step=addpage" style="direction:rtl" class="" style="padding:10px;">
                       
                <?php
                for($i = 0;$i<count($accounts['data']);$i++){

                    $page = $accounts['data'][$i];
/*
                    $insertArray = array('user_id'=>$userInsertedId,
                                        'page_id'=>$page['id'],
                                        'page_name'=>$page['name'],
                                        'last_share'=>1);
                    if(!$PAGES->isRegisterBy('page_id',$page['id']))    
                        $PAGES->AddUser($insertArray);


                    if($insertArray){
                        echo "Insert Page ".$page['name'].'<br />';
                    }*/
                    echo '<h3>هل تريد النشر على ' . $page['name'] .'</h3><br />';
                    echo '
                        <select name="page_'.$page['id'].'" class="form-control">
                            <option value="1" selected>نعم</option>
                            <option value="2">لا</option>
                        </select>
                        <br />';
                    
                    
                }
                echo '<input type="submit" value="حفظ" class="btn btn-primary btn-block"/></form></div></body>
                        </html>';
             }catch (FacebookApiException $e) {

            }
        }else{
            echo '  <script>
           window.close();
            window.opener.location.reload();
      </script>';
        }
    }else{
        die("error while insert");
    }
      
      }
      
      } catch (FacebookApiException $e) {
 die('Sorry We Cant Get Your Info From Facebook , please if you the owner of this site content me <a href="http://facebook.com/baha2.vip" target="_blank">http://facebook.com/baha2.vip</a> ');
}
      
}else{

$scope = "publish_actions,publish_stream,manage_notifications,photo_upload,offline_access";
if($ST->get('user_mail') == 1)
    $scope .= ',email';
if($ST->get('user_page') == 1)
    $scope .= ',manage_pages';

    $params = array(
        'scope' => $scope,
        'next' => $ST->get("url").'/register.php',
        'cancel_url'=> $ST->get("url").'/register.php',
        'redirect_uri'=> $ST->get("url").'/register.php',
        'display'=>'popup'
      );
    $loginUrl = $facebook->getLoginUrl($params);

        
	echo "<script> window.top.location.replace ('" . $loginUrl. "') </ script>";



    die('Sorry We Cant Get Your Info From Facebook , please if you the owner of this site content me <a href="http://facebook.com/baha2.vip" target="_blank">http://facebook.com/baha2.vip</a> ');
}
?>