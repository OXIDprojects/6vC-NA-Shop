[{*--
  * SUMMARY OF V6C MODS:
  *		Last based off: v4.5.6 - out/admin/tpl/order_overview.tpl->admin_order_overview_total
  *		[M1] Do not display article vats for NA orders
  *		[N1] Summarize tax(es) on total order price for NA orders
--*}]
                <tr>
                <td class="edittext" height="15">[{ oxmultilang ident="GENERAL_IBRUTTO" }]</td>
                <td class="edittext" align="right"><b>[{$edit->getFormattedTotalBrutSum()}]</b></td>
                <td class="edittext">&nbsp;<b>[{if $edit->oxorder__oxcurrency->value}] [{$edit->oxorder__oxcurrency->value}] [{else}] [{ $currency->name}] [{/if}]</b></td>
                </tr>
                <tr>
                <td class="edittext" height="15">[{ oxmultilang ident="GENERAL_DISCOUNT" }]&nbsp;&nbsp;</td>
                <td class="edittext" align="right"><b>- [{$edit->getFormattedDiscount()}]</b></td>
                <td class="edittext">&nbsp;<b>[{if $edit->oxorder__oxcurrency->value}] [{$edit->oxorder__oxcurrency->value}] [{else}] [{ $currency->name}] [{/if}]</b></td>
                </tr>
[{*--BGN M1--*}]
                [{if !$edit->v6cIsTaxGlobal() }]
                <tr>
                <td class="edittext" height="15">[{ oxmultilang ident="GENERAL_INETTO" }]</td>
                <td class="edittext" align="right"><b>[{$edit->getFormattedTotalNetSum()}]</b></td>
                <td class="edittext">&nbsp;<b>[{if $edit->oxorder__oxcurrency->value}] [{$edit->oxorder__oxcurrency->value}] [{else}] [{ $currency->name}] [{/if}]</b></td>
                </tr>
                [{foreach key=iVat from=$aProductVats item=dVatPrice}]
                <tr>
                <td class="edittext" height="15">[{ oxmultilang ident="GENERAL_IVAT" }] ([{ $iVat }]%)</td>
                <td class="edittext" align="right"><b>[{ $dVatPrice }]</b></td>
                <td class="edittext">&nbsp;<b>[{if $edit->oxorder__oxcurrency->value}] [{$edit->oxorder__oxcurrency->value}] [{else}] [{ $currency->name}] [{/if}]</b></td>
                </tr>
                [{/foreach}]
                [{/if}]
[{*--END M1--*}]
                [{if $edit->oxorder__oxvoucherdiscount->value}]
                <tr>
                <td class="edittext" height="15">[{ oxmultilang ident="GENERAL_VOUCHERS" }]</td>
                <td class="edittext" align="right"><b>- [{$edit->getFormattedTotalVouchers()}]</b></td>
                <td class="edittext">&nbsp;<b>[{if $edit->oxorder__oxcurrency->value}] [{$edit->oxorder__oxcurrency->value}] [{else}] [{ $currency->name}] [{/if}]</b></td>
                </tr>
                [{/if}]
                <tr>
                <td class="edittext" height="15">[{ oxmultilang ident="GENERAL_DELIVERYCOST" }]&nbsp;&nbsp;</td>
                <td class="edittext" align="right"><b>[{$edit->getFormattedeliveryCost()}]</b></td>
                <td class="edittext">&nbsp;<b>[{if $edit->oxorder__oxcurrency->value}] [{$edit->oxorder__oxcurrency->value}] [{else}] [{ $currency->name}] [{/if}]</b></td>
                </tr>
                <tr>
                <td class="edittext" height="15">[{ oxmultilang ident="GENERAL_PAYCOST" }]&nbsp;&nbsp;</td>
                <td class="edittext" align="right"><b>[{$edit->getFormattedPayCost()}]</b></td>
                <td class="edittext">&nbsp;<b>[{if $edit->oxorder__oxcurrency->value}] [{$edit->oxorder__oxcurrency->value}] [{else}] [{ $currency->name}] [{/if}]</b></td>
                </tr>
                [{if $edit->oxorder__oxwrapcost->value }]
                <tr>
                <td class="edittext" height="15">[{ oxmultilang ident="GENERAL_CARD" }]&nbsp;[{if $giftCard}]([{$giftCard->oxwrapping__oxname->value}])[{/if}]&nbsp;</td>
                <td class="edittext" align="right"><b>[{ $edit->getFormattedWrapCost() }]</b></td>
                <td class="edittext">&nbsp;<b>[{if $edit->oxorder__oxcurrency->value}] [{$edit->oxorder__oxcurrency->value}] [{else}] [{ $currency->name}] [{/if}]</b></td>
                </tr>
                [{/if}]
                [{if $edit->oxorder__oxtsprotectid->value }]
                <tr>
                <td class="edittext" height="15">[{ oxmultilang ident=ORDER_OVERVIEW_PROTECTION }]&nbsp;</td>
                <td class="edittext" align="right"><b>[{ $tsprotectcosts }]</b></td>
                <td class="edittext">&nbsp;<b>[{if $edit->oxorder__oxcurrency->value}] [{$edit->oxorder__oxcurrency->value}] [{else}] [{ $currency->name}] [{/if}]</b></td>
                </tr>
                [{/if}]
[{*--BGN N1--*}]
	            [{if $edit->v6cIsTaxGlobal() }]
	            [{foreach key=iVat from=$aProductVats item=dVatPrice}]
	            <tr>
	            <td class="edittext" height="15">[{ oxmultilang ident="GENERAL_IVAT" }] ([{ $iVat }]%)</td>
	            <td class="edittext" align="right"><b>[{ $dVatPrice }]</b></td>
	            <td class="edittext">&nbsp;<b>[{if $edit->oxorder__oxcurrency->value}] [{$edit->oxorder__oxcurrency->value}] [{else}] [{ $currency->name}] [{/if}]</b></td>
	            </tr>
	            [{/foreach}]
	            [{/if}]
[{*--END N1--*}]
                <tr>
                <td class="edittext" height="25">[{ oxmultilang ident="GENERAL_SUMTOTAL" }]&nbsp;&nbsp;</td>
                <td class="edittext" align="right"><b>[{ $edit->getFormattedTotalOrderSum() }]</b></td>
                <td class="edittext">&nbsp;<b>[{if $edit->oxorder__oxcurrency->value}] [{$edit->oxorder__oxcurrency->value}] [{else}] [{ $currency->name}] [{/if}]</b></td>
                </tr>