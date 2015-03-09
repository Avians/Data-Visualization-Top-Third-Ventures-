<?php

/**
 * Zilas Main file.
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
 * THIS IS THE MAIN FILE AND ENTRY SCRIPT INTO THE WHOLE FRAMEWORK.
 * -----------------------------------------------------------------------------
 * All the URL requests into Zilas PHP Framework are routed via this "index.php"
 * file into the controller for processing.
 * 
 * Being the entry script, it launches the Zilas bootstrap script which then
 * determines an application controllers specified  in the URL for execution.
 */


/**
 * -----------------------------------------------------------------------------
 * RULES GOVERNING THE APPLICATION CONTROLLERS & UTILISED BY ZILAS PHP FRAMEWORK
 * -----------------------------------------------------------------------------
 * The framework's CORE CONTROLLER is located inside ZilasFramework directory in the path, "/zf_base/zf_core/zf_inner/zf_controller.php"
 * This file MUST NOT be changed, unless by authorised core author(s) of Zilas PHP Framework or at your own risk.
 * 
 * All the application dependent CONTROLLER files MUST reside inside the directory "/zf_application/app_controllers/"
 * These controller files follow the following set of rules.  
 *
 *      1. All the controller files MUST have a unique and standard PHP file name format e.g filename.php ==> (Administration.php)
 *      2. All the classes within the controller files MUST have a class declaration format e.g FilenameController(){}  ==> ( AdministrationController(){...} )
 *      3. All the classes within the controllers MUST extend the Zilas Core Controller e.g   ==> ( class AdministrationController extends Zf_Controller(){...} )
 *      4. All the action methods within the controller classes MUST have a method definition format e.g actionName(){} ==> ( actionLogout(){...}, actionLogin(){....}, actionProcessForm(){...} ) 
 *      5. The default action for all controllers is the action specified as default in the "$zf_defaultAction" variable within each controller.
 *      6. Always replicate the zf_template controller which is readily structured for a standard Zilas PHP Framework Controller and then rename to suit your development need.
 * 
 */


/**
 * -----------------------------------------------------------------------------
 * RULES GOVERNING THE APPLICATION MODELS & UTILISED BY ZILAS PHP FRAMEWORK
 * -----------------------------------------------------------------------------
 * The framework's CORE MODEL is located inside ZilasFramework directory in the path, "/zf_base/zf_core/zf_inner/zf_model.php"
 * This file MUST NOT be changed, unless by authorised core author(s) of Zilas PHP Framework or at your own risk.
 * 
 * All the application dependent MODEL files MUST reside inside the directory "/zf_application/app_models/"
 * These model files follow the following set of rules.
 * 
 *      1. All the model files related a particular controller MUST be like; /zf_application/app_models/controller/action_model.php
 *      2. All the model files MUST have the following file format modelname_model.php e.g /zf_application/app_models/controller_name/modelname_name.php  ==>  ( /zf_application/app_models/administration/login_model.php )
 *      3. All the classes within the model files MUST extend the Zilas Core Model e.g class Modelname_Model extends CoreModel(){...}   ==> ( class Login_Model extends Zf_Model(){...} )
 *      4. In naming the model files, "modelname" section is the same as the "Name" section of an actionName within the co-related controller.
 *      5. All the methods within the models just follows the standard principals of defining any normal PHP based method.
 *      6. Always replicate the zf_template model which is readily structured for a standard Zilas PHP Framework Model and then rename to suit your development need.
 *  
 */


/**
 * -----------------------------------------------------------------------------
 * RULES GOVERNING THE APPLICATION VIEWS & UTILISED BY ZILAS PHP FRAMEWORK
 * -----------------------------------------------------------------------------
 * The framework's CORE VIEW is located inside ZilasFramework directory in the path, "/zf_base/zf_core/zf_inner/zf_view.php"
 * This file MUST NOT be changed, unless by authorised core author(s) of Zilas PHP Framework or at your own risk.
 * 
 * All the application dependent VIEW files MUST reside inside the directory "/zf_application/app_views/"
 * These view files follow the following set of rules.
 * 
 *      1. All the view files controlled by a specific controller, reside inside a directory that has a name corresponding to the name of the controlling controller.
 *      2. All the view file directories and the corresponding view files MUST begin in lower cases.
 *      6. Always replicate the zf_template view which is readily structured for a standard Zilas PHP Framework View and then rename to suit your development need.
 * 
 */


/**
 * -----------------------------------------------------------------------------
 * RULES GOVERNING ALL THE APPLICATION WIDGETS UTILISED BY ZILAS PHP FRAMEWORK
 * -----------------------------------------------------------------------------
 * 
 */


/**
 * -----------------------------------------------------------------------------
 * RULES GOVERNING ALL THE APPLICATION PLUGINS UTILISED BY ZILAS PHP FRAMEWORK
 * -----------------------------------------------------------------------------
 * 
 */


/**
 * -----------------------------------------------------------------------------
 * GENERAL FLOW OF EVENTS BETWEEN THE ZILAS APPLICATION AND ZILAS PHP FRAMEWORK
 * -----------------------------------------------------------------------------
 *     0. The .htaccess file is important in ensuring that all requests are routed via the "index.php" file in root directory of the Zilas PHP Framework Application.
 *     1. Requires the application cofiguration file for the application in the "index.php" file.
 *     2. Include the Autoloader class so that all the available and necessary classes are initially autoloaded for use.
 *     3. Instantiates the zilasInit.php file which is the bootstrap class so as to start the routing process.
 *     4. The bootstrap class then analyses the user request, and passes on the request to the intended controller.
 *     5. The controller check for the necessary actions and calls the related models if any, then pushes on to render the necessary view.
 *     6. Execution complete!!
 * 
 */


/**
 * -----------------------------------------------------------------------------
 * HERE WE REQUIRE THE APPLICATION CONSTANTS FILE, WHICH HOLDS FRAMWORK PATHS
 * -----------------------------------------------------------------------------
 * 
 */
require_once 'zf_base/zf_constants/zf_core_constants.php'; 


/**
 * -----------------------------------------------------------------------------
 * HERE WE REQUIRE THE FRAMEWORKS AUTOLOAD FILE WHICH HANLDES THE AUTOLOADING OF
 * ALL RELEVANT CLASSES. 
 * -----------------------------------------------------------------------------
 * 
 */
require_once ZF_CORE."zf_autoload.php";

Zf_Autoload::zf_getInstance()->zf_getLog();


/**
 * -----------------------------------------------------------------------------
 * HERE WE RUN THE ZILAS PHP FRAMEWORK, BOOTSTRAP CLASS, WHICH STARTS THE URL
 * EXECUTION AND ROUTING PROCESS.
 * -----------------------------------------------------------------------------
 * 
 */
Zf_Bootstrap::zf_run();


?>
