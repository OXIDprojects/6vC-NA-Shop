[{*-- 
  * TODO: override oxemail::setAltBody to clean-up smarty output
  * SUMMARY OF V6C_NA MODS:
  *		Remove all occurences of currency sign: $currency->sign
  *		Remove VAT info from article list
  *		Apply same mods to price summary section as done in basketcontents.tpl for order page.
  *		Replace local address layout with address widgets.
  *		Move user VAT/Tax ID to after address info
  *		Corrected misuse of getFVoucherDiscountValue in condition requiring unformatted value.
--*}]

[{ assign var="shop"      value=$oEmailView->getShop() }]
[{ assign var="oViewConf" value=$oEmailView->getViewConfig() }]
[{ assign var="currency"  value=$oEmailView->getCurrency() }]
[{ assign var="user"      value=$oEmailView->getUser() }]
[{ assign var="oDelSet"   value=$order->getDelSet() }]
[{ assign var="basket"    value=$order->getBasket() }]
[{ assign var="payment"   value=$order->getPayment() }]
[{ assign var="sOrderId"   value=$order->getId() }]
[{ assign var="oOrderFileList"   value=$oEmailView->getOrderFileList($sOrderId) }]

[{block name="email_plain_order_cust_orderemail"}]
[{if $payment->oxuserpayments__oxpaymentsid->value == "oxempty"}]
[{oxcontent ident="oxuserordernpplainemail"}]
[{else}]
[{oxcontent ident="oxuserorderplainemail"}]
[{/if}]
[{/block}]

[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_ORDERNOMBER" }] [{ $order->oxorder__oxordernr->value }]

[{block name="email_plain_order_cust_voucherdiscount"}]
[{if $oViewConf->getShowVouchers() }]
[{ foreach from=$order->getVoucherList() item=voucher}]
[{ assign var="voucherseries" value=$voucher->getSerie() }]
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_USEDCOUPONS" }] [{$voucher->oxvouchers__oxvouchernr->value}] - [{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_DICOUNT" }] [{$voucherseries->oxvoucherseries__oxdiscount->value}] [{ if $voucherseries->oxvoucherseries__oxdiscounttype->value == "absolute"}][{ $currency->sign}][{else}]%[{/if}]
[{/foreach }]
[{/if}]
[{/block}]

[{assign var="basketitemlist" value=$basket->getBasketArticles() }]
[{foreach key=basketindex from=$basket->getContents() item=basketitem}]
[{block name="email_plain_order_cust_basketitem"}]
[{assign var="basketproduct" value=$basketitemlist.$basketindex }]
[{ $basketproduct->oxarticles__oxtitle->getRawValue()|strip_tags }][{ if $basketproduct->oxarticles__oxvarselect->value}], [{ $basketproduct->oxarticles__oxvarselect->value}][{/if}]
[{ if $basketitem->getChosenSelList() }][{foreach from=$basketitem->getChosenSelList() item=oList}][{ $oList->name }] [{ $oList->value }][{/foreach}][{/if}]
[{ if $basketitem->getPersParams() }][{foreach key=sVar from=$basketitem->getPersParams() item=aParam}][{$sVar}] : [{$aParam}][{/foreach}][{/if}]
[{if $oViewConf->getShowGiftWrapping() }]
[{assign var="oWrapping" value=$basketitem->getWrapping() }]
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_WRAPPING" }] [{ if !$basketitem->getWrappingId() }][{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_NONE" }][{else}][{$oWrapping->oxwrapping__oxname->value}][{/if}]
[{/if}]
[{ if $basketproduct->oxarticles__oxorderinfo->value }][{ $basketproduct->oxarticles__oxorderinfo->getRawValue() }][{/if}]
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_UNITPRICE" }] [{ $basketitem->getFUnitPrice() }] [{ $currency->name}]
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_QUANTITY" }] [{$basketitem->getAmount()}]
[{* oxmultilang ident="EMAIL_ORDER_CUST_HTML_VAT" }] [{$basketitem->getVatPercent() }]%*}]
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_TOTAL" }] [{ $basketitem->getFTotalPrice() }] [{ $currency->name}]
[{/block}]
[{/foreach}]
------------------------------------------------------------------
[{* if !$basket->getDiscounts()}]
[{block name="email_plain_order_cust_nodiscounttotalnet"}]
*}][{* netto price *}][{*
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_TOTALNET" }] [{ $basket->getProductsNetPrice() }] [{ $currency->name}]
[{/block}]
[{block name="email_plain_order_cust_nodiscountproductvats"}]
*}][{* VATs *}][{*
[{foreach from=$basket->getProductVats() item=VATitem key=key}]
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_PLUSTAX1" }] [{ $key }][{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_PLUSTAX2" }] [{ $VATitem }] [{ $currency->name}]
[{/foreach}]
[{/block}]
[{/if*}]
[{block name="email_plain_order_cust_totalgross"}]
[{* brutto price *}]
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_TOTALGROSS" }] [{ $basket->getFProductsPrice() }] [{ $currency->name}]
[{/block}]
[{* applied discounts *}]
[{ if $basket->getDiscounts()}]
[{block name="email_plain_order_cust_discounts"}]
  [{foreach from=$basket->getDiscounts() item=oDiscount}]
  [{if $oDiscount->dDiscount < 0 }][{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_CHARGE" }][{else}][{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_DICOUNT" }][{/if}] [{ $oDiscount->sDiscount }]: [{if $oDiscount->dDiscount < 0 }][{ $oDiscount->fDiscount|replace:"-":"" }][{else}]-[{ $oDiscount->fDiscount }][{/if}] [{ $currency->name}]
  [{/foreach}]
