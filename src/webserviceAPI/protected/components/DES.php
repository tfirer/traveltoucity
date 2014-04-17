<?php
class DES {	
	var $key;		
	function DES($key) 
	{		
		$this->key = $this->subKey($key);		
	}
			
	function encrypt($input) {		
		$size = mcrypt_get_block_size('des', 'ecb');
		
		$input = $this->pkcs5_complete($input);
		$input = $this->pkcs5_pad($input, $size);
		$key = $this->key;    	
		$td = mcrypt_module_open('des', '', 'ecb', '');	    
		$iv = @mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);	   
		@mcrypt_generic_init($td, $key, $iv);	    
		$data = mcrypt_generic($td, $input);	
		mcrypt_generic_deinit($td);	   
		mcrypt_module_close($td);
		$data = base64_encode($data);	    
		return $data;	
	}		
	function decrypt($encrypted) {		
		$encrypted = base64_decode($encrypted);  	
		$key =$this->key;   	
		$td = mcrypt_module_open('des','','ecb',''); 
         	
		$iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);       	
		$ks = mcrypt_enc_get_key_size($td);         	
		@mcrypt_generic_init($td, $key, $iv);       
           	
		$decrypted = mdecrypt_generic($td, $encrypted);       

		mcrypt_generic_deinit($td);       
         
		mcrypt_module_close($td);               
		$y=$this->pkcs5_unpad($decrypted);        
		return $y;	
	}		
	
	function pkcs5_complete($text)
	{
		$textSize = strlen($text);
		switch (strlen($textSize))
		{
			case 1:
				$textSize = '000'.$textSize;
				break;
			case 2:
				$textSize = '00'.$textSize;
				break;
			case 3:
				$textSize = '0'.$textSize;
				break;
			default:
				break;			
		}
		
		return $textSize . $text;
	}
	
	function pkcs5_pad ($text, $blocksize) {
		$pad = $blocksize - (strlen($text) % $blocksize);
		return $text . str_repeat(chr('\0'), $pad);
	}
	
	function pkcs5_unpad($text)
	{
		$text = substr($text, 4);
		return trim($text, chr('\0'));
	}
	
	function subKey($key)
	{
		$tmpKey = '00000000'.$key;
		$tmpKey = substr($tmpKey, strlen($tmpKey) - 8, 8); 
		return $tmpKey;	
	}
}
?> 