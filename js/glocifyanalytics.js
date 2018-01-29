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



	

	 



	var currentweburl = ga_getDomain(document.location.origin);

	

    $('body').find('a').each(function() {

		var ga_hreffull = ga_getDomain(($(this).attr('href')));

		var ga_substring = '#';

		if(ga_hreffull.indexOf(ga_substring) == -1){

			if(currentweburl !== ga_hreffull ){

				$(this).addClass("gaAnalytics");

			}

		}

	});

	

	$('.gaAnalytics').contextmenu(function(e){

			e.preventDefault(); 

			var linkName = $(this).text();

			var linkURL = $(this).attr('href');

			var currentPage = window.location.href;

			$.ajax({

					type : "post",

					url : ajaxurl,

					data : {action: "save_clicks_data", linkName:linkName, linkURL:linkURL, currentPage:currentPage },

					success: function(response) {
						if(e.which == 3 ){
							window.open(linkURL, '_blank');
						}
					}

				}); 



	});


	$('.gaAnalytics').bind('mousedown',function(e){
			if(e.which == 3){

				return false;
			}

			e.preventDefault();  

			var linkName = $(this).text();

			var linkURL = $(this).attr('href');
			
			var targetValue = $(this).attr('target');

			var currentPage = window.location.href;

			$.ajax({

					type : "post",

					url : ajaxurl,

					data : {action: "save_clicks_data", linkName:linkName, linkURL:linkURL, currentPage:currentPage },

					success: function(response) {
						if(response == 'true') {
							if(e.which == 1 ){
								//alert(targetValue);
		                        if(targetValue !== '_blank'){
									window.location.href = linkURL;
								}								
							}
						}else{

							console.log("false");

						}

					}

				}); 

	});

})(jQuery);