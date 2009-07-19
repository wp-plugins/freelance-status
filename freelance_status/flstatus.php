<?php
/*
Plugin Name: Freelance Status
Plugin URI: http://konrad-haenel.de
Description: A simple Freelance Status sidebar widget for Wordpress
Author: Konrad Haenel
Version: 0.0.2
Author URI: http://konrad-haenel.de

    My Widget is released under the GNU General Public License (GPL)
    http://www.gnu.org/licenses/gpl.txt

    This is a WordPress plugin (http://wordpress.org) and widget
*/

// We're putting the plugin's functions in one big function we then
// call at 'plugins_loaded' (add_action() at bottom) to ensure the
// required Sidebar Widget functions are available.
function widget_flstatus_init() {

    // Check to see required Widget API functions are defined...
    if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
        return; // ...and if not, exit gracefully from the script.

    // This function prints the sidebar widget--the cool stuff!
    function widget_flstatus($args) {

        // $args is an array of strings which help your widget
        // conform to the active theme: before_widget, before_title,
        // after_widget, and after_title are the array keys.
        extract($args);

        // Collect our widget's options, or define their defaults.
        $options = get_option('widget_flstatus');
        $title = empty($options['title']) ? 'Freelance Status' : $options['title'];
        $text = empty($options['text']) ? 'Hello World!' : $options['text'];
		$statuscolor = empty($options['statuscolor']) ? '#999999' : $options['statuscolor'];

         // It's important to use the $before_widget, $before_title,
         // $after_title and $after_widget variables in your output.
		echo $before_widget;
?>
		<div style="border: 1px solid #5d5d5d; font-weight: bold; text-align: center;">
		    <div style="padding: 10px 10px; background-color:#F1F1F1"><?php echo $title ?></div>
		    <div style="padding: 20px 10px 10px; background:<?php echo $statuscolor ?> url(<?php echo WP_PLUGIN_URL.'/freelance_status/top_arrow.png' ?>) no-repeat scroll center top"><span style="color:#FFFFFF"><?php echo $text ?></span></div>
		</div>
<?php
		 echo $after_widget;
		 
        /*echo $before_widget;
        echo $before_title . $title . $after_title;
        echo $text;
        echo $after_widget;*/
    }

    // This is the function that outputs the form to let users edit
    // the widget's title and so on. It's an optional feature, but
    // we'll use it because we can!
    function widget_flstatus_control() {

        // Collect our widget's options.
        $options = get_option('widget_flstatus');

        // This is for handing the control form submission.
        if ( $_POST['flstatus-submit'] ) {
            // Clean up control form submission options
            $newoptions['title'] = strip_tags(stripslashes($_POST['flstatus-title']));
            $newoptions['text'] = strip_tags(stripslashes($_POST['flstatus-text']));
			$newoptions['statuscolor'] = strip_tags(stripslashes($_POST['flstatus-statuscolor']));
        }

        // If original widget options do not match control form
        // submission options, update them.
        if ( $options != $newoptions ) {
            $options = $newoptions;
            update_option('widget_flstatus', $options);
        }

        // Format options as valid HTML. Hey, why not.
        $title = htmlspecialchars($options['title'], ENT_QUOTES);
        $text = htmlspecialchars($options['text'], ENT_QUOTES);
		
		// ...but don't format the color value
		$statuscolor = $options['statuscolor'];

// The HTML below is the control form for editing options.
?>
        <div>
	        <label for="flstatus-title" style="line-height:35px;display:block;">Widget title: <input type="text" id="flstatus-title" name="flstatus-title" value="<?php echo $title; ?>" /></label>
	        <label for="flstatus-text" style="line-height:35px;display:block;">Widget text: <input type="text" id="flstatus-text" name="flstatus-text" value="<?php echo $text; ?>" /></label>
			<label for="flstatus-statuscolor" style="line-height:35px;display:block;">Status color: <input type="text" id="flstatus-statuscolor" name="flstatus-statuscolor" value="<?php echo $statuscolor; ?>" /></label>
	        <input type="hidden" name="flstatus-submit" id="flstatus-submit" value="1" />
        </div>
    <?php
    // end of widget_flstatus_control()
    }

    // This registers the widget. About time.
    register_sidebar_widget('Freelance Status', 'widget_flstatus');

    // This registers the (optional!) widget control form.
    register_widget_control('Freelance Status', 'widget_flstatus_control');
}

// Delays plugin execution until Dynamic Sidebar has loaded first.
add_action('plugins_loaded', 'widget_flstatus_init');
?>