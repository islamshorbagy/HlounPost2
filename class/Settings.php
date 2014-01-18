<?php
/**
 * Description of Settings
 *  
 *  @author Bahaa
 *  @PHP Web Developer 
 *  @Google Adsense
 *  @Android Developer
 *  @Website (new) Designer
 *  @Webhost manager 
 *  @MySite
 *  http://www.baha2.in
 *  @MyFacebook
 *  http://facebook.com/Baha2.Vip
 *  @MyTwiiter
 *  http://twitter.com/baha2odeh
 *  
 * @ClassInfo
 *  Create In 23/7/2013 
 *  Last Edit :  
 */
class Settings {
    //put your code here
    private $tb;
    private $options = array();
    private $optionupdate = array();
    function __construct($_tb)
    {
        $this->tb = $_tb;
    }
    
    function AddOption($_option,$_value)
    {
        $this->options[] = array('option'=>$this->secure(strtolower($_option)),'value'=>$this->secure($_value));
    }
    
    function optionExisit($option)
    {   
        $option = $this->secure(strtolower($option));
           
        $sql = mysql_query("select * from `$this->tb` where `option` = '$option'");
        if(mysql_num_rows($sql)>=1)
             return true;
        else
            return false;
    }
    function Add()
    {   
        $notempty = true;
        $msgs = array();
        $options = $this->options;
        if(count($options)>0)
        {   
            foreach ($options as $item) {
                $option = $item['option'];
                $value  = $item['value'];   
                if(!$this->optionExisit($option)){
                       
                    $sql = mysql_query("insert into `$this->tb`  (`option`,`value`) values ('$option','$value')")or die(mysql_error());
                    if($sql)
                       $msgs[$option] =  true;
                    else
                       $msgs[$option] =  false;
                }else
                    $msgs[$option] =  false;
              }
            
        }else
            $notempty = false;   
        
      return array('sucess'=>$notempty,'msgs'=>$msgs);
    }
    
    function get($option)
    {   
        $option = $this->secure(strtolower($option));
        if($this->optionExisit($option))
        {
               
            $sql = mysql_query("select * FROM `$this->tb` where `option` = '$option' limit 1");
            if(mysql_num_rows($sql))
            {
               $data = mysql_fetch_object($sql);
               return $this->Desecure($data->value);
            }
        }
        return false;
    }
    function updateOption($_option,$_value)
    {
        if($this->optionExisit($_option))
            $this->optionupdate[] = array('option'=>$this->secure(strtolower($_option)),'value'=>$this->secure($_value));
    }
    function update()
    {
        $notempty = true;
        $msgs = array();
        $options = $this->optionupdate;
        if(count($options)>0)
        {   
            
            foreach ($options as $item) {
                
                $option = $item['option'];
                $value  = $item['value'];   
                if($this->optionExisit($option)){
                       
                    $sql = mysql_query(" update `$this->tb`  set `value`= '$value' where `option` = '$option' ") or die(mysql_error());
                    if($sql)
                       $msgs[$option] =  true;
                    else
                       $msgs[$option] =  false;
                }else
                    $msgs[$option] =  false;
              }
            
        }else
            $notempty = false;   
        
      return array('sucess'=>$notempty,'msgs'=>$msgs);
    }
    public function Count($tbname)
    {   
        $tbname = $this->secure($tbname);
           
        $num_result = mysql_query("SELECT count(*) as total_count from `$tbname` ") or exit(mysql_error());
        $row = mysql_fetch_object($num_result);
        return $row->total_count;
    }
    
    function secure($html)
    {
        return addslashes(htmlspecialchars(mysql_real_escape_string($html)));
    }
    function Desecure($html)
    {
        return stripslashes($html);
    }
    
    function isImg($data){
         $r = true;
                $notAllow = @explode('|','evel|base|encode|decode|print|close|hide|display|connect|select|order|src|link|charset|title|safe|mode|php|css|style|span|div|echo|play|stop|any|text|expression|behaviour|applet|link|style|frame|frameset');
                foreach($notAllow as $b){
                        if(strpos($data, $b) !== false){
                         $r = false;
                         break;
                        }
                }
                if($r){
                $im = @imagecreatefromstring($data);
                if(!$im)
                        $r = false;
                }
                return $r;
     }
     function login($username,$password)
    {
     
       if($this->get("admin_name")==$this->secure($username) && $this->get("admin_pass")==md5($password))
       {
           $_SESSION['login'] = true;
           $_SESSION['admin_name'] = $this->get("admin_name");
           return array('st'=>'ok','msg'=>'تم تسجيل الدخول بنجاح  <meta http-equiv="refresh" content="2; url='.$this->get('url').'/admincp/" />');
       }else{
           return array('st'=>'error','msg'=>'كلمة السر  او اسم المستخدم غير صحيح');
       }
    }
    
    function logout(){
        $_SESSION['login'] = false;
        unset($_SESSION['login'] );
        unset($_SESSION['admin_name'] );
    }
    
