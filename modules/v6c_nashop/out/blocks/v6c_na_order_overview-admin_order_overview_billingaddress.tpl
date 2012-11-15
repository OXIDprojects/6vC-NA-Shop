[{*--
  * SUMMARY OF V6C MODS:
  *		Last based off: v4.5.6 - out/admin/tpl/order_overview.tpl->admin_order_overview_billingaddress
  *		[M1] Change address layout to NA standard.
--*}]
                <b>[{ oxmultilang ident="GENERAL_BILLADDRESS" }]</b><br>
                <br>
                [{ if $edit->oxorder__oxbillcompany->value }][{ oxmultilang ident="GENERAL_COMPANY" }] [{$edit->oxorder__oxbillcompany->value }]<br>[{/if}]
                [{ if $edit->oxorder__oxbilladdinfo->value }][{$edit->oxorder__oxbilladdinfo->value }]<br>[{/if}]
                [{$edit->oxorder__oxbillsal->value|oxmultilangsal}] [{$edit->oxorder__oxbillfname->value }] [{$edit->oxorder__oxbilllname->value }]<br>
                [{*--BGN M1--*}]
                [{$edit->oxorder__oxbillstreetnr->value }] [{$edit->oxorder__oxbillstreet->value }]<br>
	            [{$edit->oxorder__oxbillcity->value }], [{$edit->oxorder__oxbillstateid->value}] [{$edit->oxorder__oxbillzip->value }]<br>
	            [{*--END M1--*}]
                [{$edit->oxorder__oxbillcountry->value }]<br>
                [{if $edit->oxorder__oxbillcompany->value && $edit->oxorder__oxbillustid->value }]
                    <br>
                    [{ oxmultilang ident="ORDER_OVERVIEW_VATID" }]
                    [{ $edit->oxorder__oxbillustid->value }]<br>
                [{/if}]
                <br>
                [{ oxmultilang ident="GENERAL_EMAIL" }]: <a href="mailto:[{$edit->oxorder__oxbillemail->value }]?subject=[{ $actshop}] - [{ oxmultilang ident="GENERAL_ORDERNUM" }] [{$edit->oxorder__oxordernr->value }]" class="edittext"><em>[{$edit->oxorder__oxbillemail->value }]</em></a><br>
                <br>