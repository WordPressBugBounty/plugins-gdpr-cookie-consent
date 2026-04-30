<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://club.wpeka.com
 *
 * @package    Gdpr_Cookie_Consent
 * @subpackage Gdpr_Cookie_Consent/public
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( 'popup' === $the_options['cookie_bar_as'] ) {
	?>
	<div class="gdprmodal gdprfade" id="gdpr-<?php echo esc_html( $the_options['cookie_bar_as'] ); ?>" role="dialog" data-keyboard="false" data-backdrop="<?php echo esc_html( $the_options['backdrop'] ); ?>">
        <div class="gdprmodal-dialog gdprmodal-dialog-centered">
            <!-- Modal content-->
            <div class="gdprmodal-content">
            </div>
        </div>
    </div>
<?php } 
?>








<!-- cookie notice-->
<?php 
	if(!function_exists('hex_to_rgba')){
		function hex_to_rgba($hex, $opacity = 1) {
			$hex = str_replace('#', '', $hex);
			if (strlen($hex) === 3) {
				$r = hexdec(str_repeat(substr($hex, 0, 1), 2));
				$g = hexdec(str_repeat(substr($hex, 1, 1), 2));
				$b = hexdec(str_repeat(substr($hex, 2, 1), 2));
			} elseif (strlen($hex) === 6) {
				$r = hexdec(substr($hex, 0, 2));
				$g = hexdec(substr($hex, 2, 2));
				$b = hexdec(substr($hex, 4, 2));
			} else {
				return 'rgba(0,0,0,1)'; // fallback
			}

			return "rgba($r, $g, $b, $opacity)";
		}
	}
	
