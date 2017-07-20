<?php
function izcalender_install ($type='install-1') {
	
	global $wpdb;
	
	$table_name = $wpdb->prefix . "iz_calender";
	if($wpdb->get_var("show tables like '$table_name'") != $table_name)
		{
		$sql = "
		CREATE TABLE `".$table_name."` (
		`Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		`izc_event_year` int(4) DEFAULT NULL,
		`izc_event_month` int(2) unsigned DEFAULT '0',
		`izc_event_day` int(2) DEFAULT NULL,
		`izc_event_time` time DEFAULT NULL,
		`izc_event_name` varchar(50) DEFAULT NULL,
		`izc_event_venue` varchar(50) DEFAULT NULL,
		`izc_event_description` blob,
		`izc_event_directions` blob,
		`izc_event_status` varchar(15) DEFAULT NULL,
		`izc_event_published` timestamp,
		PRIMARY KEY (`Id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		
		INSERT INTO ".$table_name." (izc_event_year, izc_event_month, izc_event_day, izc_event_time, izc_event_name, izc_event_venue, izc_event_description)
		VALUES ('".date('Y')."','".date('n')."','".date('j')."', '".date('G').":".date('i').":00', 'Sample Event', 'To be announced', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed massa dui, molestie eget imperdiet a, posuere eget urna. Fusce lacus lorem, adipiscing et rutrum at, auctor egestas elit. In et tempus est. Sed imperdiet bibendum nulla, a eleifend velit lacinia lacinia. Suspendisse a enim urna, at venenatis sapien. Vivamus a mauris vel turpis sodales aliquet eget ut dui. Suspendisse potenti. Etiam diam arcu, condimentum ut ultricies ut, ultricies sit amet neque. Curabitur vel eros sit amet tortor bibendum consectetur ac nec lacus. Integer ac lorem purus. Aliquam consequat commodo accumsan. Sed neque metus, mattis at vestibulum sed, sodales quis mauris. Sed rhoncus pretium tortor eget tempus. Sed fermentum dolor at augue placerat viverra. Aenean non ultrices purus. ');";
		add_option(	"izc_db_version", '3.0'	);
		}
		
		if(get_option('izc_db_version')=='1.0'){
			$wpdb->query('ALTER TABLE '. $wpdb->prefix.'iz_calender CHANGE izc_event_published izc_event_published TIMESTAMP');	
			update_option('izc_db_version','3.0');
		}
		
		if(!get_option(	"izc_events_page_slug"))
			{
			add_option(	"izc_events_page_nav_item"	,	'1'			);
			add_option(	"izc_events_page_slug"		,	'izevents'	);
			add_option(	"izc_bgcolor_today"			,	'#CCC'		);
			add_option(	"izc_fontcolor_today"		,	'#333'		);
			add_option(	"izc_bgcolor_event"			,	'#E7E7E7'	);
			add_option(	"izc_fontcolor_event"		,	'#CCC'		);
			add_option(	"izc_bgcolor_header"		,	'#f2f2f2'	);
			add_option(	"izc_fontcolor_header"		,	'#666'		);
			add_option(	"izc_bgcolor_days"			,	'#CCC'		);
			add_option(	"izc_fontcolor_days"		,	'#333'		);
			add_option(	'izc_popup_direction'		,	'left'		);
			}
		
		$update_event_page = array();
		$update_event_page['ID'] = _EPAGEID;
		$update_event_page['post_status'] = 'publish';
		
		$insert_events_page = array();
		$insert_events_page['post_title'] 	= 'Events';
		$insert_events_page['post_name'] 	= get_option('izc_events_page_slug');
		$insert_events_page['post_type'] 	= 'page';
		$insert_events_page['post_status'] = 'publish';
		$insert_events_page['post_content'] = '
		<p>This page is used to view your full list of events and event details.</p>
		<p>Manage this page as any other, except:</p>
		<ul>
		<li><span style="color:#FF0000;">DO NOT</span> delete this page while IZ-Calender is in use.</li>
		<li><span style="color:#FF0000;">DO NOT</span> change the slug of this page from here, use Admin menu-> IZ-Calender -> Settings -> <em>Set the events page slug</em><br />Go to: <a href="http://codex.wordpress.org/Pages#Changing_the_URL_.28or_.22Slug.22.29_of_Your_Pages" target="_blank">http://codex.wordpress.org/Pages#Changing_the_URL_.28or_.22Slug.22.29_of_Your_Pages</a> to read more on page slugs.</li>
		<li><span style="color:#FF0000;">DO NOT</span> edit this page\'s status or Visibility</li>
		<li>To remove this page from your navigation structure go to Admin menu-> IZ-Calender -> Settings -> <em>Display this page in my primary nav</em> -> <em>Select "No"</em></li>
		<li>The information you see here <strong>will not</strong> display in your theme (user-interface)</li>
		</ul>
		';
		$insert_events_page['ping_status'] = get_option('default_ping_status');
		$insert_events_page['post_author']	= 0;
		
		if($type=='upgrade')
			{	
			wp_insert_post( $insert_events_page );
			}
		else
			{
			$get_events_page = $wpdb->get_var('SELECT ID FROM '.$wpdb->prefix.'posts WHERE post_name="'.get_option('izc_events_page_slug').'"');
			if(!$get_events_page)
				{		
				wp_insert_post( $insert_events_page );
				}
			else
				{
				wp_update_post( $update_event_page );
				}
			}
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}

function izcalender_on_deactivation(){
	$event_page = array();
	$event_page['ID'] = _EPAGEID;
	$event_page['post_status'] = 'private';
	wp_update_post( $event_page );
}
?>