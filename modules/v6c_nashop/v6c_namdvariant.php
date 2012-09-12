<?php
/**
*    The 6vCommerce NA-Shop Module Support Package is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    The 6vCommerce NA-Shop Module Support Package is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with the 6vCommerce NA-Shop Module Support Package.  If not, see <http://www.gnu.org/licenses/>.
*
* @link      http://www.6vcommerce.ca
* @copyright (C) 6vCommerce
*/

/**
 * This class extends the oxMdVariant core class and should be configured in the
 * module extension settings of admin as given below.
 *
 * 		oxmdvariant => v6c_nashop/v6c_namdvariant
 */
class v6c_naMdVariant extends v6c_naMdVariant_parent
{
	/////////////////////// OVERRIDES ////////////////////////////

    /**
     * Same as parent except for mod given in code below.  Adapted
     * to more generic currency formatting.
     *
     * @return string
     */
    public function getFPrice()
    {
        $myConfig = $this->getConfig();
        // 0002030 No need to return price if it disabled for better performance.
        if ( !$myConfig->getConfigParam( 'bl_perfLoadPrice' ) ) {
            return;
        }

        if ($this->_sFPrice)
            return $this->_sFPrice;

        $sFromPrefix = '';

        if (!$this->_isFixedPrice()) {
            $sFromPrefix = oxLang::getInstance()->translateString('priceFrom') . ' ';
        }

        $dMinPrice = $this->getMinDPrice();
        $sFMinPrice = oxLang::getInstance()->formatCurrency( $dMinPrice );
        // BEGIN MOD
        $this->_sFPrice = $sFromPrefix . $sFMinPrice;
        // END MOD

        return $this->_sFPrice;
    }

	/////////////////////// EXTENSIONS ////////////////////////////

	/////////////////////// ADDITIONS ////////////////////////////
}