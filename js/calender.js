jQuery(function(){	
    changedate('return');
});

var myimages=new Array()

function preloadimages(){
	for (i=0;i<preloadimages.arguments.length;i++){
		myimages[i]=new Image();
		myimages[i].src=preloadimages.arguments[i];
	}
}


/* The path of images to be preloaded inside parenthesis: (Extend list as desired.) */
preloadimages(image_path+"PrevYrOff40x40.png",image_path+"PrevYrOn40x40.png",image_path+"PrevMoOff40x40.png",image_path+"PrevMoOn40x40.png",image_path+"NextYrOff40x40.png",image_path+"NextYrOn40x40.png",image_path+"NextMoOff40x40.png",image_path+"NextMoOn40x40.png");


/***************************************************************************************
	JavaScript Calendar - Digital Christian Design
	//Script featured on and available at JavaScript Kit: http://www.javascriptkit.com
	// Functions
		changedate(): Moves to next or previous month or year, or current month depending on the button clicked.
		createCalendar(): Renders the calander into the page with links for each to fill the date form filds above.
			
***************************************************************************************/

var thisDate = 1;							// Tracks current date being written in calendar
var wordMonth = new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
var today = new Date();							// Date object to store the current date
var todaysDay = today.getDay() + 1;					// Stores the current day number 1-7
var todaysDate = today.getDate();					// Stores the current numeric date within the month
var todaysMonth = today.getUTCMonth() + 1;				// Stores the current month 1-12
var todaysYear = today.getFullYear();					// Stores the current year
var monthNum = todaysMonth;						// Tracks the current month being displayed
var yearNum = todaysYear;						// Tracks the current year being displayed
var firstDate = new Date(String(monthNum)+"/1/"+String(yearNum));	// Object Storing the first day of the current month
var firstDay = firstDate.getUTCDay();					// Tracks the day number 1-7 of the first day of the current month
var lastDate = new Date(String(monthNum+1)+"/0/"+String(yearNum));	// Tracks the last date of the current month
var numbDays = 0;
var calendarString = "";
var eastermonth = 0;
var easterday = 0;


function changedate(buttonpressed) {
	
	jQuery('.ui-iz-calender-events').slideUp('fast');
	
	if (buttonpressed == "prevyr") yearNum--;
	else if (buttonpressed == "nextyr") yearNum++;
	else if (buttonpressed == "prevmo") monthNum--;
	else if (buttonpressed == "nextmo") monthNum++;
	else  if (buttonpressed == "return") { 
		monthNum = todaysMonth;
		yearNum = todaysYear;
	}

	if (monthNum == 0) {
		monthNum = 12;
		yearNum--;
	}
	else if (monthNum == 13) {
		monthNum = 1;
		yearNum++
	}

	lastDate = new Date(String(monthNum+1)+"/0/"+String(yearNum));
	numbDays = daysInMonth(monthNum-1,yearNum);
	firstDate = new Date(String(monthNum)+"/1/"+String(yearNum));
	firstDay = firstDate.getDay() + 1;
	createCalendar();
	return;
}

function daysInMonth(iMonth, iYear)
	{
	return 32 - new Date(iYear, iMonth, 32).getDate();
	}



function easter(year) {
// feed in the year it returns the month and day of Easter using two GLOBAL variables: eastermonth and easterday
    var a = year % 19;
    var b = Math.floor(year/100);
    var c = year % 100;
    var d = Math.floor(b/4);
    var e = b % 4;
    var f = Math.floor((b+8) / 25);
    var g = Math.floor((b-f+1) / 3);
    var h = (19*a + b - d - g + 15) % 30;
    var i = Math.floor(c/4);
    var j = c % 4;
    var k = (32 + 2*e + 2*i - h - j) % 7;
    var m = Math.floor((a + 11*h + 22*k) / 451);
    var month = Math.floor((h + k - 7*m + 114) / 31);
    var day = ((h + k - 7*m +114) % 31) + 1;
    eastermonth = month;
    easterday = day;
}

