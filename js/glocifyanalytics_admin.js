function ga_getDomain(url) {
    var prefix = /^https?:\/\//;
    var domain = /^[^\/:]+/;
    // remove any prefix
    url = url.replace(prefix, "");
    // assume any URL that starts with a / is on the current page's domain
    if (url.charAt(0) === "/") {
        url = window.location.hostname + url;
    }
    // now extract just the domain
    var match = url.match(domain);
    if (match) {
        return(match[0]);
    }
    return(null);
}


(function($){
    function exportTableToCSV($table, filename) {

            console.log($table);
            console.log(filename);
            var $rows = $table.find('tr'),
        
              // Temporary delimiter characters unlikely to be typed by keyboard
              // This is to avoid accidentally splitting the actual contents
              tmpColDelim = String.fromCharCode(11), // vertical tab character
              tmpRowDelim = String.fromCharCode(0), // null character
        
              // actual delimiter characters for CSV format
              colDelim = '","',
              rowDelim = '"\r\n"',
        
              // Grab text from table into CSV formatted string
              csv = '"' + $rows.map(function(i, row) {
                var $row = $(row),
                  $cols = $row.find('td');
               
                return $cols.map(function(j, col) {
                  var $col = $(col),
                    text = $col.text();
        
                  return text.replace(/"/g, '""'); // escape double quotes
        
                }).get().join(tmpColDelim);
        
              }).get().join(tmpRowDelim).split(tmpRowDelim).join(rowDelim).split(tmpColDelim).join(colDelim) + '"';
     
            // Deliberate 'false', see comment below
            if (false && window.navigator.msSaveBlob) {
        
              var blob = new Blob([decodeURIComponent(csv)], {
                type: 'text/csv;charset=utf8'
              });
        
              // Crashes in IE 10, IE 11 and Microsoft Edge
              // See MS Edge Issue #10396033
              // Hence, the deliberate 'false'
              // This is here just for completeness
              // Remove the 'false' at your own risk
              window.navigator.msSaveBlob(blob, filename);
        
            } else if (window.Blob && window.URL) {
              // HTML5 Blob        
              var blob = new Blob([csv], {
                type: 'text/csv;charset=utf-8'
              });
              var csvUrl = URL.createObjectURL(blob);
        
              $(this)
                .attr({
                  'download': filename,
                  'href': csvUrl
                });
            } else {
              // Data URI
              var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);
        
              $(this)
                .attr({
                  'download': filename,
                  'href': csvData,
                  'target': '_blank'
                });
            }
          }



	var currentweburl = ga_getDomain(document.location.origin);

    $('#table1').DataTable();
    $('#table2').DataTable();
    $('#table3').DataTable();


    $("#outgoingLinksClicks").on('click', function(event) {
        // CSV
        var args = [$('#table1'), 'Outgoing_Links_Clicks.csv'];
    
        exportTableToCSV.apply(this, args);

      });
    $("#pageOutgoingLinksClicks").on('click', function(event) {

        var args = [$('#table2'), 'Pages_Outgoing_Links_Clicks.csv'];
        exportTableToCSV.apply(this, args);

      });  
 
      $("#newClick").on('click', function(event) { });  

     

   $("#pageLinksClicks").on('click', function(e) {
      var args = [$('#export_to_C'), 'Pages_Outgoing_Links_Clicks.csv'];
      exportTableToCSV.apply(this, args); 
    });

    //$(".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });

    var startDateTextBox = $('#start_datepicker');
    var endDateTextBox = $('#end_datepicker');
    

   $('#end_datepicker').datetimepicker({
      dateFormat: 'yy-mm-dd',
      timeFormat: "HH:mm:ss",
      hour: '23',
      minute:'59',
      second:'59',
      

    });

    $('#start_datepicker').datetimepicker({
      dateFormat: 'yy-mm-dd',
      timeFormat: "HH:mm:ss",
      hour: '00',
      minute:'00',
      second:'00',
      
    });

   /* $.timepicker.datetimeRange(
      startDateTextBox,
      endDateTextBox,
      {
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss',
        maxInterval: (1000*60*60*24*30), // 8 days
        start: {}, // start picker options
        end: { timeFormat: "HH:mm:ss",
        hour: '00',
        minute:'00',
        second:'00',} // end picker options
      }
    );*/


})(jQuery);