var FormSelect = function () {


    return {
        //main function to initiate the module
        init: function () {

            // use select2 dropdown instead of chosen as select2 works fine with bootstrap on responsive layouts.
            $('.select_marital').select2({
	            placeholder: "Select your marital Status",
	            allowClear: true
            });
            // use select2 dropdown instead of chosen as select2 works fine with bootstrap on responsive layouts.
            $('.select_education').select2({
	            placeholder: "Select your education status",
	            allowClear: true
            });
            // use select2 dropdown instead of chosen as select2 works fine with bootstrap on responsive layouts.
            $('.select_occupation').select2({
	            placeholder: "Select your occupation",
	            allowClear: true
            });
            // use select2 dropdown instead of chosen as select2 works fine with bootstrap on responsive layouts.
            $('.select_income').select2({
	            placeholder: "Select your annual income",
	            allowClear: true
            });
            
            

        }

    };

}();