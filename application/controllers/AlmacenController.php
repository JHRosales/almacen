<?php

require_once 'Zend/Controller/Action.php';

class AlmacenController extends Zend_Controller_Action {

    public function init() {
        $this->view->util()->registerScriptJSController($this->getRequest());
        $map = new Zend_Session_Namespace("map");
        $map->data = false;
    }

    public function indexAction() {
        
    }

    public function listarusuarioAction() {
        
    }
    public function buscarpersonaAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsigma = $this->_request->getPost('idsigma');
            $pag = $this->_request->getPost('pag');
            $this->view->idsigma = $idsigma;
            $this->view->pag = $pag;
        }
    }
    public function buscartecnicoAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsigma = $this->_request->getPost('idsigma');
            $this->view->idsigma = $idsigma;
        }
    }

    public function entradamatsaveAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idprov = $this->_request->getPost('idsigma');
            $identr = $this->_request->getPost('idEntrada');
            $params = null;
            $params[] = array('@ttrans', "1");
            $params[] = array('@idEntrada',$identr);
            $params[] = array('@idProveedor', $idprov);
            $params[] = array('@idServicio', "1");
            $params[] = array('@vHostnm', $host);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $person = $cn->executeAssocQuery('almacen.InsUpd_entradaMat', $params);
           // $cperson = count($person);
            echo json_encode($person);
        }
    }


    public function entradamatupdateAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idcot = $this->_request->getPost('idsigma');
            $subtot = $this->_request->getPost('subtotal');
            $igv = $this->_request->getPost('igv');
            $total = $this->_request->getPost('total');
            $fecha = $this->_request->getPost('fecha');
            $factura = $this->_request->getPost('factura');



            $params = null;
            $params[] = array('@ttrans', "2");
            $params[] = array('@idEntrada', $idcot);
            $params[] = array('@idServicio', 1);
            $params[] = array('@vFacturaComp',$factura);
            $params[] = array('@p_igv', $igv);
            $params[] = array('@p_sub',$subtot );
            $params[] = array('@nPrecioTotal', $total);
            $params[] = array('@dFecIngreso', $fecha);
            $params[] = array('@vEstado', "1");
            $params[] = array('@vUsernm', $usuario);
            $params[] = array('@vHostnm', $host);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->ejec_store_procedura_sql('almacen.InsUpd_entradaMat', $params);
             echo json_encode($detcot);
        }
    }
    public function entradaprodsaveAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idprov = $this->_request->getPost('idsigma');
            $identr = $this->_request->getPost('idEntrada');
            $params = null;
            $params[] = array('@ttrans', "1");
            $params[] = array('@idEntrada',$identr);
            $params[] = array('@idProveedor', $idprov);
            $params[] = array('@vHostnm', $host);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $person = $cn->executeAssocQuery('almacen.InsUpd_entradaProd', $params);
            // $cperson = count($person);
            echo json_encode($person);
        }
    }
    public function detentradaprodupdateAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $iddentr = $this->_request->getPost('idDetEntradaProd');
            $punit = $this->_request->getPost('nPrecioUnit');
            $canti = $this->_request->getPost('nCantidad');
            $ptotal = $this->_request->getPost('nPrecTotal');

            $params = null;
            $params[] = array('@p_idDetEntradaProd', $iddentr);
            $params[] = array('@p_nPrecUnit',$punit);
            $params[] = array('@p_nCantidad', $canti);
            $params[] = array('@p_nPrecTota', $ptotal);
            $params[] = array('@p_vHost', $host);
            $params[] = array('@p_vUser', $usuario);
            $detcot = $cn->ejec_store_procedura_sql('update_detEntradaProd', $params);
            //echo json_encode($detcot);
        }
    }

    public function guardarseriesAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $pSeries = $this->_request->getParam('objSeries');
            $jSeries = json_decode($pSeries);

            $idproducto =  $jSeries->idproducto;
            $identradaProd= $jSeries->identradaProd;

            #########Se cambia el estado a todos los registros de 1 a X (para que al final se eliminen los registros sobrantes)
            $_procedure = 'almacen.cambiarEstado_prodSeries';
            $params[] = array('@p_idDetEntradaProd', $identradaProd);
            $params[] = array('@p_idProd', $idproducto);
            $result = $cn->executeAssocQuery($_procedure, $params);


            foreach ($jSeries->lstSeries as $value) {
                $params = null;
                $params[] = array('@p_idProdSeries', $value->idProdSeries);#p_idprodSeries
                $params[] = array('@p_idDetEntradaProd', $identradaProd);
                $params[] = array('@p_idProducto', $idproducto);
                $params[] = array('@p_vNroSerie',$value->vNroSerie);
                $params[] = array('@p_vEstadoAlma',"1");
                $params[] = array('@p_vEstado',"1");
                $params[] = array('@p_vHost', $host); #Host
                $params[] = array('@p_vUser', $usuario);#usuario
                $detcot = $cn->ejec_store_procedura_sql('almacen.InsUpd_ProdSeries', $params);
            }

            ############Se eliminan los regitros que tengan estado X por que son registros que se quitaron de la lista
            $_procedure = 'almacen.eliminar_ProdSeries';
            $params = null;
            $params[] = array('@p_idDetEntradaProd', $identradaProd);
            $params[] = array('@p_idProd', $idproducto);
            $result2 = $cn->executeAssocQuery($_procedure, $params);


            print_r(json_encode($result2[0]));
        }
    }
    public function entradaprodupdateAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $ident = $this->_request->getPost('idsigma');
            $subtot = $this->_request->getPost('subtotal');
            $igv = $this->_request->getPost('igv');
            $total = $this->_request->getPost('total');
            $fecha = $this->_request->getPost('fecha');
            $factura = $this->_request->getPost('factura');



            $params = null;
            $params[] = array('@ttrans', "2");
            $params[] = array('@idEntrada', $ident);
            $params[] = array('@vFacturaComp',$factura);
            $params[] = array('@p_igv', $igv);
            $params[] = array('@p_sub',$subtot );
            $params[] = array('@nPrecioTotal', $total);
            $params[] = array('@dFecIngreso', $fecha);
            $params[] = array('@vEstado', "1");
            $params[] = array('@vUsernm', $usuario);
            $params[] = array('@vHostnm', $host);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->ejec_store_procedura_sql('almacen.InsUpd_entradaProd', $params);
            echo json_encode($detcot);
        }
    }

    public function entradamatAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
        //$this->view->fechaini=date('d/m/Y');
        //$this->view->fechafin=date('d/m/Y');
        $this->view->idcotiz="se";

    }
    public function entradaprodAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
        //$this->view->fechaini=date('d/m/Y');
        //$this->view->fechafin=date('d/m/Y');
        $this->view->idcotiz="se";

    }
    public function salidamatAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
        //$this->view->fechaini=date('d/m/Y');
        //$this->view->fechafin=date('d/m/Y');
        $this->view->idcotiz="se";

    }
    public function salidaprodAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
        //$this->view->fechaini=date('d/m/Y');
        //$this->view->fechafin=date('d/m/Y');
        $this->view->idcotiz="se";

    }
    public function retornomatAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
        //$this->view->fechaini=date('d/m/Y');
        //$this->view->fechafin=date('d/m/Y');
        $this->view->idcotiz="se";

    }
    public function retornoprodAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
        //$this->view->fechaini=date('d/m/Y');
        //$this->view->fechafin=date('d/m/Y');
        $this->view->idcotiz="se";

    }
    public function detentradamatAction() {
        $this->view->tieneop=0;
        $this->view->vMotivo="SISTEMA CCTV HDCVI - HD";
        $this->view->vFormaPago="Al contado";
        $this->view->dfecentrada = date('d/m/Y');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idcotizacion = $this->_request->getParam('idEntradaMat');
            $this->view->idcotizacion =$idcotizacion;
            $cn = new Model_DataAdapter ();
            $params[] = array('@tBusqueda', "1");
            $params[] = array('@vDatoBus', $idcotizacion);
            $params[] = array('@vFecIni', "");
            $params[] = array('@vFecFin', "");
            $datos = $cn->ejec_store_procedura_sql('almacen.Bus_EntradaMat', $params);

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->idEntradaMat =$datos[0][0];
                $this->view->idProveedor=$datos[0][1];
                $this->view->nombreproveed=$datos[0][2];
                $this->view->nrofactura=$datos[0][3];
                $this->view->subtotal=$datos[0][4];
                $this->view->igv=$datos[0][5];
                $this->view->total=$datos[0][6];
                $this->view->dfecentrada =$datos[0][7];
            }else{
            $this->view->idEntradaMat =$datos[0][0];
            $this->view->idProveedor=$datos[0][1];
            $this->view->nombreproveed=$datos[0][2];
            $this->view->nrofactura=$datos[0][3];
            $this->view->subtotal=$datos[0][4];
            $this->view->igv=$datos[0][5];
            $this->view->total=$datos[0][6];
            $this->view->dfecentrada =$datos[0][7];
            }
        }
    }

