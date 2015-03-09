<?php

/**
 * -----------------------------------------------------------------------------
 * THIS CLASS FILE IS ESSENTIAL FOR LOADING ALL THE WIDGETS PRE BUILT IN ZILAS
 * FRAMEWORK INCLUDING ALL THE RELATED "css" AND "scripts"
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  25th/September/2013  Time: 16:20 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */

class Zf_DefaultWidgets{
    
    
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
     * THIS IS STATIC METHOD THAT IS RESPONSIBLE FOR LOADING ALL THE FRAMEWORK'S
     * DEFAULT WIDGETS
     * -------------------------------------------------------------------------
     */
    public static function zf_load_widget(){
        
        echo "Here we load default framework widgets";
        
    }
    
}

?>

