<?php
global $global_params;
global $page_params;

?>
<script type="text/javascript" src="<?php echo JS_URL.PAGE_JS_FEEDBACK;?>"></script>
<section id="left-column">
    <section class="sale" id="seatedCustomers">
        <h1>Seated Customers</h1>
        <ul>
            <li class="center"><i>*Tap on a table to get feedback</i></li>
        </ul>
        <ul id="tableList">
            <?php echo $seatedCusts; ?>
        </ul>
    </section>
    
    <input type="hidden" id="restId" name="restId" value="<?php echo base64_encode($restId); ?>" />
    <section class="sale" id="todayPerf">
        <h1>Today's Performance</h1>
        <ul>
            <li class="center"><?php echo date("d-m-y"); ?></li>
        </ul>            
        <ul class="loadingUl show">
            <li class="center loading"><i>Loading!!!</i></li>
        </ul>
        <ul class="hotel hide scoreUl">
            <li>
                <label>Net Promoter Score</label>
                <strong>:</strong>
                <span id="todayNps"></span>
            </li>
            <li>
                <label>Ambience</label>
                <strong>:</strong>
                <span id="todayAmbience"></span>
            </li>
            <li>
                <label>Quality of Food</label>
                <strong>:</strong>
                <span id="todayFoodQuality"></span>
            </li>
            <li>
                <label>Friendliness of Staff</label>
                <strong>:</strong>
                <span id="todayStaffFriendly"></span>
            </li>
            <li>
                <label>Cleanliness</label>
                <strong>:</strong>
                <span id="todayCleanliness"></span>
            </li>
            <li>
                <label>Speed of Service</label>
                <strong>:</strong>
                <span id="todayServiceSpeed"></span>
            </li>
        </ul>
    </section>
    <section class="sale" id="yesterdayPerf">
        <h1>Yesterday's Performance</h1>
        <ul>
            <li class="center"><?php echo date("d-m-y", strtotime("yesterday")); ?></li>
        </ul>
        <ul class="loadingUl show">
            <li class="center loading"><i>Loading!!!</i></li>
        </ul>
        <ul class="hotel hide scoreUl">
            <li>
                <label>Net Promoter Score</label>
                <strong>:</strong>
                <span id="yesterdayNps"></span>
            </li>
            <li>
                <label>Ambience</label>
                <strong>:</strong>
                <span id="yesterdayAmbience"></span>
            </li>
            <li>
                <label>Quality of Food</label>
                <strong>:</strong>
                <span id="yesterdayFoodQuality"></span>
            </li>
            <li>
                <label>Friendliness of Staff</label>
                <strong>:</strong>
                <span id="yesterdayStaffFriendly"></span>
            </li>
            <li>
                <label>Cleanliness</label>
                <strong>:</strong>
                <span id="yesterdayCleanliness"></span>
            </li>
            <li>
                <label>Speed of Service</label>
                <strong>:</strong>
                <span id="yesterdayServiceSpeed"></span>
            </li>
        </ul>
    </section>
    <section class="sale" id="thisWeekPerf">
        <h1>This Week's Performance</h1>
        <ul>
            <li class="center"><?php echo date("d-m-y", strtotime("monday this week")); ?> to <?php echo date("d-m-y"); ?></li>
        </ul>
        <ul class="loadingUl show">
            <li class="center loading"><i>Loading!!!</i></li>
        </ul>
        <ul class="hotel hide scoreUl">
            <li>
                <label>Net Promoter Score</label>
                <strong>:</strong>
                <span id="thisWeekNps"></span>
            </li>
            <li>
                <label>Ambience</label>
                <strong>:</strong>
                <span id="thisWeekAmbience"></span>
            </li>
            <li>
                <label>Quality of Food</label>
                <strong>:</strong>
                <span id="thisWeekFoodQuality"></span>
            </li>
            <li>
                <label>Friendliness of Staff</label>
                <strong>:</strong>
                <span id="thisWeekStaffFriendly"></span>
            </li>
            <li>
                <label>Cleanliness</label>
                <strong>:</strong>
                <span id="thisWeekCleanliness"></span>
            </li>
            <li>
                <label>Speed of Service</label>
                <strong>:</strong>
                <span id="thisWeekServiceSpeed"></span>
            </li>
        </ul>
    </section>
    <section class="sale" id="lastWeekPerf">
        <h1>Last Week's Performance</h1>
        <ul>
            <li class="center"><?php echo date("d-m-y", strtotime("monday last week")); ?> to <?php echo date("d-m-y", strtotime("monday this week")); ?></li>
        </ul>
        <ul class="loadingUl show">
            <li class="center loading"><i>Loading!!!</i></li>
        </ul>
        <ul class="hotel hide scoreUl">
            <li>
                <label>Net Promoter Score</label>
                <strong>:</strong>
                <span id="lastWeekNps"></span>
            </li>
            <li>
                <label>Ambience</label>
                <strong>:</strong>
                <span id="lastWeekAmbience"></span>
            </li>
            <li>
                <label>Quality of Food</label>
                <strong>:</strong>
                <span id="lastWeekFoodQuality"></span>
            </li>
            <li>
                <label>Friendliness of Staff</label>
                <strong>:</strong>
                <span id="lastWeekStaffFriendly"></span>
            </li>
            <li>
                <label>Cleanliness</label>
                <strong>:</strong>
                <span id="lastWeekCleanliness"></span>
            </li>
            <li>
                <label>Speed of Service</label>
                <strong>:</strong>
                <span id="lastWeekServiceSpeed"></span>
            </li>
        </ul>
    </section>
</section>