function createCalendar() {
	calendarString = '';
	var daycounter = 0;
	calendarString += '<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">';
		calendarString += '<tr style="background-color:'+ headerBGColor +';">';
			calendarString += '<td colspan="7">';
				calendarString += '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
					calendarString += '<tr>';
						calendarString += '<td align="center" valign="center" width="30" height="22"><a href="javascript:changedate(\'prevmo\');"><img name="PrevMo" src="'+image_path+'PrevMoOff40x40.png" width="30" height="22" border="0" ></a></td>';
						calendarString += '<td align="center" valign="center" width="128" height="22" colspan="5"><strong style="color:'+ headerFontColor +';">' + wordMonth[monthNum-1] + '&nbsp;&nbsp;' + yearNum + '</strong></td>';
						calendarString += '<td align="center" valign="center" width="30" height="22" ><a href="javascript:changedate(\'nextmo\');"><img name="NextMo" src="'+image_path+'NextMoOff40x40.png" width="30" height="22" border="0" ></a></td>';
					calendarString += '</tr>';
				calendarString += '</table>';
			calendarString += '</td>';
		calendarString += '</tr>';
		calendarString += '<tr style="background-color:'+ daysBGColor +';color:'+ daysFontColor +';">';
			calendarString += '<td align="center" valign="center" width="40" height="22">S</td>';
			calendarString += '<td align="center" valign="center" width="40" height="22">M</td>';
			calendarString += '<td align="center" valign="center" width="40" height="22">T</td>';
			calendarString += '<td align="center" valign="center" width="40" height="22">W</td>';
			calendarString += '<td align="center" valign="center" width="40" height="22">T</td>';
			calendarString += '<td align="center" valign="center" width="40" height="22">F</td>';
			calendarString += '<td align="center" valign="center" width="40" height="22">S</td>';
		calendarString += '</tr>';

	thisDate = 1;
	for (var i = 1; i <= 6; i++)
		{
		calendarString += '<tr>';
		for (var x = 1; x <= 7; x++)
			{
			daycounter = (thisDate - firstDay)+1;
			thisDate++;
			if ((daycounter > numbDays) || (daycounter < 1)) 
				{
				calendarString += '<td align="center" height="30" width="40" bgcolor="#f2f2f2">&nbsp;</td>';
				} 
			else 
				{
				if (checkevents(daycounter,monthNum,yearNum,i,x) || ((todaysDay == x) && (todaysDate == daycounter) && (todaysMonth == monthNum)))
					{
					if ((todaysDay == x) && (todaysDate == daycounter) && (todaysMonth == monthNum))
						{
						calendarString += '<td id="td-day-'+daycounter+'" align="center" style="background-color:'+ todaysBGColor +';color:'+ todaysFontColor +';" height="30" width="40"><a style="color:'+ todaysFontColor +';" href="javascript:showevents(' + daycounter + ',' + monthNum + ',' + yearNum + ',' + i + ',' + x + ')"><strong>' + daycounter + '</strong></a></td>';
						}
 					else
						{
						calendarString += '<td id="td-day-'+daycounter+'" align="center" style="background-color:'+ hasEventBGColor +';color:'+ hasEventFontColor +';" height="30" width="40"><a style="color:'+ hasEventFontColor +';" href="javascript:showevents(' + daycounter + ',' + monthNum + ',' + yearNum + ',' + i + ',' + x + ')"><strong>' + daycounter + '</strong></a></td>';
						}
					} 
				else
					{
					calendarString += '<td align="center" bgcolor="#FFFFFF" height="30" width="40">' + daycounter + '</td>';
					}
				}
			}
		calendarString += '</tr>';
		}
	
		calendarString += '<tr>';
			calendarString += '<td colspan="7" aling="center" style="text-align:center;padding:5px;">';
				calendarString += '<a href="'+site_url+'/?page_id='+event_page_Id+'">View all events</a>';
			calendarString += '</td>';
		calendarString += '</tr>';
	calendarString += '</table>';
	
	jQuery('div#calendar').html(calendarString);
}


