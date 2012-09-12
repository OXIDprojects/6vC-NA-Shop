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
 * This class extends the oxLang core class and should be configured in the
 * module extension settings of admin as given below.
 *
 * 	oxlang => v6c_nashop/v6c_nalang
 *
 * NOTE: If you do not see the affect of this extension or it stops working
 * after some site interaction (particularly when accessing the Admin backend)
 * append the following code to the config.inc.php file:
 *
 *   include getShopBasePath (). 'core/oxconfk.php' ;
 *   $this -> _loadVarsFromDb ( $this -> getShopId (), array( 'aModules' ) );
 *
 * For more details see http://www.oxid-esales.com/forum/showthread.php?t=6604#post39644
 */
class v6c_naLang extends v6c_naLang_parent
{
	/////////////////////// OVERRIDES ////////////////////////////

    /**
     * OVERRIDES PARENT
     * Same function as parent with the following additions:
     * - Returned string will have currency symbol prefixed to currency value.
     * - Added argument to allow formatting w/ or w/o currency sign.
     *
     * @param double $dValue  Plain price
     * @param object $oActCur Object of active currency
     * @param bool $bNoSign Flag for no currency symbol
     *
     * @return string
     */
    public function formatCurrency( $dValue, $oActCur = null, $bNoSign = false )
    {
        // Do not show zero values
        if ( $dValue == 0 && $this->getConfig()->getConfigParam('v6c_bHideZeroCost') ) return '';

        if ( !$oActCur ) {
            $oActCur = $this->getConfig()->getActShopCurrencyObject();
        }
        $sRet = number_format( (double)$dValue, $oActCur->decimal, $oActCur->dec, $oActCur->thousand );
        if (!$bNoSign)
        {
        	if ($this->getConfig()->getConfigParam( 'v6c_blPrefixCurrencySign' ))
        	{ $sRet = $oActCur->sign . $sRet; }
        	else
        	{ $sRet =  $sRet . $oActCur->sign; }
        }

        return $sRet;
    }
}