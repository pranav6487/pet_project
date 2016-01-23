$(document).ready(function() {
    currTableList = phpToJsTableList(currTableList);
    nextAvailableAt = phpToJsNextAvailableAt(nextAvailableAt);
    refreshTableList();
    //refreshWaitList();
    reCalculateWaitList();
    
    $('body').on('keyup',".numeric",function() {
       $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });
});

$('body').on('blur',".partyDtls",function() {
    if( $("#partyCount").val() != "" )  {
        showTableOptions();
    }
});

var date_sort_desc = function (date1, date2) {
  // This is a comparison function that will result in dates being sorted in
  // DESCENDING order.
  if (date1 > date2) return -1;
  if (date1 < date2) return 1;
  return 0;
};

var date_sort_asc = function (date1, date2) {
  // This is a comparison function that will result in dates being sorted in
  // ASCENDING order. As you can see, JavaScript's native comparison operators
  // can be used to compare dates. This was news to me.
  if (date1 > date2) return 1;
  if (date1 < date2) return -1;
  return 0;
};

function addMinutes(date, minutes) {
    return new Date(date.getTime() + minutes*60000);
}

function showTableOptions() {
    var partyCount = $("#partyCount").val();
    var possibleTables = tableCapacity[partyCount];
    var x;
    var tableOpts = [];
    for( x in possibleTables ) {
        var tableNo = possibleTables[x];
        if( currTableList[tableNo]['partyName'] == "" ) {
            tableOpts.push(tableNo);
        }
    }

    if( tableOpts.length > 0 ) {
        var tableOptsHtml = "<option value=''>Select Table</option>";
        for ( x in tableOpts ) {
            tableOptsHtml += "<option id='tableOpt_"+tableOpts[x]+"' value="+tableOpts[x]+">"+tableOpts[x]+"</option>"
        }
        $("#tablesOptions").html(tableOptsHtml);
        $("#selectTable").css("display","block");
    }
    else {
        $("#tablesOptions").html("");
        if( $("#selectTable").css("display") == "block" ){
            $("#selectTable").css("display","none");
        }
    }
}

function getSeatingLeft() {
    if( $("#partyName").val() == "") {
        alert("Enter Party Name");
        $("#partyName").focus();
        return false;
    }
    
    if( $("#partyCount").val() == "") {
        alert("Enter no of people in party");
        $("#partyCount").focus();
        return false;
    }
    
    if( $("#partyNum").val() == "" ) {
       alert("Enter Mobile Number"); 
       $("#partyNum").focus();
       return false;
    }
    
    if( $("#tablesOptions").html() != "" && $("#tablesOptions").val() == "" ) {
        alert("Table available, Please select a table");
        $("#tablesOptions").focus();
        return false;
    }
    
    var noOfPeople = $("#partyCount").val();
    var partyName = $("#partyName").val();
    var partyNum = $("#partyNum").val();
    var currDate = new Date();
    
    if( $("#tablesOptions").val() !== null ) {
        var tableNo = $("#tablesOptions").val();
        currTableList[tableNo]["partyName"] = partyName;
        currTableList[tableNo]["partyNum"] = partyNum;
        currTableList[tableNo]["seatTime"] = currDate;
        currTableList[tableNo]["endTime"] = addMinutes(currDate, avgTimeAtTable[noOfPeople]);
        currTableList[tableNo]["noOfPeople"] = noOfPeople;
        //currTableList[tableNo]["endTime"] = addMinutes(currDate, Math.round((avgTimeAtTable[noOfPeople] + bufferTime[noOfPeople])));
        
        var tablesLeft = false;
        var possibleTables = tableCapacity[noOfPeople];
        var x;
        var endTime = [];
        for( x in possibleTables ) {
            if( currTableList[possibleTables[x]]["partyName"] == "" ) {
                tablesLeft = true;
                break;
            }
            else {
                endTime.push(currTableList[possibleTables[x]]["endTime"]);
            }
        }
        
        var params = "restId="+$("#restId").val()+"&tableNo="+tableNo+"&noOfPeople="+noOfPeople+"&partyName="+partyName+"&partyNum="+partyNum+"&seatedTime="+jsToPhpTime(currTableList[tableNo]["seatTime"])+"&estdEndTime="+jsToPhpTime(currTableList[tableNo]["endTime"]);
        
        if( !tablesLeft ) {
            endTime.sort(date_sort_asc);
            nextAvailableAt[noOfPeople] = endTime[0];
            params += "&nextAvailableAt="+jsToPhpTime(endTime[0]);
        }
        refreshTableList();
        saveBooking(ALLOT_TABLE,params);
    }
    else {
        if( nextAvailableAt[noOfPeople] == 0 || typeof nextAvailableAt[noOfPeople] === "undefined" ) {
            var possibleTables = tableCapacity[noOfPeople];
            var x;
            var endTime = [];
            for( x in possibleTables ) {
                endTime.push(currTableList[possibleTables[x]]["endTime"]);
            }
            endTime.sort(date_sort_asc);
            if( currDate > endTime[0] ) {
                var waitTime = bufferTime[noOfPeople];
            }
            else {
                var diff = Math.abs( new Date(endTime[0]) - new Date(currDate) );
                var waitTime = Math.round((diff/1000)/60);
                nextAvailableAt[noOfPeople] = addMinutes(endTime[0], avgTimeAtTable[noOfPeople]);
            }
        }
        else {
            if( currDate > nextAvailableAt[noOfPeople] ) {
                var waitTime = bufferTime[noOfPeople];
                nextAvailableAt[noOfPeople] = 0;
            }
            else {
                var diff = Math.abs( new Date(nextAvailableAt[noOfPeople]) - new Date(currDate) );
                var waitTime = Math.round((diff/1000)/60);
                nextAvailableAt[noOfPeople] = addMinutes(nextAvailableAt[noOfPeople], avgTimeAtTable[noOfPeople]);
            }
        }
        waitList.push({name:partyName,noOfPeople:noOfPeople,num:partyNum,waitTime:waitTime,tablesAvail:"",bookingId:""});
        var waitListIndex = waitList.length - 1;
        refreshWaitList();
        var params = "restId="+$("#restId").val()+"&noOfPeople="+noOfPeople+"&partyName="+partyName+"&partyNum="+partyNum+"&waitListTime="+waitTime+"&waitListIndex="+waitListIndex;
        if( nextAvailableAt[noOfPeople] != 0 || typeof nextAvailableAt[noOfPeople] !== "undefined" ) {
            params += "&nextAvailableAt="+jsToPhpTime(nextAvailableAt[noOfPeople]);
        }
        saveBooking(ADD_TO_WAIT_LIST,params);
    }
    clearForm();
}

