<?php
global $global_params;
global $page_params;

?>
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
</section>