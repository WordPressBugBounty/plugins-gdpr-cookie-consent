<?php
/**
 * Provide a integration tab view for the WP Cookie Consent plugin
 *
 * This file is used to markup the admin-facing aspects of the WP Cookie Consent plugin.
 *
 * @link       https://club.wpeka.com/
 * @since      3.0.0
 *
 * @package gdpr-cookie-consent
 */

// check if pro is activated or installed.

$pro_is_activated  = get_option( 'wpl_pro_active', false );
$installed_plugins = get_plugins();
$pro_installed     = isset( $installed_plugins['wpl-cookie-consent/wpl-cookie-consent.php'] ) ? true : false;

// Require the class file for gdpr cookie consent api framework settings.
require_once GDPR_COOKIE_CONSENT_PLUGIN_PATH . 'includes/settings/class-gdpr-cookie-consent-settings.php';

// Instantiate a new object of the GDPR_Cookie_Consent_Settings class.
$this->settings = new GDPR_Cookie_Consent_Settings();

// Call the is_connected() method from the instantiated object to check if the user is connected.
$is_user_connected = $this->settings->is_connected();

$class_for_blur_content = $is_user_connected ? '' : 'gdpr-blur-background'; // Add a class for styling purposes.

$class_for_card_body_blur_content = $is_user_connected ? '' : 'gdpr-body-blur-background'; // Add a class for styling purposes.

$the_options = Gdpr_Cookie_Consent::gdpr_get_settings();
$geo_options = get_option( 'wpl_geo_options' );
if (!is_array($geo_options)) {
    $geo_options = array();
}
if ( ! isset( $geo_options['database_prefix'] ) ) {
	$geo_options['maxmind_license_key'] = '';
	$geo_options['database_prefix']     = wp_generate_password( 32, false, false );
	update_option( 'wpl_geo_options', $geo_options );
}
if ( ! isset( $geo_options['enable_geotargeting'] ) ) {
	$geo_options['enable_geotargeting'] = false;
	update_option( 'wpl_geo_options', $geo_options );
}
$uploads_dir                       = wp_upload_dir();
$geo_options['database_file_path'] = trailingslashit( $uploads_dir['basedir'] ) . 'gdpr_uploads/' . $geo_options['database_prefix'] . '-GeoLite2-City.mmdb';
update_option( 'wpl_geo_options', $geo_options );
wp_enqueue_style( 'gdpr-cookie-consent-integrations' );
wp_enqueue_script( 'gdpr-cookie-consent-integrations' );
wp_localize_script(
	'gdpr-cookie-consent-integrations',
	'integrations_obj',
	array(
		'ajax_url'    => admin_url( 'admin-ajax.php' ),
		'geo_options' => $geo_options,
	)
);


$the_options = Gdpr_Cookie_Consent::gdpr_get_settings();
$geo_options = get_option( 'wpl_geo_options' );

