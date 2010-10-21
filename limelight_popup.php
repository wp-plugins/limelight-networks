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

// check for rights
if ( !is_user_logged_in() || !current_user_can('edit_posts') )
 wp_die( __('You are not allowed to be here' ) );

// Site URL
$site_url = get_option( 'siteurl' );

// get the options
$limelight_options = get_option( 'limelight_options' );

// Caching function
function request_cached_resource( $url , $cache_file_key , $cache_options, $timeout=7200 ) {
	$cache_file = $cache_options[$cache_file_key];
	if(!file_exists( $cache_file ) || filemtime( $cache_file ) < ( time()-$timeout ) ) {
		$response = wp_remote_get( $url );
		if( is_wp_error( $response ) ) {
			return false;
		}
		$data = wp_remote_retrieve_body( $response );
		if ( $data === false ) return false;
		$tmpf = tempnam( sys_get_temp_dir() , $cache_file_key );
		$fp = fopen( $tmpf , "w" );
		fwrite( $fp, $data );
		fclose( $fp );
		$cache_options[$cache_file_key] = $tmpf;
		update_option( 'limelight_options', $cache_options );
	} else {
		return file_get_contents( $cache_file );
	}
	return( $data );
}

function title_compare($a, $b)
{
	if ($a->title == $b->title) {
	    return 0;
	}
	return ($a->title < $b->title) ? -1 : 1;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Limelight Networks</title>
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
	<div id="media_panel" class="panel" style="overflow:hidden;">
		<p>Media</p>
		<?php
		$media_url = "http://api.delvenetworks.com/organizations/".$limelight_options['limelight_org_id']."/media.json";
		$media_json = request_cached_resource( $media_url , 'limelight_media_cache_file' , $limelight_options );
		if ( $media_json === false) {
			echo "<p><strong>Error loading media. Try reloading this window.</strong></p>";
		}
		?>
		<select id="media_select">
		<?php
			$media_list = json_decode( $media_json );
			usort($media_list, 'title_compare');
			$count = count( $media_list );
			for ($i = 0; $i < $count; $i++) {
					$title = $media_list[$i]->title;
					$id = $media_list[$i]->media_id;
					echo "<option value=\"mediaId=$id\">$title</option>\n";
			}
		?>
		</select>
		<p>Width</p>
		<input id="media_width" type="text" value="<?php echo $limelight_options['limelight_media_player_width']; ?>" />
		<p>Height</p>
		<input id="media_height" type="text" value="<?php echo $limelight_options['limelight_media_player_height']; ?>" />
		<p>Player</p>
		<input id="media_player" type="text" size="45" value="<?php echo $limelight_options['limelight_media_player_form']; ?>" />
		<p>Flashvars</p>
		<input id="media_flashvars" type="text" size="60" value="<?php echo $limelight_options['limelight_additional_flashvars']; ?>" />
		<div class="mceActionPanel">
			<div style="float: left">
				<input type="button" id="cancel" name="cancel" value="Cancel" onclick="tinyMCEPopup.close();" />
			</div>

			<div style="float: right">
				<input type="submit" id="insert" name="insert" value="Insert" onclick="select_media();" />
			</div>
		</div>
	</div>
	<div id="channels_panel" class="panel current" style="overflow:hidden;">
		<p>Channel</p>
		<?php
		$url = "http://api.delvenetworks.com/organizations/".$limelight_options['limelight_org_id']."/channels.json";
		$channels_json = request_cached_resource( $url , 'limelight_channels_cache_file' , $limelight_options);
		if ( $channels_json === false) {
			echo "<p><strong>Error loading channels. Try reloading this window.</strong></p>";
		}
		?>
		<select id="channel_select">
		<?php
			$channels_list = json_decode( $channels_json );
			usort($channels_list, 'title_compare');
			$count = count( $channels_list );
			for ($i = 0; $i < $count; $i++) {
					$title = $channels_list[$i]->title;
					$id = $channels_list[$i]->channel_id;
					echo "<option value=\"channelId=$id\">$title</option>\n";
			}
		?>
		</select>
		<p>Width</p>
		<input id="channel_width" type="text" value="<?php echo $limelight_options['limelight_channels_player_width']; ?>" />
		<p>Height</p>
		<input id="channel_height" type="text" value="<?php echo $limelight_options['limelight_channels_player_height']; ?>" />
		<p>Player</p>
		<input id="channel_player" type="text" size="45" value="<?php echo $limelight_options['limelight_channels_player_form']; ?>" />
		<p>Flashvars</p>
		<input id="channel_flashvars" type="text" size="60" value="<?php echo $limelight_options['limelight_additional_flashvars']; ?>" />
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