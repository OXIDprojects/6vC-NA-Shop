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
 * This class extends the oxInputValidator core class and should be configured in the
 * module extension settings of admin as given below.
 *
 * 		oxinputvalidator => v6c_nashop/v6c_nainputvalidator
 */
class v6c_naInputValidator extends v6c_naInputValidator_parent
{

	/////////////////////// OVERRIDES ////////////////////////////

    /**
     * Making state checking conditional upon whether or not there
     * are any states defined for the country.  Country field must
     * be supplied for extra check to be performed.  Changes to
     * original code are noted inside function.
     *
     * @param oxuser $oUser       active user
     * @param array  $aInvAddress billing address
     * @param array  $aDelAddress delivery address
     *
     * @return null
     */
    public function checkRequiredFields( $oUser, $aInvAddress, $aDelAddress )
    {
        // collecting info about required fields
        $aMustFields = array( 'oxuser__oxfname',
                              'oxuser__oxlname',
                              'oxuser__oxstreetnr',
                              'oxuser__oxstreet',
                              'oxuser__oxzip',
                              'oxuser__oxcity' );

        // config shoud override default fields
        $aMustFillFields = $this->getConfig()->getConfigParam( 'aMustFillFields' );
        if ( is_array( $aMustFillFields ) ) {
            $aMustFields = $aMustFillFields;
        }

        // assuring data to check
        $aInvAddress = is_array( $aInvAddress )?$aInvAddress:array();
        $aDelAddress = is_array( $aDelAddress )?$aDelAddress:array();

        // collecting fields
        $aFields = array_merge( $aInvAddress, $aDelAddress );


        // check delivery address ?
        $blCheckDel = false;
        if ( count( $aDelAddress ) ) {
            $blCheckDel = true;
        }

        // BEGIN V6C MODS
        if ( in_array('oxuser__oxstateid',$aMustFields) && isset($aFields['oxuser__oxcountryid']) )
        {
            $oCountry = oxNew( 'oxCountry' );
            if ( $oCountry->load($aFields['oxuser__oxcountryid']) )
            {
                if ( count($oCountry->getStates()) == 0 ) unset($aMustFields[array_search('oxuser__oxstateid', $aMustFields)]);
            }
        }
        if ($blCheckDel)
        {
            if ( in_array('oxaddress__oxstateid',$aMustFields) && isset($aFields['oxaddress__oxcountryid']) )
            {
                if ( $oCountry->load($aFields['oxaddress__oxcountryid']) )
                {
                    if ( count($oCountry->getStates()) == 0 ) unset($aMustFields[array_search('oxaddress__oxstateid', $aMustFields)]);
                }
            }
        }
        // END MODS

        // checking
        foreach ( $aMustFields as $sMustField ) {

            // A. not nice, but we keep all fields info in one config array, and must support baskwards compat.
            if ( !$blCheckDel && strpos( $sMustField, 'oxaddress__' ) === 0 ) {
                continue;
            }

            if ( isset( $aFields[$sMustField] ) && is_array( $aFields[$sMustField] ) ) {
                $this->checkRequiredArrayFields( $oUser, $sMustField, $aFields[$sMustField] );
            } elseif ( !isset( $aFields[$sMustField] ) || !trim( $aFields[$sMustField] ) ) {
                   $oEx = oxNew( 'oxInputException' );
                   $oEx->setMessage('EXCEPTION_INPUT_NOTALLFIELDS');

                   $this->_addValidationError( $sMustField, $oEx );
            }
        }
    }

	/////////////////////// EXTENSIONS ////////////////////////////


	/////////////////////// ADDITIONS ////////////////////////////

}