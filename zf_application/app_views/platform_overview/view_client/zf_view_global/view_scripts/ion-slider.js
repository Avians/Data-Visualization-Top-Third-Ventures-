/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var IonSliders = function () {
   
    return {
        
        //This returns the age bracket filter section.
        ageBracket: function ($absolute_path, $separator) {
            
            var url = $absolute_path + "platform_overview" + $separator + "GenderInformationProcessor" + $separator;
            //alert($absolute_path + "I am home");

            //This controls the gender chart.
            $("#genderSlider").ionRangeSlider({
                min: 0,
                max: 100,
                from: 0,
                to: 100,
                type: 'double',
                step: 1,
                postfix: "yrs",
                prettify: true,
                hasGrid: false,
                onChange: function(obj) {        // function-callback, is called on every change
                    //console.log(obj);
                    var data = $('#genderSlider').serialize();

                    $.ajax({
                        type: "POST",
                        url: url + "ageBracket",
                        data: data,
                        cache: false,
                        success: function(html) {
                            $("#genderChart").html(html);
                        }
                    });
                    
                }
            });
    
        },
        
        //This returns the gender ration filter section.
        genderRatio: function ($absolute_path, $separator) {
            
            var url = $absolute_path + "platform_overview" + $separator + "AgeInformationProcessor" + $separator;
            
                var urlInitial = url + 'genderFilter';
                
                
                $("#ageChart").load(urlInitial+"_all", function(response, status, xhr) {
                    
                    if (status == "success"){
                        
                        $("#ageChart").html(html);
                        
                    }   
                    if (status == "error"){
                        
                        $("#ageChart").html("No data found");
                        
                    }
                });
                
                
                $("input:radio[name='genderFilter']").click(function(){
                    
                    var genderFilter = $(this).val();
                    //alert(genderFilter);
                    
                    //var data = $('#ageFilter').serialize();
                    
                    $.ajax({
                        type: "POST",
                        url: url + "ganderFilter_"+genderFilter,
                        data: $(this).val(),
                        cache: false,
                        success: function(html) {
                           $("#ageChart").html(html);
                        }
                    });
                    
                });
    
        },
        
        //This returns the education ration filter section.
        educationLevel: function ($absolute_path, $separator) {
            
            var url = $absolute_path + "platform_overview" + $separator + "EducationInformationProcessor" + $separator;
            
                var urlInitial = url + 'educationFilter';
                
                //alert(urlInitial);
                
                $("#educationChart").load(urlInitial+"_all", function(response, status, xhr) {
                    
                    if (status == "success"){
                        
                        $("#educationChart").html(html);
                        
                    }   
                    if (status == "error"){
                        
                        $("#educationChart").html("No data found");
                        
                    }
                });
                
                
                $("input:radio[name='educationFilter']").click(function(){
                    
                    var educationFilter = $(this).val();
                    //alert(genderFilter);
                    
                    //var data = $('#ageFilter').serialize();
                    
                    $.ajax({
                        type: "POST",
                        url: url + "edcucationFilter_"+ educationFilter ,
                        data: $(this).val(),
                        cache: false,
                        success: function(html) {
                           $("#educationChart").html(html);
                        }
                    });
                    
                });
    
        },
        
        //This returns the marital status filter section.
        maritalStatus: function ($absolute_path, $separator) {
            
            var url = $absolute_path + "platform_overview" + $separator + "MaritalInformationProcessor" + $separator;
            //alert($absolute_path + "I am home");

            //This controls the gender chart.
            $("#maritalSlider").ionRangeSlider({
                min: 0,
                max: 100,
                from: 0,
                to: 100,
                type: 'double',
                step: 1,
                postfix: "yrs",
                prettify: true,
                hasGrid: false,
                onChange: function(obj) {        // function-callback, is called on every change
                    //console.log(obj);
                    var data = $('#maritalSlider').serialize();

                    $.ajax({
                        type: "POST",
                        url: url + "ageBracket",
                        data: data,
                        cache: false,
                        success: function(html) {
                            $("#maritalChart").html(html);
                        }
                    });
                    
                }
            });
    
        },
        
        //This returns the education ration filter section.
        occupation: function ($absolute_path, $separator) {
            
            var url = $absolute_path + "platform_overview" + $separator + "OccupationInformationProcessor" + $separator;
            
                var urlInitial = url + 'occupationFilter';
                
                //alert(urlInitial);
                
                $("#occupationChart").load(urlInitial+"_all", function(response, status, xhr) {
                    
                    if (status == "success"){
                        
                        $("#occupationChart").html(html);
                        
                    }   
                    if (status == "error"){
                        
                        $("#occupationChart").html("No data found");
                        
                    }
                });
                
                
                $("input:radio[name='occupationFilter']").click(function(){
                    
                    var educationFilter = $(this).val();
                    //alert(genderFilter);
                    
                    //var data = $('#ageFilter').serialize();
                    
                    $.ajax({
                        type: "POST",
                        url: url + "occupationFilter_"+ educationFilter ,
                        data: $(this).val(),
                        cache: false,
                        success: function(html) {
                           $("#occupationChart").html(html);
                        }
                    });
                    
                });
    
        },
        
        //This returns the annual income filter section.
        annualIncome: function ($absolute_path, $separator) {
            
            var url = $absolute_path + "platform_overview" + $separator + "IncomeInformationProcessor" + $separator;
            //alert($absolute_path + "I am home");

            //This controls the gender chart.
            $("#incomeSlider").ionRangeSlider({
                min: 0,
                max: 100,
                from: 0,
                to: 100,
                type: 'double',
                step: 1,
                postfix: "yrs",
                prettify: true,
                hasGrid: false,
                onChange: function(obj) {        // function-callback, is called on every change
                    //console.log(obj);
                    var data = $('#incomeSlider').serialize();

                    $.ajax({
                        type: "POST",
                        url: url + "ageBracket",
                        data: data,
                        cache: false,
                        success: function(html) {
                            $("#incomeChart").html(html);
                        }
                    });
                    
                }
            });
    
        }
        
    };
   

}();



