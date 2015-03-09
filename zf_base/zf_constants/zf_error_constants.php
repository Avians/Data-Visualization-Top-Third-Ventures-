<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ZILAS CORE ERROR CONSTANTS FILE, WHICH IS ESSENTIAL FOR ALL THE 
 * DEFAULT APPLICATION ERROR REPORTING CAPABILITY.
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  12th/August/2013  Time: 10:45 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */


/**
 * -----------------------------------------------------------------------------
 * THIS IS FOR REPORTING ROUTING ERROR RELATED TO INVALID DEFAULT CONTROLLER
 * -----------------------------------------------------------------------------
 */
    defined('ERROR_INVALID_DEFAULT_CONTROLLER')  ? null : define('ERROR_INVALID_DEFAULT_CONTROLLER', 100);
 
    
/**
 * -----------------------------------------------------------------------------
 * THIS IS FOR REPORTING ROUTING ERROR RELATED TO INVALID SELECTED CONTROLLER
 * -----------------------------------------------------------------------------
 */
    defined('ERROR_INVALID_SELECTED_CONTROLLER')  ? null : define('ERROR_INVALID_SELECTED_CONTROLLER', 101);
 
    
/**
 * -----------------------------------------------------------------------------
 * THIS IS FOR REPORTING ROUTING ERROR RELATED TO INVALID DEFAULT ACTION
 * -----------------------------------------------------------------------------
 */
    defined('ERROR_INVALID_DEFAULT_ACTION')  ? null : define('ERROR_INVALID_DEFAULT_ACTION', 200);
 
    
/**
 * -----------------------------------------------------------------------------
 * THIS IS FOR REPORTING ROUTING ERROR RELATED TO A DEFAULT ACTION NOT SET
 * -----------------------------------------------------------------------------
 */
    defined('ERROR_NOT_SET_DEFAULT_ACTION')  ? null : define('ERROR_NOT_SET_DEFAULT_ACTION', 201);
 
    
/**
 * -----------------------------------------------------------------------------
 * THIS IS FOR REPORTING ROUTING ERROR RELATED TO INVALID SELECTED ACTION
 * -----------------------------------------------------------------------------
 */
    defined('ERROR_INVALID_SELECTED_ACTION')  ? null : define('ERROR_INVALID_SELECTED_ACTION', 202);
    
    
/**
 * -----------------------------------------------------------------------------
 * THIS IS FOR REPORTING ROUTING ERROR RELATED TO INVALID TARGETED VIEW
 * -----------------------------------------------------------------------------
 */
    defined('ERROR_INVALID_TARGET_VIEW')  ? null : define('ERROR_INVALID_TARGET_VIEW', 300);
 
    
?>
