[{*--
  * SUMMARY OF V6C MODS:
  *		Last based off: v4.6.5 - layout/footer.tpl->footer_deliveryinfo
  *		Logic to show tax note based only on whether or not tax is enabled.
  *		Tax note not longer a link to content
--*}]
                        <div class="deliveryinfo">
                            [{if !$oViewConf->v6cIsTaxOff()}][{ oxmultilang ident="FOOTER_INCLTAXANDPLUSSHIPPING" }][{/if}]
                        </div>