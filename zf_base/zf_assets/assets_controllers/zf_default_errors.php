<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS THE DEFAULT APPLICATION CONSTRUCTION CONTROLLER WHICH IS ESSENTIAL
 * FOR ROUTING AND RENDERING THE DEFAULT VIEW OF AN APPLICATION BEING IN 
 * DEVELOPMENT.
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  28th/August/2013  Time: 13:30 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013 (sunday)
 * 
 */

class Zf_Default_ErrorsController extends Zf_Controller {
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS THE CLASS CONSTRUCTOR, IT RUNS BY DEFAULT WHENEVER THE CLASS IS
     * INITIALISED.
     * -------------------------------------------------------------------------
     * 
     */
    public function __construct() {
        
        /**
         * CALL THE CONSTRUCTOR OF THE PARENT CLASS.
         */
        parent::__construct();
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE PUBLIC FUNCTION THAT IS RESPONSIBLE FOR THE EXECUTION OF ALL 
     * SYSTEM ROUTING ERRORS
     * -------------------------------------------------------------------------
     * 
     */
    public static function zf_runErrors($zf_errorParameters = NULL){
        
        if($zf_errorParameters === ERROR_INVALID_DEFAULT_CONTROLLER){
            
            /**
             * This displays a view for an invalid default controller. The 
             * $zf_data, refers to the actual data passed into the view to render
             * the necessary information.
             * 
             */
            
            $zf_data = '<h1>Application Controller Error <code>'.ERROR_INVALID_DEFAULT_CONTROLLER.'</code>:</h1><p>The <code>default controller</code> you are trying to access is invalid!</p>';
            
            Zf_View::zf_displayView(ERROR_INVALID_DEFAULT_CONTROLLER, $zf_data);
            
            
        }else if($zf_errorParameters === ERROR_INVALID_SELECTED_CONTROLLER){
            
            /**
             * This displays a view for an invalid selected controller. The 
             * $zf_data, refers to the actual data passed into the view to render
             * the necessary information.
             * 
             */
            
            $zf_data = '<h1>Application Controller Error <code>'.ERROR_INVALID_SELECTED_CONTROLLER.'</code>:</h1><p>The <code>selected controller</code> you are trying to access is invalid!</p>';
            
            Zf_View::zf_displayView(ERROR_INVALID_SELECTED_CONTROLLER, $zf_data);
            
        
        }else if($zf_errorParameters === ERROR_INVALID_DEFAULT_ACTION){
            
            /**
             * This displays a view for an invalid default action. The $zf_data,
             * refers to the actual data passed into the view to render
             * the necessary information.
             * 
             */
            
            $zf_data = '<h1>Application Action Error <code>'.ERROR_INVALID_DEFAULT_ACTION.'</code>:</h1><p>The <code>default action</code> you are trying to execute is invalid!</p>';
            
            Zf_View::zf_displayView(ERROR_INVALID_DEFAULT_ACTION, $zf_data);
            
            
        }else if($zf_errorParameters === ERROR_NOT_SET_DEFAULT_ACTION){
            
            /**
             * This displays a view for a NOT SET default action. The $zf_data,
             * refers to the actual data passed into the view to render
             * the necessary information.
             * 
             */
            
            $zf_data = '<h1>Application Action Error <code>'.ERROR_NOT_SET_DEFAULT_ACTION.'</code>:</h1><p>The <code>default action</code> you are trying to execute has not been set!</p>';
            
            Zf_View::zf_displayView(ERROR_NOT_SET_DEFAULT_ACTION, $zf_data);
            
            
        }else if($zf_errorParameters === ERROR_INVALID_SELECTED_ACTION){
            
            /**
             * This displays a view for an invalid selected action. The $zf_data,
             * refers to the actual data passed into the view to render
             * the necessary information.
             * 
             */
            
            $zf_data = '<h1>Application Action Error <code>'.ERROR_INVALID_SELECTED_ACTION.'</code>:</h1><p>The <code>selected action</code> you are trying to execute is invalid!</p>';
            
            Zf_View::zf_displayView(ERROR_INVALID_SELECTED_ACTION, $zf_data);
            
            
        }
        
    }
    
    
    
}

?>