//styling for banner

	$ab_testing_enabled = (!isset($ab_options['ab_testing_enabled']) || ($ab_options['ab_testing_enabled'] === "false" || $ab_options['ab_testing_enabled'] === false)) ? "false" : "true";

	$notice_container_styles = "position: fixed; display: none; flex-direction: column; gap: 15px; border-radius: {$the_options[($ab_testing_enabled === "true" ? 'cookie_bar_border_radius' . $chosenBanner : ($the_options['cookie_usage_for'] === 'both' ? 'multiple_legislation_cookie_bar_border_radius1' : 'background_border_radius'))]}px;";

	if ( $the_options['cookie_bar_as'] === 'banner' ) { $notice_container_styles .= "left: 0px; {$the_options['notify_position_vertical']}: 0px;"; $notice_container_styles .= " box-shadow: 2px 5px 11px 4px #dddddd;"; } 
	elseif ( $the_options['cookie_bar_as'] === 'popup' ) { 
		$notice_container_styles .= "top:50%; left: 50%; transform: translateX(-50%) translateY(-50%);";
	} 
	else { switch ( $the_options['notify_position_horizontal'] ) { 
			case 'left': $notice_container_styles .= "left: 15px; bottom: 15px;"; break;
			case 'right': $notice_container_styles .= "right: 15px; bottom: 15px;"; break;
			case 'top_left': $notice_container_styles .= "left: 15px; top: 15px;"; break;
			case 'top_right': $notice_container_styles .= "right: 15px; top: 15px;"; break;
		}
		$notice_container_styles .= " box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;";
	}
	$notice_container_styles .= "background: " . hex_to_rgba($ab_testing_enabled === "true" ? $the_options['cookie_bar_color' . $chosenBanner] : ($the_options['cookie_usage_for'] === 'both' ? $the_options['multiple_legislation_cookie_bar_color1'] : $the_options['background']), $ab_testing_enabled === 'true' ? $the_options['cookie_bar_opacity' . $chosenBanner] : ($the_options['cookie_usage_for'] === 'both' ? $the_options['multiple_legislation_cookie_bar_opacity1'] : $the_options['opacity'])) . ";"; 
	$notice_container_styles .= "color: " . ($ab_testing_enabled === "true" ? $the_options['cookie_text_color' . $chosenBanner] : ($the_options['cookie_usage_for'] === 'both' ? $the_options['multiple_legislation_cookie_text_color1'] : $the_options["text"])) . ";"; 
	$notice_container_styles .= "border-style: " . ($ab_testing_enabled === "true" ? $the_options['border_style' . $chosenBanner] : ($the_options['cookie_usage_for'] === 'both' ? $the_options['multiple_legislation_border_style1'] : $the_options["background_border_style"])) . ";"; 
	$notice_container_styles .= "border-color: " . ($ab_testing_enabled === "true" ? $the_options['cookie_border_color' . $chosenBanner] : ($the_options['cookie_usage_for'] === 'both' ? $the_options['multiple_legislation_cookie_border_color1'] : $the_options["background_border_color"])) . ";"; 
	$notice_container_styles .= "border-width: " . ($ab_testing_enabled === "true" ? $the_options['cookie_bar_border_width' . $chosenBanner] : ($the_options['cookie_usage_for'] === 'both' ? $the_options['multiple_legislation_cookie_bar_border_width1'] : $the_options["background_border_width"])) . "px;"; 
	$notice_container_styles .= "font-family: " . ($ab_testing_enabled === "true" ? $the_options['cookie_font' . $chosenBanner] : ($the_options['cookie_usage_for'] === 'both' ? $the_options['multiple_legislation_cookie_font1'] : $the_options["font_family"])) . ";"; 

	$suffix =  ($ab_testing_enabled === "true" ? $chosenBanner : ($the_options['cookie_usage_for'] === 'both' ? '1' : ''));
	$opt_out_style_attr = "color: {$the_options['button_donotsell_link_color' . $suffix]}";

	$logo_style_attr = '';
	foreach ($template_object['logo'] as $key => $value) {
		if($key != 'src') $logo_style_attr .= esc_attr($key) . ':' . esc_attr($value) . ';';
	} 

	$heading_style_attr = "";
	foreach ($template_object['heading'] as $key => $value) {
		$heading_style_attr .= esc_attr($key) . ':' . esc_attr($value) . ';';
	}  
	$readmore_style_attr = "";
	$readmore_style_attr .= " color: {$the_options['button_readmore_link_color' . $suffix]};";
	if (
		$template_object['name'] === 'blue_full' ||
		$template_object['name'] === 'blue_center' ||
		$template_object['name'] === 'blue_center_column' ||
		$template_object['name'] === 'blue_split' ||
		$template_object['name'] === 'gray' ||
		$template_object['name'] === 'bold' ||
		$template_object['name'] === 'dark'
	) {
		$readmore_style_attr .= "text-decoration: underline;";
	} else {
		$readmore_style_attr .= "text-decoration: none;";
	}

	if ( ! empty( $the_options['button_readmore_as_button' . $suffix] ) && filter_var($the_options['button_readmore_as_button' . $suffix], FILTER_VALIDATE_BOOLEAN)) {
		$padding_key = 'button_padding';
		$padding_value = $template_object['static-settings'][$padding_key] ?? '';
		$readmore_style_attr .= "display: block; width:fit-content; margin-top: 5px;";
		$readmore_style_attr .= "border-style: {$the_options['button_readmore_button_border_style' . $suffix]};";
		$readmore_style_attr .= "border-color: {$the_options['button_readmore_button_border_color' . $suffix]};";
		$readmore_style_attr .= "border-width: {$the_options['button_readmore_button_border_width' . $suffix]}px;";
		$readmore_style_attr .= "border-radius: {$the_options['button_readmore_button_border_radius' . $suffix]}px;";
		$readmore_style_attr .= "padding: {$padding_value};";
		$rgba_color = hex_to_rgba($the_options['button_readmore_button_color' . $suffix], $the_options['button_readmore_button_opacity' . $suffix]);
		$readmore_style_attr .= "background: {$rgba_color};";
	}
	else{
		$readmore_style_attr .= "display: inline-block;";
	}
	

	$accept_style_attr = "";
	$accept_style_attr .=  " color: {$the_options["button_accept_link_color" . $suffix]};";
	if ( ! empty( $the_options['button_accept_as_button' . $suffix] ) && filter_var($the_options['button_accept_as_button' . $suffix], FILTER_VALIDATE_BOOLEAN)) {
		$padding_key = 'button_padding';
		$padding_value = $template_object['static-settings'][$padding_key] ?? '';
		$accept_style_attr .= "border-style: {$the_options['button_accept_button_border_style' . $suffix]};";
		$accept_style_attr .= "border-color: {$the_options['button_accept_button_border_color' . $suffix]};";
		$accept_style_attr .= "border-width: {$the_options['button_accept_button_border_width' . $suffix]}px;";
		$accept_style_attr .= "border-radius: {$the_options['button_accept_button_border_radius' . $suffix]}px;";
		$accept_style_attr .= "padding: {$padding_value};";
		$rgba_color = hex_to_rgba($the_options['button_accept_button_color' . $suffix], $the_options['button_accept_button_opacity' . $suffix]);
		$accept_style_attr .= "background: {$rgba_color};";
	}
	$accept_style_attr .= "min-width: " . ($template_object['accept_button']['min-width'] ?? '') . ";";
	$accept_style_attr .= "display: " . ($template_object['accept_button']['display'] ?? '') . ";";
	$accept_style_attr .= "justify-content: " . ($template_object['accept_button']['justify-content'] ?? '') . ";";
	$accept_style_attr .= "align-items: " . ($template_object['accept_button']['align-items'] ?? '') . ";";
	$accept_style_attr .= "text-align: " . ($template_object['accept_button']['text-align'] ?? '') . ";";

	$accept_style_attr .= isset($template_object['accept_button']['width']) ? "width : {$template_object['accept_button']['width']};" : '';


	$accept_all_style_attr = "";
	$accept_all_style_attr .=  " color: {$the_options["button_accept_all_link_color" . $suffix]};";

	if ( ! empty( $the_options['button_accept_all_as_button' . $suffix] ) && filter_var($the_options['button_accept_all_as_button' . $suffix], FILTER_VALIDATE_BOOLEAN)) {
		$padding_key = 'button_padding';
		$padding_value = $template_object['static-settings'][$padding_key] ?? '';
		$accept_all_style_attr .= "border-style: {$the_options['button_accept_all_btn_border_style' . $suffix]};";
		$accept_all_style_attr .= "border-color: {$the_options['button_accept_all_btn_border_color' . $suffix]};";
		$accept_all_style_attr .= "border-width: {$the_options['button_accept_all_btn_border_width' . $suffix]}px;";
		$accept_all_style_attr .= "border-radius: {$the_options['button_accept_all_btn_border_radius' . $suffix]}px;";
		$accept_all_style_attr .= "padding: {$padding_value};";
		$rgba_color = hex_to_rgba($the_options['button_accept_all_button_color' . $suffix], $the_options['button_accept_all_btn_opacity' . $suffix]);
		$accept_all_style_attr .= "background: {$rgba_color};";
	}
	$accept_all_style_attr .= "min-width: " . ($template_object['accept_all_button']['min-width'] ?? '') . ";";
	$accept_all_style_attr .= "display: " . ($template_object['accept_all_button']['display'] ?? '') . ";";
	$accept_all_style_attr .= "justify-content: " . ($template_object['accept_all_button']['justify-content'] ?? '') . ";";
	$accept_all_style_attr .= "align-items: " . ($template_object['accept_all_button']['align-items'] ?? '') . ";";
	$accept_all_style_attr .= "text-align: " . ($template_object['accept_all_button']['text-align'] ?? '') . ";";

    $accept_all_style_attr .= isset($template_object['accept_all_button']['width']) ? "width : {$template_object['accept_all_button']['width']};" : '';


	
	$settings_style_attr ="";
	$settings_style_attr .=  " color: {$the_options["button_settings_link_color" . $suffix]};";
	if ( ! empty( $the_options['button_settings_as_button' . $suffix] ) && filter_var($the_options['button_settings_as_button' . $suffix], FILTER_VALIDATE_BOOLEAN)) {
		$padding_key = 'button_padding';
		$padding_value = $template_object['static-settings'][$padding_key];
		$settings_style_attr .= "border-style: {$the_options['button_settings_button_border_style' . $suffix]};";
		$settings_style_attr .= "border-color: {$the_options['button_settings_button_border_color' . $suffix]};";
		$settings_style_attr .= "border-width: {$the_options['button_settings_button_border_width' . $suffix]}px;";
		$settings_style_attr .= "border-radius: {$the_options['button_settings_button_border_radius' . $suffix]}px;";
		$settings_style_attr .= "padding: {$padding_value};";
		$rgba_color = hex_to_rgba($the_options['button_settings_button_color' . $suffix], $the_options['button_settings_button_opacity' . $suffix]);
		$settings_style_attr .= "background: {$rgba_color};";
	}
	$settings_style_attr .= "min-width: " . ($template_object['settings_button']['min-width'] ?? '') . ";";
	$settings_style_attr .= "display: " . ($template_object['settings_button']['display'] ?? '') . ";";
	$settings_style_attr .= "justify-content: " . ($template_object['settings_button']['justify-content'] ?? '') . ";";
	$settings_style_attr .= "align-items: " . ($template_object['settings_button']['align-items'] ?? '') . ";";
	$settings_style_attr .= "text-align: " . ($template_object['settings_button']['text-align'] ?? '') . ";";

	$settings_style_attr .= isset($template_object['settings_button']['width']) ? "width : {$template_object['settings_button']['width']};" : '';


	$decline_style_attr ="";
	$decline_style_attr .=  " color: {$the_options["button_decline_link_color" . $suffix]};";
	if ( ! empty( $the_options['button_decline_as_button' . $suffix] ) && filter_var($the_options['button_decline_as_button' . $suffix], FILTER_VALIDATE_BOOLEAN)) {
		$padding_key = 'button_padding';
		$padding_value = $template_object['static-settings'][$padding_key];
		$decline_style_attr .= "border-style: {$the_options['button_decline_button_border_style' . $suffix]};";
		$decline_style_attr .= "border-color: {$the_options['button_decline_button_border_color' . $suffix]};";
		$decline_style_attr .= "border-width: {$the_options['button_decline_button_border_width' . $suffix]}px;";
		$decline_style_attr .= "border-radius: {$the_options['button_decline_button_border_radius' . $suffix]}px;";
		$decline_style_attr .= "padding: {$padding_value};";
		$rgba_color = hex_to_rgba($the_options['button_decline_button_color' . $suffix], $the_options['button_decline_button_opacity' . $suffix]);
		$decline_style_attr .= "background: {$rgba_color};";
	}
	$decline_style_attr .= "min-width: " . ($template_object['decline_button']['min-width'] ?? '') . ";";
	$decline_style_attr .= "display: " . ($template_object['decline_button']['display'] ?? '') . ";";
	$decline_style_attr .= "justify-content: " . ($template_object['decline_button']['justify-content'] ?? '') . ";";
	$decline_style_attr .= "align-items: " . ($template_object['decline_button']['align-items'] ?? '') . ";";
	$decline_style_attr .= "text-align: " . ($template_object['decline_button']['text-align'] ?? '') . ";";

	$decline_style_attr .= isset($template_object['decline_button']['width']) ? "width: {$template_object['decline_button']['width']};" : '';

	$badging_color = $the_options['button_accept_all_button_color' . $suffix] === ($ab_testing_enabled === "true" ? $the_options['cookie_bar_color' . $chosenBanner] : ($the_options['cookie_usage_for'] === 'both' ? $the_options['multiple_legislation_cookie_bar_color1'] : $the_options['background'])) ? $template_object['accept_all_button']['background-color'] ?? '' : $the_options['button_accept_all_button_color' . $suffix];
	$decoration_styles_attr = '';
	if(isset($template_object['decoration'])) foreach ($template_object['decoration'] as $key => $value) {
		$decoration_styles_attr .= esc_attr($key) . ':' . esc_attr($value) . ';';
	} 
?>

