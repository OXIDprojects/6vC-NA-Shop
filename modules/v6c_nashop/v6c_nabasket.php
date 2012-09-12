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
 * This class extends the oxBasket core class and should be configured in the
 * module extension settings of admin as given below.  If any errors occur after
 * adding this module try clearing your browsers cache and cookies.
 *
 * 	oxbasket => v6c_nashop/v6c_nabasket
 */
class v6c_naBasket extends v6c_naBasket_parent
{
	/////////////////////// OVERRIDES ////////////////////////////

	/////////////////////// EXTENSIONS ////////////////////////////

	/**
     * Forces taxes to be included/calculated for basket total when config parm
     * v6c_blKillTax is set.  If tax is not yet set, sets it according to rate
     * applicable to user.  Calls parent function to make actual
     * calculation.  If v6c_blKillTax is not set, simply calls parent.
     *
     * @return null
     *
     */
    protected function _calcTotalPrice()
    {
    	$bKillTax = $this->getConfig()->getConfigParam( 'v6c_blKillTax' );
    	$oUser = null;

    	if ($bKillTax)
    	{
    		$oUser = $this->getUser();
    		if ($oUser != null)
    		{
    			// enable taxes for basket recalc
	    		$this->_oPrice->v6cEnableTax();
	    		$this->_oPrice->setNettoPriceMode();
	    		if (!$this->_oPrice->v6cIsTaxSet()) $this->_oPrice->setVat(oxVatSelector::getInstance()->v6cGetUserTaxes($oUser));
    		}
    	}
    	parent::_calcTotalPrice();
    }

	/////////////////////// ADDITIONS ////////////////////////////

    /**
     * Returns an array of tax costs for basket grand total.
     * Array key is a string representing the type of tax.
     *
     * NOTE: This function can only be used if v6c_blKillTax is set, otherwise the
     * basket oxPrice object will not contain the required net price.
     *
     * @return array | bool
     */
    public function v6cGetBasketTaxes( $bFormatted = true )
    {
    	// Do not continue unless required config parm is set.
    	if (!$this->getConfig()->getConfigParam( 'v6c_blKillTax' )) return false;

		// Format prices if needed
		if ($bFormatted)
		{
			$aTaxes = array();
			foreach ($this->_oPrice->v6cGetTaxValues() as $sKey => $dTax )
			{
				$aTaxes[$sKey] = oxLang::getInstance()->formatCurrency( $dTax, $this->getBasketCurrency() );
			}
		} else $aTaxes = $this->_oPrice->v6cGetTaxValues();

        return $aTaxes;
    }

    /**
     * Formatted discounted products gross price getter
     *
     * @return string
     */
    public function v6cGetFDiscountedProductsPrice()
    {
        return oxLang::getInstance()->formatCurrency( $this->getDiscountedProductsBruttoPrice(), $this->getBasketCurrency() );
    }

    /**
     * Returns formatted basket total net price
     *
     * @return string
     */
    public function v6cGetFPriceNet()
    {
        return oxLang::getInstance()->formatCurrency( $this->getPrice()->getNettoPrice(), $this->getBasketCurrency() );
    }

    /**
     * Returns formatted basket total tax
     *
     * @return string
     */
    public function v6cGetFPriceTax()
    {
        return oxLang::getInstance()->formatCurrency( $this->getPrice()->getVatValue(), $this->getBasketCurrency() );
    }

    /**
    * Returns formatted cart total cost.  This is a sum of all product and gift wrap/card costs.
    *
    * @return string
    */
    public function v6cGetFCartTotal()
    {
        $dWrappNet = $this->getCosts( 'oxwrapping' )->getBruttoPrice();
        return oxLang::getInstance()->formatCurrency( $this->getDiscountedProductsBruttoPrice() + $dWrappNet, $this->getBasketCurrency() );
    }
}