<?php
global $global_params;
global $page_params;

if( $_SESSION[SESSION_USER_TYPE] == $users::SUPER_USER ) {
    $selectRest = "";
    $selectRest .= "<select id='selectRest' name='selectRest' onchange='selectRest();'><option value=''>Select Restaruant</option>";
    if( !empty($pageArgs['restId']) ) {
        $selectedRest = $pageArgs['restId'];
    }
    foreach( $restList as $restDtls ) {
        if( $selectedRest == $restDtls['restId'] ) {
            $selectedOpt = "selected";
        }
        else {
            $selectedOpt = "";
        }
        
        $selectRest .= "<option {$selectedOpt} value='{$restDtls['restId']}' >{$restDtls['restName']}</option>";
    }
    $selectRest .= "</select>";
    echo $selectRest;
}

if( !empty($restId) ) {
?>
<script type="text/javascript">
var totalTables = <?php echo $totalTables; ?>;
var avgTimeAtTable = <?php echo json_encode($avgTimeAtTable); ?>;
var tableCapacity = <?php echo json_encode($tableCapacity); ?>;
var currTableList = <?php echo json_encode($currTableList); ?>;
var waitList = <?php echo json_encode($waitList); ?>;
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
    <section class="sale" id="addNewParty">
        <input id="restId" type="hidden" value="<?php echo $restId; ?>"/>
        <h1>Add new party</h1>
        <ul>
            <li>
                <input size="30" id="partyName" name="partyName" class="inpTxtBox partyDtls" placeholder="Add one name from the party" value="" type="text"/>
            </li>
            <li>
                <input size="30" type="number" id="partyCount" name="partyCount" class="inpTxtBox partyDtls numeric" placeholder="No of people in the party" value="" maxlength="10"/>
            </li>
            <li>
                <input  size="30" type="number" id="partyNum" name="partyNum" class="inpTxtBox partyDtls numeric" placeholder="Mobile Number" value="" maxlength="10"/>
            </li>
            <li id="selectTable" style="display:none;">
                <select class="inpTxtBox" id="tablesOptions">
                </select>
            </li>
            <li class="center">
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
        <h1>Tables List (<?php echo $totalTables; ?>)</h1>
        <ul>
            <li class="center"><i>*Tap on a table to clear it</i></li>
        </ul>
        <ul id="tableList">
            
        </ul>
    </section>
</section>
<?php } ?>