<form class="form-vertical forget-form" action="<?php Zf_GenerateLinks::basic_internal_link("index", "processGuestUser", "reset_password"); ?>" method="post">
    <h3 >Forget Password ?</h3>
    <p>Enter your e-mail address below to reset your password.</p>
    <div class="control-group">
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-envelope"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" autocomplete="off" name="email" value="<?php echo $zf_formHandler->zf_getFormValue("email"); ?>" />
            </div>
        </div>
        <div class="controls server-side-error">
            <?php echo $zf_formHandler->zf_getFormError("email") ?>
        </div>
    </div>
    <div class="form-actions">
        <a href="<?php Zf_GenerateLinks::basic_internal_link('index'); ?>">
            <button type="button"  class="btn">
                <i class="m-icon-swapleft" ></i> Back
            </button>
        </a>
        <button type="submit" class="btn blue pull-right">
            Submit <i class="m-icon-swapright m-icon-white"></i>
        </button>            
    </div>
</form>
<?php
    Zf_SessionHandler::zf_unsetSessionVariable("zf_valueArray");
    Zf_SessionHandler::zf_unsetSessionVariable("zf_errorArray");
?>
