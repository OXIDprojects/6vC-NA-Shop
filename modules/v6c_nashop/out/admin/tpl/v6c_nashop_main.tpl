[{*--
  * Use shop_main.tpl as a basis for merging diffs on updates
--*}]

[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

[{ if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

[{cycle assign="_clear_" values=",2" }]

<form name="transfer" id="transfer" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{ $oViewConf->getHiddenSid() }]
    <input type="hidden" name="oxid" value="[{ $oxid }]">
    <input type="hidden" name="cl" value="v6c_nashopmain">
    <input type="hidden" name="fnc" value="">
    <input type="hidden" name="actshop" value="[{$oViewConf->getActiveShopId()}]">
    <input type="hidden" name="updatenav" value="">
    <input type="hidden" name="editlanguage" value="[{ $editlanguage }]">
</form>

<form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
[{ $oViewConf->getHiddenSid() }]
<input type="hidden" name="cl" value="v6c_nashopmain">
<input type="hidden" name="fnc" value="save">
<input type="hidden" name="oxid" value="[{ $oxid }]">
<input type="hidden" name="editval[oxshops__oxid]" value="[{ $oxid }]">


    <table border=0>

        <tr class="conftext[{cycle}]">
         <td valign="middle">
            <input type="submit" class="confinput" name="save" value="[{ oxmultilang ident="V6C_GENERAL_INSTALL" }]" onClick="Javascript:document.myedit.fnc.value='v6cInstallNA'" [{ $readonly }] [{$v6c_sNaInstalled}]>
            [{ oxinputhelp ident="V6C_HELP_INSTLNASHOP" }]
         </td>
         <td valign="middle" width="100%" >
            [{ oxmultilang ident="V6C_INSTLNASHOP" }]
         </td>
        </tr>

        <tr class="conftext[{cycle}]">
         <td valign="middle">
            <input type=hidden name=confbools[v6c_blKillTax] value=false>
            <input type=checkbox name=confbools[v6c_blKillTax] value=true  [{if ($confbools.v6c_blKillTax)}]checked[{/if}] [{ $readonly }]>
            [{ oxinputhelp ident="V6C_HELP_NOTAX" }]
         </td>
         <td valign="middle" width="100%" >
            [{ oxmultilang ident="V6C_NOTAX" }]
         </td>
        </tr>

        <tr class="conftext[{cycle}]">
         <td valign="middle">
            <input type=hidden name=confbools[v6c_blPrefixCurrencySign] value=false>
            <input type=checkbox name=confbools[v6c_blPrefixCurrencySign] value=true  [{if ($confbools.v6c_blPrefixCurrencySign)}]checked[{/if}] [{ $readonly }]>
            [{ oxinputhelp ident="V6C_HELP_PREFIXMNYSGN" }]
         </td>
         <td valign="middle" width="100%">
          [{ oxmultilang ident="V6C_PREFIXMNYSGN" }]
         </td>
        </tr>

        <tr class="conftext[{cycle}]">
         <td valign="middle">
            <input type=hidden name=confbools[v6c_blLabelTax] value=false>
            <input type=checkbox name=confbools[v6c_blLabelTax] value=true  [{if ($confbools.v6c_blLabelTax)}]checked[{/if}] [{ $readonly }]>
            [{ oxinputhelp ident="V6C_HELP_LABELTAX" }]
         </td>
         <td valign="middle" width="100%">
          [{ oxmultilang ident="V6C_LABELTAX" }]
         </td>
        </tr>

[{*
        <tr class="conftext[{cycle}]">
         <td valign="middle" class="nowrap">
           <select class="confinput" name=confstrs[iTBD] [{ $readonly }]>
             <option value="0" [{ if $confstrs.iTBD == 0}]SELECTED[{/if}]>[{ oxmultilang ident="TBD" }]</option>
             <option value="1" [{ if $confstrs.iTBD == 1}]SELECTED[{/if}]>[{ oxmultilang ident="TBD" }]</option>
             <option value="2" [{ if $confstrs.iTBD == 2}]SELECTED[{/if}]>[{ oxmultilang ident="TBD" }]</option>
           </select>
           [{ oxinputhelp ident="HELP_TBD" }]
         </td>
         <td valign="middle" width="100%">
              [{ oxmultilang ident="TBD" }]
         </td>
        </tr>
*}]
		<!-- Forcing width of first column -->
        <tr>
         <td valign="middle" class="nowrap">
         	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         </td>
         <td valign="middle" width="100%"></td>
        </tr>
    </table>

	<input type="submit" class="confinput" name="save" value="[{ oxmultilang ident="GENERAL_SAVE" }]" onClick="Javascript:document.myedit.fnc.value='save'"" [{ $readonly }]>

</form>

[{*include file="bottomnaviitem.tpl"*}]

[{include file="bottomitem.tpl"}]