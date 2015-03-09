<?php

/**
 * -----------------------------------------------------------------------------
 * THIS CLASS FILE IS ESSENTIAL FOR GENERATING THE BREADCRUMBS DEPENDING ON THE
 * SECTION OF THE APPLICATION BEING ACCESSED.
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  25th/September/2013  Time: 17:30 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */

class Zf_BreadCrumbs {
    
    /**
     * -------------------------------------------------------------------------
     * THIS PROPERTY HOLDS VALUE OF THE CURRENT ACTIVE URL GENERATED AS
     *  BREADCRUMBS
     * -------------------------------------------------------------------------
     * 
     * @var string property
     * @access private
     * 
     */
    private static $active_breadcrumb;


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
     * THIS IS STATIC METHOD THAT IS RESPONSIBLE FOR LOADING BREADCRUMBS
     * BASED ON THE LOCATION OF VISIT AND WHETHER BREADCRUMBS ARE SET IN THAT
     * PARTICULAR VIEW.
     * -------------------------------------------------------------------------
     */
    public static function zf_load_breadcrumbs(){
        
        /**
         * This returns an array of all the breadcrumbs settings
         */
        $zf_breadcrumbs = Zf_Configurations::Zf_ApplicationBreadcrumbs();
        
        /**
         * This returns an array of all the Zilas Framework default settings
         */
        $zf_dafultsConf = Zf_Configurations::Zf_ApplicationDefaults();
        
        
        /**
         * Check if the breadcrumbs have been enabled in the framework
         * cofiguration file.
         */
        if($zf_breadcrumbs['application_breadcrumbs'] == 'enabled'){
            
            $zf_current_url = Zf_Core_Functions::Zf_URLSanitize();
    
            if(empty($zf_current_url[0])){

                $activeUrl = explode("-", DEFAULT_CONTROLLER);
                self::$active_breadcrumb = str_ireplace("_", " ", ucfirst($activeUrl[0]));

            }else{

                /*
                 * -----------------------------------------------------------------------------
                 * If $zf_current_url[1], is not empty, we chain both $zf_current_url[0] and 
                 * $zf_current_url[1], to create a two level breadcrumb. Else we only create 
                 * a one level breadcrumb using $zf_current_url[0].   
                 * -----------------------------------------------------------------------------
                 */
                if(!empty($zf_current_url[0])){

                    if(!empty($zf_current_url[1])){

                        self::$active_breadcrumb = "<a href=\" ".ZF_ROOT_PATH.$zf_current_url[0]." \" >".str_ireplace("_", " ", ucfirst($zf_current_url[0]))."</a> ".BREADCRUMBS_SYMBOL;

                    }else{

                        self::$active_breadcrumb = "<span>".str_ireplace("_", " ", ucfirst($zf_current_url[0]))."</span>";

                    }

                }


                /*
                 * ------------------------------------------------------------------------------
                 * If $zf_current_url[2], is not empty, we chain both $zf_current_url[0], 
                 * $zf_current_url[1] and $zf_current_url[2], to create a three level 
                 * breadcrumb. Else we only create a two level breadcrumb using $zf_current_url[0]
                 *  and $zf_current_url[1].                                                                
                 * -------------------------------------------------------------------------------
                 */
                if(!empty($zf_current_url[1])){

                    if(!empty($zf_current_url[2])){
                        
                        if($zf_dafultsConf['application_urlencrypt'] == "enabled"){
                           
                            self::$active_breadcrumb .= "<span>".str_ireplace("_", " ", ucfirst($zf_current_url[1]))."</span>"; 
                        
                        }else{
                            
                            self::$active_breadcrumb .= "<a href=\" ".ZF_ROOT_PATH.$zf_current_url[0].DS.$zf_current_url[1]." \" >".str_ireplace("_", " ", ucfirst($zf_current_url[1]))."</a>  ".BREADCRUMBS_SYMBOL;
                            
                        }

                    }else{

                        self::$active_breadcrumb .= "<span>".str_ireplace("_", " ", ucfirst($zf_current_url[1]))."</span>"; 

                    }

                }


                /*
                 * ----------------------------------------------------------------------                                                                 
                 * If $zf_current_url[2], is not empty, we chain both $zf_current_url[0]
                 * , $zf_current_url[1]and $zf_current_url[2], to create the breadcrumbs                                                                  
                 * ----------------------------------------------------------------------
                 */
                if(!empty($zf_current_url[2])){
                    
                    if($zf_dafultsConf['application_urlencrypt'] == "enabled"){

                        self::$active_breadcrumb .=  " ";
                        
                    }else{
                        
                        self::$active_breadcrumb .=  "<span>".str_ireplace("_", " ", ucfirst($zf_current_url[2]))."</span>";
                        
                    }

                }

            }

            echo ucwords(self::$active_breadcrumb);
            
        }else{
            
            /**
             * This ensures that you cannot encrypt your links
             * without enabling application encryption.
             */
            echo "<code>You must enable <strong>application breadcrumbs</strong> in order to generate breadcrumbs in any view.</code>";
        }
        
        
    }
    
}

?>

