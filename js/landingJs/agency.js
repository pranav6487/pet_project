/*!
 * Start Bootstrap - Agency Bootstrap Theme (http://startbootstrap.com)
 * Code licensed under the Apache License v2.0.
 * For details, see http://www.apache.org/licenses/LICENSE-2.0.
 */

// jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});

// Highlight the top nav as scrolling occurs
$('body').scrollspy({
    target: '.navbar-fixed-top'
})

// Closes the Responsive Menu on Menu Item Click
$('.navbar-collapse ul li a').click(function() {
    $('.navbar-toggle:visible').click();
});

$('body').on('click',"#sbmtFeedBack",function(){
   sbmtFeedBack(); 
});

function sbmtFeedBack() {
    var ambienceRating = $("input:radio[name='ambience']:checked");
    if( ambienceRating.length == 0 ) {
        $("#ambienceError").removeClass("hide");
        $("#ambienceError").addClass("show");
        $("html, body").animate({scrollTop: $('#ambienceRating').offset().top},"slow","swing");
        return false;
    }
    var ambience = ambienceRating.val();
    
    var foodQualityRating = $("input:radio[name='foodQuality']:checked");
    if( foodQualityRating.length == 0 ) {
        $("#foodQualityError").removeClass("hide");
        $("#foodQualityError").addClass("show");
        $("html, body").animate({scrollTop: $('#foodQualityRating').offset().top},"slow","swing");
        return false;
    }
    var foodQuality = foodQualityRating.val();
    
    var staffFriendlyRating = $("input:radio[name='staffFriendly']:checked");
    if( staffFriendlyRating.length == 0 ) {
        $("#staffFriendlyError").removeClass("hide");
        $("#staffFriendlyError").addClass("show");
        $("html, body").animate({scrollTop: $('#staffFriendlyRating').offset().top},"slow","swing");
        return false;
    }
    var staffFriendly = staffFriendlyRating.val();
    
    var cleanlinessRating = $("input:radio[name='cleanliness']:checked");
    if( cleanlinessRating.length == 0 ) {
        $("#cleanlinessError").removeClass("hide");
        $("#cleanlinessError").addClass("show");
        $("html, body").animate({scrollTop: $('#cleanlinessRating').offset().top},"slow","swing");
        return false;
    }
    var cleanliness = cleanlinessRating.val();
    
    var serviceSpeedRating = $("input:radio[name='serviceSpeed']:checked");
    if( serviceSpeedRating.length == 0 ) {
        $("#serviceSpeedError").removeClass("hide");
        $("#serviceSpeedError").addClass("show");
        $("html, body").animate({scrollTop: $('#serviceSpeedRating').offset().top},"slow","swing");
        return false;
    }
    var serviceSpeed = serviceSpeedRating.val();
    
    if( $("#recommend").val() == "" ) {
        $("#recommendError").removeClass("hide");
        $("#recommendError").addClass("show");
        $("html, body").animate({scrollTop: $('#recommendRating').offset().top},"slow","swing");
        return false;
    }
    else {
        var recommend = $("#recommend").val();
    }
    
    var ajaxUrl = window.location.pathname;
    var params = "&aj=1&action=saveFeedBack&bid="+$("#bookingId").val()+"&ambience="+ambience+"&foodQuality="+foodQuality+"&staffFriendly="+staffFriendly+"&cleanliness="+cleanliness+"&serviceSpeed="+serviceSpeed+"&recommend="+recommend;
    if( $("#comments").val().trim().length > 0 && $("#comments").val() != "" ) {
        params += "&comments="+JSON.stringify($("#comments").val());
    }
    $.ajax({
        url: ajaxUrl,
        method: "POST",
        dataType: "json",
        data: params
    }).done(function(resp){
        if(resp.status == "success") {
            $("#feedbackFrm").removeClass("show");
            $("#feedbackFrm").addClass("hide");
            $("#thankYou").removeClass("hide");
            $("#thankYou").addClass("show");
        }
        else if( resp.status == "fail" ) {
            $("#feedbackFrm").removeClass("show");
            $("#feedbackFrm").addClass("hide");
            $("#error").removeClass("hide");
            $("#error").addClass("show");
        }
    });
}