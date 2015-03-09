<?php

/**
 * -----------------------------------------------------------------------------
 * THIS CLASS FILE IS ESSENTIAL FOR UPLOADING ALL FILES TO THE SERVER.
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

class Zf_File_Upload {
    
    /**
     * -------------------------------------------------------------------------
     * THIS STATIC METHOD IS RESPONSIBLE FOR UPLOADING A SIMPLE IMAGE TO THE 
     * SERVER
     * -------------------------------------------------------------------------
     */
    public static function zf_fileUpload($zf_upload_parameters = NULL, $zf_file_settings = NULL){
        
        /**
         * Check to see that $zf_upload_parameters is not emtpy
         */
        if(empty($zf_upload_parameters) || !is_array($zf_upload_parameters) || $zf_upload_parameters == NULL){
            
            echo "<code><strong>File Upload Error:</strong> Missing Upload Parameter Array</code> ";
            
        }else{
        
            self::zf_fileUpload_Process($zf_upload_parameters, $zf_file_settings);
        
        }
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS STATIC METHOD IS RESPONSIBLE FOR UPLOADING A MULTIPLE FILES TO THE 
     * SERVER
     * -------------------------------------------------------------------------
     */
    public static function zf_multipleFileUpload($zf_upload_parameters = NULL, $zf_file_settings = NULL){
        
        /**
         * Check to see that $zf_upload_parameters is not emtpy
         */
        if(empty($zf_upload_parameters) || !is_array($zf_upload_parameters) || $zf_upload_parameters == NULL){
            
            echo "<code><strong>File Upload Error:</strong> Missing Upload Parameter Array</code> ";
            
        }else{
       
            // ---------- MULTIPLE UPLOADS ----------

            // as it is multiple uploads, we will parse the $_FILES array to reorganize it into $files
            $files = array();
            foreach ($zf_upload_parameters['zf_fileFieldName'] as $k => $l) {
                foreach ($l as $i => $v) {
                    if (!array_key_exists($i, $files))
                        $files[$i] = array();
                        $files[$i][$k] = $v;
                }
            }

            // now we can loop through $files, and feed each element to the class
            foreach ($files as $file) {

                $destinationFolder = $zf_upload_parameters['zf_fileUploadFolder'];

                $zf_upload_parameters = array(

                    "zf_fileUploadFolder" => $destinationFolder ,
                    "zf_fileFieldName" => $file

                );

                self::zf_fileUpload_Process($zf_upload_parameters, $zf_file_settings);

            }

            exit();
        }
        
    }
    
    
    /**
     * -------------------------------------------------------------------------
     * THIS STATIC METHOD IS RESPONSIBLE FOR EXECUTING THE ACTUAL FILE UPLOAD
     * PROCESS TO THE SERVER
     * -------------------------------------------------------------------------
     */
    private static function zf_fileUpload_Process($zf_upload_parameters = NULL, $zf_file_settings = NULL){
        
       /**
        * Two parameters that come as parameters
        * 1. file field name
        * 2. desination folder path
        */

       $zf_fileDestination = $zf_upload_parameters['zf_fileUploadFolder'];  $zf_fileFieldName = $zf_upload_parameters['zf_fileFieldName'];
       
       
        // ---------- XMLHttpRequest UPLOAD ----------

        // we first check if it is a XMLHttpRequest call
        if (isset($_SERVER['HTTP_X_FILE_NAME']) && isset($_SERVER['CONTENT_LENGTH'])) {

            // we create an instance of the class, feeding in the name of the file
            // sent via a XMLHttpRequest request, prefixed with 'php:'
            $zf_fileUpload = new Upload('php:'.$_SERVER['HTTP_X_FILE_NAME']);  

        } else {
            
            //An instance of the file upload class.
            $zf_fileUpload = new Zf_FileUpload($zf_fileFieldName); 
            
        }
       
        
        

        /**
         * ========================Here we check that the file has been uploaded===================================== 
         * then we check if the file has been uploaded properly
         * in its *temporary* location in the server (often, it is /tmp)
         * ===========================================================================
         */
         if ($zf_fileUpload->uploaded) {
 
            /**
             * Check to see that link data is not emtpy
             */
            if(!empty($zf_file_settings) || is_array($zf_file_settings) || $zf_file_settings != NULL){

               /**
                * ===========================================================================
                * There are specific file settings that needs to be addressed.
                * So, there are any, we loop through them and execute accordingly.
                * ===========================================================================
                */
                foreach ($zf_file_settings as $settingsName => $settingsValue) {

                    $zf_fileUpload->$settingsName = $settingsValue;

                } 

            }
             


             /**
              * =======================START FILE PROCESSING=================================
              * yes, the file is on the server
              * now, we start the upload 'process'. That is, to copy the uploaded file
              * from its temporary location to the wanted location
              * It could be something like $zf_fileUpload->Process('/home/www/my_uploads/');
              * ===========================================================================
              */ 
             $zf_fileUpload->Process($zf_fileDestination);

             // we check if everything went OK
             if ($zf_fileUpload->processed) {

                 //echo 'File was uploaded successfully !'; exit();
                 //echo '<p class="result">';
                 //echo '  <b>File uploaded with success</b><br />';
                 //echo '  File: <a href="'.$zf_fileDestination.'/' . $zf_fileUpload->file_dst_name . '">' . $zf_fileUpload->file_dst_name . '</a>';
                 //echo '   (' . round(filesize($zf_fileUpload->file_dst_pathname)/256)/4 . 'KB)';
                 //echo '</p>';

             } else {
                  
                 echo '<code>';
                 echo '<strong>one error occured</strong>';
                 echo '<p class="result">';
                 echo '  <b>File not uploaded to the wanted location</b><br />';
                 echo '  Error: ' . $zf_fileUpload->error . '';
                 echo '</p>';
                 echo '</code>';
                 exit();

             }

             // we delete the temporary files
             $zf_fileUpload-> Clean();
             

         } else {
             // if we're here, the upload file failed for some reasons
             // i.e. the server didn't receive the file
             echo '<code>';
             echo '<p class="result">';
             echo '<strong>File not uploaded on the server</strong><br />';
             echo '  Error: ' . $zf_fileUpload->error . '';
             echo '</p>';
             echo '</code>';
             exit();
         } 

    }
    
}

?>