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
 * This class extends the oxPayment core class and should be configured in the
 * module extension settings of admin as given below.
 *
 * 		oxutils => v6c_nashop/v6c_nautils
 */
class v6c_naUtils extends v6c_naUtils_parent
{
	/////////////////////// OVERRIDES ////////////////////////////

    /**
     * Same as parent except for mod given in code below.  Adapted
     * to more generic currency formatting.
     *
     * @param array  $aName Initial array of strings
     * @param double $dVat  Article VAT
     *
     * @return string
     */
    protected function _fillExplodeArray( $aName, $dVat = null)
    {
        $myConfig = $this->getConfig();
        $oObject = new oxStdClass();
        $aPrice = explode( '!P!', $aName[0]);

        if ( ( $myConfig->getConfigParam( 'bl_perfLoadSelectLists' ) && $myConfig->getConfigParam( 'bl_perfUseSelectlistPrice' ) && isset( $aPrice[0] ) && isset( $aPrice[1] ) ) || $this->isAdmin() ) {

            // yes, price is there
            $oObject->price = isset( $aPrice[1] ) ? $aPrice[1] : 0;
            $aName[0] = isset( $aPrice[0] ) ? $aPrice[0] : '';

            $iPercPos = getStr()->strpos( $oObject->price, '%' );
            if ( $iPercPos !== false ) {
                $oObject->priceUnit = '%';
                $oObject->fprice = $oObject->price;
                $oObject->price  = substr( $oObject->price, 0, $iPercPos );
            } else {
                $oCur = $myConfig->getActShopCurrencyObject();
                $oObject->price = str_replace(',', '.', $oObject->price);
                $oObject->fprice = oxLang::getInstance()->formatCurrency( $oObject->price  * $oCur->rate, $oCur);
                $oObject->priceUnit = 'abs';
            }

            // add price info into list
            if ( !$this->isAdmin() && $oObject->price != 0 ) {
                $aName[0] .= " ";
                if ( $oObject->price > 0 ) {
                    $aName[0] .= "+";
                }
                //V FS#2616
                if ( $dVat != null && $oObject->priceUnit == 'abs' ) {
                    $oPrice = oxNew('oxPrice');
                    $oPrice->setPrice($oObject->price, $dVat);
                    $aName[0] .= oxLang::getInstance()->formatCurrency( $oPrice->getBruttoPrice() * $oCur->rate, $oCur);
                } else {
                    $aName[0] .= $oObject->fprice;
                }
                // MOD BEGINS/ENDS: CODE REMOVED HERE
            }
        } elseif ( isset( $aPrice[0] ) && isset($aPrice[1] ) ) {
            // A. removing unused part of information
            $aName[0] = getStr()->preg_replace( "/!P!.*/", "", $aName[0] );
        }

        $oObject->name  = $aName[0];
        $oObject->value = $aName[1];
        return $oObject;
    }


	/////////////////////// EXTENSIONS ////////////////////////////


	/////////////////////// ADDITIONS ////////////////////////////

}