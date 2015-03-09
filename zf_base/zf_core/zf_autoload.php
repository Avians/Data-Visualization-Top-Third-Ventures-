<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS ZF_AUTOLOAD FILE FOR ZILAS PHP FRAMEWORK. IT HELPS IN AUTOLOADING
 * ALL THE FRAMEWORK CLASSES BY SCANNING ALL THE DESIGNATED DIRECTORIES.
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  11th/August/2013  Time: 23:00 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 * .............................................................................
 * ADAPTED FROM:
 * 
 * autoload.class.php
 *
 * A class wrapper for the __autoload function
 *
 * @version	        1.0
 * @author	        Thomas Shone <xsist10@gmail.com>
 * @copyright		2008
 * @since 	        2008-10-24
 * 
 */


class Zf_Autoload{
    
    /**
     * -------------------------------------------------------------------------
     * A SINGLETON INSTANCE OF THE AUTOLOADER
     * -------------------------------------------------------------------------
     * 
     * @var Autoload
     * @access private
     * 
     */
    private static $_zf_instance;
    
    
    /**
     * -------------------------------------------------------------------------
     * A REQUIRED COLLECTION OF FILES THAT MUST BE INCLUDED WHEN THE OBJECT IS
     * INSTANTIATED.
     * -------------------------------------------------------------------------
     * 
     * @var    string array
     * @access private
     * 
     */
    private $_zf_required_files = array('zf_bootstrap');
    
   
    /**
     * -------------------------------------------------------------------------
     * A BASE DIRECTORY, FROM WHICH OTHER DIRECTORIES ARE SEARCHED FOR CLASS
     * FILES
     * -------------------------------------------------------------------------
     * 
     * @var    string array
     * @access private
     * 
     */
    private $_zf_base_dir = array('zf_base');
    
    
    /**
     * -------------------------------------------------------------------------
     * A LIST OF FILES OR DIRECTORIES THAT MUST BE IGNORED UPON INSTANTIATION
     * -------------------------------------------------------------------------
     * 
     * @var    string array
     * @access private
     * 
     */
    private $_zf_ignore_files = array('.', '..', '.DS_Store',"adodb5","zf_seo.php", "phpgrid_js");
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS HOLDS A LIST OF AVAILABLE LIBRARIES AND DIRECTORIES AFTER A SEARCH
     * -------------------------------------------------------------------------
     * 
     * @var string
     * @access private
     * 
     */
    private $_zf_available_files;
    
    
    /**
     * -------------------------------------------------------------------------
     * A TEMPORARY CROSS-RECURSIVE-FUNCTION FOR STORAGE
     * -------------------------------------------------------------------------
     * 
     * @var stirng
     * @access private
     * 
     */
    private $_zf_found_temp_files;
    
    
    /**
     * -------------------------------------------------------------------------
     * A LIST OF VALID FILE EXTENSIONS. UNVALID FILE EXTENSIONS WILL BE IGNORED
     * -------------------------------------------------------------------------
     *  
     * @var    string array
     * @access private
     * 
     */
    private $_zf_file_extensions = array('.class.php' ,'.php', '.class.inc', '.inc', '.zf', '.class.zf');
    
    
    /**
     * -------------------------------------------------------------------------
     * KEEPS A LOG OF THE ACTIONS OF THIS CLASS
     * -------------------------------------------------------------------------
     * 
     * @var    string
     * @access private
     * 
     */
    private $_zf_class_log;
    
    
    /**
     * -------------------------------------------------------------------------
     * PHP 5 and Above; THIS CONSTRUCTOR LOADS ALL THE REQUIRED LIBRARIES UPON
     * INITIALISATION.
     * -------------------------------------------------------------------------
     * 
     * @function
     * @access private
     * 
     */
    
