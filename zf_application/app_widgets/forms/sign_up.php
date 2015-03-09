<!-- BEGIN REGISTRATION FORM -->
<form class="form-vertical register-form" action="<?php Zf_GenerateLinks::basic_internal_link("index", "processGuestUser", "sign_up"); ?>" method="post">
    <h3 >Sign Up</h3>
    <p>Enter your company details below:</p>
    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Company Name</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-font"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="Company Name" name="companyName" value="<?php echo $zf_formHandler->zf_getFormValue("companyName"); ?>"/>
            </div>
        </div>
        <div class="controls server-side-error">
            <?php echo $zf_formHandler->zf_getFormError("companyName") ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Company Serial</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-barcode"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="Company Serial" name="companySerial" value="<?php echo $zf_formHandler->zf_getFormValue("companySerial"); ?>"/>
            </div>
        </div>
        <div class="controls server-side-error">
            <?php echo $zf_formHandler->zf_getFormError("companySerial") ?>
        </div>
    </div>
    <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Company Email</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-envelope"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="Company Email" name="companyEmail" value="<?php echo $zf_formHandler->zf_getFormValue("companyEmail"); ?>"/>
            </div>
        </div>
        <div class="controls server-side-error">
            <?php echo $zf_formHandler->zf_getFormError("companyEmail") ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Address</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-ok"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="Company Address" name="companyAddress" value="<?php echo $zf_formHandler->zf_getFormValue("companyAddress"); ?>"/>
            </div>
        </div>
        <div class="controls server-side-error">
            <?php echo $zf_formHandler->zf_getFormError("companyAddress") ?>
        </div>
    </div>
    <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Telephone</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-phone"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="Telephone" name="companyTelephone" value="<?php echo $zf_formHandler->zf_getFormValue("companyTelephone"); ?>"/>
            </div>
        </div>
        <div class="controls server-side-error">
            <?php echo $zf_formHandler->zf_getFormError("companyTelephone") ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">City/Town</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-location-arrow"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="City/Town" name="city" value="<?php echo $zf_formHandler->zf_getFormValue("city"); ?>"/>
            </div>
        </div>
        <div class="controls server-side-error">
            <?php echo $zf_formHandler->zf_getFormError("city") ?>
        </div>
    </div>
    <div class="control-group">
        <div class="row-fluid">
            <label class="control-label visible-ie8 visible-ie9">Country</label>
            <div class="controls">
                <select name="country" id="select2_sample4" class="span12 select2" value="<?php echo $zf_formHandler->zf_getFormValue("country"); ?>">
                    <?php
                         $zf_widgetFolder = "forms"; $zf_widgetFile = "contries_select.php";
                         Zf_ApplicationWidgets::zf_load_widget($zf_widgetFolder, $zf_widgetFile);
                    ?>
                </select>
            </div>
            <div class="controls server-side-error">
                <?php echo $zf_formHandler->zf_getFormError("country"); ?>
            </div>
        </div>
    </div>
    <p>Enter your personal account details below:</p>
    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Username</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-user"></i>
                <input class="m-wrap placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" value="<?php echo $zf_formHandler->zf_getFormValue("username"); ?>"/>
            </div>
        </div>
        <div class="controls server-side-error">
            <?php echo $zf_formHandler->zf_getFormError("username") ?>
        </div>
    </div>
    <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-envelope"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="Personal Email" name="email" value="<?php echo $zf_formHandler->zf_getFormValue("email"); ?>"/>
            </div>
        </div>
        <div class="controls server-side-error">
            <?php echo $zf_formHandler->zf_getFormError("email") ?>
        </div>
    </div>
    <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Mobile</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-mobile-phone"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="Mobile" name="mobile" value="<?php echo $zf_formHandler->zf_getFormValue("mobile"); ?>"/>
            </div>
        </div>
        <div class="controls server-side-error">
            <?php echo $zf_formHandler->zf_getFormError("mobile") ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-lock"></i>
                <input class="m-wrap placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password" value="<?php echo $zf_formHandler->zf_getFormValue("password"); ?>"/>
            </div>
        </div>
        <div class="controls server-side-error">
            <?php echo $zf_formHandler->zf_getFormError("password") ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-ok"></i>
                <input class="m-wrap placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="rpassword" value="<?php echo $zf_formHandler->zf_getFormValue("rpassword"); ?>"/>
            </div>
        </div>
        <div class="controls server-side-error">
            <?php echo $zf_formHandler->zf_getFormError("rpassword") ?>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <label class="checkbox">
                <input type="checkbox" name="tnc"/> I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
            </label>  
            <div id="register_tnc_error"></div>
        </div>
    </div>
    <div class="form-actions">
        <a href="<?php Zf_GenerateLinks::basic_internal_link('index'); ?>" >
            <button id="register-back-btn" type="button" class="btn">
                <i class="m-icon-swapleft"></i>  Back
            </button>
        </a>
        <button type="submit" id="register-submit-btn" class="btn green pull-right">
            Sign Up <i class="m-icon-swapright m-icon-white"></i>
        </button>            
    </div>
</form>
<!-- END REGISTRATION FORM -->
<?php
    Zf_SessionHandler::zf_unsetSessionVariable("zf_valueArray");
    Zf_SessionHandler::zf_unsetSessionVariable("zf_errorArray");
?>
