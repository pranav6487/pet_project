<?php
global $global_params;
global $page_params;

$totalTables = 16;
$tabelCount = array(
    2 => 4,
    4 => 6,
    6 => 3,
    8 => 3
);
$tableLeft = array(
    2 => 2,
    4 => 0,
    6 => 3,
    8 => 3
);
//$currTableList = array(
//    2 => array("t2_1"=>"a","t2_2"=>"b","t2_3"=>"g","t2_4"=>0),
//    4 => array("t4_1"=>"c","t4_2"=>"d","t4_3"=>"e","t4_4"=>"f","t4_5"=>"h","t4_6"=>0),
//    6 => array("t6_1"=>0,"t6_2"=>0,"t6_3"=>0),
//    8 => array("t8_1"=>0,"t8_2"=>0,"t8_3"=>0)
//);

$currTableList = array(
    "t2_1" => "a",
    "t2_2" => "b",
    "t2_3" => "c",
    "t2_4" => 0,
    "t4_1" => "d",
    "t4_2" => "e",
    "t4_3" => "f",
    "t4_4" => "g",
    "t4_5" => "h",
    "t4_6" => 0,
    "t6_1" => 0,
    "t6_2" => 0,
    "t6_3" => 0,
    "t8_1" => 0,
    "t8_2" => 0,
    "t8_3" => 0
);

$waitList = array( //noOfPeopleInParty => total
    
);
$waitListDtls = array( //list of all waiting people
    
);
$avgTimeAtTable = array( //time in minutes
    1 => 45,
    2 => 60,
    3 => 90,
    4 => 105,
    5 => 120,
    6 => 150
);
$tableTurnTime = array( //average time when the table will be available next
    1 => 11.25,
    2 => 6,
    3 => 6.92,
    4 => 8.75,
    5 => 10,
    6 => 25
);
$tableCapacity = array( //noOfPeople => table
    1 => array(2),
    2 => array(2,4),
    3 => array(2,4,6),
    4 => array(4,6,8),
    5 => array(4,6,8),
    6 => array(6,8),
    7 => array(6,8),
    8 => array(8),
    9 => array(8)
);
$tableCapacity = array(
    1 => array("t2_1","t2_2","t2_3","t2_4"),
    2 => array("t2_1","t2_2","t2_3","t2_4","t4_1","t4_2","t4_3","t4_4","t4_5","t4_6"),
    3 => array("t2_1","t2_2","t2_3","t2_4","t4_1","t4_2","t4_3","t4_4","t4_5","t4_6","t6_1","t6_2","t6_3"),
    4 => array("t4_1","t4_2","t4_3","t4_4","t4_5","t4_6","t6_1","t6_2","t6_3","t8_1","t8_2","t8_3"),
    5 => array("t4_1","t4_2","t4_3","t4_4","t4_5","t4_6","t6_1","t6_2","t6_3","t8_1","t8_2","t8_3"),
    6 => array("t6_2","t6_3","t8_1","t8_2","t8_3"),
    7 => array("t6_2","t6_3","t8_1","t8_2","t8_3"),
    8 => array("t8_1","t8_2","t8_3"),
    9 => array("t6_2","t6_3","t8_1","t8_2","t8_3")
);
$bufferTime = array( //buffer time for each party count
    1 => 10,
    2 => 15,
    3 => 20,
    4 => 25,
    5 => 30,
    6 => 35
);

//$nextAvailableAt = array( //for a particular noOfPeople the table will be next available at
//    1 => 0,
//    2 => 0,
//    3 => 0,
//    4 => 0,
//    5 => 0,
//    6 => 0,
//    7 => 0,
//    8 => 0,
//    9 => 0
//);
$nextAvailableAt = array( //when the particular table will be next available
    
);
?>
I think tableFor should be removed and just table numbers should be used. Map the noOfPeople to table numbers<br />
When a table is made empty recalculate wait list and show table next to eligible party<br />
Action to remove a person from wait list<br />
Action to allot a table to a person in the wait list<br />
Recalculate wait list when wait list is altered(added or removed)<br />
Implement condition for no of people in party more than 9<br />
Option to put a customer on wait list and not allot a specific table - is it really needed?<br />
<script type="text/javascript">
var totalTables = <?php echo $totalTables; ?>;
var tabelCount = <?php echo json_encode($tabelCount); ?>;
var tableLeft = <?php echo json_encode($tableLeft); ?>;
var avgTimeAtTable = <?php echo json_encode($avgTimeAtTable); ?>;
var tableCapacity = <?php echo json_encode($tableCapacity); ?>;
var currTableList = <?php echo json_encode($currTableList); ?>;
var waitList = [];
var tableTurnTime = <?php echo json_encode($tableTurnTime); ?>;
var bufferTime = <?php echo json_encode($bufferTime); ?>;
var nextAvailableAt = <?php echo json_encode($nextAvailableAt); ?>;