<div id="<?php echo esc_html( $the_options['container_id'] ); ?>" class="<?php echo esc_html( $the_options['container_class'] ); ?> <?php echo esc_html( $the_options['theme_class'] ); ?>"  style="<?php echo esc_attr($notice_container_styles); ?>">	
	<span id="cookie-banner-cancle-img" style="cursor: pointer; display: inline-flex; align-items: center; justify-content: center; position: absolute; top:20px; right: <?php echo 20 + ((int)$the_options[($ab_testing_enabled === "true" ? 'cookie_bar_border_radius' . $chosenBanner : ($the_options['cookie_usage_for'] === 'both' ? 'multiple_legislation_cookie_bar_border_radius1' : 'background_border_radius'))]) / 2;?>px; height: 20px; width: 20px; border-radius: 50%; color: <?php echo $the_options['cookie_usage_for'] == 'ccpa' ?  esc_html($the_options['button_donotsell_link_color' . $suffix]) : ((bool)$the_options['button_accept_all_as_button' . $suffix] === 'true' || (bool)$the_options['button_accept_all_as_button' . $suffix] === true || (bool)$the_options['button_accept_all_as_button' . $suffix] === 1 ? esc_html($the_options['button_accept_all_button_color' . $suffix]) : esc_html($the_options["button_accept_all_link_color" . $suffix]));?>;">
		<svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289Z" fill="currentColor"/>
		</svg>
	</span>
	<?php
	if($ab_options['ab_testing_enabled'] === "false" || $ab_options['ab_testing_enabled'] === false){
		if($the_options['cookie_usage_for'] == 'both'){
			$get_banner_img = get_option( GDPR_COOKIE_CONSENT_SETTINGS_LOGO_IMAGE_FIELDML1 );
			if (!empty($get_banner_img)) {
				?>
					<img style = "<?php echo esc_attr($logo_style_attr); ?>" class="gdpr_logo_image" alt="logo-image" src="<?php echo esc_url_raw( $get_banner_img ); ?>" >
					<?php
			}
			else{
				if ( isset( $template_object['logo']['src'] ) && is_string( $template_object['logo']['src'] ) && $template_object['logo']['src'] !== '' ) { ?><img alt="Logo image" style="<?php echo esc_attr( $logo_style_attr ); ?>" class="gdpr_logo_image" src="<?php echo esc_url( GDPR_COOKIE_CONSENT_PLUGIN_URL . 'includes/templates/logo_images/' . sanitize_file_name( $template_object['logo']['src'] ) ); ?>"><?php }
			}
		}else{
			$get_banner_img = get_option( GDPR_COOKIE_CONSENT_SETTINGS_LOGO_IMAGE_FIELD );
			if (!empty($get_banner_img)) {
				?>
					<img style = "<?php echo esc_attr($logo_style_attr); ?>" class="gdpr_logo_image" alt="logo-image" src="<?php echo esc_url_raw( $get_banner_img ); ?>" >
					<?php
			}
			else{
				if ( isset( $template_object['logo']['src'] ) && is_string( $template_object['logo']['src'] ) && $template_object['logo']['src'] !== '' ) { ?><img alt="Logo image" style="<?php echo esc_attr( $logo_style_attr ); ?>" class="gdpr_logo_image" src="<?php echo esc_url( GDPR_COOKIE_CONSENT_PLUGIN_URL . 'includes/templates/logo_images/' . sanitize_file_name( $template_object['logo']['src'] ) ); ?>"><?php }
			}
		}
	}
	else{
		if($ab_options['ab_testing_enabled'] === "true" || $ab_options['ab_testing_enabled'] === true){
			if($chosenBanner == 1) {
				$get_banner_img1 = get_option( GDPR_COOKIE_CONSENT_SETTINGS_LOGO_IMAGE_FIELD1 );
				if (!empty($get_banner_img1)) {
					?>
						<img style = "<?php echo esc_attr($logo_style_attr); ?>" class="gdpr_logo_image" alt="logo-image" src="<?php echo esc_url_raw( $get_banner_img1 ); ?>" >
						<?php
				}
				else{
					if ( isset( $template_object['logo']['src'] ) && is_string( $template_object['logo']['src'] ) && $template_object['logo']['src'] !== '' ) { ?><img alt="Logo image" style="<?php echo esc_attr( $logo_style_attr ); ?>" class="gdpr_logo_image" src="<?php echo esc_url( GDPR_COOKIE_CONSENT_PLUGIN_URL . 'includes/templates/logo_images/' . sanitize_file_name( $template_object['logo']['src'] ) ); ?>"><?php }
				}
			}elseif($chosenBanner == 2){
					$get_banner_img2 = get_option( GDPR_COOKIE_CONSENT_SETTINGS_LOGO_IMAGE_FIELD2 );
					if (!empty($get_banner_img2)) {
					?>
						<img style = "<?php echo esc_attr($logo_style_attr); ?>" class="gdpr_logo_image" alt="logo-image" src="<?php echo esc_url_raw( $get_banner_img2 ); ?>" >
						<?php
				}
				else{
					if ( isset( $template_object['logo']['src'] ) && is_string( $template_object['logo']['src'] ) && $template_object['logo']['src'] !== '' ) { ?><img alt="Logo image" style="<?php echo esc_attr( $logo_style_attr ); ?>" class="gdpr_logo_image" src="<?php echo esc_url( GDPR_COOKIE_CONSENT_PLUGIN_URL . 'includes/templates/logo_images/' . sanitize_file_name( $template_object['logo']['src'] ) ); ?>"><?php }
				}
			}
		}
	} ?>

	<?php if($decoration_styles_attr !== ''){ ?>
		<div  style = "<?php echo esc_attr($decoration_styles_attr); ?>" class="gdpr_banner_decoration"></div>
	<?php } ?>
	

	<div class="<?php echo esc_attr($template_object['static-settings']['layout'] ?? '');?>">
		<div class="gdpr-notice-content-body">
			<div style="display: flex; flex-direction: column; gap: 10px;">
				<?php
					if ( ($the_options['cookie_usage_for'] === 'gdpr' || $the_options['cookie_usage_for'] === 'both' ) && strlen($the_options['bar_heading_text']) > 0) : ?>
						<h3 class = "<?php if($the_options['cookie_usage_for'] === 'both') echo 'gdpr_heading';?>" style = "<?php echo esc_attr($heading_style_attr); ?>" ><?php echo esc_html($the_options['bar_heading_text'] ?? ''); ?></h3>
					<?php elseif ( ($the_options['cookie_usage_for'] === 'gdpr' || $the_options['cookie_usage_for'] === 'both' ) && strlen($the_options['bar_heading_text']) === 0 && $template_object['name'] === 'blue_split') : ?> 
						<h3 style = "<?php echo esc_attr($heading_style_attr); ?>" ><?php echo esc_html__("We value your privacy", 'gdpr-cookie-consent'); ?></h3>
					<?php elseif (( $the_options['cookie_usage_for'] === 'lgpd' ) && strlen($the_options['bar_heading_lgpd_text']) > 0) : ?>
						<h3 style = "<?php echo esc_attr($heading_style_attr); ?>" ><?php echo esc_html($the_options['bar_heading_lgpd_text'] ?? ''); ?></h3>
					<?php elseif ( ($the_options['cookie_usage_for'] === 'lgpd') && strlen($the_options['bar_heading_lgpd_text']) === 0 && $template_object['name'] === 'blue_split') : ?> 
						<h3 style = "<?php echo esc_attr($heading_style_attr); ?>" ><?php echo esc_html__("We value your privacy", 'gdpr-cookie-consent'); ?></h3>
					<?php elseif( $template_object['name'] === 'blue_split' ) : ?> 
						<h3 style = "<?php echo esc_attr($heading_style_attr); ?>" ><?php echo esc_html__("We value your privacy", 'gdpr-cookie-consent'); ?></h3>
					<?php endif; ?>
					
				<p  class = "<?php if($the_options['cookie_usage_for'] === 'both') echo 'gdpr';?>">
					<?php if ( $the_options['cookie_usage_for'] === 'gdpr'  || $the_options['cookie_usage_for'] === 'both' ) : ?>
						<span>
							<?php
							echo wp_kses(
								$the_options['is_iabtcf_on'] 
									? ($cookie_data['dash_notify_message_iabtcf'] ?? '')
									: ($cookie_data['dash_notify_message'] ?? ''),
								[
									'a' => [
										'href'   => [],
										'title' => [],
										'target'=> [],
										'rel'   => [],
										'data-toggle' => [],
										'data-target' => [],
										'id' => [],
									],
									'br'     => [],
									'em'     => [],
									'strong' => [],
									'span'   => [],
									'p'      => [],
									'i'      => [],
									'img'    => [
										'src'   => [],
										'alt'   => [],
										'title'=> [],
									],
									'b'      => [],
									'div'    => [],
									'label'  => [],
								]
							);
							?>
						</span>
						<?php elseif ( $the_options['cookie_usage_for'] === 'lgpd' ) : ?>
						<span>
							<?php
							echo wp_kses(
								$cookie_data['dash_notify_message_lgpd'] ?? '',
								[
									'a'      => [],
									'br'     => [],
									'em'     => [],
									'strong' => [],
									'span'   => [],
									'p'      => [],
									'i'      => [],
									'img'    => [
										'src'   => [],
										'alt'   => [],
										'title'=> [],
									],
									'b'      => [],
									'div'    => [],
									'label'  => [],
								]
							);
							?>
						</span>
						<?php elseif ( $the_options['cookie_usage_for'] === 'ccpa' ) : ?>
						<span>
							<?php
							echo wp_kses(
								$cookie_data['dash_notify_message_ccpa'] ?? '',
								[
									'a'      => [],
									'br'     => [],
									'em'     => [],
									'strong' => [],
									'span'   => [],
									'p'      => [],
									'i'      => [],
									'img'    => [
										'src'   => [],
										'alt'   => [],
										'title'=> [],
									],
									'b'      => [],
									'div'    => [],
									'label'  => [],
								]
							);
							?>
						</span>
						<?php elseif ( $the_options['cookie_usage_for'] === 'eprivacy' ) : ?>
						<span>
							<?php
							echo wp_kses(
								$cookie_data['dash_notify_message_eprivacy'] ?? '',
								[
									'a'      => [],
									'br'     => [],
									'em'     => [],
									'strong' => [],
									'span'   => [],
									'p'      => [],
									'i'      => [],
									'img'    => [
										'src'   => [],
										'alt'   => [],
										'title'=> [],
									],
									'b'      => [],
									'div'    => [],
									'label'  => [],
								]
							);
							?>
						</span>
					<?php endif; ?>
					<?php if ( $the_options['cookie_usage_for'] === 'ccpa') : ?>
						<a style="<?php echo esc_attr($opt_out_style_attr); ?>" data-toggle="gdprmodal" href="#" class="<?php echo esc_html( $the_options['button_donotsell_classes'] ); ?>" data-gdpr_action="donotsell" id="cookie_donotsell_link"
						>	
							<?php echo esc_html($cookie_data['dash_button_donotsell_text'], 'gdpr-cookie-consent' ); ?>
						</a>
							
					<?php elseif( $the_options['cookie_usage_for'] !== 'ccpa' &&  ! empty( $the_options['button_readmore_is_on'] ) ) : ?>
						<a style="<?php echo esc_attr($readmore_style_attr); ?>" id="cookie_action_link" href="<?php echo esc_html( $the_options['button_readmore_url_link'] ); ?>" 
						<?php if ( ! empty( $the_options['button_readmore_new_win'] ) ) { ?>
							target="_blank"
						<?php } ?>
						>
							<?php echo esc_html( $cookie_data['dash_button_readmore_text'], 'gdpr-cookie-consent' ); ?>
						</a>
					<?php endif; ?>
				</p>
			</div>
		
		<?php if($the_options['cookie_usage_for'] === 'both') : ?>
			<p class = "ccpa">
				<span>
					<?php
					echo wp_kses(
						$cookie_data['dash_notify_message_ccpa'] ?? '',
						[
							'a'      => [],
							'br'     => [],
							'em'     => [],
							'strong' => [],
							'span'   => [],
							'p'      => [],
							'i'      => [],
							'img'    => [
								'src'   => [],
								'alt'   => [],
								'title'=> [],
							],
							'b'      => [],
							'div'    => [],
							'label'  => [],
						]
					);
					?>
				</span>
				<a style="<?php echo esc_attr($opt_out_style_attr); ?>" data-toggle="gdprmodal" href="#" class="<?php echo esc_html( $the_options['button_donotsell_classes'] ); ?>" data-gdpr_action="donotsell" id="cookie_donotsell_link"
				>	
					<?php echo isset($the_options["is_dynamic_lang_on"]) && ($the_options["is_dynamic_lang_on"] === "true" || $the_options["is_dynamic_lang_on"] === true || $the_options["is_dynamic_lang_on"] === "1")
						? esc_html( $cookie_data['dash_button_donotsell_text'] )
						: esc_html( $the_options['button_donotsell_text1'] ?? '', 'gdpr-cookie-consent' ); 
					?>
				</a>
			</p>
		<?php endif; ?>
		</div>
		<?php if ( $the_options['cookie_usage_for'] !== 'ccpa' ) : ?>
			<div class="gdpr group-description-buttons cookie_notice_buttons <?php echo esc_attr($template_object['static-settings']['layout'] ?? '') . '-buttons';?>">
				<div class="left_buttons"><?php 
					if ( filter_var( $the_options['button_decline_is_on' . $suffix] ?? false, FILTER_VALIDATE_BOOLEAN )) : ?>
						<a id="cookie_action_reject" class="<?php echo esc_html( $the_options['button_decline_classes'] ); ?>" tabindex="0" aria-label="Reject"
							<?php
							if ( 'CONSTANT_OPEN_URL' === $the_options['button_decline_action' . $suffix] ) {
							?>
								href="<?php echo esc_html( $the_options['button_decline_url' . $suffix] ); ?>"
								<?php
								if ( ! empty( $the_options['button_decline_new_win' . $suffix] ) ) {
								?>
									target="_blank"
								<?php
								} else {
								?>
									href="#"
								<?php
								}
							}
							?>
							data-gdpr_action="reject"  style="<?php echo esc_attr($decline_style_attr); ?>" >
								<?php echo isset($the_options["is_dynamic_lang_on"]) && ($the_options["is_dynamic_lang_on"] === "true" || $the_options["is_dynamic_lang_on"] === true || $the_options["is_dynamic_lang_on"] === "1")
										? esc_html( $cookie_data['dash_button_decline_text'] )
										: esc_html( $the_options['button_decline_text'. $suffix] ?? '', 'gdpr-cookie-consent' ); 
								?>
						</a>
					<?php endif;
					if ( $the_options['cookie_usage_for'] !== 'eprivacy' && ! empty( $the_options['button_settings_is_on' . $suffix] ) && filter_var( $the_options['button_settings_is_on' . $suffix], FILTER_VALIDATE_BOOLEAN )) : ?>
						<a id="cookie_action_settings" class="<?php echo esc_html( $the_options['button_settings_classes'] ); ?>" tabindex="0" aria-label="Cookie Settings" href="#"
							data-gdpr_action="settings" data-toggle="gdprmodal" data-target="#gdpr-gdprmodal" style="<?php echo esc_attr($settings_style_attr); ?>">
							<?php echo isset($the_options["is_dynamic_lang_on"]) && ($the_options["is_dynamic_lang_on"] === "true" || $the_options["is_dynamic_lang_on"] === true || $the_options["is_dynamic_lang_on"] === "1")
										? esc_html( $cookie_data['dash_button_settings_text'] )
										: esc_html( $the_options['button_settings_text'. $suffix] ?? '', 'gdpr-cookie-consent' ); 
							?>
						</a>
					<?php endif;
				?></div>
				<div class="right_buttons"><?php  
					if ( filter_var( $the_options['button_accept_is_on' . $suffix] ?? false, FILTER_VALIDATE_BOOLEAN )) : ?>
						<a id="cookie_action_accept" class="<?php echo esc_html( $the_options['button_accept_classes'] ); ?>" tabindex="0" aria-label="Accept"
							<?php
							if ( 'CONSTANT_OPEN_URL' === $the_options['button_accept_action' . $suffix] ) {
							?>
								href="<?php echo esc_html( $the_options['button_accept_url' . $suffix] ); ?>"
								<?php
								if ( ! empty( $the_options['button_accept_new_win' . $suffix] ) ) {
								?>
									target="_blank"
								<?php
								}
							} else {
							?>
								href="#"
							<?php
							}
							?>
							data-gdpr_action="accept" style="<?php echo esc_attr($accept_style_attr); ?>" >
								<?php echo isset($the_options["is_dynamic_lang_on"]) && ($the_options["is_dynamic_lang_on"] === "true" || $the_options["is_dynamic_lang_on"] === true || $the_options["is_dynamic_lang_on"] === "1")
										? esc_html( $cookie_data['dash_button_accept_text'] )
										: esc_html( $the_options['button_accept_text'. $suffix] ?? '', 'gdpr-cookie-consent' ); 
								?>
						</a>
					<?php endif;
					if ( filter_var( $the_options['button_accept_all_is_on' . $suffix] ?? false, FILTER_VALIDATE_BOOLEAN )) : ?>
						<a id="cookie_action_accept_all" class="<?php echo esc_html( $the_options['button_accept_all_classes'] ); ?>" tabindex="0" aria-label="Accept All"
							<?php
							if ( 'CONSTANT_OPEN_URL' === $the_options['button_accept_all_action' . $suffix] ) {
							?>
								href="<?php echo esc_html( $the_options['button_accept_all_url' . $suffix] ); ?>"
								<?php
								if ( ! empty( $the_options['button_accept_all_new_win' . $suffix] ) ) {
								?>
									target="_blank"
								<?php
								}
							} else {
							?>
								href="#"
							<?php
							}
							?>
							data-gdpr_action="accept_all" style="<?php echo esc_attr($accept_all_style_attr); ?>" >
								<?php echo ( isset( $the_options['is_dynamic_lang_on'] ) && ($the_options["is_dynamic_lang_on"] === "true" || $the_options["is_dynamic_lang_on"] === true || $the_options["is_dynamic_lang_on"] === "1") )
										? esc_html( $cookie_data['dash_button_accept_all_text'] )
										: esc_html( $the_options['button_accept_all_text' . $suffix] ?? '' );
								?>
						</a>	
					<?php endif;
				?></div>
			</div>
		<?php endif; ?>
		
	</div>
	<?php
    if ( ! empty( $cookie_data['show_credits'] ) ) {
    ?>
    	<div class="powered-by-credits"  style="--popup_accent_color: <?php echo esc_html( '#' . ltrim($badging_color, '#') ); ?>; text-align:center; font-size: 10px; margin-bottom:-10px;"><?php echo wp_kses_post( $cookie_data['credits'] ); ?></div>
    <?php
    }
    ?>
