<?php

/**
 * Created by Eduardo R. Zaragoza Jr.
 * Date: 9/2/2021
 */

namespace common\models;

use Yii;

class CreateCertificate
{
    public $name;
    public $image;
    public $imageName;
    public $x_axis;
    public $y_axis;
    public $font_size;
    public $imagelocation;
    public $fontlocation;
    public function create()
    {
        header('Content-type: image/jpeg');
        $name = $this->name;
        $font = realpath($this->fontlocation .'arial.ttf');
        $image = imagecreatefromjpeg($this->imagelocation . $this->image);
        $color = imagecolorallocate($image, 51, 51, 102);
        //$date=date('d F, Y');
        //imagettftext($image, 18, 0, 880, 188, $color,$font, $date);
       
        $image_width = imagesx($image); 
        $text_box = imagettfbbox($this->font_size,0,$font,$name);

        // Get your Text Width and Height
        $text_width = $text_box[2]-$text_box[0];
        $x = ($image_width/2) - ($text_width/2);

        $imageName = $this->imageName;
        imagettftext($image, $this->font_size, 0, $x, $this->y_axis, $color, $font, $name);
        imagejpeg($image, "attachment/".$imageName.".jpg");
        //imagejpeg($image);
        imagedestroy($image);
    }
    public function preview()
    {
        header('Content-type: image/jpeg');
        $name = $this->name;
        $font = realpath($this->fontlocation .'arial.ttf');
        $image = imagecreatefromjpeg($this->imagelocation . $this->image);
        $color = imagecolorallocate($image, 51, 51, 102);

        $image_width = imagesx($image); 
        $text_box = imagettfbbox($this->font_size,0,$font,$name);

        // Get your Text Width and Height
        $text_width = $text_box[2]-$text_box[0];
        $x = ($image_width/2) - ($text_width/2);
        //$date=date('d F, Y');
        //imagettftext($image, 18, 0, 880, 188, $color,$font, $date);
        
        //$imageName = $this->imageName;
        imagettftext($image, $this->font_size, 0, $x, $this->y_axis, $color, $font, $name);
        //imagejpeg($image, "attachment/".$imageName.".jpg");
        imagejpeg($image);
        imagedestroy($image);
    }
}
