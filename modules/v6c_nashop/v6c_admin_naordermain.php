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
 * This class extends the order_main admin control class and should be configured in the
 * module extension settings of admin as given below.
 *
 * 		order_main => v6c_nashop/v6c_admin_naordermain
 */
class v6c_admin_naOrderMain extends v6c_admin_naOrderMain_parent
{
	/////////////////////// OVERRIDES ////////////////////////////

	/**
	 * If order has already been paid, prevents any recalc.  Otherwise,
	 * just call parent and proceed with original code.  Avoiding recalc
	 * because it messes up the order if a chosen shiping or payment is
	 * no longer available.  Furthermore, once paid, the basket amount
	 * should not change.
	 *
	 * @return empty
	 */
	public function save()
	{
	    parent::save();

		// Load applicable order:

        $soxId = $this->getEditObjectId();
        $aParams    = oxConfig::getParameter( "editval" );

		// shopid
		$sShopID = oxSession::getVar( "actshop" );
		$aParams['oxorder__oxshopid'] = $sShopID;

		$bPaid = false;
        $oOrder = oxNew( "oxorder" );
        if ( $soxId != "-1") {
        	// determine of order has been paid
            if ( $oOrder->load( $soxId) && $oOrder->v6cIsPaid() )
            {
            	$bPaid = true;
            }
        } else {
            $aParams['oxorder__oxid'] = null;
        }

        // Break off to original parent if order not yet paid
		if (!$bPaid)
		{
			parent::save();
			return;
		}

		// Already paid, so just update parms:

        $oOrder->assign( $aParams);
        $oOrder->save();

	    // set oxid if inserted
        $this->setEditObjectId( $oOrder->getId() );
	}

	/**
	 * If order has already been paid, prevents any recalc.  Otherwise,
	 * just call parent and proceed with original code.  Avoiding recalc
	 * because it messes up the order if a chosen shiping or payment is
	 * no longer available.  Furthermore, once paid, the basket amount
	 * should not change.
	 *
	 * @return empty
	*
	* @return null
	*/
	public function changeDelSet()
	{
		$oOrder = oxNew( "oxorder" );
		if ( ($sDelSetId = oxConfig::getParameter("setDelSet")) && $oOrder->load( $this->getEditObjectId() ) )
		{
			if ($oOrder->v6cIsPaid())
			{
				// Do not bother with recalc
				$oOrder->setDelivery( $sDelSetId );
				$oOrder->save();
			} else {
				// Proceed with original code and recalc
				$oOrder->oxorder__oxpaymenttype->setValue( "oxempty" );
				// keeps old discount
				$oOrder->reloadDiscount( false );
				$oOrder->setDelivery( $sDelSetId );
				$oOrder->recalculateOrder();
			}
		}
	}

	/**
	 * If order has already been paid, prevents any recalc.  Otherwise,
	 * just call parent and proceed with original code.  Avoiding recalc
	 * because it messes up the order if a chosen shiping or payment is
	 * no longer available.  Furthermore, once paid, the basket amount
	 * should not change.
	 *
	 * @return empty
	 *
	 * @return null
	 */
	public function changePayment()
	{
		$oOrder = oxNew( "oxorder" );
		if ( ( $sPayId = oxConfig::getParameter( "setPayment") ) && $oOrder->load( $this->getEditObjectId() ) )
		{
			$oOrder->oxorder__oxpaymenttype->setValue( $sPayId );
			if ($oOrder->v6cIsPaid())
			{
				// Do not bother with recalc
				$oOrder->save();
			} else {
				// keeps old discount
				$oOrder->reloadDiscount( false );
				$oOrder->recalculateOrder();
			}
		}
	}

	/////////////////////// EXTENSIONS ////////////////////////////

	/**
	* Allow admin to choose from ANY shipping method, not just those
	* allowed to specific products.
	*
	* @return string
	*/
	public function render()
	{
	    $sRet = parent::render();
	    $this->_aViewData["oShipSet"] = oxDeliverySetList::getInstance()->getDeliverySetList(null, null);
	    return $sRet;
	}


	/////////////////////// ADDITIONS ////////////////////////////

}