$enable_value = $the_options['enable_safe'] === 'true' ? 'overlay-integration-style' : '';
if ( ! $geo_options['enable_geotargeting'] ) {
	$geo_options['enable_geotargeting'] = 'false';
}
$enable        = $geo_options['enable_geotargeting'];
$enable_value1 = $geo_options['enable_geotargeting'] === 'false' ? 'overlay-integration-style__disable' : '';
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div id="wpl-cookie-consent-integrations-loader"></div>
<div id="wpl-cookie-consent-overlay"></div>
<div id="wpl-cookie-consent-integrations-page">
	<div class="wpl-cookie-consent-page-name">
		<h1><?php esc_attr_e( 'MaxMind Geolocation Integration', 'gdpr-cookie-consent' ); ?></h1>
	</div>
	<div id="wpl-cookie-consent-integrations-alert">{{alert_message}}</div>

	<c-container class="wpl-cookie-consent-integrations-form-container <?php echo $pro_installed ? '' : esc_attr( $class_for_blur_content ); ?>" style="position:relative;">
		<!-- API Connection Screen  -->
		<?php if ( ! $is_user_connected && ! $pro_installed ) : ?>
			<div class="gdpr-overlay">
				<p class="enable-text"><?php esc_html_e( 'To enable MaxMind Integration, create your FREE WP Cookie Consent account.', 'gdpr-cookie-consent' ); ?></p>
				<button class="gdpr-start-auth"><?php esc_html_e( 'New? Create an account', 'gdpr-cookie-consent' ); ?></button>
				<p><span class="already-have-acc"><?php esc_html_e( 'Already have an account?', 'gdpr-cookie-consent' ); ?></span><span class="api-connect-to-account-btn" ><?php esc_html_e( ' Connect your existing account', 'gdpr-cookie-consent' ); ?></span></p>
			</div>
		<?php endif; ?>
		<c-form spellchek="false" id="wpl-cookie-consent-integrations-form" class="<?php echo $pro_installed ? '' : esc_attr( $class_for_card_body_blur_content ); ?>">
			<?php
			if ( function_exists( 'wp_nonce_field' ) ) {
				wp_nonce_field( 'wpl-update-maxmind-license' );
			}
			?>
				</c-row>
				<?php
				if ( $enable === 'true' ) {
					?>
						<div class="<?php echo $enable_value; ?>">
					<?php if ( $the_options['enable_safe'] === 'true' ) : ?>
					<div class="overlay-integration-message">
						<?php
						esc_attr_e(
							'Safe Mode enabled. Disable it in Compliance settings to manage integrations.',
							'gdpr-cookie-consent'
						);
						?>
					</div>
				<?php endif; ?>
			</div>
				<?php } elseif ( $geo_options['enable_geotargeting'] === 'false' && $the_options['enable_safe'] === 'true' ) { ?>
					<div class="<?php echo $enable_value1; ?>">
					<?php if ( $the_options['enable_safe'] === 'true' ) : ?>
					<div class="overlay-integration-message__disable">
						<?php
						esc_attr_e(
							'Safe Mode enabled. Disable it in Compliance settings to manage integrations.',
							'gdpr-cookie-consent'
						);
						?>
					</div>
				<?php endif; ?>
			</div>
				<?php } ?>

			<c-row >
				<c-col class="col-sm-3">
					<label class="wpl-cookie-consent-integrations-label"><?php esc_attr_e( 'Enable Geotargeting', 'gdpr-cookie-consent' ); ?></label>
				</c-col>
				<c-col class="col-sm-9">
					<c-switch v-bind="labelIcon" v-model="enable_geotargeting" id="wpl-cookie-consent-enable-geo-targeting" variant="3d"  color="success" :checked="enable_geotargeting" v-on:update:checked="OnEnableGeotargeting"></c-switch>
					<input type="hidden" name="wpl-enable-geo-targeting" v-model="enable_geotargeting">
					<c-button class="wpl-cookie-consent-save-button" v-show="!enable_geotargeting" color="info" @click="onSubmitIntegrations"><?php echo esc_html( 'Save' ); ?></c-button>
				</c-col>
			</c-row>
			<c-row v-show="enable_geotargeting">
				<c-col class="col-sm-3">
					<label class="wpl-cookie-consent-integrations-label"><?php esc_attr_e( 'MaxMind License Key', 'gdpr-cookie-consent' ); ?></label>
				</c-col>
				<c-col class="col-sm-9">
					<c-input description="The key that will be used when dealing with MaxMind Geolocation services." class="wpl-cookie-consent-license-input" type="password" name="wpl-maxmind-license-key" v-model="maxmind_license_key" placeholder="Paste the license key here"></c-input>
				</c-col>
			</c-row>
			<c-row v-show="enable_geotargeting">
				<c-col class="col-sm-3">
					<label class="wpl-cookie-consent-integrations-label"><?php esc_attr_e( 'Database File Path', 'gdpr-cookie-consent' ); ?></label>
				</c-col>
				<c-col class="col-sm-9">
					<c-input description="The location that the MaxMind database should be stored.By default, the integration will automatically save the database here." class="wpl-cookie-consent-database-input" readonly type="text" name="wpl-database-file-path" v-model="database_file_path"></c-input>
				</c-col>
			</c-row>
			<c-row v-show="enable_geotargeting">
				<c-col class="col-sm-3"></c-col>
				<c-col class="col-sm-9">
					<c-button color="info" @click="onSubmitIntegrations"><?php echo esc_html( 'Save' ); ?></c-button>
				</c-col>
			</c-row>
			<c-row>
				<c-spinner class="wpl_integrations_spinner" color="dark"></c-spinner>
			</c-row>
		</c-form>
		<c-row class="wpl-cookie-consent-register-row <?php echo $pro_installed ? '' : esc_attr( $class_for_card_body_blur_content ); ?>">
			<c-col class="col-sm-12">
				<span class="wpl-cookie-consent-register-area">
					<?php echo esc_html( 'To enable this feature, you need to integrate with MaxMind for free. Register using this link to generate license key -' ); ?>
					<a class="wpl-cookie-consent-link" :href="maxmind_register_link">{{maxmind_register_link}}</a>
				</span>
			</c-col>
		</c-row>
		<c-row class="wpl-cookie-consent-documentation-row <?php echo $pro_installed ? '' : esc_attr( $class_for_card_body_blur_content ); ?>">
			<c-col class="col-sm-12">
				<span>
					<?php echo esc_html( 'Follow the steps here in the ' ); ?>
					<a class="wpl-cookie-consent-link" :href="document_link"><?php echo esc_html( 'documentation' ); ?></a>
					<?php echo esc_html( ' or refer to the video below.' ); ?>
				</span>
			</c-col>
		</c-row>
		<c-row class="wpl-cookie-consent-video-row <?php echo $pro_installed ? '' : esc_attr( $class_for_card_body_blur_content ); ?>">
			<c-col class="col-sm-12">
				<iframe :src="video_link" width="746" height="350"></iframe>
			</c-col>
		</c-row>
		<c-row class="wpl-cookie-consent-support-row <?php echo $pro_installed ? '' : esc_attr( $class_for_card_body_blur_content ); ?>">
			<c-col class="col-sm-12">
				<span><?php echo esc_html( 'Still have questions?' ); ?></span>
			</c-col>
			<c-col class="col-sm-12">
				<span><?php echo esc_html( 'Raise a support ticket' ); ?></span>
				<a class="wpl-cookie-consent-link" :href="support_link"><?php echo esc_html( 'here.' ); ?></a>
			</c-col>
		</c-row>
	</c-container>
</div>
