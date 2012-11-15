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
 * This class extends the oxViewConfig controller class and should be configured in the
 * module extension settings of admin as given below.
 *
 * 		oxviewconfig => v6c_nashop/v6c_naviewconfig
 */
class v6c_naViewConfig extends v6c_naViewConfig_parent
{
	/////////////////////// OVERRIDES ////////////////////////////

    /**
     * NOTE: Probably obsolete now since options module has been discontinued.
     * Only applicable if replacing payment view with options view.
     *
     * @return string
     */
    /*public function getPaymentLink()
    {
    	if ($this->getConfig()->getConfigParam( 'v6c_blCompactChkOut' ))
    	{
    	    if ( ( $sValue = $this->getViewConfigParam( 'paymentlink' ) ) === null )
    	    {
	            $sValue = $this->getConfig()->getShopSecureHomeUrl() . 'cl=v6c_ctrl_options';
	            $this->setViewConfigParam( 'paymentlink', $sValue );
        	}
    	}
    	else
    	{
   			$sValue = parent::getPaymentLink();
    	}

        return $sValue;
    }*/


	/////////////////////// EXTENSIONS ////////////////////////////

    /**
    * If only one domestic country available, select it.
    *
    * @return object
    */
    public function getCountryList()
    {
        static $bOnce = false;

        parent::getCountryList();

        if (!$bOnce)
        {
            $aHomeCountry = oxConfig::getInstance()->getConfigParam('aHomeCountry');
            if (is_array($aHomeCountry) && count($aHomeCountry) == 1 && count($this->_oCountryList) > 0)
            {
                foreach ( $aHomeCountry as $sCountryId )
                {
                    if ( array_key_exists($sCountryId, $this->_oCountryList->getArray()) )
                        $this->_oCountryList[$sCountryId]->domestic = true;
                }
            }
            $bOnce = true;
        }

        return $this->_oCountryList;
    }


	/////////////////////// ADDITIONS ////////////////////////////

	/**
     * Module installed checker.
     *
     * @param string $sModule module name (without v6c prefix)
     *
     * @return  bool
     */
    public function v6cIsMdlInst( $sModule )
    {
    	// check for directory in modules folder
    	$bRet = file_exists( getShopBasePath() . 'modules/' .'v6c_'. strtolower($sModule));
    	return $bRet;
    }

	/**
     * Variable getter
     *
     * @return bool
     */
    public function v6cIsTaxOff()
    {
    	return $this->getConfig()->getConfigParam( 'v6c_blKillTax' );
    }

	/**
     * Variable getter
     *
     * @return bool
     */
    public function v6cIsTaxLabelled()
    {
    	return $this->getConfig()->getConfigParam( 'v6c_blLabelTax' );
    }

	/**
     * Price formatter
     *
     * @return string
     */
    public function v6cFormatCurrency($dPrice, $oActCur = null)
    {
    	return oxLang::getInstance()->formatCurrency($dPrice, $oActCur);
    }

	/**
     * Variable getter.  Used by MerchantLink module.
     *
     * @return bool
     */
    public function v6cHideSinglePay()
    {
    	return $this->getConfig()->getConfigParam( 'v6c_blHideSinglePay' );
    }

	/**
     * Variable getter.  Used by v6c_Options module.
     *
     * @return bool
     */
    public function v6cIsCompactChkOut()
    {
    	return $this->getConfig()->getConfigParam( 'v6c_blCompactChkOut' );
    }

	/**
     * Get session basket.
     *
     * @return oxBasket
     */
    public function v6cGetBasket()
    {
    	return $this->getSession()->getBasket();
    }

    /**
    * Variable getter
    *
    * @return bool
    */
    public function v6cIsXprsChkOut()
    {
        return $this->getConfig()->getConfigParam( 'v6c_bXprsChkout' );
    }
}