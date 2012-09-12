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
 * This class extends the oxStrRegular core class and should be configured in the
 * module extension settings of admin as given below.
 *
 * 		oxstrregular => v6c_nashop/v6c_nastrregular
 */
class v6c_naStrRegular extends v6c_naStrRegular_parent
{
	/////////////////////// OVERRIDES ////////////////////////////

    /**
    * Remove undesired replacement of comma char (').
    *
     * BUG: #0003430
     * FIX: 4.6.1 revision 45706 and 4.5.11
    *
    * @param string $sStr      string to cleanup
    * @param object $sCleanChr which character should be used as a replacement (default is empty space)
    *
    * @return string
    */
    public function cleanStr( $sStr, $sCleanChr = ' ')
    {
        return $this->preg_replace( "/\"|\:|\!|\?|\n|\r|\t|\x95|\xa0|;/", $sCleanChr, $sStr );
    }
}