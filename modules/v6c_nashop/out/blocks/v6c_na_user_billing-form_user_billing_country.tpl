[{*--
  * SUMMARY OF V6C MODS:
  *		Last based off: v4.5.11 - form/fieldset/user_billing.tpl->form_user_billing_country
  *		Old code in case update breaks previous mod: Auto select of domestic country
--*}]
    <li [{if $aErrors.oxuser__oxcountryid}]class="oxInValid"[{/if}]>
        <label [{if $oView->isFieldRequired(oxuser__oxcountryid) }]class="req"[{/if}]>[{ oxmultilang ident="FORM_FIELDSET_USER_BILLING_COUNTRY" }]</label>
          <select [{if $oView->isFieldRequired(oxuser__oxcountryid) }] class="js-oxValidate js-oxValidate_notEmpty" [{/if}] id="invCountrySelect" name="invadr[oxuser__oxcountryid]">
               <option value="">-</option>
            [{foreach from=$oViewConf->getCountryList() item=country key=country_id }]
                <option value="[{ $country->oxcountry__oxid->value }]" [{if isset( $invadr.oxuser__oxcountryid ) && $invadr.oxuser__oxcountryid == $country->oxcountry__oxid->value}] selected[{elseif $oxcmp_user->oxuser__oxcountryid->value == $country->oxcountry__oxid->value}] selected[{ elseif !isset($invadr.oxuser__oxcountryid) && empty($oxcmp_user->oxuser__oxcountryid->value) && $country->domestic }] selected[{/if}]>[{ $country->oxcountry__oxtitle->value }]</option>
            [{/foreach }]
          </select>
          [{if $oView->isFieldRequired(oxuser__oxcountryid) }]
        <p class="oxValidateError">
            <span class="js-oxError_notEmpty">[{ oxmultilang ident="EXCEPTION_INPUT_NOTALLFIELDS" }]</span>
            [{include file="message/inputvalidation.tpl" aErrors=$aErrors.oxuser__oxcountryid}]
        </p>
          [{/if}]
    </li>
    <li class="stateBox">
          [{include file="form/fieldset/state.tpl"
                countrySelectId="invCountrySelect"
                stateSelectName="invadr[oxuser__oxstateid]"
                selectedStateIdPrim=$invadr.oxuser__oxstateid
                selectedStateId=$oxcmp_user->oxuser__oxstateid->value
         }]
    </li>