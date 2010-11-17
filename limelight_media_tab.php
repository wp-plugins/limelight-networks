<?php
/**
 * The HTML for post-editing popup window.
 *
 */

// Define Wordpress load path
if ( !defined('WP_LOAD_PATH') ) {
	/** classic root path if wp-content and plugins is below wp-config.php */
	$classic_root = dirname( dirname( dirname( dirname(__FILE__) ) ) ) . '/' ;
	if (file_exists( $classic_root . 'wp-load.php') )
		define( 'WP_LOAD_PATH' , $classic_root );
	else
		exit( 'Could not find wp-load.php' );
}

// Load Wordpress
require_once(WP_LOAD_PATH.'wp-load.php');

// Load Limelight functions
require_once('limelight_functions.php');

// check for rights
if ( !is_user_logged_in() || !current_user_can('edit_posts') )
 wp_die( __('You are not allowed to be here' ) );

// Site URL
$site_url = get_option( 'siteurl' );

// get the options
$limelight_options = get_option( 'limelight_options' );

// Load Global page parameters
global $limelight_upload_type;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Limelight VPS</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
wp_enqueue_script('swfupload-all');
wp_enqueue_script('swfupload-handlers');
wp_enqueue_script('image-edit');
wp_enqueue_script('set-post-thumbnail' );
wp_enqueue_style('imgareaselect');
?>
	<script language="javascript" type="text/javascript">
	function init() {
		tinyMCEPopup.resizeToInnerSize();
	}

	function writeShortCode(flashvars, width, height) {
    var win = window.dialogArguments || opener || parent || top;
    win.send_to_editor("[limelight " + flashvars + " " + width + " " + height + "]");
	}

	function select_channels() {
		var channel_flashvar = document.getElementById('channel_select').value;
		var player = document.getElementById('channel_player').value;
		var width = document.getElementById('channel_width').value;
		var height = document.getElementById('channel_height').value;
		var flashvars = document.getElementById('channel_flashvars').value;
		writeShortCode(channel_flashvar + '&playerForm=' + player + '&' + flashvars, width, height);
	}

	function select_media() {
		var media_flashvar = document.getElementById('media_select').value;
		var player = document.getElementById('media_player').value;
		var width = document.getElementById('media_width').value;
		var height = document.getElementById('media_height').value;
		var flashvars = document.getElementById('media_flashvars').value;
		writeShortCode(media_flashvar + '&playerForm=' + player + '&' + flashvars, width, height);
	}

	function close_modal() {
    var win = window.dialogArguments || opener || parent || top;
    win.send_to_editor("");
	}


</script>
</head>
<body style="margin: 0 8px;">
<?php if ( $limelight_options['limelight_org_id'] != "" && strlen( $limelight_options['limelight_org_id'] ) == 32 ) { ?>
	<div>
    <?php include('limelight_'.$limelight_upload_type.'_insert_form.php'); ?>
		<div class="mceActionPanel">
			<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="Cancel" onclick="close_modal();" />
			</div>

			<div style="float: right">
				<input type="submit" id="insert" name="insert" value="Insert" onclick="select_<?php echo $limelight_upload_type; ?>();" />
			</div>
		</div>
	</div>
<?php } else { ?>
	<p>You must enter in your organization id in the settings page. If you have already entered your organization ID, please make sure it is valid.</p>
	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="OK" onclick="close_modal();" />
		</div>
	</div>
<?php } ?>
</body>
</html>