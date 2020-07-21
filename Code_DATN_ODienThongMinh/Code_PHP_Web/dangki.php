<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Đăng kí</title>
        <link rel="stylesheet" type="text/css" href="mystyle.css" />
</head>
<body >
    <h2 class = "tieude_dangki">Vui lòng nhập đầy đủ các thông tin của bạn để đăng kí</h2>
    <br>
    <form class ="formdangki" method="post" action="dangki.php">  
        Tên Tài Khoản:<input class ="tentaikhoan" type="text" name="tenTaiKhoan" value="">
        <br><br>
        Mật Khẩu: <input class ="matkhau" type="text" name="matKhau" value="">
        <br><br>
        Họ Tên: <input class ="hoten" type="text" name="hoTen" value="">
        <br><br>
        Ngày Tháng Năm Sinh : <input class ="ngaysinh" type="date" name="ngaySinh">
        <br><br>
        Địa Chỉ: <input class ="diachi" type="text" name="diaChi" value="">
        <br><br>
        Số điện thoại: <input class ="sodienthoai" type="text" name="soDienThoai" value="">
        <br><br>
        Giới Tính:
        <input class ="gioitinh" type="radio" name="gioiTinh"  value="Nam">Nam
        <input class ="gioitinh" type="radio" name="gioiTinh"  value="Nữ">Nữ
        <br><br>
        <input style ="width: 160px;height: 40px;margin-left: 250px;" type="submit" name="submit" value="Gửi thông tin đăng kí">  
    </form>
    <?php
        if (isset($_POST['tenTaiKhoan']) && $_POST['tenTaiKhoan'] != '' && isset($_POST['matKhau']) && $_POST['matKhau'] != ''
                && isset($_POST['hoTen']) && $_POST['hoTen'] != '' && isset($_POST['ngaySinh']) && $_POST['ngaySinh'] != ''
                && isset($_POST['diaChi']) && $_POST['diaChi'] != '' && isset($_POST['soDienThoai']) && $_POST['soDienThoai'] != ''
                && isset($_POST['gioiTinh']) && $_POST['gioiTinh'] != '') 
        {
            $tenTaiKhoan = $_POST['tenTaiKhoan'];
            $matKhau = $_POST['matKhau'];
            $hoTen = $_POST['hoTen'];
            $ngaySinh = $_POST['ngaySinh'];
            $diaChi = $_POST['diaChi'];
            $soDienThoai = $_POST['soDienThoai'];
            $gioiTinh = $_POST['gioiTinh'];
			
			require_once 'learn2crack_login_api/include/config.php';
			$host = DB_HOST; // change this as required
			$username = DB_USER; // change this as required
			$password = DB_PASSWORD; // change this as required
			$db = DB_DATABASE	; // your DB    
			
            $DBConnect=mysql_connect($host, $username, $password) or die("Could Not Connect");
            mysql_select_db( $db) or die(mysql_error()); 
            mysql_set_charset('utf8',$DBConnect); 
            
            $kt = mysql_query("SELECT * FROM thongtinnguoidung WHERE tentaikhoan = '$tenTaiKhoan'") or die(mysql_error());
            $dem = mysql_num_rows($kt);
            if($dem > 0 ){
                echo "<p>Đăng kí không thành công, tên đăng nhập đã được sử dụng</p>";
            }else{
                if($result = mysql_query("INSERT INTO thongtinnguoidung (tentaikhoan, matkhau,  tennguoidung,ngaysinh,diachi,sodienthoai,gioitinh,thoigiantao) 
					VALUES ('$tenTaiKhoan', '$matKhau', '$hoTen','$ngaySinh','$diaChi','$soDienThoai','$gioiTinh',NOW())"))
				{	
					mysql_query("CREATE TABLE $tenTaiKhoan (
						  `id` smallint(10) NOT NULL AUTO_INCREMENT,
						  `ocam1` varchar(10) COLLATE latin1_general_ci NOT NULL,
						  `ocam2` varchar(10) COLLATE latin1_general_ci NOT NULL,
						  `ocam3` varchar(10) COLLATE latin1_general_ci NOT NULL,
						  `thoigiantao` varchar(20) COLLATE latin1_general_ci NOT NULL,
						  `pin` varchar(10) COLLATE latin1_general_ci NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ") or die(mysql_error());
					
				
					echo "<p>Đăng kí thành công</p>";
					echo "<br>";
					echo "<p>Trở lại trang chủ trong chốc lát, xin hãy đợi hệ thống xử lý</p>";
					echo "<p id=\"demo\"></p>";
					echo "<script>";
					echo "var dem = 0;";
					echo "var myVar = setInterval(myTimer, 3000);";
					echo "function myTimer() {";
						echo "dem+=1;";
						echo "if(dem>0){";
						echo "window.location.href = 'index.php';";
						echo "}";
					echo "}";
					echo " </script>";
				}else echo "<p>Đăng kí không thành công, không biết lỗi</p>";
            }
        }else{
            if (isset($_POST['submit']) && $_POST['submit'] != ''){
                echo "<h3 class = \"error_regis\">Vui Lòng Điền Đầy Đủ Thông Tin<h3>";
            }   
        }  
    ?>
</body>
</html>