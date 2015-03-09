<?php

// we are assuming that database connection are already set
if($zf_phpGridSettings['zf_tableName'] != NULL){
    
    $database_settings = Zf_Configurations::Zf_DatabaseSettings();
            
    $characterset = $database_settings['zf_dbCharacterset'];
    $connection   = $database_settings['zf_dbConnection'];
    
    
    $db_conf = array();
    $db_conf["type"]     = $database_settings['zf_dbType'];; // mysql,oci8(for oracle),mssql,postgres,sybase
    $db_conf["server"]   = $database_settings['zf_dbHost'];;
    $db_conf["user"]     = $database_settings['zf_dbUser'];
    $db_conf["password"] = $database_settings['zf_dbPassword'];;
    $db_conf["database"] = $database_settings['zf_dbName'];

    // include and create object
    include_once ZF_PLUGINS.'zf_phpgrid'.DS.'lib'.DS.'inc'.DS.'zf_phpgrid.php';
    $g = new zf_phpgrid($db_conf);

    $g->set_options($zf_phpGridSettings['zf_gridSettings']);

    $g->set_actions($zf_phpGridSettings['zf_gridActions']);
    
    if(($zf_phpGridSettings['zf_gridQuery'] != "") && (!empty($zf_phpGridSettings['zf_gridQuery']))){
 
        $g->select_command =  $zf_phpGridSettings['zf_gridQuery'];
        
    }
   
    

    // set database table for CRUD operations
    $g->table = $zf_phpGridSettings['zf_tableName'];
    
    // pass the cooked columns to grid
    if(!empty($zf_phpGridSettings['zf_gridColumns'])){
        
        $g->set_columns($zf_phpGridSettings['zf_gridColumns']);
        
    }
    
    // render grid and get html/js output
    $zf_generateTable = $g->render("list1");
    
}
?>