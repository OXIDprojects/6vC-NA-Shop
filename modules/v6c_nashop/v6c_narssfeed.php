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
 * This class extends the oxRssFeed core class and should be configured in the
 * module extension settings of admin as given below.
 *
 * 		oxrssfeed => v6c_nashop/v6c_narssfeed
 */
class v6c_naRssFeed extends v6c_naRssFeed_parent
{
	/////////////////////// OVERRIDES ////////////////////////////

    /**
     * Same as parent except for mod noted in code.  Adapted to more
     * generic curreny formatting.
     *
     * @param oxArticleList $oList article list
     *
     * @access protected
     * @return array
     */
    protected function _getArticleItems(oxArticleList $oList)
    {
        $myUtilsUrl = oxUtilsUrl::getInstance();
        $aItems = array();
        $oLang = oxLang::getInstance();
        $oStr  = getStr();

        foreach ($oList as $oArticle) {
            $oItem = new oxStdClass();
            $oActCur = $this->getConfig()->getActShopCurrencyObject();
            $sPrice = '';
            if ( $oPrice = $oArticle->getPrice() ) {
            	// BEGIN MOD
                $sPrice =  " " . $oArticle->getPriceFromPrefix().$oLang->formatCurrency( $oPrice->getBruttoPrice(), $oActCur );
                // END MOD
            }
            $oItem->title                   = strip_tags($oArticle->oxarticles__oxtitle->value . $sPrice);
            $oItem->guid     = $oItem->link = $myUtilsUrl->prepareUrlForNoSession($oArticle->getLink());
            $oItem->isGuidPermalink         = true;
            //$oItem->description             = $oArticle->getArticleLongDesc()->value; //oxarticles__oxshortdesc->value;
            if ( oxConfig::getInstance()->getConfigParam( 'bl_perfParseLongDescinSmarty' ) ) {
                $oItem->description         = $oArticle->getLongDesc();
            } else {
                $oItem->description         = $oArticle->getArticleLongDesc()->value;//$oArticle->getLongDescription()->value;
            }

            if (trim(str_replace('&nbsp;', '', (strip_tags($oItem->description)))) == '') {
                $oItem->description             = $oArticle->oxarticles__oxshortdesc->value;
            }

            $oItem->description = trim($oItem->description);
            if ($sIcon = $oArticle->getIconUrl()) {
                $oItem->description = "<img src='$sIcon' border=0 align='left' hspace=5>".$oItem->description;
            }
            $oItem->description = $oStr->htmlspecialchars( $oItem->description );

            $aItems[] = $oItem;
        }
        return $aItems;
    }


	/////////////////////// EXTENSIONS ////////////////////////////

	/////////////////////// ADDITIONS ////////////////////////////
}