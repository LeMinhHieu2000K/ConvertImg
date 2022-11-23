<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="Upload" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{csrf_token('')}}">
        <label for="files">Chọn ảnh:</label>
        <input type="file" id="files" name="files[]" multiple><br><br>
        <input type="submit">
      </form>

      <br>
      <br>

      <div class="dropdown">
        <button class="dropbtn">Dropdown</button>
        <div class="dropdown-content">
        @if(!empty($ImgClient))
        @foreach($ImgClient as $item)
          <a href="">
            <p>{{$item->name}}</p>
            <img src="{{$item->link}}" alt="" width="100px" >
            <p>{{$item->size}}</p>
          </a>
        @endforeach
        @endif
        </div>
      </div>

      <style>
        /* Dropdown Button */
.dropbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #ddd;}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {display: block;}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {background-color: #3e8e41;}
      </style>
      <br>

      <a href="logout">Đăng xuất</a>
    
</body>
</html>