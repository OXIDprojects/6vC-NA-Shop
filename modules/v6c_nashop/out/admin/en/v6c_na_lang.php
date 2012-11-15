<?php
$sLangName  = "English";
// -------------------------------
// RESOURCE IDENTITFIER = STRING
// -------------------------------
$aLang = array(
'charset'                                   => 'ISO-8859-15',

// Admin overrides
'GENERAL_DELIVERYCOST'	                                    => 'Shipping & Handling',
'GENERAL_IVAT'                                              => 'Tax',
'GENERAL_SUMTOTAL'                                          => 'Grand Total',
'EMAIL_SENDEDNOW_HTML_ORDERSHIPPEDTO'                       => 'The order was shipped to:',
'EMAIL_SENDEDNOW_HTML_YUORTEAM1'                            => 'The',
'LOOKNFEEL_BLOCK_DISPLAY_CURRENCIES'                        => 'Enable Multiple Currencies',
'LOOKNFEEL_BLOCK_DISPLAY_LANGUAGES'                         => 'Enable Multiple Languages',
'ORDER_OVERVIEW_PDF_FILLONPAYMENT'                          => '',//'Please always indicate for payments.',
'ORDER_OVERVIEW_PDF_TAXIDNR'                                => 'GST/TPS#:',
'ORDER_OVERVIEW_PDF_ORDERSFROM'                             => 'Your ',
'ORDER_OVERVIEW_PDF_ORDERSAT'                               => ' order at ',
'ORDER_OVERVIEW_PDF_SHIPCOST'                               => 'Shipping & Handling',
'ORDER_OVERVIEW_PDF_GREETINGS'                              => 'Thank you for your order! Please order from us again and recommend us to others.',
'ORDER_OVERVIEW_PDF_PHONE'                                  => '',//'phone : ',
'ORDER_OVERVIEW_PDF_ACCOUNTNR'                              => 'TVQ/QST#: ',
'ORDER_OVERVIEW_PDF_ALLPRICEBRUTTO'                         => 'Total Products (gross)',
'SHOP_CONFIG_CALCULATEVATFORDELIVERY'                       => 'Enable VAT for Shipping Costs in Shopping Cart and Invoice',
'SHOP_PERF_LOADCURRENCY'                                    => 'Enable Multiple Currencies',
'SHOP_PERF_LOADLANGUAGES'                                   => 'Enable Multiple Languages',

// General admin content
'TBD'										=> 'To Be Determined',
'HELP_TBD'									=> 'Content to be determined',
'V6C_GENERAL_CARTCOST'                      => 'Cart Subtotal',
'V6C_GENERAL_ORDERCOST'                     => 'Order Total',
'V6C_GENERAL_FEDERAL'                    	=> '(Federal)',
'V6C_GENERAL_STATE'                     	=> '(Provincial)',
'V6C_GENERAL_PAYTERMS'                     	=> 'Payment Terms:',
'V6C_GENERAL_INSTALL'                     	=> 'Install/Update',
'V6C_EMAIL_SENDEDNOW_SHIPMETHOD'			=> 'Shipping Method:',
'V6C_EMAIL_SENDEDNOW_TRACKNR'				=> 'Tracking #:',

// Menu & tab titles
'v6cmods'    								=> '6vC Settings',
'v6c_nashop'    							=> 'North America Shop',
'v6c_nashop_main'							=> 'Main',
'V6C_MENUITEM'    							=> '6vC Extensions',
'V6C_MENUSUBITEM_NASHOP'    				=> 'North America Shop',

// Configuration parameter descriptions and help content
'V6C_INSTLNASHOP'							=> 'Installs or updates the shop to use this module. Always go to Admin>Service>Tools and Update DB Views after performing this action.',
'V6C_HELP_INSTLNASHOP'						=> 'If button is active, then an install or update is required.  Otherwise, shop is already up-to-date.',
'V6C_NOTAX'    								=> 'Do not include/calulate taxes except at final checkout for total order cost (ie. NAtax=ON).',
'V6C_HELP_NOTAX'    						=> 'Tax is calculated for every price used/displayed in OXID.  Setting this option will stop these tax calculations except when finalizing the grand total cost of an order.  Content displayed during checkout is also updated according to this setting.',
'V6C_PREFIXMNYSGN'    						=> 'Prefix currency sign to prices.',
'V6C_LABELTAX'    							=> 'Include tax labels in order summary.',
'V6C_HELP_LABELTAX'    						=> 'If not set, all taxes will be summarized simply as "Tax:".  If set, a label such as "Tax (GST):" will be used for each appliable tax.',
);