$(document).ready(function(){
   getPerformanceData(); 
});

function getPerformanceData() {
    var restId = $("#restId").val();
    var ajaxUrl = window.location.pathname;
    var params = "&aj=1&action=getPerformanceData&restId="+restId;
    $.ajax({
        url: ajaxUrl,
        method: "POST",
        dataType: "json",
        data: params
    }).done(function(resp){
        if( resp.status == "success" ) {
            $("#todayNps").html(resp.todayScore['npsScore']);
            if( resp.todayScore['npsScore'] < 0 ) {
                $("#todayNps").css("color","red");
            }
            else if( resp.todayScore['npsScore'] >= 50 ) {
                $("#todayNps").css("color","green");
            }
            
            $("#todayAmbience").html(resp.todayScore['ambience']);
            $("#todayFoodQuality").html(resp.todayScore['foodQuality']);
            $("#todayStaffFriendly").html(resp.todayScore['staffFriendly']);
            $("#todayCleanliness").html(resp.todayScore['cleanliness']);
            $("#todayServiceSpeed").html(resp.todayScore['serviceSpeed']);
            
            $("#yesterdayNps").html(resp.yesterdayScore['npsScore']);
            if( resp.yesterdayScore['npsScore'] < 0 ) {
                $("#yesterdayNps").css("color","red");
            }
            else if( resp.yesterdayScore['npsScore'] >= 50 ) {
                $("#yesterdayNps").css("color","green");
            }
            
            $("#yesterdayAmbience").html(resp.yesterdayScore['ambience']);
            $("#yesterdayFoodQuality").html(resp.yesterdayScore['foodQuality']);
            $("#yesterdayStaffFriendly").html(resp.yesterdayScore['staffFriendly']);
            $("#yesterdayCleanliness").html(resp.yesterdayScore['cleanliness']);
            $("#yesterdayServiceSpeed").html(resp.yesterdayScore['serviceSpeed']);
            
            $("#thisWeekNps").html(resp.thisWeekScore['npsScore']);
            if( resp.thisWeekScore['npsScore'] < 0 ) {
                $("#thisWeekNps").css("color","red");
            }
            else if( resp.thisWeekScore['npsScore'] >= 50 ) {
                $("#thisWeekNps").css("color","green");
            }
            
            $("#thisWeekAmbience").html(resp.thisWeekScore['ambience']);
            $("#thisWeekFoodQuality").html(resp.thisWeekScore['foodQuality']);
            $("#thisWeekStaffFriendly").html(resp.thisWeekScore['staffFriendly']);
            $("#thisWeekCleanliness").html(resp.thisWeekScore['cleanliness']);
            $("#thisWeekServiceSpeed").html(resp.thisWeekScore['serviceSpeed']);
            
            $("#lastWeekNps").html(resp.lastWeekScore['npsScore']);
            if( resp.lastWeekScore['npsScore'] < 0 ) {
                $("#lastWeekNps").css("color","red");
            }
            else if( resp.lastWeekScore['npsScore'] > 0 && resp.lastWeekScore['npsScore'] < 50 ) {
                $("#lastWeekNps").css("color","yellow");
            }
            else if( resp.lastWeekScore['npsScore'] >= 50 ) {
                $("#lastWeekNps").css("color","green");
            }
            
            $("#lastWeekAmbience").html(resp.lastWeekScore['ambience']);
            $("#lastWeekFoodQuality").html(resp.lastWeekScore['foodQuality']);
            $("#lastWeekStaffFriendly").html(resp.lastWeekScore['staffFriendly']);
            $("#lastWeekCleanliness").html(resp.lastWeekScore['cleanliness']);
            $("#lastWeekServiceSpeed").html(resp.lastWeekScore['serviceSpeed']);
            
            $(".loadingUl").removeClass("show");
            $(".loadingUl").addClass("hide");
            $(".scoreUl").removeClass("hide");
            $(".scoreUl").addClass("show");
        }
        else if( resp.status == "faliure" ) {
            $(".loading").html(resp.errMsg);
        }
    });
}