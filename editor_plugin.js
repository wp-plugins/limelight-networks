// Docu : http://wiki.moxiecode.com/index.php/TinyMCE:Create_plugin/3.x#Creating_your_own_plugins

(function() {
  // Load plugin specific language pack
  tinymce.PluginManager.requireLangPack('limelight_networks');

  tinymce.create('tinymce.plugins.limelight_networks', {
    /**
     * Initializes the plugin, this will be executed after the plugin has been created.
     * This call is done before the editor instance has finished it's initialization so use the onInit event
     * of the editor instance to intercept that event.
     *
     * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
     * @param {string} url Absolute URL to where the plugin is located.
     */

    init : function(ed, url) {
      // Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
      ed.addCommand('mce_limelight', function() {
        ed.windowManager.open({
          file : url + '/limelight_popup.php',
          width : 500,
          height : 400,
          inline : 1
        }, {
          plugin_url : url // Plugin absolute URL
        });
      });

      // Register example button
      ed.addButton('limelight_networks', {
        title : 'Insert Limelight VPS media',
        cmd : 'mce_limelight',
        image : url + '/limelight_logo.png'
      });

      // Add a node change handler, selects the button in the UI when a image is selected
      ed.onNodeChange.add(function(ed, cm, n) {
        cm.setActive('limelight', n.nodeName == 'IMG');
      });
    },

    /**
     * Returns information about the plugin as a name/value array.
     * The current keys are longname, author, authorurl, infourl and version.
     *
     * @return {Object} Name/value array containing information about the plugin.
     */
    getInfo : function() {
      return {
          longname  : 'Limelight VPS',
          author    : 'Limelight VPS',
          authorurl : 'http://limelightnetworks.com',
          infourl   : 'http://limelightnetworks.com',
          version   : "1.0"
      };
    }
  });

  // Register plugin
  tinymce.PluginManager.add('limelight_networks', tinymce.plugins.limelight_networks);
})();


