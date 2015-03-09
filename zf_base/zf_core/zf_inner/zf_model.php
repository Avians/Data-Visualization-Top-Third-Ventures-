<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS THE CORE MODEL FOR ZILAS PHP FRAMEWORK. ITS IS THE MAIN BRIDEG 
 * BETWEEN THE MODELS AND THE DATABASE ABSTRACTION CLASSES.
 * 
 * THIS CLASS MUST BE EXTENDED BY ALL THE OTHER MODELS USED IN THE APPLICATION.
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  14th/August/2013  Time: 11:20 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013 (sunday)
 * 
 */


class Zf_Model extends Zf_QueryGenerator {
    
    /**
     *This is property that is used to instantiate the ADODB library for 
     * database transaction processing.
     * 
     * @var type protected
     */
    protected $Zf_AdoDB;
    
    
    /**
     * This is property that is used to instantiate the Zf_QueryGenerator 
     * library for database transaction processing.
     * 
     * @var type protected
     */
    protected $Zf_QueryGenerator;
    
    
    /**
     * This is property that is used to instantiate the Zf_QueryGenerator 
     * library for database transaction processing.
     * 
     * @var type protected
     */
    public $identificationCodeArray;
    
    /**
     * -------------------------------------------------------------------------
     * THIS THE CLASS CONSTRUCTOR, IT RUNS BY DEFAULT WHENEVER THE CLASS IS
     * INITIALISED.
     * -------------------------------------------------------------------------
     * 
     */
    public function __construct() {
        
        parent::__construct();
        
        $database_settings = Zf_Configurations::Zf_DatabaseSettings();
        
        
        $databasetype = $database_settings['zf_dbType']; 
        $server       = $database_settings['zf_dbHost'];
        $user         = $database_settings['zf_dbUser'];
        $password     = $database_settings['zf_dbPassword'];
        $database     = $database_settings['zf_dbName'];
        $characterset = $database_settings['zf_dbCharacterset'];
        $connection   = $database_settings['zf_dbConnection'];

        if($database_settings['zf_dbDebug'] == 'true'){
           
            echo "<pre>";print_r($database_settings);echo "</pre><br><br>";
            
        }
        
        $this->Zf_AdoDB = ADONewConnection($databasetype);
        
        $this->Zf_AdoDB->debug = $database_settings['zf_dbDebug']; 
        
        $this->Zf_AdoDB->Connect($server, $user, $password, $database);
        
        $this->identificationCodeArray = Zf_Core_Functions::Zf_DecodeIdentificationCode(Zf_SessionHandler::zf_getSessionVariable('ttv_identificationCode'));
        
        //$this->Zf_QueryGenerator = new Zf_QueryGenerator(true, $database, $server, $user, $password);  
            
    }

}
?>
