<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS A CORE FILE FOR ZILAS FRAMEWORK HOLDING ALL THE CORE CONSTANTS
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  11th/August/2013  Time: 23:00 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 */

/**
 * -----------------------------------------------------------------------------
 * HERE WE REQUIRE THE ZILAS PHP FRAMEWORK, CORE CONFIGURATION FILE
 * -----------------------------------------------------------------------------
 * 
 */
require_once 'zf_base/zf_configurations/zf_configurations.php';

/**
 * -----------------------------------------------------------------------------
 * THIS HOLDS THE DEFAULT FRAMEWORK PATHS FOR ZILAS PHP FRAMEWORK
 * -----------------------------------------------------------------------------
 */
$zf_defaultPaths = Zf_Configurations::Zf_ConfigurationPaths();

/**
 * -----------------------------------------------------------------------------
 * THIS HOLDS THE VALUE OF THE DIRECTORY SEPARATOR
 * -----------------------------------------------------------------------------
 */
$zf_directorySeparator = Zf_Configurations::Zf_directorySeparator();

/**
 * -----------------------------------------------------------------------------
 * USING BROWSER USER AGENTS, WE GET TO SELECT THE DIRECTORY SEPARATOR
 * -----------------------------------------------------------------------------
 * 
 */
 defined('DS') ? null : define('DS', $zf_directorySeparator);//i.e in this case DS means either "\" for windows or "/" for unix.
 

/**
 * -----------------------------------------------------------------------------
 *  THIS IS THE APPLICATION PATH TO THE ROOT FOLDER OF A GIVEN ZILAS APPLICATION                                                      
 * -----------------------------------------------------------------------------
 */
   defined('ZF_ROOT_PATH') ? null : define('ZF_ROOT_PATH', $zf_defaultPaths['zf_application']);    
    

/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ABSOLUTE PATH TO THE "zf_base" directory
 * -----------------------------------------------------------------------------
 */
    defined('ZF_BASE')      ? null : define('ZF_BASE'      , 'zf_base'.DS);
    
    
/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ABSOLUTE PATH TO DIRECTORIES IN THE zf_base DIRECTORY.
 * -----------------------------------------------------------------------------
 */
    defined('ZF_CLASSES')   ? null : define('ZF_CLASSES'   ,  ZF_BASE.'zf_classes'.DS);
    defined('ZF_CONFIG')    ? null : define('ZF_CONFIG'    ,  ZF_BASE.'zf_configurations'.DS);
    defined('ZF_CONSTANTS') ? null : define('ZF_CONSTANTS' ,  ZF_BASE.'zf_constants'.DS);
    defined('ZF_CORE')      ? null : define('ZF_CORE'      ,  ZF_BASE.'zf_core'.DS);
    defined('ZF_FUNCTIONS') ? null : define('ZF_FUNCTIONS' ,  ZF_BASE.'zf_functions'.DS);
    defined('ZF_PLUGINS')   ? null : define('ZF_PLUGINS'   ,  ZF_BASE.'zf_plugins'.DS);
    defined('ZF_WIDGETS')   ? null : define('ZF_WIDGETS'   ,  ZF_BASE.'zf_widgets'.DS);
    
    
/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ABSOLUTE PATHS TO THE APPLICATION INSTALLATION FILE AND THE
 * ACTUAL FILE ITSELF.
 * -----------------------------------------------------------------------------
 * 
 */
    defined('INSTALLATION_FILE') ? null : define('INSTALLATION_FILE', ZF_CORE.'zf_install/zf_install.php');
    defined('INSTALLATION_PATH') ? null : define('INSTALLATION_PATH', $zf_defaultPaths['zf_application'].DS.INSTALLATION_FILE);
    
 
/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ABSOLUTE PATH TO THE "zf_application" directory
 * -----------------------------------------------------------------------------
 */
    defined('ZF_APPLICATION')  ? null : define('ZF_APPLICATION'  , 'zf_application'.DS);
    
    