    private function __construct() {
        
        foreach ($this->_zf_base_dir as $searched_directories) {
            
            $this->zf_buildDirList($searched_directories);
            
            foreach ($this->_zf_required_files as $found_files){
                
                $this->zf_loadFiles($found_files);
                
            }
            
        }
        
    }
    
    
    /**
      -------------------------------------------------------------------------
     * PHP 3, 4 Constructor
     * -------------------------------------------------------------------------
     *
     * Points to __constructor()
     *
     * @access	public
     */
    private function Factory() {
        
        $this->__construct();
  
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS LOCATES AND LOADS A FILE UPON A REQUEST.
     * -------------------------------------------------------------------------
     *
     * @param	string $class_files
     * @access	public
     */
    public function zf_loadFiles($class_files){
        
        if ($this->_zf_available_files[$class_files]) {
            
            require_once $this->_zf_available_files[$class_files];
            $this->_zf_class_log = "Loaded " . $class_files . " (" . $this->_zf_available_files[$class_files] . ")";

            return true;
            
        } else {
            
            throw new Exception("Could not find file for class " . $class_files);
            
        }
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS RECURSIVELY PASSES THROUGH A DIRECTORY AND FINDS ALL FILES THAT 
     * MATHCES A PARTICULAR PATTERN AND CONVENTIONS AND BUILDS THEIR LIST
     * -------------------------------------------------------------------------
     *
     * @param	string $zf_base
     * @access	private
     */
    private function zf_buildDirList($directories = ""){
        
        $directories = rtrim($directories, "/") ."/";
        
        if($directories_handler = opendir($directories)){
            
            while(($file_handler = readdir($directories_handler)) !== false){
                
                if(in_array($file_handler, $this->_zf_ignore_files)){
                    
                    // Recusrively check any directories we come across
                    
                }else if(is_dir($directories . $file_handler)){
                    
                    $this->zf_buildDirList($directories . $file_handler);
                    
                }else{
                    
                    $class_files = str_replace($this->_zf_file_extensions, array_fill(0, count($this->_zf_file_extensions), ""), $file_handler);
                    
                    if(isset($this->_zf_available_files[$class_files])){
                        
                        throw new Exception("Duplicate file for ". $class_files ." found.");
                        
                    }else{
                        
                        $this->_zf_available_files[$class_files] = $directories . $file_handler;
                        
                    }
                    
                }
                
            }
            
        }
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS RETURNS THE LOG ACTIONS OF THE CLASS
     * -------------------------------------------------------------------------
     *
     * @access	public
     * @return	string array
     */
    public function zf_getLog() {
        return $this->_zf_class_log;
    }
    

    /**
     * -------------------------------------------------------------------------
     * CLONE MAGIC FUNCTION PREVENTS EXTERNAL INSTANTIATION OF COPIES OF THE 
     * SINGLETON CLASS
     * -------------------------------------------------------------------------
     *
     * @access	public
     */
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
    

    /**
     * -------------------------------------------------------------------------
     * WAKEUP MAGIC FUNCTION PREVENTS EXTERNAL INSTANTIATION OF COPIES OF THE 
     * SINGLETON CLASS
     * -------------------------------------------------------------------------
     *
     * @access	public
     */
    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }
    

    /**
     * -------------------------------------------------------------------------
     * HERE, WE GET THE SINGLETON INSTANCE OF THE CLASS
     * -------------------------------------------------------------------------
     *
     * @access	public
     * @return	self
     */
    public static function zf_getInstance() {
        if (!self::$_zf_instance instanceof self) {
            self::$_zf_instance = new self;
        }
        return self::$_zf_instance;
    }
    
}

/**
 * -----------------------------------------------------------------------------
 * HERE, WE ARE OVERLOADING THE PHP DEFAULT AUTOLOAD FUNCTION
 * -----------------------------------------------------------------------------
 *
 * @param	string $class_files
 */
function __autoload($class_files) {
    
	if (!Zf_Autoload::zf_getInstance()->zf_loadFiles(strtolower($class_files))) {
		// Note: Exceptions thrown in __autoload function cannot be caught in the catch block and results in a fatal error.
		// Note: Autoloading is not available if using PHP in CLI interactive mode.
		throw new Exception("Failed to load essential library: ". $class_files, __FILE__, __LINE__);
	}
        
}

?>
