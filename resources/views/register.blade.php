<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <form action="register" method="POST"  id="contact-form">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <label>name:</label><br>
        <input type="text" name="name" id="name"><br>
        <label>email:</label><br>
        <input type="text" name="email" id="email" ><br>
        <label>password:</label><br>
        <input id="password" type="password"  name="password" required autocomplete="current-password"><br>
        <label>nhập lại password:</label><br>
        <input id="password" type="password"  name="password_confirmation" required autocomplete="current-password"><br>
        <br>
        <label>phone:</label><br>
        <input type="text" name="phone" id="phone" ><br>
        <label>Role:</label>
        <label>
            <input name="role" value="User" checked="" type="radio">User
        </label>
        <label>
            <input name="role" value="Admin" type="radio">Admin
        </label>
        <br>
        <input type="submit" value="Đăng Ký">
    </form>
</body>
</html>