function checkevents(day,month,year,week,dayofweek) {
var numevents = 0;
var floater = 0;

	for (var i = 0; i < events.length; i++) {
		if (events[i][0] == "W") {
			if ((events[i][2] == dayofweek)) numevents++;
		}
		else if (events[i][0] == "Y") {
			if ((events[i][2] == day) && (events[i][1] == month)) numevents++;
		}
		else if (events[i][0] == "F") {
			if ((events[i][1] == 3) && (events[i][2] == 0) && (events[i][3] == 0) ) {
				easter(year);
				if (easterday == day && eastermonth == month) numevents++;
			} else {
				floater = floatingholiday(year,events[i][1],events[i][2],events[i][3]);
				if ((month == 5) && (events[i][1] == 5) && (events[i][2] == 4) && (events[i][3] == 2)) {
					if ((floater + 7 <= 31) && (day == floater + 7)) {
						numevents++;
					} else if ((floater + 7 > 31) && (day == floater)) numevents++;
				} else if ((events[i][1] == month) && (floater == day)) numevents++;
			}
		}
		else if ((events[i][2] == day) && (events[i][1] == month) && (events[i][3] == year)) {
			numevents++;
		}
	}

	if (numevents == 0) {
		return false;
	} else {
		return true;
	}
}


function showevents(day,month,year,week,dayofweek) {
var theevent = "";
var floater = 0;

	for (var i = 0; i < events.length; i++) {
		// First we'll process recurring events (if any):
		if (events[i][0] != "") {
			if (events[i][0] == "D") {
			}
			if (events[i][0] == "W") {
				if ((events[i][2] == dayofweek)) {
				//theevent += "Events of: \n" + month +'/'+ day +'/'+ year + '\n';
				//theevent += events[i][6] + '\n';
				theevent += 'Title: ' + events[i][4] + '\n';
				theevent += 'Date: ' + events[i][5] + '\n';
				//theevent += 'Price: ' + events[i][7] + '\n';
				theevent += '\n ---------------------------- \n\n';
				document.forms.eventform.eventlist.value = theevent;
				}
			}
			if (events[i][0] == "M") {
			}
			if (events[i][0] == "Y") {
				if ((events[i][2] == day) && (events[i][1] == month)) {
				//theevent += "Events of: \n" + month +'/'+ day +'/'+ year + '\n';
				//theevent += events[i][6] + '\n';
				theevent += 'Title: ' + events[i][4] + '\n';
				theevent += 'Date: ' + events[i][5] + '\n';
				//theevent += 'Price: ' + events[i][7] + '\n';
				theevent += '\n ---------------------------- \n\n';
				document.forms.eventform.eventlist.value = theevent;
				}
			}
			if (events[i][0] == "F") {
				if ((events[i][1] == 3) && (events[i][2] == 0) && (events[i][3] == 0) ) {
					if (easterday == day && eastermonth == month) {
						//theevent += "Events of: \n" + month +'/'+ day +'/'+ year + '\n';
						//theevent += events[i][6] + '\n';
						  theevent += 'Title: ' + events[i][4] + '\n';
						  theevent += 'Date: ' + events[i][5] + '\n';
						  //theevent += 'Price: ' + events[i][7] + '\n';
						theevent += '\n ---------------------------- \n\n';
						document.forms.eventform.eventlist.value = theevent;
					} 
				} else {
					floater = floatingholiday(year,events[i][1],events[i][2],events[i][3]);

					if ((month == 5) && (events[i][1] == 5) && (events[i][2] == 4) && (events[i][3] == 2)) {
						if ((floater + 7 <= 31) && (day == floater + 7)) {
							//theevent += "Events of: \n" + month +'/'+ day +'/'+ year + '\n';
							//theevent += events[i][6] + '\n';
						      theevent += 'Title: ' + events[i][4] + '\n';
							  theevent += 'Date: ' + events[i][5] + '\n';
							  //theevent += 'Price: ' + events[i][7] + '\n';
							theevent += '\n ---------------------------- \n\n';
							document.forms.eventform.eventlist.value = theevent;
						} else if ((floater + 7 > 31) && (day == floater)) {
							//theevent += "Events of: \n" + month +'/'+ day +'/'+ year + '\n';
							//theevent += events[i][6] + '\n';
						      theevent += 'Title: ' + events[i][4] + '\n';
							  theevent += 'Date: ' + events[i][5] + '\n';
							  //theevent += 'Price: ' + events[i][7] + '\n';
							theevent += '\n ---------------------------- \n\n';
							document.forms.eventform.eventlist.value = theevent;
						}
					} else if ((events[i][1] == month) && (floater == day)) {
						//theevent += "Events of: \n" + month +'/'+ day +'/'+ year + '\n';
						//theevent += events[i][6] + '\n';
						      theevent += 'Title: ' + events[i][4] + '\n';
							  theevent += 'Date: ' + events[i][5] + '\n';
							  //theevent += 'Price: ' + events[i][7] + '\n';
							theevent += '\n ---------------------------- \n\n';
						document.forms.eventform.eventlist.value = theevent;
					}
				}
			}
		}
		// Now we'll process any One Time events happening on the matching month, day, year:
		else if ((events[i][2] == day) && (events[i][1] == month) && (events[i][3] == year))
			{
			if(events[i][4]!='')
				{
				theevent += '<li><strong><a href="'+events[i][7]+'/?page_id='+event_page_Id+'&izc-event-id='+events[i][6]+'">' + events[i][4]+'</a></strong>';
				theevent += ' @ ' + events[i][5] + '</li>' + '\n';
				}
			}
	}

	var offset = jQuery('td#td-day-'+day).offset();
	
	jQuery('.ui-iz-calender-events').css("position","absolute");
	
	if(popup_direction=='right')
		{
		jQuery('.ui-iz-calender-events').css("top",offset.top+10);
		jQuery('.ui-iz-calender-events').css("left",offset.left+30);
		}
	else
		{
		jQuery('.ui-iz-calender-events').css("top",offset.top+10);
		jQuery('.ui-iz-calender-events').css("left",offset.left-210);
		}
		
	jQuery('#ui-iz-calender-event-description').slideUp('fast');
	jQuery('.ui-iz-calender-events').hide();
	jQuery('.ui-iz-calender-events').slideDown('fast');
	
	if (theevent == "")
		{
		jQuery('#list-events').html('No events to show.');
		}
	else
		{
		jQuery('#list-events').html('<ul class="events-list">'+ theevent + '</ul>');
		}
}


