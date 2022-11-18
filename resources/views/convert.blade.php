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

<?php 
//convert types
$types = array(
	'png' => 'PNG',
	'jpg' => 'JPG',
	'gif' => 'GIF',
  'webp'=> 'WEBP'
);
?>

<form action="convert" method="post" enctype="multipart/form-data">
<input type="hidden" name="_token" value="{{csrf_token()}}">


<table>
  <tr>
    <th>Tên ảnh</th>
    <th>Hình ảnh</th>
    <th>Loại ảnh</th>
    <th>Convert Sang</th>
    <th>Thao Tác</th>
  </tr>
  <?php $dem = 0 ?>
  @foreach ($imgData as $item)
  <?php $dem++ ?>

<tr>
  <td>{{$item->image}}</td>
  <td><img src="source/image/{{$item->image}}" alt="" width="100px" height="100px"></td>
  <td>{{$item->extension}}</td>
  <td>
    <select id="select-{{$dem}}" name="typecanchuyen[]">
      <?php foreach($types as $key=>$type) {?>
          
          <option  value="<?=$key;?>"><?=$type;?></option>
          
      <?php } ?>
  </select>
  <input type="hidden" name="id_img[]" value="{{$item->id}}">
  <input type="hidden" name="name_img[]" value="{{$item->image}}">
  <input type="hidden" name="type_img[]" value="{{$item->extension}}">
  </td>
  <td><a href="delete/{{$item->id}}">Xóa</a></td>

</tr>
@endforeach
</table>
<input type="submit" value="Convert ảnh">
</form>

<div class="convert-multiple">
  <div class="text">
    <p>Chuyển đổi tất cả thành</p>
  </div>
  


  <select id="mySelect" onchange="myFunction()">
  
    <?php foreach($types as $key=>$type) {?>
      <option value="<?=$key;?>"><?=$type;?></option>
  <?php } ?>
  </select>
</div>





<div class="Upload">
  <form action="Upload" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{csrf_token('')}}">
    <label for="files">Chọn ảnh Khác:</label>
    <input type="file" id="files" name="files[]" multiple>
    <input type="submit" value="tải ảnh lên">
  </form>
  
</div>

</body>
</html>


<script>
  function myFunction() {
    var x = document.getElementById("mySelect").value;
    var dem = document.getElementsByTagName("select").length;
    for(var i = 1 ; i < dem ; i++)
    {
      document.getElementById('select-'+ i).value = x; 
    }
  }
</script>


<style>
  .Upload{
    width: 700px;
    margin-top: -50px;
    margin-left: 900px;

  }
  .convert-multiple{
    width: 500px;
    margin-left: 350px;
    /* display: flex; */
    margin-top: -35px;
   
  }
</style>

 



