[{*--
  * SUMMARY OF V6C MODS:
  *		Last based off: v4.5.11 - form/fieldset/user_shipping.tpl->form_user_billing_country
  *		Old code in case update breaks previous mod: Auto select of domestic country
--*}]
        <li [{if $aErrors.oxaddress__oxcountryid}]class="oxInValid"[{/if}]>
            <label [{if $oView->isFieldRequired(oxaddress__oxcountryid) }]class="req"[{/if}]>[{ oxmultilang ident="FORM_FIELDSET_USER_SHIPPING_COUNTRY2" }]</label>
              <select [{if $oView->isFieldRequired(oxaddress__oxcountryid) }] class="js-oxValidate js-oxValidate_notEmpty" [{/if }] id="delCountrySelect" name="deladr[oxaddress__oxcountryid]">
                <option value="">-</option>
                [{foreach from=$oViewConf->getCountryList() item=country key=country_id }]
                  <option value="[{ $country->oxcountry__oxid->value }]" [{if isset( $deladr.oxaddress__oxcountryid ) && $deladr.oxaddress__oxcountryid == $country->oxcountry__oxid->value }]selected[{elseif $delivadr->oxaddress__oxcountry->value == $country->oxcountry__oxtitle->value or $delivadr->oxaddress__oxcountry->value == $country->oxcountry__oxid->value or $delivadr->oxaddress__oxcountryid->value == $country->oxcountry__oxid->value }]selected[{ elseif !isset($invadr.oxuser__oxcountryid) && empty($oxcmp_user->oxuser__oxcountryid->value) && $country->domestic }] selected[{/if }]>[{ $country->oxcountry__oxtitle->value }]</option>
                [{/foreach }]
              </select>
              [{if $oView->isFieldRequired(oxaddress__oxcountryid) }]
              <p class="oxValidateError">
                <span class="js-oxError_notEmpty">[{ oxmultilang ident="EXCEPTION_INPUT_NOTALLFIELDS" }]</span>
                [{include file="message/inputvalidation.tpl" aErrors=$aErrors.oxaddress__oxcountryid}]
            </p>
          [{/if }]
        </li>
        <li class="stateBox">
              [{include file="form/fieldset/state.tpl"
                    countrySelectId="delCountrySelect"
                    stateSelectName="deladr[oxaddress__oxstateid]"
                    selectedStateIdPrim=$deladr.oxaddress__oxstateid
                    selectedStateId=$delivadr->oxaddress__oxstateid->value
            }]
        </li>