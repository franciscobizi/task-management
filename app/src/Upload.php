<?php

namespace FB\src;

/**
* Upload class for working files 
*
* PHP Version 7+
*
* Methods : getExtention, ehImagem, resizing, save
* @author Francisco Bizi <taylorsoft28@gmail.com> 
* 
*/
class Upload
{
	private $file;
	private $height;
	private $width;
	private $folder;

	/**
	*   
	*  Constructor that set parametrs
	*  
	* @param string $file
	* @param string $height
	* @param string $width
	* @param string $folder
	*/
	function __construct($file, $height, $width, $folder)
	{
		$this->file    = $file;
		$this->height  = $height;
		$this->width   = $width;
		$this->folder  = $folder;
	}
		
	/**
	*   
	* Method that get the file extention
	*
	* @return string $extension
	*/
	private function getExtention()
	{
		$nome = strtolower($this->file['name']);
		$extention = explode('.', $nome);
		return $extention[1];
	}
	
	/**
	*   
	*  Methot that verify the pattern of file extension
	* 
	* @param string $extention
	* @param bool $folder
	*/	
	private function ehImagem($extention) : bool
	{
		$extensoes = array('gif', 'jpg', 'png');
		if (in_array($extention, $extensoes)){
		 	return true;
		}else{
			return false;
		}	
	}
		
	/**
	*   
	*  Method that resize file
	*  
	* @param string imgLarg
	* @param string $imgAlt
	* @param string $tipo
	* @param string $img_localization
	*/
	private function resizing($imgLarg, $imgAlt, $tipo, $img_localization)
	{
		if ( $imgLarg > $imgAlt ){
			$novaLarg = $this->width;
			$novaAlt = round( ($novaLarg / $imgLarg) * $imgAlt );
		}
		elseif ( $imgAlt > $imgLarg ){
			$novaAlt = $this->height;
			$novaLarg = round( ($novaAlt / $imgAlt) * $imgLarg );
		}
		else 
			$novaheight = $novawidth = max($this->width, $this->height);
					
		$neImage = imagecreatetruecolor($novaLarg, $novaAlt);
				
		switch ($tipo){
			case 1:	// gif
				$origem = imagecreatefromgif($img_localization);
				imagecopyresampled($neImage, $origem, 0, 0, 0, 0,
				$novaLarg, $novaAlt, $imgLarg, $imgAlt);
				imagegif($neImage, $img_localization);
				break;
			case 2:	// jpg
				$origem = imagecreatefromjpeg($img_localization);
				imagecopyresampled($neImage, $origem, 0, 0, 0, 0,
				$novaLarg, $novaAlt, $imgLarg, $imgAlt);
				imagejpeg($neImage, $img_localization);
				break;
			case 3:	// png
				$origem = imagecreatefrompng($img_localization);
				imagecopyresampled($neImage, $origem, 0, 0, 0, 0,
				$novaLarg, $novaAlt, $imgLarg, $imgAlt);
				imagepng($neImage, $img_localization);
				break;
		}
		
		imagedestroy($neImage);
		imagedestroy($origem);
	}
	
	/**
	*   
	* Method that save the file
	*
	* @return string $destination
	*/	
	public function save()
	{									
		$extention = $this->getExtention();
		$new_name = time() . '.' . $extention;
		$destination = $this->folder . $new_name;

		if (! move_uploaded_file($this->file['tmp_name'], $destination)){
			if ($this->file['error'] == 1)
				return "BIG";
			else
				return "Erro " . $this->file['error'];
			}
				
		if ($this->ehImagem($extention)){
			list($width, $height, $tipo, $atributo) = getimagesize($destination);
			if(($width > $this->width) || ($height > $this->height))
				$this->resizing($width, $height, $tipo, $destination);
		}else{
			return false;
			exit;
		}
		return $destination;
	}						
}