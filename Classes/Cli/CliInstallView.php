<?php
/**
 * Created by PhpStorm.
 * User: pekue
 * Date: 02.01.15
 * Time: 15:44
 */

class Tx_Smoothmigration_Cli_CliInstallView extends \TYPO3\CMS\Install\View\FailsafeView {

	public function render(){
		foreach($this->variables['availableUpdates'] as $availableUpdate){
			if($availableUpdate['renderNext']){
				return $availableUpdate;
				break;
			}
		}
		var_dump($this->variables);
		return false;
	}

}