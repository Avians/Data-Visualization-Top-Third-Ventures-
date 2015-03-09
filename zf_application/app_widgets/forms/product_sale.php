<form action="#" class="form-horizontal" id="submit_form">
    <div class="form-wizard">
        <div class="navbar steps">
            <div class="navbar-inner">
                <ul class="row-fluid">
                    <li class="span3">
                        <a href="#tab1" data-toggle="tab" class="step ">
                            <span class="number">1</span>
                            <span class="desc"><i class="icon-ok"></i> Product Data</span>   
                        </a>
                    </li>
                    <li class="span3">
                        <a href="#tab2" data-toggle="tab" class="step">
                            <span class="number">2</span>
                            <span class="desc"><i class="icon-ok"></i> Personal Data</span>   
                        </a>
                    </li>
                    <li class="span3">
                        <a href="#tab3" data-toggle="tab" class="step active">
                            <span class="number">3</span>
                            <span class="desc"><i class="icon-ok"></i> More Information</span>   
                        </a>
                    </li>
                    <li class="span3">
                        <a href="#tab4" data-toggle="tab" class="step">
                            <span class="number">4</span>
                            <span class="desc"><i class="icon-ok"></i> Confirm Data</span>   
                        </a> 
                    </li>
                </ul>
            </div>
        </div>
        
        <!--End of the progress bar -->
        <div id="bar" class="progress progress-success progress-striped">
            <div class="bar"></div>
        </div>
        <!--End of the progress bar -->
        
        <div class="tab-content">
            <!-- Start of alerts -->
            <div class="alert alert-error hide">
                <button class="close" data-dismiss="alert"></button>
                You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
                <button class="close" data-dismiss="alert"></button>
                Your form validation is successful!
            </div>
            <!-- End of alerts -->
            
            <!-- Start of tabbed content 1 -->
            <div class="tab-pane active" id="tab1">
                <h3 class="block">Enter the correct product details</h3>
                <div class="control-group">
                    <label class="control-label">Voucher No.<span class="required">*</span></label>
                    <div class="controls">
                        <input type="text" class="span6 m-wrap" name="voucher"/>
                        <span class="help-inline">Provide voucher number</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Product Serial<span class="required">*</span></label>
                    <div class="controls">
                        <input type="text" class="span6 m-wrap" name="productSerial" id="submit_form_password"/>
                        <span class="help-inline">Provide product serial</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Amount Paid<span class="required">*</span></label>
                    <div class="controls">
                        <input type="text" class="span6 m-wrap" name="productAmount"/>
                        <span class="help-inline">Enter amount paid</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Purchase Reason<span class="required">*</span></label>
                    <div class="controls">
                        <input type="text" class="span6 m-wrap" name="purchaseReason"/>
                        <span class="help-inline">What's your purchase reason</span>
                    </div>
                </div>
            </div>
            <!-- End of tabbed content  1-->
            
            <!-- Start of tabbed content 2 -->
            <div class="tab-pane" id="tab2">
                <h3 class="block">Provide your profile details</h3>
                <div class="control-group">
                    <label class="control-label">First Name<span class="required">*</span></label>
                    <div class="controls">
                        <input type="text" class="span6 m-wrap" name="firstName"/>
                        <span class="help-inline">Provide your fullname</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Middle Name<span class="required">*</span></label>
                    <div class="controls">
                        <input type="text" class="span6 m-wrap" name="middleName"/>
                        <span class="help-inline">Provide your fullname</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Surname Name<span class="required">*</span></label>
                    <div class="controls">
                        <input type="text" class="span6 m-wrap" name="lastName"/>
                        <span class="help-inline">Provide your fullname</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Id Number<span class="required">*</span></label>
                    <div class="controls">
                        <input type="text" class="span6 m-wrap" name="nationalId"/>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Mobile Number<span class="required">*</span></label>
                    <div class="controls">
                        <input type="text" class="span6 m-wrap" name="mobileNo"/>
                        <span class="help-inline">Provide your phone number</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Gender<span class="required">*</span></label>
                    <div class="controls">
                        <label class="radio">
                            <input type="radio" name="gender" value="Male" data-title="Male" />
                            Male
                        </label>
                        <label class="radio">
                            <input type="radio" name="gender" value="Female" data-title="Female"/>
                            Female
                        </label>  
                        <div id="form_gender_error"></div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Age Bracket<span class="required">*</span></label>
                    <div class="controls">
                        <input type="text" class="span6 m-wrap" name="ageBracket" />
                        <span class="help-inline">Provide your street address</span>
                    </div>
                </div>
            </div>
            <!-- End of tabbed content 2 -->
            
            <div class="tab-pane" id="tab3">
                <h3 class="block">Enter a detailed information about the customer</h3>
                <div class="control-group">
                    <label class="control-label">Marital Status</label>
                    <div class="controls">
                        <select name='maritalStatus' class="span6 select_marital" data-placeholder="Marital Status" tabindex="1">
                            <option value=""></option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Widowed">Widowed</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Education Level</label>
                    <div class="controls">
                        <select name='educationLevel' class="span6 select_education" data-placeholder="Education Level" tabindex="1">
                            <option value=""></option>
                            <option value="None">None</option>
                            <option value="Primary">Primary</option>
                            <option value="Secondary">Secondary</option>
                            <option value="Diploma">Diploma</option>
                            <option value="Industry">University</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Occupation</label>
                    <div class="controls">
                        <select name='occupation' class="span6 select_occupation" data-placeholder="Occupation" tabindex="1">
                            <option value=""></option>
                            <option value="Farmer">Farmer</option>
                            <option value="Shop Owner">Shop Owner</option>
                            <option value="Professional">Professional</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="tab-pane" id="tab4">
                <h3 class="block">Confirm your Data</h3>
                
                <h4 class="form-section">Product Data</h4>
                <div class="control-group">
                    <label class="control-label">Voucher Number:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="voucher"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Product Serial:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="productSerial"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Amount Paid:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="productAmount"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Reason for Purchase:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="purchaseReason"></span>
                    </div>
                </div>
                
                
                <h4 class="form-section">Personal Data</h4>
                <div class="control-group">
                    <label class="control-label">First Name:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="firstName"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Middle Name:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="middleName"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Last Name:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="lastName"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">National Id:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="nationalId"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Mobile No:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="mobileNo"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Gender:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="gender"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Age Bracket:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="ageBracket"></span>
                    </div>
                </div>
                
                
                <h4 class="form-section">More Information</h4>
                <div class="control-group">
                    <label class="control-label">Marital Status:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="maritalStatus"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Education Level:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="educationLevel"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Occupation</label>
                    <div class="controls">
                        <span class="text display-value" data-display="occupation"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Monthly Income:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="monthlyIncome"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Total Benefactors:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="totalBenefactors"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Total Children:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="totalChildren"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Children Under 5:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="childrenUnderFive"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Country:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="country"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Region/Town:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="region"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Location:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="location"></span>
                    </div>
                </div>
                
                
                <h4 class="form-section">Billing</h4>
                <div class="control-group">
                    <label class="control-label">Card Holder Name:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="card_name"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Card Number:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="card_number"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">CVC:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="card_cvc"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Expiration:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="card_expiry"></span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Payment Options:</label>
                    <div class="controls">
                        <span class="text display-value" data-display="payment"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions clearfix">
            <a href="javascript:;" class="btn button-previous">
                <i class="m-icon-swapleft"></i> Back 
            </a>
            <a href="javascript:;" class="btn blue button-next">
                Continue <i class="m-icon-swapright m-icon-white"></i>
            </a>
            <a href="javascript:;" class="btn green button-submit">
                Submit <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
</form>
<script typr="text/javascript">
$(document).ready(function() {
    
    //Here we are generating the applications absolute path.
    var $absolute_path = "<?php echo APPLICATION_FOLDER; ?>";
    
    FormWizard.init($absolute_path );
    FormSelect.init();
    
});
</script>