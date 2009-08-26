﻿<?php
/**
 * Mini-component core file
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 4
* @package Jomres
* @subpackage mini-components
* @copyright	2005-2009 Vince Wooll

Jomres is distributed as a mix of two licenses (excepting other files in the libraries folder, which are independantly licensed). 

The first, proprietary license, refers to Jomres as a package. You cannot share it, period. You can see the full license here http://www.jomres.net/license.html. There are some exceptions, and these files are independantly licensed (see the /jomres/libraries/phptools folder for example)
The files in the /jomres/core-minicomponents,  /jomres/libraries/jomres/cms_specific and the /jomres/templates folders, whilst copyright Vince Wooll, are licensed differently to allow those users who wish, to develop and distribute their own third party plugins for Jomres. Those files are licensed under the MIT license, which allows third party vendors to modify them to suit their own requirements and if so desired, distribute them for free or cost. 

################################################################
This file is subject to The MIT License. For licencing information, please visit 
http://www.jomres.net/index.php?option=com_content&task=view&id=214&Itemid=86 and http://www.jomres.net/license.html
################################################################
*/
// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( 'Direct Access to '.__FILE__.' is not allowed.' );
// ################################################################

/**
#
 * Configuration panel for miscelleneous options
 #
* @package Jomres
#
 */
class j00501odds {
	/**
	#
	 * Constructor: Constructs and outputs miscelleneous options
	#
	 */
	function j00501odds($componentArgs)
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		global $cssStyle;
		global $configurationPanel,$jrConfig,$thisJRUser;
		$mrConfig=$componentArgs['mrConfig'];
		$lists=$componentArgs['lists'];
		$editIconSize=$componentArgs['editIconSize'];
		$configurationPanel->startPanel(_JOMRES_COM_A_ODDS);

		$configurationPanel->setleft(_JOMRES_COM_CONFIGCOUNTRIES);
		$configurationPanel->setmiddle(configCountries());
		$configurationPanel->setright();
		$configurationPanel->insertSetting();
		
		if ($jrConfig['minimalconfiguration']!="1" || $thisJRUser->superPropertyManager)
			{
			$configurationPanel->setleft(_JOMRES_COM_INPUTERROR_BACKGROUND);
			$configurationPanel->setmiddle(jomres_makeColourPickerInput('inputBoxErrorBackground',$mrConfig['inputBoxErrorBackground']));
			$configurationPanel->setright();
			$configurationPanel->insertSetting();

			$configurationPanel->setleft(_JOMRES_COM_INPUTOKTOBOOK_BACKGROUND);
			$configurationPanel->setmiddle(jomres_makeColourPickerInput('inputBoxOktobookBackground',$mrConfig['inputBoxOktobookBackground']));
			$configurationPanel->setright();
			$configurationPanel->insertSetting();
			
			$configurationPanel->setleft(_JOMRES_COM_A_EDITICON);
			$configurationPanel->setmiddle($editIconSize);
			$configurationPanel->setright();
			$configurationPanel->insertSetting();
			}
			
		if ($jrConfig['minimalconfiguration']!="1" || $thisJRUser->superPropertyManager)
			{
			// Disabled for v4 as the full url is passed to the make popup function
			/*
			$configurationPanel->setleft(_JOMRES_COM_A_POPUPSALLOWED);
			$configurationPanel->setmiddle($lists['popupsAllowed']);
			$configurationPanel->setright(_JOMRES_COM_A_POPUPSALLOWED_DESC);
			$configurationPanel->insertSetting();
			*/
			
			$configurationPanel->setleft(_JOMRES_COM_A_VISITORSCANBOOKONLINE);
			$configurationPanel->setmiddle($lists['visitorscanbookonline']);
			$configurationPanel->setright(_JOMRES_COM_A_VISITORSCANBOOKONLINE_DESC);
			$configurationPanel->insertSetting();

			$configurationPanel->setleft(_JOMRES_COM_A_REGISTEREDUSERSONLYBOOK);
			$configurationPanel->setmiddle($lists['registeredUsersOnlyCanBook']);
			$configurationPanel->setright();
			$configurationPanel->insertSetting();
			}

		$configurationPanel->endPanel();
		}

	/**
	#
	 * Must be included in every mini-component
	#
	 * Returns any settings the the mini-component wants to send back to the calling script. In addition to being returned to the calling script they are put into an array in the mcHandler object as eg. $mcHandler->miniComponentData[$ePoint][$eName]
	#
	 */
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}


?>