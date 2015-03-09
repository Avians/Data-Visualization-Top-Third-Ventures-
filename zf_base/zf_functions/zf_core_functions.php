<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ZILAS CORE FUNCTIONS FILE, WHICH IS ESSENTIAL FOR ALL THE DEFAULT
 * APPLICATION FUNCTIONS THAT ARE NECESSARY FOR THE FRAMEWORK TO RUN PROPERLY
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  12th/August/2013  Time: 09:30 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */


class Zf_Core_Functions {
    
    /**
     * -----------------------------------------------------------------------------
     * Responsible for sanitizing and spliting the URL passed and then it returns an
     * array with the URL parts as the array values.
     * -----------------------------------------------------------------------------
     */
    public static function Zf_URLSanitize() {

        /**
         * IF A URL HAS BEEN SET, GET IT FOR SANITIZATION
         */
        $zf_url = isset($_GET['url']) ? $_GET['url'] : null;


        /**
         * REMOVE THE LAST FORWARD SLASH "/" FROM THE URL
         */
        $zf_url = rtrim($zf_url, '/');


        /**
         * FILTER THE URL TO ONLY REMAIN WITH CLEAN URL
         */
        $zf_url = filter_var($zf_url, FILTER_SANITIZE_URL);


        /**
         * SPLIT THE URL, WITH "/" AS THE DELIMITER WHILE RETURNING EACH PART INTO
         * AN ARRAY
         */
        $zf_url = explode('/', $zf_url);

        //print_r($zf_url); echo "<br><br>"; //This is strictly for debugging purposes.


        /**
         * RETURNS AN ARRAY OF THE URL PARTS.
         */
        return $zf_url;
    }
    
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE STATIC METHOD FOR GENERATING THE APPLICATION COPYRIGHT
     * INFORMATION
     * -------------------------------------------------------------------------
     */
    public static function Zf_ApplicationCopyright(){
        
        $zf_applicationcopyright = Zf_Configurations::Zf_ApplicationStatus();
        
        echo  $zf_applicationcopyright['application_copyright'];
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE STATIC METHOD FOR GENERATING THE "powered by..." FRAMEWORK 
     * TAGLINE.
     * -------------------------------------------------------------------------
     */
    public static function Zf_FrameworkTagLine(){
        
        $zf_external_link = array(
            'name' => 'Powered by: Zilas PHP Framework',
            'link' => 'http://www.zilasframework.com', //Always ensure that the external link starts with http:// or https://
            'title' => 'Zilas PHP Framework',
            'target' => '_blank',
            'style' => '',
            'id' => ''
        );
    
        $zf_frameworkTagline = Zf_GenerateLinks::zf_external_link($zf_external_link);
        echo  $zf_frameworkTagline;
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE STATIC METHOD FOR DECODING THE IDENIFICATION CODE INTO AN 
     * ARRAY
     * -------------------------------------------------------------------------
     */
    public static function Zf_DecodeIdentificationCode($identificationCode){
        
        $zf_idenificationCode = explode('-', Zf_SecureData::zf_decode_data($identificationCode));
        
        return $zf_idenificationCode;
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE STATIC METHOD FOR GENERATING A RANDOM STRING
     * -------------------------------------------------------------------------
     */
    public static function Zf_GenerateRandomString($zf_stringLength){
        
        $randomGenerator = new self;
        
        $randomValue = $randomGenerator->Zf_GenerateRandomData($zf_stringLength);
            
        return md5($randomValue);

        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE STATIC METHOD FOR GENERATING RANDOM DATA
     * -------------------------------------------------------------------------
     */
    public function Zf_GenerateRandomData($zf_stringLength){
       
            $randstr = "";
            for($i=0; $i<$zf_stringLength; $i++){
                    $randnum = mt_rand(0,61);
                    if($randnum < 10){
                            $randstr .= chr($randnum+48);
                    }
                    else if($randnum < 36){
                            $randstr .= chr($randnum+55);
                    }else{
                            $randstr .= chr($randnum+61);
                    }
            }
            return $randstr;
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE STATIC METHOD FOR GENERATING RANDOM DATA
     * -------------------------------------------------------------------------
     */
    public static function Zf_GeneratePassword($zf_passwordLength = 9, $zf_passwordStrength = 0){
       
        $vowels = 'aeiou';
	$consonants = 'bcdfghjklmnpqrstvwxyz';
	if ($zf_passwordStrength & 1) {
		$consonants .= 'BCDFGHJKLMNPQRSTVWXYZ';
	}
	if ($zf_passwordStrength & 2) {
		$vowels .= "AEIOU";
	}
	if ($zf_passwordStrength & 4) {
		$consonants .= '23456789';
	}
	if ($zf_passwordStrength & 8) {
		$consonants .= '&@#$%!';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $zf_passwordLength; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
        
    }
    
    
}

?>
