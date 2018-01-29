<?php
require_once('ga_functions.php');	
$getResult = get_page_outgoing_link_clicks_from_db($_REQUEST['href']);	
?>
<h2>Track of "<?php echo $_REQUEST['href']; ?>" Outgoing links Clicks</h2>
<div id="page_outgoing_links">
<button class="export_button">
<a href="#" id="pageOutgoingLinksClicks">Export Data Into Excel</a>
</button>
<div>
        <form  method="post" enctype="multipart/form-data" class="form_10">
            <input type="hidden" value="date" name="searc_type"/>
           From:  <input required type="text" autocomplete="off" class="datepicker" id="start_datepicker" name="start_datepicker"/>
           To:  <input required type="text" autocomplete="off" class="datepicker" id="end_datepicker" name="end_datepicker"/>
                <?php submit_button('Search') ?>
        </form>
    </div>
    <div>
     <form  method="post" enctype="multipart/form-data" class="form_11">
            <input type="hidden" value="selection" name="searc_type"/>
            <select required name="range_time">
                 <option value="">---Select Duration ---</option>
                 <option value="day">Today</option>
                 <option value="week">Last Week</option>
                 <option value="month">Last Month</option>
                 <option value="year">Last Year</option>
            </select>
                <?php submit_button('Search') ?>
        </form>
      </div>  
<table id="table2" class="display" width="100%" cellspacing="0">
        <thead>
            <tr>
                <td width="50%">Outgoing URL</td>
                <td width="20%">Clicks</td>
            </tr>
        </thead>
        <tbody>
<?php 
foreach($getResult as $singleResult ):
?>		 
            <tr>
                <td align="center"><?php echo  $singleResult->outgoing_link; ?></td>
                <td align="center"><?php echo  $singleResult->count; ?></td>
            </tr>
<?php 
endforeach;
?>        </tbody>
    </table>	
 </div>   