public function detentradaprodAction() {
    $this->view->tieneop=0;
    $this->view->vMotivo="SISTEMA CCTV HDCVI - HD";
    $this->view->vFormaPago="Al contado";
    $this->view->dfecentrada = date('d/m/Y');
    if ($this->getRequest()->isXmlHttpRequest()) {
        $this->_helper->getHelper('ajaxContext')->initContext();
        $this->_helper->layout->disableLayout();
        $identradaprod = $this->_request->getParam('idEntradaProd');
        $this->view->idEntradaProd =$identradaprod;
        $cn = new Model_DataAdapter ();
        $params[] = array('@tBusqueda', "1");
        $params[] = array('@vDatoBus', $identradaprod);
        $params[] = array('@vFecIni', "");
        $params[] = array('@vFecFin', "");
        $datos = $cn->ejec_store_procedura_sql('almacen.Bus_EntradaProd', $params);

        $cdatos = count($datos);
        if ($cdatos == 0) {
            $this->view->idEntradaProd =$datos[0][0];
            $this->view->idProveedor=$datos[0][1];
            $this->view->nombreproveed=$datos[0][2];
            $this->view->nrofactura=$datos[0][3];
            $this->view->subtotal=$datos[0][4];
            $this->view->igv=$datos[0][5];
            $this->view->total=$datos[0][6];
            $this->view->dfecentrada =$datos[0][7];
        }else{
            $this->view->idEntradaProd =$datos[0][0];
            $this->view->idProveedor=$datos[0][1];
            $this->view->nombreproveed=$datos[0][2];
            $this->view->nrofactura=$datos[0][3];
            $this->view->subtotal=$datos[0][4];
            $this->view->igv=$datos[0][5];
            $this->view->total=$datos[0][6];
            $this->view->dfecentrada =$datos[0][7];
        }
    }
}

    public function detretornomatAction() {
        $this->view->tieneop=0;
        $this->view->dFecSalida = date('d/m/Y');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsalidamat = $this->_request->getParam('idSalidaMat');
            $this->view->idsalidamat =$idsalidamat;
            $cn = new Model_DataAdapter ();
            $params[] = array('@tBusqueda', "3");
            $params[] = array('@vDatoBus', $idsalidamat);
            $params[] = array('@vFecIni', "");
            $params[] = array('@vFecFin', "");
            $datos = $cn->ejec_store_procedura_sql('almacen.List_RetornoMat', $params);

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->idRetornoMat =$datos[0][0];
                $this->view->idSalidaMat =$datos[0][1];
                $this->view->dFecSalida =$datos[0][2];
                $this->view->dFecRetorno =$datos[0][3];
                $this->view->obra=$datos[0][4];
                $this->view->lugar=$datos[0][5];
                $this->view->idtecnico=$datos[0][6];
                $this->view->nomtecnico=$datos[0][7];

            }else{
                $this->view->idRetornoMat =$datos[0][0];
                $this->view->idSalidaMat =$datos[0][1];
                $this->view->dFecSalida =$datos[0][2];
                $this->view->dFecRetorno =$datos[0][3];
                $this->view->obra=$datos[0][4];
                $this->view->lugar=$datos[0][5];
                $this->view->idtecnico=$datos[0][6];
                $this->view->nomtecnico=$datos[0][7];
            }

            $arrDetMateriales = array();
            $params_mat[] = array('@tBusqueda', "0"); #p_idsigma
            $params_mat[] = array('@vIdSalidaMat',$idsalidamat);#p_mpapeleta
            $params_mat[] = array('@vDatoBus', "");#p_mpapeleta
            $params_mat[] = array('@vFecIni', "");#p_mpapeleta
            $params_mat[] = array('@vFecFin', "");#p_mpapeleta
            $dtbdtestigo = $cn->executeAssocQuery("almacen.Bus_DetRetornoMat", $params_mat);
            if (count($dtbdtestigo) > 0) {
                $arrDetMateriales = $dtbdtestigo;
            }

        $this->view->detMateriales = $arrDetMateriales;

        }
    }
    public function detsalidamatAction() {
        $this->view->tieneop=0;
        $this->view->dFecSalida = date('d/m/Y');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsalidamat = $this->_request->getParam('idSalidaMat');
            $this->view->idsalidamat =$idsalidamat;
            $cn = new Model_DataAdapter ();
            $params[] = array('@tBusqueda', "2");
            $params[] = array('@vDatoBus', $idsalidamat);
            $params[] = array('@vFecIni', "");
            $params[] = array('@vFecFin', "");
            $datos = $cn->ejec_store_procedura_sql('almacen.List_SalidaMat', $params);

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->idSalidaMat =$datos[0][0];
                $this->view->dFecSalida =$datos[0][1];
                $this->view->obra=$datos[0][2];
                $this->view->lugar=$datos[0][3];
                $this->view->idtecnico=$datos[0][4];
                $this->view->nomtecnico=$datos[0][5];

            }else{
                $this->view->idSalidaMat =$datos[0][0];
                $this->view->dFecSalida =$datos[0][1];
                $this->view->obra=$datos[0][2];
                $this->view->lugar=$datos[0][3];
                $this->view->idtecnico=$datos[0][4];
                $this->view->nomtecnico=$datos[0][5];
            }
            $arrDetMateriales = array();
            $params_mat[] = array('@tBusqueda', "0");
            $params_mat[] = array('@vIdSalidaMat',$idsalidamat);
            $params_mat[] = array('@vDatoBus', "");
            $params_mat[] = array('@vFecIni', "");
            $params_mat[] = array('@vFecFin', "");
            $dtbdtestigo = $cn->executeAssocQuery("almacen.Bus_DetSalidaMat", $params_mat);
            if (count($dtbdtestigo) > 0) {
                $arrDetMateriales = $dtbdtestigo;
            }

            $this->view->detSalidaMat = $arrDetMateriales;

        }
    }


    public function addpsmAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsigma = $this->_request->getPost('idsigma');
            $iddetentrada = $this->_request->getPost('iddetentrada');
            $idMaterial = $this->_request->getPost('idMaterial');
            $nCantidad = $this->_request->getPost('nCantidad');
            $nPrecioUnit = $this->_request->getPost('nPrecioUnit');
            $this->view->identrdamat = $idsigma;
            $this->view->iddetentrada = $iddetentrada;
            $this->view->idMaterial = $idMaterial;
            $this->view->cantidad = $nCantidad;
            $this->view->punitario = $nPrecioUnit;
        }
    }

    public function addproductoAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsigma = $this->_request->getPost('idsigma');
            $iddetentrada = $this->_request->getPost('iddetentrada');
            $idProd = $this->_request->getPost('idProducto');
            $this->view->identradaprod = $idsigma;
            $this->view->iddetentrada = $iddetentrada;
            $this->view->idProducto = $idProd;
        }
    }
    public function ingresarseriesAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsigma = $this->_request->getPost('idsigma');
            $idprod = $this->_request->getPost('idProducto');
            $nombproduct = $this->_request->getPost('nombreProd');
            $nCantidad = $this->_request->getPost('nCantidad');
            $this->view->iddetentradaprod = $idsigma;
            $this->view->idproducto = $idprod;
            $this->view->nombreprod = $nombproduct;
            $this->view->cantidad = $nCantidad;
        }
    }

    public function detentradaprodaddAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idprod = $this->_request->getPost('id');
            $identrada = $this->_request->getPost('identradaprod');
            $iddetentrada = $this->_request->getPost('iddetentradaprod');
            $iddetentrada = $this->_request->getPost('iddetentradaprod');
            //$Cantidad = $this->_request->getPost('Cantidad');
            //$PrecioUnitario = $this->_request->getPost('PrecioUnitario');
            //$total =(int) $Cantidad * (double) $PrecioUnitario;
            $params = null;
            $params[] = array('@p_idprod',$idprod);
            $params[] = array('@p_identradaprod', $identrada);
            $params[] = array('@p_iddetentradaprod', $iddetentrada);
            //$params[] = array('@p_cantidad', $Cantidad);
            //$params[] = array('@p_preciounitario', $PrecioUnitario);
           // $params[] = array('@p_total', $total);

            $detcot = $cn->executeAssocQuery('add_detentradaprod', $params);
            $cperson = count($detcot);
            echo json_encode($detcot);
        }
    }
    public function detentradamataddAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idmat = $this->_request->getPost('id');
            $identradamat = $this->_request->getPost('identradamat');
            $iddetentradamat = $this->_request->getPost('iddetentradamat');
            $Cantidad = $this->_request->getPost('Cantidad');
            $PrecioUnitario = $this->_request->getPost('PrecioUnitario');
            $total =(int) $Cantidad * (double) $PrecioUnitario;
            $params = null;
            $params[] = array('@p_idmat',$idmat);
            $params[] = array('@p_identradamat', $identradamat);
            $params[] = array('@p_iddetentradamat', $iddetentradamat);
            $params[] = array('@p_cantidad', $Cantidad);
            $params[] = array('@p_preciounitario', $PrecioUnitario);
            $params[] = array('@p_total', $total);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->executeAssocQuery('add_detentradamat', $params);
            $cperson = count($detcot);
            echo json_encode($detcot);
        }
    }

    public function listarseriesAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();

            $tBusqueda = $this->_request->getPost('tBusqueda');
            $vDatoBus = $this->_request->getPost('vDatoBus');
            $vIddetEntradaProd = $this->_request->getPost('vIddetEntradaProd');
            $params = null;
            $params[] = array('@tBusqueda',$tBusqueda);
            $params[] = array('@vDatoBus', $vDatoBus);
            $params[] = array('@vIddetEntradaProd', $vIddetEntradaProd);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->executeAssocQuery('almacen.Bus_ProdSeries', $params);
            $cperson = count($detcot);
            echo json_encode($detcot);
        }
    }

    public function guardarsalidamatAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $userlogin = $ddatosuserlog->userlogin;

            $pPapeleta = $this->_request->getParam('objSalidaMat');
            $jPapeleta = json_decode($pPapeleta);

            $dataSet = new Model_DataAdapter();
            if ($jPapeleta->idSalidaMat == "") {
                $trans = "1";
            } else {
                $trans = "2";
            }
            $_procedure = 'almacen.InsUpd_salidaMat';
            $params[] = array('@ttrans', $trans);
            $params[] = array('@p_idsalidamat', $jPapeleta->idSalidaMat);
            $params[] = array('@p_obra', $jPapeleta->obra);
            $params[] = array('@p_lugar', $jPapeleta->lugar);
            $params[] = array('@p_fecha', $jPapeleta->fecha);
            $params[] = array('@p_idtecnico', $jPapeleta->idtecnico);
            $params[] = array('@vUsernm', $userlogin);
            $params[] = array('@vHostnm', 'local');

            $resultPapeleta = $dataSet->executeAssocQuery($_procedure, $params);

            $_proc_dtestigo = 'add_detsalidamat';

            foreach ($jPapeleta->materiales as $value) {
                $params = null;
                $params[] = array('@p_idmat', $value->idMaterial);  #p_idsigma
                $params[] = array('@p_idsalidamat', $resultPapeleta[0]["idSalidaMat"]);   #p_mpapeleta
                $params[] = array('@p_iddetsalidamat',  $value->idDetSalidaMat);  #p_mperson
                $params[] =  array('@p_cantidad',  $value->Cantidad); #cantidad
                //print_r($params);
                $permiso = $dataSet->ejec_store_procedura_sql($_proc_dtestigo, $params);
            }

            print_r(json_encode($resultPapeleta[0]));
            // print_r(json_encode($resultDescta[0]["b"]));
        }
    }
    public function guardarretornomatAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $userlogin = $ddatosuserlog->userlogin;

            $pPapeleta = $this->_request->getParam('objSalidaMat');
            $jPapeleta = json_decode($pPapeleta);

            $dataSet = new Model_DataAdapter();
            if ($jPapeleta->idRetornoMat == "") {
                $trans = "1";
            } else {
                $trans = "2";
            }
            $_procedure = 'almacen.InsUpd_retornoMat';
            $params[] = array('@ttrans', $trans);
            $params[] = array('@p_idretornomat', $jPapeleta->idRetornoMat);
            $params[] = array('@p_idsalidamat', $jPapeleta->idSalidaMat);
            $params[] = array('@p_obra', $jPapeleta->obra);
            $params[] = array('@p_lugar', $jPapeleta->lugar);
            $params[] = array('@p_fecha', $jPapeleta->fecha);
            $params[] = array('@p_idtecnico', $jPapeleta->idtecnico);
            $params[] = array('@vUsernm', $userlogin);
            $params[] = array('@vHostnm', 'local');

            $resultPapeleta = $dataSet->executeAssocQuery($_procedure, $params);

            $_proc_dtestigo = 'add_detretornomat';

            foreach ($jPapeleta->materiales as $value) {
                $params = null;
                $params[] = array('@p_idmat', $value->idMaterial);  #p_idsigma
                $params[] = array('@p_idretornomat', $resultPapeleta[0]["idRetornoMat"]);   #p_mpapeleta
                $params[] = array('@p_iddetretornomat',  $value->idDetRetornoMat);  #p_mperson
                $params[] =  array('@p_cantidad',  $value->cantidadRetorno); #cantidad
                $params[] =  array('@p_observ',  $value->observacion); #cantidad
                //print_r($params);
                $permiso = $dataSet->ejec_store_procedura_sql($_proc_dtestigo, $params);
            }

            print_r(json_encode($resultPapeleta[0]));
            // print_r(json_encode($resultDescta[0]["b"]));
        }
    }

