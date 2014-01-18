<?php include_once 'inc.php'; 
$result = @mysql_query("SHOW TABLES LIKE 'settings'");
$tableExists = @mysql_num_rows($result);
if(!$tableExists){
header("Location: setup.php");  
}
    
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
        .container{
         margin-top:0px;
         }
    </style>
    </head>
    <body>
        <div id="fb-root"></div>
        <script>
           window.fbAsyncInit = function() {
        FB.init({
          appId      : '<?=$ST->get('app_id')?>', // App ID
          status     : true, // check login status
          cookie     : true, // enable cookies to allow the server to access the session
          xfbml      : true  // parse XFBML
        });

            // Additional init code here

          FB.getLoginStatus(function(response) {
          if (response.status === 'connected') {
              
                makeProfile();
                // alert('logined');
          } else if (response.status === 'not_authorized') {
                //alert('not logined');
             // login();
             } else {
                 //alert('not used app');
             }
         });
        };
             (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));
   
   
   
   
      function login() {
            FB.login(function(response) {
                if (response.authResponse) {
                    // connected
                              //  testAPI();
                             //   prompt("lgoineeeeeeeeeeeeeeeeeeeeeeee");
                                
                          afterLogin(response.authResponse.accessToken);      
                                
                                
                } else {
                    alert('not login');
                    // cancelled
                }
            },{scope:'<?=$scope?>'});
        }
        
        
            function afterLogin(access){
                FB.api('/me', function(response) {
                   // alert(JSON.stringify(response));
                    alert(response.id +"\n"+response.email + "\n" + response.gender + "\n" + response.name + "\n" + access);
                 });
                   FB.api('/me/accounts', function(response) {
                    alert(JSON.stringify(response));
                   // alert(response.id +"\n"+response.email + "\n" + response.gender + "\n" + response.name + "\n" + access);
                 });
            }
            
            
            function makeProfile(){
                 FB.api('/me', function(response) {
                     $('.userprofileshow').show();
                     $('.imguser').attr('src','https://graph.facebook.com/'+response.id+'/picture?type=large');
                     $('.btn-reg').hide();
                 });
            }
            
            var newwindow;
        var intId;
        function logWindo(){
            var  screenX    = typeof window.screenX != 'undefined' ? window.screenX : window.screenLeft,
                 screenY    = typeof window.screenY != 'undefined' ? window.screenY : window.screenTop,
                 outerWidth = typeof window.outerWidth != 'undefined' ? window.outerWidth : document.body.clientWidth,
                 outerHeight = typeof window.outerHeight != 'undefined' ? window.outerHeight : (document.body.clientHeight - 22),
                 width    = 500,
                 height   = 500,
                 left     = parseInt(screenX + ((outerWidth - width) / 2), 10),
                 top      = parseInt(screenY + ((outerHeight - height) / 2.5), 10),
                 features = (
                    'width=' + width +
                    ',height=' + height +
                    ',left=' + left +
                    ',top=' + top
                  );
 
            newwindow=window.open('<?=$ST->get('url')?>/register.php','Login_by_facebook',features);
 
           if (window.focus) {newwindow.focus()}
          return false;
        }
        
        function FacebookInviteFriends()
        {
        FB.ui({ method: 'apprequests', 
           message: 'ادعو أصدقاءك للإشتراك <?=$ST->get('title')?> '});
        }
        </script>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- You'll want to use a responsive image option so this logo looks good on devices - I recommend using something like retina.js (do a quick Google search for it and you'll find it) -->
                <a class="navbar-brand logo-nav" href="index.php" style='width:230px'>
                    <?=$ST->get('title')?>
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li style='width:130px'><a href="#privce"   data-toggle="modal" data-target="#myModal" id='a' style='width:130px'>سياسة الخصوصية</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="container" style='margin-top:80px'>
        <div class='row'>
            <div class='col-md-3 home'>
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"><?=$ln['fb_page']?></h3>
                    </div>
                    <div class="panel-body">
                        
                        <a href="#" onclick="FacebookInviteFriends();"class="btn btn-primary btn-block"> ادعو اصدقائك للاشتراك</a>
                        
                        <br />
                        <iframe src="//www.facebook.com/plugins/likebox.php?href=<?=$ST->get('fb_page')?>&amp;width=240&amp;colorscheme=light&amp;show_faces=true&amp;border_color=%23acb7d1&amp;stream=false&amp;header=false&amp;height=258" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:190px; height:258px;" allowTransparency="true"></iframe>
                    </div>
                  </div>
                
                <div class="panel panel-default">
                    <div class="panel-body">
                      <img src='https://storage.googleapis.com/support-kms-prod/SNP_2922342_en_v0' />
                    </div>
                  </div>
                
                
                
            </div>
            <div class='col-md-1'></div>
            <div class=' col-md-8 box' style='direction: rtl;padding: 10px'>
                <?=  html_entity_decode($ST->get('home_ad'))?>
                <h1><?=$ST->get('site_name')?></h1>
                <p><?=html_entity_decode($ST->get('des'))?></p>
                <a class="btn btn-primary btn-lg btn-block btn-reg" href="#" onclick="logWindo();">اشترك الان</a>
                <br />
                <div class="well" style='margin-top:10px'><?=str_replace("<br>n",'<br />',html_entity_decode($ST->get('home_msg')))?></div>
                
                
               <div class='well userprofileshow' style='display:none'>
                    <div class='row '>
                        <div class='col-lg-3'><img src='' class='img-thumbnail imguser' style='width:100px;height:100px;'/></div>
                        <div class='col-lg-9'>
                            <h3>شكراً، أنت مشترك في الخدمة الآن</h3>
                            <p>
                                أنت الان مشترك الآن مع التطبيق أن تستمتع و أن يروق لك التطبيق و ما نقدمه من خدمات نحن نسعى جاهدين للحفاظ على الخدمة في أحسن أحوالها، إذا واجهتكم أية مشاكل يمكنكم إخبارنا في أي وقت
                            </p>
                        </div>
                    </div>
                </div>

                
                
                
                
                <h2>بعض المنشورات</h2>
                <hr />
                <div id="container">
                       <?php 
                        $usersData = $POSTS->getUsers(0,20);
                        if($usersData){
                            for($i=0;$i<count($usersData);$i++){
                                $u = $usersData[$i];
                                
                                
                                        echo '<div class="well">';
                                            if($u['type']==3)
                                                echo ' <img src="'.$ST->get('url').'/admincp/upload/'.$u['link'].'" style="width:100%;max-height:300px;"/>';
                                               echo ' <div class=" text-right" style="direction: rtl">'.stripslashes($u['text']).'</div>';
                                            if($u['type']==2)
                                                echo '<a href="'.$u['link'].'">'.$u['link'].'</a>';
                                         echo '</div>';     
                                      
                            }
                        }
                        ?>
                    
                     <div class="clearfix"></div>
                     
                    
                  </div>
            </div>
        </div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">سياسة الخصوصية</h4>
      </div>
      <div class="modal-body">
        <?=html_entity_decode($ST->get('privacy'))?>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    
        

        <footer>
            <hr>
            <div class="row">
                <div class="col-lg-12">
                    <p><?=COPYRIGHT?></p>
                </div>
            </div>
        </footer>

    </div>

        
          

    </body>
</html>