function clearForm() {
    $("#partyName").val("");
    $("#partyCount").val("");
    $("#partyNum").val("");
    $("#tablesOptions").html("");
    $("#selectTable").css("display","none");
}

function refreshTableList() {
    var tableListHtml = "";
    var i = 0;
    var noOfTables = currTableList.length;
    for( tableNo in currTableList ) {
        i++;
        if( i == 1 ) {
            tableListHtml += '<li>';
        }
        
        if( currTableList[tableNo]["partyName"] == "" ) {
            //tableListHtml += '<span style="color:grey;">'+tableNo+'</span> | ';
            tableListHtml += '<button type="button" class="greyBtn">'+tableNo+'</button>&nbsp;';
        }
        else {
            //tableListHtml += '<span style="color:blue;cursor:pointer;" title="Clear Table" onclick="clearTable(\''+tableNo+'\');">'+currTableList[tableNo]["partyName"]+' ('+currTableList[tableNo]["noOfPeople"]+') ('+tableNo+')</span> | ';
            tableListHtml += '<button class="greenBtn" type="button" onclick="clearTable(\''+tableNo+'\');" title="Clear Table"><i>'+tableNo+'</i><br />'+currTableList[tableNo]["partyName"]+' ('+currTableList[tableNo]["noOfPeople"]+')</i></button>&nbsp;';
        }
        
        if( i%4 == 0 || noOfTables == i ) {
            tableListHtml += '</li><li>';
        }
        
        if( noOfTables == i ) {
            tableListHtml += '</li>';
        }
    }
    $("#tableList").html(tableListHtml);
}

