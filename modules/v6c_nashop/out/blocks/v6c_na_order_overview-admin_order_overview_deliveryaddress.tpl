[{*--
  * SUMMARY OF V6C MODS:
  *		Last based off: v4.5.6 - out/admin/tpl/order_overview.tpl->admin_order_overview_deliveryaddress
  *		[M1] Change address layout to NA standard.
--*}]
                    <b>[{ oxmultilang ident="GENERAL_DELIVERYADDRESS" }]:</b><br>
                    <br>
                    [{ if $edit->oxorder__oxdelcompany->value }]Firma [{$edit->oxorder__oxdelcompany->value }]<br>[{/if}]
                    [{ if $edit->oxorder__oxdeladdinfo->value }][{$edit->oxorder__oxdeladdinfo->value }]<br>[{/if}]
                    [{$edit->oxorder__oxdelsal->value|oxmultilangsal }] [{$edit->oxorder__oxdelfname->value }] [{$edit->oxorder__oxdellname->value }]<br>
		            [{*--BGN M1--*}]
                    [{$edit->oxorder__oxdelstreetnr->value }] [{$edit->oxorder__oxdelstreet->value }]<br>
		            [{$edit->oxorder__oxdelcity->value }], [{$edit->oxorder__oxdelstateid->value}] [{$edit->oxorder__oxdelzip->value }]<br>
		            [{*--END M1--*}]
                    [{$edit->oxorder__oxdelcountry->value }]<br>
                    <br>