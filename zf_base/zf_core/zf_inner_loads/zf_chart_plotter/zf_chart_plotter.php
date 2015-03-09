<?php

class Zf_Chart_Plotter extends Zf_QueryGenerator{

    public $chart_type;
    public $chart_id;
    public $width;
    public $height;
    
    private $sessionUser;

    
    public function __construct($chart_type, $chart_id, $chart_width, $chart_height) {
        
        $this->init();
        $this->chart_type = $chart_type;
        $this->chart_id = $chart_id;
        $this->width = $chart_width;
        $this->height = $chart_height;
        
    }

    /**
     * -------------------------------------------------------------------------
     * THIS ENSURES THAT ALL NECESSARY FILES ARE INCLUDED AND A PROPER CONNECTION
     * TO THE DATABASE HAS BEEN MADE.
     * -------------------------------------------------------------------------
     * 
     */
    public function init() {
        
        //include('includes/ConnectDB_inc.php');
        @require_once ZF_PLUGINS.'zf_fusioncharts'.DS.'php'.DS.'FusionCharts.php';
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE METHOD THAT PLOTS THE ACTUAL CHARTS.
     * -------------------------------------------------------------------------
     * 
     */
    public function plotChart($tableName, $entityField, $dataRange, $userIdentity, $chartOptions) {
        
        $fieldParameters = $this->params($entityField);
        //print_r($fieldParameters);
        
        if (is_array($entityField)) {
            
            //Here we return the array keys which holds the field name.
            $keys = array_keys($entityField);
            
            $fieldName = $keys[0];
            
        }
        
        //Here we build the chart options
        $strXML = "<chart " . $this->build_attrs($chartOptions) . ">";
        
        foreach ($fieldParameters as $fieldKey => $fieldValue) {
            
            $data[$fieldKey][$fieldValue] = $this->fetchTableData($tableName, $fieldName, $fieldValue, $dataRange, $userIdentity);
            
            if (!empty($data[$fieldKey][$fieldValue])) {
                
                $strXML .= "<set label='" . $fieldValue . "' value='" . $data[$fieldKey][$fieldValue] . "' tooltext=' Total " . $fieldValue . " count: " .$data[$fieldKey][$fieldValue]. ",{br}Click for a detailed{br}information ' link=' ".Zf_GenerateLinks::zf_fusionCharts_link('platform_data', 'customer_data', 'gender_data'.DS. $fieldValue)." ' />";
                
            }
            
        }
        $strXML .= "
                    <styles>
                        <definition>
                              <style name='myToolTipFont' type='font' font='ProximaNova-Light' size='11' color='87b6d9'/>
                        </definition>
                        <application>
                              <apply toObject='ToolTip' styles='myToolTipFont' />
                        </application>
                    </styles> 

                   ";
        
        $strXML = $strXML . "</chart>";
        $this->render($strXML);
    }

    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE METHOD FOR BULIDING THE CHART OPTIONS AS REQUIRED BY FUSION 
     * CHARTS
     * -------------------------------------------------------------------------
     * 
     */
    public function build_attrs($options) {
        //print_r($options);//[bgcolor]=>transparent
        array_walk($options, create_function('&$value, $key',  '$value = " $key = \' $value\' " ;'));
        //print_r($options);
        return $options = rtrim(implode($options, ""));
    }
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE METHOD FOR FETCHING ALL THE RELEVANT DATA OUT OF THE DBASE 
     * -------------------------------------------------------------------------
     * 
     */
    public function fetchTableData($table, $fieldName, $fieldValue, $dataRange, $userIdentity) {
        
        $rangeValues = explode(";", $dataRange);
        
        //Here we filter query by userRoles
        if($userIdentity['userRole'] == PLATFORM_SUPER_ADMIN || $userIdentity['userRole'] == TOP_THIRD_ADMIN ){

            $table_query = "SELECT * FROM " . $table . " WHERE " . $fieldName . "='" . $fieldValue . "' AND age BETWEEN " . $rangeValues[0] . " AND " . $rangeValues[1]; //die();

        }else if($userIdentity['userRole'] == COMPANY_ADMIN){

            $table_query = "SELECT * FROM " . $table . " WHERE " . $fieldName . "='" . $fieldValue . "' AND companySerial = '" .$userIdentity['companySerial']. "' AND age BETWEEN " . $rangeValues[0] . " AND " . $rangeValues[1]; //die();

        }else if($userIdentity['userRole'] == REGIONAL_MANAGER || $userIdentity['userRole'] == SHOP_MANAGER || $userIdentity['userRole'] == ASSISTANT_SHOP_MANAGER){

            $table_query = "SELECT * FROM " . $table . " WHERE " . $fieldName . "='" . $fieldValue . "' AND companySerial = '" .$userIdentity['companySerial']. "' AND identificationCode = '" .$userIdentity['identificationCode']. "' AND age BETWEEN " . $rangeValues[0] . " AND " . $rangeValues[1]; //die();

        } 
        
        
        if ($resultSet = mysql_query($table_query)) {
            
            return mysql_num_rows($resultSet);
            
        } else {
            
            echo "No data to plot chart";
            
        }
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE METHOD THAT RENDERS THE ACTUAL CHARTS.
     * -------------------------------------------------------------------------
     * 
     */
    public function render($strXML) {
        FC_SetRenderer('javascript');
        echo renderChart('FusionCharts/' . $this->chart_type . '.swf', // Path to chart type
                '', // Empty string when using Data String method
                $strXML, // Variable which has the chart data
                $this->chart_id, // Unique chart ID
                $this->width, $this->height, // Width and height in pixels
                false, // Disable debug mode
                true // Enable 'Register with JavaScript' (Recommended)
        );
    }
    

    /**
     * -------------------------------------------------------------------------
     * THIS IS THE METHOD THAT PROCESSES THE FIELD ENTITIES THAT DETERMINE THE
     * DATA TO BE FETCHED.
     * -------------------------------------------------------------------------
     * 
     */
    public function params($entity) {
        
        if (is_array($entity)) {
            
            //Returns the array pointer to the first element.
            return reset($entity);
            
        } else {
            
            $params['gender'] = array("male", "female");
            $params['occupation'] = array("farmer", "doctor");
            
            return $params[$entity];
        }
    }

}

//
//$chart = new Plotter('Pie2D', 'male_female', '660', '400');
//$chart->plot('customer', array('Gender' => array("male", "female")), $_POST['age_bracket'], array("caption" => "Male Female", "showValues" => "1", "useRoundEdges" => "1", "palette" => "3"));

?>