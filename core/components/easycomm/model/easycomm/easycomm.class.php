<?php

/**
 * The base class for easyComm.
 */
class easyComm {
	/* @var modX $modx */
	public $modx;


	/**
	 * @param modX $modx
	 * @param array $config
	 */
	function __construct(modX &$modx, array $config = array()) {
		$this->modx =& $modx;

		$corePath = $this->modx->getOption('ec_core_path', $config, $this->modx->getOption('core_path') . 'components/easycomm/');
		$assetsUrl = $this->modx->getOption('ec_assets_url', $config, $this->modx->getOption('assets_url') . 'components/easycomm/');
		$connectorUrl = $assetsUrl . 'connector.php';
        $actionUrl = $this->modx->getOption('ec_action_url', $config, $assetsUrl.'action.php');

        $this->config = array_merge(array(
			'assetsUrl' => $assetsUrl,
			'cssUrl' => $assetsUrl . 'css/',
			'jsUrl' => $assetsUrl . 'js/',
			'imagesUrl' => $assetsUrl . 'images/',
			'connectorUrl' => $connectorUrl,
            'actionUrl' => $actionUrl,

			'corePath' => $corePath,
			'modelPath' => $corePath . 'model/',
			'chunksPath' => $corePath . 'elements/chunks/',
			'templatesPath' => $corePath . 'elements/templates/',
			'chunkSuffix' => '.chunk.tpl',
			'snippetsPath' => $corePath . 'elements/snippets/',
			'processorsPath' => $corePath . 'processors/',

            'json_response' => true,
		), $config);

		$this->modx->addPackage('easycomm', $this->config['modelPath']);
		$this->modx->lexicon->load('easycomm:default');
	}


