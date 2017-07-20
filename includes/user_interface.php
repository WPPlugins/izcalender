<?php
function izcalender_user_interface(){
    
	global $wpdb;

	echo '<script type="text/JavaScript" language="JavaScript">';
		echo 'var todaysBGColor 	= "'.get_option(	"izc_bgcolor_today"		).'";';
		echo 'var todaysFontColor 	= "'.get_option(	"izc_fontcolor_today"	).'";';
		echo 'var hasEventBGColor 	= "'.get_option(	"izc_bgcolor_event"		).'";';
		echo 'var hasEventFontColor = "'.get_option(	"izc_fontcolor_event"	).'";';
		echo 'var headerBGColor 	= "'.get_option(	"izc_bgcolor_header"	).'";';
		echo 'var headerFontColor 	= "'.get_option(	"izc_fontcolor_header"	).'";';
		echo 'var daysBGColor 		= "'.get_option(	"izc_bgcolor_days"		).'";';
		echo 'var daysFontColor 	= "'.get_option(	"izc_fontcolor_days"	).'";';
		echo 'var popup_direction 	= "'.get_option(	"izc_popup_direction"	).'";';
		echo 'var image_path 		= "'.WP_PLUGIN_URL . '/izcalender/images/";';
		echo 'var site_url	 		= "'.get_option('siteurl').'";';
		echo 'var event_page_Id		= '._EPAGEID.';';
		
		echo 'events = new Array';
			echo '(';
					$sgl = "SELECT * FROM " . $wpdb->prefix . "iz_calender ".((isset($_POST['e_name'])) ? "WHERE izc_event_name='".$_POST['e_name']."'" : '');
					$rows = $wpdb->get_results($sgl);
					foreach($rows as $row)
						{
						echo '["","'.$row->izc_event_month.'","'.$row->izc_event_day.'","'.$row->izc_event_year.'","'.$row->izc_event_name.'","'.substr($row->izc_event_time,0,5).'","'.$row->Id.'","'.get_option('siteurl').'"],' ;
						}
					echo "['','1','1','2111','End',	'End','','End']";
			echo ');';
	echo '</script>';
	echo '<script type="text/JavaScript" language="JavaScript" src="'.WP_PLUGIN_URL . '/izcalender/js/calender.js'.'"></script>';
	
	echo '<table id="evtcal"cellpadding="0" cellspacing="0">';
		echo '<tr>';
			echo '<td class="calendar" rowspan="1" align="center" valign="top">';
			echo '<div id="calendar"><!--  Dynamically Filled --></div></td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td class="order_form" valign="top"><center>';
				echo '<form id="eventform" name="eventform" action="#" method="get">';	
					echo '<div id="eventlist" class="style" align="left"></div>';
				echo '</form>';   
			echo '</td>';
		echo '</tr>';
	echo '</table>';
}

function izcalender_ui_list_events(){
		
	global $wpdb;
	
	$events = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "iz_calender WHERE izc_event_month=".$_POST['month']." AND izc_event_year=".$_POST['year']." ORDER BY izc_event_year DESC, izc_event_month DESC, izc_event_day DESC, izc_event_time ASC");

	echo '<div id="ui-iz-calender-month">';
		echo '<strong>'.date("F, Y",mktime(0,0,0,$_POST['month']+1,$_POST['day'],$_POST['year'])).'</strong>';
	echo '</div>';
	
	echo '<ul>';
		if($events)
			{
			foreach($events as $event)
				{
				echo '<li>';
					echo '<a href="javascript:getEventDescription(\''.$event->Id.'\',\''.admin_url('admin-ajax.php').'\');">'.date("jS",mktime(0,0,0,$_POST['month']+1,$event->izc_event_day,$_POST['year'])).' - '.$event->izc_event_name.'</a>';
				echo '</li>';
				}
			}
		else
			{
			echo '<span style="font-weight:normal">No events sheduled.<span>';
			}
	echo '</ul>';
}

function izcalender_ui_list_events_page(){
		
	global $wpdb;
	
	$events = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "iz_calender ORDER BY izc_event_year DESC, izc_event_month DESC, izc_event_day DESC, izc_event_time ASC");

	
	
		if($events)
			{
			foreach($events as $event)
				{
				echo '<div class="izc-event-item">';
					echo '<div class="event-name">';
					echo '<a href="'.get_option('siteurl').'/?page_id='._EPAGEID.'&izc-event-id='.$event->Id.'">'.$event->izc_event_name.'</a>';
					echo '</div>';
					
					echo '<div class="event-date"><strong>Date:</strong> ';
					echo $event->izc_event_year;
					echo '/';
					echo $event->izc_event_month;
					echo '/';
					echo $event->izc_event_day;
					echo '</div>';
					
					echo '<div class="event-time"><strong>Time:</strong> ';
					echo $event->izc_event_time;
					echo '</div>';
					
					echo '<div class="event-description">';
					echo izcalender_view_excerpt($event->izc_event_description,15);
					echo '<a href="'.get_option('siteurl').'/?page_id='._EPAGEID.'&izc-event-id='.$event->Id.'"><br />read more</a>';
					echo '</div>';
				echo '</div>';
				}
			}
		else
			{
			echo '<span style="font-weight:normal">No events sheduled.<span>';
			}
		echo '<p>&nbsp;</p>';
	
}

function izcalender_get_event_page(){
	
	global $wpdb;
	global $post;

	echo $args;
	if($post->post_name==get_option('izc_events_page_slug'))
		{
		if(!isset($_REQUEST['izc-event-id']))
			{
			izcalender_ui_list_events_page(); 
			}
		else
			{
			$sgl = "SELECT * FROM " . $wpdb->prefix . "iz_calender WHERE Id=".$_REQUEST['izc-event-id'] ;
			$event = $wpdb->get_row($sgl);
			
			echo '<div class="izc-event-description-wrapper">';
				echo '<div class="izc-event-title">';
					echo '<h3>'.$event->izc_event_name.'</h3>';
				echo '</div>';
				
				echo '<div class="izc-event-date">';
					echo '<strong>When</strong>: ';
					echo date("l",mktime(0,0,0,$event->izc_event_month,$event->izc_event_day,$event->izc_event_year));
					echo ' the ';
					echo date("jS",mktime(0,0,0,$event->izc_event_month,$event->izc_event_day,$event->izc_event_year));
					echo ' of ';
					echo date("F, Y",mktime(0,0,0,$event->izc_event_month,$event->izc_event_day,$event->izc_event_year));
					echo ' at '.substr($event->izc_event_time,0,5);
				echo '</div>';
				
				echo '<div class="izc-event-venue">';
					echo '<strong>Where</strong>: ';
					echo $event->izc_event_venue;
				echo '</div>';
				
				echo '<div class="izc-event-dessciption">';		
					echo $event->izc_event_description;
				echo '</div>';
				
				echo '<div class="izc-event-actions">';
					echo '<a href="javascript:izc_event_print();"><img src="'.WP_PLUGIN_URL.'/izcalender/images/print.png" align="absmiddle" >print this event</a>';
					echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
					echo '<a href="javascript:izc_event_mail(\''.get_option('blogname').' Event - '.$event->izc_event_name.'\');"><img src="'.WP_PLUGIN_URL.'/izcalender/images/email.png" align="absmiddle">E-mail to friend</a>';
				echo '</div>';
				
				echo '<a href="'.get_option('siteurl').'/?page_id='._EPAGEID.'"><br />View all events</a>';
				
				echo '<p>&nbsp;</p>';
				
			echo '</div>';
			}
		}
	else
		{
		return nl2br(get_the_content());
		}
}

?>