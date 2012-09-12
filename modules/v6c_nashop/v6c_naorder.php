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
 * This class extends the oxOrder core class and should be configured in the
 * module extension settings of admin as given below.
 *
 * 		oxorder => v6c_nashop/v6c_naorder
 */
class v6c_naOrder extends v6c_naOrder_parent
{
	/////////////////////// OVERRIDES ////////////////////////////


	/////////////////////// EXTENSIONS ////////////////////////////

	/**
	* Insert global tax values into article tax value fields (they have to go somewhere)
	* and then flag this difference using new field.  This flag
	* will be used to tell order basket calculations to use the article tax values as
	* global values.
	*
	* @param oxBasket $oBasket Shopping basket object
	*
	* @return null
	*/
	protected function _loadFromBasket( oxBasket $oBasket )
	{
	    parent::_loadFromBasket($oBasket);

	    // Only applies if shop is configured as such
	    if ($this->getConfig()->getConfigParam( 'v6c_blKillTax' ))
	    {
	        $oBasketPrice = $oBasket->getPrice();
	        $aTaxAmounts = $oBasketPrice->v6cGetTaxValues();
	        $aTaxPercents = $oBasketPrice->v6cGetTaxes();

	        // use article-vat fields to store (upto 2) global tax values
	        if (count($aTaxAmounts) <= 2)
	        {
    	        $iVatIndex = 1;
    	        foreach ( $aTaxAmounts as $sTax => $dPrice )
    	        {
	                $this->{"oxorder__oxartvat$iVatIndex"}      = new oxField($aTaxPercents[$sTax], oxField::T_RAW);
	                $this->{"oxorder__oxartvatprice$iVatIndex"} = new oxField($dPrice, oxField::T_RAW);
	                $iVatIndex++;
    	        }
	        // Using total/cumulative value because more than 2 tax values present
	        } else {
	            $this->{"oxorder__oxartvat$iVatIndex"}      = new oxField($oBasketPrice->getVat(), oxField::T_RAW);
	            $this->{"oxorder__oxartvatprice$iVatIndex"} = new oxField($oBasketPrice->getVatValue(), oxField::T_RAW);
	        }

	        // set new fields specific to NA tax methods
	        $this->oxorder__v6globaltax  = new oxField(1, oxField::T_RAW); // flag for NA tax method
	        $this->oxorder__v6taxes      = new oxField(serialize($aTaxPercents), oxField::T_RAW);
	    }
	}


	/////////////////////// ADDITIONS ////////////////////////////

    /**
     * Returns string describing the payment terms.  For example, "Payment In Advance" or "NET30".
     * Currently, only support detection of advanced payment based on dates.
     *
     * @return string
     */
    public function v6cGetPaymentTerms()
    {
    	$oUtilsDate = oxUtilsDate::getInstance();
    	$oLang = oxLang::getInstance();
    	$sRet = $oLang->translateString('V6C_ORDER_PAYTERM_NA');

    	// Not sure the purpose of oxUtilsDate::isEmptyDate but it doesn't seem to work in this case!
    	// As a result, resorting to manual checking.
    	$iPaid = (isset($this->oxorder__oxpaid->value) && !( strcmp('0000-00-00 00:00:00', $this->oxorder__oxpaid->value) == 0 || strcmp('-', $this->oxorder__oxpaid->value) == 0) ) ? strtotime($this->oxorder__oxpaid->value) : 0;
    	$iSent = (isset($this->oxorder__oxsenddate->value) && !( strcmp('0000-00-00 00:00:00', $this->oxorder__oxsenddate->value) == 0 || strcmp('-', $this->oxorder__oxsenddate->value) == 0) ) ? strtotime($this->oxorder__oxsenddate->value) : 0;

    	if ( $iPaid != 0 && $iSent == 0 )
    		$sRet = $oLang->translateString('V6C_ORDER_PAYTERM_ADV');
    	elseif ( $iPaid != 0 && $iSent != 0 )
    	{
    		$iPaid = strtotime($this->oxorder__oxpaid->value);
    		$iSent = strtotime($this->oxorder__oxsenddate->value);
    		if ($iPaid <= $iSent) $sRet = $oLang->translateString('V6C_ORDER_PAYTERM_ADV');
    	}

    	return $sRet;
    }

    /**
    * Checks if tax was calculated on basket total in accordance with the NAshop killTax configuration option.
    * In this case, the tax values stored in the article-tax fields represent tax for the entire basket.
    *
    * @return bool
    */
    public function v6cIsTaxGlobal()
    {
    	return ($this->oxorder__v6globaltax->value == 1);
    }

    /**
    * Checks if order has been paid.
    *
    * @return bool
    */
    public function v6cIsPaid()
    {
    	static $bRet = null;
    	if (!isset($bRet)) $bRet = ( isset($this->oxorder__oxpaid->value) && !oxUtilsDate::getInstance()->isEmptyDate($this->oxorder__oxpaid->value) );
    	return $bRet;
    }
}