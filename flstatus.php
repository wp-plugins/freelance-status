<?php
/*
Plugin Name: Freelance Status
Plugin URI: http://konrad-haenel.de/downloads/freelance-status-wordpress-widget/
Description: A simple Freelance Status sidebar widget for Wordpress
Author: Konrad Haenel
Version: 0.0.6
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
        $title = empty($options['title']) ? 'My Status:' : $options['title'];
        $textA = empty($options['textA']) ? 'I\'m available.' : $options['textA'];
		$textB = empty($options['textB']) ? 'I\'m not available.' : $options['textB'];
		$statusAcolor = empty($options['statusAcolor']) ? '#5d8c5b' : $options['statusAcolor'];
		$statusBcolor = empty($options['statusBcolor']) ? '#8c5b5b' : $options['statusBcolor'];
		$subline = empty($options['subline']) ? '' : $options['subline'];
		$status = empty($options['status']) ? 'A' : $options['status'];

         // It's important to use the $before_widget, $before_title,
         // $after_title and $after_widget variables in your output.
		echo $before_widget;
?>
		<div style="border: 1px solid #5d5d5d; font-weight: bold; text-align: center;">
		    <div style="padding: 10px 10px; background-color:#F1F1F1"><?php echo $title ?></div>
		    <div style="padding: 20px 10px 10px; background:<?php echo ($status == 'A')? $statusAcolor : $statusBcolor ;?> url(<?php echo WP_PLUGIN_URL.'/freelance-status/top_arrow.png' ?>) no-repeat scroll center top">
			<span style="color:#FFFFFF"><?php echo ($status == 'A')? $textA : $textB ; ?></span>
			<?php if ($subline != '') { ?><br><span style="font-weight: normal; font-size: .8em; color:#FFFFFF;"><?php echo $subline; ?></span><?php } ?>
			</div>
		</div>
<?php
		 echo $after_widget;
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
            $newoptions['textA'] = strip_tags(stripslashes($_POST['flstatus-textA']));
			$newoptions['textB'] = strip_tags(stripslashes($_POST['flstatus-textB']));
			$newoptions['statusAcolor'] = strip_tags(stripslashes($_POST['flstatus-statusAcolor']));
			$newoptions['statusBcolor'] = strip_tags(stripslashes($_POST['flstatus-statusBcolor']));
			$newoptions['subline'] = strip_tags(stripslashes($_POST['flstatus-subline']));
			$newoptions['status'] = strip_tags(stripslashes($_POST['flstatus-status']));
			
			// If original widget options do not match control form
	        // submission options, update them.
	        if ( $options != $newoptions ) {
	            $options = $newoptions;
	            update_option('widget_flstatus', $options);
	        }
        }

        // Format options as valid HTML. Hey, why not.
        $title = htmlspecialchars($options['title'], ENT_QUOTES);
        $textA = htmlspecialchars($options['textA'], ENT_QUOTES);
		$textB = htmlspecialchars($options['textB'], ENT_QUOTES);
		$subline = htmlspecialchars($options['subline'], ENT_QUOTES);
		
		// ...but don't format the color and status values
		$statusAcolor = $options['statusAcolor'];
		$statusBcolor = $options['statusBcolor'];
		$status = $options['status'];

// The HTML below is the control form for editing options.
?>
        <div>
	        <label for="flstatus-title" style="line-height:35px;display:block;">Status description:</label> <input type="text" id="flstatus-title" name="flstatus-title" value="<?php echo $title; ?>" />
			<hr />
			<label for="flstatus-status" style="line-height:35px;display:block;">Current status: </label>
				<input type="radio" id="flstatus-status" name="flstatus-status" value="A" <?php echo ($status == 'A')? 'checked="checked"': ''; ?>/>A 
				<input type="radio" id="flstatus-status" name="flstatus-status" value="B" <?php echo ($status == 'B')? 'checked="checked"': ''; ?>/>B
			<hr />
	        <label for="flstatus-textA" style="line-height:35px;display:block;">Status A text: <br /></label><input type="text" id="flstatus-textA" name="flstatus-textA" value="<?php echo $textA; ?>" />
			<label for="flstatus-statusAcolor" style="line-height:35px;display:block;">Status A color: </label><input type="text" size="7" maxlength="7" id="flstatus-statusAcolor" name="flstatus-statusAcolor" value="<?php echo $statusAcolor; ?>" />
			<hr />
			<label for="flstatus-textB" style="line-height:35px;display:block;">Status B text: <br /></label><input type="text" id="flstatus-textB" name="flstatus-textB" value="<?php echo $textB; ?>" />
			<label for="flstatus-statusBcolor" style="line-height:35px;display:block;">Status B color: </label><input type="text" size="7" maxlength="7" id="flstatus-statusBcolor" name="flstatus-statusBcolor" value="<?php echo $statusBcolor; ?>" />
			<hr />
			<label for="flstatus-subline" style="line-height:35px;display:block;">Subline: <br /></label><input type="text" id="flstatus-subline" name="flstatus-subline" value="<?php echo $subline; ?>" />
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