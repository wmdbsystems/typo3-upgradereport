<?php
/**
 * Created by PhpStorm.
 * User: pekue
 * Date: 02.01.15
 * Time: 13:40
 */

class Tx_Smoothmigration_Cli_CliInstallToolController extends TYPO3\CMS\Install\Controller\ToolController {

	private $postValues = array();

	/**
	 * Main dispatch method
	 *
	 * @return void
	 */
	public function execute() {
		$this->loadBaseExtensions();
		$this->initializeObjectManager();

		// Warning: Order of these methods is security relevant and interferes with different access
		// conditions (new/existing installation). See the single method comments for details.
//		$this->outputInstallToolNotEnabledMessageIfNeeded();
//		$this->outputInstallToolPasswordNotSetMessageIfNeeded();
//		$this->initializeSession();
//		$this->checkSessionToken();
//		$this->checkSessionLifetime();
//		$this->logoutIfRequested();
//		$this->loginIfRequested();
//		$this->outputLoginFormIfNotAuthorized();
		$this->registerExtensionConfigurationErrorHandler();
		return $this->dispatchActions();
	}
	/**
	 * Call an action that needs authentication
	 *
	 * @throws Exception
	 * @return string Rendered content
	 */
	protected function dispatchActions() {
		$action = $this->getAction();
		if ($action === '') {
			$action = 'upgradeWizard';
		}
		$actionClass = ucfirst($action);
		/** @var \TYPO3\CMS\Install\Controller\Action\ActionInterface $toolAction */
		$toolAction = $this->objectManager->get('TYPO3\\CMS\\Install\\Controller\\Action\\Tool\\' . $actionClass);
		if (!($toolAction instanceof TYPO3\CMS\Install\Controller\Action\ActionInterface)) {
			throw new Exception(
				$action . ' does not implement ActionInterface',
				1369474309
			);
		}

		$view = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Tx_Smoothmigration_Cli_CliInstallView');
		$toolAction->injectView($view);
		$toolAction->setController('tool');
		$toolAction->setAction($action);
		$toolAction->setToken($this->generateTokenForAction($action));
		$toolAction->setPostValues($this->getPostValues());
		$toolAction->setLastError($this->getLastError());
		return $toolAction->handle();
	}

	public function setPostValues($values){
		$this->postValues = $values;
	}

	protected function getPostValues() {
		return $this->postValues;
	}

}