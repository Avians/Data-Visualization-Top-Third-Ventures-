<?php

//THIS CODE IS WRITTEN BY:
          //1. ATHIAS AVIANS (MATHEW JUMA), THE CHIEF AND CORE DEVELOPER OF ZILAS FRAMEWORK PROJECT.
          //2. ALLAN KIBET, DEVELOPMENT AND IMPLEMENTATION HEAD AT ZILAS FRAMEWORK PROJECT.

/*
 * ---------------------------------------------------------------------
 * |                                                                   |
 * |  This the Index Model which is responsible responsible for        |
 * |  handling all logics that are related to the template Controller  |
 * |                                                                   |
 * ---------------------------------------------------------------------
 */

class ProcessGuestUser_Model extends Zf_Model {
    
   
    private $_errorResult = array();
    private $_validResult = array();

   /*
    * --------------------------------------------------------------------------------------
    * |                                                                                    |
    * |  The is the main class constructor. It runs automatically within any class object  |
    * |                                                                                    |
    * --------------------------------------------------------------------------------------
    */
    public function __construct() {
        
         parent::__construct();
         
         
    }
    
    //THIS METHOD DOES THE PROCESSING OF ALL LOGINS
    public function processLogin(){
        
      //echo "We are processing logins"; exit();//This is strictly for debugging purposes
        
        
      $this->zf_formController->zf_postFormData('email')
                              ->zf_validateFormData('zf_maximumLength', 30, 'Your email')
                              ->zf_validateFormData('zf_minimumLength', 5, 'Your email')
                              ->zf_validateFormData('zf_checkEmail')
                              ->zf_validateFormData('zf_fieldNotEmpty', 'Email')
              
                              ->zf_postFormData('password')
                              ->zf_validateFormData('zf_maximumLength', 30, 'Your password')
                              ->zf_validateFormData('zf_minimumLength', 5, 'Your password')
                              ->zf_validateFormData('zf_fieldNotEmpty', 'Password');
      
      
      $this->_errorResult = $this->zf_formController->zf_fetchErrorData();
      //echo'<pre>'; print_r($this->_errorResult); echo'<pre>';//exit(); //This is strictly for debugging purpose.
       
       
      $this->_validResult = $this->zf_formController->zf_fetchValidData();
      //echo'<pre>'; print_r($this->_validResult); echo'<pre>'; //exit(); //This is strictly for debugging purpose.
      
      if(empty($this->_errorResult)){
          
          //echo "The form has passed server side fields validation and now MUST be validated against the database";//This is strictly for debugging purpose
           
           foreach ($this->_validResult as $zf_fieldName => $zf_fieldValue) {
               
               if($zf_fieldName == 'email'){
                   
                   $zf_value[$zf_fieldName] = Zf_QueryGenerator::SQLValue($zf_fieldValue); 
                   
               }
               
           } 
           
           $zf_columnStatus = array('userStatus');
           
           $zf_selectUserStatus = Zf_QueryGenerator::BuildSQLSelect('ttv_applicationUsers', $zf_value, $zf_columnStatus);
           
           $zf_executeSelectUserStatus = $this->Zf_AdoDB->Execute($zf_selectUserStatus);
           
           if(!$zf_executeSelectUserStatus){
               
               echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
               
           }else{
               
               if($zf_executeSelectUserStatus->RecordCount() > 0){

                    $userStatus = $zf_executeSelectUserStatus->fields['userStatus'];
               
                    if($userStatus != 1){

                        //echo "You need to activate you account from your email"; exit();

                        Zf_SessionHandler::zf_setSessionVariable("Account_Sign_Up", "need_to_confirm");

                        Zf_GenerateLinks::zf_header_location("index","login");

                    }else{

                        $zf_columnPassword = array('password');

                        $zf_selectUserPassword = Zf_QueryGenerator::BuildSQLSelect('ttv_applicationUsers', $zf_value, $zf_columnPassword);

                        $zf_executeSelectUserPassword = $this->Zf_AdoDB->Execute($zf_selectUserPassword);

                        if(!$zf_executeSelectUserPassword){

                            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

                        }else{

                            if($zf_executeSelectUserPassword->RecordCount() > 0){
                                
                                while(!$zf_executeSelectUserPassword->EOF){
                                    
                                    if($zf_executeSelectUserPassword->fields['password'] === Zf_SecureData::zf_data_encode($this->_validResult['password'])){
                                        
                                        Zf_SessionHandler::zf_setSessionVariable("LoggedIn", true);
                                        
                                        $zf_valueUserEmail['email'] = Zf_QueryGenerator::SQLValue($this->_validResult['email']); 
                                        $zf_columnIdentificationCode = array('identificationCode');
                                        $zf_sqlSelectIdentificationCode = Zf_QueryGenerator::BuildSQLSelect('ttv_applicationUsers', $zf_valueUserEmail, $zf_columnIdentificationCode);
                                        
                                        $zf_executeSelectIdentificationCode = $this->Zf_AdoDB->Execute($zf_sqlSelectIdentificationCode);
                                        
                                        if(!$zf_executeSelectIdentificationCode){
                                            
                                            echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
                                            
                                        }else{
                                            
                                            //Retrieve the encrypted identification code.
                                            $identificationCode = $zf_executeSelectIdentificationCode->fields['identificationCode'];
                                            
                                            Zf_SessionHandler::zf_setSessionVariable("ttv_identificationCode", $identificationCode);
                                            
                                            Zf_GenerateLinks::zf_header_location("platform_overview", "index", $identificationCode);
                                            
                                            exit();
                                            
                                        }
                                        
                                        
                                        
                                    }else{
                                        
                                        $zf_errorData = array( "zf_fieldName" => "password", "zf_errorMessage" => "* The password entered is invalid" );
                   
                                        //echo "The form has some errors which MUST be rectified"; //This is strictly for debugging purpose.
                                        Zf_FormController::zf_validateSpecificField($this->_validResult, $zf_errorData);
                                        Zf_GenerateLinks::zf_header_location('index', 'login');
                                        exit();
                                        
                                    }
                                    
                                }

                            }

                        }

                    }
                   
               }else{
                   
                   $zf_errorData = array( "zf_fieldName" => "email", "zf_errorMessage" => "* The email entered is invalid" );
                   
                   //echo "The form has some errors which MUST be rectified"; //This is strictly for debugging purpose.
                   Zf_FormController::zf_validateSpecificField($this->_validResult, $zf_errorData);
                   Zf_GenerateLinks::zf_header_location('index', 'login');
                   exit();
                   
               }
               
           }
           
           
          // print "<pre>";print_r($zf_executeQuery->GetRows()); print "</pre>"; //This is strictly for debugging purpose.
          
      }else{
          
          //echo "The form has some errors which MUST be rectified"; //This is strictly for debugging purpose.
           Zf_FormController::zf_validateGeneralForm($this->_validResult, $this->_errorResult);
           Zf_GenerateLinks::zf_header_location('index');
          
      }
              
        
    }
    
    
    //THIS METHOD DOES THE RESETTING OF ALL PASSWORDS
    public function processReset_password(){
        
      //echo "We are processing Resets"; exit();//This is strictly for debugging purposes
        
      $this->zf_formController->zf_postFormData('email')
                              ->zf_validateFormData('zf_maximumLength', 30, 'Your email')
                              ->zf_validateFormData('zf_minimumLength', 5, 'Your email')
                              ->zf_validateFormData('zf_checkEmail')
                              ->zf_validateFormData('zf_fieldNotEmpty', 'Email');
      
      $this->_errorResult = $this->zf_formController->zf_fetchErrorData();
      //echo'<pre>'; print_r($this->_errorResult); echo'<pre>';//exit(); //This is strictly for debugging purpose.
       
       
      $this->_validResult = $this->zf_formController->zf_fetchValidData();
      //echo'<pre>'; print_r($this->_validResult); echo'<pre>'; //exit(); //This is strictly for debugging purpose.
      
      if(empty($this->_errorResult)){
          
          //echo "The form has passed server side fields validation and now MUST be validated against the database";//This is strictly for debugging purpose
           
           foreach ($this->_validResult as $zf_fieldName => $zf_fieldValue) {
               
               if($zf_fieldName == 'email'){
                   
                   $zf_value[$zf_fieldName] = Zf_QueryGenerator::SQLValue($zf_fieldValue); 
                   
               }
               
           } 
           
           $zf_columnPassword = array('password', 'username');
           
           $zf_selectUserPassword = Zf_QueryGenerator::BuildSQLSelect('ttv_applicationUsers', $zf_value, $zf_columnPassword);
            
           $zf_executeSelectUserPassword = $this->Zf_AdoDB->Execute($zf_selectUserPassword);
           
           if(!$zf_executeSelectUserPassword){
               
               echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
               
           }else{
               
               if($zf_executeSelectUserPassword->RecordCount() > 0){
                   
                   //Here we generate a random password
                   $raw_password = Zf_Core_Functions::Zf_GeneratePassword(7, 8);
                   
                   $encoded_password = Zf_SecureData::zf_encode_data($raw_password);
                   
                   //Update the dbase with the encoded password.
                   $zf_valueUserPassword['password'] = Zf_QueryGenerator::SQLValue($encoded_password); 
                   $zf_columnUserEmail['email'] = Zf_QueryGenerator::SQLValue($this->_validResult['email']);
                   $zf_sqlUpdateUserPassword = Zf_QueryGenerator::BuildSQLUpdate('ttv_applicationUsers', $zf_valueUserPassword, $zf_columnUserEmail);
                   
                   $zf_executeUpdateUserPassword = $this->Zf_AdoDB->Execute($zf_sqlUpdateUserPassword);
                   
                   if(!$zf_executeUpdateUserPassword){
                       
                       echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";
                       
                   }else{
                       
                       //send email to the user showing the new password.
                       $zf_controller ="index";

                        $emailBody = '
                                        <html>
                                            <head></head>
                                            <body>

                                                <div style="
                                                    width:100%; min-height: 550px !important; background-color: #2f2f2f !important; color: #fff !important;
                                                    -webkit-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset; -moz-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
                                                    box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;border: 0px solid #fff; 
                                                    background-color: #2f2f2f; margin-top: 10px; height: auto;-moz-border-radius: 5px 5px 5px 5px; -webkit-border-radius: 5px 5px 5px 5px; border-radius: 5px 5px 5px 5px;
                                                ">
                                                    <div style="min-height: 60px !important; width: 100% !important; border: 0px solid #2f2f2f !important;">
                                                        <p>&nbsp;</p>
                                                    </div>
                                                    <div style="
                                                        border: 0px solid #fff; width: 96% !important; margin: 10px auto 10px auto !important; min-height: 350px; background-color: #1e1e1e;-moz-border-radius: 5px 5px 5px 5px; 
                                                        -webkit-border-radius: 5px 5px 5px 5px; border-radius: 5px 5px 5px 5px; font-family: PTSansRegular,sans-serif;font-size: 13px; color: #787878;
                                                    ">
                                                        <div style="border: 0px solid #fff;margin: 0px auto 0 auto !important; width: 98% !important;color: #999999 !important;">
                                                            <h2 style="padding-top: 20px !important;">Top Third Ventures Limited</h2>
                                                            <p>
                                                                Dear '.$zf_executeSelectUserPassword->fields['username'].',<br>
                                                            </p>
                                                            <div style="color: #999999 !important;">
                                                                <p>
                                                                    Thank you. Your password has successfully been reset and your new password is:
                                                                </p>
                                                                <p>
                                                                    <strong>'.$raw_password.'</strong>
                                                                </p>
                                                                <p>
                                                                    You can now login into your account using this link:<br>
                                                                     <a href="'.ZF_ROOT_PATH.$zf_controller.' " target="_blank">Login Here</a>
                                                                </p>
                                                                <p><br><br><br></p>
                                                                <p>
                                                                    Sincerely,<br />
                                                                    Top Third Ventures Platform Reporting
                                                                </p>
                                                            </div>
                                                        </div>	
                                                    </div>

                                                    <div style="
                                                        text-align:center !important;font-family: Cuprum,Arial,Helvetica,Sans-Serif;
                                                        font-size: 11px !important; color: #cbcbcb; padding: 10px; padding-top: 0px !important;
                                                    ">
                                                                    EMAIL: service@topthirdventures.com | PHONE: +254 (0) 700 428 252 <br>
                                                                    &copy; 2013, Top Third Ventures Global. All Rights Reserved.
                                                    </div>

                                                </div>

                                            </body>
                                    </html>                    

                                     ';

                        //echo "Insertion was successful."; exit();//This is strictly for debugging purposes.
                        $zf_mailElements = array(

                            "zf_senderName"    => "Top Third Ventures Limited", 
                            "zf_senderEmail"   => "service@topthirdventures.com",
                            "zf_mailAddresses" => array($this->_validResult['email']), 
                            "zf_replyAddress"  => "mathew@topthirdventures.com",//Can be left empty if not desired. 
                            "zf_mailSubject"   => "Password Reset", 
                            "zf_mailBody"      => $emailBody, 
                            "zf_mailType"      => "rich-html" //'rich-html' or 'plain-text'

                        );


                        Zf_SendEmails::zf_sendMail($zf_mailElements);

                        Zf_SessionHandler::zf_setSessionVariable("Account_Sign_Up", "reset_password");

                        Zf_GenerateLinks::zf_header_location("index","login");
                        exit();
                       
                   }
                   
               }else{
                   
                   $zf_errorData = array( "zf_fieldName" => "email", "zf_errorMessage" => "* The email entered is invalid" );
                   
                   //echo "The form has some errors which MUST be rectified"; //This is strictly for debugging purpose.
                   Zf_FormController::zf_validateSpecificField($this->_validResult, $zf_errorData);
                   Zf_GenerateLinks::zf_header_location('index', 'reset_password');
                   exit();
                   
               }
               
           }

          
      }else{
          
          //echo "The form has some errors which MUST be rectified"; //This is strictly for debugging purpose.
           Zf_FormController::zf_validateGeneralForm($this->_validResult, $this->_errorResult);
           Zf_GenerateLinks::zf_header_location('index', 'reset_password');
          
      }
              
        
    }
    
    
    //THIS METHOD DOES THE PROCESSING OF ALL SIGN UPs
    public function processSign_up(){
        
      //echo "We are processing sign ups"; exit();//This is strictly for debugging purposes
        
        $this->zf_formController->zf_postFormData('companySerial')
                                ->zf_validateFormData('zf_maximumLength', 30, 'Company Serial')
                                ->zf_validateFormData('zf_minimumLength', 5, 'Company Serial')
        
                                ->zf_postFormData('companyName')
                                ->zf_validateFormData('zf_maximumLength', 30, 'Company Name')
                                ->zf_validateFormData('zf_minimumLength', 5, 'Company Name')
        
                                ->zf_postFormData('companyEmail')
                                ->zf_validateFormData('zf_maximumLength', 30, 'Company Email')
                                ->zf_validateFormData('zf_minimumLength', 5, 'Company Email')
                                ->zf_validateFormData('zf_checkEmail')
        
                                ->zf_postFormData('companyAddress')
                                ->zf_validateFormData('zf_maximumLength', 30, 'Company Address')
                                ->zf_validateFormData('zf_minimumLength', 5, 'Company Address')
        
                                ->zf_postFormData('companyTelephone')
                                ->zf_validateFormData('zf_maximumLength', 30, 'Company Telephone')
                                ->zf_validateFormData('zf_minimumLength', 5, 'Company Telephone')
        
                                ->zf_postFormData('city')
                                ->zf_validateFormData('zf_maximumLength', 30, 'City')
                                ->zf_validateFormData('zf_minimumLength', 4, 'City')
        
                                ->zf_postFormData('country')
                                ->zf_validateFormData('zf_maximumLength', 2, 'Country')
                                ->zf_validateFormData('zf_minimumLength', 2, 'Country')
        
                                ->zf_postFormData('username')
                                ->zf_validateFormData('zf_maximumLength', 30, 'Username')
                                ->zf_validateFormData('zf_minimumLength', 5, 'Username')
        
                                ->zf_postFormData('email')
                                ->zf_validateFormData('zf_maximumLength', 30, 'Email')
                                ->zf_validateFormData('zf_minimumLength', 5, 'Email')
                                ->zf_validateFormData('zf_checkEmail')
                
                                ->zf_postFormData('mobile')
                                ->zf_validateFormData('zf_maximumLength', 30, 'Mobile No.')
                                ->zf_validateFormData('zf_minimumLength', 5, 'Mobile No.')
        
                                ->zf_postFormData('password')
                                ->zf_validateFormData('zf_maximumLength', 30, 'Password')
                                ->zf_validateFormData('zf_minimumLength', 5, 'Password')
        
                                ->zf_postFormData('rpassword')
                                ->zf_validateFormData('zf_maximumLength', 30, 'Re-Password')
                                ->zf_validateFormData('zf_minimumLength', 5, 'Re-Password');
                                

        
       $this->_errorResult = $this->zf_formController->zf_fetchErrorData();
       //echo'<pre>'; print_r($this->_errorResult); echo'<pre>';//exit(); //This is strictly for debugging purpose.
       
       
       $this->_validResult = $this->zf_formController->zf_fetchValidData();
       //echo'<pre>'; print_r($this->_validResult); echo'<pre>'; //exit(); //This is strictly for debugging purpose.
       
       if(empty($this->_errorResult)){
           
           //1.Check if the company is already registered
            $zf_companyValue['companySerial'] = Zf_QueryGenerator::SQLValue($this->_validResult['companySerial']);
            $zf_companyValue['companyEmail'] = Zf_QueryGenerator::SQLValue($this->_validResult['companyEmail']);
            
            $zf_companyColumns = array('companySerial', 'companyEmail');

            $zf_companySql = Zf_QueryGenerator::BuildSQLSelect('ttv_clientCompanies', $zf_companyValue, $zf_companyColumns);
            
            $zf_executeCompanyQuery = $this->Zf_AdoDB->Execute($zf_companySql);

            if (!$zf_executeCompanyQuery) {

                echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

            } else {
                
                if ($zf_executeCompanyQuery->RecordCount() > 0) {

                    $zf_errorData = array("zf_fieldName" => "company_serial", "zf_errorMessage" => "* This company serial is already registered.");
                    Zf_FormController::zf_validateSpecificField($this->_validResult, $zf_errorData);
                    Zf_GenerateLinks::zf_header_location('index', 'sign_up');
                    
                } else {
                    
                    //2.Check if the user is already registered.
                    $zf_userValue['username'] = Zf_QueryGenerator::SQLValue($this->_validResult['username']);
                    $zf_userValue['email'] = Zf_QueryGenerator::SQLValue($this->_validResult['email']);

                    $zf_userColumns = array('username', 'email');

                    $zf_userSql = Zf_QueryGenerator::BuildSQLSelect('ttv_applicationUsers', $zf_userValue, $zf_userColumns);
                     
                    $zf_executeUserQuery = $this->Zf_AdoDB->Execute($zf_userSql);
                    
                    if (!$zf_executeUserQuery) {

                        echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

                    } else {
                        
                        if($zf_executeUserQuery->RecordCount() > 0){
                            
                            $zf_errorData = array("zf_fieldName" => "username", "zf_errorMessage" => "* This username or email is already registered.");
                            Zf_FormController::zf_validateSpecificField($this->_validResult, $zf_errorData);
                            Zf_GenerateLinks::zf_header_location('index', 'sign_up');
                            
                        }else{
                            
                            //We now generate the identification code.
                            $identificationCode = Zf_SecureData::zf_encode_data($this->_validResult['country']."-".$this->_validResult['companySerial']."-".$this->_validResult['username']."-".$this->_validResult['email']."-".COMPANY_ADMIN);
                            
                            //Register the user and the company
                            foreach ($this->_validResult as $zf_fieldName => $zf_fieldValue) {
                           
                                if($zf_fieldName != 'rpassword'){

                                     if($zf_fieldName == 'username' || $zf_fieldName == 'email' || $zf_fieldName == 'mobile' || $zf_fieldName == 'password'){
                                         
                                         if($zf_fieldName == 'password'){                                
                                             $ttv_UserFields[$zf_fieldName] = Zf_QueryGenerator::SQLValue(Zf_SecureData::zf_encode_data($zf_fieldValue));                                          
                                         }
                                         else{
                                            $ttv_UserFields[$zf_fieldName] = Zf_QueryGenerator::SQLValue($zf_fieldValue);
                                         }

                                     }else if($zf_fieldName == 'companySerial' || $zf_fieldName == 'companyName' || $zf_fieldName == 'companyEmail' || $zf_fieldName == 'companyAddress' || $zf_fieldName == 'companyTelephone'){

                                         $ttv_CompanyFields[$zf_fieldName] = Zf_QueryGenerator::SQLValue($zf_fieldValue);

                                     }else if($zf_fieldName == 'country'){

                                         $ttv_CountryFields['countryCode'] = Zf_QueryGenerator::SQLValue($zf_fieldValue);

                                     }else if($zf_fieldName == 'city' || $zf_fieldName == 'country'){
                                         
                                         if($zf_fieldName == 'city'){
                                             
                                            $ttv_RegionFields["regionName"] = Zf_QueryGenerator::SQLValue($zf_fieldValue);
                                         
                                         }else if($zf_fieldName == 'country'){
                                             
                                            $ttv_RegionFields['countryCode'] = Zf_QueryGenerator::SQLValue($zf_fieldValue);
                                            
                                         }
                                         
                                     } 

                                }

                            }
                            
                            $ttv_UserFields['identificationCode'] = Zf_QueryGenerator::SQLValue($identificationCode);
                            
                            $ttv_CompanyFields['accountType'] = Zf_QueryGenerator::SQLValue('Trial');
                                     
                            $insertApplicationUser = Zf_QueryGenerator::BuildSQLInsert('ttv_applicationUsers', $ttv_UserFields);
                            //echo $insertApplicationUser."<br><br>";
                            $executeInsertApplicationUser = $this->Zf_AdoDB->Execute($insertApplicationUser);
                            
                            $insertApplicationCompany = Zf_QueryGenerator::BuildSQLInsert('ttv_clientCompanies', $ttv_CompanyFields);
                            //echo $insertApplicationCompany."<br><br>";
                            $executeInsertApplicationCompany = $this->Zf_AdoDB->Execute($insertApplicationCompany);
                            
                            $insertApplicationCountry = Zf_QueryGenerator::BuildSQLInsert('ttv_countries', $ttv_CountryFields);
                            //echo $insertApplicationCountry."<br><br>";
                            $executeInsertApplicationCountry = $this->Zf_AdoDB->Execute($insertApplicationCountry);
                            
                            $insertApplicationRegions = Zf_QueryGenerator::BuildSQLInsert('ttv_regions', $ttv_RegionFields);
                            //echo $insertRegions;
                            $executeInsertApplicationRegions = $this->Zf_AdoDB->Execute($insertApplicationRegions);
                            
                            if(!$executeInsertApplicationUser || !$executeInsertApplicationCompany || !$executeInsertApplicationCountry || !$executeInsertApplicationRegions){
                           
                                echo "<strong>Query Execution Failed:</strong> <code>" . $this->Zf_AdoDB->ErrorMsg() . "</code>";

                            }else{

                                $zf_controller ="index";
                                $zf_action ="activateSign_up";
                                $zf_parameter = Zf_SecureData::zf_encode_data($this->_validResult['email']);

                                $emailBody = '
                                                <html>
                                                    <head></head>
                                                    <body>

                                                        <div style="
                                                            width:100%; min-height: 550px !important; background-color: #2f2f2f !important; color: #fff !important;
                                                            -webkit-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset; -moz-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
                                                            box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;border: 0px solid #fff; 
                                                            background-color: #2f2f2f; margin-top: 10px; height: auto;-moz-border-radius: 5px 5px 5px 5px; -webkit-border-radius: 5px 5px 5px 5px; border-radius: 5px 5px 5px 5px;
                                                        ">
                                                            <div style="min-height: 60px !important; width: 100% !important; border: 0px solid #2f2f2f !important;">
                                                                <p>&nbsp;</p>
                                                            </div>
                                                            <div style="
                                                                border: 0px solid #fff; width: 96% !important; margin: 10px auto 10px auto !important; min-height: 350px; background-color: #1e1e1e;-moz-border-radius: 5px 5px 5px 5px; 
                                                                -webkit-border-radius: 5px 5px 5px 5px; border-radius: 5px 5px 5px 5px; font-family: PTSansRegular,sans-serif;font-size: 13px; color: #787878;
                                                            ">
                                                                <div style="border: 0px solid #fff;margin: 0px auto 0 auto !important; width: 98% !important;color: #999999 !important;">
                                                                    <h2 style="padding-top: 20px !important;">Top Third Ventures Limited</h2>
                                                                    <p>
                                                                        Dear '.$this->_validResult['username'].',<br>
                                                                    </p>
                                                                    <div style="color: #999999 !important;">
                                                                        <p>
                                                                            Thank you for subscribing to the Top Third Ventures demo account.
                                                                        </p>
                                                                        <p>
                                                                            You cannot access your demo account until it is activated. To activate
                                                                            your email address, click on this link: <a href="'.ZF_ROOT_PATH.$zf_controller.DS.$zf_action.DS.$zf_parameter.' " target="_blank">Confirm your email account here</a>
                                                                        </p>
                                                                        <p><br><br><br></p>
                                                                        <p>
                                                                            Sincerely,<br />
                                                                            Top Third Ventures Platform Reporting
                                                                        </p>
                                                                    </div>
                                                                </div>	
                                                            </div>

                                                            <div style="
                                                                text-align:center !important;font-family: Cuprum,Arial,Helvetica,Sans-Serif;
                                                                font-size: 11px !important; color: #cbcbcb; padding: 10px; padding-top: 0px !important;
                                                            ">
                                                                            EMAIL: service@topthirdventures.com | PHONE: +254 (0) 700 428 252 <br>
                                                                            &copy; 2013, Top Third Ventures Global. All Rights Reserved.
                                                            </div>

                                                        </div>

                                                    </body>
                                            </html>                    

                                             ';

                                //echo "Insertion was successful."; exit();//This is strictly for debugging purposes.
                                $zf_mailElements = array(

                                    "zf_senderName"    => "Top Third Ventures Limited", 
                                    "zf_senderEmail"   => "service@topthirdventures.com",
                                    "zf_mailAddresses" => array($this->_validResult['email']), 
                                    "zf_replyAddress"  => "mathew@topthirdventures.com",//Can be left empty if not desired. 
                                    "zf_mailSubject"   => "Thank you for your subscription", 
                                    "zf_mailBody"      => $emailBody, 
                                    "zf_mailType"      => "rich-html" //'rich-html' or 'plain-text'

                                );


                                Zf_SendEmails::zf_sendMail($zf_mailElements);

                                Zf_SessionHandler::zf_setSessionVariable("Account_Sign_Up", "signed_up");

                                Zf_GenerateLinks::zf_header_location("index","sign_up");

                            }
                            
                        }
                        
                    }
                    
                }
                
            } 
           
       }else{
           
           //echo "The form has some errors which MUST be rectified"; exit(); //This is strictly for debugging purpose.
           Zf_FormController::zf_validateGeneralForm($this->_validResult, $this->_errorResult);
           Zf_GenerateLinks::zf_header_location('index','sign_up');
           
       }
        
    }
    
    
    

}

?>
