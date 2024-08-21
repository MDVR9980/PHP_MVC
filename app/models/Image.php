<?php

/**
 * Image manipulation class
 */
namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

class Image {
	
	
	public function resize($filename,$max_size = 700) {
	
		/** check what kind of file type it is **/
		$type = mime_content_type($filename);

		if(file_exists($filename)) {
			switch ($type) {

				case 'image/png':
					$image = imagecreatefrompng($filename);
					break;

				case 'image/gif':
					$image = imagecreatefromgif($filename);
					break;
				
				case 'image/jpeg':
					$image = imagecreatefromjpeg($filename);
					break;
				
				case 'image/webp':
					$image = imagecreatefromwebp($filename);
					break;
				
				default:
					return $filename;
			}

			$src_w = imagesx($image);
			$src_h = imagesy($image);

		    if($src_w > $src_h) {
		      //reduce max size if image is smaller
		      if($src_w < $max_size) {
		        $max_size = $src_w;
		      }

		      $dst_w = $max_size;
		      $dst_h = ($src_h / $src_w) * $max_size;
		    }else {

		      //reduce max size if image is smaller
		      if($src_h < $max_size) {
		        $max_size = $src_h;
		      }

		      $dst_w = ($src_w / $src_h) * $max_size;
		      $dst_h = $max_size;
		    }

		    $dst_w = round($dst_w); 
		    $dst_h = round($dst_h);
		    
			$dst_image = imagecreatetruecolor($dst_w, $dst_h);

			if($type == 'image/png') {

				imagealphablending($dst_image, false);
				imagesavealpha($dst_image, true );
			}

			imagecopyresampled($dst_image, $image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

			imagedestroy($image);

			switch ($type) {

				case 'image/png':
					imagepng($dst_image,$filename,8);
					break;

				case 'image/gif':
					imagegif($dst_image,$filename);
					break;
				
				case 'image/jpeg':
					imagejpeg($dst_image,$filename,90);
					break;
				
				case 'image/webp':
					imagewebp($dst_image,$filename,90);
					break;
				
				default:
					imagejpeg($dst_image,$filename,90);
					break;
			}

			imagedestroy($dst_image);
		}

		return $filename;
	}

	public function crop($filename,$max_width = 700,$max_height = 700) {
	
		/** check what kind of file type it is **/
		$type = mime_content_type($filename);

		if(file_exists($filename)) {
			$imagefunc = 'imagecreatefromjpeg';

			switch ($type) {

				case 'image/png':
					$image = imagecreatefrompng($filename);
					$imagefunc = 'imagecreatefrompng';
					break;

				case 'image/gif':
					$image = imagecreatefromgif($filename);
					$imagefunc = 'imagecreatefromgif';
					break;
				
				case 'image/jpeg':
					$image = imagecreatefromjpeg($filename);
					$imagefunc = 'imagecreatefromjpeg';
					break;
				
				case 'image/webp':
					$image = imagecreatefromwebp($filename);
					$imagefunc = 'imagecreatefromwebp';
					break;
				
				default:
					return $filename;
			}

			$src_w = imagesx($image);
			$src_h = imagesy($image);

			if($max_width > $max_height) {
				if($src_w > $src_h) {
					$max = $max_width;
				}else {
					$max = ($src_h / $src_w) * $max_width;
				}
			}else {
				if($src_w > $src_h) {
					$max = ($src_w / $src_h) * $max_height;
				}else {
					$max = $max_height;
				}
			}

			$this->resize($filename,$max);
 
			$image = $imagefunc($filename);

			$src_w = imagesx($image);
			$src_h = imagesy($image);

			$src_x = 0;
			$src_y = 0;
 			if($max_width > $max_height) {
				$src_y = round(($src_h - $max_height) / 2);
			}else {
				$src_x = round(($src_w - $max_width) / 2);
			}

			$dst_image = imagecreatetruecolor($max_width, $max_height);

			if($type == 'image/png') {
				imagealphablending($dst_image, false);
				imagesavealpha($dst_image, true );
			}

			imagecopyresampled($dst_image, $image, 0, 0, $src_x, $src_y, $max_width, $max_height, $max_width, $max_height);
			imagedestroy($image);

			switch ($type) {

				case 'image/png':
					imagepng($dst_image,$filename,8);
					break;

				case 'image/gif':
					imagegif($dst_image,$filename);
					break;
				
				case 'image/jpeg':
					imagejpeg($dst_image,$filename,90);
					break;
				
				case 'image/webp':
					imagewebp($dst_image,$filename,90);
					break;
				
				default:
					imagejpeg($dst_image,$filename,90);
					break;
			}

			imagedestroy($dst_image);
		}

		return $filename;
	}


	public function getThumbnail($filename, $max_width = 700, $max_height = 700) {

		if(file_exists($filename)) {
			$ext = explode(".", $filename);
			$ext = end($ext);

			$dest = preg_replace("/\.{$ext}$/", '_thumbnail.'.$ext, $filename);

			if(file_exists($dest)) {
				return $dest;
			}
			
			copy($filename, $dest);
			$this->crop($dest,$max_width,$max_height);

			$filename = $dest;
		}

		return $filename;
	}
}