<?php
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
 * Passed the property uids to be listed, will re-order those property uids. Allows us to create plugins (for example for the portal) which can create featured properties
 #
* @package Jomres
#
 */
class j01009filterproperties
	{
	function j01009filterproperties($componentArgs)
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=true; return;
			}
		global $jomresConfig_live_site;
		$propertys_uids=$componentArgs['propertys_uids'];
		// get sroting value
		$sortid = intval(jomresGetParam( $_COOKIE, 'jomsearch_sortby', 1));
		switch ($sortid)
			{
			#########################################################################################
			case '1':
				$this->propertys_uids = $propertys_uids;
			break;
			#########################################################################################
			case '2':
				$gor=genericOr($propertys_uids,'propertys_uid');
				$query = "SELECT propertys_uid, property_name FROM #__jomres_propertys WHERE $gor ORDER BY property_name";
				$uids = doSelectSql($query);
				foreach ($uids as $u)
					$this->propertys_uids[] = $u->propertys_uid;
			break;
			#########################################################################################
			case '3':
				$gor=genericOr($propertys_uids,'propertys_uid');
				$query = "SELECT propertys_uid, property_region FROM #__jomres_propertys WHERE $gor ORDER BY property_region";
				$uids = doSelectSql($query);
				foreach ($uids as $u)
					$this->propertys_uids[] = $u->propertys_uid;
			break;
			#########################################################################################
			case '4':
				$gor=genericOr($propertys_uids,'propertys_uid');
				$query = "SELECT propertys_uid, property_town FROM #__jomres_propertys WHERE $gor ORDER BY property_town";
				$uids = doSelectSql($query);
				foreach ($uids as $u)
					$this->propertys_uids[] = $u->propertys_uid;
			break;
			#########################################################################################
			case '5':
				$gor=genericOr($propertys_uids,'propertys_uid');
				$query = "SELECT propertys_uid, stars FROM #__jomres_propertys WHERE $gor ORDER BY stars DESC";
				$uids = doSelectSql($query);
				foreach ($uids as $u)
					$this->propertys_uids[] = $u->propertys_uid;
			break;
			#########################################################################################
			default:
				$this->propertys_uids = $propertys_uids;
			break;
			}
		$sortArray=array();

		$sortArray[]=jomresHTML::makeOption("1", jr_gettext('_JOMRES_SORTORDER_DEFAULT',_JOMRES_SORTORDER_DEFAULT,false,false));
		$sortArray[]=jomresHTML::makeOption("2", jr_gettext('_JOMRES_SORTORDER_PROPERTYNAME',_JOMRES_SORTORDER_PROPERTYNAME,false,false));
		$sortArray[]=jomresHTML::makeOption("3", jr_gettext('_JOMRES_SORTORDER_PROPERTYREGION',_JOMRES_SORTORDER_PROPERTYREGION,false,false));
		$sortArray[]=jomresHTML::makeOption("4", jr_gettext('_JOMRES_SORTORDER_PROPERTYTOWN',_JOMRES_SORTORDER_PROPERTYTOWN,false,false));
		$sortArray[]=jomresHTML::makeOption("5", jr_gettext('_JOMRES_SORTORDER_STARS',_JOMRES_SORTORDER_STARS,false,false));

		$order['HORDER']=jr_gettext('_JOMRES_ORDER',_JOMRES_ORDER);

		$order['ORDER']=jomresHTML::selectList( $sortArray, 'sortby', 'onchange="gosearch();" id="sortby" size="1"', 'value', 'text', $sortid );
		$sortorder=array();
		$sortorder[]=$order;

		$tmpl = new patTemplate();
		$tmpl->setRoot( JOMRES_TEMPLATEPATH_FRONTEND );
		$tmpl->readTemplatesFromInput( 'order.html' );
		$tmpl->addRows( 'sort_order', $sortorder);
		$tmpl->displayParsedTemplate();
		}

	function touch_template_language()
		{
		$output=array();

		$output[]		=jr_gettext('_JOMRES_SORTORDER_DEFAULT',_JOMRES_SORTORDER_DEFAULT);
		$output[]		=jr_gettext('_JOMRES_SORTORDER_PROPERTYNAME',_JOMRES_SORTORDER_PROPERTYNAME);
		$output[]		=jr_gettext('_JOMRES_SORTORDER_PROPERTYREGION',_JOMRES_SORTORDER_PROPERTYREGION);
		$output[]		=jr_gettext('_JOMRES_SORTORDER_PROPERTYTOWN',_JOMRES_SORTORDER_PROPERTYTOWN);
		$output[]		=jr_gettext('_JOMRES_SORTORDER_STARS',_JOMRES_SORTORDER_STARS);
		foreach ($output as $o)
			{
			echo $o;
			echo "<br/>";
			}
		}
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return $this->propertys_uids;
		}
	}
?>