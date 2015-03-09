<?php

/**
 * -----------------------------------------------------------------------------
 * THIS CLASS FILE IS ESSENTIAL FOR LOADING ALL THE IMAGES USED WITHIN ANY ZILAS
 * FRAMEWORK APPLICATION.
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  25th/September/2013  Time: 17:00 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */

class Zf_LoadImages{
    
    
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
     * THIS IS THE MAIN STATIC METHOD FOR LOADING APPLICATION LOGO. THIS METHOD
     * EXPECTS AN ARRAY CONTAINING FOUR ELEMENTS.
     * 
     * Element 1: Width of the logo in px or %
     * Element 2: Heigth of the logo in px or %
     * Element 3: Altrnative description of the logo
     * Element 4: Title of the logo as it shoud appear on hover
     * Element 5: Optional CSS that can be used to style the logo
     * Element 6: Optional Identity that can be used to invoke the logo
     * -------------------------------------------------------------------------
     * 
     */
    public static function zf_loadLogo($zf_logo_data = NULL){
        
        /**
         * Check to see that link data is not emtpy
         */
        if(empty($zf_logo_data) || !is_array($zf_logo_data) || $zf_logo_data == NULL){
            
            $zf_application_logo = '<a href="'.ZF_ROOT_PATH.'" ><img src="'.APPLICATION_LOGO.'" alt="'.APPLICATION_NAME.'"/></a>';
            
        }else{
            
            $zf_application_logo = '<a href="'.ZF_ROOT_PATH.'" title="'.$zf_logo_data['alt'].'" ><img src="'.APPLICATION_LOGO.'" alt="'.$zf_logo_data['alt'].'" width="'.$zf_logo_data['width'].'" height="'.$zf_logo_data['height'].'" style="'.$zf_logo_data['style'].'"  id="'.$zf_logo_data['id'].'"/></a>';
            
        }
        
        echo $zf_application_logo;
        
    }
    
    
}


?>

