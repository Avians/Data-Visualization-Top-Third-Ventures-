<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS THE ZILAS PHP FRAMEWORK, PHP GRID CONFIGURATION FILE. ALL ITS DEFAULT
 * CONFIGURATIONS ARE IN THIS PARTICULAR FILE.
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  24th/December/2013  Time: 09:30 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 */

class zf_phpGridConfigurations {
    
    
    /**
     * -------------------------------------------------------------------------
     * STORES AN ARRAY OF ALL THE GRID SETTINGS FOR THE PHP GRID
     * -------------------------------------------------------------------------
     * 
     * @var string array
     * @access private
     * 
     */
    private static $zf_gridSettings = array();
    
    
    /**
     * -------------------------------------------------------------------------
     * STORES AN ARRAY OF ALL THE GRID ACTIONS FOR THE PHP GRID
     * -------------------------------------------------------------------------
     * 
     * @var string array
     * @access private
     * 
     */
    private static $zf_gridActions = array();

    
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
    public static function Zf_PhpGridSettings($zf_gridTitle = NULL){
        
        self::$zf_gridSettings = array(
            
            //Main Settings for the data grid
            "caption" => $zf_gridTitle,
            "width"   => 1200,
            "height"  => 300,
            "rowNum"  => 10,

            //Other settings for the data grid.
            "rowList" => array(5,10,20,30,40,50,100),
            "viewrecords" => true,
            "forceFit" => true,
            "autowidth" => true,
            "resizable" => false,
            "hiddengrid" => false,
            "hidegrid" => true,
            "toolbar" => "bottom",
            "multiselect" => true,
            "altRows" => false, 
            "cellEdit" => false,

            //Grid settings that accept arrays.
            "form" => array("nav"=>true, "position"=>"center"),

            //Grid settings for exporting data either as PDF or XLS
            "export" => array("range"=>"filtered", "filename"=>"my-file", "sheetname"=>"my-file", "heading"=>$zf_gridTitle, "orientation"=>"potrait", "paper"=>"a4"),
            // "export" => array("format"=>"xls", "range"=>"filtered", "filename"=>"my-file", "heading"=>"$zf_gridTitle", "orientation"=>"landscape", "paper"=>"a4"),


            "add_options" => array("recreateForm" => true, "closeAfterEdit"=>true, "width"=>"500", "top"=>"600", "left"=>"500" ),
            "edit_options" => array("recreateForm" => true, "closeAfterEdit"=>true, "width"=>"500", "top"=>"600", "left"=>"500"),
            
        );
        
        return self::$zf_gridSettings;
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
    public static function Zf_PhpGridActions(){
        
        self::$zf_gridActions = array(
            "add"=>true,
            "edit"=>true,
            "delete"=>true,
            "view"=>true,
            "rowactions"=>true,
            "export_excel"=>true, // show/hide export to excel option - must set export xlsx params
            "export_pdf"=>true, // show/hide export to pdf option - must set pdf params
            //"export_csv"=>true, // show/hide export to pdf option - must set pdf params
            "autofilter" => true,
            "search" => "advance", //simple or advance
            "inlineadd" => false,
            "showhidecolumns" => false
        );
        
        return self::$zf_gridActions;
    }

}
?>
