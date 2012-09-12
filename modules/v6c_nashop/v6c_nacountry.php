<?php
/**
*    This file is part of the 6vCommerce NA-Shop Module Support Package.
*
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
 * This class extends the oxCountry core class and should be configured in the
 * module extension settings of admin as given below.
 *
 * 		oxcountry => v6c_nashop/v6c_nacountry
 */
class v6c_naCountry extends v6c_naCountry_parent
{
	/////////////////////// OVERRIDES ////////////////////////////

    /**
     * Returns current ordered state list, overiding the non-ordered parent method.
     * Mods are noted in code.
     *
     * @return array
     */
    public function getStates()
    {
        if (!is_null($this->_aStates))
        return $this->_aStates;

        $sCountryId = $this->getId();
        $sViewName = getViewName( "oxstates", $this->getLanguage() );
        // BEGIN V6C MODS
        $sQ = "select * from {$sViewName} where oxcountryid = '$sCountryId' order by oxid asc ";
        // END MODS
        $this->_aStates = oxNew("oxlist");
        $this->_aStates->init("oxstate");
        $this->_aStates->selectString($sQ);

        return $this->_aStates;
    }


	/////////////////////// EXTENSIONS ////////////////////////////

	/////////////////////// ADDITIONS ////////////////////////////

    /**
     * Load country object by 3-letter ISO.  Returns success result.
     *
     * @param string $sIso 3-letter country ISO code
     *
     * @return bool
     */
    public function v6cLoadByIso3($sIso)
    {
    	return $this->assignRecord("select * from oxcountry where oxisoalpha3 = '$sIso'");
    }
}