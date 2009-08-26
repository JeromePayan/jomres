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

class j16020stats_properties_currentbookings
	{
	function j16020stats_properties_currentbookings()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$query="SELECT property_name,propertys_uid
		FROM #__jomres_propertys ORDER BY property_name";
		$result=doSelectSql($query);
		$propertys=array();
		foreach ($result as $r)
			{
			$propertys[$r->propertys_uid]=array('property_name'=>$r->property_name,'count'=>0);
			}
		$query="SELECT contract_uid,property_uid FROM #__jomres_contracts WHERE `cancelled` = 0 AND bookedout = 0";
		$result=doSelectSql($query);
		if (count($result)>0)
			{
			foreach ($result as $r)
				{
				$oldcount=$propertys[$r->property_uid]['count'];
				$oldcount++;
				$propertys[$r->property_uid]['count']=$oldcount++;
				}
			}
		$graphLabels="";
		$graphValues="";
		$counter=0;
		$numberOfResults=count($result);
		foreach ($propertys as $p)
			{
			$graphLabels.=$p['property_name'];
			$graphValues.=$p['count'];
			$counter++;
			//if ($counter<$numberOfResults)
			//	{
				$graphLabels.=",";
				$graphValues.=",";
			//	}
			}
		
		$graphParams=makeJsGraphOutput($graphLabels,$graphValues,"hBar","","divGraph");
		$this->retVal='<div class="graphcontainer"></div>';
		$this->retVal.='<div id="divGraph"></div>';
		$this->retVal.=$graphParams;
		echo $this->retVal;
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return $this->retVal;
		}	
	}