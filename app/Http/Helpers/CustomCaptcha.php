<?php 
namespace App\Http\Helpers;

use DB,Log;
use Illuminate\Support\Facades\Session;

class CustomCaptcha {

    public static function generateRandomAdditionExpression() {
        $image_width = 300;
        $image_height = 50;
        $characters_on_image = 4; //Number of characters to display on the captcha image
        $font = 'assets/ttff/monofont.ttf';
        
        //The characters that can be used in the CAPTCHA code. Avoid confusing characters (l 1 and i for example)
        $possible_letters = 'abcdfghjkmnpqrstvwxyz123456789ABC';
        $random_dots = 0;
        $random_lines = 20;
        $captcha_text_color="884ffb";    //Text color
        $captcha_noice_color = "7fbf4d"; //Text color
        
        $code = '';
        $i = 0;
        while ($i < $characters_on_image) 
        { 
            $code .= substr($possible_letters, mt_rand(0, strlen($possible_letters)-1), 1);
            $i++;
        }
        $font_size = $image_height * 0.75;
        $image = @imagecreate($image_width, $image_height);
        
        
        /*Setting the background, text and noise colours here */
        $background_color = imagecolorallocate($image, 255, 255, 255);
        $int = hexdec($captcha_text_color);
        $arr_text_color = array("red" => 0xFF & ($int >> 0x10),"green" => 0xFF & ($int >> 0x8),"blue" => 0xFF & $int);
        $text_color = imagecolorallocate($image, $arr_text_color['red'], 
        $arr_text_color['green'], $arr_text_color['blue']);
        $int1 = hexdec($captcha_text_color);
        $arr_noice_color = array("red" => 0xFF & ($int1 >> 0x10),"green" => 0xFF & ($int1 >> 0x8),"blue" => 0xFF & $int1);
        $image_noise_color = imagecolorallocate($image, $arr_noice_color['red'], 
        $arr_noice_color['green'], $arr_noice_color['blue']);
        
        /*This generates the dots randomly strings in background */
        for( $i=0; $i<$random_dots; $i++ ) 
        {
            imagefilledellipse($image, mt_rand(0,$image_width),
             mt_rand(0,$image_height), 2, 3, $image_noise_color);
        }
        
        /*This generates lines randomly strings in background of image */
        for( $i=0; $i<$random_lines; $i++ ) 
        {
            imageline($image, mt_rand(0,$image_width), mt_rand(0,$image_height),
             mt_rand(0,$image_width), mt_rand(0,$image_height), $image_noise_color);
        }
        
        /*This creates a text box and add 6 letters code in it */
        $textbox = imagettfbbox($font_size, 0, $font, $code); 
        $x = ($image_width - $textbox[4])/2;
        $y = ($image_height - $textbox[5])/2;
        imagettftext($image, $font_size, 0, $x, $y, $text_color, $font , $code);
        /* Show captcha image in the page html page */
        header('Content-Type: image/jpeg');// defining the image type to be shown in browser widow
        imagejpeg($image);//showing the image
        imagedestroy($image);//destroying the image instance
        //$_SESSION['captcha_code'] = $code;
        Session::put('captcha_code', $code);
    }


    public function phpcaptcha($textColor,$backgroundColor,$imgWidth,$imgHeight,$noiceLines=0,$noiceDots=0,$noiceColor='#162453')
        {       
                /* Settings */
                $text=rand(6,999999);
                $font = 'assets/ttff/monofont.ttf';/* font */
                $textColor=$this->hexToRGB($textColor);      
                $fontSize = $imgHeight * 0.75;
                
                $im = imagecreatetruecolor($imgWidth, $imgHeight);      
                $textColor = imagecolorallocate($im, $textColor['r'],$textColor['g'],$textColor['b']);                  
                
                $backgroundColor = $this->hexToRGB($backgroundColor);
                $backgroundColor = imagecolorallocate($im, $backgroundColor['r'],$backgroundColor['g'],$backgroundColor['b']);
                                
                /* generating lines randomly in background of image */
                if($noiceLines>0){
                $noiceColor=$this->hexToRGB($noiceColor);    
                $noiceColor = imagecolorallocate($im, $noiceColor['r'],$noiceColor['g'],$noiceColor['b']);
                for( $i=0; $i<$noiceLines; $i++ ) {                          
                        imageline($im, mt_rand(0,$imgWidth), mt_rand(0,$imgHeight),
                        mt_rand(0,$imgWidth), mt_rand(0,$imgHeight), $noiceColor);
                }}                              
                                
                if($noiceDots>0){/* generating the dots randomly in background */
                for( $i=0; $i<$noiceDots; $i++ ) {
                        imagefilledellipse($im, mt_rand(0,$imgWidth),
                        mt_rand(0,$imgHeight), 3, 3, $textColor);
                }}              
                
                imagefill($im,0,0,$backgroundColor);    
                list($x, $y) = $this->ImageTTFCenter($im, $text, $font, $fontSize);  
                imagettftext($im, $fontSize, 0, $x, $y, $textColor, $font, $text);              
                header('Content-Type: image/jpeg');/* defining the image type to be shown in browser widow */
                imagejpeg($im);/* Showing image */
                imagedestroy($im);/* Destroying image instance */
                Session::put('captcha_code', $text);
               //if(isset($_SESSION)){
                   // $_SESSION['captcha_code'] = $text;/* set random text in session for captcha validation*/
               // }
        }
        
        /*function to convert hex value to rgb array*/
        protected function hexToRGB($colour)
        {
        if ( $colour[0] == '#' ) {
                        $colour = substr( $colour, 1 );
        }
        if ( strlen( $colour ) == 6 ) {
                        list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
        } elseif ( strlen( $colour ) == 3 ) {
                        list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
        } else {
                        return false;
        }
        $r = hexdec( $r );
        $g = hexdec( $g );
        $b = hexdec( $b );
        return array( 'r' => $r, 'g' => $g, 'b' => $b );
        }
                
                
        /*function to get center position on image*/
        protected function ImageTTFCenter($image, $text, $font, $size, $angle = 8) 
        {
                $xi = imagesx($image);
                $yi = imagesy($image);
                $box = imagettfbbox($size, $angle, $font, $text);
                $xr = abs(max($box[2], $box[4]))+5;
                $yr = abs(max($box[5], $box[7]));
                $x = intval(($xi - $xr) / 2);
                $y = intval(($yi + $yr) / 2);
                return array($x, $y);   
        }
}