<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">		
        <title>Đồ án tốt nghiệp</title>
		<link href="mystyle.css" rel = "stylesheet" type = "text/css" />
		
        <link rel="shortcut icon" href="anh2/aaa.ico"/>
        
		
    </head>
    <body >
        <!-- header -->
        <div class = "tab" >
		<img src="anh2/banner.jpg" style="image-align:center" >
            <marquee> <h1  style="text-align:center">Đồ án tốt nghiệp 2016 - Ổ cắm điện thông minh</h1> </marquee>
            <div class="nutdangnhap">Đăng Nhập
            <form action="index.php" method="post">      
                <input type ="text" name ="tendangnhap" value="User Name"/> 
                <input type ="password" name ="matkhau" value="Password"/>
                <input type ="submit" value ="Đăng Nhập"/>
            </form>
            </div>
            <ul>
                <li><a href ="#" >Trang Chủ</a>
                <li><a href ="dangki.php" >Đăng kí</a>
                <li><a href ="#" >Hỗ trợ khách hàng</a>
                <li><a href ="#" >Sản phẩm</a>
                <li><a href ="#" >Giới thiệu</a>
            </ul>
        </div>
        <!-- body -->
        <div class="slide" style="max-width:500px">
            <img class="mySlides" src="anh2/1.jpg" style="width:800px ;height:450px; margin-left: 10px">
            <img class="mySlides" src="anh2/2.jpg" style="width:800px ;height:450px; margin-left: 10px">
            <img class="mySlides" src="anh2/3.jpg" style="width:800px ;height:450px; margin-left: 10px">
            <img class="mySlides" src="anh2/4.jpg" style="width:800px ;height:450px; margin-left: 10px">
            <img class="mySlides" src="anh2/5.jpg" style="width:800px ;height:450px; margin-left: 10px">
			<img class="mySlides" src="anh2/6.jpg" style="width:800px ;height:450px; margin-left: 10px">
			<img class="mySlides" src="anh2/7.jpg" style="width:800px ;height:450px; margin-left: 10px">
			<img class="mySlides" src="anh2/8.jpg" style="width:800px ;height:450px; margin-left: 10px">
        </div>
        <div class="noidung">
            <h3>Giải pháp quản lý thiết bị điện thông minh<br><br><br></h3>
            <h4>
                Đem đến sự tiện lợi cho khách hàng<br>
                Liên tục theo dõi, giám sát thiết bị <br>
                Điều khiển các thiết bị điện từ xa tiện lợi <br>
				Quản lý tiêu hao của thiết bị qua hệ thống đo công suất<br>
				Tự động nhận dạng thiết bị bằng hệ thống NFC <br>
				
																	
                
            </h4>
        </div>
        <script>
            var myIndex = 0;
            carousel();
            function carousel() {
            var i;
            var x = document.getElementsByClassName("mySlides");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";  
            }
            myIndex++;
            if (myIndex > x.length) {myIndex = 1}    
               x[myIndex-1].style.display = "block";  
            setTimeout(carousel, 3000); // Change image every 2 seconds
            }
        </script>
        
    </body>
</html>
