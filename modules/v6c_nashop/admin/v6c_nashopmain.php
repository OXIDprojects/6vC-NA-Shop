<?php
/**
*    This file is part of the 6vCommerce NA-Shop Module Support Package.
*
*    The 6vCommerce NA-Shop Module Support Package is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    The 6vCommerce NA-Shop Module Support Package is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with the 6vCommerce NA-Shop Module Support Package.  If not, see <http://www.gnu.org/licenses/>.
*
* @link      http://www.6vcommerce.ca
* @copyright (C) 6vCommerce
*/

/**
 * Admin shop system setting manager.
 * Collects shop system settings, updates it on user submit, etc.
 * Admin Menu: Main Menu -> Core Settings -> System.
 * @package admin
 */
class v6c_naShopMain extends Shop_Config
{
    /////////////////////// OVERRIDES ////////////////////////////

    /**
     * Current class template name.
     * @var string
     */
    protected $_sThisTemplate = 'v6c_nashop_main.tpl';


    /////////////////////// EXTENSIONS ////////////////////////////

    /**
    * Add check for install of module.
    *
    * @return string
    */
    public function render()
    {
        $ret = parent::render();

        // Check if module has been installed.  If so, disable install button.
        $oDB = oxDb::getDb();
        $aInstallSteps = array();

        // V6GLOBALTAX field added?
        $sQ = "SHOW COLUMNS FROM `oxorder` LIKE 'V6GLOBALTAX'";
        $rs = $oDB->execute($sQ);
        if ($rs != false && $rs->recordCount() == 0) $aInstallSteps[] = 'AddColV6GLOBALTAX';

        // V6TAXES field added?
        $sQ = "SHOW COLUMNS FROM `oxorder` LIKE 'V6TAXES'";
        $rs = $oDB->execute($sQ);
        if ($rs != false && $rs->recordCount() == 0) $aInstallSteps[] = 'AddColV6TAXES';

        // All provinces available?
        $oCanada = oxNew('oxCountry');
        $oCanada->v6cLoadByIso3('CAN');
        $sQ = "SELECT `OXID` FROM `oxstates` WHERE `OXCOUNTRYID` = '".$oCanada->getId()."'";
        $rs = $oDB->execute($sQ);
        if ($rs != false && $rs->recordCount() != 13) $aInstallSteps[] = 'AddRwsCanProvs';

        // disable button if fully installed
        if (empty($aInstallSteps))
        {
            if ($this->_aViewData["readonly"] === true)
            $sVal = '';
            else
            $sVal = 'disabled';
        } else {
            $sVal = '';
            oxSession::setVar('v6c_aNaInstSteps', $aInstallSteps);
        }

        $this->_aViewData["v6c_sNaInstalled"] = $sVal;

        return $ret;
    }


    /////////////////////// ADDITIONS ////////////////////////////

    public function v6cInstallNA()
    {
        $oDB = oxDb::getDb();
        $aInstallSteps = oxSession::getVar('v6c_aNaInstSteps');
        if (!isset($aInstallSteps)) return;

        if (in_array('AddColV6GLOBALTAX', $aInstallSteps)) $oDB->execute("ALTER TABLE `oxorder` ADD COLUMN `V6GLOBALTAX` TINYINT(1) NOT NULL DEFAULT '0'");

        if (in_array('AddColV6TAXES', $aInstallSteps)) $oDB->execute("ALTER TABLE `oxorder` ADD COLUMN `V6TAXES` BLOB NOT NULL");

        if (in_array('AddRwsCanProvs', $aInstallSteps))
        {
            $oCanada = oxNew('oxCountry');
            $oCanada->v6cLoadByIso3('CAN');
            $sCanId = $oCanada->getId();
            $oDB->execute("DELETE FROM `oxstates` WHERE `OXCOUNTRYID` = '$sCanId'");
            $oDB->execute
            ("
                INSERT INTO `oxstates` (`OXID`, `OXCOUNTRYID`, `OXTITLE`, `OXISOALPHA2`, `OXTITLE_1`, `OXTITLE_2`, `OXTITLE_3`) VALUES
                ('MB', '$sCanId', 'Manitoba', 'MB', 'Manitoba', 'Manitoba', ''),
                ('NB', '$sCanId', 'New Brunswick', 'NB', 'Nouveau-Brunswick', 'Nouveau-Brunswick', ''),
                ('NL', '$sCanId', 'Newfoundland and Labrador', 'NL', 'Terre-Neuve-et-Labrador', 'Terre-Neuve-et-Labrador', ''),
                ('NT', '$sCanId', 'Northwest Territories', 'NT', 'Territoires du Nord-Ouest', 'Territoires du Nord-Ouest', ''),
                ('NS', '$sCanId', 'Nova Scotia', 'NS', 'Nouvelle-Écosse', 'Nouvelle-Écosse', ''),
                ('NU', '$sCanId', 'Nunavut', 'NU', 'Nunavut', 'Nunavut', ''),
                ('ON', '$sCanId', 'Ontario', 'ON', 'Ontario', 'Ontario', ''),
                ('PE', '$sCanId', 'Prince Edward Island', 'PE', 'Île-du-Prince-Édouard', 'Île-du-Prince-Édouard', ''),
                ('QC', '$sCanId', 'Quebec', 'QC', 'Québec', 'Québec', ''),
                ('SK', '$sCanId', 'Saskatchewan', 'SK', 'Saskatchewan', 'Saskatchewan', ''),
                ('YT', '$sCanId', 'Yukon', 'YT', 'Yukon', 'Yukon', ''),
                ('BC', '$sCanId', 'British Columbia', 'BC', 'Colombie-Britannique', 'Colombie-Britannique', ''),
                ('AB', '$sCanId', 'Alberta', 'AB', 'Alberta', 'Alberta', '')
            ");
        }
    }
}
