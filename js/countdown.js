(function($) {
	$.fn.countdown = function(options, callback) {

		//custom 'this' selector
		thisEl = $(this);

		//array of custom settings
		var settings = { 
			'date': null,
			'format': null
		};

		//append the settings array to options
		if(options) {
			$.extend(settings, options);
		}
		
		//main countdown function
		function countdown_proc() {
			

			var currentdate = new Date(); 

			//var days= ((currentdate.getDate() < 10)?"0":"") + currentdate.getDate() +"/"+(((currentdate.getMonth()+1) < 10)?"0":"") + (currentdate.getMonth()+1) +"/"+ currentdate.getFullYear();
			var hours = currentdate.getHours();
			var minutes = currentdate.getMinutes();
			var seconds = currentdate.getSeconds();

			//eventDate = Date.parse(settings['date']) / 1000;
			//currentDate = Math.floor($.now() / 1000);
			
			//if(eventDate <= currentDate) {
			//	callback.call(this);
			//	clearInterval(1000);
			//}
			
			//seconds = eventDate - currentDate;
			
			//days = Math.floor(seconds / (60 * 60 * 24)); //calculate the number of days
			//seconds -= days * 60 * 60 * 24; //update the seconds variable with no. of days removed
			
			//hours = Math.floor(seconds / (60 * 60));
			//seconds -= hours * 60 * 60; //update the seconds variable with no. of hours removed
			
			//minutes = Math.floor(seconds / 60);
			//seconds -= minutes * 60; //update the seconds variable with no. of minutes removed
			
			//conditional Ss
			//if (days == 1) { thisEl.find(".timeRefDays").text("day"); } else { thisEl.find(".timeRefDays").text("days"); }
			if (hours == 1) { thisEl.find(".timeRefHours").text("hora"); } else { thisEl.find(".timeRefHours").text("horas"); }
			if (minutes == 1) { thisEl.find(".timeRefMinutes").text("minuto"); } else { thisEl.find(".timeRefMinutes").text("minutos"); }
			if (seconds == 1) { thisEl.find(".timeRefSeconds").text("segundo"); } else { thisEl.find(".timeRefSeconds").text("segundos"); }
			
			//logic for the two_digits ON setting
			if(settings['format'] == "on") {
			//	days = (String(days).length >= 2) ? days : "0" + days;
				hours = (String(hours).length >= 2) ? hours : "0" + hours;
				minutes = (String(minutes).length >= 2) ? minutes : "0" + minutes;
				seconds = (String(seconds).length >= 2) ? seconds : "0" + seconds;
			}
			

			//update the countdown's html values.
			//if(!isNaN(eventDate)) {
				//thisEl.find(".days").text(days);
				thisEl.find(".hours").text(hours);
				thisEl.find(".minutes").text(minutes);
				thisEl.find(".seconds").text(seconds);
			//} else { 
			//	alert("Invalid date. Here's an example: 12 Tuesday 2012 17:30:00");
			//	clearInterval(interval); 
			//}
		}
		
		//run the function
		countdown_proc();
		
		//loop the function
		interval = setInterval(countdown_proc, 1000);
		
	}
}) (jQuery);