    /**
     * Initializes component into different contexts.
     *
     * @param string $ctx The context to load. Defaults to web.
     * @param array $scriptProperties
     *
     * @return boolean
     */
    public function initialize($ctx = 'web', $scriptProperties = array()) {
        $this->config = array_merge($this->config, $scriptProperties);
        $this->config['ctx'] = $ctx;
        if (!empty($this->initialized[$ctx])) {
            return true;
        }
        switch ($ctx) {
            case 'mgr': break;
            default:
                if (!defined('MODX_API_MODE') || !MODX_API_MODE) {
                    $config = $this->makePlaceholders($this->config);
                    if ($css = $this->modx->getOption('ec_frontend_css')) {
                        $this->modx->regClientCSS(str_replace($config['pl'], $config['vl'], $css));
                    }
                    $config_js = preg_replace(array('/^\n/', '/\t{6}/'), '', '
						easyCommConfig = {
							ctx: "'.$ctx.'"
							,jsUrl: "'.$this->config['jsUrl'].'web/"
							,cssUrl: "'.$this->config['cssUrl'].'web/"
							,actionUrl: "'.$this->config['actionUrl'].'"
						};
					');
                    $this->modx->regClientStartupScript("<script type=\"text/javascript\">\n".$config_js."\n</script>", true);
                    if ($js = trim($this->modx->getOption('ec_frontend_js'))) {
                        if (!empty($js) && preg_match('/\.js/i', $js)) {
                            $this->modx->regClientScript(str_replace($config['pl'], $config['vl'], $js));
                        }
                    }
                }
                $this->initialized[$ctx] = true;
                break;
        }
        return true;
    }

    /**
     * Method for transform array to placeholders
     *
     * @var array $array With keys and values
     * @var string $prefix Prefix for array keys
     *
     * @return array $array Two nested arrays with placeholders and values
     */
    public function makePlaceholders(array $array = array(), $prefix = '') {
        if (!$this->pdoTools) {
            $this->loadPdoTools();
        }
        return $this->pdoTools->makePlaceholders($array, $prefix);
    }

    /**
     * Loads an instance of pdoTools
     *
     * @return boolean
     */
    public function loadPdoTools() {
        if (!is_object($this->pdoTools) || !($this->pdoTools instanceof pdoTools)) {
            /** @var pdoFetch $pdoFetch */
            $fqn = $this->modx->getOption('pdoFetch.class', null, 'pdotools.pdofetch', true);
            if ($pdoClass = $this->modx->loadClass($fqn, '', false, true)) {
                $this->pdoTools = new $pdoClass($this->modx, $this->config);
            }
            elseif ($pdoClass = $this->modx->loadClass($fqn, MODX_CORE_PATH . 'components/pdotools/model/', false, true)) {
                $this->pdoTools = new $pdoClass($this->modx, $this->config);
            }
            else {
                $this->modx->log(modX::LOG_LEVEL_ERROR, 'Could not load pdoFetch from "MODX_CORE_PATH/components/pdotools/model/".');
            }
        }
        return !empty($this->pdoTools) && $this->pdoTools instanceof pdoTools;
    }

    /**
     * Create ecMessage through processor
     *
     * @param array $data $_POST
     *
     * @return array
     */
    public function createMessage($data = array()){
        $requiredFields = array_map('trim', explode(',', $this->config['requiredFields']));
        $requiredFields = array_unique(array_merge($requiredFields, array('thread')));
        $allowedFields = array_map('trim', explode(',', $this->config['allowedFields']));
        $allowedFields = array_unique(array_merge($allowedFields, $requiredFields));

        $fields = array();
        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $data)) {
                $fields[$field] = $this->sanitizeString($data[$field]);
            }
        }

        $fields['requiredFields'] = $requiredFields;

        if (!empty($fields['thread']) && $thread = $this->modx->getObject('ecThread', array('name' => $fields['thread']))) {
            $fields['thread'] = $thread->get('id');
        }

        $response = $this->runProcessor('web/message/create', $fields);

        /* @var modProcessorResponse $response */
        if ($response->isError()) {
            return $this->error($response->getMessage(), $response->getFieldErrors());
        }
        else{
            //if ($ticket = $this->modx->getObject('Ticket', $response->response['object']['id'])) {
            //    $ticket = $ticket->toArray();
            //    $this->sendTicketMails($ticket);
            //}
        }

        if(!empty($this->config['tplSuccess'])) {
            return $this->success('ec_fe_send_success', $this->modx->getChunk($this->config['tplSuccess'], $response->response['object']));
        }
        return $this->success('ec_fe_send_success', $response->response['object']);
    }


    /**
     * Shorthand for the call of processor
     *
     * @access public
     * @param string $action Path to processor
     * @param array $data Data to be transmitted to the processor
     * @return mixed The result of the processor
     */
    public function runProcessor($action = '', $data = array()) {
        if (empty($action)) {return false;}
        return $this->modx->runProcessor($action, $data, array('processors_path' => $this->config['processorsPath']));
    }

    /**
     * Sanitize MODX tags
     *
     * @param string $string Any string with MODX tags
     *
     * @return string String with html entities
     */
    public function sanitizeString($string = '') {
        $string = htmlentities(trim($string), ENT_QUOTES, "UTF-8");
        $string = preg_replace('/^@.*\b/', '', $string);
        $arr1 = array('[',']','`');
        $arr2 = array('&#091;','&#093;','&#096;');
        return str_replace($arr1, $arr2, $string);
    }


    /**
     * This method returns an error of the cart
     *
     * @param string $message A lexicon key for error message
     * @param array $data.Additional data, for example cart status
     * @param array $placeholders Array with placeholders for lexicon entry
     *
     * @return array|string $response
     */
    public function error($message = '', $data = array(), $placeholders = array()) {
        $response = array(
            'success' => false
            ,'message' => $this->modx->lexicon($message, $placeholders)
            ,'data' => $data
        );
        return $this->config['json_response']
            ? $this->modx->toJSON($response)
            : $response;
    }

    /* This method returns an success of the action
	 *
	 * @param string $message A lexicon key for success message
	 * @param array $data.Additional data, for example cart status
	 * @param array $placeholders Array with placeholders for lexicon entry
	 *
	 * @return array|string $response
	 * */
    public function success($message = '', $data = array(), $placeholders = array()) {
        $response = array(
            'success' => true
            ,'message' => $this->modx->lexicon($message, $placeholders)
            ,'data' => $data
        );
        return $this->config['json_response']
            ? $this->modx->toJSON($response)
            : $response;
    }
}