$(document).ready(function() {
    refreshTableList();
    
    $(".partyDtls").on("blur", function(){
       if( $("#partyCount").val() != "" )  {
           showTableOptions();
       }
    });
});

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
        if( currTableList[tableNo] == 0 ) {
            tableOpts.push(tableNo);
        }
    }
    
    
//    for( x in possibleTables ) {
//        var table = possibleTables[x];
//        for( tableNo in currTableList[table] ) {
//            if( currTableList[table][tableNo] == 0 ) {
//                tableOpts.push(table+"-"+tableNo);
//            }
//        }
//    }

    if( tableOpts.length > 0 ) {
        var tableOptsHtml = "<option value=''>Select</option>";
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
        currTableList[tableNo] = partyName;
        
        if( nextAvailableAt[noOfPeople] == 0 || typeof nextAvailableAt[noOfPeople] === "undefined") {
            var tablesLeft = false;
            var possibleTables = tableCapacity[noOfPeople];
            var x;
            for( x in possibleTables ) {
                if( currTableList[possibleTables[x]] == 0 ) {
                    tablesLeft = true;
                    break;
                }
            }
        }
        
        if( !tablesLeft ) {
            
        }
        refreshTableList();
    }
    else {
        var waitTime
        if( waitList.length == 0 ) {
            waitTime = Math.round(tableTurnTime[noOfPeople] + bufferTime[noOfPeople]);
        }
        else {
            var priorWait = [];
            for( y in waitList ) {
                var partyNoOfPeople = waitList[y].noOfPeople;
                if( typeof priorWait[partyNoOfPeople] === "undefined" ) {
                    priorWait[partyNoOfPeople] = 1;
                }
                else {
                    priorWait[partyNoOfPeople] = priorWait[partyNoOfPeople] + 1;
                }
            }
            if( typeof priorWait[noOfPeople] === "undefined" ) {
                waitTime = Math.round( tableTurnTime[noOfPeople] + bufferTime[noOfPeople] );
            }
            else {
                waitTime = Math.round( tableTurnTime[noOfPeople] + bufferTime[noOfPeople] ) * ( priorWait[noOfPeople]+1 );
            }
        }
        waitList.push({name:partyName,noOfPeople:noOfPeople,num:partyNum,waitTime:waitTime});
        refreshWaitList();
    }
    clearForm();
    
