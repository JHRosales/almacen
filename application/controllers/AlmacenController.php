<?php

require_once 'Zend/Controller/Action.php';

class AlmacenController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->util()->registerScriptJSController($this->getRequest());
        $map = new Zend_Session_Namespace("map");
        $map->data = false;
    }

    public function indexAction()
    {
    }

    public function listarusuarioAction()
    {
    }
    public function buscarpersonaAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsigma = $this->_request->getPost('idsigma');
            $pag = $this->_request->getPost('pag');
            $this->view->idsigma = $idsigma;
            $this->view->pag = $pag;
        }
    }
    public function buscartecnicoAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsigma = $this->_request->getPost('idsigma');
            $this->view->idsigma = $idsigma;
        }
    }

    public function entradamatsaveAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idprov = $this->_request->getPost('idsigma');
            $identr = $this->_request->getPost('idEntrada');
            $params = null;
            $params[] = array('@ttrans', "1");
            $params[] = array('@idEntrada', $identr);
            $params[] = array('@idProveedor', $idprov);
            $params[] = array('@idServicio', "1");
            $params[] = array('@vHostnm', $host);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $person = $cn->executeAssocQuery('almacen.InsUpd_entradaMat', $params);
            // $cperson = count($person);
            echo json_encode($person);
        }
    }


    public function entradamatupdateAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idcot = $this->_request->getPost('idsigma');
            $subtot = $this->_request->getPost('subtotal');
            $igv = $this->_request->getPost('igv');
            $total = $this->_request->getPost('total');
            $fecha = $this->_request->getPost('fecha');
            $factura = $this->_request->getPost('factura');
            $tipomon = $this->_request->getPost('tipoMoneda');



            $params = null;
            $params[] = array('@ttrans', "2");
            $params[] = array('@idEntrada', $idcot);
            $params[] = array('@idServicio', 1);
            $params[] = array('@vFacturaComp', $factura);
            $params[] = array('@p_igv', $igv);
            $params[] = array('@p_sub', $subtot);
            $params[] = array('@nPrecioTotal', $total);
            $params[] = array('@dFecIngreso', $fecha);
            $params[] = array('@vEstado', "1");
            $params[] = array('@vUsernm', $usuario);
            $params[] = array('@vHostnm', $host);
            $params[] = array('@vTipomon', $tipomon);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->ejec_store_procedura_sql('almacen.InsUpd_entradaMat', $params);

            //Se pasa a estado Desabilitado los que estan eliminado temporalmente (5= Eliminado Temporal, 4= Desabilitado)
            $_proc_okEliminado = 'almacen.Entrada_OKmatpasaAeliminado';
            $params1[] = array('@p_idEntradamat', $idcot); // $jPapeleta->idSalidaMat);
            $resultEok = $cn->executeAssocQuery($_proc_okEliminado, $params1);


            echo json_encode($detcot);
        }
    }
    public function entradaprodsaveAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idprov = $this->_request->getPost('idsigma');
            $identr = $this->_request->getPost('idEntrada');
            $params = null;
            $params[] = array('@ttrans', "1");
            $params[] = array('@idEntrada', $identr);
            $params[] = array('@idProveedor', $idprov);
            $params[] = array('@vHostnm', $host);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $person = $cn->executeAssocQuery('almacen.InsUpd_entradaProd', $params);
            // $cperson = count($person);
            echo json_encode($person);
        }
    }
    public function detentradaprodupdateAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $iddentr = $this->_request->getPost('idDetEntradaProd');
            $punit = $this->_request->getPost('nPrecioUnit');
            $canti = $this->_request->getPost('nCantidad');
            $ptotal = $this->_request->getPost('nPrecTotal');

            $params = null;
            $params[] = array('@p_idDetEntradaProd', $iddentr);
            $params[] = array('@p_nPrecUnit', $punit);
            $params[] = array('@p_nCantidad', $canti);
            $params[] = array('@p_nPrecTota', $ptotal);
            $params[] = array('@p_vHost', $host);
            $params[] = array('@p_vUser', $usuario);
            $detcot = $cn->ejec_store_procedura_sql('update_detEntradaProd', $params);
            //echo json_encode($detcot);
        }
    }

    public function guardarseriesAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $pSeries = $this->_request->getParam('objSeries');
            $jSeries = json_decode($pSeries);

            $idproducto =  $jSeries->idproducto;
            $identradaProd = $jSeries->identradaProd;

            #########Se cambia el estado a todos los registros de 1 a X (para que al final se eliminen los registros sobrantes)
            $_procedure = 'almacen.cambiarEstado_prodSeries';
            $params[] = array('@p_idDetEntradaProd', $identradaProd);
            $params[] = array('@p_idProd', $idproducto);
            $result = $cn->executeAssocQuery($_procedure, $params);


            foreach ($jSeries->lstSeries as $value) {
                $params = null;
                $params[] = array('@p_idProdSeries', $value->idProdSeries); #p_idprodSeries
                $params[] = array('@p_idDetEntradaProd', $identradaProd);
                $params[] = array('@p_idProducto', $idproducto);
                $params[] = array('@p_vNroSerie', $value->vNroSerie);
                $params[] = array('@p_vEstadoAlma', "1");
                $params[] = array('@p_vEstado', "1");
                $params[] = array('@p_vHost', $host); #Host
                $params[] = array('@p_vUser', $usuario); #usuario
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
    public function entradaprodupdateAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $ident = $this->_request->getPost('idsigma');
            $subtot = $this->_request->getPost('subtotal');
            $igv = $this->_request->getPost('igv');
            $total = $this->_request->getPost('total');
            $fecha = $this->_request->getPost('fecha');
            $factura = $this->_request->getPost('factura');
            $tipomon = $this->_request->getPost('tipoMoneda');



            $params = null;
            $params[] = array('@ttrans', "2");
            $params[] = array('@idEntrada', $ident);
            $params[] = array('@vFacturaComp', $factura);
            $params[] = array('@p_igv', $igv);
            $params[] = array('@p_sub', $subtot);
            $params[] = array('@nPrecioTotal', $total);
            $params[] = array('@dFecIngreso', $fecha);
            $params[] = array('@vEstado', "1");
            $params[] = array('@vUsernm', $usuario);
            $params[] = array('@vHostnm', $host);
            $params[] = array('@vTipoMon', $tipomon);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->ejec_store_procedura_sql('almacen.InsUpd_entradaProd', $params);

            //Se pasa a estado Desabilitado los que estan eliminado temporalmente (5= Eliminado Temporal, 4= Desabilitado)
            $_proc_okEliminado = 'almacen.Entrada_OKprodpasaAeliminado';
            $params1[] = array('@p_idEntradaprod', $ident); // $jPapeleta->idSalidaMat);
            $resultEok = $cn->executeAssocQuery($_proc_okEliminado, $params1);


            echo json_encode($detcot);
        }
    }

    public function entradamatAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
        //$this->view->fechaini=date('d/m/Y');
        //$this->view->fechafin=date('d/m/Y');
        $this->view->idcotiz = "se";

        $cn = new Model_DataAdapter();
        $params[] = array('@p_identradamat', '');
        $copiarcot = $cn->executeAssocQuery('eliminar_entradamat', $params);
    }
    public function entradaprodAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
        // $this->view->fechaini=date('d/m/Y', strtotime('yesterday'));
        //$this->view->fechafin=date('d/m/Y');
        $this->view->idcotiz = "se";
        $cn = new Model_DataAdapter();
        $params[] = array('@p_identradaprod', '');
        $copiarcot = $cn->executeAssocQuery('eliminar_entradaprod', $params);
    }
    public function salidamatAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
        //$this->view->fechaini=date('d/m/Y');
        //$this->view->fechafin=date('d/m/Y');
        $this->view->idcotiz = "se";
    }
    public function salidaprodAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
        //$this->view->fechaini=date('d/m/Y');
        //$this->view->fechafin=date('d/m/Y');
        $this->view->idcotiz = "se";
    }
    public function retornomatAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
        //$this->view->fechaini=date('d/m/Y');
        //$this->view->fechafin=date('d/m/Y');
        $this->view->idcotiz = "se";
    }
    public function retornoprodAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
        //$this->view->fechaini=date('d/m/Y');
        //$this->view->fechafin=date('d/m/Y');
        $this->view->idcotiz = "se";
    }
    public function detentradamatAction()
    {
        $this->view->tieneop = 0;
        $this->view->vMotivo = "SISTEMA CCTV HDCVI - HD";
        $this->view->vFormaPago = "Al contado";
        $this->view->dfecentrada = date('d/m/Y');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idcotizacion = $this->_request->getParam('idEntradaMat');
            $this->view->idcotizacion = $idcotizacion;
            $cn = new Model_DataAdapter();
            $params[] = array('@tBusqueda', "1");
            $params[] = array('@vDatoBus', $idcotizacion);
            $params[] = array('@vFecIni', "");
            $params[] = array('@vFecFin', "");
            $datos = $cn->ejec_store_procedura_sql('almacen.Bus_EntradaMat', $params);

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->idEntradaMat = $datos[0][0];
                $this->view->idProveedor = $datos[0][1];
                $this->view->nombreproveed = $datos[0][2];
                $this->view->nrofactura = $datos[0][3];
                $this->view->subtotal = $datos[0][4];
                $this->view->igv = $datos[0][5];
                $this->view->total = $datos[0][6];
                $this->view->dfecentrada = $datos[0][7];
                $this->view->ctipmon = $datos[0][9];
            } else {
                $this->view->idEntradaMat = $datos[0][0];
                $this->view->idProveedor = $datos[0][1];
                $this->view->nombreproveed = $datos[0][2];
                $this->view->nrofactura = $datos[0][3];
                $this->view->subtotal = $datos[0][4];
                $this->view->igv = $datos[0][5];
                $this->view->total = $datos[0][6];
                $this->view->dfecentrada = $datos[0][7];
                $this->view->ctipmon = $datos[0][9];
            }
        }
    }

    public function detentradaprodAction()
    {
        $this->view->tieneop = 0;
        $this->view->vMotivo = "SISTEMA CCTV HDCVI - HD";
        $this->view->vFormaPago = "Al contado";
        $this->view->dfecentrada = date('d/m/Y');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $identradaprod = $this->_request->getParam('idEntradaProd');
            $this->view->idEntradaProd = $identradaprod;
            $cn = new Model_DataAdapter();
            $params[] = array('@tBusqueda', "1");
            $params[] = array('@vDatoBus', $identradaprod);
            $params[] = array('@vFecIni', "");
            $params[] = array('@vFecFin', "");
            $datos = $cn->ejec_store_procedura_sql('almacen.Bus_EntradaProd', $params);

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->idEntradaProd = $datos[0][0];
                $this->view->idProveedor = $datos[0][1];
                $this->view->nombreproveed = $datos[0][2];
                $this->view->nrofactura = $datos[0][3];
                $this->view->subtotal = $datos[0][4];
                $this->view->igv = $datos[0][5];
                $this->view->total = $datos[0][6];
                $this->view->dfecentrada = $datos[0][7];
                $this->view->ctipmon = $datos[0][9];
            } else {
                $this->view->idEntradaProd = $datos[0][0];
                $this->view->idProveedor = $datos[0][1];
                $this->view->nombreproveed = $datos[0][2];
                $this->view->nrofactura = $datos[0][3];
                $this->view->subtotal = $datos[0][4];
                $this->view->igv = $datos[0][5];
                $this->view->total = $datos[0][6];
                $this->view->dfecentrada = $datos[0][7];
                $this->view->ctipmon = $datos[0][9];
            }
        }
    }

    public function detretornomatAction()
    {
        $this->view->tieneop = 0;
        $this->view->dFecSalida = date('d/m/Y');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsalidamat = $this->_request->getParam('idSalidaMat');
            $this->view->idsalidamat = $idsalidamat;
            $cn = new Model_DataAdapter();
            $params[] = array('@tBusqueda', "3");
            $params[] = array('@vDatoBus', $idsalidamat);
            $params[] = array('@vFecIni', "");
            $params[] = array('@vFecFin', "");
            $datos = $cn->ejec_store_procedura_sql('almacen.List_RetornoMat', $params);

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->idRetornoMat = $datos[0][0];
                $this->view->idSalidaMat = $datos[0][1];
                $this->view->dFecSalida = $datos[0][2];
                $this->view->dFecRetorno = $datos[0][3];
                $this->view->obra = $datos[0][4];
                $this->view->lugar = $datos[0][5];
                $this->view->idtecnico = $datos[0][6];
                $this->view->nomtecnico = $datos[0][7];
                $this->view->idCliente = $datos[0][8];
                $this->view->nomCliente = $datos[0][9];
                $this->view->obs = $datos[0][11];
            } else {
                $this->view->idRetornoMat = $datos[0][0];
                $this->view->idSalidaMat = $datos[0][1];
                $this->view->dFecSalida = $datos[0][2];
                $this->view->dFecRetorno = $datos[0][3];
                $this->view->obra = $datos[0][4];
                $this->view->lugar = $datos[0][5];
                $this->view->idtecnico = $datos[0][6];
                $this->view->nomtecnico = $datos[0][7];
                $this->view->idCliente = $datos[0][8];
                $this->view->nomCliente = $datos[0][9];
                $this->view->obs = $datos[0][11];
            }

            $arrDetMateriales = array();
            $params_mat[] = array('@tBusqueda', "0"); #p_idsigma
            $params_mat[] = array('@vIdSalidaMat', $idsalidamat); #p_mpapeleta
            $params_mat[] = array('@vDatoBus', ""); #p_mpapeleta
            $params_mat[] = array('@vFecIni', ""); #p_mpapeleta
            $params_mat[] = array('@vFecFin', ""); #p_mpapeleta
            $dtbdtestigo = $cn->executeAssocQuery("almacen.Bus_DetRetornoMat", $params_mat);
            if (count($dtbdtestigo) > 0) {
                $arrDetMateriales = $dtbdtestigo;
            }

            $this->view->detMateriales = $arrDetMateriales;
        }
    }
    public function detsalidamatAction()
    {
        $this->view->tieneop = 0;
        $this->view->dFecSalida = date('d/m/Y');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsalidamat = $this->_request->getParam('idSalidaMat');
            $this->view->idsalidamat = $idsalidamat;
            $cn = new Model_DataAdapter();
            $params[] = array('@tBusqueda', "2");
            $params[] = array('@vDatoBus', $idsalidamat);
            $params[] = array('@vFecIni', "");
            $params[] = array('@vFecFin', "");
            $datos = $cn->ejec_store_procedura_sql('almacen.List_SalidaMat', $params);

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->idSalidaMat = $datos[0][0];
                $this->view->dFecSalida = $datos[0][1];
                $this->view->obra = $datos[0][2];
                $this->view->lugar = $datos[0][3];
                $this->view->idtecnico = $datos[0][4];
                $this->view->nomtecnico = $datos[0][5];
                $this->view->idCliente = $datos[0][6];
                $this->view->nomCliente = $datos[0][7];
                $this->view->obs = $datos[0][9];
                $this->view->idCotiz = $datos[0][10];
                $this->view->vnroCot = $datos[0][11];
            } else {
                $this->view->idSalidaMat = $datos[0][0];
                $this->view->dFecSalida = $datos[0][1];
                $this->view->obra = $datos[0][2];
                $this->view->lugar = $datos[0][3];
                $this->view->idtecnico = $datos[0][4];
                $this->view->nomtecnico = $datos[0][5];
                $this->view->idCliente = $datos[0][6];
                $this->view->nomCliente = $datos[0][7];
                $this->view->obs = $datos[0][9];
                $this->view->idCotiz = $datos[0][10];
                $this->view->vnroCot = $datos[0][11];
            }
            $arrDetMateriales = array();
            $params_mat[] = array('@tBusqueda', "0");
            $params_mat[] = array('@vIdSalidaMat', $idsalidamat);
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


    public function addpsmAction()
    {
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

    public function addproductoAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsigma = $this->_request->getPost('idsigma');
            $iddetentrada = $this->_request->getPost('iddetentrada');
            $idProd = $this->_request->getPost('idProducto');
            $pag = $this->_request->getPost('pag');
            $this->view->identradaprod = $idsigma;
            $this->view->iddetentrada = $iddetentrada;
            $this->view->idProducto = $idProd;
            $this->view->pag = $pag;
        }
    }
    public function addseriesAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsigma = $this->_request->getPost('idsigma');
            $iddetentrada = $this->_request->getPost('iddetentrada');
            $idProd = $this->_request->getPost('idProducto');
            $pag = $this->_request->getPost('pag');
            $this->view->identradaprod = $idsigma;
            $this->view->iddetentrada = $iddetentrada;
            $this->view->idProducto = $idProd;
            $this->view->pag = $pag;
        }
    }
    public function ingresarseriesAction()
    {
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

    public function detentradaprodaddAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
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
            $params[] = array('@p_idprod', $idprod);
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
    public function detentradamataddAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idmat = $this->_request->getPost('id');
            $identradamat = $this->_request->getPost('identradamat');
            $iddetentradamat = $this->_request->getPost('iddetentradamat');
            $Cantidad = $this->_request->getPost('Cantidad');
            $PrecioUnitario = $this->_request->getPost('PrecioUnitario');
            $total = (int) $Cantidad * (float) $PrecioUnitario;
            $params = null;
            $params[] = array('@p_idmat', $idmat);
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

    public function actualizarserieAction()
    {
        //AL DAR CLICK EN AGREGAR SERIE PARA RETORNO
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idmat = $this->_request->getPost('id');
            $params = null;
            $params[] = array('@p_idprodserie', $idmat);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->executeAssocQuery('almacen.retorno_stockstadoprod', $params);
            $cperson = count($detcot);
            echo json_encode($detcot);
        }
    }
    public function actualizarseriesalidaAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idmat = $this->_request->getPost('id');
            $params = null;
            $params[] = array('@p_idprodserie', $idmat);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->executeAssocQuery('almacen.salida_stockstadoprod', $params);
            $cperson = count($detcot);
            echo json_encode($detcot);
        }
    }
    public function listarseriesAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();

            $tBusqueda = $this->_request->getPost('tBusqueda');
            $vDatoBus = $this->_request->getPost('vDatoBus');
            $vIddetEntradaProd = $this->_request->getPost('vIddetEntradaProd');
            $params = null;
            $params[] = array('@tBusqueda', $tBusqueda);
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
            $params[] = array('@p_idcliente', $jPapeleta->idcliente);
            $params[] = array('@p_idcotizacion', $jPapeleta->idcotizacion);
            $params[] = array('@p_obs', $jPapeleta->obs);
            $params[] = array('@vUsernm', $userlogin);
            $params[] = array('@vHostnm', 'local');

            $resultPapeleta = $dataSet->executeAssocQuery($_procedure, $params);



            //Se pasa a estado Desabilitado los que estan eliminado temporalmente (5= Eliminado Temporal, 4= Desabilitado)
            $_proc_okEliminado = 'almacen.salida_OKmatpasaAeliminado';
            $params1[] = array('@p_idSalidamat', $resultPapeleta[0]["idSalidaMat"]); // $jPapeleta->idSalidaMat);
            $resultEok = $dataSet->executeAssocQuery($_proc_okEliminado, $params1);


            $_proc_dtestigo = 'add_detsalidamat';

            foreach ($jPapeleta->materiales as $value) {
                $params = null;
                $params[] = array('@p_idmat', $value->idMaterial);  #p_idsigma
                $params[] = array('@p_idsalidamat', $resultPapeleta[0]["idSalidaMat"]);   #p_mpapeleta
                $params[] = array('@p_iddetsalidamat',  $value->idDetSalidaMat);  #p_mperson
                $params[] =  array('@p_cantidad',  $value->Cantidad); #cantidad
                $params[] =  array('@p_nstocksalida',  $value->stock); #cantidad
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
            $params[] = array('@p_observa', $jPapeleta->observa);
            $params[] = array('@vUsernm', $userlogin);
            $params[] = array('@vHostnm', 'local');

            $resultPapeleta = $dataSet->executeAssocQuery($_procedure, $params);

            $_proc_dtestigo = 'add_detretornomat';

            foreach ($jPapeleta->materiales as $value) {
                $params = null;
                $params[] = array('@p_idmat', $value->idMaterial);  #p_idsigma
                $params[] = array('@p_idretornomat', $resultPapeleta[0]["idRetornoMat"]);   #p_mpapeleta
                $params[] = array('@p_iddetretornomat',  $value->idDetRetornoMat);  #p_mperson
                $params[] = array('@p_iddetsalidamat',  $value->idDetSalidaMat);  #p_mperson
                $params[] =  array('@p_cantidad',  $value->cantidadRetorno); #cantidad
                $params[] =  array('@p_observ',  $value->observacion); #cantidad
                $params[] =  array('@p_stock',  $value->stock); #cantidad
                //print_r($params);
                $permiso = $dataSet->ejec_store_procedura_sql($_proc_dtestigo, $params);
            }

            print_r(json_encode($resultPapeleta[0]));
            // print_r(json_encode($resultDescta[0]["b"]));
        }
    }

    ##########detalle Salida Producto
    public function detsalidaprodAction()
    {
        $this->view->tieneop = 0;
        $this->view->dFecSalida = date('d/m/Y');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsalidaProd = $this->_request->getParam('idSalidaProd');
            $this->view->idsalidamat = $idsalidaProd;
            $cn = new Model_DataAdapter();
            $params[] = array('@tBusqueda', "2");
            $params[] = array('@vDatoBus', $idsalidaProd);
            $params[] = array('@vFecIni', "");
            $params[] = array('@vFecFin', "");
            $datos = $cn->ejec_store_procedura_sql('almacen.List_SalidaProd', $params);

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->idSalidaProd = $datos[0][0];
                $this->view->dFecSalida = $datos[0][1];
                $this->view->obra = $datos[0][2];
                $this->view->lugar = $datos[0][3];
                $this->view->idtecnico = $datos[0][4];
                $this->view->nomtecnico = $datos[0][5];
                $this->view->idCliente = $datos[0][8];
                $this->view->nomCliente = $datos[0][9];
                $this->view->obs = $datos[0][11];
                $this->view->idCotiz = $datos[0][12];
                $this->view->vnroCot = $datos[0][13];
            } else {
                $this->view->idSalidaProd = $datos[0][0];
                $this->view->dFecSalida = $datos[0][1];
                $this->view->obra = $datos[0][2];
                $this->view->lugar = $datos[0][3];
                $this->view->idtecnico = $datos[0][4];
                $this->view->nomtecnico = $datos[0][5];
                $this->view->idCliente = $datos[0][8];
                $this->view->nomCliente = $datos[0][9];
                $this->view->obs = $datos[0][11];
                $this->view->idCotiz = $datos[0][12];
                $this->view->vnroCot = $datos[0][13];
            }
            $arrDetMateriales = array();
            $params_mat[] = array('@tBusqueda', "0");
            $params_mat[] = array('@vIdSalidaProd', $idsalidaProd);
            $params_mat[] = array('@vDatoBus', "");
            $params_mat[] = array('@vFecIni', "");
            $params_mat[] = array('@vFecFin', "");
            $dtbdtestigo = $cn->executeAssocQuery("almacen.Bus_DetSalidaProd", $params_mat);
            if (count($dtbdtestigo) > 0) {
                $arrDetMateriales = $dtbdtestigo;
            }

            $this->view->detSalidaProd = $arrDetMateriales;
        }
    }


    public function detretornoprodAction()
    {
        $this->view->tieneop = 0;
        $this->view->dFecSalida = date('d/m/Y');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsalidaprod = $this->_request->getParam('idSalidaProd');
            $this->view->idsalidaprod = $idsalidaprod;
            $cn = new Model_DataAdapter();
            $params[] = array('@tBusqueda', "3");
            $params[] = array('@vDatoBus', $idsalidaprod);
            $params[] = array('@vFecIni', "");
            $params[] = array('@vFecFin', "");
            $datos = $cn->ejec_store_procedura_sql('almacen.List_RetornoProd', $params);

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->idRetornoProd = $datos[0][0];
                $this->view->idSalidaProd = $datos[0][1];
                $this->view->dFecSalida = $datos[0][2];
                $this->view->dFecRetorno = $datos[0][3];
                $this->view->obra = $datos[0][4];
                $this->view->lugar = $datos[0][5];
                $this->view->idtecnico = $datos[0][6];
                $this->view->nomtecnico = $datos[0][7];
                $this->view->idCliente = $datos[0][8];
                $this->view->nomCliente = $datos[0][9];
                $this->view->obs = $datos[0][11];
            } else {
                $this->view->idRetornoProd = $datos[0][0];
                $this->view->idSalidaProd = $datos[0][1];
                $this->view->dFecSalida = $datos[0][2];
                $this->view->dFecRetorno = $datos[0][3];
                $this->view->obra = $datos[0][4];
                $this->view->lugar = $datos[0][5];
                $this->view->idtecnico = $datos[0][6];
                $this->view->nomtecnico = $datos[0][7];
                $this->view->idCliente = $datos[0][8];
                $this->view->nomCliente = $datos[0][9];
                $this->view->obs = $datos[0][11];
            }

            $arrDetMateriales = array();
            $params_prod[] = array('@tBusqueda', "0"); #p_idsigma
            $params_prod[] = array('@vIdSalidaProd', $idsalidaprod); #
            $params_prod[] = array('@vDatoBus', ""); #
            $params_prod[] = array('@vFecIni', ""); #
            $params_prod[] = array('@vFecFin', ""); #
            $dtbdtestigo = $cn->executeAssocQuery("almacen.Bus_DetRetornoProd", $params_prod);
            if (count($dtbdtestigo) > 0) {
                $arrDetMateriales = $dtbdtestigo;
            }

            $this->view->detSeries = $arrDetMateriales;
        }
    }




    public function cancelarsalidaprodAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $userlogin = $ddatosuserlog->userlogin;

            $pidsalidaprod = $this->_request->getParam('idSalidaprod');


            $dataSet = new Model_DataAdapter();
            $_proc_dtestigo = 'almacen.salida_NOprod_regresaSE';

            $params = null;
            $params[] =  array('@p_idsalidaprod', $pidsalidaprod);
            //print_r($params);
            $permiso = $dataSet->ejec_store_procedura_sql($_proc_dtestigo, $params);

            print_r(json_encode($permiso));
            // print_r(json_encode($resultDescta[0]["b"]));
        }
    }

    public function salidaprodregresaestadostockprodseriesAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $userlogin = $ddatosuserlog->userlogin;

            $pidprodserie = $this->_request->getParam('idProdSerie');
            $piddetsalida = $this->_request->getParam('idDetsalida');
            $pidDetRetorno = $this->_request->getParam('idDetRetorno');


            $dataSet = new Model_DataAdapter();
            $_proc_dtestigo = 'almacen.salida_regresarestadostockprodserie';

            $params = null;
            $params[] = array('@p_idprodserie',  $pidprodserie);  #prodserie
            $params[] =  array('@p_idDetSalidaprod', $piddetsalida); #iddetsalidaprod
            $permiso = $dataSet->ejec_store_procedura_sql($_proc_dtestigo, $params);

            print_r(json_encode($permiso));
            // print_r(json_encode($resultDescta[0]["b"]));
        }
    }

    public function regresaestadostockprodseriesAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $userlogin = $ddatosuserlog->userlogin;

            $pidprodserie = $this->_request->getParam('idProdSerie');
            $piddetsalida = $this->_request->getParam('idDetsalida');
            $pidDetRetorno = $this->_request->getParam('idDetRetorno');


            $dataSet = new Model_DataAdapter();
            $_proc_dtestigo = 'almacen.retorno_regresarestadostockprodserie';

            $params = null;
            $params[] = array('@p_idprodserie',  $pidprodserie);  #prodserie
            $params[] =  array('@p_idDetSalidaprod', $piddetsalida); #iddetsalidaprod
            $params[] =  array('@p_idDetRetornoprod', $pidDetRetorno); #iddetsalidaprod
            $permiso = $dataSet->ejec_store_procedura_sql($_proc_dtestigo, $params);

            print_r(json_encode($permiso));
            // print_r(json_encode($resultDescta[0]["b"]));
        }
    }

    public function eliminarserieretornoprodAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $userlogin = $ddatosuserlog->userlogin;

            $pidprodserie = $this->_request->getParam('idProdSerie');
            $piddetsalida = $this->_request->getParam('idDetsalida');
            $pidDetRetorno = $this->_request->getParam('idDetRetorno');


            $dataSet = new Model_DataAdapter();
            $_proc_dtestigo = 'almacen.retorno_stockstadoprodeliminar';

            $params = null;
            $params[] = array('@p_idprodserie',  $pidprodserie);  #prodserie
            $params[] =  array('@p_idDetSalidaprod', $piddetsalida); #iddetsalidaprod
            $params[] =  array('@p_idDetRetornoprod', $pidDetRetorno); #iddetsalidaprod
            //print_r($params);
            $permiso = $dataSet->ejec_store_procedura_sql($_proc_dtestigo, $params);

            print_r(json_encode($permiso));
            // print_r(json_encode($resultDescta[0]["b"]));
        }
    }

    public function eliminarseriesalidaprodAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $userlogin = $ddatosuserlog->userlogin;

            $pidprodserie = $this->_request->getParam('id');
            $piddetsalida = $this->_request->getParam('idDetsalida');


            $dataSet = new Model_DataAdapter();
            $_proc_dtestigo = 'almacen.salida_stockstadoprodeliminar';

            $params = null;
            $params[] = array('@p_idprodserie',  $pidprodserie);  #prodserie
            $params[] =  array('@p_idDetSalidaprod', $piddetsalida); #iddetsalidaprod
            //print_r($params);
            $permiso = $dataSet->ejec_store_procedura_sql($_proc_dtestigo, $params);

            print_r(json_encode($permiso));
            // print_r(json_encode($resultDescta[0]["b"]));
        }
    }


    public function cancelareliminadosentradaprodAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $userlogin = $ddatosuserlog->userlogin;

            $pidentradaprod = $this->_request->getParam('identradaprod');


            $dataSet = new Model_DataAdapter();
            $_proc_dtestigo = 'almacen.entrada_NOprodregresaeliminado';

            $params = null;
            $params[] =  array('@p_identradaprod', $pidentradaprod);
            //print_r($params);
            $permiso = $dataSet->ejec_store_procedura_sql($_proc_dtestigo, $params);

            print_r(json_encode($permiso));
            // print_r(json_encode($resultDescta[0]["b"]));
        }
    }


    public function cancelareliminadosretornoprodAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $userlogin = $ddatosuserlog->userlogin;

            $pidretornoprod = $this->_request->getParam('idretornoprod');


            $dataSet = new Model_DataAdapter();
            $_proc_dtestigo = 'almacen.retorno_NOprodregresaeliminado';

            $params = null;
            $params[] =  array('@p_idretornoprod', $pidretornoprod);
            //print_r($params);
            $permiso = $dataSet->ejec_store_procedura_sql($_proc_dtestigo, $params);

            print_r(json_encode($permiso));
            // print_r(json_encode($resultDescta[0]["b"]));
        }
    }

    public function cancelareliminadosentradamatAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $userlogin = $ddatosuserlog->userlogin;

            $pidentradamat = $this->_request->getParam('identradamat');


            $dataSet = new Model_DataAdapter();
            $_proc_dtestigo = 'almacen.entrada_NOmatregresaeliminado';

            $params = null;
            $params[] =  array('@p_identradamat', $pidentradamat);
            //print_r($params);
            $permiso = $dataSet->ejec_store_procedura_sql($_proc_dtestigo, $params);

            print_r(json_encode($permiso));
            // print_r(json_encode($resultDescta[0]["b"]));
        }
    }

    public function cancelareliminadossalidamatAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $userlogin = $ddatosuserlog->userlogin;

            $pidsalidamat = $this->_request->getParam('idSalidamat');


            $dataSet = new Model_DataAdapter();
            $_proc_dtestigo = 'almacen.salida_NOmatregresaeliminado';

            $params = null;
            $params[] =  array('@p_idSalidamat', $pidsalidamat);
            //print_r($params);
            $permiso = $dataSet->ejec_store_procedura_sql($_proc_dtestigo, $params);

            print_r(json_encode($permiso));
            // print_r(json_encode($resultDescta[0]["b"]));
        }
    }

    public function eliminarmaterialsalidamatAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $userlogin = $ddatosuserlog->userlogin;

            $pidprodserie = $this->_request->getParam('id');
            $piddetsalida = $this->_request->getParam('idDetsalida');


            $dataSet = new Model_DataAdapter();
            $_proc_dtestigo = 'almacen.salida_stockstadomateliminar';

            $params = null;
            $params[] = array('@p_idmaterial',  $pidprodserie);  #prodserie
            $params[] =  array('@p_idDetSalidamat', $piddetsalida); #iddetsalidaprod
            //print_r($params);
            $permiso = $dataSet->ejec_store_procedura_sql($_proc_dtestigo, $params);

            print_r(json_encode($permiso));
            // print_r(json_encode($resultDescta[0]["b"]));
        }
    }
    public function buscarclienteAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsigma = $this->_request->getPost('idsigma');
            $this->view->idsigma = $idsigma;
        }
    }
    public function buscarcotizacionAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsigma = $this->_request->getPost('idsigma');
            $this->view->idsigma = $idsigma;
        }
    }
    public function guardarsalidaprodAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $userlogin = $ddatosuserlog->userlogin;

            $pSalidap = $this->_request->getParam('objSalidaProd');
            $jSalidaP = json_decode($pSalidap);

            $dataSet = new Model_DataAdapter();
            if ($jSalidaP->idsalidaprod == "") {
                $trans = "1";
            } else {
                $trans = "2";
            }
            $_procedure = 'almacen.InsUpd_salidaProd';
            $params[] = array('@ttrans', $trans);
            $params[] = array('@p_idsalidaprod', $jSalidaP->idsalidaprod);
            $params[] = array('@p_obra', $jSalidaP->obra);
            $params[] = array('@p_lugar', $jSalidaP->lugar);
            $params[] = array('@p_fecha', $jSalidaP->fecha);
            $params[] = array('@p_idtecnico', $jSalidaP->idtecnico);
            $params[] = array('@p_idcliente', $jSalidaP->idcliente);
            $params[] = array('@p_idcotizacion', $jSalidaP->idcotizacion);
            $params[] = array('@p_obs', $jSalidaP->obs);
            $params[] = array('@vUsernm', $userlogin);
            $params[] = array('@vHostnm', 'local');

            $resultPapeleta = $dataSet->executeAssocQuery($_procedure, $params);


            //Se pasa a estado Desabilitado los que estan eliminado temporalmente (5= Eliminado Temporal, 4= Desabilitado)
            $_proc_okEliminado = 'almacen.salida_OKprodpasaAeliminadoS';
            $params1[] = array('@p_idsalidaprod', $resultPapeleta[0]["idSalidaprod"]); // $jPapeleta->idSalidaMat);
            $resultEok = $dataSet->executeAssocQuery($_proc_okEliminado, $params1);




            $_proc_dtestigo = 'add_detsalidaprod';

            foreach ($jSalidaP->series as $value) {
                $params = null;
                $params[] = array('@p_idsalidaprod', $resultPapeleta[0]["idSalidaprod"]);   #salida
                $params[] = array('@p_iddetsalidaprod',  $value->idDetSalidaProd);  #detsalida
                $params[] =  array('@p_idSerie',  $value->idSerie); #idSerie
                $params[] =  array('@p_Serie',  $value->vSerie); #Serie
                $params[] =  array('@p_nstocksalida',  $value->stock); #cantidad
                //print_r($params);
                $permiso = $dataSet->ejec_store_procedura_sql($_proc_dtestigo, $params);
            }

            print_r(json_encode($resultPapeleta[0]));
            // print_r(json_encode($resultDescta[0]["b"]));
        }
    }


    public function pasaraventaAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();

        if ($this->getRequest()->isXmlHttpRequest()) {
            $idprodsoporte = $this->_request->getParam('idprodsoporte');

            $this->view->idprodsoporte = $idprodsoporte;
            $cn = new Model_DataAdapter();
            $params[] = array('@tBusqueda', "0");
            $params[] = array('@idprodsoporte', $idprodsoporte);
            //$datos = $cn->ejec_store_procedura_sql('almacen.List_RetornoProd', $params);
            $dtbdtestigo = $cn->executeAssocQuery("almacen.SoportePasaraVenta", $params);


            $this->view->detSeries = $dtbdtestigo;
        }
    }


    public function detentradamatdelAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
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

    public function detentradaproddelAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $iddentrada = $this->_request->getPost('idDetEntradaProd');

            $params = null;
            $params[] = array('@p_iddentradaprod', $iddentrada);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->ejec_store_procedura_sql('delete_dentradaprod', $params);
            echo json_encode($detcot);
        }
    }
    public function eliminarentradaprodAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $identradaprod = $this->_request->getPost('identradaProd');
            $params = null;
            $params[] = array('@p_identradaprod', $identradaprod);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $copiarcot = $cn->executeAssocQuery('eliminar_entradaprod', $params);
            echo json_encode($copiarcot);
        }
    }
    public function eliminarentradamatAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $identradamat = $this->_request->getPost('idEntradaMat');
            $params = null;
            $params[] = array('@p_identradamat', $identradamat);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $copiarcot = $cn->executeAssocQuery('eliminar_entradamat', $params);
            echo json_encode($copiarcot);
        }
    }

    public function eliminarsalidamatAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $identradamat = $this->_request->getPost('idSalidaMat');
            $params = null;
            $params[] = array('@p_idsalidamat', $identradamat);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $copiarcot = $cn->executeAssocQuery('eliminar_salidamat', $params);
            echo json_encode($copiarcot);
        }
    }

    public function eliminarsalidaprodAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $identradamat = $this->_request->getPost('idSalidaProd');
            $params = null;
            $params[] = array('@p_idsalidaprod', $identradamat);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $copiarcot = $cn->executeAssocQuery('eliminar_salidaprod', $params);
            echo json_encode($copiarcot);
        }
    }

    public function guardarretornoprodAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $userlogin = $ddatosuserlog->userlogin;

            $pPSeries = $this->_request->getParam('objSalidaProd');
            $jProSeries = json_decode($pPSeries);

            $dataSet = new Model_DataAdapter();
            if ($jProSeries->idRetornoProd == "") {
                $trans = "1";
            } else {
                $trans = "2";
            }
            $_procedure = 'almacen.InsUpd_retornoProd';
            $params[] = array('@ttrans', $trans);
            $params[] = array('@p_idretornoprod', $jProSeries->idRetornoProd);
            $params[] = array('@p_idsalidaprod', $jProSeries->idSalidaProd);
            $params[] = array('@p_obra', $jProSeries->obra);
            $params[] = array('@p_lugar', $jProSeries->lugar);
            $params[] = array('@p_fecha', $jProSeries->fecha);
            $params[] = array('@p_idtecnico', $jProSeries->idtecnico);
            $params[] = array('@p_observa', $jProSeries->observa);
            $params[] = array('@vUsernm', $userlogin);
            $params[] = array('@vHostnm', 'local');

            $resultPapeleta = $dataSet->executeAssocQuery($_procedure, $params);


            //Se pasa a estado Desabilitado los que estan eliminado temporalmente (5= Eliminado Temporal, 4= Desabilitado)
            $_proc_okEliminado = 'almacen.retorno_OKprodpasaAeliminadoS';
            $params1[] = array('@p_idretornoprod', $resultPapeleta[0]["idRetornoProd"]); // $jPapeleta->idSalidaMat);
            $resultEok = $dataSet->executeAssocQuery($_proc_okEliminado, $params1);




            $_proc_dtestigo = 'add_detretornoprod';

            foreach ($jProSeries->objSeries as $value) {
                $params = null;
                $params[] = array('@p_idprodser', $value->idProdSeries);  #p_idsigma
                $params[] = array('@p_idretornoprod', $resultPapeleta[0]["idRetornoProd"]);   #idretorno
                $params[] = array('@p_iddetretornoprod',  $value->idDetRetornoProd);  #iddetretornoprod
                $params[] =  array('@p_iddetsalidaprod',  $value->idDetSalidaProd); #iddetsalidprod
                $params[] =  array('@p_observ',  $value->observacion); #observacion
                $params[] =  array('@p_stock',  $value->stock); #stock
                //print_r($params);
                $permiso = $dataSet->ejec_store_procedura_sql($_proc_dtestigo, $params);
            }

            print_r(json_encode($resultPapeleta[0]));
            // print_r(json_encode($resultDescta[0]["b"]));
        }
    }

    public function tecnicoAction()
    {
        $func = new Libreria_Pintar();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();

            $idsigma = $this->_request->getPost('idsigma');

            $cn = new Model_DataAdapter();
            $parametros = null;
            $parametros[] = array('@tBusqueda', '1');
            $parametros[] = array('@vDatoBus', $idsigma);

            $datos = $cn->executeAssocQuery(
                'Bus_Tecnico',
                $parametros
            );

            $this->view->idsigma = $idsigma;

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->vnombre = '';
                $this->view->ctipper = '1';
                $this->view->tipdoc = 'DNI';
                $this->view->vnrodoc = '';
                $this->view->vcorreo = '';
                $this->view->personcont = "";
                $this->view->vtelfij = "";
                $this->view->vtelmov = "";
                $this->view->departamento = "Lima";
                $this->view->provincia = "Lima";
                $this->view->distrito = "1408";

                $this->view->vdirecc = '';
            } else {
                $this->view->vnombre = $datos[0]['vNombre'];
                $this->view->ctipper = $datos[0]['vTipPers'];
                $this->view->tipdoc = $datos[0]['vTipoDoc'];
                $this->view->vnrodoc = $datos[0]['vNroDoc'];
                $this->view->vcorreo = $datos[0]['vCorreoContac'];
                //$this->view->personcont =$datos[0]['vPersContac'];
                $this->view->vtelfij = $datos[0]['vTelefContac'];
                $this->view->vtelmov = $datos[0]['vCelContac'];
                $this->view->departamento = $datos[0]['vDepartamento'];
                $this->view->provincia = $datos[0]['vProvincia'];
                $this->view->distrito = $datos[0]['idUbigeo'];

                $this->view->vdirecc = $datos[0]['vDireccion'];
            }
        }

        $evt[] = array("txtvnrodoc", "keypress", "return validarnumerossinespacios(event);");
        $func->PintarEvento($evt);
    }

    public function guardartecnicoAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;


            $idsigma = $this->_request->getPost('idsigma');
            $vnombre = $this->_request->getPost('vnombre');
            $ctipper = $this->_request->getPost('ctipper');
            $vdirecc = $this->_request->getPost('vdirecc');
            $tipdoc = $this->_request->getPost('tipdoc');
            $vnrodoc = $this->_request->getPost('vnrodoc');
            $vcorreo = $this->_request->getPost('vcorreo');
            $personcont = $this->_request->getPost('personcont');
            $vtelfij = $this->_request->getPost('vtelfij');
            $vtelmov = $this->_request->getPost('vtelmov');
            $idUbigeo = $this->_request->getPost('idUbigeo');

            if ($idsigma == '0000000000') {
                $idsigma = '';
                $ttrans = '1';
            } else {
                $ttrans = '2';
            }

            echo "<pre>";
            // print_r($txtdescrip);
            $texto2 = str_replace(
                array("�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�"),
                array(
                    "&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&ntilde;",
                    "&Aacute;", "&Eacute;", "&Iacute;", "&Oacute;", "&Uacute;", "&Ntilde;"
                ),
                $vnombre
            );
            //print_r($texto2);
            echo "</pre>";


            $params = null;
            $params[] = array('@ttrans', $ttrans);
            $params[] = array('@idTecnico', $idsigma);
            // $params[] = array('@p_vnombre', strtoupper($vnombre));
            $params[] = array('@vNombre', utf8_decode(str_replace('"', '&quot;', str_replace("�", '&bull;', strtoupper($texto2)))));
            //$params[] = array('@vTipPers', $ctipper);
            $params[] = array('@vTipoDoc', $tipdoc);
            $params[] = array('@vNroDoc ', $vnrodoc);
            $params[] = array('@vDireccion', strtoupper($vdirecc));
            $params[] = array('@idUbigeo ', $idUbigeo);
            //$params[] = array('@vPersContac', $personcont);
            $params[] = array('@vTelefContac', $vtelfij);
            $params[] = array('@vCelContac', $vtelfij);
            $params[] = array('@vCorreoContac', $vcorreo);
            $params[] = array('@vEstado', '1');
            $params[] = array('@vUsernm', $usuario);
            $params[] = array('@vHostnm', $host);

            $person = $cn->ejec_store_procedura_sql('InsUpd_tecnico', $params);
            $cperson = count($person);
            echo $person[0][0];
        }
    }

    /**Activos */

    public function entradaactivosAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }

        $this->view->idcotiz = "se";

        $cn = new Model_DataAdapter();
        $params[] = array('@p_identradamat', '');
        // $copiarcot = $cn->executeAssocQuery('eliminar_entradamat', $params);
    }
    public function detentradaactivosAction()
    {
        $this->view->tieneop = 0;
        $this->view->vMotivo = "SISTEMA CCTV HDCVI - HD";
        $this->view->vFormaPago = "Al contado";
        $this->view->dfecentrada = date('d/m/Y');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idcotizacion = $this->_request->getParam('idEntradaActivos');
            $this->view->idcotizacion = $idcotizacion;
            $cn = new Model_DataAdapter();
            $params[] = array('@tBusqueda', "1");
            $params[] = array('@vDatoBus', $idcotizacion);
            $params[] = array('@vFecIni', "");
            $params[] = array('@vFecFin', "");
            $datos = $cn->ejec_store_procedura_sql('almacen.Bus_EntradaActivos', $params);

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->idEntradaMat = $datos[0][0];
                $this->view->idProveedor = $datos[0][1];
                $this->view->nombreproveed = $datos[0][2];
                $this->view->nrofactura = $datos[0][3];
                $this->view->subtotal = $datos[0][4];
                $this->view->igv = $datos[0][5];
                $this->view->total = $datos[0][6];
                $this->view->dfecentrada = $datos[0][7];
                $this->view->ctipmon = $datos[0][9];
            } else {
                $this->view->idEntradaMat = $datos[0][0];
                $this->view->idProveedor = $datos[0][1];
                $this->view->nombreproveed = $datos[0][2];
                $this->view->nrofactura = $datos[0][3];
                $this->view->subtotal = $datos[0][4];
                $this->view->igv = $datos[0][5];
                $this->view->total = $datos[0][6];
                $this->view->dfecentrada = $datos[0][7];
                $this->view->ctipmon = $datos[0][9];
            }
        }
    }


    public function entradaactivossaveAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idprov = $this->_request->getPost('idsigma');
            $identr = $this->_request->getPost('idEntrada');
            $params = null;
            $params[] = array('@ttrans', "1");
            $params[] = array('@idEntrada', $identr);
            $params[] = array('@idProveedor', $idprov);
            $params[] = array('@vHostnm', $host);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $person = $cn->executeAssocQuery('almacen.InsUpd_entradaActivos', $params);
            // $cperson = count($person);
            echo json_encode($person);
        }
    }

    public function entradaactivosupdateAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idEntActivos = $this->_request->getPost('idsigma');
            $subtot = $this->_request->getPost('subtotal');
            $igv = $this->_request->getPost('igv');
            $total = $this->_request->getPost('total');
            $fecha = $this->_request->getPost('fecha');
            $factura = $this->_request->getPost('factura');
            $tipomon = $this->_request->getPost('tipoMoneda');



            $params = null;
            $params[] = array('@ttrans', "2");
            $params[] = array('@idEntrada', $idEntActivos);
            $params[] = array('@vFacturaComp', $factura);
            $params[] = array('@p_igv', $igv);
            $params[] = array('@p_sub', $subtot);
            $params[] = array('@nPrecioTotal', $total);
            $params[] = array('@dFecIngreso', $fecha);
            $params[] = array('@vTipomon', $tipomon);
            $params[] = array('@vEstado', "1");
            $params[] = array('@vUsernm', $usuario);
            $params[] = array('@vHostnm', $host);


            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->ejec_store_procedura_sql('almacen.InsUpd_entradaActivos', $params);

            //Se pasa a estado Desabilitado los que estan eliminado temporalmente (5= Eliminado Temporal, 4= Desabilitado)
            $_proc_okEliminado = 'almacen.Entrada_OKmatpasaAeliminado';
            $params1[] = array('@p_idEntrada', $idEntActivos); // $jPapeleta->idSalidaMat);
            $resultEok = $cn->executeAssocQuery($_proc_okEliminado, $params1);


            echo json_encode($detcot);
        }
    }

    public function addactivosAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsigma = $this->_request->getPost('idsigma');
            $iddetentrada = $this->_request->getPost('iddetentrada');
            $idActivos = $this->_request->getPost('idActivos');
            $nCantidad = $this->_request->getPost('nCantidad');
            $nPrecioUnit = $this->_request->getPost('nPrecioUnit');
            $this->view->identrdamat = $idsigma;
            $this->view->iddetentrada = $iddetentrada;
            $this->view->idActivos = $idActivos;
            $this->view->cantidad = $nCantidad;
            $this->view->punitario = $nPrecioUnit;
        }
    }

    public function detentradaactivoaddAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idmat = $this->_request->getPost('id');
            $identradaActivo = $this->_request->getPost('identradaActivo');
            $iddetentradaActivo = $this->_request->getPost('iddetentradaActivo');
            $Cantidad = $this->_request->getPost('Cantidad');
            $PrecioUnitario = $this->_request->getPost('PrecioUnitario');
            $total = (int) $Cantidad * (float) $PrecioUnitario;
            $params = null;
            $params[] = array('@p_idActivo', $idmat);
            $params[] = array('@p_identradaactivo', $identradaActivo);
            $params[] = array('@p_iddetentradaactivo', $iddetentradaActivo);
            $params[] = array('@p_cantidad', $Cantidad);
            $params[] = array('@p_preciounitario', $PrecioUnitario);
            $params[] = array('@p_total', $total);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->executeAssocQuery('add_detentradaactivos', $params);
            $cperson = count($detcot);
            echo json_encode($detcot);
        }
    }
    public function cancelareliminadosentradaactivosAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $userlogin = $ddatosuserlog->userlogin;

            $pidEntradaActivos = $this->_request->getParam('idEntradaActivos');


            $dataSet = new Model_DataAdapter();
            $_proc_dtestigo = 'almacen.entrada_NOActivosRegresaeliminado';

            $params = null;
            $params[] =  array('@p_identrada', $pidEntradaActivos);
            //print_r($params);
            $permiso = $dataSet->ejec_store_procedura_sql($_proc_dtestigo, $params);

            print_r(json_encode($permiso));
            // print_r(json_encode($resultDescta[0]["b"]));
        }
    }

    public function detentradaactivosdelAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $iddentrada = $this->_request->getPost('idDetEntradaActivos');

            $params = null;
            $params[] = array('@p_iddentradaact', $iddentrada);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->ejec_store_procedura_sql('delete_dentradaactivos', $params);
            echo json_encode($detcot);
        }
    }

    public function eliminarentradaactivosAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal = $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $identradaacti = $this->_request->getPost('idEntradaActivos');
            $params = null;
            $params[] = array('@p_identradaact', $identradaacti);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $copiarcot = $cn->executeAssocQuery('eliminar_entradaactivos', $params);
            echo json_encode($copiarcot);
        }
    }


    /**
     * Salida Activos
     */
    public function salidaactivosAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
        //$this->view->fechaini=date('d/m/Y');
        //$this->view->fechafin=date('d/m/Y');
        $this->view->idcotiz = "se";
    }
    public function detsalidaactivosAction()
    {
        $this->view->tieneop = 0;
        $this->view->dFecSalida = date('d/m/Y');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsalidaactivo = $this->_request->getParam('idSalidaActivo');
            $this->view->idsalidaactivo = $idsalidaactivo;
            $cn = new Model_DataAdapter();
            $params[] = array('@tBusqueda', "2");
            $params[] = array('@vDatoBus', $idsalidaactivo);
            $params[] = array('@vFecIni', "");
            $params[] = array('@vFecFin', "");
            $datos = $cn->ejec_store_procedura_sql('almacen.List_SalidaActivos', $params);

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->idSalidaActivo = $datos[0][0];
                $this->view->dFecSalida = $datos[0][1];
                $this->view->obra = $datos[0][2];
                $this->view->lugar = $datos[0][3];
                $this->view->idtecnico = $datos[0][4];
                $this->view->nomtecnico = $datos[0][5];
                $this->view->idCliente = $datos[0][6];
                $this->view->nomCliente = $datos[0][7];
                $this->view->obs = $datos[0][9];
                $this->view->idCotiz = $datos[0][10];
                $this->view->vnroCot = $datos[0][11];
            } else {
                $this->view->idSalidaActivo = $datos[0][0];
                $this->view->dFecSalida = $datos[0][1];
                $this->view->obra = $datos[0][2];
                $this->view->lugar = $datos[0][3];
                $this->view->idtecnico = $datos[0][4];
                $this->view->nomtecnico = $datos[0][5];
                $this->view->idCliente = $datos[0][6];
                $this->view->nomCliente = $datos[0][7];
                $this->view->obs = $datos[0][9];
                $this->view->idCotiz = $datos[0][10];
                $this->view->vnroCot = $datos[0][11];
            }
            $arrDetMateriales = array();
            $params_mat[] = array('@tBusqueda', "0");
            $params_mat[] = array('@vIdSalidaActivo', $idsalidaactivo);
            $params_mat[] = array('@vDatoBus', "");
            $params_mat[] = array('@vFecIni', "");
            $params_mat[] = array('@vFecFin', "");
            $dtbdtestigo = $cn->executeAssocQuery("almacen.Bus_DetSalidaActivo", $params_mat);
            if (count($dtbdtestigo) > 0) {
                $arrDetMateriales = $dtbdtestigo;
            }

            $this->view->detSalidaMat = $arrDetMateriales;
        }
    }

    public function guardarsalidaactivosAction()
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
            $_procedure = 'almacen.InsUpd_salidaActivos';
            $params[] = array('@ttrans', $trans);
            $params[] = array('@p_idsalidaActivos', $jPapeleta->idSalidaMat);
            $params[] = array('@p_obra', $jPapeleta->obra);
            $params[] = array('@p_lugar', $jPapeleta->lugar);
            $params[] = array('@p_fecha', $jPapeleta->fecha);
            $params[] = array('@p_idtecnico', $jPapeleta->idtecnico);
            $params[] = array('@p_idcliente', $jPapeleta->idcliente);
            $params[] = array('@p_idcotizacion', $jPapeleta->idcotizacion);
            $params[] = array('@p_obs', $jPapeleta->obs);
            $params[] = array('@vUsernm', $userlogin);
            $params[] = array('@vHostnm', 'local');

            $resultPapeleta = $dataSet->executeAssocQuery($_procedure, $params);



            //Se pasa a estado Desabilitado los que estan eliminado temporalmente (5= Eliminado Temporal, 4= Desabilitado)
            $_proc_okEliminado = 'almacen.salida_OKActivopasaAeliminado';
            $params1[] = array('@p_idSalidaActivo', $resultPapeleta[0]["idSalidaActivo"]); // $jPapeleta->idSalidaMat);
            $resultEok = $dataSet->executeAssocQuery($_proc_okEliminado, $params1);


            $_proc_dtestigo = 'add_detsalidaActivos';

            foreach ($jPapeleta->materiales as $value) {
                $params = null;
                $params[] = array('@p_idmat', $value->idMaterial);  #p_idsigma
                $params[] = array('@p_idsalidamat', $resultPapeleta[0]["idSalidaMat"]);   #p_mpapeleta
                $params[] = array('@p_iddetsalidamat',  $value->idDetSalidaMat);  #p_mperson
                $params[] =  array('@p_cantidad',  $value->Cantidad); #cantidad
                $params[] =  array('@p_nstocksalida',  $value->stock); #cantidad
                //print_r($params);
                $permiso = $dataSet->ejec_store_procedura_sql($_proc_dtestigo, $params);
            }

            print_r(json_encode($resultPapeleta[0]));
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


    public function visordocsAction() {

        $img = $this->_request->getParam('img', '');
        $this->_helper->layout->disableLayout();
        $this->view->img = $img;
    }*/
}
