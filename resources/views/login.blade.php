<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
   
    @if(Session::has('thongbao'))
    <p>{{Session::get('thongbao')}}</p>
    @endif
    <form action="login" method="POST" id="contact-form">
        @csrf
        <label>email:</label><br>
        <input type="text" name="email" id="email" ><br>
        <label>password:</label><br>
        <input type="password" name="password" id="password"><br>
        <input type="submit" value="Đăng Nhập">
    </form> 
    
   
    
</body>
</html>