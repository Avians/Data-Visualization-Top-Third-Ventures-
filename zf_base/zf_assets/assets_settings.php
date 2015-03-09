<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ASSETS SETTINGS FILE. ALL THE ASSETS SETTINGS ARE DONE ON THIS 
 * FILES BY THE AUTHORISED FRAMEWORK DEVELOPERS. 
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  13th/August/2013  Time: 21:45 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */


/**
 * -----------------------------------------------------------------------------
 * HERE WE SET THE APPLICATION ENCRYPTION KEY FOR ENCRYPTION AND DECRYPTION 
 * PURPOSES.
 * 
 * NB: THIS KEY SHOULD BE SET ONCE AND ONLY ONCE IN THE LIFE OF THE WHOLE 
 * APPLICATION. IF YOU LOOSE YOUR "ENCRYPTION_DECRYPTION_KEY", YOU WILL NOT BE 
 * ABLE TO RECOVER YOUR PREVIOUSLY ENCRYPTED DATA.
 * 
 * Default Key is: Athias-Avians(Mathew-Juma-O)!<+*+%>!@11th-08-2013-ZilasPHPencryption/decryption-CODE&copyzilasphpframework2013+[asdfghjklLKJHGFDSA]^[QWERTYUIOPpoiuytrewq]^[zxcvbnmMNBVCXZ]
 * -----------------------------------------------------------------------------
 */
    @define('ENCRYPTION_DECRYPTIION_KEY', 'Athias-Avians(Mathew-Juma-O)!<+*+%>!@11th-08-2013-ZilasPHPencryption/decryption-CODE&copyzilasphpframework2013+[asdfghjklLKJHGFDSA]^[QWERTYUIOPpoiuytrewq]^[zxcvbnmMNBVCXZ]');


/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ABSOLUTE PATH TO THE "zf_application" directory
 * -----------------------------------------------------------------------------
 */
    defined('ZF_ASSETS')  ? null : define('ZF_ASSETS'  , ZF_BASE.'zf_assets'.DS);
    
    
/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ABSOLUTE PATH TO DIRECTORIES IN THE zf_application DIRECTORY.
 * -----------------------------------------------------------------------------
 */
    defined('ASSETS_CONTROLLERS')   ? null : define('ASSETS_CONTROLLERS' ,  ZF_ASSETS.'assets_controllers'.DS);
    defined('ASSETS_MODELS')        ? null : define('ASSETS_MODELS'      ,  ZF_ASSETS.'assets_models'.DS);
    defined('ASSETS_VIEWS')         ? null : define('ASSETS_VIEWS'       ,  ZF_ASSETS.'assets_views'.DS);
    defined('ASSETS_LAYOUTS')       ? null : define('ASSETS_LAYOUTS'     ,  ZF_ASSETS.'assets_layouts'.DS);
    

/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ABSOLUTE PATH TO ASSETS LAYOUT HEADERS AND THE FOOTER.
 * -----------------------------------------------------------------------------
 */
    defined('ASSETS_HEADERS') ? null : define('ASSETS_HEADERS' , ASSETS_LAYOUTS.'assets_headers'.DS);
    defined('ASSETS_FOOTERS') ? null : define('ASSETS_FOOTERS' , ASSETS_LAYOUTS.'assets_footers'.DS);
    
    
?>
