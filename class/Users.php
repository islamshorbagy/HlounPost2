<?php
/**
 * Description of User
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
 *  Create In 21/3/2013 
 *  Last Edit :  
 */
class User {
    
    private $table  = 'users';
    
    private $md5    = true;
    
    private $uid    = 0;
    
    private $primary = 'id';
    
    private $passkey = 'password';
    
    private $loginBy = 'username';
    
    private $groups   = 'groups';
    
    private $secure = true;
    
    private $desecure   = null;

    private $uObject;
    
    
    public function setTable($value)
    {
        $this->table = $value;
    }
    public function setMd5($value)
    {
        $this->md5   = $value;
    }
    public function getMd5()
    {
        return $this->md5;
    }
    public function setPrimary($value)
    {
        $this->primary = $value;
    }
    public function getPrimary()
    {
        return $this->primary;
    }
    public function  setSecure($value,$desecure=null)
    {
        $this->secure = $value;
        $this->desecure = $desecure;
    }
    public function getSecure()
    {
        return $this->secure;
    }
    private function secure($value)
    {
        return htmlspecialchars(mysql_real_escape_string($value));
    }
    public function setLoginBy($value)
    {
        $this->loginBy = $value;
    }
    public function getLoginBy()
    {
        return $this->loginBy;
    }
    public function setUid($value)
    {
        $this->uid   = $this->filterId($value);
    }
    public function getUid()
    {
        return $this->uid;
    }
    private function filterId($value)
    {
        return abs(intval($value));
    }
    public function setPasskey($value)
    {
         $this->passkey = $value;    
    }
    public function getPasskey()
    {
        return $this->passkey;
    }
    public function setGorups($value)
    {
        $this->groups = $value;
    }
    public function getGroups()
    {
        return $this->groups;
    }
    public function isRegisterBy($key,$value)
    {
                if($this->secure)
                {
                    if(is_array($this->desecure))
                    {
                        if(!in_array($key,$this->desecure))
                               $value = $this->secure($value);
                    }else{
                        if($key != $this->desecure)
                            $value = $this->secure($value);
                    }
                }
                
          $sql = mysql_query("select * from $this->table where $key='$value'");
          if(mysql_num_rows($sql))
                return true;
       
        return false;
    }
    public function AddUser($data)
    {
        if(is_array($data))
        {
        $keys = '';
        $values = '';
        $i = count($data);
        foreach ($data as $key => $value)
        {   
            if($key==$this->passkey)
            {
                if($this->md5)
                  $value = md5($value);  
               
            }else{
                
                if($this->secure)
                {
                    if(is_array($this->desecure))
                    {
                        if(!in_array($key,$this->desecure))
                               $value = $this->secure($value);
                    }else{
                        if($key != $this->desecure)
                            $value = $this->secure($value);
                    }
                }   
             }
             
            
            
            if($i==1)
            {
            $keys .= $key;
            $values .=  "'".$value."'";
            }else{
            $keys .= $key.',';
            $values .= "'".$value."',";
            }
            $i--;
        }
        $sql = 'insert into '.$this->table.' ('.$keys.') values ('.$values.')';
       
        $Add = mysql_query($sql) or die(mysql_error());
        if($Add)
        {   $this->uid = mysql_insert_id();
            return true;      
        }
        
        }
        
        return FALSE;
    }
    
    public function getUser()
    {
        $id = $this->uid;
        $p = $this->primary;
        $data = mysql_query("select * from $this->table where $p='$id'");
        if(mysql_num_rows($data))
        {  
            $info = mysql_fetch_object($data);
            
            $this->uObject = $info;
            
            return $info;
        
        }
          return FALSE;
        
        
    }
    public function getValue($name)
    {
        ($this->uObject) ? '' : $this->getUser();
        return $this->uObject->$name;
    }
    
    public function UpdateUser($key,$value)
    {
        if(isset($this->uid))
        {
            
            if($key==$this->passkey)
            {
                if($this->md5)
                  $value = md5($value);  
               
            }else{    
                if($this->secure)
                {
                    if(is_array($this->desecure))
                    {
                        if(!in_array($key,$this->desecure))
                               $value = $this->secure($value);
                    }else{
                        if($key != $this->desecure)
                            $value = $this->secure($value);
                    }
                }   
             }
             
            $update = mysql_query("update $this->table set $key='$value' where $this->primary='$this->uid'");  
            if($update)
                return true;    
        }
     return false;   
    }
    
    public function getUsers($start=0,$end=0,$where="")
    {
        if($end==0)
            {
            $sql = mysql_query("select * from $this->table  $where order by $this->primary desc");
            }
            else
            {
             $sql = mysql_query("select * from $this->table $where order by $this->primary desc limit $start,$end");
            }
            
        if(mysql_num_rows($sql))
        {
            $info = array();
            while($data =  mysql_fetch_assoc($sql))
                  $info[] = $data;
            return $info;
        }
        return false;
    }
    
    public function getUsersNoLimit($where="")
    {
            $sql = mysql_query("select * from $this->table  $where order by $this->primary asc") or die(mysql_error());
            
        if(mysql_num_rows($sql))
        {
            $info = array();
            while($data =  mysql_fetch_assoc($sql))
                  $info[] = $data;
            return $info;
        }
        return false;
    }
    
    public function cCount($cc){
         $sql = mysql_query("select * from $this->table where country_code='$cc'");
         if(mysql_num_rows($sql)==0)
             return false;
         else
             return mysql_num_rows($sql);
    }
    public function cCountMF($cc){
         $sql = mysql_query("select * from $this->table where fb_gander='$cc'");
         if(mysql_num_rows($sql)==0)
             return false;
         else
             return mysql_num_rows($sql);
    }
    public function cCounAcOrNot($cc){
         $sql = mysql_query("select * from $this->table where last_share='$cc'");
         if(mysql_num_rows($sql)==0)
             return false;
         else
             return mysql_num_rows($sql);
    }
    
    public function login($user,$pass,$group=0)
    {
                $user  = $this->secure($user);
                $pass  = ($this->md5) ? md5($pass) : $pass;
                $group = $this->filterId($group); 
        $sql = mysql_query("select * from $this->table where $this->loginBy='$user' and $this->passkey='$pass' and $this->groups='$group'") or die(mysql_error());
        if($sql)
        {
            if(mysql_num_rows($sql))
            {    
                     $data = mysql_fetch_array($sql);
                    if($data[$this->loginBy] == $user)
                    {
                        if($data[$this->passkey] == $pass)
                        {
                            if($data[$this->groups] == $group)
                            {   
                                $this->setUid($data[$this->primary]);
                                return TRUE;
                            }
                        }
                    }
                
            }
        }
        
    return false;    
    }
    
    public function Delete()
    {
        if(isset($this->uid))
        {
            $already = mysql_query(" select * from $this->table where $this->primary='$this->uid'");
            if(mysql_num_rows($already))
            {
                $sql = mysql_query("DELETE from $this->table where $this->primary='$this->uid'");
                if($sql)
                    return true;
            }
        }
        
      return false;  
    }
    
    function delNotActive(){
        $sql = mysql_query("DELETE from $this->table where last_share='2'");
        if($sql)
            return true;
        else return false;
    }
    
    
    
    
    
   
    
    
    
}

?>