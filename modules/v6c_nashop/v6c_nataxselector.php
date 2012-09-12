<?php
/**
* The contents of this file are subject to the Common Public Attribution License
* Version 1.0 (the "License"); you may not use this file except in compliance with
* the License. You may obtain a copy of the License at
* http://www.6vcommerce.ca/CPAL.html. The License is based on the
* Mozilla Public License Version 1.1 but Sections 14 and 15 have been added to cover
* use of software over a computer network and provide for limited attribution for
* the Original Developer. In addition, Exhibit A has been modified to be consistent
* with Exhibit B.
*
* Software distributed under the License is distributed on an "AS IS" basis, WITHOUT
* WARRANTY OF ANY KIND, either express or implied. See the License for the specific
* language governing rights and limitations under the License.
*
* The Original Code is 6vCommerce NA-Shop Module.
*
* The Initial Developer of the Original Code is 6vCommerce.
* The Original Developer is the Initial Developer.
*
* All portions of the code written by 6vCommerce are Copyright (C) 6vCommerce.
* All Rights Reserved.
*
* Contributor(s):
*
* @link      http://www.6vcommerce.ca
* @copyright (C) 6vCommerce
*/

/**
 * This class extends the oxVatSelector core class and should be configured in the
 * module extension settings of admin as given below.
 *
 * 		oxvatselector => v6c_nashop/v6c_nataxselector
 */
class v6c_naTaxSelector extends v6c_naTaxSelector_parent
{
	/////////////////////// OVERRIDES ////////////////////////////

	/**
	 * OVERRIDES parent function
	 * get region specific tax for user
	 *
	 * Note regarding original/parent function:
     * Returns a double only if foreign tax value applies to user, otherwise returns false.
     * That is, will always return false for domestic users.  As a result tax could only be
     * set to two different values: domestic & international.
	 *
	 * @param oxUser $oUser		given user object
	 * @param bool   $blCacheReset reset cache
	 *
	 * @throws oxObjectException if invalid state (region)
	 * @return double | false
	 */
	public function getUserVat( oxUser $oUser, $blCacheReset = false )
	{
		/**
		 * - Regional taxes configured via config.inc.php
		 *
		 *   $this->aCountryVat = array( ... );
		 */
	    if (!$blCacheReset)
	    {
	        $sId = $oUser->getId();
	        if ( array_key_exists( $sId, self::$_aUserVatCache ) && self::$_aUserVatCache[$sId] !== null)
	            return self::$_aUserVatCache[$sId];
	    }

		$dTax = false;
		// check if a foreign tax applies to user a return that if true
		//if ( ( $dTax = parent::getUserVat( $oUser, $blCacheReset ) ) === false ) {
			// check for required parms
			if ( $oUser && ( $aRegion2Tax = $this->getConfig()->getConfigParam( "aRegionTax" ) ) ) {
				// get region from oxUser object
				if ( ( $sUserRegion = $this->_v6c_getActiveState($oUser) ) === null ) {
					//no region from oxUser so get it from oxVatSelector
					$sUserRegion = $this->_v6c_getTaxRegion( $oUser );
				}
				if ( isset( $aRegion2Tax[$sUserRegion] ) ) {
					$aRegionTaxes = $aRegion2Tax[$sUserRegion];
					if (count($aRegionTaxes) == 1)
					{
						// Return single tax (GST/HST)
						$dTax = reset($aRegionTaxes);
					} else {
						// Return effective tax for multiple values (GST+PST)
						/*
						 * WARNING:
						 * Summing tax as follows will result in tax being calc'd as
						 * 		Brutto = Round( Netto * (1 + (TAX1+TAX2)/100) )
						 * Even though the correct method should be
						 * 		Brutto = Netto + Round(1+TAX1/100) + Round(1+TAX2/100)
						 * As a result, the Brutto price will be off by +/-0.01 and
						 * a fudge factor will need to be used in code when extracting
						 * individual tax costs from the brutto price.
						 *
						 * TODO: Support proper multi-tax calculations.
						 */
						$dTax = reset($aRegionTaxes) + next($aRegionTaxes);
					}
				}
			}
		//}
		self::$_aUserVatCache[$oUser->getId()] = $dTax;
		return $dTax;
	}

	/////////////////////// ADDITTIONS ////////////////////////////

	/**
	 * Returns active state based on oxUser object
	 * @param oxUser $oUser
	 * @return string
	 */
	protected function _v6c_getActiveState( oxUser $oUser )
	{
		$sDeliveryState = '';

		if ( $oUser->getId() ) {
			$sDeliveryState = $oUser->getState();
		} else {
			$oUser = oxNew( 'oxuser' );
			if ( $oUser->loadActiveUser() ) {
				$sDeliveryState = $oUser->oxuser__oxstateid->value;
			}
		}

		return $sDeliveryState;
	}

	/**
	 * Returns state based on oxVatSelector object and shop config
	 * @param oxUser $oUser
	 */
	protected function _v6c_getTaxRegion( oxUser $oUser ) {
		$blUseShippingCountry = $this->getConfig()->getConfigParam("blShippingCountryVat");

		if ($blUseShippingCountry) {
			$aAddresses = $oUser->getUserAddresses($oUser->getId());
			$sSelectedAddress = $oUser->getSelectedAddressId();

			if (isset($aAddresses[$sSelectedAddress])) {
				return $aAddresses[$sSelectedAddress]->oxaddress__oxstateid->value;
			}
		}

		return $oUser->oxuser__oxstateid->value;
	}

	/**
	 * get array of region specific tax for user
	 *
	 * @param oxUser $oUser		given user object
	 * @param bool   $blCacheReset reset cache
	 *
	 * @throws oxObjectException if invalid state (region)
	 * @return array | false
	 */
	public function v6cGetUserTaxes( oxUser $oUser )
	{
		/**
		 * - Regional taxes configured via config.inc.php
		 *
		 *   $this->aCountryVat = array( ... );
		 */

		$aTaxes = false;
		static $aTaxCache = array();

		if (array_key_exists($oUser->getId(), $aTaxCache)) $aTaxes = $aTaxCache[$oUser->getId()];
		// check for required parms
		elseif ( $oUser && ( $aRegion2Tax = $this->getConfig()->getConfigParam( "aRegionTax" ) ) )
		{
			// get region from oxUser object
			if ( ( $sUserRegion = $this->_v6c_getActiveState($oUser) ) === null ) {
				//no region from oxUser so get it from oxVatSelector
				$sUserRegion = $this->_v6c_getTaxRegion( $oUser );
			}
			if ( isset( $aRegion2Tax[$sUserRegion] ) ) {
				$aTaxes = $aRegion2Tax[$sUserRegion];
				$aTaxCache[$oUser->getId()] = $aTaxes;
			}
		}

		return $aTaxes;
	}
}