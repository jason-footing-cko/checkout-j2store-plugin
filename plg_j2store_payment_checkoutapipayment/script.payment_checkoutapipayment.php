<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class plgJ2StorePayment_checkoutapipaymentInstallerScript {

	function preflight( $type, $parent ) {

		$xmlfile = JPATH_ADMINISTRATOR.'/components/com_j2store/manifest.xml';
		$xml = JFactory::getXML($xmlfile);
		$version=(string)$xml->version;

		//check for minimum requirement
		// abort if the current J2Store release is older
		if( version_compare( $version, '2.0.2', 'lt' ) ) {
			Jerror::raiseWarning(null, 'You are using an old version of J2Store. Please upgrade to the latest version');
			return false;
		}

	}

}