</div>












<?php
if ( ! empty( $the_options['lgpd_notify'] )) {
	if ( ! empty( $the_options['cookie_data'] ) ) {
		?>
			<div class="gdpr_messagebar_detail layout-classic <?php echo esc_html( $the_options['template_parts'] ); ?> <?php echo esc_html( $the_options['theme_class'] ); ?>">
			<?php include plugin_dir_path( __FILE__ ) . 'modals/cookie_settings.php'; ?>
		</div>
		<?php
	}
	if ( ! empty( $the_options['show_again' . $suffix] ) ) {
		?>
		<?php if ( $the_options['show_again_as' . $suffix] === "text" ) { ?>
			<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>" style="position: fixed; display:none; bottom: 10px; color: <?php echo esc_html($the_options['button_revoke_consent_text_color' . $suffix]); ?>; background-color: <?php echo esc_html($the_options['button_revoke_consent_background_color' . $suffix]); ?>; <?php if($the_options['show_again_position' . $suffix] === 'right') echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; else echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> border-radius: 5px; box-shadow: 0px 6px 11px gray;">
				<span><?php echo esc_html__( $cookie_data['dash_show_again_text'], 'gdpr-cookie-consent' ); //phpcs:ignore ?></span>
			</div>
			<?php } elseif ( $the_options['show_again_as' . $suffix] === "icon" ) { ?>			
				<?php if ( $the_options['show_again_icon' . $suffix] === "cookie" ) { ?>
					<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>" 
						style="
							position: fixed; 
							display:none; 
							bottom: 10px; 
							color: <?php echo esc_html($the_options['button_revoke_consent_text_color' . $suffix]); ?>; 
							background-color: <?php echo esc_html($the_options['button_revoke_consent_background_color' . $suffix]); ?>; 
							<?php if($the_options['show_again_position' . $suffix] === 'right') 
								echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; 
							else 
								echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> 
							border-radius: 50%; 
							height: 50px;
							width: 50px;
							padding: 4px !important;
							box-shadow: 0px 6px 11px gray;"
					>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
							<path fill="currentColor" stroke="currentColor" d="M321.5 91.6C320.7 86.2 316.6 81.8 311.2 81C289.1 77.9 266.6 81.9 246.8 92.4L172.8 131.9C153.1 142.4 137.2 158.9 127.4 179L90.7 254.6C80.9 274.7 77.7 297.5 81.6 319.5L96.1 402.3C100 424.4 110.7 444.6 126.8 460.2L187.1 518.6C203.2 534.2 223.7 544.2 245.8 547.3L328.8 559C350.9 562.1 373.4 558.1 393.2 547.6L467.2 508.1C486.9 497.6 502.8 481.1 512.6 460.9L549.3 385.4C559.1 365.3 562.3 342.5 558.4 320.5C557.5 315.2 553.1 311.2 547.8 310.4C496.3 302.2 455 263.3 443.3 213C441.5 205.4 435.3 199.6 427.6 198.4C373 189.7 329.9 146.4 321.4 91.6zM272 208C289.7 208 304 222.3 304 240C304 257.7 289.7 272 272 272C254.3 272 240 257.7 240 240C240 222.3 254.3 208 272 208zM208 400C208 382.3 222.3 368 240 368C257.7 368 272 382.3 272 400C272 417.7 257.7 432 240 432C222.3 432 208 417.7 208 400zM432 336C449.7 336 464 350.3 464 368C464 385.7 449.7 400 432 400C414.3 400 400 385.7 400 368C400 350.3 414.3 336 432 336z"/>
						</svg>
					</div>
				<?php } elseif ( $the_options['show_again_icon' . $suffix] === "shield" ) { ?>
					<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>" 
						style="
							position: fixed; 
							display:none; 
							bottom: 10px; 
							color: <?php echo esc_html($the_options['button_revoke_consent_text_color' . $suffix]); ?>; 
							background-color: <?php echo esc_html($the_options['button_revoke_consent_background_color' . $suffix]); ?>; 
							<?php if($the_options['show_again_position' . $suffix] === 'right') 
								echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; 
							else 
								echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> 
							border-radius: 50%; 
							height: 50px;
							width: 50px;
							padding: 4px !important;
							box-shadow: 0px 6px 11px gray;"
					>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
							<path fill="currentColor" stroke="currentColor" d="M320 64C324.6 64 329.2 65 333.4 66.9L521.8 146.8C543.8 156.1 560.2 177.8 560.1 204C559.6 303.2 518.8 484.7 346.5 567.2C329.8 575.2 310.4 575.2 293.7 567.2C121.3 484.7 80.6 303.2 80.1 204C80 177.8 96.4 156.1 118.4 146.8L306.7 66.9C310.9 65 315.4 64 320 64z"/>
						</svg>
					</div>
				<?php } elseif ( $the_options['show_again_icon' . $suffix] === "gear" ) { ?>
					<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>" 
						style="
							position: fixed; 
							display:none; 
							bottom: 10px; 
							color: <?php echo esc_html($the_options['button_revoke_consent_text_color' . $suffix]); ?>; 
							background-color: <?php echo esc_html($the_options['button_revoke_consent_background_color' . $suffix]); ?>; 
							<?php if($the_options['show_again_position' . $suffix] === 'right') 
								echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; 
							else 
								echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> 
							border-radius: 50%; 
							height: 50px;
							width: 50px;
							padding: 4px !important;
							box-shadow: 0px 6px 11px gray;"
					>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
							<path fill="currentColor" stroke="currentColor" d="M259.1 73.5C262.1 58.7 275.2 48 290.4 48L350.2 48C365.4 48 378.5 58.7 381.5 73.5L396 143.5C410.1 149.5 423.3 157.2 435.3 166.3L503.1 143.8C517.5 139 533.3 145 540.9 158.2L570.8 210C578.4 223.2 575.7 239.8 564.3 249.9L511 297.3C511.9 304.7 512.3 312.3 512.3 320C512.3 327.7 511.8 335.3 511 342.7L564.4 390.2C575.8 400.3 578.4 417 570.9 430.1L541 481.9C533.4 495 517.6 501.1 503.2 496.3L435.4 473.8C423.3 482.9 410.1 490.5 396.1 496.6L381.7 566.5C378.6 581.4 365.5 592 350.4 592L290.6 592C275.4 592 262.3 581.3 259.3 566.5L244.9 496.6C230.8 490.6 217.7 482.9 205.6 473.8L137.5 496.3C123.1 501.1 107.3 495.1 99.7 481.9L69.8 430.1C62.2 416.9 64.9 400.3 76.3 390.2L129.7 342.7C128.8 335.3 128.4 327.7 128.4 320C128.4 312.3 128.9 304.7 129.7 297.3L76.3 249.8C64.9 239.7 62.3 223 69.8 209.9L99.7 158.1C107.3 144.9 123.1 138.9 137.5 143.7L205.3 166.2C217.4 157.1 230.6 149.5 244.6 143.4L259.1 73.5zM320.3 400C364.5 399.8 400.2 363.9 400 319.7C399.8 275.5 363.9 239.8 319.7 240C275.5 240.2 239.8 276.1 240 320.3C240.2 364.5 276.1 400.2 320.3 400z"/>
						</svg>
					</div>
				<?php } else {
					$revoke_icon_img = get_option( GDPR_COOKIE_CONSENT_SETTINGS_REVOKE_ICON . $suffix );
					
					if (!empty($revoke_icon_img)) { ?>
					<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>"
						style="
							position: fixed; 
							display:none; 
							bottom: 10px;  
							<?php if($the_options['show_again_position' . $suffix] === 'right') 
								echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; 
							else 
								echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> 
							padding:0 !important;"
					>
						<img 
							style="
								height: 50px;
								width: auto;
								object-fit: contain;
							" 
							alt="revoke-icon" 
							src="<?php echo esc_url_raw( $revoke_icon_img ); ?>" 
						>
					</div>
					<?php } else { ?>
						<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>" 
							style="
								position: fixed; 
								display:none; 
								bottom: 10px; 
								color: <?php echo esc_html($the_options['button_revoke_consent_text_color' . $suffix]); ?>; 
								background-color: <?php echo esc_html($the_options['button_revoke_consent_background_color' . $suffix]); ?>; 
								<?php if($the_options['show_again_position' . $suffix] === 'right') 
									echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; 
								else 
									echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> 
								border-radius: 50%; 
								height: 50px;
								width: 50px;
								padding: 4px !important;
								box-shadow: 0px 6px 11px gray;"
						>
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
								<path fill="currentColor" stroke="currentColor" d="M321.5 91.6C320.7 86.2 316.6 81.8 311.2 81C289.1 77.9 266.6 81.9 246.8 92.4L172.8 131.9C153.1 142.4 137.2 158.9 127.4 179L90.7 254.6C80.9 274.7 77.7 297.5 81.6 319.5L96.1 402.3C100 424.4 110.7 444.6 126.8 460.2L187.1 518.6C203.2 534.2 223.7 544.2 245.8 547.3L328.8 559C350.9 562.1 373.4 558.1 393.2 547.6L467.2 508.1C486.9 497.6 502.8 481.1 512.6 460.9L549.3 385.4C559.1 365.3 562.3 342.5 558.4 320.5C557.5 315.2 553.1 311.2 547.8 310.4C496.3 302.2 455 263.3 443.3 213C441.5 205.4 435.3 199.6 427.6 198.4C373 189.7 329.9 146.4 321.4 91.6zM272 208C289.7 208 304 222.3 304 240C304 257.7 289.7 272 272 272C254.3 272 240 257.7 240 240C240 222.3 254.3 208 272 208zM208 400C208 382.3 222.3 368 240 368C257.7 368 272 382.3 272 400C272 417.7 257.7 432 240 432C222.3 432 208 417.7 208 400zM432 336C449.7 336 464 350.3 464 368C464 385.7 449.7 400 432 400C414.3 400 400 385.7 400 368C400 350.3 414.3 336 432 336z"/>
							</svg>
						</div>
					<?php }
				} ?>
		<?php }
	}
}
if ( ! empty( $the_options['gdpr_notify'] )) {
	if ( ! empty( $the_options['cookie_data'] ) ) {
			?>
			<div class="gdpr_messagebar_detail layout-classic <?php echo esc_html( $the_options['template_parts'] ); ?> <?php echo esc_html( $the_options['theme_class'] ); ?>">
			<?php include plugin_dir_path( __FILE__ ) . 'modals/cookie_settings.php'; ?>
		</div>
		<?php
	}
	if ( ! empty( $the_options['show_again' . $suffix] ) ) {
		?>
		<?php if ( $the_options['show_again_as' . $suffix] === "text" ) { ?>
			<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>" style="position: fixed; display:none; bottom: 10px; color: <?php echo esc_html($the_options['button_revoke_consent_text_color' . $suffix]); ?>; background-color: <?php echo esc_html($the_options['button_revoke_consent_background_color' . $suffix]); ?>; <?php if($the_options['show_again_position' . $suffix] === 'right') echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; else echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> border-radius: 5px; box-shadow: 0px 6px 11px gray;">
				<span><?php echo esc_html__( $cookie_data['dash_show_again_text'], 'gdpr-cookie-consent' ); //phpcs:ignore ?></span>
			</div>
		<?php } elseif ( $the_options['show_again_as' . $suffix] === "icon" ) { ?>
				<?php if ( $the_options['show_again_icon' . $suffix] === "cookie" ) { ?>
					<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>" 
						style="
							position: fixed; 
							display:none; 
							bottom: 10px; 
							color: <?php echo esc_html($the_options['button_revoke_consent_text_color' . $suffix]); ?>; 
							background-color: <?php echo esc_html($the_options['button_revoke_consent_background_color' . $suffix]); ?>; 
							<?php if($the_options['show_again_position' . $suffix] === 'right') 
								echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; 
							else 
								echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> 
							border-radius: 50%; 
							height: 50px;
							width: 50px;
							padding: 4px !important;
							box-shadow: 0px 6px 11px gray;"
					>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
							<path fill="currentColor" stroke="currentColor" d="M321.5 91.6C320.7 86.2 316.6 81.8 311.2 81C289.1 77.9 266.6 81.9 246.8 92.4L172.8 131.9C153.1 142.4 137.2 158.9 127.4 179L90.7 254.6C80.9 274.7 77.7 297.5 81.6 319.5L96.1 402.3C100 424.4 110.7 444.6 126.8 460.2L187.1 518.6C203.2 534.2 223.7 544.2 245.8 547.3L328.8 559C350.9 562.1 373.4 558.1 393.2 547.6L467.2 508.1C486.9 497.6 502.8 481.1 512.6 460.9L549.3 385.4C559.1 365.3 562.3 342.5 558.4 320.5C557.5 315.2 553.1 311.2 547.8 310.4C496.3 302.2 455 263.3 443.3 213C441.5 205.4 435.3 199.6 427.6 198.4C373 189.7 329.9 146.4 321.4 91.6zM272 208C289.7 208 304 222.3 304 240C304 257.7 289.7 272 272 272C254.3 272 240 257.7 240 240C240 222.3 254.3 208 272 208zM208 400C208 382.3 222.3 368 240 368C257.7 368 272 382.3 272 400C272 417.7 257.7 432 240 432C222.3 432 208 417.7 208 400zM432 336C449.7 336 464 350.3 464 368C464 385.7 449.7 400 432 400C414.3 400 400 385.7 400 368C400 350.3 414.3 336 432 336z"/>
						</svg>
					</div>
				<?php } elseif ( $the_options['show_again_icon' . $suffix] === "shield" ) { ?>
					<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>" 
						style="
							position: fixed; 
							display:none; 
							bottom: 10px; 
							color: <?php echo esc_html($the_options['button_revoke_consent_text_color' . $suffix]); ?>; 
							background-color: <?php echo esc_html($the_options['button_revoke_consent_background_color' . $suffix]); ?>; 
							<?php if($the_options['show_again_position' . $suffix] === 'right') 
								echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; 
							else 
								echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> 
							border-radius: 50%; 
							height: 50px;
							width: 50px;
							padding: 4px !important;
							box-shadow: 0px 6px 11px gray;"
					>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
							<path fill="currentColor" stroke="currentColor" d="M320 64C324.6 64 329.2 65 333.4 66.9L521.8 146.8C543.8 156.1 560.2 177.8 560.1 204C559.6 303.2 518.8 484.7 346.5 567.2C329.8 575.2 310.4 575.2 293.7 567.2C121.3 484.7 80.6 303.2 80.1 204C80 177.8 96.4 156.1 118.4 146.8L306.7 66.9C310.9 65 315.4 64 320 64z"/>
						</svg>
					</div>
				<?php } elseif ( $the_options['show_again_icon' . $suffix] === "gear" ) { ?>
					<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>" 
						style="
							position: fixed; 
							display:none; 
							bottom: 10px; 
							color: <?php echo esc_html($the_options['button_revoke_consent_text_color' . $suffix]); ?>; 
							background-color: <?php echo esc_html($the_options['button_revoke_consent_background_color' . $suffix]); ?>; 
							<?php if($the_options['show_again_position' . $suffix] === 'right') 
								echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; 
							else 
								echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> 
							border-radius: 50%; 
							height: 50px;
							width: 50px;
							padding: 4px !important;
							box-shadow: 0px 6px 11px gray;"
					>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
							<path fill="currentColor" stroke="currentColor" d="M259.1 73.5C262.1 58.7 275.2 48 290.4 48L350.2 48C365.4 48 378.5 58.7 381.5 73.5L396 143.5C410.1 149.5 423.3 157.2 435.3 166.3L503.1 143.8C517.5 139 533.3 145 540.9 158.2L570.8 210C578.4 223.2 575.7 239.8 564.3 249.9L511 297.3C511.9 304.7 512.3 312.3 512.3 320C512.3 327.7 511.8 335.3 511 342.7L564.4 390.2C575.8 400.3 578.4 417 570.9 430.1L541 481.9C533.4 495 517.6 501.1 503.2 496.3L435.4 473.8C423.3 482.9 410.1 490.5 396.1 496.6L381.7 566.5C378.6 581.4 365.5 592 350.4 592L290.6 592C275.4 592 262.3 581.3 259.3 566.5L244.9 496.6C230.8 490.6 217.7 482.9 205.6 473.8L137.5 496.3C123.1 501.1 107.3 495.1 99.7 481.9L69.8 430.1C62.2 416.9 64.9 400.3 76.3 390.2L129.7 342.7C128.8 335.3 128.4 327.7 128.4 320C128.4 312.3 128.9 304.7 129.7 297.3L76.3 249.8C64.9 239.7 62.3 223 69.8 209.9L99.7 158.1C107.3 144.9 123.1 138.9 137.5 143.7L205.3 166.2C217.4 157.1 230.6 149.5 244.6 143.4L259.1 73.5zM320.3 400C364.5 399.8 400.2 363.9 400 319.7C399.8 275.5 363.9 239.8 319.7 240C275.5 240.2 239.8 276.1 240 320.3C240.2 364.5 276.1 400.2 320.3 400z"/>
						</svg>
					</div>
				<?php } else {
					$revoke_icon_img = get_option( GDPR_COOKIE_CONSENT_SETTINGS_REVOKE_ICON . $suffix );
					
					if (!empty($revoke_icon_img)) { ?>
					<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>"
						style="
							position: fixed; 
							display:none; 
							bottom: 10px;  
							<?php if($the_options['show_again_position' . $suffix] === 'right') 
								echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; 
							else 
								echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> 
							padding:0 !important"
					>
						<img 
							style="
								height: 50px;
								width: auto;
								object-fit: contain;
							" 
							alt="revoke-icon" 
							src="<?php echo esc_url_raw( $revoke_icon_img ); ?>" 
						>
					</div>
					<?php } else { ?>
						<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>" 
							style="
								position: fixed; 
								display:none; 
								bottom: 10px; 
								color: <?php echo esc_html($the_options['button_revoke_consent_text_color' . $suffix]); ?>; 
								background-color: <?php echo esc_html($the_options['button_revoke_consent_background_color' . $suffix]); ?>; 
								<?php if($the_options['show_again_position' . $suffix] === 'right') 
									echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; 
								else 
									echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> 
								border-radius: 50%; 
								height: 50px;
								width: 50px;
								padding: 4px !important;
								box-shadow: 0px 6px 11px gray;"
						>
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
								<path fill="currentColor" stroke="currentColor" d="M321.5 91.6C320.7 86.2 316.6 81.8 311.2 81C289.1 77.9 266.6 81.9 246.8 92.4L172.8 131.9C153.1 142.4 137.2 158.9 127.4 179L90.7 254.6C80.9 274.7 77.7 297.5 81.6 319.5L96.1 402.3C100 424.4 110.7 444.6 126.8 460.2L187.1 518.6C203.2 534.2 223.7 544.2 245.8 547.3L328.8 559C350.9 562.1 373.4 558.1 393.2 547.6L467.2 508.1C486.9 497.6 502.8 481.1 512.6 460.9L549.3 385.4C559.1 365.3 562.3 342.5 558.4 320.5C557.5 315.2 553.1 311.2 547.8 310.4C496.3 302.2 455 263.3 443.3 213C441.5 205.4 435.3 199.6 427.6 198.4C373 189.7 329.9 146.4 321.4 91.6zM272 208C289.7 208 304 222.3 304 240C304 257.7 289.7 272 272 272C254.3 272 240 257.7 240 240C240 222.3 254.3 208 272 208zM208 400C208 382.3 222.3 368 240 368C257.7 368 272 382.3 272 400C272 417.7 257.7 432 240 432C222.3 432 208 417.7 208 400zM432 336C449.7 336 464 350.3 464 368C464 385.7 449.7 400 432 400C414.3 400 400 385.7 400 368C400 350.3 414.3 336 432 336z"/>
							</svg>
						</div>
					<?php }
				} ?>
		<?php }
	}
}
if ( ! empty( $the_options['eprivacy_notify'] ) ) {
	if ( ! empty( $the_options['show_again' . $suffix] ) ) {
		?>
		<?php if ( $the_options['show_again_as' . $suffix] === "text" ) { ?>
			<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>" style="position: fixed; display:none; bottom: 10px; color: <?php echo esc_html($the_options['button_revoke_consent_text_color' . $suffix]); ?>; background-color: <?php echo esc_html($the_options['button_revoke_consent_background_color' . $suffix]); ?>; <?php if($the_options['show_again_position' . $suffix] === 'right') echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; else echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> border-radius: 5px; box-shadow: 0px 6px 11px gray;">
				<span><?php echo esc_html__( $cookie_data['dash_show_again_text'], 'gdpr-cookie-consent' );//phpcs:ignore ?></span>
			</div>
		<?php } elseif ( $the_options['show_again_as' . $suffix] === "icon" ) {?>
				<?php if ( $the_options['show_again_icon' . $suffix] === "cookie" ) { ?>
					<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>" 
						style="
							position: fixed; 
							display:none; 
							bottom: 10px; 
							color: <?php echo esc_html($the_options['button_revoke_consent_text_color' . $suffix]); ?>; 
							background-color: <?php echo esc_html($the_options['button_revoke_consent_background_color' . $suffix]); ?>; 
							<?php if($the_options['show_again_position' . $suffix] === 'right') 
								echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; 
							else 
								echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> 
							border-radius: 50%; 
							height: 50px;
							width: 50px;
							padding: 4px !important;
							box-shadow: 0px 6px 11px gray;"
					>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
							<path fill="currentColor" stroke="currentColor" d="M321.5 91.6C320.7 86.2 316.6 81.8 311.2 81C289.1 77.9 266.6 81.9 246.8 92.4L172.8 131.9C153.1 142.4 137.2 158.9 127.4 179L90.7 254.6C80.9 274.7 77.7 297.5 81.6 319.5L96.1 402.3C100 424.4 110.7 444.6 126.8 460.2L187.1 518.6C203.2 534.2 223.7 544.2 245.8 547.3L328.8 559C350.9 562.1 373.4 558.1 393.2 547.6L467.2 508.1C486.9 497.6 502.8 481.1 512.6 460.9L549.3 385.4C559.1 365.3 562.3 342.5 558.4 320.5C557.5 315.2 553.1 311.2 547.8 310.4C496.3 302.2 455 263.3 443.3 213C441.5 205.4 435.3 199.6 427.6 198.4C373 189.7 329.9 146.4 321.4 91.6zM272 208C289.7 208 304 222.3 304 240C304 257.7 289.7 272 272 272C254.3 272 240 257.7 240 240C240 222.3 254.3 208 272 208zM208 400C208 382.3 222.3 368 240 368C257.7 368 272 382.3 272 400C272 417.7 257.7 432 240 432C222.3 432 208 417.7 208 400zM432 336C449.7 336 464 350.3 464 368C464 385.7 449.7 400 432 400C414.3 400 400 385.7 400 368C400 350.3 414.3 336 432 336z"/>
						</svg>
					</div>
				<?php } elseif ( $the_options['show_again_icon' . $suffix] === "shield" ) { ?>
					<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>" 
						style="
							position: fixed; 
							display:none; 
							bottom: 10px; 
							color: <?php echo esc_html($the_options['button_revoke_consent_text_color' . $suffix]); ?>; 
							background-color: <?php echo esc_html($the_options['button_revoke_consent_background_color' . $suffix]); ?>; 
							<?php if($the_options['show_again_position' . $suffix] === 'right') 
								echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; 
							else 
								echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> 
							border-radius: 50%; 
							height: 50px;
							width: 50px;
							padding: 4px !important;
							box-shadow: 0px 6px 11px gray;"
					>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
							<path fill="currentColor" stroke="currentColor" d="M320 64C324.6 64 329.2 65 333.4 66.9L521.8 146.8C543.8 156.1 560.2 177.8 560.1 204C559.6 303.2 518.8 484.7 346.5 567.2C329.8 575.2 310.4 575.2 293.7 567.2C121.3 484.7 80.6 303.2 80.1 204C80 177.8 96.4 156.1 118.4 146.8L306.7 66.9C310.9 65 315.4 64 320 64z"/>
						</svg>
					</div>
				<?php } elseif ( $the_options['show_again_icon' . $suffix] === "gear" ) { ?>
					<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>" 
						style="
							position: fixed; 
							display:none; 
							bottom: 10px; 
							color: <?php echo esc_html($the_options['button_revoke_consent_text_color' . $suffix]); ?>; 
							background-color: <?php echo esc_html($the_options['button_revoke_consent_background_color' . $suffix]); ?>; 
							<?php if($the_options['show_again_position' . $suffix] === 'right') 
								echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; 
							else 
								echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> 
							border-radius: 50%; 
							height: 50px;
							width: 50px;
							padding: 4px !important;
							box-shadow: 0px 6px 11px gray;"
					>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
							<path fill="currentColor" stroke="currentColor" d="M259.1 73.5C262.1 58.7 275.2 48 290.4 48L350.2 48C365.4 48 378.5 58.7 381.5 73.5L396 143.5C410.1 149.5 423.3 157.2 435.3 166.3L503.1 143.8C517.5 139 533.3 145 540.9 158.2L570.8 210C578.4 223.2 575.7 239.8 564.3 249.9L511 297.3C511.9 304.7 512.3 312.3 512.3 320C512.3 327.7 511.8 335.3 511 342.7L564.4 390.2C575.8 400.3 578.4 417 570.9 430.1L541 481.9C533.4 495 517.6 501.1 503.2 496.3L435.4 473.8C423.3 482.9 410.1 490.5 396.1 496.6L381.7 566.5C378.6 581.4 365.5 592 350.4 592L290.6 592C275.4 592 262.3 581.3 259.3 566.5L244.9 496.6C230.8 490.6 217.7 482.9 205.6 473.8L137.5 496.3C123.1 501.1 107.3 495.1 99.7 481.9L69.8 430.1C62.2 416.9 64.9 400.3 76.3 390.2L129.7 342.7C128.8 335.3 128.4 327.7 128.4 320C128.4 312.3 128.9 304.7 129.7 297.3L76.3 249.8C64.9 239.7 62.3 223 69.8 209.9L99.7 158.1C107.3 144.9 123.1 138.9 137.5 143.7L205.3 166.2C217.4 157.1 230.6 149.5 244.6 143.4L259.1 73.5zM320.3 400C364.5 399.8 400.2 363.9 400 319.7C399.8 275.5 363.9 239.8 319.7 240C275.5 240.2 239.8 276.1 240 320.3C240.2 364.5 276.1 400.2 320.3 400z"/>
						</svg>
					</div>
				<?php } else {
					$revoke_icon_img = get_option( GDPR_COOKIE_CONSENT_SETTINGS_REVOKE_ICON . $suffix );
					
					if (!empty($revoke_icon_img)) { ?>
					<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>"
						style="
							position: fixed; 
							display:none; 
							bottom: 10px;  
							<?php if($the_options['show_again_position' . $suffix] === 'right') 
								echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; 
							else 
								echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> 
							padding:0 !important;"
					>
						<img 
							style="
								height: 50px;
								width: auto;
								object-fit: contain;
							" 
							alt="revoke-icon" 
							src="<?php echo esc_url_raw( $revoke_icon_img ); ?>" 
						>
					</div>
					<?php } else { ?>
						<div id="<?php echo esc_html( $the_options['show_again_container_id'] ); ?>" 
							style="
								position: fixed; 
								display:none; 
								bottom: 10px; 
								color: <?php echo esc_html($the_options['button_revoke_consent_text_color' . $suffix]); ?>; 
								background-color: <?php echo esc_html($the_options['button_revoke_consent_background_color' . $suffix]); ?>; 
								<?php if($the_options['show_again_position' . $suffix] === 'right') 
									echo "right: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; 
								else 
									echo "left: ". esc_html($the_options['show_again_margin' . $suffix]) . "%;"; ?> 
								border-radius: 50%; 
								height: 50px;
								width: 50px;
								padding: 4px !important;
								box-shadow: 0px 6px 11px gray;"
						>
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
								<path fill="currentColor" stroke="currentColor" d="M321.5 91.6C320.7 86.2 316.6 81.8 311.2 81C289.1 77.9 266.6 81.9 246.8 92.4L172.8 131.9C153.1 142.4 137.2 158.9 127.4 179L90.7 254.6C80.9 274.7 77.7 297.5 81.6 319.5L96.1 402.3C100 424.4 110.7 444.6 126.8 460.2L187.1 518.6C203.2 534.2 223.7 544.2 245.8 547.3L328.8 559C350.9 562.1 373.4 558.1 393.2 547.6L467.2 508.1C486.9 497.6 502.8 481.1 512.6 460.9L549.3 385.4C559.1 365.3 562.3 342.5 558.4 320.5C557.5 315.2 553.1 311.2 547.8 310.4C496.3 302.2 455 263.3 443.3 213C441.5 205.4 435.3 199.6 427.6 198.4C373 189.7 329.9 146.4 321.4 91.6zM272 208C289.7 208 304 222.3 304 240C304 257.7 289.7 272 272 272C254.3 272 240 257.7 240 240C240 222.3 254.3 208 272 208zM208 400C208 382.3 222.3 368 240 368C257.7 368 272 382.3 272 400C272 417.7 257.7 432 240 432C222.3 432 208 417.7 208 400zM432 336C449.7 336 464 350.3 464 368C464 385.7 449.7 400 432 400C414.3 400 400 385.7 400 368C400 350.3 414.3 336 432 336z"/>
							</svg>
						</div>
					<?php }
				} ?>
		<?php
		}
	}
}

if ( ! empty( $the_options['ccpa_notify'] ) ) {
	?>
	<div class="ccpa_messagebar_detail layout-classic <?php echo esc_html( $the_options['template_parts'] ); ?>">
		<?php include plugin_dir_path( __FILE__ ) . 'modals/cookie_settings.php'; ?>
	</div>
	<?php
}