<p>Media</p>
<?php
$media_list = limelight_get_sorted_media();
if ( $media_list === false) {
	echo "<p><strong>Error loading media. Try reloading this window.</strong></p>";
}
?>
<select id="media_select">
<?php
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