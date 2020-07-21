<?php


if (isset($_POST['tag']) && $_POST['tag'] != '') {
    // Get tag
    $tag = $_POST['tag'];

    // Include Database handler
    require_once 'include/DB_Functions.php';
    $db = new DB_Functions();
    // response Array
    $response = array("tag" => $tag, "success" => 0,"error" => 0);

    // check for tag type
    if ($tag == 'androiddown') {
				
        $email = $_POST['email'];  // email lấy từ android gửi lên ( email lấy từ phần đăng ký -> login -> control,status,wattmeter,NFC)      
		$rs=$db->getdata($email);
		//$rs=$db->getdata();
		
		if($rs){       									
			echo json_encode($rs);
		}else{
			$response["success"] = 0;
			$response["error"] = 1;
			echo json_encode($response);
		}	
		
    }elseif($tag == 'espup'){
		//Tất cả các dữ liệu gửi bằng phương thức POST đều được lưu trong một biến toàn cục $_POST do PHP tự tạo ra, vì thế để lấy dữ liệu thì bạn chỉ cần lấy trong biến này là được. Cũng như lưu ý với các bạn là trước khi lấy phải dùng hàm isset($bien) để kiểm tra có hay không nhé.
		//Với phương thức GET thì dữ liệu được thấy trên URL thì phương thức POST thì hoàn toàn ngược lại, POST sẽ gửi dữ liệu qua một cái form HTML và các giá trị sẽ được định nghĩa trong các input gồm các kiểu (textbox, radio, checkbox, password, textarea, hidden) và được nhận dang thông qua tên (name) của các input đó.
		//Hàm isset() được dùng để kiểm tra một biến nào đó đã được khởi tạo trong bộ nhớ của máy tính hay chưa, nếu nó đã khởi tạo (tồn tại) thì sẽ trả về TRUE và ngược lại sẽ trả về FALSE.
		if(isset($_POST['email']) && $_POST['email'] != ''
		&&isset($_POST['kw1']) && $_POST['kw1'] != ''
		&&isset($_POST['kwh1']) && $_POST['kwh1'] != ''
		&&isset($_POST['kw2']) && $_POST['kw2'] != ''
		&& isset($_POST['kwh2']) && $_POST['kwh2'] != '' 
		&&isset($_POST['kw3']) && $_POST['kw3'] != ''
		&& isset($_POST['kwh3']) && $_POST['kwh3'] != ''){
			$email = $_POST['email'];
			$kw1 = $_POST['kw1'];
			$kwh1 = $_POST['kwh1'];
			$stt1 = $_POST['stt1'];
			$dvname1 = $_POST['dvname1'];
			$kw2 = $_POST['kw2'];
			$kwh2 = $_POST['kwh2'];
			$stt2 = $_POST['stt2'];
			$dvname2 = $_POST['dvname2'];
			$kw3 = $_POST['kw3'];
			$kwh3 = $_POST['kwh3'];
			$stt3 = $_POST['stt3'];
			$dvname3 = $_POST['dvname3'];
			
			
			$rs=$db->updatedata($email,$kw1,$kwh1,$stt1,$dvname1,$kw2,$kwh2,$stt2,$dvname2,$kw3,$kwh3,$stt3,$dvname3);
			
			if($rs){       			
						
				echo json_encode($rs);
			}else{
				$response["success"] = 0;
				$response["error"] = 1;
				echo json_encode($response);
			}
		}else{
				$response["success"] = 0;
				$response["error"] = 1;
				$response["msg"] = "Loi cu phap";
				echo json_encode($response);
			}
		
		
	}elseif($tag == 'sendcontrol'){
	
		$email = $_POST['email'];
		$command1 = $_POST['command1'];
		$command2 = $_POST['command2'];
		$command3 = $_POST['command3'];
		$onoff1 = $_POST['onoff1'];
		$sta1 = $_POST['sta1'];
		$sto1 = $_POST['sto1'];
		$onoff2 = $_POST['onoff2'];
		$sta2 = $_POST['sta2'];
		$sto2 = $_POST['sto2'];
		$onoff3 = $_POST['onoff3'];
		$sta3 = $_POST['sta3'];
		$sto3 = $_POST['sto3'];
		
		$rs=$db->updatecontrol($email,$command1,$command2,$command3,$onoff1,$sta1,$sto1,$onoff2,$sta2,$sto2,$onoff3,$sta3,$sto3);
		
		
		if($rs){       			
			$response["success"] = 1;
			$response["error"] = 0;			
			echo json_encode($response);
		}else{
			$response["success"] = 0;
			$response["error"] = 1;
			echo json_encode($response);
		}
	
	}
	elseif ($tag == 'login') {
        // Request type is check Login
        $email = $_POST['email'];
        $password = $_POST['password'];

        // check for user
        $user = $db->getUserByEmailAndPassword($email, $password);
        if ($user != false) {
            // user found
            // echo json with success = 1
            $response["success"] = 1;
            $response["user"]["fname"] = $user["firstname"];
            $response["user"]["lname"] = $user["lastname"];
            $response["user"]["email"] = $user["email"];
	    $response["user"]["uname"] = $user["username"];
            $response["user"]["uid"] = $user["unique_id"];
            $response["user"]["created_at"] = $user["created_at"];
            
            echo json_encode($response);
        } else {
            // user not found
            // echo json with error = 1
            $response["error"] = 1;
            $response["error_msg"] = "Incorrect email or password!";
            echo json_encode($response);
        }
    } 
  else if ($tag == 'chgpass'){
	$email = $_POST['email'];
	$newpassword = $_POST['newpas'];
  

		$hash = $db->hashSSHA($newpassword);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"];
		$subject = "Change Password Notification";
        $message = "Hello User,\n\nYour Password is sucessfully changed.\n\nRegards,\nLearn2Crack Team.";
        $from = "contact@learn2crack.com";
        $headers = "From:" . $from;
		if ($db->isUserExisted($email)) {
			$user = $db->forgotPassword($email, $encrypted_password, $salt);
			if ($user) {
				$response["success"] = 1;
				mail($email,$subject,$message,$headers);
				echo json_encode($response);
			}
			else {
				$response["error"] = 1;
				echo json_encode($response);
				}           
		}	 
		else {
			$response["error"] = 2;
			$response["error_msg"] = "User not exist";
			echo json_encode($response);

		}
}
else if ($tag == 'forpass'){
$forgotpassword = $_POST['forgotpassword'];

$randomcode = $db->random_string();
  

$hash = $db->hashSSHA($randomcode);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"];
  $subject = "Password Recovery";
         $message = "Hello User,\n\nYour Password is sucessfully changed. Your new Password is $randomcode . Login with your new Password and change it in the User Panel.\n\nRegards,\nLearn2Crack Team.";
          $from = "contact@learn2crack.com";
          $headers = "From:" . $from;
	if ($db->isUserExisted($forgotpassword)) {

 $user = $db->forgotPassword($forgotpassword, $encrypted_password, $salt);
if ($user) {
         $response["success"] = 1;
          mail($forgotpassword,$subject,$message,$headers);
         echo json_encode($response);
}
else {
$response["error"] = 1;
echo json_encode($response);
}


            // user is already existed - error response
           
           
        } 
           else {

            $response["error"] = 2;
            $response["error_msg"] = "User not exist";
             echo json_encode($response);

}

}
else if ($tag == 'register') {
        // Request type is Register new user
        $fname = $_POST['fname'];
		$lname = $_POST['lname'];
        $email = $_POST['email'];
		$uname = $_POST['uname'];
        $password = $_POST['password'];

          $subject = "Registration";
         $message = "Hello $fname,\n\nYou have sucessfully registered to our service.\n\nRegards,\nAdmin.";
          $from = "chanlysonghnt@gmail.com";
          $headers = "From:" . $from;

        // check if user is already existed
        if ($db->isUserExisted($email)) {
            // user is already existed - error response
            $response["error"] = 2;
            $response["error_msg"] = "User already existed";
            echo json_encode($response);
        } 
           else if(!$db->validEmail($email)){
            $response["error"] = 3;
            $response["error_msg"] = "Invalid Email Id";
            echo json_encode($response);             
		}
		else {
            // store user
            //$user = $db->storeUser($fname, $lname, $email, $uname, $password);
			$user = $db->storeUser($fname, $lname, $email, $uname, $password);
            if ($user) {
                // user stored successfully
            $response["success"] = 1;
            $response["user"]["fname"] = $user["firstname"];
            $response["user"]["lname"] = $user["lastname"];
            $response["user"]["email"] = $user["email"];
			$response["user"]["uname"] = $user["username"];
            $response["user"]["uid"] = $user["unique_id"];
            $response["user"]["created_at"] = $user["created_at"];
			
               mail($email,$subject,$message,$headers); //******** Gửi phản hồi về mail đã đăng ký ************
            
                echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "JSON Error occured in Registartion";
                echo json_encode($response);
            }
        }
    }
	else {
         $response["error"] = 3;
         $response["error_msg"] = "JSON ERROR";
        echo json_encode($response);
    }
	
}
?>