//    if( $("#tablesOptions").val() !== null  ) {
//        var tableDtls = $("#tablesOptions").val().split("-");
//        var tableFor = tableDtls[0];
//        var tableNo = tableDtls[1];
//        currTableList[tableFor][tableNo] = partyName;
//        
//        //Find out if all possible tables for the given noOfPeople are full
//        if( nextAvailableAt[noOfPeople] == 0 || typeof nextAvailableAt[noOfPeople] === "undefined") {
//            var possibleTables = tableCapacity[noOfPeople];
//            var x;
//            var tablesLeft = false;
//            for( x in possibleTables ) {
//                var table = possibleTables[x];
//                for( tableNo in currTableList[table] ) {
//                    if( currTableList[table][tableNo] == 0 ) {
//                        tablesLeft = true;
//                        break;
//                    }
//                }
//            }
//            
//            if( !tablesLeft ) {
//                var waitTime
//                if( waitList.length == 0 ) {
//                    waitTime = Math.round(tableTurnTime[noOfPeople] + bufferTime[noOfPeople]);
//                }
//                else {
//                    var priorWait = [];
//                    for( y in waitList ) {
//                        var partyNoOfPeople = waitList[y].noOfPeople;
//                        if( typeof priorWait[partyNoOfPeople] === "undefined" ) {
//                            priorWait[partyNoOfPeople] = 1;
//                        }
//                        else {
//                            priorWait[partyNoOfPeople] = priorWait[partyNoOfPeople] + 1;
//                        }
//                    }
//                    if( typeof priorWait[noOfPeople] === "undefined" ) {
//                        waitTime = Math.round( tableTurnTime[noOfPeople] + bufferTime[noOfPeople] );
//                    }
//                    else {
//                        waitTime = Math.round( tableTurnTime[noOfPeople] + bufferTime[noOfPeople] ) * ( priorWait[noOfPeople]+1 );
//                    }
//                }
//                //var waitTime = Math.round(tableTurnTime[noOfPeople] + bufferTime[noOfPeople]);
//                var nextAt = addMinutes(currDate, waitTime);
//                if( typeof nextAvailableAt[noOfPeople] === "undefined" ) {
//                    //nextAvailableAt[noOfPeople] = nextAt.toLocaleString();
//                    nextAvailableAt[noOfPeople] = nextAt;
//                }
//                else {
//                    //nextAvailableAt[noOfPeople] = nextAt.toLocaleString();
//                    nextAvailableAt[noOfPeople] = nextAt;
//                }
//            }
//        }console.debug(nextAvailableAt);
//        refreshTableList();
//    }
//    else {
//        var waitTime
//        if( waitList.length == 0 ) {
//            waitTime = Math.round(tableTurnTime[noOfPeople] + bufferTime[noOfPeople]);
//        }
//        else {
//            var priorWait = [];
//            for( y in waitList ) {
//                var partyNoOfPeople = waitList[y].noOfPeople;
//                if( typeof priorWait[partyNoOfPeople] === "undefined" ) {
//                    priorWait[partyNoOfPeople] = 1;
//                }
//                else {
//                    priorWait[partyNoOfPeople] = priorWait[partyNoOfPeople] + 1;
//                }
//            }
//            if( typeof priorWait[noOfPeople] === "undefined" ) {
//                waitTime = Math.round( tableTurnTime[noOfPeople] + bufferTime[noOfPeople] );
//            }
//            else {
//                waitTime = Math.round( tableTurnTime[noOfPeople] + bufferTime[noOfPeople] ) * ( priorWait[noOfPeople]+1 );
//            }
//        }
//        console.debug(waitTime);
//        var newNextAt;
//        if( nextAvailableAt[noOfPeople] == 0 || typeof nextAvailableAt[noOfPeople] === "undefined" ) {
//            waitTime = Math.round(tableTurnTime[noOfPeople] + bufferTime[noOfPeople]);
//            newNextAt = addMinutes(currDate,waitTime);
//        }
//        else {
//            var diff = Math.abs( new Date(nextAvailableAt[noOfPeople]) - new Date(currDate) );
//            waitTime = Math.round((diff/1000)/60);
//            var nextTableIn = Math.round(tableTurnTime[noOfPeople] + bufferTime[noOfPeople]);
//            newNextAt = addMinutes(new Date(nextAvailableAt[noOfPeople]),nextTableIn);
//        }
//        nextAvailableAt[noOfPeople] = newNextAt;
//        waitList.push({name:partyName,noOfPeople:noOfPeople,num:partyNum,waitTime:waitTime});
////        if( waitList.length == 0 ) {
////            waitTime = (tableTurnTime[noOfPeople] * 1) + bufferTime[noOfPeople];
////            waitList.push({name:partyName,noOfPeople:noOfPeople,num:partyNum,waitTime:waitTime});
////        }
////        else {
////            for( x in waitList ) {
////                var partyNoOfPeople = waitList[x].noOfPeople;
////                if( typeof priorWait[partyNoOfPeople] === "undefined" ) {
////                    priorWait[partyNoOfPeople] = 1;
////                }
////                else {
////                    priorWait[partyNoOfPeople] = priorWait[partyNoOfPeople] + 1;
////                }
////            }
////            waitTime = (tableTurnTime[noOfPeople] * (priorWait[noOfPeople]+1)) + bufferTime[noOfPeople];
////            waitList.push({name:partyName,noOfPeople:noOfPeople,num:partyNum,waitTime:waitTime});
////        }
//        refreshWaitList();
//    }
    
//    clearForm();
    
