<?php

namespace App\Http\Controllers;

use App\Img;
use App\ImgAfter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use ZipArchive;

class ImgController extends Controller
{
    public function getUploadImg()
    {
        return view('Upload');
    }

    public function postUploadImg(Request $request)
    {
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $size = $file->getSize();
                // cho vào file 
                $file->move('source/image', $filename);
                // khởi tạo đối tượng ảnh
                $imgData = new Img();
                $imgData->image = $filename;
                $imgData->extension = $extension;
                $imgData->size = $size;
                $imgData->formatSize = $this->formatSizeUnits($size);

                $imgData->save();
            }
            return redirect('ImageData');
        } else {
            echo "ko co file";
        }
    }

    public function getImageData()
    {
        $imgData = Img::all();

        return view('convert', ['imgData' => $imgData]);
    }

    public function deleteImg(Request $request, $id)
    {
        $target_dir = 'source/image/';
        $name_img = Img::where('id', $id)->first();
        unlink($target_dir . $name_img->image);
        $delete_Img = Img::where('id', $id)->delete();
        return back();
    }

    public function convertImageData(Request $request, $image_quality = 100)
    {
        $typeTarget = $request->typecanchuyen; // kiểu cần chuyển
        $nameImg = $request->name_img; // tên ban đầu
        $typeOriginal = $request->type_img; // kiểu ban đầu
        $count = 0;
        $idImg = $request->id_img; 
        foreach ($idImg as $id) {
            $count++;
        }

        for ($i = 0; $i < $count; $i++) // lap ten ban dau
        {

            $nameImg[$i];
            $typeOriginal[$i];

            $typeTarget[$i];


            $dir = 'source/image/'; // đường dẫn ban đầu

            $target_dir = "source/convert/"; // đường dẫn lưu trữ ảnh đã convert

            $image = $dir . $nameImg[$i]; // tạo ảnh

            $only_name = basename($image, '.' . $typeOriginal[$i]);

            if ($typeTarget[$i] == 'gif') {
                $binary = imagecreatefromstring(file_get_contents($image));
                imageGif($binary, $target_dir . $only_name . '.' . $typeTarget[$i], $image_quality);
                $ten_moi = $only_name . '.' . $typeTarget[$i];
            }

            if ($typeTarget[$i] == 'webp') {
                $binary = imagecreatefromstring(file_get_contents($image));
                imagewebp($binary, $target_dir . $only_name . '.' . $typeTarget[$i], $image_quality);
                $ten_moi = $only_name . '.' . $typeTarget[$i];

                ob_start(); //Tạo một bộ đệm đầu ra mới và thêm nó vào đầu ngăn xếp.
                imagewebp($binary, NULL, 100);
                $cont = ob_get_contents(); //  Trả về nội dung của bộ đệm đầu ra trên cùng.
                ob_end_clean(); // - Trả về tất cả nội dung của bộ đệm đầu ra trên cùng & xóa nội dung khỏi bộ đệm.
                imagedestroy($binary);
                $content = imagecreatefromstring($cont);
                $output = $target_dir . $ten_moi;
                imagewebp($content, $output);
                imagedestroy($content);
            }
            if ($typeTarget[$i] == 'png') {
                $binary = imagecreatefromstring(file_get_contents($image));
                $ten_moi = $only_name . '.' . $typeTarget[$i];

                ob_start();
                imagepng($binary, NULL, 100);
                $cont = ob_get_contents();
                ob_end_clean();
                imagedestroy($binary);
                $content = imagecreatefromstring($cont);
                $output = $target_dir . $ten_moi;
                imagepng($content, $output);
                imagedestroy($content);
            }

            if ($typeTarget[$i] == 'jpg') {
                $binary = imagecreatefromstring(file_get_contents($image));
                imagejpeg($binary, $target_dir . $only_name . '.' . $typeTarget[$i], $image_quality);
                $ten_moi = $only_name . '.' . $typeTarget[$i];
            }
        }

        $file_names = glob("source/convert/*");
        $ImgData = Img::all();
        $dem = 0 ;
        foreach($file_names as $item)
        {
            $dem++;
        }
        for($j = 0 ; $j < $dem ; $j++)
        {
            
            $newName = basename($file_names[$j]); // tên mới 
            $link = $file_names[$j];
            $size = filesize($file_names[$j]); // size mới
            $id_img = $ImgData[$j]->id;
            $sizeBefore =  $ImgData[$j]->size;// size cũ
            $decleare = round(100 - (($size/$sizeBefore)*100));

            $ImgAfter = new ImgAfter();
            $ImgAfter->id_img = $id_img;
            $ImgAfter->name = $newName;
            $ImgAfter->link = $link;
            $ImgAfter->formatSizeBefore = $this->formatSizeUnits($sizeBefore);
            $ImgAfter->formatSizeAfter = $this->formatSizeUnits($size);
            $ImgAfter->decleare = $decleare;
            $ImgAfter->save();
            

        }
        $ImgAfter = ImgAfter::all();

        // XÓA DỮ LIỆU BẢNG img
        $idImg = $request->id_img; // id ảnh
        foreach ($idImg as $id) {
            $delete_Img = Img::where('id', $id)->delete();
            $delete_ImgAfter = ImgAfter::where('id_img' ,$id)->delete();
        }
       





        return view('download',['ImgAfter'=> $ImgAfter]);
    }

    public function download_img(Request $request)
    {

        $dem  = 0;
        $file_names = glob("source/convert/*");
        foreach ($file_names as $file) {
            $dem++;
        }

        if ($dem == 1) {
            $file_names = glob("source/convert/*");
            $file_namess = glob("source/image/*");
            foreach ($file_names as $file) {

                header('Content-Type: application/octet-stream');
                header("Content-Transfer-Encoding: Binary");
                header("Content-disposition: attachment; filename=\"" . basename($file) . "\"");
                readfile($file);
            }
            foreach ($file_names as $file) {
                unlink($file);
            }
            foreach ($file_namess as $file) {
                unlink($file);
            }
            $status = unlink('D:\xampp\htdocs\project\ConvertMultipleImg\public\file.zip');
            if ($status) {
                echo "File bị xóa thành công!";
            } else {
                echo "Error: File không bị xóa.";
            }
        } elseif ($dem >= 2) {

            $archive_file_name = 'file.zip';
            $file_names = glob("source/convert/*");
            $file_namess = glob("source/image/*");
            $file_path =  'source/convert/';
            $zip = new ZipArchive();
            $zip->open($archive_file_name, ZipArchive::CREATE);
            foreach ($file_names as $file) {
                $zip->addFile($file_path . basename($file));
            }
            $zip->close();

            header("Content-type: application/zip");
            header("Content-Disposition: attachment; filename=$archive_file_name");
            header("Content-length: " . filesize($archive_file_name));
            header("Pragma: no-cache");
            header("Expires: 0");
            readfile("$archive_file_name");


            foreach ($file_names as $file) {
                unlink($file);
            }
            foreach ($file_namess as $file) {
                unlink($file);
            }
            $status = unlink('D:\xampp\htdocs\project\ConvertMultipleImg\public\file.zip');
            if ($status) {
                echo "File bị xóa thành công!";
            } else {
                echo "Error: File không bị xóa.";
            }
        }
        // return redirect('Upload');
    }



    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}
