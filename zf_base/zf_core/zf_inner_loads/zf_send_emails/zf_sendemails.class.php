<?php

/**
 * -----------------------------------------------------------------------------
 * THIS CLASS FILE IS ESSENTIAL FOR ENSURING THAT EMAILS ARE SENT CORRECTLY TO
 * THE INTENDED PERSONS. IT IMPLEMENTS THE PHP MAILER CLASS TO ENSURE THAT THE
 * MAILING PROCESS IS ROBUST.
 * -----------------------------------------------------------------------------
 *
 * @author Mathew Juma O. (ATHIAS AVIANS) <mathew@headsafrica.com>
 * @time  6th/January/2013  Time: 13:00 EMT
 * @link http://www.zilasframework.com/
 * @copyright Copyright &copy; 2013 Zilas Software LLC
 * @license http://www.zilasframework.com/license/
 * @version 1.01 Final
 * @since version 1.01 Final - 11th/August/2013
 * 
 */

class Zf_SendEmails extends PHPMailer {

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
     * THIS IS STATIC METHOD THAT ENSURES THE SENDING OF PLAIN EMAILS WITHOUT
     * HTML ELEMENTS. 
     * -------------------------------------------------------------------------
     */
    public static function zf_sendMail($zf_mailElements = NULL){
        
        if(empty($zf_mailElements) || $zf_mailElements == NULL || !is_array($zf_mailElements)){
            
            echo "<code><strong>HTML Mail Error:</strong> Missing Mail Elements</code> "; exit();
            
        }else{
            
            //An instance of the PHP Mailer class
            $mailer = new PHPMailer();
            
            
            /**
             * Here we include the array that contains the configurations for
             * the SMTP Mail server.
             */
            $zf_smtpSetting = Zf_Configurations::Zf_SmtpSettings();
            
            if($zf_smtpSetting['zf_smtpServer'] == 'enabled'){
                
                $mailer->IsSMTP();
                $mailer->Host     = $zf_smtpSetting['zf_smtpHost'];
                $mailer->SMTPAuth = $zf_smtpSetting['zf_smtpAuth'];
                $mailer->Username = $zf_smtpSetting['zf_smtpUsername'];
                $mailer->Password = $zf_smtpSetting['zf_smtpPassword'];
                
            }
        
            $mailer->From = $zf_mailElements['zf_senderEmail'];
            
            //This is the name of the sender section
            $mailer->FromName = $zf_mailElements['zf_senderName'];
            
            //This is the email sender section
            $mailer->Sender = ($zf_mailElements['zf_senderEmail']);
            
            //This is the email to be replyed to section
            
            if(!empty($zf_mailElements['zf_replyAddress'])){
            
                $mailer->AddReplyTo($zf_mailElements['zf_replyAddress'], "{$zf_mailElements['zf_senderName']} - Reply");
            
            }
            
            //This is the recieving addresses section
            foreach ($zf_mailElements['zf_mailAddresses'] as $zf_emails) {
                
                $mailer->AddAddress($zf_emails);
                
            }
            
            //This is the mail subject section
            $mailer->Subject = $zf_mailElements['zf_mailSubject'];
            
            //This is the mail body section
            $htmlBody = $zf_mailElements['zf_mailBody'];
            
            /**
             * This handles the email type section
             */
            if($zf_mailElements['zf_mailType'] == 'plain-text'){
               
                $mailer->IsHTML(false);
                $mailer->AltBody = $htmlBody;
                
            }else if($zf_mailElements['zf_mailType'] == 'rich-html'){
                
                $mailer->IsHTML(true);
                $mailer->Body = $htmlBody;
                
            }
           

            if (!$mailer->Send()) {

                //echo "Error sending: " . $mailer->ErrorInfo; exit();

            } else {

                //echo "Email has been is sent successfully!!";

            }
            
        }
        
    }
    
}
?>
