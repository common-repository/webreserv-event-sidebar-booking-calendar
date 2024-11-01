<?php
/*
Plugin Name: WebReserv EVENT Sidebar Booking Calendar
Plugin URI: http://blog.webreserv.eu/webreserv-event-sidebar-booking-calendar-for-wordpress/
Description: This is the WebReserv EVENT SideBar Booking Calendar plugin. It allows you to create a sidebar component that opens the WebReserv booking system in the EVENT Calendar view. To embed the component directly on a PAGE or POST, read <a href="http://blog.webreserv.eu/webreserv-event-sidebar-booking-calendar-for-wordpress/">WebReserv EVENT Sidebar Booking Calendar</a>. 
Version: 0.9 BETA
Author: WebReserv
Author URI: http://blog.webreserv.eu/webreserv-event-sidebar-booking-calendar-for-wordpress/

*/

function event_widget_webreserv($args) {
	// First we grab the Wordpress theme args, which we
	// use to display the widget
	extract($args);
	
	// Now we sniff around to see if there are
	// any preset options
	$options = get_option("event_widget_webreserv");


	
	// If no options have been set, we need to set them
	if (!is_array( $options )) {
		$options = array(
	  	'event_title' => 'Event Calendar',
		'event_bizid' => 'demogymes',
		'event_eu_or_com' => '.EU',
		'event_calendar_width' => '200',
		'event_calendar_height' => '850'

	  	);
	}      
	
	// Display the widget!
	echo $before_widget;
	echo $before_title;

	// set some height and width if they are missing
	if ($options['event_calendar_width'] == '')
		{
		$options['event_calendar_width'] = '200';
		}	
	if ($options['event_calendar_height'] == '')
		{
		$options['event_calendar_height'] = '850';
		}	


	// set URL for booking component
	$event_iframe_url_start = "<iframe src=";
	$event_iframe_url_end = " marginwidth=0 marginheight=0 width=".$options['event_calendar_width']." height=".$options['event_calendar_height']." frameborder=0><font size=6px>Powered-by <a href=http://blog.webreserv.eu/webreserv-booking-plugins-for-wordpress/ target=_new>WebReserv</a></font></iframe>";
	$event_wr_url1 = "http://www.webreserv";
	$event_wr_url2 = "/bookingcalendar.do";

	$event_wr_css = get_option('siteurl')."/wp-content/plugins/webreserv-event-sidebar-booking-calendar/sidebar-event-calendar.css";
	$event_wr_css_popup = get_option('siteurl')."/wp-content/plugins/webreserv-event-sidebar-booking-calendar/sidebar-event-calendar-popup.css";
	
	// Set business ID parameter'
	$event_businessid_url = "?businessid=".$options['event_bizid'];


	// Work out whether to use .eu or .com url
	// if the business id = demogymes, then you must overrule the option and set to .eu
	if ($options['event_bizid'] == 'demogymes')
		{
		$event_wr_url_eu_or_com = '.EU';
		}
	else
		{
		$event_wr_url_eu_or_com = $options['event_eu_or_com'];
		}



	// Build the Header URL

	$event_webreserv_header_link = "<a target=_new href=".$event_wr_url1.$event_wr_url_eu_or_com.$event_wr_url2.$event_businessid_url."&css=".$event_wr_css_popup.">".$options['event_title']."</a>";


	// show the link
	echo $event_webreserv_header_link;

	echo $after_title;
		//Our Widget Component
		echo 	$event_iframe_url_start.$event_wr_url1.$event_wr_url_eu_or_com.$event_wr_url2.$event_businessid_url."&css=".$event_wr_css.$event_iframe_url_end;
	echo $after_widget;
}


