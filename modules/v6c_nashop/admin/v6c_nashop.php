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

/*
 * Based off of shop.php.  Use that file as a basis for merging diffs for updates.
 */

/**
 * Admin shop manager.
 * Returns template, that arranges two other templates ("v6c_list.tpl"
 * and "v6c_nashop_main.tpl") to frame.
 * Admin Menu: 6vC Modules -> North America Shop.
 * @package admin
 */
class v6c_naShop extends oxAdminView
{
    /**
     * Executes parent method parent::render() and returns name of template
     * file "shop.tpl".
     *
     * @return string
     */
    public function render()
    {
        parent::render();

            $sCurrentAdminShop = oxSession::getVar("currentadminshop");

            if (!$sCurrentAdminShop) {
                if (oxSession::getVar( "malladmin"))
                    $sCurrentAdminShop = "oxbaseshop";
                else
                    $sCurrentAdminShop = oxSession::getVar( "actshop");
            }

            $this->_aViewData["currentadminshop"] = $sCurrentAdminShop;
            oxSession::setVar("currentadminshop", $sCurrentAdminShop);


        return "v6c_container.tpl";
    }
}
