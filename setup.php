<?php 
include 'class/db.php';
include 'class/lang.php';
$m = @mysql_query("select * from `settings` where `option`='isinstall'");
if($m){
	$d = @mysql_fetch_object($m);
	if($d->value==1){
		die("script installed before bybye");
	}
}
?>
<html>
    <head>
       <meta charset="utf-8"/>
       <title>Hloun Post Install Page</title>
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link rel="stylesheet" href="dist/css/bootstrap.min.css">
       <link rel="stylesheet" href="dist/css/bootstrap-theme.min.css">
       <link rel="stylesheet" href="dist/css/style.css">
       <link rel="stylesheet" href="dist/css/flags.css" >
               <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script src="https://code.jquery.com/jquery.js"></script>
          <script src="dist/js/bootstrap.min.js"></script>

	</head>
	<body>
		<?php 
		$step = addslashes($_GET['step']);
		?>
		<div class="container box" style="padding: 10px">
			<div class="row" style="direction: rtl">
				<div class="col-lg-8">
					<center>
						<?php if($step==""){ ?>
						<h2>تركيب سكربت ليون بوست</h2>
						<p>اهلا بك بصفحة تركيب سكربت ليون بوست الاصدار الثاني</p>
						<p style="color:red">السكربت مجاني وغير مخصص للبيع ابدا</p>
						<p style="color:red">لن اسامح من يقوم بحذف اي حقوق من السكربت</p>
						<p>برمجة <a href="http://facebook.com/baha2.vip">بهاء عودة</a></p>
						<p>الموقع الرسمي <a href="http://hloun.com">ليون بوست</a></p>
						<h2><a href="setup.php?step=server" class="btn btn-block btn-primary">فحص السيرفر والملفات</a></h2>
						<?php }else if($step=="server"){ $success = 1;?>
						<h2>فحص السيرفر والملفات</h2>
						<table class="table table-striped" style="width:100%;text-align: center">
							<tr style="font-weight: bold">
								<td>الخاصية</td>
								<td>الحالة</td>
							</tr>
							<tr>
								<td>وجود ملف upload داخل مجلد الادمن</td>
								<td><?php if(file_exists('admincp/upload')){
									echo '<p style="color:green">موجود</p>';	
								}else{
									echo '<p style="color:red">غير موجود</p>';	
									$success = 0;
								}?></td>
							</tr>
							<tr>
								<td>تاكد من تفعيل دالة ال file_get_contents</td>
								<td><?php if(function_exists("file_get_contents")){
									echo '<p style="color:green">مفعلة</p>';	
								}else{
									echo '<p style="color:red">غير مفعلة</p>';	
									$success = 0;
								}?></td>
							</tr>
							<tr>
								<td>تاكد من تفعيل مكتبة ال curl</td>
								<td><?php if(function_exists("curl_version")){
									echo '<p style="color:green">مفعلة</p>';
								}else{
									echo '<p style="color:red">غير مفعلة</p>';	
									$success = 0;
								}?></td>
							</tr>
							<tr>
								<td colspan="2">
									<?php if($success){
								echo '<h2><a href="setup.php?step=db" class="btn btn-block btn-primary">فحص الاتصال بالقاعدة</a></h2>';		
									}?>
								</td>
							</tr>
						</table>
						<?php }else if($step=='db'){ ?>
							<h2>فحص الاتصال بالقاعدة</h2>
								<?php 
									@mysql_close();
									$success = 1;
									
									if(@mysql_connect($SERVER,$DBUSER,$DBPASS)){
										if(@mysql_select_db($DBNAME)){
											echo "<h3 style='color:green'>تم الاتصال بالقاعدة بنجاح</h3>";
											echo '<h2><a href="setup.php?step=install" class="btn btn-block btn-primary">تركيب القاعدة</a></h2>';
										}else{
											echo "<h3 style='color:red'>هنالك مشكلة باسم القاعدة</h3>";
										}
									}else{
										echo "<h3 style='color:red'>هنالك مشكلة باسم المستخدم او كلمة السر للقاعدة</h3>";
									}
								?>
					<?php	}else if($step == 'install'){ $success = 1; ?>
							<h2>تركيب القاعدة</h2>
						<table class="table table-striped" style="width:100%;text-align: center">
							<tr style="font-weight: bold">
								<td>الجدول</td>
								<td>الحالة</td>
							</tr>
							<tr>
								<td>الاعدادات الرئيسية</td>
								<td>
									<?php 
									
									$tb1 = "CREATE TABLE IF NOT EXISTS `settings` (
											  `option` text NOT NULL,
											  `value` text NOT NULL
											) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
									if(@mysql_query($tb1)){
										echo '<p style="color:green">تم بنجاح</p>';
									}else{
										echo '<p style="color:red">لم تنجح العملية</p>';
										$success = 0;
									}		
									?>
								</td>
							</tr>
							<tr>
								<td>زرع المعلومات الرئيسية للاعدادات</td>
								<td>
									<?php 
									$tb1Stg = "INSERT INTO `settings` (`option`, `value`) VALUES
