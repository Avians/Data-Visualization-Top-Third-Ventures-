<?php

/**
 * -----------------------------------------------------------------------------
 * THIS IS CACHE CLASS THAT IS RESPONSIBLE FOR CACHING THE FILES USED WIHTIN THE 
 * FRAMEWORK. THIS FILE WILL CHECK IF THE FRAMEWORK'S CACHING MECHNISM IS 
 * ENABLED AND IT YES, THE FILES WILL BE CACHED, IF NO, THE FILES WILL NOT BE 
 * CACHED.
 * -----------------------------------------------------------------------------
 *
 * @added Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  12th/August/2013  Time: 09:00 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */

class Zf_StaticCache {


 /**************************\
 
  @ $query {string} unique id, query sql
  @ $time {int} the time in seconds of duration
  @ $file {string} md5 cached file
  @ $switch {bool} 1 - not cached / 0 - cached

 \**************************/
   var $query;
   var $time;
   var $file;
   var $switch;


 /**************************\
   
   function check_cache
   ( 
     query -> $q,
     time -> $t,
     dir -> cache     
   )

 \**************************/
 function check_cache ($q, $t=300, $dir="zf_datastore/zf_static")
 {
     if ($q == '') 
     {
         $this->switch = 1;  
         return 1;
     }

     $this->time = $t;
     $this->query = $q;
     $this->file = $dir.'/'.md5($this->query).'.cache'; 
		
		//echo $this->file;
		
     if ((time()-@filemtime($this->file)) > $this->time) 
     { 
         $this->switch = 1;
         return 1;  
     }
      else 
     {      
         $this->switch = 0;         
         return 0;  
     }
 }


 /**************************\
   
   function start_cache
   ( switch -> true or false )

 \**************************/ 
 function start_cache ()
 {
     if ($this->switch) {@ob_start();}       
 }


 /**************************\
   
   function end_cache
   ( switch -> true or false )

 \**************************/ 
 function end_cache ()
 {
     if ($this->switch)
     {
         $contents = @ob_get_contents();
         @ob_end_clean();
         if ($f = @fopen($this->file, "wb"))
         {
             @fwrite($f, $contents);
             @fclose($f);
         }
         echo $contents;
     }
 }


 /**************************\
   
   function contents_cache
   ( readfile cache )

 \**************************/ 
 function contents_cache ()
 {
     @readfile($this->file);
 }


 /**************************\

   clean up the folder of cache  

   function emptying_cache
   ( 
     dir -> cache folder 
     DeleteMe -> delete folder  1 - yes or 0 - no
   )

 \**************************/ 
 function emptying_cache ($dir, $DeleteMe=0)
 {
    if (!$dh = @opendir($dir)) {return false;}
    while (false !== ($obj = @readdir($dh)))
    {
        if ($obj == '.' || $obj == '..' || $obj == 'index.html')
        {
            continue;
        }
         else 
        {
            if (!@unlink($dir.'/'.$obj)) {SureRemoveDir($dir.'/'.$obj, true);}
        }  
        
    }

    if ($DeleteMe)
    {
        @closedir($dh);
        @rmdir($dir);
    }
 }

}

?>
