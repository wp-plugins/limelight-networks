<?php
/**
 * The HTML for the admin options page.
 *
 */
$limelight_options = get_option( 'limelight_options');

if( $_POST['limelight_hidden'] == 'Y' ) {
	// API Settings
	$limelight_options['limelight_org_id'] = $_POST['limelight_org_id'];

	// Media settings
	$limelight_options['limelight_media_player_width'] = $_POST['limelight_media_player_width'];
	$limelight_options['limelight_media_player_height'] = $_POST['limelight_media_player_height'];
	$limelight_options['limelight_media_player_form'] = $_POST['limelight_media_player_form'];

	// Channels settings
	$limelight_options['limelight_channels_player_width'] = $_POST['limelight_channels_player_width'];
	$limelight_options['limelight_channels_player_height'] = $_POST['limelight_channels_player_height'];
	$limelight_options['limelight_channels_player_form'] = $_POST['limelight_channels_player_form'];

	// General Settings
	$limelight_options['limelight_additional_flashvars'] = $_POST['limelight_additional_flashvars'];

	// Bust cache in case org ID has changed
	$limelight_options['limelight_media_cache_file'] = '';
	$limelight_options['limelight_channels_cache_file'] = '';

	update_option( 'limelight_options' , $limelight_options);
	?>
	<div class="updated"><p><strong><?php echo __( 'Options saved.' , 'limelight_text_domain' ); ?></strong></p></div>
	<?php
}
?>

<div class="wrap">
	<?php echo '<h2>' . __( 'Limelight VPS Options', 'limelight_text_domain' ) . '</h2>'; ?>

	<?php if (version_compare(PHP_VERSION, '5.2.0') < 0) { ?>
		<?php echo '<h4>' . __( 'Limelight VPS Requirements', 'limelight_text_domain' ) . '</h4>'; ?>
		<p>
			<strong style="color: #ff0000;">This plugin requires PHP 5.2.0.  You are running <?php echo phpversion(); ?></strong>
		</p>
	<?php } ?>

	<?php echo '<h4>' . __( 'Embed Code Overview', 'limelight_text_domain' ) . '</h4>'; ?>
	<p>
		To insert a video or channel into a post or page, using the following shortcode:<code>[limelight FLASHVARS WIDTH HEIGHT]</code>where FLASHVARS is a <a href="http://kb2.adobe.com/cps/164/tn_16417.html">string of variables</a> to pass to the player, and HEIGHT and WIDTH are optional dimensions in pixels.	 This shortcode gets transformed into an embedcode when the post/page is loaded.
	</p>
	<p>
		For example:
		<code>[limelight mediaId=1fcedd0a66334ac28fbb2a4117707145&playerForm=DelvePlaylistPlayer 800 400]</code>
	</p>
	<p>
		This plugin also adds a button to the visual editor that will popup a window and allow you to select from your media and channels.
	</p>

	<form name="limelight_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="limelight_hidden" value="Y">

		<?php		 echo '<h4>' . __( 'Embed Code Settings', 'limelight_text_domain' ) . '</h4>'; ?>
		<p>Defaults for embedding Media</p>
		<div style="padding-left:15px">
			<p><?php _e('Player width (px): ', 'limelight_text_domain' ); ?><input type="text" name="limelight_media_player_width" value="<?php echo $limelight_options['limelight_media_player_width']; ?>" size="5"><?php _e( " ex: 480" ); ?></p>
			<p><?php _e('Player height (px): ', 'limelight_text_domain' ); ?><input type="text" name="limelight_media_player_height" value="<?php echo $limelight_options['limelight_media_player_height']; ?>" size="5"><?php _e( " ex: 411" ); ?></p>
			<p><?php _e('Player: ', 'limelight_text_domain' ); ?><input type="text" name="limelight_media_player_form" value="<?php echo $limelight_options['limelight_media_player_form']; ?>" size="45"><?php _e( " ex: DelvePlayer" ); ?></p>
		</div>

		<p>Defaults for embedding Channels</p>
		<div style="padding-left:15px">
			<p><?php _e('Player width (px): ', 'limelight_text_domain' ); ?><input type="text" name="limelight_channels_player_width" value="<?php echo $limelight_options['limelight_channels_player_width']; ?>" size="5"><?php _e( " ex: 940" ); ?></p>
			<p><?php _e('Player height (px): ', 'limelight_text_domain' ); ?><input type="text" name="limelight_channels_player_height" value="<?php echo $limelight_options['limelight_channels_player_height']; ?>" size="5"><?php _e( " ex: 413" ); ?></p>
			<p><?php _e('Player: ', 'limelight_text_domain' ); ?><input type="text" name="limelight_channels_player_form" value="<?php echo $limelight_options['limelight_channels_player_form']; ?>" size="45"><?php _e( " ex: DelvePlaylistPlayer" ); ?></p>
		</div>

		<p>General Defaults</p>
		<div style="padding-left:15px">
			<p><?php _e("Additional Flashvars: ", 'limelight_text_domain'); ?><input type="text" name="limelight_additional_flashvars" value="<?php echo $limelight_options['limelight_additional_flashvars']; ?>" size="40"><?php _e(" ex: deepLink=true&var=val" ); ?></p>
		</div>

		<?php echo '<h4>' . __( 'API Settings' , 'limelight_text_domain' ) . '</h4>'; ?>
		<p><?php _e("Organization ID: " ); ?><input type="text" name="limelight_org_id" value="<?php echo $limelight_options['limelight_org_id']; ?>" size="45"><?php echo __(" ex: 1fcedd0a66334ac28fbb2a4117707145", 'limelight_text_domain'); ?></p>

		<p class="submit">
		<input type="submit" name="Submit" value="<?php _e( 'Update Options', 'limelight_text_domain' ) ?>" />
		</p>
	</form>
</div>

