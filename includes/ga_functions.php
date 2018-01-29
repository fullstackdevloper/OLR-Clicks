<?php  
    function get_distinct_outgoing_link_clicks_from_db(){

        if(isset($_POST['submit']) && isset($_POST['searc_type']) && $_POST['searc_type'] == 'date'){
            $start_date = $_POST['start_datepicker'];
            $end_date = $_POST['end_datepicker'];
            global $wpdb;
            $table_name = $wpdb->prefix . "ga_analytics";
       
           $sqlQuery = "Select *, COUNT(*) as count from ".$table_name." WHERE `time_created` >= '".$start_date."' AND `time_created` <= '".$end_date."' GROUP BY `outgoing_link`";
            return $getAlldata =  $wpdb->get_results( $sqlQuery );

        }elseif(isset($_POST['submit']) && isset($_POST['searc_type']) && $_POST['searc_type'] == 'selection'){

           $todayDateTime = date('Y-m-d H:i:s');
            global $wpdb;
            $table_name = $wpdb->prefix . "ga_analytics";
         
           
            switch($_POST['range_time']){
                case 'day':
                             $sqlQuery = "Select *, COUNT(*) as count from ".$table_name." WHERE `time_created` > DATE_SUB(NOW(), INTERVAL 1 DAY) GROUP BY `outgoing_link`";
                            break;
                case 'week':
                             $sqlQuery = "Select *, COUNT(*) as count from ".$table_name." WHERE `time_created` > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY `outgoing_link`";
                             break;     
                case 'month':
                             $sqlQuery = "Select *, COUNT(*) as count from ".$table_name." WHERE `time_created` > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY `outgoing_link`";
                            break;  
                case 'year':
                            $sqlQuery = "Select *, COUNT(*) as count from ".$table_name." WHERE `time_created` > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY `outgoing_link`";
                            break;                           

            }
            return $getAlldata =  $wpdb->get_results( $sqlQuery );

        }else{
            global $wpdb;
            $table_name = $wpdb->prefix . "ga_analytics";
            $sqlQuery = "Select *, count(*) as count from ".$table_name." GROUP BY outgoing_link";
            return $getAlldata =  $wpdb->get_results( $sqlQuery );
        } 
    }

    function get_distinct_pages_outgoing_link_clicks_from_db(){
        if(isset($_POST['submit']) && isset($_POST['searc_type']) && $_POST['searc_type'] == 'date'){
            $start_date = $_POST['start_datepicker'];
            $end_date = $_POST['end_datepicker'];
            global $wpdb;
            $table_name = $wpdb->prefix . "ga_analytics";
       
           $sqlQuery = "Select *, COUNT(*) as count from ".$table_name." WHERE `time_created` >= '".$start_date."' AND `time_created` <= '".$end_date."' GROUP BY `page `";
            return $getAlldata =  $wpdb->get_results( $sqlQuery );

        }elseif(isset($_POST['submit']) && isset($_POST['searc_type']) && $_POST['searc_type'] == 'selection'){

           $todayDateTime = date('Y-m-d H:i:s');
            global $wpdb;
            $table_name = $wpdb->prefix . "ga_analytics";
         
           
            switch($_POST['range_time']){
                case 'day':
                             $sqlQuery = "Select *, COUNT(*) as count from ".$table_name." WHERE `time_created` > DATE_SUB(NOW(), INTERVAL 1 DAY) GROUP BY `page`";
                            break;
                case 'week':
                             $sqlQuery = "Select *, COUNT(*) as count from ".$table_name." WHERE `time_created` > DATE_SUB(NOW(), INTERVAL 1 WEEK) GROUP BY `page`";
                             break;     
                case 'month':
                             $sqlQuery = "Select *, COUNT(*) as count from ".$table_name." WHERE `time_created` > DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY `page`";
                            break;  
                case 'year':
                            $sqlQuery = "Select *, COUNT(*) as count from ".$table_name." WHERE `time_created` > DATE_SUB(NOW(), INTERVAL 1 YEAR) GROUP BY `page`";
                            break;                           

            }
            return $getAlldata =  $wpdb->get_results( $sqlQuery );

        }else{
            global $wpdb;
            $table_name = $wpdb->prefix . "ga_analytics";
            $sqlQuery = "Select *, count(*) as count from ".$table_name." GROUP BY page";
            return $getAlldata =  $wpdb->get_results( $sqlQuery );
        }    
    }
    function get_page_outgoing_link_clicks_from_db($getURL = null){
        if(isset($_POST['submit']) && isset($_POST['searc_type']) && $_POST['searc_type'] == 'date'){
            $start_date = $_POST['start_datepicker'];
            $end_date = $_POST['end_datepicker'];
            global $wpdb;
            $table_name = $wpdb->prefix . "ga_analytics";
       
           $sqlQuery = "Select *, COUNT(*) as count from ".$table_name." WHERE `time_created` >= '".$start_date."' AND `time_created` <= '".$end_date."' AND `page` = '".$getURL ."' GROUP BY `outgoing_link`";
            return $getAlldata =  $wpdb->get_results( $sqlQuery );

        }elseif(isset($_POST['submit']) && isset($_POST['searc_type']) && $_POST['searc_type'] == 'selection'){

           $todayDateTime = date('Y-m-d H:i:s');
            global $wpdb;
            $table_name = $wpdb->prefix . "ga_analytics";
         
           
            switch($_POST['range_time']){
                case 'day':
                             $sqlQuery = "Select *, COUNT(*) as count from ".$table_name." WHERE `time_created` > DATE_SUB(NOW(), INTERVAL 1 DAY) AND page = '".$getURL ."' GROUP BY `outgoing_link`";
                            break;
                case 'week':
                             $sqlQuery = "Select *, COUNT(*) as count from ".$table_name." WHERE `time_created` > DATE_SUB(NOW(), INTERVAL 1 WEEK) AND page = '".$getURL ."' GROUP BY `outgoing_link`";
                             break;     
                case 'month':
                             $sqlQuery = "Select *, COUNT(*) as count from ".$table_name." WHERE `time_created` > DATE_SUB(NOW(), INTERVAL 1 MONTH) AND page = '".$getURL ."' GROUP BY `outgoing_link`";
                            break;  
                case 'year':
                            $sqlQuery = "Select *, COUNT(*) as count from ".$table_name." WHERE `time_created` > DATE_SUB(NOW(), INTERVAL 1 YEAR) AND  page = '".$getURL ."' GROUP BY `outgoing_link`";
                            break;                           

            }
            return $getAlldata =  $wpdb->get_results( $sqlQuery );

        }else{
            global $wpdb;
            $table_name = $wpdb->prefix . "ga_analytics";
            $sqlQuery = "Select *, count(*) as count from ".$table_name." WHERE page = '".$getURL ."' GROUP BY outgoing_link";
            return $getAlldata =  $wpdb->get_results( $sqlQuery );
        }
    }
    function export_to_csv(){
        global $wpdb;
        $table_name = $wpdb->prefix . "ga_analytics";
        $sqlQuery = "Select * from ".$table_name." GROUP BY page";
        $getAlldata =  $wpdb->get_results( $sqlQuery );
    
        $tableHTML = '<table id="export_to_C" style="display:none;">
                        <tr>
                            <td>Page</td><td>Outgoing URL</td><td>clicks on outgoing URL</td>
                        </tr>';
        foreach($getAlldata as $singleData){
     
            $sqlQuery2 = "Select *, count(*) as count from ".$table_name." WHERE page = '".$singleData->page ."' GROUP BY outgoing_link";
             $getAlldata2 =  $wpdb->get_results( $sqlQuery2 );
             
             foreach( $getAlldata2 as  $singleData2){
                $tableHTML .= '<tr><td>'.$singleData2->page.'</td><td>'.$singleData2->outgoing_link.'</td><td>'.$singleData2->count.'</td></tr>';
             }
        }
        
        $tableHTML .='</table>';
        return $tableHTML;
    }?>