//    var partyCount = $("#partyCount").val();
//    var possibleTables = tableCapacity[partyCount];
//    var x;
//    var partySeated = false;
//    var tableGiven;
//    var partyName = $("#partyName").val();
//    for( x in possibleTables ) {
//        if( !partySeated ) {
//            var table = possibleTables[x];
//            var index = currTableList[table].indexOf(0);
//            if( index != -1 ) {
//                currTableList[table][index] = partyName;
//                partySeated = true;
//                tableGiven = table;
//                break;
//            }
//        }
//    }
//    
//    if( partySeated ) {
//        refreshTableList();
//    }
//    else {
//        refreshWaitList( $("#partyName").val(), partyCount, $("#partyNum").val() );
//        if( typeof waitList[partyCount] === "undefined" ) {
//            waitList[partyCount] = 1;
//        }
//        else {
//            waitList[partyCount] = waitList[partyCount] + 1;
//        }
//        showWaitTime();
//    }
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
        
        if( currTableList[tableNo] == 0 ) {
            tableListHtml += '<span style="color:grey;">'+tableNo+'</span> | ';
        }
        else {
            tableListHtml += '<span style="color:blue;cursor:pointer;" title="Clear Table" onclick="clearTable(\''+tableNo+'\');">'+currTableList[tableNo]+' ('+tableNo+')</span> | ';
        }
        
        if( i%4 == 0 || noOfTables == i ) {
            tableListHtml += '</li><li>';
        }
        
        if( noOfTables == i ) {
            tableListHtml += '</li>';
        }
    }
    $("#tableList").html(tableListHtml);
//    for( table in currTableList ) {
//        var currTable = currTableList[table];
//        tableListHtml += "<li>T"+table+":";
//        for(tableNo in currTable ) {
//            if( currTable[tableNo] == 0 ) {
//                tableListHtml += ' <span style="color:grey;">'+tableNo+'</span> |';
//            }
//            else {
//                tableListHtml += ' <span title="Clear Table" style="color:blue;cursor:pointer" onclick="clearTable(\''+table+'\',\''+tableNo+'\');">'+tableNo+'</span> |';
//            }
//        }
//        tableListHtml += "</li>";
//    }
//    $("#tableList").html(tableListHtml);
}

function clearTable( tableFor, tableNo ) {
    var confirmAction = confirm("You sure the party at table no "+tableNo+" is done?");
    if( confirmAction == true ) {
        currTableList[tableFor][tableNo] = 0;
        refreshTableList();
    }
}

function refreshWaitList() {
    var waitListHtml = "";
    if( waitList.length > 0 ) {
        for( x in waitList ) {
            var currWait = waitList[x];
            waitListHtml += "<li>"+currWait.name+" "+currWait.num+" "+currWait.noOfPeople+" "+currWait.waitTime+"mins <span title='Remove party from wait list' style='color:blue;cursor:pointer' onclick=\"removeFromWaitList("+x+")\">Remove</span></li>";
        }
    }
    $("#waitList").html(waitListHtml);
}

function removeFromWaitList( index ) {
    waitList.splice(index,1);
    if( waitList.length == 0 ) {
        $("#waitList").html("");
    }
}

function showWaitTime() {
    //Estimate wait time
    //Update the wait list array
    var partyCount = $("#partyCount").val();
    var waitTime = (tableTurnTime[partyCount] * waitList[partyCount]) + bufferTime[partyCount];
    console.debug(currTableList);console.debug(waitTime);
}

</script>

<section id="left-column">
    <section class="sale" id="hotelDtls">
        <h1>Hotel Details</h1>
        <ul>
            <li>
                Total Tables: 
            </li>
            <li>
                
            </li>
        </ul>
    </section>
    <section class="sale" id="addNewParty">
        <h1>Add new party</h1>
        <ul>
            <li>
                Name: <input id="partyName" name="partyName" class="partyDtls" placeholder="Add one name from the party" value=""/>
            </li>
            <li>
                No of People: <input id="partyCount" name="partyCount" class="partyDtls numeric" placeholder="No of people in the party" value=""/>
            </li>
            <li>
                Number: <input id="partyNum" name="partyNum" class="partyDtls numeric" placeholder="Mobile Number" value=""/>
            </li>
            <li id="selectTable" style="display:none;">
                Table: 
                <select id="tablesOptions">
                </select>
            </li>
            <li>
                <button type="button" id="addParty" name="addParty" onclick="getSeatingLeft();">Add</button>
                <button type="button" id="clearForm" name="clearForm" onclick="clearForm();">Reset</button>
            </li>
        </ul>
    </section>
    <section class="sale" id="waitListDiv">
        <h1>Wait List</h1>
        <ul id="waitList">
        </ul>
    </section>
    <section class="sale" id="tableListDiv">
        <h1>Tables List</h1>
        <ul id="tableList">
            
        </ul>
    </section>
</section>

