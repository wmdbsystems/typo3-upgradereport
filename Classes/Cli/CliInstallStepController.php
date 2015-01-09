<?php
/**
 * Created by PhpStorm.
 * User: pekue
 * Date: 02.01.15
 * Time: 13:40
 */

class Tx_Smoothmigration_Cli_CliInstallStepController extends TYPO3\CMS\Install\Controller\StepController {

	public function execute(){
		$this->loadBaseExtensions();
		$this->initializeObjectManager();

		$this->outputInstallToolNotEnabledMessageIfNeeded();
		$this->migrateLocalconfToLocalConfigurationIfNeeded();
//		$this->outputInstallToolPasswordNotSetMessageIfNeeded();
		$this->migrateExtensionListToPackageStatesFile();
		$this->executeOrOutputFirstInstallStepIfNeeded();
		$this->executeSilentConfigurationUpgradesIfNeeded();
//		$this->initializeSession();
//		$this->checkSessionToken();
//		$this->checkSessionLifetime();
//		$this->loginIfRequested();
//		$this->outputLoginFormIfNotAuthorized();
		$this->executeSpecificStep();
//		$this->outputSpecificStep();
//		$this->redirectToTool();
	}


	/**
	 * Execute a step action if requested. If executed, a redirect is done, so
	 * the next request will render step one again if needed or initiate a
	 * request to test the next step.
	 *
	 * @throws Exception
	 * @return void
	 */
	protected function executeSpecificStep() {
		$action = $this->getAction();
		$postValues = $this->getPostValues();
		var_dump($action);
		if ($action && isset($postValues['set']) && $postValues['set'] === 'execute') {
			$stepAction = $this->getActionInstance($action);
			$stepAction->setAction($action);
			$stepAction->setToken($this->generateTokenForAction($action));
			$stepAction->setPostValues($this->getPostValues());
			$messages = $stepAction->execute();
			$this->addSessionMessages($messages);
			$this->redirect();
		}
	}
}