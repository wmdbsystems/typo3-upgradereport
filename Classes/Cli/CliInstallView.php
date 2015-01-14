<?php
/**
 * Created by PhpStorm.
 * User: pekue
 * Date: 02.01.15
 * Time: 15:44
 */

class Tx_Smoothmigration_Cli_CliInstallView extends \TYPO3\CMS\Install\View\FailsafeView {

	private static $options;

	private static $last;

	public function render(){
		if($this->variables['availableUpdates']) {
			Tx_Smoothmigration_Cli_CliInstallView::$options = $this->variables['availableUpdates'];
			foreach ($this->variables['availableUpdates'] as $pointer => $availableUpdate) {
				if ($availableUpdate['renderNext'] && $pointer != Tx_Smoothmigration_Cli_CliInstallView::$last) {
					$availableUpdate['way'] = 'a';
					return $availableUpdate;
					break;
				}
			}
		} else {
			if(isset($this->variables['wizardData']['identifier'])) {
				Tx_Smoothmigration_Cli_CliInstallView::$last = $this->variables['wizardData']['identifier'];
				$result = $this->getNextStep($this->variables['wizardData']['identifier']);
				return $result;
			}
		}
		return false;
	}

	/**
	 * @param $currentIdentifier
	 *
	 * @return null
	 */
	private function getNextStep($currentIdentifier) {
		$next = null;
		if(is_array(Tx_Smoothmigration_Cli_CliInstallView::$options)) {
			$reached = 0;
			foreach(Tx_Smoothmigration_Cli_CliInstallView::$options AS $identifier => $option) {
				if($reached == 1) {
					$next = $option;
					break;
				}
				if($currentIdentifier == $identifier) {
					$reached = 1;
				}
			}
		}
		return $next;
	}

}