function floatingholiday(targetyr,targetmo,cardinaloccurrence,targetday) {
// Floating holidays/events of the events.js file uses:
//	the Month field for the Month (here it becomes the targetmo field)
//	the Day field as the Cardinal Occurrence  (here it becomes the cardinaloccurrence field)
//		1=1st, 2=2nd, 3=3rd, 4=4th, 5=5th, 6=6th occurrence of the day listed next
//	the Year field as the Day of the week the event/holiday falls on  (here it becomes the targetday field)
//		1=Sunday, 2=Monday, 3=Tuesday, 4=Wednesday, 5=Thurday, 6=Friday, 7=Saturday
//	example: "F",	"1",	"3",	"2", = Floating holiday in January on the 3rd Monday of that month.
//
// In our code below:
// 	targetyr is the active year
// 	targetmo is the active month (1-12)
// 	cardinaloccurrence is the xth occurrence of the targetday (1-6)
// 	targetday is the day of the week the floating holiday is on
//		0=Sun; 1=Mon; 2=Tue; 3=Wed; 4=Thu; 5=Fri; 6=Sat
//		Note: subtract 1 from the targetday field if the info comes from the events.js file
//
// Note:
//	If Memorial Day falls on the 22nd, 23rd, or 24th, then we add 7 to the dayofmonth to the result.
//
// Example: targetyr = 2052; targetmo = 5; cardinaloccurrence = 4; targetday = 1
//	This is the same as saying our floating holiday in the year 2052, is during May, on the 4th Monday
//
var firstdate = new Date(String(targetmo)+"/1/"+String(targetyr));	// Object Storing the first day of the current month.
var firstday = firstdate.getUTCDay();	// The first day (0-6) of the target month.
var dayofmonth = 0;	// zero out our calendar day variable.

	targetday = targetday - 1;

	if (targetday >= firstday) {
		cardinaloccurrence--;	// Subtract 1 from cardinal day.
		dayofmonth = (cardinaloccurrence * 7) + ((targetday - firstday)+1);
	} else {
		dayofmonth = (cardinaloccurrence * 7) + ((targetday - firstday)+1);
	}
return dayofmonth;
}