##########detalle Salida Producto
    public function detsalidaprodAction() {
        $this->view->tieneop=0;
        $this->view->dFecSalida = date('d/m/Y');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsalidamat = $this->_request->getParam('idSalidaProd');
            $this->view->idsalidamat =$idsalidamat;
            $cn = new Model_DataAdapter ();
            $params[] = array('@tBusqueda', "2");
            $params[] = array('@vDatoBus', $idsalidamat);
            $params[] = array('@vFecIni', "");
            $params[] = array('@vFecFin', "");
            $datos = $cn->ejec_store_procedura_sql('almacen.List_SalidaMat', $params);

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->idSalidaMat =$datos[0][0];
                $this->view->dFecSalida =$datos[0][1];
                $this->view->obra=$datos[0][2];
                $this->view->lugar=$datos[0][3];
                $this->view->idtecnico=$datos[0][4];
                $this->view->nomtecnico=$datos[0][5];

            }else{
                $this->view->idSalidaMat =$datos[0][0];
                $this->view->dFecSalida =$datos[0][1];
                $this->view->obra=$datos[0][2];
                $this->view->lugar=$datos[0][3];
                $this->view->idtecnico=$datos[0][4];
                $this->view->nomtecnico=$datos[0][5];
            }
            $arrDetMateriales = array();
            $params_mat[] = array('@tBusqueda', "0");
            $params_mat[] = array('@vIdSalidaMat',$idsalidamat);
            $params_mat[] = array('@vDatoBus', "");
            $params_mat[] = array('@vFecIni', "");
            $params_mat[] = array('@vFecFin', "");
            $dtbdtestigo = $cn->executeAssocQuery("almacen.Bus_DetSalidaMat", $params_mat);
            if (count($dtbdtestigo) > 0) {
                $arrDetMateriales = $dtbdtestigo;
            }

            $this->view->detSalidaMat = $arrDetMateriales;

        }
    }


    public function detretornoprodAction() {
        $this->view->tieneop=0;
        $this->view->dFecSalida = date('d/m/Y');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsalidamat = $this->_request->getParam('idSalidaProd');
            $this->view->idsalidamat =$idsalidamat;
            $cn = new Model_DataAdapter ();
            $params[] = array('@tBusqueda', "3");
            $params[] = array('@vDatoBus', $idsalidamat);
            $params[] = array('@vFecIni', "");
            $params[] = array('@vFecFin', "");
            $datos = $cn->ejec_store_procedura_sql('almacen.List_RetornoMat', $params);

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->idRetornoMat =$datos[0][0];
                $this->view->idSalidaMat =$datos[0][1];
                $this->view->dFecSalida =$datos[0][2];
                $this->view->dFecRetorno =$datos[0][3];
                $this->view->obra=$datos[0][4];
                $this->view->lugar=$datos[0][5];
                $this->view->idtecnico=$datos[0][6];
                $this->view->nomtecnico=$datos[0][7];

            }else{
                $this->view->idRetornoMat =$datos[0][0];
                $this->view->idSalidaMat =$datos[0][1];
                $this->view->dFecSalida =$datos[0][2];
                $this->view->dFecRetorno =$datos[0][3];
                $this->view->obra=$datos[0][4];
                $this->view->lugar=$datos[0][5];
                $this->view->idtecnico=$datos[0][6];
                $this->view->nomtecnico=$datos[0][7];
            }

            $arrDetMateriales = array();
            $params_mat[] = array('@tBusqueda', "0"); #p_idsigma
            $params_mat[] = array('@vIdSalidaMat',$idsalidamat);#p_mpapeleta
            $params_mat[] = array('@vDatoBus', "");#p_mpapeleta
            $params_mat[] = array('@vFecIni', "");#p_mpapeleta
            $params_mat[] = array('@vFecFin', "");#p_mpapeleta
            $dtbdtestigo = $cn->executeAssocQuery("almacen.Bus_DetRetornoMat", $params_mat);
            if (count($dtbdtestigo) > 0) {
                $arrDetMateriales = $dtbdtestigo;
            }

            $this->view->detMateriales = $arrDetMateriales;

        }
    }
















