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
 * Metadata version
 */
$sMetadataVersion = '1.0';

/**
 * Module information
 */
$aModule = array(
    'id'	            => 'v6c_nashop',
    'title'             => '6vC NA-Shop',
    'description'       => 'Applies localization to shop (currency, address, etc.) for use in countries such as USA, Canada, Australia, and New Zealand.',
    'thumbnail'         => 'logo-sqr.png',
    'version'           => '1.2.0',
    'author'            => '6vCommerce',
    'url'		        => 'http://www.6vcommerce.ca',
    'email'				=> 'info@6vcommerce.ca',
    'extend'            => array(
        'oxbasket' => 'v6c_nashop/v6c_nabasket',
        'oxcountry' => 'v6c_nashop/v6c_nacountry',
        'oxinputvalidator' => 'v6c_nashop/v6c_nainputvalidator',
        'oxlang' => 'v6c_nashop/v6c_nalang',
        'oxmdvariant' => 'v6c_nashop/v6c_namdvariant',
        'oxorder' => 'v6c_nashop/v6c_naorder',
        'oxprice' => 'v6c_nashop/v6c_naprice',
        'oxrssfeed' => 'v6c_nashop/v6c_narssfeed',
        'oxvatselector' => 'v6c_nashop/v6c_nataxselector',
        'oxutils' => 'v6c_nashop/v6c_nautils',
        'oxviewconfig' => 'v6c_nashop/v6c_naviewconfig',
        'oxvoucherserie' => 'v6c_nashop/v6c_navoucherseries',
    ),
    'files' => array(
        'v6c_BaseList' => 'v6c_nashop/admin/v6c_baselist.php',
    	'v6c_naShop' => 'v6c_nashop/admin/v6c_nashop.php',
    	'v6c_naShopList' => 'v6c_nashop/admin/v6c_nashoplist.php',
    	'v6c_naShopMain' => 'v6c_nashop/admin/v6c_nashopmain.php',
    ),
    'blocks' => array(
        array('template' => 'layout/base.tpl', 'block'=>'base_style', 'file'=>'v6c_na_base_style.tpl'),
        array('template' => 'layout/sidebar.tpl', 'block'=>'sidebar_trustedshopsratings', 'file'=>'v6c_na_rmblock.tpl'),
        array('template' => 'layout/sidebar.tpl', 'block'=>'sidebar_partners', 'file'=>'v6c_na_rmblock.tpl'),
        array('template' => 'layout/sidebar.tpl', 'block'=>'sidebar_shopluperatings', 'file'=>'v6c_na_rmblock.tpl'),
        array('template' => 'page/checkout/inc/basketcontents.tpl', 'block'=>'checkout_basketcontents_basketitem_vat', 'file'=>'v6c_na_rmblock.tpl'),
        array('template' => 'page/checkout/inc/basketcontents.tpl', 'block'=>'checkout_basketcontents_giftwrapping', 'file'=>'v6c_na_rmblock.tpl'),
        array('template' => 'order_overview.tpl', 'block'=>'admin_order_overview_billingaddress', 'file'=>'v6c_na_order_overview-admin_order_overview_billingaddress.tpl'),
        array('template' => 'order_overview.tpl', 'block'=>'admin_order_overview_deliveryaddress', 'file'=>'v6c_na_order_overview-admin_order_overview_deliveryaddress.tpl'),
        array('template' => 'order_overview.tpl', 'block'=>'admin_order_overview_deliveryaddress', 'file'=>'v6c_na_order_overview-admin_order_overview_total.tpl'),
        array('template' => 'layout/footer.tpl', 'block'=>'footer_deliveryinfo', 'file'=>'v6c_na_footer-footer_deliveryinfo.tpl'),
        // Remove currency signs:
        array('template' => 'widget/minibasket/minibasket.tpl', 'block'=>'v6c_pl_minibasket_03', 'file'=>'v6c_na_rmblock.tpl'),
        array('template' => 'widget/minibasket/minibasket.tpl', 'block'=>'v6c_pl_minibasket_04', 'file'=>'v6c_na_rmblock.tpl'),
    ),
    'templates' => array(
    	'v6c_container.tpl' => 'v6c_nashop/out/admin/tpl/v6c_container.tpl',
    	'v6c_list.tpl' => 'v6c_nashop/out/admin/tpl/v6c_list.tpl',
    	'v6c_nashop_main.tpl' => 'v6c_nashop/out/admin/tpl/v6c_nashop_main.tpl',
    ),
);

/**
* External dependencies
*
* 	out/azure/en/map.php
* 	out/azure/fr/map.php
* 	out/v6z_azure
*/