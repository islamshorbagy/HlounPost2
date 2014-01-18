<?php session_start();

$SERVER = "localhost";
 
 $DBNAME = "hloun2install";
 
 $DBUSER = "root";
 
 $DBPASS = "baha";
 
 
 mysql_connect($SERVER,$DBUSER,$DBPASS);
// mysql_query("SET character_set_results=utf8");
// mb_language('uni'); 
// mb_internal_encoding('UTF-8');
 mysql_select_db($DBNAME);
// mysql_query("set names 'utf8'");
 
 function cptime($start)
         {
		    $time = time() - $start ;

		    if($time <= 59)
                {
    		        return 'منذ '.$time.'  ثوان مضت';
		        }
            elseif($time == 60)
                {
    		        return 'منذ دقيقه مضت';
		        }
		    elseif(60 < $time && $time <= 3600)
                {   $time = ceil($time/60);
		            return  $time.' دقائق مضت';
    	        }
    	    elseif(3600 < $time && $time <= 86400)
                {   $time = ceil($time/3600);
		            return  $time.' ساعات مضت';
    	        }
    	    elseif(86400 < $time && $time <= 604800)
                {   $time = ceil($time/86400) ;
		            return  $time.' ايام مضت';
    	        }
    	    elseif(604800 < $time && $time <= 2592000)
                {   $time = ceil($time/604800);
		            return  $time.' اسابيع مضت';
    	        }
    	    elseif(2592000 < $time && $time <= 29030400)
                {    $time = ceil($time/2592000);
		            return   $time.' شهور مضت';
    	        }
    	    else
                {
		            return date('M d y at h:i A',$start);
    	        }
		}

                
function getLink($url){

$contetn = @file_get_contents($url);
        if (empty($contetn)){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_URL, $url);
        $contetn= curl_exec($ch);
        curl_close($ch);
       }
return str_replace("access_token=","",$contetn);
}
                
                
/*
 * <div class="row box" style="width:1002px;direction: rtl">
                <div class="col-md-6">
                    <h4>الاصدار الثاني</h4>
                    <h4><a href="http://baha2.in/">Baha'a Odeh</a></h4>
                    <h4><a href="http://hloun.com">Hloun.com</a></h4>
                </div>
                <div class="col-md-6">
                    <h4>سكربت ليون بوست</h4>
                    <h4>برمجة</h4>
                    <h4>الموقع الرسمي</h4>
                </div>        
            </div>
 */
 define(COPYRIGHT, '<center style="margin-top:50px"><a href="//hloun.com">Powered By HlounPost Version 2</a></center>')
?>