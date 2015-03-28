<?php

/**
 * Class easyCommMainController
 */
abstract class easyCommMainController extends modExtraManagerController {
	/** @var easyComm $easyComm */
	public $easyComm;


	/**
	 * @return void
	 */
	public function initialize() {
		$corePath = $this->modx->getOption('easycomm_core_path', null, $this->modx->getOption('core_path') . 'components/easycomm/');
		require_once $corePath . 'model/easycomm/easycomm.class.php';

		$this->easyComm = new easyComm($this->modx);
		$this->addCss($this->easyComm->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->easyComm->config['jsUrl'] . 'mgr/easycomm.js');
		$this->addHtml('
		<script type="text/javascript">
			easyComm.config = ' . $this->modx->toJSON($this->easyComm->config) . ';
			easyComm.config.connector_url = "' . $this->easyComm->config['connectorUrl'] . '";
		</script>
		');

		parent::initialize();
	}


	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return array('easycomm:default');
	}


	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}


/**
 * Class IndexManagerController
 */
class IndexManagerController extends easyCommMainController {

	/**
	 * @return string
	 */
	public static function getDefaultController() {
		return 'home';
	}
}