/*
    public function cotizacionopcionalapricipalAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idcot = $this->_request->getPost('idDetCotiz');

            $params = null;
            $params[] = array('@p_iddcotiz', $idcot);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->ejec_store_procedura_sql('update_cotiz_opcprin1', $params);
            // echo json_encode($detcot);
        }
    }
    public function cotizaciondelAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idcot = $this->_request->getPost('idCotiz');

            $params = null;
            $params[] = array('@p_idcotiz', $idcot);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->ejec_store_procedura_sql('delete_cotiz1', $params);
             //echo json_encode("Desabilitado.");
        }
    }

    public function detentradamatdelAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $iddentrada = $this->_request->getPost('idDetEntradaMat');

            $params = null;
            $params[] = array('@p_iddentradamat', $iddentrada);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->ejec_store_procedura_sql('delete_dentradamat', $params);
            echo json_encode($detcot);
        }
    }

    public function copiarcotizAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idcotiz = $this->_request->getPost('idCotiz');
            $params = null;
            $params[] = array('@p_idcotiz', $idcotiz);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $copiarcot = $cn->executeAssocQuery('copiar_cotizacion1', $params);
            echo json_encode($copiarcot);
        }
    }
    public function eliminarcotizacionAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idcotiz = $this->_request->getPost('idCotiz');
            $params = null;
            $params[] = array('@p_idcotiz', $idcotiz);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $copiarcot = $cn->executeAssocQuery('eliminar_cotizacion1', $params);
            echo json_encode($copiarcot);
        }
    }

    public function visordocsAction() {

        $img = $this->_request->getParam('img', '');
        $this->_helper->layout->disableLayout();
        $this->view->img = $img;
    }*/



    
}
