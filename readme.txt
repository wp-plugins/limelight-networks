=== Limelight VPS ===
Contributors: nstielau
Tags: video, media, delve, delve networks, limelight, limelight networks, limelight vps, embed codes
Requires at least: 3.0.0
Tested up to: 3.0.1
Stable tag: 1.1.2

Limelight VPS video platform integration.  Add your media to any Wordpress post or page.

== Description ==

This plugin integrates your Wordpress installation with your Limelight VPS account, making it
easy to add audio, video, and channels into your Wordpress posts and pages.

== Installation ==

Standard plugin installation procedure:

1. Upload the plugin directory `limelight-networks` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Configure the plugin in the Limelight VPS settings page (add your organization id, choose default options)
4. Insert videos or channels using the Limelight VPS shortcode (`[limelight FLASHVARS WIDTH HEIGHT]`) or the Limelight VPS button added to the editor.
5. (Optional): Install the wp-file-cache plugin to improve admin user-interface performace by caching media/channel API requests.

== Frequently Asked Questions ==

= Do I need a Delve Networks / Limelight VPS Account? =

Yes.

= Where can I find my 'organization ID'? =

Log in to your Limelight VPS account, go to 'Settings', and select the 'Developer Tools' tab.
Your will see your 32 character organization ID.  It will look something like "1f09ae2dd5a7410a932c154e97b5593f".

== Screenshots ==

1. The two buttons to insert VPS Media: the media upload area and the visual editor.
2. Select your media/channels easily from drop-down menus.
3. View all of your media/channels in drop-down menus.
4. Use the wizard or manually use the Limelight VPS shortcode to insert video into your Wordpress posts and pages.
5. Easily embed your Limelight VPS videos in your Wordpress posts and pages.

== Changelog ==.

= 1.0.0 =
* First version.

= 1.0.1 =
* Trivial style and text changes.

= 1.0.2 =
* Trivial style and text changes.

= 1.0.3 =
* Using single option row, uninstall handler, specifying defaults for both channels and media embeds.

= 1.0.4 =
* Changing name from Limelight Networks to Limelight VPS

= 1.0.5 =
* More text changes.

= 1.1.0 =
* Added UI for Add a Video area.
* Adding JSON-decoder for PHP 4

= 1.1.1 =
* Fix for new "Add a Video" tabs

= 1.1.2 =
* Readme Update

= 1.1.3 =
* Version Update

== Upgrade Notice ==

= 1.0.0 =
First version.