[{/block}]
[{*block name="email_plain_order_cust_totalnet"}]
  *}][{* netto price *}][{*
  [{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_TOTALNET" }] [{ $basket->getProductsNetPrice() }] [{ $currency->name}]
[{/block}]
[{block name="email_plain_order_cust_productvats"}]
  *}][{* VATs *}][{*
  [{foreach from=$basket->getProductVats() item=VATitem key=key}]
    [{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_PLUSTAX1" }] [{ $key }][{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_PLUSTAX2" }] [{ $VATitem }] [{ $currency->name}]
  [{/foreach}]
[{/block*}]
[{/if}]
[{block name="email_plain_order_cust_voucherdiscount"}]
[{* voucher discounts *}]
[{if $oViewConf->getShowVouchers() && $basket->getVoucherDiscValue() }]
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_COUPON" }] [{ if $basket->getVoucherDiscValue() > 0 }]-[{/if}][{ $basket->getFVoucherDiscountValue()|replace:"-":"" }] [{ $currency->name}]
[{/if}]
[{/block}]
[{* gift card/wapping *}]
[{block name="email_plain_order_cust_giftwrapping"}]
[{ if $oViewConf->getShowGiftWrapping() && $basket->getFWrappingCosts() }]
[{block name="email_plain_order_cust_wrappingcosts"}]
  [{if $basket->getWrappCostVat()}]
    [{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_WRAPPINGNET" }][{ $basket->getWrappCostNet() }] [{ $currency->name}]
    [{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_PLUSTAX21" }] [{ $basket->getWrappCostVatPercent() }][{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_PLUSTAX22" }] [{ $basket->getWrappCostVat() }] [{ $currency->name}]
  [{/if}]
[{/block}]
[{block name="email_plain_order_cust_giftwrapping"}]
    [{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_WRAPPINGANDGREETINGCARD1" }][{if $basket->getWrappCostVat()}] [{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_WRAPPINGANDGREETINGCARD2" }][{/if}]: [{ $basket->getFWrappingCosts() }] [{ $currency->name}]
[{/if}]
[{/block}]
[{/block}]
[{block name="email_plain_order_cust_delcosts"}]
[{* delivery costs *}]
[{* delivery VAT (if available) *}]
[{if $basket->getDelCostVat() > 0}]
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_SHIPPINGNET" }] [{ $basket->getDelCostNet() }] [{ $currency->name}]
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_TAX1" }] [{ $basket->getDelCostVatPercent() }][{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_TAX2" }] [{ $basket->getDelCostVat() }] [{ $currency->name}]
[{/if}]
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_SHIPPINGGROSS1" }] [{if $basket->getDelCostVat() > 0}][{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_SHIPPINGGROSS2" }] [{/if}]: [{ $basket->getFDeliveryCosts() }] [{ $currency->name}]
[{/block}]
[{block name="email_plain_order_cust_paymentcosts"}]
[{* payment sum *}]
[{ if $basket->getPaymentCosts() }]
[{if $basket->getPaymentCosts() >= 0}][{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_PAYMENTCHARGEDISCOUNT1" }][{else}][{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_PAYMENTCHARGEDISCOUNT2" }][{/if}] [{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_PAYMENTCHARGEDISCOUNT3" }] [{ $basket->getPayCostNet() }] [{ $currency->name}]
[{* payment sum VAT (if available) *}]
  [{ if $basket->getDelCostVat() }]
  [{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_PAYMENTCHARGEVAT1" }] [{ $basket->getPayCostVatPercent()}][{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_PAYMENTCHARGEVAT2" }] [{ $basket->getPayCostVat() }] [{ $currency->name}]
  [{/if}]
[{/if}]
[{/block}]
[{block name="email_plain_order_cust_ts"}]
[{ if $basket->getTsProtectionCosts() }]
  [{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_TSPROTECTIONCHARGETAX1" }] [{ $basket->getTsProtectionVatPercent()}][{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_TSPROTECTIONCHARGETAX2" }] [{ $basket->getTsProtectionVat() }] [{ $currency->name}]
  [{ if $basket->getTsProtectionVat() }]
  [{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_TSPROTECTION" }] [{ $basket->getTsProtectionNet() }]
  [{/if}]
[{/if}]
[{/block}]

[{block name="v6c_email_plain_order_cust_nataxes"}]
[{* tax summary *}]
[{ if $oViewConf->v6cIsTaxOff() }]
[{ oxmultilang ident="V6C_EMAIL_ORDER_CUST_HTML_PRETAXTOTAL" }] [{ $basket->v6cGetFPriceNet() }] [{ $currency->name}]
[{if $oViewConf->v6cIsTaxLabelled() }]
[{foreach from=$basket->v6cGetBasketTaxes() item=sFTaxCost key=sTaxId }]
[{ oxmultilang ident="V6C_EMAIL_ORDER_CUST_HTML_ORDERTAX1" }][{$sTaxId}][{ oxmultilang ident="V6C_EMAIL_ORDER_CUST_HTML_ORDERTAX2" }] [{$sFTaxCost}] [{ $currency->name}]
[{/foreach}]
[{else}]
[{ oxmultilang ident="V6C_EMAIL_ORDER_CUST_HTML_ORDERTAX" }] [{ $basket->v6cGetFPriceTax() }] [{ $currency->name}]
[{/if}]
[{/if}]
[{/block}]

[{block name="email_plain_order_cust_grandtotal"}]
[{* grand total price *}]
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_GRANDTOTAL" }] [{ $basket->getFPrice() }] [{ $currency->name}]

[{if $basket->getCard() }]
    [{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_YOURGREETINGCARD" }]
    [{$basket->getCardMessage()}]
[{/if}]
[{/block}]

[{block name="email_plain_order_cust_userremark"}]
[{ if $order->oxorder__oxremark->value }]
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_YOURMESSAGE" }] [{ $order->oxorder__oxremark->getRawValue() }]
[{/if}]
[{/block}]

[{block name="email_plain_order_cust_download_link"}]
    [{ if $oOrderFileList }]
        [{ oxmultilang ident="MY_DOWNLOADS_DESC" }]
        [{foreach from=$oOrderFileList item="oOrderFile"}]
          [{if $order->oxorder__oxpaid->value || !$oOrderFile->oxorderfiles__oxpurchasedonly->value}]
            [{ oxgetseourl ident=$oViewConf->getSelfLink()|cat:"cl=download" params="sorderfileid="|cat:$oOrderFile->getId()}]
          [{else}]
            [{$oOrderFile->oxorderfiles__oxfilename->value}] [{ oxmultilang ident="DOWNLOADS_PAYMENT_PENDING" }]
          [{/if}]
        [{/foreach}]
    [{/if}]
[{/block}]

[{block name="email_plain_order_cust_paymentinfo"}]
[{if $payment->oxuserpayments__oxpaymentsid->value != "oxempty"}][{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_PAYMENTMETHOD" }] [{ $payment->oxpayments__oxdesc->getRawValue() }] [{ if $basket->getPaymentCosts() }]([{ $basket->getFPaymentCosts() }] [{ $currency->sign}])[{/if}]
[{/if}]
[{/block}]

[{block name="email_plain_order_cust_username"}]
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_EMAILADDRESS" }] [{ $user->oxuser__oxusername->value }]
[{/block}]

[{block name="email_plain_order_cust_address"}]
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_BILLINGADDRESS" }]
[{include file="widget/address/billing_address.tpl" v6c_oOrder=$order v6c_bNoEmail=true v6c_bPlainTxt=true}]
[{if $order->oxorder__oxbillustid->value}][{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_VATIDNOMBER" }] [{ $order->oxorder__oxbillustid->value }][{/if}]

[{ if $order->oxorder__oxdellname->value }][{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_SHIPPINGADDRESS" }]
[{include file="widget/address/shipping_address.tpl" v6c_oOrder=$order v6c_bNoEmail=true v6c_bPlainTxt=true}]
[{/if}]
[{/block}]

[{block name="email_plain_order_cust_deliveryinfo"}]
[{if $payment->oxuserpayments__oxpaymentsid->value != "oxempty"}][{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_SHIPPINGCARRIER" }] [{ $order->oDelSet->oxdeliveryset__oxtitle->getRawValue() }]
[{/if}]
[{/block}]

[{block name="email_plain_order_cust_paymentinfo"}]
[{if $payment->oxuserpayments__oxpaymentsid->value == "oxidpayadvance"}]
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_BANK" }] [{$shop->oxshops__oxbankname->getRawValue()}]<br>
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_ROUTINGNOMBER" }] [{$shop->oxshops__oxbankcode->value}]<br>
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_ACCOUNTNOMBER" }] [{$shop->oxshops__oxbanknumber->value}]<br>
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_BIC" }] [{$shop->oxshops__oxbiccode->value}]<br>
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_IBAN" }] [{$shop->oxshops__oxibannumber->value}]
[{/if}]
[{/block}]

[{block name="email_plain_order_cust_orderemailend"}]
[{ oxcontent ident="oxuserorderemailendplain" }]
[{/block}]

[{block name="email_plain_order_cust_tsinfo"}]
[{if $oViewConf->showTs("ORDEREMAIL") && $oViewConf->getTsId() }]
[{ oxmultilang ident="EMAIL_ORDER_CUST_HTML_TS_RATINGS_RATEUS" }]
[{ $oViewConf->getTsRatingUrl() }]
[{/if}]
[{/block}]

[{ oxcontent ident="oxemailfooterplain" }]
