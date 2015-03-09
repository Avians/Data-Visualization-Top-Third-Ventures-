<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ZILAS PHP FRAMEWORK, CORE CONFIGURATION FILE. ALL DEFAULT
 * CONFIGURATIONS ARE IN THIS PARTICULAR FILE.
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  12th/August/2013  Time: 12:15 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 */


/**
 * -----------------------------------------------------------------------------
 * HERE WE REQUIRE THE APPLICATION SETTINGS FILE, WHICH IS SET BY THE DEVELPOER
 * -----------------------------------------------------------------------------
 * 
 */
require_once 'zf_application/zf_application_settings.php'; 

class Zf_Configurations {
    
    /**
     * -------------------------------------------------------------------------
     * STORES AN ARRAY OF A COLLECTION OF APPLICATION DEFAULT PATHS
     * -------------------------------------------------------------------------
     * 
     * @var string array
     * @access private
     * 
     */
    private static $zf_defaultpaths;
    
    
    /**
     * -------------------------------------------------------------------------
     * STORES AN ARRAY CONTAINING THE STATUS OF THE APPLICATION
     * -------------------------------------------------------------------------
     * 
     * @var string array
     * @access private
     * 
     */
    private static $zf_applicationstatus;
    
    
    /**
     * -------------------------------------------------------------------------
     * STORES AN ARRAY CONTAINING DEFAULT SETTINGS OF THE APPLICATION
     * -------------------------------------------------------------------------
     * 
     * @var string array
     * @access private
     * 
     */
    private static $zf_applicationdefaults;
    
    
    /**
     * -------------------------------------------------------------------------
     * STORES AN ARRAY CONTAINING BREADCRUMBS SETTINGS FOR THE APPLICATION
     * -------------------------------------------------------------------------
     * 
     * @var string array
     * @access private
     * 
     */
    private static $zf_applicationbreadcrumbs;
    
    /**
     * -------------------------------------------------------------------------
     * STORES AN ARRAY CONTAINING DATABASE SETTINGS FOR THE APPLICATION
     * -------------------------------------------------------------------------
     * 
     * @var string array
     * @access private
     * 
     */
    private static $zf_databaseSettings;
    
    
    /**
     * -------------------------------------------------------------------------
     * STORES AN ARRAY CONTAINING SMTP MAIL SERVER SETTINGS FOR THE APPLICATION
     * -------------------------------------------------------------------------
     * 
     * @var string array
     * @access private
     * 
     */
    private static $zf_smtpSettings;
    
    
    
    