function clearTable( tableNo ) {
    var confirmAction = confirm("You sure the party at table no "+tableNo+" is done?");
    if( confirmAction == true ) {
        var params = "restId="+$("#restId").val()+"&tableNo="+tableNo+"&noOfPeople="+currTableList[tableNo]["noOfPeople"]+"&partyName="+currTableList[tableNo]["partyName"]+"&partyNum="+currTableList[tableNo]["partyNum"]+"&bkkId="+currTableList[tableNo]["bookingId"];
        currTableList[tableNo]["partyName"] = "";
        currTableList[tableNo]["partyNum"] = "";
        currTableList[tableNo]["seatTime"] = "";
        currTableList[tableNo]["noOfPeople"] = "";
        currTableList[tableNo]["endTime"] = "";
        currTableList[tableNo]["bookingId"] = "";
        if( waitList.length > 0 ) {
            reCalculateWaitList();
        }
        
        if( typeof nextAvailableAt[currTableList[tableNo]["noOfPeople"]] !== "undefined" ) {
            params += "&nextAvailableAt="+jsToPhpTime(nnextAvailableAt[currTableList[tableNo]["noOfPeople"]]);
        }
        saveBooking(EMPTY_TABLE,params);
        refreshTableList();
    }
}

function refreshWaitList() {
    var waitListHtml = "";
    if( waitList.length > 0 ) {
        for( x in waitList ) {
            var currWait = waitList[x];
            var hours = Math.floor(currWait.waitTime/60);
            var minutes = Math.floor(currWait.waitTime%60);
            waitListHtml += "<li>"+currWait.name+" ("+currWait.noOfPeople+") "+currWait.num+" "+hours+":"+minutes+" mins <span title='Remove party from wait list' style='color:blue;cursor:pointer' onclick=\"removeFromWaitList("+x+")\">Remove</span> ";
            if( currWait.tablesAvail.length > 0 ) {
               waitListHtml += '<select class="allotFromWaitList"><option value= "">Select Table</option>'; 
               for( var y in currWait.tablesAvail ) {
                   waitListHtml += '<option value="'+x+'|'+currWait.tablesAvail[y]+'">'+currWait.tablesAvail[y]+'</option>';
               }
               waitListHtml += "</select>";
            }
            waitListHtml += "</li>";
        }
    }
    $("#waitList").html(waitListHtml);
}

function removeFromWaitList( index ) {
    var confirmAct = confirm("You sure you want to remove "+waitList[index]["name"]+" from the list?");
    if( confirmAct ) {
        var noOfPeople = waitList[index]["noOfPeople"];
        //nextAvailableAt[noOfPeople] = 0;
        var params = "restId="+$("#restId").val()+"&noOfPeople="+waitList[index]["noOfPeople"]+"&partyName="+waitList[index]["name"]+"&partyNum="+waitList[index]["num"];
        waitList.splice(index,1);
        if( waitList.length == 0 ) {
            $("#waitList").html("");
        }
        else {
            reCalculateWaitList();
        }
        
        if( typeof nextAvailableAt[noOfPeople] !== "undefined" ) {
            params += "&nextAvailableAt="+jsToPhpTime(nextAvailableAt[noOfPeople]);
        }
        saveBooking(REMOVE_FROM_WAIT_LIST,params);
    }
}

function resetNextAvailableAt() {
    for (var x in nextAvailableAt) {
        nextAvailableAt[x] = 0;
    }
}

function reCalculateWaitList() {
    var currDate = new Date();
    resetNextAvailableAt();
    for ( var x in waitList ) {
        var currWait = waitList[x];
        var noOfPeople = currWait.noOfPeople;
        var possibleTables = tableCapacity[noOfPeople];
        var tableOpts = [];
        var endTime = [];
        for ( var y in possibleTables ) {
            var tableNo = possibleTables[y];
            if( currTableList[tableNo]["partyName"] == "" ) {
                tableOpts.push(tableNo);
            }
            else {
                endTime.push(currTableList[tableNo]["endTime"]);
            }
        }
        
        if( tableOpts.length > 0 ) {
            currWait.tablesAvail = tableOpts;
            currWait.waitTime = 0;
            nextAvailableAt[noOfPeople] = 0;
        }
        else {
            if( nextAvailableAt[noOfPeople] == 0 || typeof nextAvailableAt[noOfPeople] === "undefined" ) {
                endTime.sort(date_sort_asc);
                if( currDate > endTime[0] ) {
                    var waitTime = bufferTime[noOfPeople];
                    nextAvailableAt[noOfPeople] = 0;
                }
                else {
                    var diff = Math.abs( new Date(endTime[0]) - new Date(currDate) );
                    var waitTime = Math.round((diff/1000)/60);
                    nextAvailableAt[noOfPeople] = addMinutes(endTime[0], avgTimeAtTable[noOfPeople]);
                }
            }
            else {
                var diff = Math.abs( new Date(nextAvailableAt[noOfPeople]) - new Date(currDate) );
                var waitTime = Math.round((diff/1000)/60);
                nextAvailableAt[noOfPeople] = addMinutes(nextAvailableAt[noOfPeople], avgTimeAtTable[noOfPeople]);
            }
            currWait.tablesAvail = "";
            currWait.waitTime = waitTime;
        }
    }
    refreshWaitList();
}

