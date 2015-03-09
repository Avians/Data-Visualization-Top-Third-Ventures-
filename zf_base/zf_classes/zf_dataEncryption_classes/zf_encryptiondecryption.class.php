<?php
/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ZILAS PHP FRAMEWORK CLASS FOR ENSURING PROPER ENCRYPTION AND 
 * DECRYPTION OF DATA. ALL THE SETTING CAN BE ENABLED FROM THE SETTINGS FILE
 * WITHIN THE "zf_application" DIRECTORY.
 * 
 * THIS IS THE MAIN CLASS THAT DOES THE 256 BIT ENCRYPTION AND DECRYPTION OF ALL
 * THE ENCYRPTED AND DECRYPTED DATA IN THE WHOLE OF THE ZILAS FRAMEWORK.
 * 
 * Adopted from Nicholas Kreidberg (niczak@gmail.com). - Thanks for kindness  
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  27th/September/2013  Time: 08:00 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 */


class Zf_EncryptionDecryption {
    
    /**
     * THIS IS THE PRIVATE PROPERTY THAT HOLDS THE ENCRYPTION AND DECRYPTION KEY
     * THAT IS USED WITHIN THE WHOLE APPLICATION. THIS KEY SHOULD BE KEPT AWAY
     * FROM PRYING EYES AS IT IS THE MAIN SECURITY TO YOUR APPLICATION.
     *   
     * @var type private static.
     */
    private static $_securekey = ENCRYPTION_DECRYPTIION_KEY; // Default == "Athias-Avians(Mathew-Juma-O)!<+*+%>!@11th-08-2013-ZilasPHPencryption/decryption-CODE"

    
    /**
     * This is public static method that is generate an encrypetd string of 
     * data.
     * 
     * @param type $string
     * @return type encrypeted data string using base64_encode algorithm.
     */
    public static function zf_base64_encode($zf_string) {

        $zf_encode_data = base64_encode($zf_string);
        $zf_data = str_replace(array('+', '/', '='), array('-', '_', ''), $zf_encode_data);
        
        return $zf_data;
    }
    
    
    /**
     * This is the public static method that does the actual encryption and then
     * returns an encrypted data incase of any or else returns a false
     * 
     * @param type $value
     * @return boolean
     */
    public static function zf_data_encode($zf_value) {
        
        if (!$zf_value) {
            
            return false;
            
        }
            
            $zf_text = $zf_value;
            $zf_iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
            $zf_iv = mcrypt_create_iv($zf_iv_size, MCRYPT_RAND);
            $zf_crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(sha1(self::$_securekey)), $zf_text, MCRYPT_MODE_ECB, $zf_iv);
            
            return trim(self::zf_base64_encode($zf_crypttext));
        
        
    }
    

    /**
     * This is public static method that is generate a decrypetd string of 
     * data.
     * 
     * @param type $string
     * @return type decrypted data string using base64_decode algorithm.
     */
    public static function zf_base64_decode($zf_string) {

        $zf_decode_data = str_replace(array('-', '_'), array('+', '/'), $zf_string);
        $zf_mod4 = strlen($zf_decode_data) % 4;
        
        if ($zf_mod4) {
            $zf_decode_data .= substr('====', $zf_mod4);
        }
        
        return base64_decode($zf_decode_data);
    }

    
    /**
     * This is the public static method that does the actual decryption and then
     * returns a decrypted data incase of any or else returns a false
     * 
     * @param type $value
     * @return boolean
     */
    public static function zf_data_decode($zf_value) {
        if (!$zf_value) {
            
            return false;
            
        }
            
            $zf_crypttext = self::zf_base64_decode($zf_value);
            $zf_iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
            $zf_iv = mcrypt_create_iv($zf_iv_size, MCRYPT_RAND);
            $zf_decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(sha1(self::$_securekey)), $zf_crypttext, MCRYPT_MODE_ECB, $zf_iv);
            return trim($zf_decrypttext);
        
        
    }
    

}
?>