/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ABSOLUTE PATH TO DIRECTORIES IN THE zf_application DIRECTORY.
 * -----------------------------------------------------------------------------
 */
    defined('APP_CONTROLLERS')   ? null : define('APP_CONTROLLERS' ,  ZF_APPLICATION.'app_controllers'.DS);
    defined('APP_MODELS')        ? null : define('APP_MODELS'      ,  ZF_APPLICATION.'app_models'.DS);
    defined('APP_VIEWS')         ? null : define('APP_VIEWS'       ,  ZF_APPLICATION.'app_views'.DS);
    defined('APP_PLUGINS')       ? null : define('APP_PLUGINS'     ,  ZF_APPLICATION.'app_plugins'.DS);
    defined('APP_WIDGETS')       ? null : define('APP_WIDGETS'     ,  ZF_APPLICATION.'app_widgets'.DS);
    defined('APP_LAYOUTS')       ? null : define('APP_LAYOUTS'     ,  ZF_APPLICATION.'app_layouts'.DS);
 
    
/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ABSOLUTE PATH TO DIRECTORIES FOR APPLICATION ASSETS
 * -----------------------------------------------------------------------------
 */
    defined('APP_CONTROLLERS_ASSETS')  ? null : define('APP_CONTROLLERS_ASSETS' ,  APP_CONTROLLERS.'app_assets'.DS);
    defined('APP_MODELS_ASSETS')       ? null : define('APP_MODELS_ASSETS' ,  APP_MODELS.'app_assets'.DS);
    defined('APP_VIEWS_ASSETS')        ? null : define('APP_VIEWS_ASSETS' ,  APP_VIEWS.'app_assets'.DS);
    

/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ABSOLUTE PATH TO INNER DIRECTORIES FOR APPLICATION LAYOUTS
 * -----------------------------------------------------------------------------
 */
    defined('APPLICATION_HEADERS')  ? null : define('APPLICATION_HEADERS', APP_LAYOUTS.'app_headers'.DS);
    defined('APPLICATION_FOOTERS')  ? null : define('APPLICATION_FOOTERS', APP_LAYOUTS.'app_footers'.DS);
    
    
/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ABSOLUTE PATH TO THE "zf_client" directory
 * -----------------------------------------------------------------------------
 */
    defined('ZF_CLIENT')      ? null : define('ZF_CLIENT'      , 'zf_client'.DS);
    
/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ABSOLUTE PATH TO DIRECTORIES IN THE zf_client DIRECTORY.
 * -----------------------------------------------------------------------------
 */
    defined('ZF_APP_GLOBAL')       ? null : define('ZF_APP_GLOBAL' ,  ZF_CLIENT.'zf_app_global'.DS);
    defined('ZF_DESKTOP_LAPTOP')   ? null : define('ZF_DESKTOP_LAPTOPL' ,  ZF_CLIENT.'zf_desktop_laptop'.DS);
    defined('ZF_MOBILE_DEVICE')    ? null : define('ZF_MOBILE_DEVICE' ,  ZF_CLIENT.'zf_mobile_device'.DS);
    defined('ZF_TABLET_DEVICE')    ? null : define('ZF_TABLET_DEVICE' ,  ZF_CLIENT.'zf_tablet_devices'.DS);
    
    
/**
 * -----------------------------------------------------------------------------
 * THIS HOLDS THE VALUES FOR THE ROLES OF USERS WITHIN THE TOP THIRD PLATFORM
 * -----------------------------------------------------------------------------
 */    
    defined('PLATFORM_SUPER_ADMIN')    ?   null : define('PLATFORM_SUPER_ADMIN' , 9);
    defined('TOP_THIRD_ADMIN')         ?   null : define('TOP_THIRD_ADMIN' , 8);
    defined('COMPANY_ADMIN')           ?   null : define('COMPANY_ADMIN' , 7);
    defined('REGIONAL_MANAGER')        ?   null : define('REGIONAL_MANAGER' , 6);
    defined('SHOP_MANAGER')            ?   null : define('SHOP_MANAGER' , 5);
    defined('ASSISTANT_SHOP_MANAGER')  ?   null : define('ASSISTANT_SHOP_MANAGER' ,  4);
    defined('SALES_REPRESENTATIVE')    ?   null : define('SALES_REPRESENTATIVE' ,  3);
    defined('INACTIVE_USER')           ?   null : define('INACTIVE_USER ' ,  2);
    defined('BANNED_USER')             ?   null : define('BANNED_USER' ,  1);
    defined('GUEST_USER')              ?   null : define('GUEST_USER' ,  0);
    

?>
