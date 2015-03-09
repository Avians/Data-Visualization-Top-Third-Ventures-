<?php

/**
 * -----------------------------------------------------------------------------
 * THIS CLASS FILE IS ESSENTIAL FOR DETECTING IF THE DEVICE THAT IS ACCESSING
 * OUR APPLICATION OR WEBSITE IS A MOBILE DEVICE, TABLET DEVICE OR A PC
 * 
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  16th/January/2014  Time: 11:40 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */


final class Zf_DeviceDetect extends Zf_MobileDetect{
    
    public $targetView = array();




    /**
     * -------------------------------------------------------------------------
     * THIS THE CLASS CONSTRUCTOR, IT RUNS BY DEFAULT WHENEVER THE CLASS IS
     * INITIALISED.
     * -------------------------------------------------------------------------
     * 
     */
    public function __construct() {
        
        parent::__construct();
            
    }
    
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE MAIN STATIC METHOD FOR DETECTING IF THA ACCESSING DEVICE IS
     * A MOBILE DEVICE
     * -------------------------------------------------------------------------
     * 
     */
    public static function zf_detectMobile(){
        
        /**
         * This is essential in calling the methods that are used for device
         * detection
         */
        $zf_currentDevice = new self;
        
        if($zf_currentDevice->isMobile() && !$zf_currentDevice->isTablet()){
            
            return TRUE;
            
        }
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE MAIN STATIC METHOD FOR DETECTING IF THA ACCESSING DEVICE IS
     * A TABLET DEVICE
     * -------------------------------------------------------------------------
     * 
     */
    public static function zf_detectTablet(){
        
        /**
         * This is essential in calling the methods that are used for device
         * detection
         */
        $zf_currentDevice = new self;
        
        if($zf_currentDevice->isTablet() && !$zf_currentDevice->isMobile()){
            
            return TRUE;
            
        }

        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE MAIN STATIC METHOD FOR DETECTING IF THA ACCESSING DEVICE IS
     * A PC DEVICE
     * -------------------------------------------------------------------------
     * 
     */
    public static function zf_detectPC(){
        
        /**
         * This is essential in calling the methods that are used for device
         * detection
         */
        $zf_currentDevice = new self;
        
        if(!$zf_currentDevice->isMobile() && !$zf_currentDevice->isTablet()){
            
            return TRUE;
            
        }
        
    }

    
}

?>
