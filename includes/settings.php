<?php
function izcalender_settings(){
	
	if(isset($_REQUEST['action']))
		{
		$_REQUEST['color'] = '#'.$_REQUEST['color'];
		switch($_REQUEST['action'])
			{
			case 'izc_set_today_bg': update_option('izc_bgcolor_today',$_REQUEST['color']); break;
			case 'izc_set_today_font': update_option('izc_fontcolor_today',$_REQUEST['color']); break;
			case 'izc_set_event_bg': update_option('izc_bgcolor_event',$_REQUEST['color']); break;
			case 'izc_set_event_font': update_option('izc_fontcolor_event',$_REQUEST['color']); break;
			case 'izc_set_header_bg': update_option('izc_bgcolor_header',$_REQUEST['color']); break;
			case 'izc_set_header_font': update_option('izc_fontcolor_header',$_REQUEST['color']); break;
			case 'izc_set_days_bg': update_option('izc_bgcolor_days',$_REQUEST['color']); break;
			case 'izc_set_days_font': update_option('izc_fontcolor_days',$_REQUEST['color']); break;
			case 'izc_set_direction': update_option('izc_popup_direction',$_REQUEST['color']); break;
			case 'set_events_page_nav_item': update_option('izc_events_page_nav_item',$_REQUEST['izc_events_page_nav_item']); break;
			case 'izc_events_page_slug': izc_change_event_page(get_option('izc_events_page_slug'),$_REQUEST['izc_page']); break;
			}
		}
	
	echo '<div class="wrap">';
		echo '<div class="izc-settings">';
			echo '<h2>IZ Callender - Settings</h2>';
			echo '<h3>Events page</h3>';
			
			echo '<small>Set the events page slug.</small>';
			echo '<form name="izc_set" action="'.$_SERVER['PHP_SELF'].'" method="get">';
				echo '<input type="hidden" name="action" value="izc_events_page_slug">';
				echo '<input type="hidden" name="page" value="izc-settings">';
				echo '<input type="text" name="izc_page" value="'.get_option('izc_events_page_slug').'">';
				echo '<input type="submit" name="submit" value="Save" class="button-primary" />&nbsp;&nbsp;';
			echo '</form>';

			echo '<br /><small>Display this page in my top/primary nav.</small>';
			echo '<form name="izc_set" action="'.$_SERVER['PHP_SELF'].'" method="get">';
				echo '<input type="hidden" name="action" value="set_events_page_nav_item">';
				echo '<input type="hidden" name="page" value="izc-settings">';
					echo '<input type="radio" name="izc_events_page_nav_item" value="1" '.((get_option('izc_events_page_nav_item')=='1') ? 'checked="checked"' : '').'>&nbsp;&nbsp;Yes<br />';
					echo '<input type="radio" name="izc_events_page_nav_item" value="0" '.((get_option('izc_events_page_nav_item')=='0') ? 'checked="checked"' : '').'>&nbsp;&nbsp;No<br /><br />';
				echo '<input type="submit" name="submit" value="Save" class="button-primary" />&nbsp;&nbsp;';
			echo '</form>';
			
			echo '<h3>Popup direction</h3>';
			echo '<small>Set the direction to which the events should popup.</small>';
			echo '<form name="izc_set" action="'.$_SERVER['PHP_SELF'].'" method="get">';
				echo '<input type="hidden" name="action" value="izc_set_direction">';
				echo '<input type="hidden" name="page" value="izc-settings">';
					echo '<input type="radio" name="izc_popup_direction" value="right" '.((get_option('izc_popup_direction')=='right') ? 'checked="checked"' : '').'>&nbsp;&nbsp;To the Right<br />';
					echo '<input type="radio" name="izc_popup_direction" value="left" '.((get_option('izc_popup_direction')=='left') ? 'checked="checked"' : '').'>&nbsp;&nbsp;To the left<br /><br />';
				echo '<input type="submit" name="submit" value="Save" class="button-primary" />&nbsp;&nbsp;';
			echo '</form>';

			echo '<h3>Color settings</h3>';
			echo '<small>Set todays background color</small>';
			echo '<form name="izc_set" action="'.$_SERVER['PHP_SELF'].'" method="get">';
				echo '<input type="hidden" name="action" value="izc_set_today_bg">';
				echo '<input type="hidden" name="page" value="izc-settings">';
					echo '<input class="color" type="text" name="color" value="'.get_option('izc_bgcolor_today').'">';
				echo '<input type="submit" name="submit" value="Save" class="button-primary" />&nbsp;&nbsp;';
			echo '</form>';
			
			echo '<small>Set todays font color</small>';
			echo '<form name="izc_set" action="'.$_SERVER['PHP_SELF'].'" method="get">';
				echo '<input type="hidden" name="action" value="izc_set_today_font">';
				echo '<input type="hidden" name="page" value="izc-settings">';
					echo '<input class="color" type="text" name="color" value="'.get_option('izc_fontcolor_today').'">';
				echo '<input type="submit" name="submit" value="Save" class="button-primary" />&nbsp;&nbsp;';
			echo '</form>';
			
			
			echo '<br /><br /><small>Set event dates background color</small>';
			echo '<form name="izc_set" action="'.$_SERVER['PHP_SELF'].'" method="get">';
				echo '<input type="hidden" name="action" value="izc_set_event_bg">';
				echo '<input type="hidden" name="page" value="izc-settings">';
					echo '<input class="color" type="text" name="color" value="'.get_option('izc_bgcolor_event').'">';
				echo '<input type="submit" name="submit" value="Save" class="button-primary" />&nbsp;&nbsp;';
			echo '</form>';
			
			echo '<small>Set event dates font color</small>';
			echo '<form name="izc_set" action="'.$_SERVER['PHP_SELF'].'" method="get">';
				echo '<input type="hidden" name="action" value="izc_set_event_font">';
				echo '<input type="hidden" name="page" value="izc-settings">';
					echo '<input class="color" type="text" name="color" value="'.get_option('izc_fontcolor_event').'">';
				echo '<input type="submit" name="submit" value="Save" class="button-primary" />&nbsp;&nbsp;';
			echo '</form>';
			
			
			echo '<br /><br /><small>Set Month header background color</small>';
			echo '<form name="izc_set" action="'.$_SERVER['PHP_SELF'].'" method="get">';
				echo '<input type="hidden" name="action" value="izc_set_header_bg">';
				echo '<input type="hidden" name="page" value="izc-settings">';		
					echo '<input class="color" type="text" name="color" value="'.get_option('izc_bgcolor_header').'">';
				echo '<input type="submit" name="submit" value="Save" class="button-primary" />&nbsp;&nbsp;';
			echo '</form>';
			
			echo '<small>Set Month header font color</small>';
			echo '<form name="izc_set" action="'.$_SERVER['PHP_SELF'].'" method="get">';
				echo '<input type="hidden" name="action" value="izc_set_header_font">';
				echo '<input type="hidden" name="page" value="izc-settings">';
					echo '<input class="color" type="text" name="color" value="'.get_option('izc_fontcolor_header').'">';
				echo '<input type="submit" name="submit" value="Save" class="button-primary" />&nbsp;&nbsp;';
			echo '</form>';

			echo '<br /><br /><small>Set Days header background color</small>';
			echo '<form name="izc_set" action="'.$_SERVER['PHP_SELF'].'" method="get">';
				echo '<input type="hidden" name="action" value="izc_set_days_bg">';
				echo '<input type="hidden" name="page" value="izc-settings">';
					echo '<input class="color" type="text" name="color" value="'.get_option('izc_bgcolor_days').'">';
				echo '<input type="submit" name="submit" value="Save" class="button-primary" />&nbsp;&nbsp;';
			echo '</form>';
			
			echo '<small>Set Month Days font color</small>';
			echo '<form name="izc_set" action="'.$_SERVER['PHP_SELF'].'" method="get">';
				echo '<input type="hidden" name="action" value="izc_set_days_font">';
				echo '<input type="hidden" name="page" value="izc-settings">';
					echo '<input class="color" type="text" name="color" value="'.get_option('izc_fontcolor_days').'">';
				echo '<input type="submit" name="submit" value="Save" class="button-primary" />&nbsp;&nbsp;';
			echo '</form>';
			
		echo '</div>';
	echo '</div>';
}

function izc_change_event_page($oldslug,$newslug){

	global $wpdb;
	
	$is_duplicate = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'posts WHERE post_name="'.$newslug.'" AND ID<>'._EPAGEID);
	if(!$is_duplicate){
		$event_page = array();
		$event_page['ID'] = _EPAGEID;
		$event_page['post_name'] = $newslug;
		
		wp_update_post( $event_page );	
		update_option('izc_events_page_slug',$newslug);
		}
	else
		{
		echo('<div class="error" id="message"><p>Failed! page "<strong>'.$is_duplicate->post_title.'</strong>" is using "<strong>'.$newslug.'</strong>" as a slug.</p></div>');
		}
}

?>