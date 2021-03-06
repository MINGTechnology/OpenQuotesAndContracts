<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/Sugar_Smarty.php');
require_once('modules/oqc_Contract/oqc_Contract.php');

function getNextRevisionsHtml($focus, $name, $value, $view) {
	if ('EditView' != $view && 'DetailView' != $view) {
 		return ""; // skip the rest of the method if another view calls this method
 	}
	global $sugar_version ;
	global $mod_strings;
	global $app_list_strings;
	//2.2RC2 translation eroor fix	
	//Detect module name and select appropriate status list
	$moduleName = $focus->object_name;
	if ($moduleName == 'oqc_Product') {
		$status_list = $app_list_strings["oqc_product_status_list"];
		}
	elseif ($moduleName == 'oqc_Contract') {
		$status_list = $app_list_strings["oqc_contract_status_dom"];
		}
	elseif ($moduleName == 'oqc_Offering') {
		$status_list = $app_list_strings["oqc_offering_status_dom"];
		}
	elseif ($moduleName == 'oqc_Addition') {
		$status_list = $app_list_strings["oqc_addition_status_dom"];
		}
	elseif ($moduleName == 'oqc_ExternalContract') {
		$status_list = $app_list_strings["oqc_externalcontract_status_dom"];
		}
	else {
		$status_list = $app_list_strings["issue_status_dom"];
		}
	$nextRevisions = $focus->getSevenNextRevisions();

	foreach ($nextRevisions as &$contract) {
		$contract = $contract->toArray();
		if (isset($status_list[$contract['status']])) {
			$contract['status'] = $status_list[$contract['status']];
	
			}
		}
	
	$smarty = new Sugar_Smarty;
	$smarty->assign('moduleName', $moduleName);
	$smarty->assign('nextRevisions', $nextRevisions);
	$smarty->assign($mod_strings);
//	$smarty->assign('numberOfNextRevisions', count($nextRevisions));
	if(substr($sugar_version,0,1) == '6') {
	return $smarty->fetch('include/oqc/NextRevisions/' . $view . '.html');
	}
	else {
		return $smarty->fetch('include/oqc/NextRevisions/' . $view . '52.html');
		}
}

?>
