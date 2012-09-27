
/* Import plugin specific language pack */
//tinyMCE.importPluginLanguagePack('simage', 'en,tr,he,nb,ru,ru_KOI8-R,ru_UTF-8,nn,fi,cy,es,is,pl'); // <- Add a comma separated list of all supported languages

// Singleton class
var TinyMCE_SImagePlugin = {

	getInfo : function() {
		return {
			longname : 'Simple image upload plugin',
			author : 'Sergey Galashyn',
			authorurl : 'http://ziost.com',
			infourl : 'http://ziost.com',
			version : "1.0"
		};
	},


	getControlHTML : function(cn) {
		switch (cn) {
			case "simage":
				return tinyMCE.getButtonHTML(cn, 'lang_simage_desc', '{$pluginurl}/images/simage.gif', 'mceSImage', true);
		}

		return "";
	},

	/**
	 * Executes a specific command, this function handles plugin commands.
	 */

	execCommand : function(editor_id, element, command, user_interface, value) {
		// Handle commands
		switch (command) {
			// Remember to have the "mce" prefix for commands so they don't intersect with built in ones in the browser.
			case "mceSImage":

				// Open a popup window and send in some custom data in a window argument
				var simage = new Array();

//				simage['file'] = '../../plugins/simage/simage.php'; // Relative to theme
				simage['width'] = 360;
				simage['height'] = 110;

				simage['file'] = tinyMCE.getParam("plugin_simage_action");

				simage['path'] = tinyMCE.getParam("plugin_simage_path");

				tinyMCE.openWindow(simage, {editor_id : editor_id});

				// Let TinyMCE know that something was modified
				tinyMCE.triggerNodeChange(false);

				return true;
		}

		// Pass to next handler in chain
		return false;
	}



};

// Adds the plugin class to the list of available TinyMCE plugins
tinyMCE.addPlugin("simage", TinyMCE_SImagePlugin);