function event_widget_control() {

	// We need to grab any preset options
	$options = get_option("event_widget_webreserv");
	
	// No options? No problem! We set them here.
	if (!is_array( $options )) {
		$options = array(
	  	'event_title' => 'Event Calendar',
	  	'event_bizid' => 'demogymes',
		'event_eu_or_com' => '.EU',
		'event_calendar_width' => '200',
		'event_calendar_height' => '850'

		);
	}      
	
	// Is the user has set the options and clicked save,
	// Then we grab them using the $_POST function.
	if ($_POST['event-widgetTutorial-Submit']) {
		$options['event_title'] = 
		  htmlspecialchars($_POST['event-widget-WidgetTitle']);
		$options['event_bizid'] = 
		  htmlspecialchars($_POST['event-widget-bizid']);
		$options['event_eu_or_com'] = 
		  htmlspecialchars($_POST['event-eu-or-com']);
		$options['event_calendar_width'] = 
		  htmlspecialchars($_POST['event-calendar-width']);
		$options['event_calendar_height'] = 
		  htmlspecialchars($_POST['event-calendar-height']);
		// And we also update the options in the Wordpress Database
		update_option("event_widget_webreserv", $options);
	}
	
?>
<p>
<b>WebReserv EVENT Sidebar Booking Calendar</b><br>
This widget allows you to add the WebReserv EVENT booking system to your wordpress website.<br>
To read more about the WebReserv Wordpress plugins - <a href="http://blog.webreserv.eu/webreserv-booking-plugins-for-wordpress/" Target="_new">click here</a>
<hr>
<b>Do you already have a WebReserv Account?</b><br>
Yes I do - <a href="http://blog.webreserv.eu/finding-your-webreserv-business-id-in-the-back-office/" target="_new">click here to find your business ID.</a><br>
No I don't...<br>
If you are located in <b>Europe</b><br>
<a href="https://www.webreserv.eu/signup.do" target="_new">click here to create an account.</a><br>
If you are located <b>outside Europe</b><br>
<a href="https://www.webreserv.com/signup.do" target="_new">click here to create an account.</a><br>
<hr>
	<label for="event-widget-bizid"><b>Business ID</b><br></label>
	<input type="text" 
      id="event-widget-bizid" 
      name="event-widget-bizid" 
      value="<?php echo $options['event_bizid'];?>" />
<br>
<i>The business ID associates your plugin with your WebReserv account.<br>
The demo account ID "demogymes" can be used to test the system.<br>
<a href="http://blog.webreserv.eu/finding-your-webreserv-business-id-in-the-back-office/" target="_new">Click here to read how to find your business ID</a></i>
<hr>
	<label for="event-eu-or-com"><b>WebReserv.EU or WebReserv.COM</b><br></label>
	<SELECT 
	NAME="event-eu-or-com" 
	id="event-eu-or-com">  
	 <OPTION VALUE=".EU" <?php if($options['event_eu_or_com'] == '.EU')  echo "SELECTED";?>    > .EU
	 <OPTION VALUE=".COM" <?php if($options['event_eu_or_com'] == '.COM')  echo "SELECTED";?>    > .COM
	</SELECT>
<br>
<i>Choose whether you have a WebReserv.EU or a WebReserv.COM account.</i>
<hr>
	<label for="event-widget-WidgetTitle"><b>Title</b><br></label>
	<input type="text" 
      id="event-widget-WidgetTitle" 
      name="event-widget-WidgetTitle" 
      value="<?php echo $options['event_title'];?>" />
<br>
<i>This is the title you will have on the sidebar. Clicking on the Title opens the WebReserv EVENT Calendar in a new window.<br>You can leave this blank and the header will not be shown.</i>
<hr>

	<label for="event-calendar-width"><b>Width</b><br></label>
	<input type="text" 
      id="event-calendar-width" 
      name="event-calendar-width" 
      value="<?php echo $options['event_calendar_width'];?>" />
<br>
<i>Set the width of the calendar - a width under 200 cuts off some of the data entry fields, Also, long event names may cause the width of the component to increase. If you see a horizontal scroll bar, you may want to increase this value.</i>
<hr>

	<label for="event-calendar-height"><b>Height</b><br></label>
	<input type="text" 
      id="event-calendar-height" 
      name="event-calendar-height" 
      value="<?php echo $options['event_calendar_height'];?>" />
<br>
<i>Set the height of the calendar - Remember, the more events you have - the higher you must set this. If you see a scroll bar to the right of the component, you may want to increase this value.</i>
<hr>
<b>CSS Styling</b><br>
There are two CSS files located in the plugin folder.<br>
One is used to set the CSS for the sidebar component, while the other is used to set the CSS for the calendar that opens when clicking on the Title (if it is given).
<hr>

	<input type="hidden" 
      id="event-widgetTutorial-Submit" 
      name="event-widgetTutorial-Submit" 
      value="1" />

</p>
<?php
}

function event_widget_init() {
	// These are the Wordpress functions which will register
	// the widget, and also the widget control - or
	// 'options', to you and me.
	register_sidebar_widget('WebReserv EVENT Sidebar', 'event_widget_webreserv');
	register_widget_control('WebReserv EVENT Sidebar', 'event_widget_control');
}

add_action("plugins_loaded", "event_widget_init");
?>
