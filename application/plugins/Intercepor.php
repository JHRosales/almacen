<?php

require_once dirname(__FILE__) . '/../../library/Log4PHP/Logger.php';

class Application_Plugin_Intercepor extends Zend_Controller_Plugin_Abstract {

    private $_logger = null;
    private $_auth = null;
    private $_blackList = null;
    private $_executeController = null;
    private $_executeView = null;
    private $_cajexecuteView = null;
    
    private $_executeController2 = null;
    private $_executeView2 = null;
    
    private $_parametersObserverController = null;
    private $_parametersObserver = null;

    public function __construct(Zend_Auth $auth, array $options) {
        date_default_timezone_set(DATE_ZONE);
        Logger::configure(LOG_ACCESS);

        $this->_logger = Logger::getLogger(__CLASS__);
        $this->_auth = $auth;
        $this->_blackList = $options['blackList'];
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        $resource = $controller . ':' . $action;
        $auth = " [Acceso autorizado.]";

        $login = new Zend_Session_Namespace('datosuserlog');
        $nompers = $login->nompers;

        if (!in_array($resource, $this->_blackList) && ($nompers == '' || $nompers == null)) {
            if ($request->isXmlHttpRequest()) {
                $request->setControllerName('logeo')->setActionName('redirect');
            } else {
                $request->setControllerName('logeo')->setActionName('index');
            }
            $auth = " [Acceso no autorizado.]";
        }
        $this->_logger->info($resource . $auth);
    }

    public function postDispatch(Zend_Controller_Request_Abstract $request) {
    	
    }
}