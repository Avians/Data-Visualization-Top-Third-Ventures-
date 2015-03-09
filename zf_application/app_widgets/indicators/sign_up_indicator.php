<div class="row-fluid">
    <div class="container-fluid">
        <?php if(Zf_SessionHandler::zf_getSessionVariable('Account_Sign_Up') == 'signed_up'){ ?>
            <div class="span12 alert alert-success action-indicators success-fadeout">
                <p><i class="icon-thumbs-up"></i>&nbsp;&nbsp;Thank you for subscribing to try our demo platform. A confirmation email has been sent to you!!</p>  
            </div>
        <?php
        }else if(Zf_SessionHandler::zf_getSessionVariable('Account_Sign_Up') == 'reset_password'){
        ?>
            <div class="span12 alert alert-info action-indicators info-fadeout">
                <p><i class="icon-thumbs-down"></i>&nbsp;&nbsp;Thank you. Your new password has been sent to your email.</p>  
            </div>
        <?php
        } else if(Zf_SessionHandler::zf_getSessionVariable('Account_Sign_Up') == 'confirmed_email'){
        ?>
            <div class="span12 alert alert-success action-indicators  success-fadeout">
                <p><i class="icon-thumbs-up"></i>&nbsp;&nbsp;Thank you for confirming your email account. You can now login into your dashboard.</p>  
            </div>
        <?php 
        } else if(Zf_SessionHandler::zf_getSessionVariable('Account_Sign_Up') == 'need_to_confirm'){
        ?>
            <div class="span12 alert alert-error action-indicators error-fadeout">
                <p><i class="icon-warning-sign"></i>&nbsp;&nbsp;You account is not yet active. Please activate from your provided email.</p>  
            </div>
        <?php 
        }
        Zf_SessionHandler::zf_unsetSessionVariable("Account_Sign_Up");
        ?>
    </div>
</div>
