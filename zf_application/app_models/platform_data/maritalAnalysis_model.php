<?php

//THIS CODE IS WRITTEN BY:
          //1. ATHIAS AVIANS (MATHEW JUMA), THE CHIEF AND CORE DEVELOPER OF ZILAS FRAMEWORK PROJECT.
          

/*
 * ---------------------------------------------------------------------
 * |                                                                   |
 * |  This the Index Model which is responsible responsible for        |
 * |  handling all logics that are related to the template Controller  |
 * |                                                                   |
 * ---------------------------------------------------------------------
 */

class MaritalAnalysis_Model extends Zf_Model {
    
    //This holds the session user details.
    private $sessionUser;
    

   /*
    * --------------------------------------------------------------------------------------
    * |                                                                                    |
    * |  The is the main class constructor. It runs automatically within any class object  |
    * |                                                                                    |
    * --------------------------------------------------------------------------------------
    */
    public function __construct() {
        
         parent::__construct();
         
         $this->sessionUser = Zf_SessionHandler::zf_getSessionVariable("ttv_identificationCode");
         
    }
    
    
    
    /**
     * =========================================================================
     * THIS METHOD HOLDS ALL THE INFORMATION RELATED TO AREAS OF ACTIVE PROJECTS.
     * =========================================================================
     */
    public function ProjectAreas(){
        
        //An instance of the ZF_MAPBUILDER CLASS.
        $zf_map = new Zf_MapBuilder();
        
        // Set map's center position by latitude and longitude coordinates. 
        $zf_map->setCenter(-1.2921,36.8219);

        // Set the default map type.
        $zf_map->setMapTypeId(Zf_MapBuilder::MAP_TYPE_ID_TERRAIN);

        // Set width and height of the map.
        $zf_map->setSize(730, 310);

        // Set default zoom level.
        $zf_map->setZoom(2);

        // Make zoom control compact.
        $zf_map->setZoomControlStyle(Zf_MapBuilder::ZOOM_CONTROL_STYLE_DEFAULT);

        // Define locations and add markers with custom icons and attached info windows.
        $column = array('country_name','latitude','longitude');
            
        $getProjectCountries = Zf_QueryGenerator::BuildSQLSelect('ttv_projectCountries','', $column);
        //echo $sql; exit(); //This is strictly for debugging purpose.
        
        //Fetch all the results related to the query above.
        $result = mysql_query("$getProjectCountries") or die(mysql_error());
        while ($row = mysql_fetch_assoc($result)) {

            $zf_map->addMarker($row['latitude'], $row['longitude'], array(
                'title' => $row['country_name'],
                'html' => '<div style="width: 120px; height: 160px;">Counrty: '. $row['country_name'] .'</div><b></b>', 
                'infoCloseOthers' => true
            ));
        }

        // Display the map.
        $zf_map->show();
        
    }
    

}

?>

