<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>HTML Table</h2>

<table>
  <tr>
    <th>Tên ảnh</th>
    <th>Hình ảnh</th>
    <th>Dung lượng trước chuyển đổi</th>
    <th>Dung lượng sau chuyển đổi</th>
    <th>Giảm</th>
  </tr>
@foreach($ImgAfter as $item)
  <tr>
    <td>{{$item->name}}</td>
    <td><img src="{{$item->link}}" alt="" width="100px" ></td>
    <td>{{$item->formatSizeBefore}}</td>
    <td>{{$item->formatSizeAfter}}</td>
    <td>{{$item->decleare}}%</td>
  </tr>
  @endforeach

</table>

<a id = "text" href="taixuong" onclick="an()">ấn vào đây để tải ảnh</a>
    
    
    
    <a href="Upload">ấn vào đây để tiếp tục convert ảnh</a>


    <script>
        function an(){
            link = document.getElementById("text");
            link.classList.add("hidden");
        }

    </script>

    <style>
        .hidden{
            display: none;
        }
    </style>
   



  
</div>

</body>
</html>


 



