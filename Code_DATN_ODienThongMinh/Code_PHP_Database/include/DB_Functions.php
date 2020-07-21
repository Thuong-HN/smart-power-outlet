<?php
class DB_Functions {

    private $db;

    //put your code here
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }

    // destructor
    function __destruct() {
        
    }

	public	function updatedata($email,$kw1,$kwh1,$stt1,$dvname1,$kw2,$kwh2,$stt2,$dvname2,$kw3,$kwh3,$stt3,$dvname3){
		// ****** Không cần email trong code esp nên phải gán id = 1 *************
		$rows = mysql_query("SELECT * FROM nguoidung WHERE email = '$email'") or die(mysql_error());
		$row = mysql_fetch_array($rows,MYSQL_ASSOC);
		$id=$row["id"];
		$tt1=$row["tt1"];
		$tt2=$row["tt2"];
		$tt3=$row["tt3"];
		$sta1=$row["sta1"];
		$sta2=$row["sta2"];
		$sta3=$row["sta3"];
		$sto1=$row["sto1"];
		$sto2=$row["sto2"];
		$sto3=$row["sto3"];
		$command1=$row["command1"];
		$command2=$row["command2"];
		$command3=$row["command3"];
			
		if($id) {
			
			$rs = mysql_query("UPDATE `nguoidung` SET `kw1`='$kw1',`kwh1`='$kwh1' , `stt1`='$stt1' , `dvname1`='$dvname1' , 
								`kw2`='$kw2',`kwh2`='$kwh2' , `stt2`='$stt2' , `dvname2`='$dvname2' , `kw3`='$kw3',
								`kwh3`='$kwh3' , `stt3`='$stt3' , `dvname3`='$dvname3' WHERE `nguoidung`.`id`=$id")or die(mysql_error());
			
			if($rs) {
						
				
				if($rows){
					$chatime = mysql_query("SELECT dvname1,kwh1,kwh2,kwh3 FROM nguoidung WHERE id = $id") or die(mysql_error()); // nếu có NFC cắm vào
					$changetime = mysql_fetch_array($chatime,MYSQL_ASSOC);
					$wtime=$changetime["dvname1"];
					
							
					if($wtime==="BongDen"){  
						mysql_query("UPDATE `nguoidung` SET `sta1`='9:11',`sto1`='9:20'  WHERE `nguoidung`.`id`=$id")or die(mysql_error());
						
					}
					//******* nếu công suất thiết bị nằm trong khoảng thì định danh cho thiết bị đó ********
					/* if($timekwh1>="38" &&  $timekwh1<="40"){mysql_query("UPDATE `nguoidung` SET `dvname2`='Quat'  WHERE `nguoidung`.`id`='1'")or die(mysql_error());}
					if($timekwh2>="1000" &&  $timekwh2<="1100"){mysql_query("UPDATE `nguoidung` SET `dvname3`='Am nuoc'  WHERE `nguoidung`.`id`='1'")or die(mysql_error());}  */	
					
					// ******** HẸN GIỜ **************
					
					date_default_timezone_set("Asia/Bangkok");
					$Setime = date("G:i");
					$isetime=strpos($Setime,":");
					if(intval(substr($Setime,$isetime+1,1))===0){$isetime=$isetime+1;} //nếu giờ app dạng 9:1
					$star1=strpos($sta1,":");
					$star2=strpos($sta2,":");
					$star3=strpos($sta3,":");
					$stop1=strpos($sto1,":");
					$stop2=strpos($sto2,":");
					$stop3=strpos($sto3,":");
					
					if((($command1==="1") and ($tt1==="TRUE")) and (intval(substr($Setime,0,$isetime)) == intval(substr($sta1,0,$star1))) and (intval(substr($Setime,$isetime+1)) == intval(substr($sta1,$star1+1)))){
						mysql_query("UPDATE `nguoidung` SET `tt1`='FALSE',`onoff1`='ON'  WHERE `nguoidung`.`id`=$id")or die(mysql_error());
						
				
					}
					if((($command2==="1") and ($tt2==="TRUE")) and (intval(substr($Setime,0,$isetime)) ==intval(substr($sta2,0,$star2))) and (intval(substr($Setime,$isetime+1)) == intval(substr($sta2,$star2+1)))){
						mysql_query("UPDATE `nguoidung` SET `tt2`='FALSE',`onoff2`='ON'  WHERE `nguoidung`.`id`=$id")or die(mysql_error());
				
					}
					if((($command3==="1") and ($tt3==="TRUE")) and (intval(substr($Setime,0,$isetime)) ==intval(substr($sta3,0,$star3))) and (intval(substr($Setime,$isetime+1)) == intval(substr($sta3,$star3+1)))){
						mysql_query("UPDATE `nguoidung` SET `tt3`='FALSE',`onoff3`='ON' WHERE `nguoidung`.`id`=$id")or die(mysql_error());
				
					}
			
					if((($command1==="1") and ($tt1==="FALSE")) and (intval(substr($Setime,0,$isetime)) == intval(substr($sto1,0,$stop1))) and (intval(substr($Setime,$isetime+1)) == intval(substr($sto1,$stop1+1)))){
						mysql_query("UPDATE `nguoidung` SET `tt1`='TRUE',`onoff1`='OFF' WHERE `nguoidung`.`id`=$id")or die(mysql_error());
				
					}
					if((($command2==="1") and ($tt2==="FALSE")) and (intval(substr($Setime,0,$isetime)) == intval(substr($sto2,0,$stop2))) and (intval(substr($Setime,$isetime+1)) == intval(substr($sto2,$stop2+1)))){
						mysql_query("UPDATE `nguoidung` SET `tt2`='TRUE',`onoff2`='OFF' WHERE `nguoidung`.`id`=$id")or die(mysql_error());
				
					}
					if((($command3==="1") and ($tt3==="FALSE")) and (intval(substr($Setime,0,$isetime)) == intval(substr($sto3,0,$stop3))) and (intval(substr($Setime,$isetime+1)) == intval(substr($sto3,$stop3+1)))){
						mysql_query("UPDATE `nguoidung` SET `tt3`='TRUE',`onoff3`='OFF' WHERE `nguoidung`.`id`=$id")or die(mysql_error());
					}
				
					//*********** Trả về *************
					
					$response["success"] = 1;
					$response["error"] = 0;					
					
					$response["onoff1"] = $row["onoff1"];
					
					$response["onoff2"] = $row["onoff2"];
					
					$response["onoff3"] = $row["onoff3"];
					
					return 	$response;
					
					}
					
				}
		}				
		return false;
	
	}
	
	public function getdata($email){
	
	
		$rows = mysql_query("SELECT * FROM nguoidung WHERE email = '$email'") or die(mysql_error());
		$row = mysql_fetch_array($rows,MYSQL_ASSOC);
		
		if($rows){
		
			$response["success"] = 1;
			$response["error"] = 0;
			$response["kw1"] = $row["kw1"];
			$response["kwh1"] = $row["kwh1"];
			$response["stt1"] = $row["stt1"];
			$response["onoff1"] = $row["onoff1"];
			$response["sta1"] = $row["sta1"];
			$response["sto1"] = $row["sto1"];
			$response["command1"]= $row["command1"];
			$response["dvname1"] = $row["dvname1"];
			
			$response["kw2"] = $row["kw2"];
			$response["kwh2"] = $row["kwh2"];
			$response["stt2"] = $row["stt2"];
			$response["onoff2"] = $row["onoff2"];
			$response["sta2"] = $row["sta2"];
			$response["sto2"] = $row["sto2"];
			$response["command2"]= $row["command2"];
			$response["dvname2"] = $row["dvname2"];
			
			$response["kw3"] = $row["kw3"];
			$response["kwh3"] = $row["kwh3"];
			$response["stt3"] = $row["stt3"];
			$response["onoff3"] = $row["onoff3"];
			$response["sta3"] = $row["sta3"];
			$response["sto3"] = $row["sto3"];
			$response["command3"]= $row["command3"];
			$response["dvname3"] = $row["dvname3"];
			
			return 	$response;
		
		}		
		else return false;
	}
	
	public function updatecontrol($email,$command1,$command2,$command3,$onoff1,$sta1,$sto1,$onoff2,$sta2,$sto2,$onoff3,$sta3,$sto3){
	
	
		
		$rows = mysql_query("SELECT id FROM nguoidung WHERE email = '$email' ") or die(mysql_error());
		$row = mysql_fetch_array($rows,MYSQL_ASSOC);
		$id=$row["id"];
		// ******** CÓ điều khiển thì mới lưu email vừa đăng ký vào database******************
		if($id) {
			$rs = mysql_query("UPDATE `nguoidung` SET `onoff1`='$onoff1' , `sta1`='$sta1' , `sto1`='$sto1' , 
								`onoff2`='$onoff2' , `sta2`='$sta2' , `sto2`='$sto2',
								`onoff3`='$onoff3' , `sta3`='$sta3' , `sto3`='$sto3',
								`command1`='$command1',`command2`='$command2',`command3`='$command3' 
WHERE `nguoidung`.`id`=$id")or die(mysql_error());
			if($rs) return true;
		}		
		return false;
	
	}
	
	public function random_string()
{
    $character_set_array = array();
    $character_set_array[] = array('count' => 7, 'characters' => 'abcdefghijklmnopqrstuvwxyz');
    $character_set_array[] = array('count' => 1, 'characters' => '0123456789');
    $temp_array = array();
    foreach ($character_set_array as $character_set) {
        for ($i = 0; $i < $character_set['count']; $i++) {
            $temp_array[] = $character_set['characters'][rand(0, strlen($character_set['characters']) - 1)];
        }
    }
    shuffle($temp_array);
    return implode('', $temp_array);
}


public function forgotPassword($forgotpassword, $newpassword, $salt){
	$result = mysql_query("UPDATE `users` SET `encrypted_password` = '$newpassword',`salt` = '$salt' 
						  WHERE `email` = '$forgotpassword'");

if ($result) {
 
return true;

}
else
{
return false;
}

}
/**
     * Adding new user to mysql database
     * returns user details
     */

    public function storeUser($fname, $lname, $email, $uname, $password) {
        $uuid = uniqid('', true);
		
        $hash = $this->hashSSHA($password); // mã hóa pass
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
		//******* Tào một hàng mới trong bảng **********
		mysql_query("INSERT INTO nguoidung (email) VALUES ('$email')");
        $result = mysql_query("INSERT INTO users(unique_id, firstname, lastname, email, username, encrypted_password, salt, created_at) VALUES('$uuid', '$fname', '$lname', '$email', '$uname', '$encrypted_password', '$salt', NOW())");
        //***************************************************************//
		//mysql_query("INSERT INTO nguoidung (email) VALUES ('$email')");
		
        if ($result) {
			
            // get user details 
            $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM users WHERE uid = $uid");
            // return user details
            return mysql_fetch_array($result);
        } else {
            return false;
        }
		
    }

    /**
     * Verifies user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {
        $result = mysql_query("SELECT * FROM users WHERE email = '$email'") or die(mysql_error());
        // check for result 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
			//*** Tạo hàng mới trên nguoidung ******
			
			
            $result = mysql_fetch_array($result);
            $salt = $result['salt'];
            $encrypted_password = $result['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) { // kiểm tra pass
                // user authentication details are correct
                return $result;
            }
        } else {
            // user not found
            return false;
        }
    }

 /**
     * Checks whether the email is valid or fake
     */
public function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || 
 ↪checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}

 /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $result = mysql_query("SELECT email from users WHERE email = '$email'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }

    /**
     * Encrypting password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }
	
}

?>