    /**
     * -------------------------------------------------------------------------
     * THIS THE CLASS CONSTRUCTOR, IT RUNS BY DEFAULT WHENEVER THE CLASS IS
     * INITIALISED.
     * -------------------------------------------------------------------------
     * 
     */
    public function __construct() {
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS A STATIC METHOD THAT RETURNS AN ARRAY HOLDING ALL THE APPLICATION
     * PATHS.
     * -------------------------------------------------------------------------
     *
     * @var    string array
     * @access public 
     */
    public static function Zf_ConfigurationPaths(){
    
        $DS = self::Zf_directorySeparator();
        
        $zf_protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
        $zf_protocol = isset($_SERVER["https"]) ? 'https' : 'http';
        
        $zf_serverPath = $zf_protocol.':'.$DS.$DS.$_SERVER['SERVER_NAME'].$DS;
        
        self::$zf_defaultpaths = array(
            
            'zf_application'   => $zf_serverPath.APPLICATION_FOLDER,
            'application_name' => APPLICATION_NAME,
            'application_logo' => $zf_serverPath.APPLICATION_LOGO
            
        );
        
        return self::$zf_defaultpaths;
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS A STATIC METHOD THAT RETURNS AN ARRAY HOLDING ALL THE APPLICATION
     * PATHS.
     * -------------------------------------------------------------------------
     *
     * @var    string array
     * @access public 
     */
    public static function Zf_ApplicationStatus(){
        
        self::$zf_applicationstatus = array(
            
            'application_title'      => APPLICATION_NAME,
            'application_copyright'  => APPLICATION_COPYRIGHT,
            'application_status'     => APPLICATION_STATUS,
            'construction_indicator' => CONSTRUCTION_INDICATOR,
            'default_controller'     => DEFAULT_CONTROLLER
            
        );
        
        return self::$zf_applicationstatus;
    }
    
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS A STATIC METHOD THAT RETURNS AN ARRAY HOLDING ALL DEFAULT SETTINGS
     * OF THE ZILAS BASED APPLICATION.
     * -------------------------------------------------------------------------
     *
     * @var    string array
     * @access public 
     */
    public static function Zf_ApplicationDefaults(){
        
        self::$zf_applicationdefaults = array(
            
            'application_seo'          => APPLICATION_SEO,
            'application_caching'      => APPLICATION_CACHING,
            'application_urlencrypt'   => APPLICATION_URLENCRYPT,
            'application_encryption'   => APPLICATION_ENCRYPTION,
            'application_decryption'   => APPLICATION_DECRYPTION,
            'security_key'             => ENCRYPTION_DECRYPTIION_KEY,
            'application_fusioncharts' => APPLICATION_FUSIONCHARTS,
            'application_phpgrid'      => APPLICATION_PHPGRID       
            
        );
        
        return self::$zf_applicationdefaults;
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS A STATIC METHOD THAT RETURNS AN ARRAY HOLDING ALL DEFAULT SETTINGS
     * OF THE ZILAS BASED APPLICATION.
     * -------------------------------------------------------------------------
     *
     * @var    string array
     * @access public 
     */
    public static function Zf_ApplicationBreadcrumbs(){
        
        self::$zf_applicationbreadcrumbs = array(
            
            'application_breadcrumbs'    => APPLICATION_BREADCRUMBS,
            'breadcrumbs_symbol'         => BREADCRUMBS_SYMBOL
            
        );
        
        return self::$zf_applicationbreadcrumbs;
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS A STATIC METHOD THAT RETURNS AN ARRAY HOLDING ALL DEFAULT SETTINGS
     * OF THE ZILAS BASED APPLICATION.
     * -------------------------------------------------------------------------
     *
     * @var    string array
     * @access public 
     */
    public static function Zf_DatabaseSettings(){
        
        self::$zf_databaseSettings = array(
            
            'zf_dbHost'          => DATABASE_HOST,
            'zf_dbUser'          => DATABASE_USERNAME,
            'zf_dbPassword'      => DATABASE_PASSWORD,
            'zf_dbType'          => DATABASE_DRIVER,
            'zf_dbName'          => DATABASE_NAME,
            'zf_dbCharacterset'  => CHARACTER_SET,
            'zf_dbConnection'    => CONNECTION_TYPE,
            'zf_dbDebug'         => DATABASE_DEBUG
            
        );
        
        return self::$zf_databaseSettings;
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS A STATIC METHOD THAT RETURNS AN ARRAY HOLDING ALL DEFAULT SETTINGS
     * OF THE SMTP SERVER FOR ZILAS BASED APPLICATION.
     * -------------------------------------------------------------------------
     *
     * @var    string array
     * @access public 
     */
    public static function Zf_SmtpSettings(){
        
        self::$zf_smtpSettings = array(
            
            'zf_smtpServer'    => SMTP_MAIL_SERVER,
            'zf_smtpHost'      => SMTP_SERVER_HOST,
            'zf_smtpAuth'      => SMTP_SERVER_AUTH,
            'zf_smtpUsername'  => SMTP_SERVER_USERNAME,
            'zf_smtpPassword'  => SMTP_SERVER_PASSWORD
            
        );
        
        return self::$zf_smtpSettings;
    }
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS A STATIC METHOD THAT RETURNS THE OPERATING SYSTEM ON WHICH YOUR
     * APPLICATION IS RUNNING
     * -------------------------------------------------------------------------
     *
     * @var    string array
     * @access public 
     */
    public static function Zf_getOperatingSystem() {
        
        //Here we get get actual user agent.
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        
        $os_platform = "Unknown OS Platform";

        $os_array = array(
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($os_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }

        return $os_platform;
        
    }
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS A STATIC METHOD THAT RETURNS THE BROWSER AGENT WHICH IS RENDERING
     * YOUR APPLICATION PAGES
     * -------------------------------------------------------------------------
     *
     * @var    string array
     * @access public 
     */
    public static function Zf_getBrowserAgent() {
        
        //Here we get get actual user agent.
         $user_agent = $_SERVER['HTTP_USER_AGENT'];
        
        $browser = "Unknown Browser";

        $browser_array = array(
            '/msie/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/opera/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i' => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }

        return $browser;
    }
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS A STATIC METHOD THAT GENERATES THE VALID DIRECTORY SEPARATOR
     * -------------------------------------------------------------------------
     *
     * @var    string array
     * @access public 
     */
    public static function Zf_directorySeparator(){
        
        $zf_getOperatingSystem = self::Zf_getOperatingSystem();
        $zf_getBrowserAgent = self::Zf_getBrowserAgent();
        
        $navigator_user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);

    
        if($navigator_user_agent === "mozilla/5.0 (windows nt 6.1; rv:15.0) gecko/20100101 firefox/15.0.1"){
            defined('DS') ? null : define('DS', '/');//i.e in this case DS means either "\" for windows or "/" for unix.
        }else if(strpos($zf_getOperatingSystem, "Windows") !== false){
           defined('DS') ? null : define('DS', '/');//i.e in this case DS means either "\" for windows or "/" for unix.
        }
        else if(strpos($zf_getBrowserAgent, "Firefox") !== false){
           defined('DS') ? null : define('DS', '/');//i.e in this case DS means either "\" for windows or "/" for unix. 
        }
        else if(strpos($zf_getOperatingSystem, "Android") !== false){
           defined('DS') ? null : define('DS', '/');//i.e in this case DS means either "\" for windows or "/" for unix. 
        }
        else{
           defined('DS') ? null : define('DS',  DIRECTORY_SEPARATOR);//i.e in this case DS means either "\" for windows or "/" for unix===> DIRECTORY_SEPARATOR. 
        }
        
        return DS;
        
    }
    
}

?>
