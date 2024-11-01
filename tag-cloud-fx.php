<?php
/*
Plugin Name: Tag Cloud FX
Plugin URI: http://www.flashxml.net/tag-cloud.html
Description: One of the most advanced Tag Clouds on the web. Fully XML customizable without any Flash knowledge. And it's free!
Version: 0.2.8
Author: FlashXML.net
Author URI: http://www.flashxml.net/
License: GPL2
*/

/* start global parameters */
	$tagcloudfx_params = array(
		'count'	=> 0, // number of Tag Cloud FX embeds
	);
/* end global parameters */

/* start client side functions */
	function tagcloudfx_get_embed_code($tagcloudfx_attributes) {
		global $tagcloudfx_params;
		$tagcloudfx_params['count']++;

		$plugin_dir = get_option('tagcloudfx_path');
		if ($plugin_dir === false) {
			$plugin_dir = 'flashxml/tag-cloud-fx';
		}
		$plugin_dir = trim($plugin_dir, '/');

		$settings_file_name = !empty($tagcloudfx_attributes[2]) ? $tagcloudfx_attributes[2] : 'settings.xml';
		$settings_file_path = WP_CONTENT_DIR . "/{$plugin_dir}/{$settings_file_name}";

		if (function_exists('simplexml_load_file')) {
			if (file_exists($settings_file_path)) {
				$data = simplexml_load_file($settings_file_path);
				$width = (int)$data->General_Properties->componentWidth->attributes()->value;
				$height = (int)$data->General_Properties->componentHeight->attributes()->value;
			}
		} elseif ((int)$tagcloudfx_attributes[4] > 0 && (int)$tagcloudfx_attributes[6] > 0) {
			$width = (int)$tagcloudfx_attributes[4];
			$height = (int)$tagcloudfx_attributes[6];
		} else {
			return '<!-- invalid Tag Cloud FX width and / or height -->';
		}

		$swf_embed = array(
			'width' => $width,
			'height' => $height,
			'text' => isset($tagcloudfx_attributes[7]) ? trim($tagcloudfx_attributes[7]) : '',
			'component_path' => WP_CONTENT_URL . "/{$plugin_dir}/",
			'swf_name' => 'TagCloudFX.swf',
		);
		$swf_embed['swf_path'] = $swf_embed['component_path'].$swf_embed['swf_name'];

		if (!is_feed()) {
			$embed_code = '<div id="tagcloud-fx'.$tagcloudfx_params['count'].'">'.$swf_embed['text'].'</div>';
			$embed_code .= '<script type="text/javascript">';
			$embed_code .= "swfobject.embedSWF('{$swf_embed['swf_path']}', 'tagcloud-fx{$tagcloudfx_params['count']}', '{$swf_embed['width']}', '{$swf_embed['height']}', '9.0.0.0', '', { folderPath: '{$swf_embed['component_path']}'".($settings_file_name != 'settings.xml' ? ", settingsXML: '{$settings_file_name}'" : '')." }, { scale: 'noscale', salign: 'tl', wmode: 'transparent', allowScriptAccess: 'sameDomain', allowFullScreen: true }, {});";
			$embed_code.= '</script>';
		} else {
			$embed_code = '<object width="'.$swf_embed['width'].'" height="'.$swf_embed['height'].'">';
			$embed_code .= '<param name="movie" value="'.$swf_embed['swf_path'].'"></param>';
			$embed_code .= '<param name="scale" value="noscale"></param>';
			$embed_code .= '<param name="salign" value="tl"></param>';
			$embed_code .= '<param name="wmode" value="transparent"></param>';
			$embed_code .= '<param name="allowScriptAccess" value="sameDomain"></param>';
			$embed_code .= '<param name="allowFullScreen" value="true"></param>';
			$embed_code .= '<param name="sameDomain" value="true"></param>';
			$embed_code .= '<param name="flashvars" value="folderPath='.$swf_embed['component_path'].($settings_file_name != 'settings.xml' ? '&settingsXML='.$settings_file_name : '').'"></param>';
			$embed_code .= '<embed type="application/x-shockwave-flash" width="'.$swf_embed['width'].'" height="'.$swf_embed['height'].'" src="'.$swf_embed['swf_path'].'" scale="noscale" salign="tl" wmode="transparent" allowScriptAccess="sameDomain" allowFullScreen="true" flashvars="folderPath='.$swf_embed['component_path'].($settings_file_name != 'settings.xml' ? '&settingsXML='.$settings_file_name : '').'"';
			$embed_code .= '></embed>';
			$embed_code .= '</object>';
		}

		return $embed_code;
	}

	function tagcloudfx_filter_content($content) {
		return preg_replace_callback('|\[tag-cloud-fx\s*(settings="([^"]+)")?\s*(width="([0-9]+)")?\s*(height="([0-9]+)")?\s*\](.*)\[/tag-cloud-fx\]|i', 'tagcloudfx_get_embed_code', $content);
	}

	function tagcloudfx_echo_embed_code($settings_xml_path = '', $div_text = '', $width = 0, $height = 0) {
		echo tagcloudfx_get_embed_code(array(2 => $settings_xml_path, 7 => $div_text, 4 => $width, 6 => $height));
	}

	function tagcloudfx_load_swfobject_lib() {
		wp_enqueue_script('swfobject');
	}
/* end client side functions */

/* start admin section functions */
	function tagcloudfx_admin_menu() {
		add_options_page('Tag Cloud FX Options', 'Tag Cloud FX', 'manage_options', 'tagcloudfx', 'tagcloudfx_admin_options');
	}

	function tagcloudfx_admin_options() {
		  if (!current_user_can('manage_options'))  {
	    wp_die(__('You do not have sufficient permissions to access this page.'));
	  }

	  $tagcloudfx_default_path = get_option('tagcloudfx_path');
	  if ($tagcloudfx_default_path === false) {
	  	$tagcloudfx_default_path = 'flashxml/tag-cloud-fx';
	  }
?>
<div class="wrap">
	<h2>Tag Cloud FX</h2>
	<form method="post" action="options.php">
		<?php wp_nonce_field('update-options'); ?>

		<table class="form-table">
			<tr valign="top">
				<th scope="row" style="width: 40em;">SWF and assets path is <?php echo WP_CONTENT_DIR; ?>/</th>
				<td><input type="text" style="width: 25em;" name="tagcloudfx_path" value="<?php echo $tagcloudfx_default_path; ?>" /></td>
			</tr>
		</table>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="tagcloudfx_path" />
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
</div>
<?php
	}
/* end admin section functions */

/* start hooks */
	add_filter('the_content', 'tagcloudfx_filter_content');
	add_action('init', 'tagcloudfx_load_swfobject_lib');
	add_action('admin_menu', 'tagcloudfx_admin_menu');
/* end hooks */

?>