('title', 'HlounPost Version 2'),
('url', 'http://hloun.com/'),
('keyword', 'HlounPost Version 2'),
('des', 'HlounPost Version 2'),
('site_name', 'HlounPost Version 2'),
('site_status', '1'),
('close_msg', 'HlounPost Version 2'),
('home_msg', 'HlounPost Version 2'),
('home_ad', '&lt;img class=\\&quot;img-responsive img-rounded\\&quot; src=\\&quot;http://i.imgur.com/h9XmPUR.jpg\\&quot;&gt;'),
('admin_name', 'admin'),
('admin_email', 'bw4@hotmail.it'),
('admin_pass', '202cb962ac59075b964b07152d234b70'),
('email_rest', '1'),
('app_id', '123456789'),
('app_key', '4ead54712csad2c779bf1de3a8asdaa672d3'),
('fb_page', 'https://www.facebook.com/computarje'),
('reg_msg', '1'),
('reg_text', 'HlounPost Version 2'),
('user_mail', '1'),
('user_page', '1'),
('privacy', '&lt;b&gt;Personal identification information&lt;/b&gt;&lt;p&gt;We may collect personal identification information from Users in a variety of ways, including&lt;/p&gt;&lt;p&gt;, but not limited to, when Users visit our site, register on the site, and in connection with other activities,&lt;/p&gt;&lt;p&gt;&amp;nbsp;services, features or resources we make available on our Site. Users may be asked for, as appropriate,&lt;/p&gt;&lt;p&gt;&amp;nbsp;name, email address. We will collect personal identification information from Users only if they voluntarily&lt;/p&gt;&lt;p&gt;submit such information to us. Users can always refuse to supply personally identification information&lt;/p&gt;&lt;p&gt;, except that it may prevent them from engaging in certain Site related activities.Non-personal&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;b&gt;identification information&lt;/b&gt;&lt;/p&gt;&lt;p&gt;We may collect non-personal identification information about Users&lt;/p&gt;&lt;p&gt;&amp;nbsp;whenever they interact with our Site. Non-personal identification information may include the browser name,&lt;/p&gt;&lt;p&gt;&amp;nbsp;the type of computer and technical information about Users means of connection to our Site, &lt;/p&gt;&lt;p&gt;such as the operating system and the&lt;/p&gt;&lt;p&gt;&amp;nbsp;Internet service providers utilized and other similar information.&lt;/p&gt;'),
('restcode', ''),('isinstall','');";						@mysql_query("TRUNCATE TABLE  `settings`");
									if(@mysql_query($tb1Stg)){
										echo '<p style="color:green">تم بنجاح</p>';
									}else{
										echo '<p style="color:red">لم تنجح العملية</p>';
										$success = 0;
									}		
	
									?>
								</td>
							</tr>
							<tr>
								<td>المستخدمين</td>
								<td>
									<?php 
									
									$tb3 = "CREATE TABLE IF NOT EXISTS `users` (
										  `id` int(11) NOT NULL AUTO_INCREMENT,
										  `fb_id` text NOT NULL,
										  `fb_name` text NOT NULL,
										  `fb_email` text NOT NULL,
										  `fb_access` text NOT NULL,
										  `fb_gander` text NOT NULL,
										  `reg_date` text NOT NULL,
										  `last_login` text NOT NULL,
										  `country_code` text NOT NULL,
										  `last_share` int(11) NOT NULL,
										  PRIMARY KEY (`id`)
										) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
									if(@mysql_query($tb3)){
										echo '<p style="color:green">تم بنجاح</p>';
									}else{
										echo '<p style="color:red">لم تنجح العملية</p>';
										$success = 0;
									}		
									?>
								</td>
							</tr>
							<tr>
								<td>الصفحات</td>
								<td>
									<?php 
									
									$tb4 = "CREATE TABLE IF NOT EXISTS `pages` (
										  `id` int(11) NOT NULL AUTO_INCREMENT,
										  `user_id` text NOT NULL,
										  `page_id` text NOT NULL,
										  `page_name` text NOT NULL,
										  `last_share` int(11) NOT NULL,
										  PRIMARY KEY (`id`)
										) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
									if(@mysql_query($tb4)){
										echo '<p style="color:green">تم بنجاح</p>';
									}else{
										echo '<p style="color:red">لم تنجح العملية</p>';
										$success = 0;
									}		
									?>
								</td>
							</tr>
							<tr>
								<td>المنشورات</td>
								<td>
									<?php 
									
									$tb5 = "CREATE TABLE IF NOT EXISTS `posts` (
									  `id` int(11) NOT NULL AUTO_INCREMENT,
									  `date` text NOT NULL,
									  `type` int(11) NOT NULL,
									  `text` text NOT NULL,
									  `link` text NOT NULL,
									  PRIMARY KEY (`id`)
									) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
									";
									if(@mysql_query($tb5)){
										echo '<p style="color:green">تم بنجاح</p>';
									}else{
										echo '<p style="color:red">لم تنجح العملية</p>';
										$success = 0;
									}		
									?>
								</td>
							</tr>
							<tr>
								<td>اوامر النشر</td>
								<td>
									<?php 
									
									$tb6 = "CREATE TABLE IF NOT EXISTS `task` (
										  `id` int(11) NOT NULL AUTO_INCREMENT,
										  `type` int(11) NOT NULL,
										  `time` text NOT NULL,
										  `posts` text NOT NULL,
										  `count` text NOT NULL,
										  `gander` text NOT NULL,
										  `isfinish` int(11) NOT NULL,
										  `idnow` int(11) NOT NULL,
										  `taskfor` text NOT NULL,
										  `totalcount` int(11) NOT NULL,
										  `successed` int(11) NOT NULL,
										  `failed` int(11) NOT NULL,
										  PRIMARY KEY (`id`)
										) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
									if(@mysql_query($tb6)){
										echo '<p style="color:green">تم بنجاح</p>';
									}else{
										echo '<p style="color:red">لم تنجح العملية</p>';
										$success = 0;
									}		
									?>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<?php if($success){
								echo '<h2><a href="setup.php?step=info" class="btn btn-block btn-primary">معلومات الموقع</a></h2>';		
									}?>
								</td>
							</tr>
							
							</table>
					<?php	}else if($step=='info'){ ?>
						<h2>معلومات الموقع</h2>
						<form method="post" action="setup.php?step=end">
						<table class="table table-striped" style="width:100%;text-align: center">
							<tr>
								<td style="padding-top: 15px"><?=$ln['site_title']?></td>
								<td>
                                <input type='text' class='form-control updateOnChange' name='title'  />
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px"><?=$ln['site_url']?></td>
								<td>
                                <input type='text' class='form-control updateOnChange' style='direction:ltr' name='url' />
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px"><?=$ln['keyword']?></td>
								<td>
                                <input type='text' class='form-control updateOnChange' name='keyword' />
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px"><?=$ln['des']?></td>
								<td>
                                <input type='text' class='form-control updateOnChange' name='des'/>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px"><?=$ln['site_name']?></td>
								<td>
                                <input type='text' class='form-control updateOnChange' name='site_name'/>
								</td>
							</tr>
							
								<!--other side -->
							<tr>
								<td style="padding-top: 15px"><?=$ln['site_status']?></td>
								<td>
									<select class='form-control updateOnChange' name='site_status' style='height: 40px'>
	                                    <option value='1'><?=$ln['open']?></option>
	                                    <option value='2'><?=$ln['close']?></option>
	                                </select>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px"><?=$ln['close_msg']?></td>
								<td>
									 <textarea  class='form-control updateOnChange' name='close_msg'></textarea>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px"><?=$ln['home_msg']?></td>
								<td>
									 <textarea  class='form-control updateOnChange' name='home_msg'></textarea>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px"><?=$ln['home_ad']?></td>
								<td>
									 <textarea  class='form-control updateOnChange' name='home_ad'></textarea>
								</td>
							</tr>
							
							<tr>
								<td colspan="2"><hr /></td>
							</tr>
							<tr>
								<td style="padding-top: 15px"><?=$ln['app_id']?></td>
								<td>
									 <input type='text' class='form-control updateOnChange' name='app_id'/>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px"><?=$ln['app_key']?></td>
								<td>
									 <input type='text' class='form-control updateOnChange' name='app_key'/>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px"><?=$ln['fb_page']?></td>
								<td>
									 <input type='text' class='form-control updateOnChange' name='fb_page'/>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px"><?=$ln['user_mail']?></td>
								<td>
                                <select class='form-control updateOnChange' name='user_mail' style='height: 40px'>
                                    <option value='1'><?=$ln['open']?></option>
                                    <option value='2'><?=$ln['close']?></option>
                                </select>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px"><?=$ln['user_page']?></td>
								<td>
                                <select class='form-control updateOnChange' name='user_page' style='height: 40px'>
                                    <option value='1'><?=$ln['open']?></option>
                                    <option value='2'><?=$ln['close']?></option>
                                </select>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px"><?=$ln['reg_msg']?></td>
								<td>
                                <select class='form-control updateOnChange' name='reg_msg' style='height: 40px'>
                                    <option value='1'><?=$ln['open']?></option>
                                    <option value='2'><?=$ln['close']?></option>
                                </select>
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px"><?=$ln['reg_text']?></td>
								<td>
                                <textarea  class='form-control updateOnChange' name='reg_text'></textarea>
								</td>
							</tr>
							<tr>
								<td colspan="2"><hr /></td>
							</tr>
							<tr>
								<td style="padding-top: 15px"><?=$ln['admin_email']?></td>
								<td>
                                <input type='text' class='form-control updateOnChange' name='admin_email' />
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px"><?=$ln['admin_name']?></td>
								<td>
                                <input type='text' class='form-control updateOnChange' name='admin_name' />
								</td>
							</tr>
							<tr>
								<td style="padding-top: 15px"><?=$ln['new_pass']?></td>
								<td>
                                <input type='password' class='form-control updateOnChange' name='admin_pass' />
								</td>
							</tr>
							
							<tr>
								<td colspan="2"><br /><br />
									<input type="hidden" name="isinstall" value="1"/>
									<input type="submit" name="submit" value="حفظ الاعدادات" class="btn btn-block btn-primary" />
										<br />
									<div class="alert alert-danger">
										تاكد من تعبئة جميع الحقول بشكل صحيح خصوصا اسم المستخدم وكلمة السر لكي تستطيع تسجيل الدخول للوحة , ولكي يعمل التطبيق بشكل جيد !
									</div>
								</td>
							</tr>
						</table>
						</form>
					<?php }else if($step=="end"){
						  $success = 1;
						  $SQL = mysql_query("select * from `settings`");
						  while($data=mysql_fetch_object($SQL)){
						  		$key = $data->option;
							  	 $value;
								
								if(!empty($_POST[$key])){
									$value = ($key=='admin_pass') ? md5($_POST[$key]) : $_POST[$key];
									if(!mysql_query("update `settings` set `value`='$value' where `option`='$key'"))
										$success = 0;
							}
						  }
						  if($success){
						  ?>
						  	<h2>تم تنصيب السكربت بنجاح</h2>
						  	<p>
						  		تستطيع الدخول للوحة الادمن من خلال الرابط التالي
						  	</p>
						  	<br />
						  	<a href="admincp/index.php">لوحة التحكم</a>
						  	<br />
						  	<a href="index.php">رئيسية الموقع</a>
						  	<br />
						  	
						  	<a href="http://hloun.com/">الموقع الرسمي لدعم الفني</a>
						  	<br />
						  	<a href="http://facebook.com/baha2.vip">بهاء عودة</a>
						  	<br />
						  	<h3>هذا السكربت مجاني وغير مخصص للبيع مقدم من ليون بوست </h3>
						  	<br />
						  	<h3>تم تامين ملف التنصيب لن يعمل مرة اخرا  :)</h3>
						  	<br />
						  	<h3>شكرا لك</h3>
						  <?php
						  }else{
						  	echo '<div class="alert alert-danger">حدث خطا غير متوقع , تاكد من ان جميع المعلومات صحيحة بالصفحة السابقة</div>';
						 }
					} ?>
					</center>
				</div>
				<div class="col-lg-4">
					<div class="list-group">
					  <a href="#" class="list-group-item <?=($step=='') ? 'active': ''?>">الرئيسية</a>
					  <a href="#" class="list-group-item <?=($step=='server') ? 'active': ''?>">فحص السيرفر والملفات</a>
					  <a href="#" class="list-group-item <?=($step=='db') ? 'active': ''?>">فحص الاتصال بالقاعدة</a>
					  <a href="#" class="list-group-item <?=($step=='install') ? 'active': ''?>">تركيب القاعدة</a>
					  <a href="#" class="list-group-item <?=($step=='info') ? 'active': ''?>">معلومات الموقع</a>
					  <a href="#" class="list-group-item <?=($step=='end') ? 'active': ''?>">النهاية</a>
					</div>
				</div>
			</div>
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