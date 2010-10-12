<?php

require_once('dd_logging_LogFactory.php');
require_once('dd_logging_ILogger.php');

require_once('lithe_IController.php');
require_once('lithe_Model.php');

require_once('substrate_Context.php');
require_once('substrate_stones_IContextAware.php');

require_once('halo_ModelAndView.php');

class lithe_Controller implements lithe_IController, substrate_stones_IContextAware {
    
    /**
     * Default view
     * Enter description here ...
     * @var string
     */
    protected $defaultView = 'default';
    
    /**
     * Name of selected view
     * @var string
     */
    protected $view;
    
    /**
     * Model data
     * Enter description here ...
     * @var unknown_type
     */
    protected $model;
    
    /**
     * Logger
     * @var dd_logging_ILogger
     */
    static public $LOGGER;

    /**
     * Substrate context
     * @var substrate_Context
     */
    protected $context;
    
    /**
     * Constructor
     */
    public function __construct() {
        if ( self::$LOGGER->isDebugEnabled() ) {
            self::$LOGGER->debug('In constructor.');
        }
        $this->model = $this->data = new lithe_Model();
    }
    
    /**
     * Inform controller about Substrate context
     * @param $context
     */
    public function informAboutContext(substrate_Context $context) {
        if ( self::$LOGGER->isDebugEnabled() ) {
            self::$LOGGER->debug('Informed of Substrate context startup.');
        }
        $this->context = $context;
    }
    
    /**
     * Generate Halo's Model and View
     * @return halo_ModelAndView
     */
    public function generateHaloModelAndView() {
        return new halo_ModelAndView($this->view ? $this->view : $this->defaultView, $this->model->export());
    }

}

lithe_Controller::$LOGGER = dd_logging_LogFactory::get('lithe_Controller');