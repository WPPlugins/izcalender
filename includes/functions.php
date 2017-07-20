<?php
function izcalender_display_header($style = ''){
	echo '
	<div id="iz-calender">
	<div id="iz-calender-header'.$style.'"></div>
	<div id="iz-calender-page'.$style.'">';
}

function izcalender_display_footer($style = ''){
	echo '
	</div><!--#iz-calender-page-->
	<div id="iz-calender-footer'.$style.'"></div>
	</div>';
}

//format timestamps to ie: "Tuesday the 12th of Oct, 2010 at 11:30"
function izcalender_date_format(){
	if($_POST['day']!='Select')
		{
		echo date("l",mktime(0,0,0,$_POST['month'],$_POST['day'],$_POST['year']));
		echo ' the ';
		echo date("jS",mktime(0,0,0,$_POST['month'],$_POST['day'],$_POST['year']));
		echo ' of ';
		echo date("M, Y",mktime(0,0,0,$_POST['month'],$_POST['day'],$_POST['year']));
		if($_POST['time']!='Select:00')
			{
			echo ' at ';
			echo substr($_POST['time'],0,5);
			}
		}		
}

function izcalender_ui_count_events(){
	global $wpdb;
	$sgl = "SELECT count(*) FROM " . $wpdb->prefix . "iz_calender WHERE izc_event_month=".$_POST['month']." AND izc_event_year=".$_POST['year'];
	$counted = $wpdb->get_var($sgl);
	echo '<div class="counted">'.$counted.'</div>';
}

function izcalender_view_excerpt($cotent,$total_words = 7){
	$words = str_word_count($cotent,1);
	for( $i = 0; $i<=count($words); $i++ )
		{
		$excerpt .= $words[$i].' ';
		if($i>$total_words)
			{
			$add_ellipsis ='...';
			break;
			}
		}
	return $excerpt.$add_ellipsis;
}

?>