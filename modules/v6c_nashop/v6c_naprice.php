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
 * This class extends the oxPrice core class and should be configured in the
 * module extension settings of admin as given below.
 *
 * 	oxprice => v6c_nashop/v6c_naprice
 */
class v6c_naPrice extends v6c_naPrice_parent
{
    /**
     * Raw price
     *
     * @var double
     */
    protected $_dPrice = 0.0;

    /**
     * Raw price entering mode
     * This will override $_blNetPriceMode.
     * If enabled, tax (net/gross) price calculations will be turned off
     * unless explicitly turned on.
     *
     * @var boolean
     */
    protected $_blRawPriceMode;

    /**
    * Tax percentages array
    *
    * @var array
    */
    protected $_aTax = null;

    /**
    * Tax values array
    *
    * @var array
    */
    protected $_aTaxVals = null;

	/////////////////////// OVERRIDES ////////////////////////////

    /**
     * Adding support for multiple tax values.  Use of multiple tax values also
     * enforces netto mode (brutto mode could result in impossible solutions, ie.
     * tax values never sum up to yield brutto price).
     * If tax is disabled, does nothing.
     *
     * @param mixed $newVat vat percent or array of percents
     *
     * @return null
     */
    public function setVat($newVat)
    {
        if (!$this->_blRawPriceMode)
        {
            $this->_aTax = null;
            $this->_aTaxVals = null;
            if (is_array($newVat))
            {
                $this->_aTax = $newVat;
                $this->_recalculate(); // netto mode will get set via this call, as well as _dVat
            } else parent::setVat($dNewVat);
        }
    }

    /**
     * Overrides only if tax is disabled.
     * If tax is disabled, does nothing.
     *
     * @param double $newVat vat percent
     *
     * @return null
     */
    public function setUserVat($newVat)
    {
        if (!$this->_blRawPriceMode)
        {
            $this->_aTax = null;
            $this->_aTaxVals = null;
            parent::setUserVat($newVat);
        }
    }

    /**
     * Adding support to get individual tax percentages.
     * If tax is disabled, always returns zero.
     *
     * @param string $sTax tax name/label
     *
     * @return double
     */
    public function getVat($sTax = null)
    {
        if ($this->_blRawPriceMode) return doubleval(0);
        elseif (isset($sTax)) return array_key_exists($sTax, $this->_aTax) ? $this->_aTax[$sTax] : doubleval(0);
        else return parent::getVat();
    }

    /**
     * Sets raw price if $_blRawPriceMode is set, otherwise calls parent.
     * Does not support setting of multiple tax values.  Use setVat to
     * set multiple values.
     *
     * @param double $newPrice new price
     * @param double $dVat     (optional)
     *
     * @return null
     */
    public function setPrice($newPrice, $dVat = null)
    {
        if ($this->_blRawPriceMode)
        { $this->_dPrice = oxUtils::getInstance()->fRound( $newPrice ); }
        else
        {
            if (isset($dVat))
            {
                // Clear multi-tax if a single value is being set
                $this->_aTax = null;
                $this->_aTaxVals = null;
            }
            parent::setPrice($newPrice, $dVat);
        }
    }

    /**
     * Overrides only if $_blRawPriceMode is set
     * Returns raw price
     *
     * Note regarding original/parent method:
     * I think this is redundant.  rounding should have already occurred when price was set.
     *
     * @return double
     */
    public function getBruttoPrice()
    {
        if ($this->_blRawPriceMode)
        { return $this->_dPrice; }
        else
        { return parent::getBruttoPrice(); }
    }

    /**
     * Overrides only if $_blRawPriceMode is set
     * Returns raw price
     *
     * Note regarding original/parent method:
     * I think this is redundant.  rounding should have already occurred when price was set.
     *
     * @return double
     */
    public function getNettoPrice()
    {
        if ($this->_blRawPriceMode)
        { return $this->_dPrice; }
        else
        { return parent::getNettoPrice(); }
    }

    /**
     * Adding support to get individual tax values.
     * If tax is disabled, always returns zero.
     *
     * @param string $sTax tax name/label
     *
     * @return double
     */
    public function getVatValue($sTax = null)
    {
        if ($this->_blRawPriceMode) return doubleval(0);
        elseif (isset($sTax)) return array_key_exists($sTax, $this->$_aTaxVals) ? $this->$_aTaxVals[$sTax] : doubleval(0);
        else return parent::getVatValue();
    }

    /**
     * Overrides only if $_blRawPriceMode is set
     * Subtracts given percent from raw price
     *
     * @param double $dValue percent to subtract from price
     *
     * @return null
     */
    public function subtractPercent($dValue)
    {
        if ($this->_blRawPriceMode)
        {
        	$this->_dPrice = $this->_dPrice - self::percent($this->_dPrice, $dValue);
        	$this->_dPrice = oxUtils::getInstance()->fRound( $this->_dPrice );
        }
        else
        { parent::subtractPercent($dValue); }
    }

    /**
     * Overrides only if $_blRawPriceMode is set
     * Adds to raw price
     *
     * @param double $dValue value to add to price
     *
     * @return null
     */
    public function add($dValue)
    {
        if ($this->_blRawPriceMode)
        {
        	$this->_dPrice += $dValue;
        	$this->_dPrice = oxUtils::getInstance()->fRound( $this->_dPrice );
        }
        else
        { parent::add($dValue); }
    }

