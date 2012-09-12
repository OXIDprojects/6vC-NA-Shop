[{*--
  * SUMMARY OF V6C MODS:
  *		Lang flags not shown
  *		Drop-down menu not used it only two langs defined
--*}]

[{oxscript include="js/widgets/oxflyoutbox.js" priority=10 }]
[{oxscript add="$( '#languageTrigger' ).oxFlyOutBox();"}]
[{if $oView->isLanguageLoaded()}]
	[{if count($oxcmp_lang) > 2 }]
	<div class="topPopList">
	    [{capture name="languageList"}]
	        [{foreach from=$oxcmp_lang item=_lng}]
		        [{assign var="sLangImg" value="lang/"|cat:$_lng->abbr|cat:".png"}]
		        [{if $_lng->selected}]
		            [{capture name="languageSelected"}]
		                <a title="[{$_lng->name}]" href="[{$_lng->link|oxaddparams:$oView->getDynUrlParams()}]" hreflang="[{$_lng->abbr }]"><span>[{$_lng->name}]</span></a>
		            [{/capture}]
		        [{/if}]
	            <li><a[{if $_lng->selected}] class="selected"[{/if}] title="[{$_lng->name}]" href="[{$_lng->link|oxaddparams:$oView->getDynUrlParams()}]" hreflang="[{$_lng->abbr }]"><span>[{$_lng->name}]</span></a></li>
	      	[{/foreach}]
	    [{/capture}]
	    <p id="languageTrigger" class="selectedValue">
	        [{$smarty.capture.languageSelected}]
	    </p>
	    <div class="flyoutBox">
	    <ul id="languages" class="corners">
	        <li class="active">[{$smarty.capture.languageSelected}]</li>
	        [{$smarty.capture.languageList}]
	    </ul>
	    </div>
	</div>
	[{else}]
		[{foreach from=$oxcmp_lang item=_lng}]
        	[{if !$_lng->selected}]
        		<ul id="langMenu">
        			<li><a title="[{$_lng->name}]" href="[{$_lng->link|oxaddparams:$oView->getDynUrlParams()}]" hreflang="[{$_lng->abbr }]">[{$_lng->name}]</a></li>
        		</ul>
        	[{/if}]
		[{/foreach}]
	[{/if}]
[{/if}]