$(document).ready(function() {
   $("body").on("keydown",".required",function(){
       if( $(this).hasClass("inpError") )  {
           $(this).removeClass("inpError");
       }
   });
    
   $('body').on('keyup',".numeric",function() {
       $(this).val($(this).val().replace(/[^0-9]/g, ''));
   });
   
   $("body").on("click","#addNoOfTables",function() {
      if( $("#noOfTables").val() != "" ) {
          addNoTables( $("#noOfTables").val() );
      }
      else {
          alert("Please add no of tables");
          $("#noOfTables").focus();
      }
   });
   
   $("body").on("click",".removeTable",function() {
      var tmp = $(this).attr("id").split("_");
      var liId = tmp[1];
      $("#tableList_"+liId).remove();
   });
   
   $("body").on("click","#addMoreParty",function() {
      addMoreParty(); 
   });
   
   $("body").on("click",".removePartyRel",function() {
      var tmp = $(this).attr("id").split("_"); 
      $("#partyRel_"+tmp[1]).remove();
   });
});

function addRestaurant() {
    if( validateForm() ) {
        var ajaxUrl = window.location.pathname;
        var params = "aj=1&action=addRest";
        params += "&"+$("#add_restaurant").serialize();
        $.ajax({
            url: ajaxUrl,
            method: "POST",
            dataType: "json",
            data: params
        }).done(function(resp){
           if( resp.status == 0 ) {
               alert(resp.errMsg);
           }
           else if( resp.status == 1 ) {
               $("#addRestDtls").css("display","none");
               $("#dispRestName").html( $("#restName").val() );
               $("#restDtls").css("display","block");
               $("#addTableDtls").css("display","block");
               $("#restId").val( resp.restId );
           }
        }).fail(function(){
            console.debug("Call to "+ajaxUrl+" failed");
        });
    }
    return false;
}

function validateForm() {
    var emptyFields = true;
    var i = 0;
    $(".required").each( function(){
       if( $(this).val() == "" )  {
           emptyFields = false;
           i++;
           $(this).addClass("inpError");
       }
       
       if( i == 1 ) {
           $(this).focus();
       }
    });
    return emptyFields;
}

function addNoTables( noOfTables ) {
    var html = "";
    for( i = 1; i <= noOfTables; i++ ) {
        html += '<li id="tableList_'+i+'"><input id="tableNo_'+i+'" name="tableNo[]" value="" size="3" placeholder="Table No" type="text" /> <input type="text" id="tableMinOcc_'+i+'" name="tableMinOcc[]" value="" class="numeric" size="1" placeholder="Min Occ" /> <input type="text" id="tableMaxOcc_'+i+'" name="tableMaxOcc[]" value="" class="numeric" size="1" placeholder="Max Occ" /> <input class="removeTable" id="removeTable_'+i+'" type="button" value="Remove" /></li>';
    }
    
    html += '<li><input type="submit" value="Add Tables" id="addTableList" name="addTableList" /></li>';
    $("#tableDtlsList").html(html);
}

function addTableDtls() {
    var ajaxUrl = window.location.pathname;
    var params = "aj=1&action=addTableDtls";
    params += "&"+$("#tableDtlsFrm").serialize();
    $.ajax({
        url: ajaxUrl,
        method: "POST",
        dataType: "json",
        data: params
    }).done( function(resp) {
        if( resp.status == 1 ) {
            var tableDtls = resp.tableDtls;
            var html = "";
            for( x in tableDtls ) {
                html += '<option value='+x+'>'+tableDtls[x]+'</option>';
            }
            $("#addTableDtls").css("display","none");
            $("#multipleTableOpts").html(html);
            $("#eligibleTablOpts_1").html(html);
            $("#eligibleTablOpts_1").css("display","block");
            $("#partyRestRel").css("display","block");
        }
        else if( resp.status == 0 ) {
            alert(resp.errMsg);
        }
    });
    return false;
}

function addMoreParty() {
    var nextLi = $("#partyRestRelList li").length + 1;
    var html = '<li id="partyRel_'+nextLi+'"><input type="text" size="1" placeholder="No of People" class="numeric" id="noOfPeople_'+nextLi+'" name="noOfPeople[]" value=""/> <input type="text" size="1" placeholder="Avg Time" class="numeric" id="avgTime_'+nextLi+'" name="avgTime[]" value=""/> <input type="text" size="1" placeholder="Buffer" class="numeric" id="bufferTime_'+nextLi+'" name="bufferTime[]" value="" /> <select multiple="multiple" id="eligibleTablOpts_'+nextLi+'" name="eligibleTableOpts_'+nextLi+'[]" style="display:block;">'+$("#multipleTableOpts").html()+'</select><input type="button" id="removePartyRel_'+nextLi+'" class="removePartyRel" value="Remove"/></li>';
    $("#partyRestRelList").append(html);
}

function addPartyRestRel() {
    var ajaxUrl = window.location.pathname;
    var params = "aj=1&action=addPartyRel&rest_id="+$("#restId").val();
    params += "&"+$("#partyRestRelFrm").serialize();
    $.ajax({
        url: ajaxUrl,
        method: "POST",
        dataType: "json",
        data: params
    }).done( function(resp) {
        if( resp.status == 1 ) {
            location.reload();
        }
    });
    return false;
}