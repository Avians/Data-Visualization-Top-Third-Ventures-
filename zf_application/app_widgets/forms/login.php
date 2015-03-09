<form class="form-vertical login-form" action="<?php Zf_GenerateLinks::basic_internal_link("index", "processGuestUser", "login"); ?>" method="post">
    <h3 class="form-title">Login to your account</h3>
    <div class="alert alert-error hide">
        <button class="close" data-dismiss="alert"></button>
        <span>Enter your email and password.</span>
    </div>
    <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-envelope"></i>
                <input class="m-wrap placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" value="<?php echo $zf_formHandler->zf_getFormValue("email"); ?>" />
            </div>
        </div>
        <div class="controls server-side-error">
            <?php echo $zf_formHandler->zf_getFormError("email") ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-lock"></i>
                <input class="m-wrap placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" value="<?php echo $zf_formHandler->zf_getFormValue("password"); ?>"/>
            </div>
        </div>
        <div class="controls server-side-error">
            <?php echo $zf_formHandler->zf_getFormError("password") ?>
        </div>
    </div>
    <div class="form-actions">
        <label class="checkbox">
            <input type="checkbox" name="remember" value="1"/> Remember me
        </label>
        <button type="submit" class="btn blue pull-right">
            Login <i class="m-icon-swapright m-icon-white"></i>
        </button>            
    </div>
    <div class="forget-password">
        <h4>Forgot your password ?</h4>
        <p>
            <?php
            $reset_pass = array(
                'name' => 'here',
                'controller' => 'index',
                'action' => 'reset_password',
                'parameter' => '',
                'title' => '',
                'style' => '',
                'id' => 'forget-password'
            );
            ?>
            Click <?php Zf_GenerateLinks::zf_internal_link($reset_pass) ?>
            to reset your password.
        </p>
    </div>
    <div class="create-account">
        <p>
            Don't have a <font color="white">demo</font> account yet ?&nbsp; 
            <?php
            $sign_up = array(
                'name' => 'Sign up',
                'controller' => 'index',
                'action' => 'sign_up',
                'parameter' => '',
                'title' => '',
                'style' => '',
                'id' => 'register-btn'
            );


            Zf_GenerateLinks::zf_internal_link($sign_up);
            ?>

        </p>
    </div>
</form>
<?php
    Zf_SessionHandler::zf_unsetSessionVariable("zf_valueArray");
    Zf_SessionHandler::zf_unsetSessionVariable("zf_errorArray");
?>