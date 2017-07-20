<?php
function izcalender_admin_interface(){
	
	$months = array('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
	
	echo '<form name="date_values">';
		echo '<input type="hidden" name="oldmonthvalue" value="calender-month-1" >';
		echo '<input type="hidden" name="oldyearvalue" value="'.date('Y').'" >';
	echo '</form>';
			
	echo '<div id="iz-calender">';
		echo '<div class="wrap">';
			echo '<h2>Add Event</h2>';
			echo '<div class="calender-months">';
				echo '<div id="calender-select-year"><ul class="prev"><li><a href="javascript:changYear(\'prev\',\'admin\',\''.admin_url('admin-ajax.php').'\');">&lt;</a></li></ul><div class="calender-year" id="calender-year">'.date('Y').'</div><ul class="next"><li><a href="javascript:changYear(\'next\',\'admin\',\''.admin_url('admin-ajax.php').'\');">&gt;</a></li></ul></div>';
				for($i=1;$i<=4;$i++)
					{
					echo '<ul class="calender-month-row">';					
					for($j=1;$j<=3;$j++)
						{
						if($i==1){$k=0;}
						if($i==2){$k=3;}
						if($i==3){$k=6;}
						if($i==4){$k=9;}
						echo '<li id="calender-month-'.($k+$j).'" class="calender-month-'.($k+$j).'"><a href="javascript:showEvents(\'calender-month-'.($k+$j).'\',\''.($k+$j).'\',\''.$_REQUEST['p_id'].'\',\'admin\',\'\');">'.$months[$k+$j].'</a></li>';
						}
					echo '</ul>';
					}
			echo '</div>';
			echo '<div id="calender-days" class="calender-days" style="display:none;">';
				echo '<div id="date-format" style="display:none;"></div>';
				echo '<form name="events">';
					echo '<input type="hidden" name="izc_event_day" value="">';
					echo '<input type="hidden" name="izc_event_month" value="">';
					echo '<input type="hidden" name="izc_event_year" value="'.date('Y').'">';
				echo '</form>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
	/*echo '<script type="text/javascript">';
		echo 'for(i=1; i<=12;i++)
				{						
				count_events(\''.admin_url('admin-ajax.php').'\',i,\'admin\');
				}';
	echo '</script>';*/
	if($_REQUEST['action']=='edit')
		{
		echo '<script type="text/javascript">';
			echo 'showEvents(\'calender-month-'.$_REQUEST['month'].'\',\''.$_REQUEST['month'].'\',\''.$_REQUEST['p_id'].'\',\''.admin.'\',\'\');';
		echo '</script>';
		}
}


function izcalender_event_creator(){
	
	global $wpdb;

	$title 		= 'Insert ';
	$action 	= 'insert';
	$months  	= array('','January','February','March','April','May','June','July','August','September','October','November','December');
	$maxdays 	= array('','31','28','31','30','31','30','31','31','30','31','30','31');
	$time		= array('Select','05:00','05:30','06:00','06:30','07:00','07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00','20:30','21:00','21:30','22:00','22:30','23:00');
	
	if($_POST['edit']==1)
		{
		$title 	= 'Update ';
		$action = 'edit';
		$sgl 	= "SELECT * FROM " . $wpdb->prefix . "iz_calender WHERE Id=".$_POST['p_id'];
		$myrows = $wpdb->get_results($sgl);
		foreach($myrows as $row)
			{
			$izc_event_name 		= $row->izc_event_name;
			$izc_event_venue 		= $row->izc_event_venue;
			$izc_event_description 	= $row->izc_event_description;
			$izc_event_day 			= $row->izc_event_day;
			$izc_event_month 		= $row->izc_event_month;
			$izc_event_year			= $row->izc_event_year;
			$izc_event_time			= $row->izc_event_time;
			}
		}
		
	echo '<div class="days">';
		echo '<form name="events" method="post" action="?page=iz-calender&action='.$action.'&p_id='.$_POST['p_id'].'">';
			echo '<input type="hidden" name="izc_event_month" value="'.$_POST['month'].'">';
			echo '<input type="hidden" name="izc_event_year" value="'.$_POST['year'].'">';
			echo '<h3>'.$months[$_POST['month']].'</h3>';
			echo '<div class="iz-calender-event-description">';

				echo '<label>Event Name:</label><br /><input type="text" name="izc_event_name" value="'.$izc_event_name.'"><br />';
				echo '<label>Venue:</label><br /><input type="text" name="izc_event_venue" value="'.$izc_event_venue.'"><br />';
				echo '<br /><label>Description:</label><br /><input name="izc_event_description" type="hidden">';
				
				//WYSIWYG TOOLS
				echo '<div class="de77_wysiwyg">';
					echo '<div class="de77_toolbar">';
						echo '<img alt="bold" title="bold" onclick="action(this,\'bold\')" src="'.WP_PLUGIN_URL . '/izcalender/js/editor/ico/bold.png">';
						echo '&nbsp;&nbsp;<img alt="italic" title="italic" onclick="action(this,\'italic\')" src="'.WP_PLUGIN_URL . '/izcalender/js/editor/ico/italic.png">';
						echo '&nbsp;&nbsp;<img alt="underline" title="underline" onclick="action(this,\'underline\')" src="'.WP_PLUGIN_URL . '/izcalender/js/editor/ico/underline.png">';
						echo '&nbsp;&nbsp;<img alt="strikethrough" title="strikethrough" onclick="action(this,\'strikethrough\')" src="'.WP_PLUGIN_URL . '/izcalender/js/editor/ico/strikethrough.png">';
						echo '&nbsp;&nbsp;<img alt="paragraph" title="paragraph" onclick="action(this,\'insertparagraph\')" src="'.WP_PLUGIN_URL . '/izcalender/js/editor/ico/paragraph.png">';
						echo '&nbsp;&nbsp;<img alt="subscript" title="subscript" onclick="action(this,\'subscript\')" src="'.WP_PLUGIN_URL . '/izcalender/js/editor/ico/subscript.png">';
						echo '&nbsp;&nbsp;<img alt="superscript" title="superscript" onclick="action(this,\'superscript\')" src="'.WP_PLUGIN_URL . '/izcalender/js/editor/ico/superscript.png">';
						echo '&nbsp;&nbsp;<img alt="html" title="html" onclick="action(this,\'inserthtml\', prompt(\'HTML?\'))" src="'.WP_PLUGIN_URL . '/izcalender/js/editor/ico/html.png">';
						
						//echo '<img alt="paste" title="paste" onclick="action(this,\'paste\')" src="'.WP_PLUGIN_URL . '/izcalender/js/editor/ico/paste.png">';
						//echo '<img alt="cut" title="cut" onclick="action(this,\'cut\')" src="'.WP_PLUGIN_URL . '/izcalender/js/editor/ico/cut.png">';
						//echo '<img alt="copy" title="copy" onclick="action(this,\'copy\')" src="'.WP_PLUGIN_URL . '/izcalender/js/editor/ico/copy.gif">';
							
						//echo '<img alt="left" title="left" onclick="action(this,\'justifyleft\')" src="'.WP_PLUGIN_URL . '/izcalender/js/editor/ico/left.png">';
						//echo '<img alt="right" title="right" onclick="action(this,\'justifyright\')" src="'.WP_PLUGIN_URL . '/izcalender/js/editor/ico/right.png">';
						//echo '<img alt="center" title="center" onclick="action(this,\'justifycenter\')" src="'.WP_PLUGIN_URL . '/izcalender/js/editor/ico/center.png">';
						//echo '<img alt="justify" title="justify" onclick="action(this,\'justifyfull\')" src="'.WP_PLUGIN_URL . '/izcalender/js/editor/ico/justify.png">';
							
						//echo '<img alt="ol" title="ol" onclick="action(this,\'insertorderedlist\')" src="'.WP_PLUGIN_URL . '/izcalender/js/editor/ico/ol.png">';
						//echo '<img alt="ul" title="ul" onclick="action(this,\'insertunorderedlist\')" src="'.WP_PLUGIN_URL . '/izcalender/js/editor/ico/ul.png">';
					echo '</div>';
					
					echo '<div contenteditable="true" id="editor" class="de77_editor">';
						echo (($izc_event_description) ? $izc_event_description : 'Type your event description here');
					echo '</div>';
					
				echo '</div>';
			echo '<input onclick="set_description();" type="submit" name="submit" value="'.$title.' Event" class="button-primary">';
			echo '</div>';
			echo '<div class="iz-calender-event-attributes">';
				echo '<label>Day:<label><br />';
				echo '<select name="izc_event_day" onChange="format_date(this.value,document.events.izc_event_year.value,\''.$_POST['month'].'\',document.events.izc_event_time.value);">';
						echo '<option value="Select">Select</option>';
						for($i=1;$i<=$maxdays[$_POST['month']];$i++)
							{
							echo '<option value="'.$i.'" '.(($i==$izc_event_day) ? 'selected="selected"' : '' ).'>'.$i.'</option>';
							}
				echo '</select><br />';
				echo '<label>Time:</label><br />';
				echo '<select name="izc_event_time" onChange="format_date(document.events.izc_event_day.value,document.events.izc_event_year.value,\''.$_POST['month'].'\',this.value);">';
						for($i=0;$i<count($time);$i++)
							{		
							echo '<option value="'.$time[$i].':00" '.(($time[$i]==substr($izc_event_time,0,5)) ? 'selected="selected"' : '' ).'>'.$time[$i].'</option>';
							}
				echo '</select>';
				echo '<div id="date-format"></div>';
				
			echo '</div>';
		echo '</form>';
	echo '</div>';

	die();
}


function izcalender_event_quick_insert(){
		
		global $wpdb;
		
		$time		= array('Select','05:00','05:30','06:00','06:30','07:00','07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00','20:30','21:00','21:30','22:00','22:30','23:00');
		
		if(isset($_POST['action']))
			{
			if($_POST['action']=='quick_insert')
				{
				if(izcalender_quickdate_format($_POST['izc_event_date']))
					{	
					$error_str = '';
					$date_str = explode('-',$_POST['izc_event_date']);		
					$insertString = 'INSERT INTO '.$wpdb->prefix . 'iz_calender
										(izc_event_name,
										 izc_event_venue,
										 izc_event_description,
										 izc_event_day,
										 izc_event_month,
										 izc_event_year,
										 izc_event_time
										 )
										VALUES
										("'.$_POST['izc_event_name'].'",
										 "'.$_POST['izc_event_venue'].'",
										 "'.$_POST['izc_event_description'].'",
										 "'.$date_str[2].'",
										 "'.$date_str[1].'",
										 "'.$date_str[0].'",
										 "'.$_POST['izc_event_time'].'"
										)';
										
					$insert = mysql_query ($insertString);
						
					if($insert)
						{
						echo('<div class="updated fade" id="message"><p>Event <strong> added</strong>.</p></div>');
						}
					else
						{
						echo('<div class="error" id="message"><p>Failed! please try again.</p></div>');
						}		
					}
				else	
					{
					$error_str = '&nbsp;<span style="color:#FF0000;">Invalid date format!</span>';
					}
				}
			}
			global $current_user;
			echo '<div class="izc-dashboard-panel">';
			
				echo '<p  style="margin-top:-30px; padding-right:30px;" align="right"><a href="http://www.intisul.co.za/">by Paul Cilliers</a></p>';
				echo '<p>&nbsp;</p>';
				echo '<p >Welcome  <strong>'.$current_user->display_name.'</strong>,</p>';
				
				echo '<p><a href="'.get_option('siteurl').'/wp-admin/admin.php?page=add-event">&bull;&nbsp;Add a new event using simple WYSIWYG</a></p>';
				echo '<p><a href="'.get_option('siteurl').'/wp-admin/admin.php?page=iz-calender">&bull;&nbsp;View,edit or delete active events</a></p>';
				echo '<p><a href="'.get_option('siteurl').'/wp-admin/admin.php?page=izc-settings">&bull;&nbsp;Change calender color scheme</a></p>';
				echo '<p>&bull;&nbsp;<strong><em>or</em></strong> use this form below for a quick add of your event.</p>';
				echo '<p>&nbsp;</p>';
	
				echo '<form name="events" method="post" action="#">';
					echo '<input type="hidden" name="action" value="quick_insert">';
						echo '&nbsp;<label><strong>Date:</strong></label>&nbsp;&nbsp;<small><em>Format: YYYY-MM-DD</em></small>&nbsp;&nbsp;'.$error_str.'<br />';
					
						echo '<input type="text" style="width:67%;" name="izc_event_date" value="'.$_POST['izc_event_date'].'">';
						echo '<label><small>&nbsp;Time&nbsp;</small></label><select name="izc_event_time"  style="width:25%;" onChange="format_date(document.events.izc_event_day.value,document.events.izc_event_year.value,\''.$_POST['month'].'\',this.value);">';
							for($i=0;$i<count($time);$i++)
								{		
								echo '<option value="'.$time[$i].':00" '.(($time[$i]==substr($_POST['izc_event_time'],0,5)) ? 'selected="selected"' : '' ).'>'.$time[$i].'</option>';
								}
						echo '</select><br />';
						echo '&nbsp;<label><strong>Event Name:</strong></label><br /><input type="text" style="width:100%;" name="izc_event_name" value="'.$_POST['izc_event_name'].'"><br />';
						echo '&nbsp;<label><strong>Venue:</strong></label><br /><input type="text" style="width:100%;" name="izc_event_venue" value="'.$_POST['izc_event_venue'].'"><br />';
						echo '&nbsp;<label><strong>Description:</strong></label><br /><textarea style="width:100%;" name="izc_event_description">'.$_POST['izc_event_description'].'</textarea>';
					echo '<br /><br /><input type="submit" name="submit" value="Add New Event" class="button-primary">';
				echo '</form>';
				echo '<p>&nbsp;</p>';
			echo '</div>';
			
}


function izcalender_list_events() {
	
	global $wpdb;
	
	izcalender_display_header('-list');
	
	if (!current_user_can('manage_options'))
		{
		wp_die( __('You do not have sufficient permissions to access this page.') );
		}
	if(isset($_REQUEST['action']))
		{
		if($_REQUEST['action']	=='trash'	)	{	izcalender_trash($_REQUEST['p_id']);						}
		if($_REQUEST['action']	=='insert'	)	{	izcalender_db_action('insert');					}
		if($_REQUEST['action']	=='edit'	)	{	izcalender_db_action('update',$_REQUEST['p_id']);}
		}
		echo '<div class="wrap">';
			echo '<h2>Events list</h2>';
			echo '<table class="iz-calender-list" width="100%" border="0" cellspacing="1" cellpadding="5">';
				echo '<tr>';
					echo '<td width="20%" class="table-head"><strong>Event&nbsp;name</strong></td>';				
					echo '<td width="30%" class="table-head"><strong>Description</strong></td>';
					echo '<td width="20%" class="table-head"><strong>Where</strong></td>';					
					echo '<td width="30%" class="table-head"><strong>When</strong></td>';
					echo '<td width="10%" class="table-head"><strong>Edit</strong></td>';
					echo '<td width="10%" class="table-head"><strong>Trash</strong></td>';
				echo '</tr>';
					 
				$events = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "iz_calender ORDER BY izc_event_year DESC, izc_event_month DESC, izc_event_day DESC, izc_event_time ASC ");
				
				foreach($events as $event)
					{
					echo '<tr>';
						echo '<td><a href="?page=add-event&action=edit&month='.$event->izc_event_month.'&p_id='.$event->Id.'">'.$event->izc_event_name.'</a></td>';
						echo '<td>'.izcalender_view_excerpt($event->izc_event_description).'</td>';
						echo '<td>'.$event->izc_event_venue.'</td>';				
						echo '<td>'.date('l M j,Y',mktime(0,0,0,$event->izc_event_month,$event->izc_event_day,$event->izc_event_year)).' at '.substr($event->izc_event_time,0,5).'</td>';
						echo '<td><a href="?page=add-event&action=edit&month='.$event->izc_event_month.'&p_id='.$event->Id.'"><img src="'. WP_PLUGIN_URL . '/izcalender/images/edit.jpg" width="44" height="34" alt="Edit Product: '.$event->p_name.'" /></a></td>';
						echo '<td><a href="?page=iz-calender&action=trash&p_id='.$event->Id.'"><img src="'. WP_PLUGIN_URL . '/izcalender/images/trash.jpg" width="44" height="34" alt="Thrash Product: '.$event->p_name.'" /></a></td>';	
					echo '</tr>';			
					}
			echo '</table>';
		echo '</div>';
		
	izcalender_display_footer('-list');
}
function izcalender_quickdate_format($date){

	if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts))
		{
		if(checkdate($parts[2],$parts[3],$parts[1]))
			{
			return true;
			}
		else
			{
			return false;
			}
		}	
	else
		{
		return false;
		}
}
function izcalender_db_action($action,$p_id =''){
	
	global $wpdb;
	
	($_REQUEST['izc_event_name']!='') 		? $izc_event_name 		 = $_REQUEST['izc_event_name']		  : '';
	($_REQUEST['izc_event_venue']!='')		? $izc_event_venue		 = $_REQUEST['izc_event_venue'] 	  : '';
	($_REQUEST['izc_event_description']!='')? $izc_event_description = $_REQUEST['izc_event_description'] : '';
	($_REQUEST['izc_event_day']!='') 		? $izc_event_day		 = $_REQUEST['izc_event_day'] 		  : '';
	($_REQUEST['izc_event_month']!='') 		? $izc_event_month		 = $_REQUEST['izc_event_month'] 	  : '';
	($_REQUEST['izc_event_year']!='') 		? $izc_event_year		 = $_REQUEST['izc_event_year'] 	  	  : '';
	($_REQUEST['izc_event_time']!='') 		? $izc_event_time		 = $_REQUEST['izc_event_time'] 		  : '';
	
	$is_duplicate = $wpdb->get_row("SELECT izc_event_name FROM " . $wpdb->prefix . "iz_calender 
									WHERE 
									izc_event_name='".$izc_event_name."'
									AND izc_event_venue='".$izc_event_venue."'
									AND izc_event_description='".$izc_event_description."'
									AND izc_event_day='".$izc_event_day."'
									AND izc_event_month='".$izc_event_month."'										
									AND izc_event_year='".$izc_event_year."'
									AND izc_event_time='".$izc_event_time."'");	
	
	if($action == 'update')
		{
		if($is_duplicate)
			{
			echo('<div class="error" id="message"><p>Event already exists.</p></div>');
			}
		else
			{
			$updateString = 'UPDATE '.$wpdb->prefix . 'iz_calender
							 SET izc_event_name			= "'.$izc_event_name.'", 
								 izc_event_venue		= "'.$izc_event_venue.'",
								 izc_event_description	= "'.$izc_event_description.'",
								 izc_event_day			= "'.$izc_event_day.'",
								 izc_event_month		= "'.$izc_event_month.'",
								 izc_event_year			= "'.$izc_event_year.'",
								 izc_event_time			= "'.$izc_event_time.'"
							 WHERE Id = '.$p_id;
								
			$update = mysql_query ($updateString);
				
			if($update)
				{
				echo('<div class="updated fade" id="message"><p>Event <strong> updated</strong>.</p></div>');
				}
			else
				{
				echo('<div class="error" id="message"><p>Failed! please try again.</p></div>');
				}
			}
		}
			
	if($action == 'insert')
		{
		if($izc_event_name!='')
			{
			if($is_duplicate)
				{
				echo('<div class="error" id="message"><p>Event already exists.</p></div>');
				}
			else
				{	
				$insertString = 'INSERT INTO '.$wpdb->prefix . 'iz_calender
								(izc_event_name,
								 izc_event_venue,
								 izc_event_description,
								 izc_event_day,
								 izc_event_month,
								 izc_event_year,
								 izc_event_time
								 )
								VALUES
								("'.$izc_event_name.'",
								 "'.$izc_event_venue.'",
								 "'.$izc_event_description.'",
								 "'.$izc_event_day.'",
								 "'.$izc_event_month.'",
								 "'.$izc_event_year.'",
								 "'.$izc_event_time.'"
								)';
								
				$insert = mysql_query ($insertString);
				
				if($insert)
					{
					echo('<div class="updated fade" id="message"><p>Event <strong> added</strong>.</p></div>');
					}
				else
					{
					echo('<div class="error" id="message"><p>Failed! please try again.</p></div>');
					}
				}
			}
		}	
	
}

function izcalender_trash($delId){
	global $wpdb;
	$delete = $wpdb->query ( 'DELETE FROM '.$wpdb->prefix . 'iz_calender WHERE id='.$delId );
	if($delete)
		{
		echo('<div class="updated fade" id="message"><p>Event <strong> deleted</strong>.</p></div>');
		}
	else
		{
		echo('<div class="error" id="message"><p>Failed! please try again.</p></div>');
		}
}
?>