    /**
     * Overrides only if $_blRawPriceMode is set
     * Multiply raw price by given value
     *
     * @param double $dValue value for multipying price
     *
     * @return null
     */
    public function multiply($dValue)
    {
        if ($this->_blRawPriceMode)
        {
        	$this->_dPrice *= $dValue;
        	$this->_dPrice = oxUtils::getInstance()->fRound( $this->_dPrice );
        }
        else
        { parent::multiply($dValue); }
    }

    /**
     * Overrides only if $_blRawPriceMode is set
     * Divide raw price by given value
     *
     * @param double $dValue value for divideing price
     *
     * @return null
     */
    public function divide($dValue)
    {
        if ($this->_blRawPriceMode)
        {
        	$this->_dPrice /= $dValue;
        	$this->_dPrice = oxUtils::getInstance()->fRound( $this->_dPrice );
        }
        else
        { parent::divide($dValue); }
    }

    /**
    * Add support for multiple taxes.  See description of v6c_naPrice::setVat
    * for more info on the logic.  Also added logic to not process if price
    * is not set.
    *
    * @access protected
    *
    * @return null
    */
    protected function _recalculate()
    {
        // Ensure netto mode is set for multiple taxes
        if (isset($this->_aTax) && !$this->_blNetPriceMode) $this->setNettoPriceMode();

        if ( $this->_blNetPriceMode && $this->_dNetto != 0)
        {
            // check for multi-tax calc
            if (isset($this->_aTax)) $this->_v6cCalcMultiTaxes();
            // else do original calc
            else {
                $this->_dBrutto = self::netto2Brutto($this->_dNetto, $this->_dVat);
                $this->_dBrutto = oxUtils::getInstance()->fRound($this->_dBrutto);
            }
        // Adding zero value check for faster perf
        } elseif ( $this->_blNetPriceMode && $this->_dNetto == 0) {
            $this->_dBrutto = doubleval(0);
        // Original calc
        } elseif ($this->_dBrutto != 0) {
            $this->_dBrutto = oxUtils::getInstance()->fRound($this->_dBrutto);
            $this->_dNetto  = self::brutto2Netto($this->_dBrutto, $this->_dVat);
        // Added zero value case
        } else {
            $this->_dNetto = doubleval(0);
        }
    }

	/////////////////////// EXTENSIONS ////////////////////////////

    /**
     * Sets raw price mode then calls parent.
     *
     * @param double $dInitPrice given price
     *
     * @return oxPrice
     */
    public function __construct($dInitPrice = null)
    {
    	$this->_blRawPriceMode = $this->getConfig()->getConfigParam( 'v6c_blKillTax' );

    	parent::__construct($dInitPrice);
    }

	/////////////////////// ADDITTIONS ////////////////////////////

    /**
     * Set raw price mode.
     * Enabling tax (true) turns off raw price mode.
     *
     * @param bool $blTax enable tax
     *
     * @return null
     */
    public function v6cEnableTax($blTax = true)
    {
        // Only do something if setting is changing
    	if ((!$blTax) != $this->_blRawPriceMode)
    	{
    		$this->_blRawPriceMode = !$blTax;
    		if ($blTax)
    		{ $this->setPrice($this->_dPrice); }
    		else
    		{ $this->_dPrice = $this->_blNetPriceMode ? $this->_dNetto : $this->_dBrutto; }
    	}
    }

    /**
    * Checks if tax has been set
    *
    * @return bool
    */
    public function v6cIsTaxSet()
    {
        return (isset($this->_aTax) || $this->_dVat > 0 );
    }

    /**
     * Gets raw price
     *
     * @return double
     */
    //TODO: add prefix!
    public function getPrice()
    {
        if ($this->_blRawPriceMode)
        { return $this->_dPrice; }
        else
        { return $this->_blNetPriceMode ? $this->_dNetto : $this->_dBrutto; }
    }

    /**
    * Gets all taxes in array form.
    *
    * @return array
    */
    public function v6cGetTaxes()
    {
        if (isset($this->_aTax)) return $this->_aTax;
        else return array($this->_dVat);
    }

    /**
    * Gets all tax values in array form.
    *
    * @return array
    */
    public function v6cGetTaxValues()
    {
        if (isset($this->_aTaxVals)) return $this->_aTaxVals;
        else return array($this->getVatValue());
    }

    /**
    * Generally, this should not be needed because it is generated after each
    * recalc.  However, providing it to support old tax method where a sinlge
    * value is used for tax, but the individual tax amounts are still desired,
    * for example, to display on receipt.
    *
    * @param array $aTaxVals array of tax values
    */
    public function v6cSetTaxValues($aTaxVals)
    {
        $this->_aTaxVals = $aTaxVals;
    }

    /**
    * Performs calulations neccessary when using multiple taxes.  Calcs gross price
    * from net price as well as individual tax costs.
    */
    protected function _v6cCalcMultiTaxes()
    {
        $this->_aTaxVals = array();
        $dPrice = $this->_dNetto;
        // Each tax value must be rounded
        foreach ($this->_aTax as $sKey => $dTax)
        {
            $this->_aTaxVals[$sKey] = oxUtils::getInstance()->fRound( self::percent($this->_dNetto, $dTax) );
            $dPrice += $this->_aTaxVals[$sKey];
        }

        $this->_dBrutto = $dPrice;

        /*
        * _dVat must be set after calculation because
        * 		round(price*(1+tax1/100)) + round(price*(1+tax2/100))
        * does not neccessarily equal
        * 		round(price*(1+tax1/100+tax2/100)
        * That is, we can't just sum up the tax values to get the total tax.
        */
        if ($this->getNettoPrice() > 0) $this->_dVat = $this->getVatValue() / $this->getNettoPrice() * 100;
    }
}