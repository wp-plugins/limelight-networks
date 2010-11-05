
<?php

// Compares two objects by their 'title' property.
function limelight_title_compare( $a, $b ) {
	if ($a->title == $b->title) {
			return 0;
	}
	return ($a->title < $b->title) ? -1 : 1;
}

// Makes an API call to retrieve the channels list
function limelight_get_sorted_channels() {
	$limelight_options = get_option( 'limelight_options' );
	return limelight_get_sorted_resource_list( "http://api.delvenetworks.com/organizations/".$limelight_options['limelight_org_id']."/channels.json", LIMELIGHT_CHANNELS_CACHE_KEY );
}

// Makes an API call to retrieve the media list
function limelight_get_sorted_media() {
	$limelight_options = get_option( 'limelight_options' );
	return limelight_get_sorted_resource_list( "http://api.delvenetworks.com/organizations/".$limelight_options['limelight_org_id']."/media.json", LIMELIGHT_MEDIA_CACHE_KEY );
}

// Returns a list of JSON-decoded resources retrieved from the specified url.
// Uses the wp_cache* functions.
function limelight_get_sorted_resource_list( $url , $key) {
	$resource_list = wp_cache_get( $key , LIMELIGHT_CACHE_GROUP );
	if ( false == $resource_list ) {
			$response = wp_remote_get( $url );
			if( is_wp_error( $response ) ) {
				return false;
			}
			$json = wp_remote_retrieve_body( $response );

			if ($json === false) {
				return false;
			}

			if (!function_exists('json_decode')) {
				require_once 'JSON.php';
				$json_decoder = new Services_JSON;
				$resource_list = $json_decoder->decode( $json );
			} else {
				$resource_list = json_decode( $json );
			}
      // Sort by title
			usort($resource_list, 'limelight_title_compare' );
			return $resource_list;

		wp_cache_set( $key , $resource_list , LIMELIGHT_CACHE_GROUP );
	}
	return $resource_list;
}

?>