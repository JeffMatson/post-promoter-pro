<?php

function ppp_upgrade_plugin() {
	$ppp_version = get_option( 'ppp_version' );

	$upgrades_executed = false;

	// We don't have a version yet, so we need to run the upgrader
	if ( !$ppp_version && PPP_VERSION == '1.3' ) {
		ppp_v13_upgrades();
		$ppp_version = PPP_VERSION;
		$upgrades_executed = true;
	}

	if ( $upgrades_executed || version_compare( $ppp_version, PPP_VERSION, '<' ) ) {
		update_option( 'ppp_version', $ppp_version );
	}

}

function ppp_v13_upgrades() {
	global $ppp_share_settings;
	$uq_status = ( isset( $ppp_share_settings['ppp_unique_links'] ) && $ppp_share_settings['ppp_unique_links'] == '1' ) ? $ppp_share_settings['ppp_unique_links'] : 0;
	$ga_status = ( isset( $ppp_share_settings['ppp_ga_tags'] ) && $ppp_share_settings['ppp_ga_tags'] == '1' ) ? $ppp_share_settings['ppp_ga_tags'] : 0;

	if ( $uq_status ) {
		$ppp_share_settings['analytics'] = 'unique_links';
		unset( $ppp_share_settings['ppp_unique_links'] );
	} elseif ( $ga_status ) {
		$ppp_share_settings['analytics'] = 'google_analytics';
		unset( $ppp_share_settings['ppp_ga_tags'] );
	}

	update_option( 'ppp_share_settings', $ppp_share_settings );
	var_dump('ran 1.3 upgrades');
}