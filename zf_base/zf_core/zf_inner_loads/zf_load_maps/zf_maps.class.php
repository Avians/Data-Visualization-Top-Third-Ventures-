<?php

/**
 * -----------------------------------------------------------------------------
 * THIS CLASS FILE IS ESSENTIAL FOR METHODS USED IN THE MAP BUILDER CLASS AND
 * THEN USES THESE METHODS TO GENERATE GEO-MAPS.
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  01st/November/2013  Time: 23:00 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */

class Zf_Maps extends Zf_MapBuilder {

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
     * THIS IS THE STATIC METHOD THAT IS RESPONSIBLE FOR GENERATION OF A BASIC
     * SATELLITE MAP
     * -------------------------------------------------------------------------
     * 
     */
    public static function zf_basic_satellite($zf_map_data){
        
        //The parameter "$zf_map_data" holds all the data necessary for map generation.
        $zf_map = new self;
        
        $zf_map->setCenter($zf_map_data['latitude'], $zf_map_data['longitude']);
        
        $zf_map->setMapTypeId(Zf_MapBuilder::MAP_TYPE_ID_SATELLITE);
        
        
        $zf_map->setSize($zf_map_data['width'], $zf_map_data['height']);
       
        $zf_map->show();
        
    }
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE STATIC METHOD THAT IS RESPONSIBLE FOR GENERATION OF A BASIC
     * ROADMAP MAP
     * -------------------------------------------------------------------------
     * 
     */
    public static function zf_basic_roadmap($zf_map_data){
        
        //The parameter "$zf_map_data" holds all the data necessary for map generation.
        $zf_map = new self;
        
        $zf_map->setCenter($zf_map_data['latitude'], $zf_map_data['longitude']);
        
        $zf_map->setMapTypeId(Zf_MapBuilder::MAP_TYPE_ID_ROADMAP);
        
        $zf_map->setSize($zf_map_data['width'], $zf_map_data['height']);
       
        $zf_map->show();
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS IS THE STATIC METHOD THAT IS RESPONSIBLE FOR GENERATION OF A BASIC
     * HYBRID MAP
     * -------------------------------------------------------------------------
     * 
     */
    public static function zf_basic_hybrid($zf_map_data){
        
        //The parameter "$zf_map_data" holds all the data necessary for map generation.
        $zf_map = new self;
        
        $zf_map->setCenter($zf_map_data['latitude'], $zf_map_data['longitude']);
        
        $zf_map->setMapTypeId(Zf_MapBuilder::MAP_TYPE_ID_HYBRID);
        
        $zf_map->setSize($zf_map_data['width'], $zf_map_data['height']);
       
        $zf_map->show();
        
    }
    

}
?>
