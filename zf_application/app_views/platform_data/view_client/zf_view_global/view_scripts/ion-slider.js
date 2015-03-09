/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var ChartDrawer = function () {
 
        //This controls the all the gender section chart
        var genderCharts = function ($absolute_path, $separator) {
            
            var ageChart = $absolute_path + "platform_data" + $separator + "GenderChartDrawer" + $separator;
            var maritalChart = $absolute_path + "platform_data" + $separator + "GenderChartDrawer" + $separator;
            var educationChart = $absolute_path + "platform_data" + $separator + "GenderChartDrawer" + $separator;
            var occupationChart = $absolute_path + "platform_data" + $separator + "GenderChartDrawer" + $separator;
            var incomeChart = $absolute_path + "platform_data" + $separator + "GenderChartDrawer" + $separator;
            
            var gender = $("#gender").val();
            
            $("#genderSlider").ionRangeSlider({
                min: 0,
                max: 100,
                type: 'double',
                step: 1,
                postfix: "yrs",
                prettify: true,
                hasGrid: false,
                onChange: function(obj) {        // function-callback, is called on every change
                    
                    var ageBracket = $("#genderSlider").val();
                    
                    //post to age chart
                    $.ajax({
                        type: "POST",
                        url: ageChart + "ageDistribution",
                        data: {gender: gender, ageBracket: ageBracket},
                        cache: false,
                        success: function(html) {
                           $("#ageChart").html(html);
                        }
                    });
                    
                    //post to marital chart
                    $.ajax({
                        type: "POST",
                        url: maritalChart + "maritalStatus",
                        data: {gender: gender, ageBracket: ageBracket},
                        cache: false,
                        success: function(html) {
                           $("#maritalChart").html(html);
                        }
                    });
                    
                    //post to education chart
                    $.ajax({
                        type: "POST",
                        url: educationChart + "educationLevel",
                        data: {gender: gender, ageBracket: ageBracket},
                        cache: false,
                        success: function(html) {
                           $("#educationChart").html(html);
                        }
                    });
                    
                    //post to occupation chart
                    $.ajax({
                        type: "POST",
                        url: occupationChart + "occupation",
                        data: {gender: gender, ageBracket: ageBracket},
                        cache: false,
                        success: function(html) {
                           $("#occupationChart").html(html);
                        }
                    });
                    
                    //post to income chart
                    $.ajax({
                        type: "POST",
                        url: incomeChart + "annualIncome",
                        data: {gender: gender, ageBracket: ageBracket},
                        cache: false,
                        success: function(html) {
                           $("#incomeChart").html(html);
                        }
                    });
                    
                }
            });
    
        }
        
        //This controls the all age brackets section charts
        var ageCharts = function ($absolute_path, $separator){
            
            var ageChart = $absolute_path + "platform_data" + $separator + "AgeChartDrawer" + $separator;
            
            var uncleanAgesBracket = $("#ageBracket").val();
            //var ageBracket = $("#ageBracket").val();
            var ageBracket = uncleanAgesBracket.replace(/\s+/g, '');
            var activeGender = $("#activeGender").val();
            var initial_url_param = ageBracket + "_" + activeGender;
            
            //Gender chart
            $("#genderChart").load(ageChart + initial_url_param + "_genderRatio", function(response, status, xhr) {    
                if (status == "success"){ $("#genderChart").html(html); }   
                if (status == "error"){ $("#genderChart").html("No data found"); }
            });
            
            //Marital chart
            $("#maritalChart").load(ageChart + initial_url_param + "_maritalStatus", function(response, status, xhr) {    
                if (status == "success"){ $("#maritalChart").html(html); }   
                if (status == "error"){ $("#maritalChart").html("No data found"); }
            });
            
            //Education chart
            $("#educationChart").load(ageChart + initial_url_param + "_educationLevel", function(response, status, xhr) {    
                if (status == "success"){ $("#educationChart").html(html); }   
                if (status == "error"){ $("#educationChart").html("No data found"); }
            });
            
            //Occupation chart
            $("#occupationChart").load(ageChart + initial_url_param + "_occupation", function(response, status, xhr) {  
                if (status == "success"){ $("#occupationChart").html(html); }   
                if (status == "error"){ $("#occupationChart").html("No data found"); }
            });
            
            //Income chart
            $("#incomeChart").load(ageChart + initial_url_param + "_annualIncome", function(response, status, xhr) {
                    
                if (status == "success"){ $("#incomeChart").html(html); }   
                if (status == "error"){ $("#incomeChart").html("No data found"); }
            });
            
            
            $("input:radio[name='genderFilter']").click(function(){
                    
                var genderFilter = $(this).val();
                var genderRatio = "genderRatio"; var maritalStatus = "maritalStatus"; var educationLevel = "educationLevel"; 
                var occupation = "occupation"; var annualIncome = "annualIncome";
                
                var new_url_param = ageBracket + "_" + genderFilter;
                
                //Post to gender
                $.ajax({
                    type: "POST",
                    url: ageChart + new_url_param,
                    data: {dataFilter: genderRatio},
                    cache: false,
                    success: function(html) {
                       $("#genderChart").html(html);
                    }
                });
                
                //Post to marital
                $.ajax({
                    type: "POST",
                    url: ageChart + new_url_param,
                    data: {dataFilter: maritalStatus},
                    cache: false,
                    success: function(html) {
                       $("#maritalChart").html(html);
                    }
                });
                
                //Post to education
                $.ajax({
                    type: "POST",
                    url: ageChart + new_url_param,
                    data: {dataFilter: educationLevel},
                    cache: false,
                    success: function(html) {
                       $("#educationChart").html(html);
                    }
                });
                
                //Post to occupation
                $.ajax({
                    type: "POST",
                    url: ageChart + new_url_param,
                    data: {dataFilter: occupation},
                    cache: false,
                    success: function(html) {
                       $("#occupationChart").html(html);
                    }
                });
                
                //Post to income
                $.ajax({
                    type: "POST",
                    url: ageChart + new_url_param,
                    data: {dataFilter: annualIncome},
                    cache: false,
                    success: function(html) {
                       $("#incomeChart").html(html);
                    }
                });

            });
            
        }
        
        //This controls the all the marital status section chart
        var maritalCharts = function ($absolute_path, $separator) {
            
            var genderChart = $absolute_path + "platform_data" + $separator + "MaritalChartDrawer" + $separator;
            var ageChart = $absolute_path + "platform_data" + $separator + "MaritalChartDrawer" + $separator;
            var educationChart = $absolute_path + "platform_data" + $separator + "MaritalChartDrawer" + $separator;
            var occupationChart = $absolute_path + "platform_data" + $separator + "MaritalChartDrawer" + $separator;
            var incomeChart = $absolute_path + "platform_data" + $separator + "MaritalChartDrawer" + $separator;
            
            var gender = $("#gender").val();
            
            $("#genderSlider").ionRangeSlider({
                min: 0,
                max: 100,
                type: 'double',
                step: 1,
                postfix: "yrs",
                prettify: true,
                hasGrid: false,
                onChange: function(obj) {        // function-callback, is called on every change
                    
                    var ageBracket = $("#genderSlider").val();
                    
                    //post to gender chart
                    $.ajax({
                        type: "POST",
                        url: genderChart + "genderRatio",
                        data: {gender: gender, ageBracket: ageBracket},
                        cache: false,
                        success: function(html) {
                           $("#genderChart").html(html);
                        }
                    });
                    
                    //post to age chart
                    $.ajax({
                        type: "POST",
                        url: ageChart + "ageDistribution",
                        data: {gender: gender, ageBracket: ageBracket},
                        cache: false,
                        success: function(html) {
                           $("#ageChart").html(html);
                        }
                    });
                    
                    //post to education chart
                    $.ajax({
                        type: "POST",
                        url: educationChart + "educationLevel",
                        data: {gender: gender, ageBracket: ageBracket},
                        cache: false,
                        success: function(html) {
                           $("#educationChart").html(html);
                        }
                    });
                    
                    //post to occupation chart
                    $.ajax({
                        type: "POST",
                        url: occupationChart + "occupation",
                        data: {gender: gender, ageBracket: ageBracket},
                        cache: false,
                        success: function(html) {
                           $("#occupationChart").html(html);
                        }
                    });
                    
                    //post to income chart
                    $.ajax({
                        type: "POST",
                        url: incomeChart + "annualIncome",
                        data: {gender: gender, ageBracket: ageBracket},
                        cache: false,
                        success: function(html) {
                           $("#incomeChart").html(html);
                        }
                    });
                    
                }
            });
    
        }
        
        //This controls the all age brackets section charts
        var educationCharts = function ($absolute_path, $separator){
            
            var educationChart = $absolute_path + "platform_data" + $separator + "EducationChartDrawer" + $separator;
            
            var educationLevel = $("#educationLevel").val();
            var activeGender = $("#activeGender").val();
            var initial_url_param = educationLevel + "_" + activeGender;
            
            //Gender chart
            $("#genderChart").load(educationChart + initial_url_param + "_genderRatio", function(response, status, xhr) {    
                if (status == "success"){ $("#genderChart").html(html); }   
                if (status == "error"){ $("#genderChart").html("No data found"); }
            });
            
            //Age chart
            $("#ageChart").load(educationChart + initial_url_param + "_ageDistribution", function(response, status, xhr) {    
                if (status == "success"){ $("#ageChart").html(html); }   
                if (status == "error"){ $("#ageChart").html("No data found"); }
            });
            
            //Marital chart
            $("#maritalChart").load(educationChart + initial_url_param + "_maritalStatus", function(response, status, xhr) {    
                if (status == "success"){ $("#maritalChart").html(html); }   
                if (status == "error"){ $("#maritalChart").html("No data found"); }
            });
            
            //Occupation chart
            $("#occupationChart").load(educationChart + initial_url_param + "_occupation", function(response, status, xhr) {  
                if (status == "success"){ $("#occupationChart").html(html); }   
                if (status == "error"){ $("#occupationChart").html("No data found"); }
            });
            
            //Income chart
            $("#incomeChart").load(educationChart + initial_url_param + "_annualIncome", function(response, status, xhr) {
                    
                if (status == "success"){ $("#incomeChart").html(html); }   
                if (status == "error"){ $("#incomeChart").html("No data found"); }
            });
            
            
            $("input:radio[name='genderFilter']").click(function(){
                    
                var genderFilter = $(this).val();
                var genderRatio = "genderRatio";var ageDistribution = "ageDistribution"; var maritalStatus = "maritalStatus";  
                var occupation = "occupation"; var annualIncome = "annualIncome";
                
                var new_url_param = educationLevel + "_" + genderFilter;
                
                //Post to gender
                $.ajax({
                    type: "POST",
                    url: educationChart + new_url_param,
                    data: {dataFilter: genderRatio},
                    cache: false,
                    success: function(html) {
                       $("#genderChart").html(html);
                    }
                });
                
                //Post to age
                $.ajax({
                    type: "POST",
                    url: educationChart + new_url_param,
                    data: {dataFilter: ageDistribution},
                    cache: false,
                    success: function(html) {
                       $("#ageChart").html(html);
                    }
                });
                
                //Post to marital
                $.ajax({
                    type: "POST",
                    url: educationChart + new_url_param,
                    data: {dataFilter: maritalStatus},
                    cache: false,
                    success: function(html) {
                       $("#maritalChart").html(html);
                    }
                });
                
                //Post to occupation
                $.ajax({
                    type: "POST",
                    url: educationChart + new_url_param,
                    data: {dataFilter: occupation},
                    cache: false,
                    success: function(html) {
                       $("#occupationChart").html(html);
                    }
                });
                
                //Post to income
                $.ajax({
                    type: "POST",
                    url: educationChart + new_url_param,
                    data: {dataFilter: annualIncome},
                    cache: false,
                    success: function(html) {
                       $("#incomeChart").html(html);
                    }
                });

            });
            
        }
        
        //This controls the all age brackets section charts
        var occupationCharts = function ($absolute_path, $separator){
            
            var occupationChart = $absolute_path + "platform_data" + $separator + "OccupationChartDrawer" + $separator;
            
            var occupation = $("#occupation").val();
            var activeGender = $("#activeGender").val();
            var initial_url_param = occupation + "_" + activeGender;
            
            //Gender chart
            $("#genderChart").load(occupationChart + initial_url_param + "_genderRatio", function(response, status, xhr) {    
                if (status == "success"){ $("#genderChart").html(html); }   
                if (status == "error"){ $("#genderChart").html("No data found"); }
            });
            
            //Age chart
            $("#ageChart").load(occupationChart + initial_url_param + "_ageDistribution", function(response, status, xhr) {    
                if (status == "success"){ $("#ageChart").html(html); }   
                if (status == "error"){ $("#ageChart").html("No data found"); }
            });
            
            //education chart
            $("#educationChart").load(occupationChart + initial_url_param + "_educationLevel", function(response, status, xhr) {  
                if (status == "success"){ $("#educationChart").html(html); }   
                if (status == "error"){ $("#educationChart").html("No data found"); }
            });
            
            //Marital chart
            $("#maritalChart").load(occupationChart + initial_url_param + "_maritalStatus", function(response, status, xhr) {    
                if (status == "success"){ $("#maritalChart").html(html); }   
                if (status == "error"){ $("#maritalChart").html("No data found"); }
            });
            
            //Income chart
            $("#incomeChart").load(occupationChart + initial_url_param + "_annualIncome", function(response, status, xhr) {
                    
                if (status == "success"){ $("#incomeChart").html(html); }   
                if (status == "error"){ $("#incomeChart").html("No data found"); }
            });
            
            
            $("input:radio[name='genderFilter']").click(function(){
                    
                var genderFilter = $(this).val();
                var genderRatio = "genderRatio";var ageDistribution = "ageDistribution"; var educationLevel = "educationLevel";  
                var maritalStatus = "maritalStatus"; var annualIncome = "annualIncome";
                
                var new_url_param = occupation + "_" + genderFilter;
                
                //Post to gender
                $.ajax({
                    type: "POST",
                    url: occupationChart + new_url_param,
                    data: {dataFilter: genderRatio},
                    cache: false,
                    success: function(html) {
                       $("#genderChart").html(html);
                    }
                });
                
                //Post to age
                $.ajax({
                    type: "POST",
                    url: occupationChart + new_url_param,
                    data: {dataFilter: ageDistribution},
                    cache: false,
                    success: function(html) {
                       $("#ageChart").html(html);
                    }
                });
                
                //Post to education
                $.ajax({
                    type: "POST",
                    url: occupationChart + new_url_param,
                    data: {dataFilter: educationLevel},
                    cache: false,
                    success: function(html) {
                       $("#educationChart").html(html);
                    }
                });
                
                //Post to marital
                $.ajax({
                    type: "POST",
                    url: occupationChart + new_url_param,
                    data: {dataFilter: maritalStatus},
                    cache: false,
                    success: function(html) {
                       $("#maritalChart").html(html);
                    }
                });
                
                
                //Post to income
                $.ajax({
                    type: "POST",
                    url: occupationChart + new_url_param,
                    data: {dataFilter: annualIncome},
                    cache: false,
                    success: function(html) {
                       $("#incomeChart").html(html);
                    }
                });

            });
            
        }
        
        //This controls the all the annual income section chart
        var incomeCharts = function ($absolute_path, $separator) {
            
            var genderChart = $absolute_path + "platform_data" + $separator + "IncomeChartDrawer" + $separator;
            var ageChart = $absolute_path + "platform_data" + $separator + "IncomeChartDrawer" + $separator;
            var maritalChart = $absolute_path + "platform_data" + $separator + "IncomeChartDrawer" + $separator;
            var educationChart = $absolute_path + "platform_data" + $separator + "IncomeChartDrawer" + $separator;
            var occupationChart = $absolute_path + "platform_data" + $separator + "IncomeChartDrawer" + $separator;
            
            var gender = $("#gender").val();
            
            $("#genderSlider").ionRangeSlider({
                min: 0,
                max: 100,
                type: 'double',
                step: 1,
                postfix: "yrs",
                prettify: true,
                hasGrid: false,
                onChange: function(obj) {        // function-callback, is called on every change
                    
                    var ageBracket = $("#genderSlider").val();
  
                    //post to income chart
                    $.ajax({
                        type: "POST",
                        url: genderChart + "genderRatio",
                        data: {gender: gender, ageBracket: ageBracket},
                        cache: false,
                        success: function(html) {
                           $("#genderChart").html(html);
                        }
                    });
                    
                    //post to age chart
                    $.ajax({
                        type: "POST",
                        url: ageChart + "ageDistribution",
                        data: {gender: gender, ageBracket: ageBracket},
                        cache: false,
                        success: function(html) {
                           $("#ageChart").html(html);
                        }
                    });
                    
                    //post to marital chart
                    $.ajax({
                        type: "POST",
                        url: maritalChart + "maritalStatus",
                        data: {gender: gender, ageBracket: ageBracket},
                        cache: false,
                        success: function(html) {
                           $("#maritalChart").html(html);
                        }
                    });
                    
                    //post to education chart
                    $.ajax({
                        type: "POST",
                        url: educationChart + "educationLevel",
                        data: {gender: gender, ageBracket: ageBracket},
                        cache: false,
                        success: function(html) {
                           $("#educationChart").html(html);
                        }
                    });
                    
                    //post to occupation chart
                    $.ajax({
                        type: "POST",
                        url: occupationChart + "occupation",
                        data: {gender: gender, ageBracket: ageBracket},
                        cache: false,
                        success: function(html) {
                           $("#occupationChart").html(html);
                        }
                    });
                    
                }
            });
    
        }
        
        return { 

            init:function($current_view, $absolute_path, $separator){

                if($current_view === "genderAnalysis"){

                    genderCharts($absolute_path, $separator);

                }

                if($current_view === "ageAnalysis"){

                    ageCharts($absolute_path, $separator);

                }

                if($current_view === "maritalAnalysis"){

                    maritalCharts($absolute_path, $separator);

                }

                if($current_view === "educationAnalysis"){

                    educationCharts($absolute_path, $separator);

                }

                if($current_view === "occupationAnalysis"){

                    occupationCharts($absolute_path, $separator);

                }

                if($current_view === "incomeAnalysis"){

                    incomeCharts($absolute_path, $separator);

                }

            }

        };  

}();



