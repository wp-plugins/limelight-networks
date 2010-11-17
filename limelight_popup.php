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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Limelight VPS</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="<?php echo $site_url; ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $site_url; ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $site_url; ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript">
	function init() {
		tinyMCEPopup.resizeToInnerSize();
	}

	function writeShortCode(flashVars, width, height) {
		if(window.tinyMCE) {
			window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, "[limelight " + flashVars + " " + width + " " + height + "]");
			//Peforms a clean up of the current editor HTML.
			//tinyMCEPopup.editor.execCommand('mceCleanup');
			//Repaints the editor. Sometimes the browser has graphic glitches.
			tinyMCEPopup.editor.execCommand('mceRepaint');
			tinyMCEPopup.close();
		}
		return false;
	}

	function select_channel() {
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
</script>
</head>
<body onload="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';document.getElementById('mediatag').focus();" style="display: none">
<?php if ( $limelight_options['limelight_org_id'] != "" && strlen( $limelight_options['limelight_org_id'] ) == 32 ) { ?>
<div class="tabs">
	<ul>
		<li id="channels_tab" class="current"><span><a href="javascript:mcTabs.displayTab('channels_tab','channels_panel');" onmousedown="return false;">Channels</a></span></li>
		<li id="media_tab"><span><a href="javascript:mcTabs.displayTab('media_tab','media_panel');" onmousedown="return false;">Media</a></span></li>
	</ul>
</div>
<div class="panel_wrapper" overflow>
	<!-- media panel -->
	<div id="media_panel" class="panel" style="overflow:hidden;height:325px;">
    <?php include('limelight_media_insert_form.php'); ?>
		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" id="cancel" name="cancel" value="Cancel" onclick="tinyMCEPopup.close();" />
			</div>

			<div style="float: right">
				<input type="submit" id="insert" name="insert" value="Insert" onclick="select_media();" />
			</div>
		</div>
	</div>
	<div id="channels_panel" class="panel current" style="overflow:hidden;height:325px;">
    <?php include('limelight_channels_insert_form.php'); ?>
		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" id="cancel" name="cancel" value="Cancel" onclick="tinyMCEPopup.close();" />
			</div>

			<div style="float: right">
				<input type="submit" id="insert" name="insert" value="Insert" onclick="select_channel();" />
			</div>
		</div>
	</div>
</div>
<?php } else { ?>
	<p>You must enter in your organization id in the settings page. If you have already entered your organization ID, please make sure it is valid.</p>
	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="OK" onclick="tinyMCEPopup.close();" />
		</div>
	</div>
<?php } ?>
</body>
</html>