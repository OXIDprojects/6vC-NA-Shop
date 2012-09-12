[{*--
  * SUMMARY OF V6C MODS:
  *		Note about VAT included made conditional upon tax option, not content.
--*}]

[{capture append="oxidBlock_pageBody"}]
    <div id="page" class="[{if $sidebar}] sidebar[{$sidebar}][{/if}]">
        [{include file="layout/header.tpl"}]
        [{if $oView->getClassName() ne "start" && !$blHideBreadcrumb}]
           [{ include file="widget/breadcrumb.tpl"}]
        [{/if}]
        [{if $sidebar}]
            <div id="sidebar">
                [{include file="layout/sidebar.tpl"}]
            </div>
        [{/if}]
        <div id="content">
            [{include file="message/errors.tpl"}]
            [{foreach from=$oxidBlock_content item="_block"}]
                [{$_block}]
            [{/foreach}]
        </div>
        [{include file="layout/footer.tpl"}]
    </div>
    [{include file="widget/facebook/init.tpl"}]
    [{if !$oViewConf->v6cIsTaxOff()}]
	    [{*oxifcontent ident="oxdeliveryinfo" object="oCont"*}]
	        <div id="incVatMessage"><span class="deliveryInfo">[{ oxmultilang ident="INCL_TAX_AND_PLUS_SHIPPING" }]</span></div>
	    [{*/oxifcontent *}]
    [{/if}]
[{/capture}]
[{include file="layout/base.tpl"}]