    function isLogin(){
        if($_SESSION['login'])
            return true;
        
        return false;;
    }
    
    function countre(){
        return array('Andorra',
'United Arab Emirates',
'Afghanistan',
'Antigua and Barbuda',
'Anguilla',
'Albania',
'Armenia',
'Angola',
'Antarctica',
'Argentina',
'American Samoa',
'Austria',
'Australia',
'Aruba',
'Aland Islands',
'Azerbaijan',
'Bosnia and Herzegovina',
'Barbados',
'Bangladesh',
'Belgium',
'Burkina Faso',
'Bulgaria',
'Bahrain',
'Burundi',
'Benin',
'Saint Barthalemy',
'Bermuda',
'Brunei Darussalam',
'Bolivia, Plurinational State of',
'Bonaire, Sint Eustatius and Saba',
'Brazil',
'Bahamas',
'Bhutan',
'Bouvet Island',
'Botswana',
'Belarus',
'Belize',
'Canada',
'Cocos (Keeling) Islands',
'Congo, the Democratic Republic of the',
'Central African Republic',
'Congo',
'Switzerland',
'Cote d\'Ivoire ! CÃ´te d\'Ivoire ',
'Cook Islands',
'Chile',
'Cameroon',
'China',
'Colombia',
'Costa Rica',
'Cuba',
'Cape Verde',
'CuraÃ§ao',
'Christmas Island',
'Cyprus',
'Czech Republic',
'Germany',
'Djibouti',
'Denmark',
'Dominica',
'Dominican Republic',
'Algeria',
'Ecuador',
'Estonia',
'Egypt',
'Western Sahara',
'Eritrea',
'Spain',
'Ethiopia',
'Finland',
'Fiji',
'Falkland Islands (Malvinas)',
'Micronesia, Federated States of',
'Faroe Islands',
'France',
'Gabon',
'United Kingdom',
'Grenada',
'Georgia',
'French Guiana',
'Guernsey',
'Ghana',
'Gibraltar',
'Greenland',
'Gambia',
'Guinea',
'Guadeloupe',
'Equatorial Guinea',
'Greece',
'South Georgia and the South Sandwich Islands',
'Guatemala',
'Guam',
'Guinea-Bissau',
'Guyana',
'Hong Kong',
'Heard Island and McDonald Islands',
'Honduras',
'Croatia',
'Haiti',
'Hungary',
'Indonesia',
'Ireland',
'Israel',
'Isle of Man',
'India',
'British Indian Ocean Territory',
'Iraq',
'Iran, Islamic Republic of',
'Iceland',
'Italy',
'Jersey',
'Jamaica',
'Jordan',
'Japan',
'Kenya',
'Kyrgyzstan',
'Cambodia',
'Kiribati',
'Comoros',
'Saint Kitts and Nevis',
'Korea, Democratic People\'s Republic of',
'Korea, Republic of',
'Kuwait',
'Cayman Islands',
'Kazakhstan',
'Lao People\'s Democratic Republic',
'Lebanon',
'Saint Lucia',
'Liechtenstein',
'Sri Lanka',
'Liberia',
'Lesotho',
'Lithuania',
'Luxembourg',
'Latvia',
'Libya',
'Morocco',
'Monaco',
'Moldova, Republic of',
'Montenegro',
'Saint Martin (French part)',
'Madagascar',
'Marshall Islands',
'Macedonia, the former Yugoslav Republic of',
'Mali',
'Myanmar',
'Mongolia',
'Macao',
'Northern Mariana Islands',
'Martinique',
'Mauritania',
'Montserrat',
'Malta',
'Mauritius',
'Maldives',
'Malawi',
'Mexico',
'Malaysia',
'Mozambique',
'Namibia',
'New Caledonia',
'Niger',
'Norfolk Island',
'Nigeria',
'Nicaragua',
'Netherlands',
'Norway',
'Nepal',
'Nauru',
'Niue',
'New Zealand',
'Oman',
'Panama',
'Peru',
'French Polynesia',
'Papua New Guinea',
'Philippines',
'Pakistan',
'Poland',
'Saint Pierre and Miquelon',
'Pitcairn',
'Puerto Rico',
'Palestine, State of',
'Portugal',
'Palau',
'Paraguay',
'Qatar',
'Reunion ! RÃ©union ',
'Romania',
'Serbia',
'Russian Federation',
'Rwanda',
'Saudi Arabia',
'Solomon Islands',
'Seychelles',
'Sudan',
'Sweden',
'Singapore',
'Saint Helena, Ascension and Tristan da Cunha',
'Slovenia',
'Svalbard and Jan Mayen',
'Slovakia',
'Sierra Leone',
'San Marino',
'Senegal',
'Somalia',
'Suriname',
'South Sudan',
'Sao Tome and Principe',
'El Salvador',
'Sint Maarten (Dutch part)',
'Syrian Arab Republic',
'Swaziland',
'Turks and Caicos Islands',
'Chad',
'French Southern Territories',
'Togo',
'Thailand',
'Tajikistan',
'Tokelau',
'Timor-Leste',
'Turkmenistan',
'Tunisia',
'Tonga',
'Turkey',
'Trinidad and Tobago',
'Tuvalu',
'Taiwan, Province of China',
'Tanzania, United Republic of',
'Ukraine',
'Uganda',
'United States Minor Outlying Islands',
'United States',
'Uruguay',
'Uzbekistan',
'Holy See (Vatican City State)',
'Saint Vincent and the Grenadines',
'Venezuela, Bolivarian Republic of',
'Virgin Islands, British',
'Virgin Islands, U.S.',
'Viet Nam',
'Vanuatu',
'Wallis and Futuna',
'Samoa',
'Yemen',
'Mayotte',
'South Africa',
'Zambia',
'Zimbabwe');
    }
    function countreCode(){
        return array('AD','AE','AF','AG','AI','AL','AM','AO','AQ','AR','AS','AT','AU','AW','AX','AZ','BA','BB','BD','BE','BF','BG','BH','BI','BJ','BL','BM','BN','BO','BQ','BR','BS','BT','BV','BW','BY','BZ','CA','CC','CD','CF','CG','CH','CI','CK','CL','CM','CN','CO','CR','CU','CV','CW','CX','CY','CZ','DE','DJ','DK','DM','DO','DZ','EC','EE','EG','EH','ER','ES','ET','FI','FJ','FK','FM','FO','FR','GA','GB','GD','GE','GF','GG','GH','GI','GL','GM','GN','GP','GQ','GR','GS','GT','GU','GW','GY','HK','HM','HN','HR','HT','HU','ID','IE','IL','IM','IN','IO','IQ','IR','IS','IT','JE','JM','JO','JP','KE','KG','KH','KI','KM','KN','KP','KR','KW','KY','KZ','LA','LB','LC','LI','LK','LR','LS','LT','LU','LV','LY','MA','MC','MD','ME','MF','MG','MH','MK','ML','MM','MN','MO','MP','MQ','MR','MS','MT','MU','MV','MW','MX','MY','MZ','NA','NC','NE','NF','NG','NI','NL','NO','NP','NR','NU','NZ','OM','PA','PE','PF','PG','PH','PK','PL','PM','PN','PR','PS','PT','PW','PY','QA','RE','RO','RS','RU','RW','SA','SB','SC','SD','SE','SG','SH','SI','SJ','SK','SL','SM','SN','SO','SR','SS','ST','SV','SX','SY','SZ','TC','TD','TF','TG','TH','TJ','TK','TL','TM','TN','TO','TR','TT','TV','TW','TZ','UA','UG','UM','US','UY','UZ','VA','VC','VE','VG','VI','VN','VU','WF','WS','YE','YT','ZA','ZM','ZW');
    }
    
