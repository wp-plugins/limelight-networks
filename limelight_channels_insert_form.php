<p>Channel</p>
<?php
$channels_list = limelight_get_sorted_channels();
if ( $channels_list === false) {
	echo "<p><strong>Error loading channels. Try reloading this window.</strong></p>";
}
?>
<select id="channel_select">
<?php
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