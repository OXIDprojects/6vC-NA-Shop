[{*--
  * SUMMARY OF V6C MODS:
  *		Last based off: v4.5.11 - page/checkout/inc/basketcontents.tpl->checkout_basketcontents_basketitem_quantity
  *		Old 4.5 mod kept incase 4.6 update does not fix bug.
  *		[M1] BUG: When non-editable, quantity displays twice for bundled products, corrected the logic for this.
--*}]
                        [{* product quantity manager *}]
                        <td class="quantity">
                            [{if $editable }]
                                <input type="hidden" name="aproducts[[{ $basketindex }]][aid]" value="[{ $basketitem->getProductId() }]">
                                <input type="hidden" name="aproducts[[{ $basketindex }]][basketitemid]" value="[{ $basketindex }]">
                                <input type="hidden" name="aproducts[[{ $basketindex }]][override]" value="1">
                                [{if $basketitem->isBundle() }]
                                    <input type="hidden" name="aproducts[[{ $basketindex }]][bundle]" value="1">
                                [{/if}]
[{*--BEGIN M1--*}]
                                [{if !($basketitem->isBundle() || $basketitem->isDiscountArticle())}]
[{*--END M1--*}]
                                    [{foreach key=sVar from=$basketitem->getPersParams() item=aParam }]
                                        <p><strong>[{ oxmultilang ident="PAGE_CHECKOUT_BASKETCONTENTS_PERSPARAM" }]</strong> <input class="textbox persParam" type="text" name="aproducts[[{ $basketindex }]][persparam][[{ $sVar }]]" value="[{ $aParam }]"></p>
                                    [{/foreach }]
                                    <p>
                                        <input id="am_[{$smarty.foreach.basketContents.iteration}]" type="text" class="textbox" name="aproducts[[{ $basketindex }]][am]" value="[{ $basketitem->getAmount() }]" size="2">
                                    </p>
                                [{/if}]
[{*--BEGIN M1--*}]
                            [{elseif $basketitem->getdBundledAmount() > 0 && ($basketitem->isBundle() || $basketitem->isDiscountArticle()) }]
                                +[{ $basketitem->getdBundledAmount() }]
                            [{else}]
                                [{ $basketitem->getAmount() }]
                            [{/if}]
[{*--END M1--*}]
                        </td>