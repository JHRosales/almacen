<?php

require_once 'Zend/Controller/Action.php';

class ContenController extends Zend_Controller_Action {
    function indexAction(){
    }
    function tipoasuntoAction(){
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
        $this->view->showNavPanel = $this->_request->getPost('showNavPanel', 'true');
    }
    function itemsaveAction(){
        $this->_helper->viewRenderer->setNoRender();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();

            $p_schema = $this->_request->getPost('p_schema', '');
            $p_cidtabl = $this->_request->getPost('p_cidtabl', '');
            $p_idsigma = $this->_request->getPost('p_idsigma', '');
            $p_vdescri = $this->_request->getPost('p_vdescri', '');
            $p_nestado = $this->_request->getPost('p_nestado', '');

            $cn = new Model_DataAdapter();
            $params = null;
            $params[] = array('@p_schema', $p_schema);
            $params[] = array('@p_cidtabl', $p_cidtabl);
            $params[] = array('@p_idsigma', $p_idsigma);
            $params[] = array('@p_vdescri', strtoupper($p_vdescri));
            $params[] = array('@p_nestado', $p_nestado);

            $conten = $cn->executeAssocQuery('sp_conten_guardar', $params);
        }
    }
    function itemAction(){
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();

            $pschema = $this->_request->getPost('pschema', '');
            $idsigma = $this->_request->getPost('idsigma', '');

            $cn = new Model_DataAdapter();
            $params = null;
            $params[] = array('@p_schema', $pschema);
            $params[] = array('@p_idsigma', $idsigma);
            $conten = $cn->executeAssocQuery('sp_conten_item', $params);

            $this->view->idsigma = $conten[0]['idsigma'];
            $this->view->vdescri = $conten[0]['vdescri'];
            $this->view->nestado = $conten[0]['nestado'];

            //echo $idsigma;
        }
    }
}