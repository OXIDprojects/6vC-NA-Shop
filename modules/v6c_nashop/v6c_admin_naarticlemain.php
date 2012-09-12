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
 * This class extends the article_main admin control class and should be configured in the
 * module extension settings of admin as given below.
 *
 * 		article_main => v6c_nashop/v6c_admin_naarticlemain
 */
class v6c_admin_naArticleMain extends v6c_admin_naArticleMain_parent
{
    /////////////////////// OVERRIDES ////////////////////////////


    /////////////////////// EXTENSIONS ////////////////////////////

    /**
    * Set no price alert field if configured as such
    *
    * @param array $aParams Parameters, to set default values
    *
    * @return array
    */
    public function addDefaultValues( $aParams )
    {
        $aParams = parent::addDefaultValues($aParams);

        if (oxConfig::getInstance()->getConfigParam( 'v6c_blDefaultNoPriceAlert' )) $aParams['oxarticles__oxblfixedprice'] = 1;

        return $aParams;
    }


    /////////////////////// ADDITIONS ////////////////////////////
}