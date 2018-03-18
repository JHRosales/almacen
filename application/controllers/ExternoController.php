<?php

class ExternoController extends Zend_Controller_Action {

    public function indexAction(){
        $this->_helper->layout()->setLayout('layout-externo');
    }
	public function helpAction()
	{
		$this->_helper->layout->disableLayout();
        $this->_helper->getHelper('ajaxContext')->initContext();
	}
    public function buscarAction(){
        //tramite.consulta_externa

        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        $this->_helper->getHelper('ajaxContext')->initContext();

        if ($this->getRequest()->isXmlHttpRequest()) {


        $nrodoc = $this->_request->getParam('nrodoc');
        $fecdoc = $this->_request->getParam('fecdoc');

        $cn = new Model_DataAdapter();
        $params = null;
        $params[] = array("@p_nrodoc", $nrodoc);
        $params[] = array("@p_fecdoc", $fecdoc);

        $docum = $cn->ejec_store_procedura_sql('tramite.consulta_externa', $params);
        $docum_count = count($docum);

        $result = '';
        if($docum){
            $result .= '<tr>';
            $result .= '<td><b>' . $docum[0][1] . '</b></td>';
            $result .= '<td><b>' . $docum[0][2] . '</b></td>';
            $result .= '<td><b>' . $docum[0][3] . '<br/>' . $docum[0][4] . '</b></td>';
            $result .= '<td><b>' . $docum[0][9] . '</b></td>';
            $result .= '</tr>';
        }else{
            $result .= '<tr>';
            $result .= '<td style="text-align:center;" colspan="4"><b>No se encontraron resultados con los parametros ingresados.</b></td>';
            $result .= '</tr>';
        }
        echo $result;
        }
    }
}