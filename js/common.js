$(document).ready(function() {
    $('body').on('keyup',"#loginEmail, #loginPswd",function() {
        $("#errMsgLi").html("");
        $("#errMsgLi").css("display","none");
    });
    
    $("body").on("click","#logoutHref", function() {
        logout();
    });
    
    $('body').on("click","#sbmtQuery", function(){
        contactMail();
    });
    
    $('body').on("click",".feedBackBtn",function(){
       getFeedBack($(this)); 
    });
});

function loginFrm() {
    if( $("#loginEmail").val() == "" ) {
        alert("Please enter Email");
        $("#loginEmail").focus();
        return false;
    }
    
    if( $("#loginPswd").val() == "" ) {
        alert("Please enter Password");
        $("#loginPswd").focus();
        return false;
    }
    
    var ajaxUrl = window.location.pathname;
    var params = "aj=1&action=login";
    params += "&"+$("#loginFrm").serialize();
    $.ajax({
        url: ajaxUrl,
        method: "POST",
        dataType: "json",
        data: params
    }).done(function(resp){
        if( resp.status == 0 ) {
            $("#errMsgLi").html(resp.errMsg);
            $("#errMsgLi").css("display","block");
        }
        else if( resp.status == 1 ) {
            if( typeof resp.redHref !== "undefined" ) {
                window.location.href = resp.redHref;
            }
            else {
                window.location.href = "/hotels/waitTime.html"
            }
        }
    });
    return false;
}

function forgotPasswd() {
    if( $("#loginEmail").val() == "" ) {
        alert("Please enter Email first");
        $("#loginEmail").focus();
        return false;
    }
    
    var ajaxUrl = window.location.pathname;
    var params = "aj=1&action=forgotPasswd";
    params += "&email="+$("#loginEmail").val();
    $.ajax({
        url: ajaxUrl,
        method: "POST",
        dataType: "json",
        data: params
    }).done(function(resp){
        if( resp.status == 0 ) {
            $("#errMsgLi").html(resp.errMsg);
            $("#errMsgLi").css("display","block");
        }
        else if( resp.status == 1 ) {
            $("#errMsgLi").html(resp.errMsg);
            $("#errMsgLi").css("display","block");
        }
    });
    return false;
}

function resetFrm() {
    if( $("#newPasswd").val() == "" ) {
        alert("Please enter password");
        $("#newPasswd").focus();
        return false;
    }
    
    if( $("#confPasswd").val() == "" || $("#newPasswd").val() != $("#confPasswd").val() ) {
        alert("Please type the same password again");
        $("#confPasswd").focus();
        return false;
    }
    
    var ajaxUrl = window.location.pathname;
    var params = "aj=1&action=resetPasswd";
    params += "&"+$("#resetFrm").serialize();
    $.ajax({
        url: ajaxUrl,
        method: "POST",
        dataType: "json",
        data: params
    }).done(function(resp){
        if( resp.status == 0 ) {
            $("#errMsgLi").html(resp.errMsg);
            $("#errMsgLi").css("display","block");
        }
        else if( resp.status == 1 ) {
            $("#resetPassdUl").html("");
            $("#resetPassdUl").html("<li>"+resp.errMsg+"</li>");
            if( typeof resp.redHref !== "undefined" ) {
                window.setTimeout(function(){window.location.href = resp.redHref;},5000);
            }
            else {
                window.setTimeout(function(){window.location.href = "/login.html";},5000);
            }
        }
    });
    return false;
}

function logout() {
    window.location.href = "/login.html?action=logout";
}

function selectRest() {
    if( $("#selectRest").val() != "" ) {
        window.location.href = "http://"+window.location.hostname+window.location.pathname+"?restId="+$("#selectRest").val();
    }
}

function contactMail() {
    if( $("#querySub").val() == "" ) {
        alert("Please enter subject");
        $("#querySub").focus();
        return false;
    }
    
    if( $("#queryMsg").val() == "" ) {
        alert("Please enter message");
        $("#queryMsg").focus();
        return false;
    }
    
    var ajaxUrl = window.location.pathname;
    var params = "aj=1&action=contMail";
    params += "&subject="+$("#querySub").val()+"&message="+$("#queryMsg").val();
    $("#sbmtLi").css("display","none");
    $("#plsWaitLi").css("display","block");
    $.ajax({
        url: ajaxUrl,
        method: "POST",
        dataType: "json",
        data: params
    }).done(function(resp){
        $("#errMsgLi").html(resp.errMsg);
        $("#errMsgLi").css("display","block");
        $("#querySub").val("");
        $("#queryMsg").val("");
        $("#sbmtLi").css("display","block");
        $("#plsWaitLi").css("display","none");
        window.setTimeout(function(){
            $("#errMsgLi").html("");
            $("#errMsgLi").css("display","none");
        },1000*15);
    });
}

function getFeedBack(ele) {
    var href = ele.attr("rel");
    if( typeof href !== "undefined" && href != "done" ) {
        window.open(href,"_blank");
    }
    else if( typeof href !== "undefined" && href == "done" ) {
        alert("Feedback taken");
    }
    else {
        alert("No customer seated at this table currently");
    }
}