    function CCout(){
         $p = $this->countreCode();
         return count($p);
    }
    function getCCode($pos){
        $p = $this->countreCode();
        return $p[$pos];
    }
    
    function getCName($cOde){
           $cc = $this->countreCode();
           $C = $this->countre();
            for($i=0;$i<count($cc);$i++){
                if(strtolower($cc[$i]) == $cOde)
                {
                    break;
                }
            }
            return $C[$i];
    }
    public function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=mysql_real_escape_string($_SERVER['HTTP_CLIENT_IP']);
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=mysql_real_escape_string($_SERVER['HTTP_X_FORWARDED_FOR']);
    }
    else
    {
      $ip=mysql_real_escape_string($_SERVER['REMOTE_ADDR']);
    }
    return $ip;
}
    
  public function visitor_country()
   {
                
           $ip = $this->getRealIpAddr();
       //    $ip = "79.173.199.93";
           $ip_data = @json_decode(getLink("http://www.geoplugin.net/json.gp?ip=".$ip));
           if($ip_data && $ip_data->geoplugin_countryCode != null)
          {
               $result = $ip_data->geoplugin_countryCode;
             return $result;
          }
          else{
          return 'Un Known';
          }
    }
    function sendMail($to, $name, $subject, $message)
    {
        $from = 'support-hlounlive@hloun.com';
        $headers ="MIME-Version:1.0\r\n";
        $headers .="content-type:text/html; Charset=utf-8\r\n";
        $headers .= "From: " . "$name" . "<" . "$from" . ">\n";
        $headers .= "Return-Path: <" . "$to" . ">\n";
        $headers .= "Error-To: <" . "$to" . ">\n";
        $headers .= "X-Sender: <" . "$to" . ">\n";
        $headers .= "X-Mailer: PHP v".phpversion()."\n";


        $subject= nl2br($subject);
        $message=nl2br($message);
        $to=$to;
        $mail= @mail($to, $subject, $message, $headers)	 ;
        return $mail;
    }
}

?>
