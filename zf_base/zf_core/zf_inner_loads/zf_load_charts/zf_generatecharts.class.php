<?php

/**
 * -----------------------------------------------------------------------------
 * THIS CLASS FILE IS ESSENTIAL FOR LOADING THE CHARTS THAT HAVE BEEN GENERATED
 * USING THE FUSIONCHARTS PLUGIN.
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  25th/December/2013  Time: 21:40 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */

class Zf_GenerateCharts{
    
    
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
     * THIS STATIC METHOD IS RESPONSIBLE FOR GENERATING A CHART GIVEN A FEW 
     * PARAMETORS.
     * -------------------------------------------------------------------------
     */
    public static function zf_generate_chart($zf_chartParameters, $chartPosition = NULL){
        
        if(!empty($chartPosition) && $chartPosition != NULL && $chartPosition == "inline"){
            
            @require_once ZF_PLUGINS.'zf_fusioncharts'.DS.'php'.DS.'FusionCharts.php';
            
        }
        
        FC_SetRenderer("javascript"); FC_SetDataFormat("xml");
        echo renderChart( ZF_ROOT_PATH.APP_PLUGINS."zf_fusioncharts".DS."{$zf_chartParameters['chartType']}.swf", "", $zf_chartParameters['chartData'], $zf_chartParameters['chartId'], $zf_chartParameters['chartWidth'], $zf_chartParameters['chartHeight'], $zf_chartParameters['chartDebug'], $zf_chartParameters['registerJavacript'],$zf_chartParameters['chartTransparency']);
        
    }

    
}

?>