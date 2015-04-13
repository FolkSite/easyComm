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
			easyComm.config.thread_fields = ' . json_encode($this->easyComm->getThreadFields()) . ';
			easyComm.config.thread_grid_fields = ' . json_encode($this->easyComm->getThreadGridFields()) . ';
			easyComm.config.thread_window_fields = ' . json_encode($this->easyComm->getThreadWindowFields()) . ';
			easyComm.config.message_fields = ' . json_encode($this->easyComm->getMessageFields()) . ';
			easyComm.config.message_grid_fields = ' . json_encode($this->easyComm->getMessageGridFields()) . ';
			easyComm.config.message_window_layout = ' . $this->easyComm->getMessageWindowLayout() . ';
		</script>
		');

        $this->loadPlugins();

		parent::initialize();
	}

    /**
	 * Loads additional scripts for message form from easyComm plugins
	 *
	 * @return void
	 * */
    function loadPlugins() {
        foreach ($this->modx->easyCommPlugins->plugins as $plugin) {
            if (!empty($plugin['manager']['ecMessage'])) {
                $this->addJavascript($plugin['manager']['ecMessage']);
            }
        }
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