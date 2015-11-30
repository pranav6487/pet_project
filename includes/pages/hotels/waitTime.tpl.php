<?php
global $global_params;
global $page_params;
?>
Implement condition for no of people in party more than 9<br />
Option to put a customer on wait list and not allot a specific table - is it really needed?<br />
<script type="text/javascript">
var totalTables = <?php echo $totalTables; ?>;
var avgTimeAtTable = <?php echo json_encode($avgTimeAtTable); ?>;
var tableCapacity = <?php echo json_encode($tableCapacity); ?>;
var currTableList = <?php echo json_encode($currTableList); ?>;
var waitList = [];
var tableTurnTime = <?php echo json_encode($tableTurnTime); ?>;
var bufferTime = <?php echo json_encode($bufferTime); ?>;
var nextAvailableAt = <?php echo json_encode($nextAvailableAt); ?>;

var ALLOT_TABLE = <?php echo $restObj::ALLOT_TABLE; ?>;
var ADD_TO_WAIT_LIST = <?php echo $restObj::ADD_TO_WAIT_LIST; ?>;
var EMPTY_TABLE = <?php echo $restObj::EMPTY_TABLE; ?>;
var REMOVE_FROM_WAIT_LIST = <?php echo $restObj::REMOVE_FROM_WAIT_LIST; ?>;
var ALLOT_TABLE_FROM_WAIT_LIST = <?php echo $restObj::ALLOT_TABLE_FROM_WAIT_LIST; ?>;
</script>
<script type="text/javascript" src="<?php echo JS_URL.PAGE_JS_WAITTIME;?>"></script>

<section id="left-column">
    <section class="sale" id="hotelDtls">
        <h1>Hotel Details</h1>
        <ul>
            <li>
                Total Tables: <?php echo count($currTableList); ?>
            </li>
            <li>
                
            </li>
        </ul>
    </section>
    <section class="sale" id="addNewParty">
        <input id="restId" type="hidden" value="<?php echo $restId; ?>"/>
        <h1>Add new party</h1>
        <ul>
            <li>
                Name: <input id="partyName" name="partyName" class="partyDtls" placeholder="Add one name from the party" value="" type="text"/>
            </li>
            <li>
                No of People: <input type="text" id="partyCount" name="partyCount" class="partyDtls numeric" placeholder="No of people in the party" value="" maxlength="10"/>
            </li>
            <li>
                Number: <input type="text" id="partyNum" name="partyNum" class="partyDtls numeric" placeholder="Mobile Number" value="" maxlength="10"/>
            </li>
            <li id="selectTable" style="display:none;">
                Table: 
                <select id="tablesOptions">
                </select>
            </li>
            <li>
                <input type="button" id="addParty" name="addParty" onclick="getSeatingLeft();" value="Add" />
                <input type="button" id="clearForm" name="clearForm" onclick="clearForm();" value="Reset"/>
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