$("body").on("change",".allotFromWaitList",function(){
    var tmp = $(this).val().split("|");
    var index = tmp[0];
    var tableNo = tmp[1];
    var currDate = new Date();
    currTableList[tableNo]["partyName"] = waitList[index]["name"];
    currTableList[tableNo]["partyNum"] = waitList[index]["num"];
    currTableList[tableNo]["seatTime"] = currDate;
    currTableList[tableNo]["endTime"] = addMinutes(currDate, avgTimeAtTable[ waitList[index]["noOfPeople"] ]);
    currTableList[tableNo]["noOfPeople"] = waitList[index]["noOfPeople"];
    waitList.splice(index,1);
    refreshTableList();
    reCalculateWaitList();
    
    var params = "restId="+$("#restId").val()+"&tableNo="+tableNo+"&noOfPeople="+currTableList[tableNo]["noOfPeople"]+"&partyName="+currTableList[tableNo]["partyName"]+"&partyNum="+currTableList[tableNo]["partyNum"]+"&seatedTime="+jsToPhpTime(currTableList[tableNo]["seatTime"])+"&estdEndTime="+jsToPhpTime(currTableList[tableNo]["endTime"]);
    
    if( typeof nextAvailableAt[currTableList[tableNo]["noOfPeople"]] !== "undefined" ) {
        params += "&nextAvailableAt="+jsToPhpTime(nextAvailableAt[currTableList[tableNo]["noOfPeople"]]);
    }
    saveBooking(ALLOT_TABLE_FROM_WAIT_LIST,params);
});

function showWaitTime() {
    //Estimate wait time
    //Update the wait list array
    var partyCount = $("#partyCount").val();
    var waitTime = (tableTurnTime[partyCount] * waitList[partyCount]) + bufferTime[partyCount];
    console.debug(currTableList);console.debug(waitTime);
}

function jsToPhpTableList( tableList ) {
    for( x in tableList ) {
        if( tableList[x]["endTime"] != "" && tableList[x]["seatTime"] != "" ) {
            tableList[x]["endTime"] = Math.round(tableList[x]["endTime"].getTime()/1000);
            tableList[x]["seatTime"] = Math.round(tableList[x]["seatTime"].getTime()/1000);
        }
    }
    return tableList;
}

function phpToJsTableList( tableList ) {
    for( x in tableList ) {
        if( tableList[x]["endTime"] != "" && tableList[x]["seatTime"] != "" ) {
            tableList[x]["endTime"] = new Date(tableList[x]["endTime"]*1000);
            tableList[x]["seatTime"] = new Date(tableList[x]["seatTime"]*1000);
        }
    }
    return tableList;
}

function jsToPhpNextAvailableAt( nextAvailable ) {
    for( x in nextAvailable ) {
        if( nextAvailable[x] != 0 ) {
            nextAvailable[x] = Math.round(nextAvailable[x].getTime()/1000);
        }
    }
    return nextAvailable;
}

function phpToJsNextAvailableAt( nextAvailable ) {
    for( x in nextAvailable ) {
        if( nextAvailable[x] != 0 ) {
            nextAvailable[x] = new Date(nextAvailable[x]*1000);
        }
    }
    return nextAvailable;
}

function jsToPhpTime( jsDate ) {
    if( jsDate == 0 ) {
        return 0;
    }
    return Math.round(jsDate.getTime()/1000);
}

function phpToJsTime( phpTime ) {
    if( phpTime == 0 ) {
        return 0;
    }
    return new Date(phpTime*1000);
}

function saveBooking( action,params ) {
    var ajaxUrl = window.location.pathname;
    params += "&aj=1&action=saveBooking&status="+action;
    $.ajax({
        url: ajaxUrl,
        method: "POST",
        dataType: "json",
        data: params
    }).done(function(resp){
        if( action == ALLOT_TABLE ) {
            currTableList[resp.tableNo]["bookingId"] = resp.bookingId;
        }
        else if( action == ADD_TO_WAIT_LIST ) {
            waitList[resp.waitListIndex]["bookingId"] = resp.bookingId;
        }
    });
}