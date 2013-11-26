<?php
class Controller_Captcha extends Core_Controller
{
	//creates captcha image from stored in the session captcha string, made by Core_Captcha class 
	public function actionCreate()
	{
		$im = imagecreatetruecolor(130, 50);//create black image 
		$str = $this->getCaptchaString();//get captcha string stored in the session
		$gray = imagecolorallocate($im,159, 152,160);
		$black = imagecolorallocate($im, 0x00, 0x00, 0x00);
		$fontFile =BASEPATH.'\fonts\comic.ttf';
		imagefilledrectangle($im, 0, 0, 130, 50, $gray);
		$this->drawRandomLines($im,$black,5);//draw some noise lines beneath the letters
		$this->drawLetters($im,$str,$black,$fontFile);//draw captcha string
		$this->drawRandomLines($im,$black,5);//draw some noise lines above the letters
		header('Content-Type: image/png');
		imagepng($im);
		imagedestroy($im); 
	}

	private function drawRandomLines($im,$black,$num)
	{
		for($i=0;$i<$num;$i++){
			imageline($im,mt_rand(0,120),mt_rand(0,50),mt_rand(0,120),mt_rand(0,50),$black);
		}
	}
	
	private function drawLetters($im,$str,$color,$font)
	{
		$space = 0;
		$str = str_split($str);//split captcha string on different letters 
		foreach($str as $letter){
			$start = 5; //start point of text
			$space += 14; //space between letters
			$letter = (mt_rand(0,1)) ? $letter : mb_strtoupper($letter);//convert letter to random case
			imagefttext($im, 18, mt_rand(-15,15), $start + $space, 30, $color, $font, $letter);
		}
	}

	private function getCaptchaString()
	{
		return (isset($_SESSION['captcha']) ? $_SESSION['captcha'] : false);
	}
}