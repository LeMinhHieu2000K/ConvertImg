<?php 
 $date = getdate(); 
$ngay = $date['mday'].$date['mon'].$date['year'].$date['hours'].$date['minutes'].$date['seconds'];
$archive_file_name = $ngay.'.zip';
$path = realpath("'D:\xampp\htdocs\project\ConvertMultipleImg\public' .'\'.$archive_file_name");
echo $path ?>