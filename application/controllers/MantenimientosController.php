<?php

require_once 'Zend/Controller/Action.php';

class MantenimientosController extends Zend_Controller_Action {

    public function init() {
        $this->view->util()->registerScriptJSController($this->getRequest());
        $map = new Zend_Session_Namespace("map");
        $map->data = false;
    }

    public function indexAction() {
        
    }

    public function listarusuarioAction() {
        
    }

    public function buscarclienteAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
    }

    public function buscarproveedorAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
    }

    public function buscarseriesAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
    }

    public function buscarproductoAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
    }
    public function buscarservicioAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
    }
    public function buscarmaterialAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
    }
    public function buscartasacambioAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();

        }
        $this->view->fechaini=date('d/m/Y');
        $this->view->fechafin=date('d/m/Y');
    }
    public function obtenercubigeoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->getHelper('ajaxContext')->initContext();

        $cubigeo = $this->_request->getPost('cubigeo');

        echo $this->view->util()->getComboContenedorUbigeo($cubigeo, '');
    }

    public function personaAction() {
        $func = new Libreria_Pintar();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();

            $idsigma = $this->_request->getPost('idsigma');

            $cn = new Model_DataAdapter ();
            $parametros = null;
            $parametros[] = array('@p_nvar1', $idsigma);

            $datos = $cn->executeAssocQuery(
                'buscar_cliente'
                , $parametros
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
                $this->view->tipdoc = $datos[0]['vtipdoc'];
                $this->view->vnrodoc = $datos[0]['vnrodoc'];
                $this->view->vcorreo = $datos[0]['vCorreoContac'];
                $this->view->personcont =$datos[0]['vPersContac'];
                $this->view->vtelfij = $datos[0]['vTelefContac'];
                $this->view->vtelmov = $datos[0]['vCelContac'];
                $this->view->departamento = $datos[0]['vDepartamento'];
                $this->view->provincia = $datos[0]['vProvincia'];
                $this->view->distrito = $datos[0]['idUbigeo'];

                $this->view->vdirecc = $datos[0]['direccf'];
            }
        }

        $evt[] = array("txtvnrodoc", "keypress", "return validarnumerossinespacios(event);");
        $func->PintarEvento($evt);
    }

    public function proveedorAction() {
        $func = new Libreria_Pintar();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();

            $idsigma = $this->_request->getPost('idsigma');

            $cn = new Model_DataAdapter ();
            $parametros = null;
            $parametros[] = array('@p_nvar1', $idsigma);

            $datos = $cn->executeAssocQuery(
                'buscar_proveedor'
                , $parametros
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
                $this->view->tipdoc = $datos[0]['vtipdoc'];
                $this->view->vnrodoc = $datos[0]['vnrodoc'];
                $this->view->vcorreo = $datos[0]['vCorreoContac'];
                $this->view->personcont =$datos[0]['vPersContac'];
                $this->view->vtelfij = $datos[0]['vTelefContac'];
                $this->view->vtelmov = $datos[0]['vCelContac'];
                $this->view->departamento = $datos[0]['vDepartamento'];
                $this->view->provincia = $datos[0]['vProvincia'];
                $this->view->distrito = $datos[0]['idUbigeo'];

                $this->view->vdirecc = $datos[0]['direccf'];
            }
        }

        $evt[] = array("txtvnrodoc", "keypress", "return validarnumerossinespacios(event);");
        $func->PintarEvento($evt);
    }


    public function guardarpersonaAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
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


            echo"<pre>";
            // print_r($txtdescrip);


            $texto2 = str_replace(array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ"),
                array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
                    "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), $vnombre);
            print_r($texto2);

            echo"</pre>";


            $params = null;
            $params[] = array('@p_idsigma', $idsigma);
           // $params[] = array('@p_vnombre', strtoupper($vnombre));
            $params[] = array('@p_vnombre',utf8_decode(str_replace('"','&quot;',str_replace( "•",'&bull;',strtoupper($texto2)))));

            $params[] = array('@p_ctipper', $ctipper);
            $params[] = array('@p_vdirecc', strtoupper($vdirecc));
            $params[] = array('@p_ctipdoc', $tipdoc);
            $params[] = array('@p_vnrodoc', $vnrodoc);
            $params[] = array('@p_vcorreo', $vcorreo);
            $params[] = array('@p_personcont', $personcont);
            $params[] = array('@p_ctelfij', $vtelfij);
            $params[] = array('@p_ctelmov', $vtelmov);
            $params[] = array('@p_ubigeo', $idUbigeo);
            $params[] = array('@p_usuario', $usuario);
            $params[] = array('@p_host', $host);

            $person = $cn->ejec_store_procedura_sql('guardar_cliente', $params);
            $cperson = count($person);
            echo $person[0][0];
        }
    }


    public function guardarproveedorAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
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


            echo"<pre>";
            // print_r($txtdescrip);


            $texto2 = str_replace(array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ"),
                array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
                    "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), $vnombre);
            print_r($texto2);

            echo"</pre>";


            $params = null;
            $params[] = array('@p_idsigma', $idsigma);
            // $params[] = array('@p_vnombre', strtoupper($vnombre));
            $params[] = array('@p_vnombre',utf8_decode(str_replace('"','&quot;',str_replace( "•",'&bull;',strtoupper($texto2)))));

            $params[] = array('@p_ctipper', $ctipper);
            $params[] = array('@p_vdirecc', strtoupper($vdirecc));
            $params[] = array('@p_ctipdoc', $tipdoc);
            $params[] = array('@p_vnrodoc', $vnrodoc);
            $params[] = array('@p_vcorreo', $vcorreo);
            $params[] = array('@p_personcont', $personcont);
            $params[] = array('@p_ctelfij', $vtelfij);
            $params[] = array('@p_ctelmov', $vtelmov);
            $params[] = array('@p_ubigeo', $idUbigeo);
            $params[] = array('@p_usuario', $usuario);
            $params[] = array('@p_host', $host);

            $person = $cn->ejec_store_procedura_sql('guardar_proveedor', $params);
            $cperson = count($person);
            echo $person[0][0];
        }
    }



    public function eliminarpersonaAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();

            $idsigma = $this->_request->getPost('idsigma');

            $params = null;
            $params[] = array('@p_idsigma', $idsigma);

            $person = $cn->ejec_store_procedura_sql('eliminar_cliente', $params);
            $cperson = count($person);
            echo $person[0][0];
        }
    }

    public function eliminarproductoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $cn = new Model_DataAdapter ();

            $idProducto = $this->_request->getPost('idProducto');

            $params = null;
            $params[] = array('@p_idprod', $idProducto);

            $prod = $cn->ejec_store_procedura_sql('borrar_producto', $params);
            // $cperson = count($prod);
            //echo $prod;
            echo json_encode($prod);
        }
    }

    public function usuarioAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
        }
        $func = new Libreria_Pintar();
       // $evt[] = array("txtusuario", "keypress", "return validarletrassinespacios(event);");
        //$func->PintarEvento($evt);

        $cidusuario = $this->_request->getPost('cidusuario');
        //$cidusuario = '0000000001';
        if ($cidusuario=='') {
            $cidusuario1='00000000';
        }else{
            $cidusuario1=$cidusuario;
        }
        $cn = new Model_DataAdapter();

        $params[] = array("@p_cidusuario", $cidusuario1);
        $usuario = $cn->executeAssocQuery('seguridad.listar_usuario', $params);
        $cusuario = count($usuario);

        $this->view->cidpersonal = $cidusuario;
        if ($cusuario == 0 || $cusuario > 1) {
            $this->view->vnombre = '';
            $this->view->vtipdoc = '1';
            $this->view->nrodoc = '';
            $this->view->fechanac = date('d/m/Y');
            $this->view->direcc = '';
            $this->view->vUbigeo = '1424';
            $this->view->telef = '';
            $this->view->celular = '';
            $this->view->correo = '';
            $this->view->cargo = '';
            $this->view->usuario = '';
            $this->view->pass = '';
            $this->view->estado = '1';
        } else {
            $this->view->vnombre = $usuario[0]['vNombre'];
            $this->view->vtipdoc = $usuario[0]['vTipoDoc'];
            $this->view->nrodoc = $usuario[0]['vNroDoc'];
            $this->view->fechanac = $usuario[0]['dFecNac'];
            $this->view->direcc = $usuario[0]['vDireccion'];
            $this->view->vUbigeo = $usuario[0]['idUbigeo'];
            $this->view->telef = $usuario[0]['vTelefContac'];
            $this->view->celular = $usuario[0]['vCelContac'];
            $this->view->correo = $usuario[0]['vCorreoContac'];
            $this->view->cargo = $usuario[0]['vCargo'];
            $this->view->usuario = $usuario[0]['vUsuario'];
            $this->view->pass = $usuario[0]['vPasswd'];
            $this->view->estado = $usuario[0]['vEstado'];
            $this->view->usernm = $usuario[0]['vUsernm'];
            $this->view->host = $usuario[0]['vHostnm'];
            $this->view->fecha = $usuario[0]['dFecReg'];
        }
    }
    public function productoAction() {
        $func = new Libreria_Pintar();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();

            $idsigma = $this->_request->getPost('idsigma');

            $cn = new Model_DataAdapter ();
            $parametros = null;
            $parametros[] = array('@idProd', $idsigma);

            $datos = $cn->executeAssocQuery(
                'list_Producto1'
                , $parametros
            );

            $this->view->idsigma = $idsigma;

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->idcat = '';
                $this->view->idSubCat = '';
                $this->view->vNombre = '';
                $this->view->vMarca = '';
                $this->view->vModelo = '';
                $this->view->vResolucion = "";
                $this->view->vCapacidad = "";
                $this->view->vTecnologia = "";
                $this->view->vDescrip = '';
                $this->view->ccosto = '';
                $this->view->cstock = '';
                $this->view->img = '';
                $this->view->doc = '';

            } else {
                $this->view->idcat = $datos[0]['idCat'];
                $this->view->idSubCat = $datos[0]['idSubCat'];
                $this->view->vNombre = $datos[0]['vNombre'];
                $this->view->vMarca = $datos[0]['vMarca'];
                $this->view->vModelo = $datos[0]['vModelo'];
                $this->view->vResolucion =$datos[0]['vResolucion'];
                $this->view->vCapacidad = $datos[0]['vCapacidad'];
                $this->view->vTecnologia = $datos[0]['vTecnologia'];
                $this->view->vDescrip = $datos[0]['vDescrip'];
                $this->view->ccosto = $datos[0]['nCosto'];
                $this->view->cstock = $datos[0]['nStock'];
                $this->view->img = $datos[0]['iadjunto'];
                $this->view->doc = $datos[0]['docadjunto'];
            }
        }

       // $evt[] = array("txtvnrodoc", "keypress", "return validarnumerossinespacios(event);");
       // $func->PintarEvento($evt);
    }

    public function guardarproductoAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;


            $idsigma = $this->_request->getPost('txtidsigma');
            $vnombre = $this->_request->getPost('txnombre');
            $cbocatego = $this->_request->getPost('cbocatego');
            $cbocsubcate = $this->_request->getPost('cbocsubcate');
            $marca = $this->_request->getPost('marca');
            $modelo = $this->_request->getPost('txtmodelo');
            $txtresoluc = $this->_request->getPost('cboresolu');
            $txtcapacidad = $this->_request->getPost('txtcapacidad');
            //$txttecnologia = $this->_request->getPost('cboTecno');
            $txttecnologia = $this->_request->getPost('tecnologia');
            $txtcosto = $this->_request->getPost('txtcosto');
            $txtstock = $this->_request->getPost('txtstock');
            $txtdescrip = $this->_request->getPost('txdescrip');
            $estado = $this->_request->getPost('estado');
            $adjunto = $this->_request->getPost('adjunto');

            if($idsigma=='...'){
                $idsigma='';
                $ttrans='1';
            } else{
                $ttrans='2';
            }
            if($txtcosto==''){
                $txtcosto=0;
            }
            if($txtstock==''){
                $txtstock=0;
            }

            if($cbocatego=='1'){

            }else{
                $txtresoluc='';
                $txttecnologia='';
            }

            $vnombre = str_replace('#1', '&', $vnombre);
            $txtdescrip = str_replace('#1', '&',  $txtdescrip);

            $params = null;
            $params[] = array('@ttrans', $ttrans);
            $params[] = array('@idProducto', $idsigma);
            $params[] = array('@idSubCat', $cbocsubcate);
            $params[] = array('@vNombre', $vnombre);
            $params[] = array('@vMarca', $marca);
            $params[] = array('@vModelo', $modelo);
            $params[] = array('@vResolucion', $txtresoluc);
            $params[] = array('@vCapacidad', $txtcapacidad);
            $params[] = array('@vTecnologia', $txttecnologia);
            $params[] = array('@vDescrip', $txtdescrip);
            $params[] = array('@nCosto', $txtcosto);
            $params[] = array('@nStock', $txtstock);
            //$params[] = array('@p_estado', $estado);
            $params[] = array('@vUsernm', $usuario);
            $params[] = array('@vHostnm', $host);
            $params[] = array('@iadjunto', $adjunto);

            $person = $cn->ejec_store_procedura_sql('InsUpd_Producto', $params);
            $cperson = count($person);
            $ddatosuserlogA = new Zend_Session_Namespace('datosProducto');
            $ddatosuserlogA->p_idprod =  $person[0][0];
            echo $person[0][0];

        }
    }
    public function visordocsAction() {

        $img = $this->_request->getParam('img', '');
        $this->_helper->layout->disableLayout();
        $this->view->img = $img;
    }

    public function uploadproductAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $UsuarioReg = $ddatosuserlog->cidusuario;
            $ddatosuserlogA = new Zend_Session_Namespace('datosProducto');
            $p_idsigma = $ddatosuserlogA->p_idprod;


            $name = $_FILES['qqfile']['name'];
            $size = $_FILES['qqfile']['size'];
            $ddatosuserlogA->p_file = $_FILES['qqfile']['name'];
            if ($size == 0) {
                return array('error' => 'File is empty.');
            }
            $nomadjunto = $p_idsigma . "_" . $_FILES['qqfile']['name'];
            $carpeta = "uploadDdocuments/";
            opendir($carpeta);
            $destino = $carpeta . $nomadjunto;
            copy($_FILES['qqfile']['tmp_name'], utf8_decode($destino));
            $cn = new Model_DataAdapter();
            $procedure = 'Upd_AdjProducto';
            $parameters[] = array('@idProducto', $p_idsigma);
            $parameters[] = array('@iadjunto', $nomadjunto);
            $recordsAdjunto = $cn->executeAssocQuery($procedure, $parameters);
            $ddatosuserlogA = new Zend_Session_Namespace('datosProducto');
            $p_idsigma = $ddatosuserlogA->p_idprod;
            echo $this->_helper->json(array('success' => true));
        }
    }

    public function uploaddocproductAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $UsuarioReg = $ddatosuserlog->cidusuario;
            $ddatosuserlogA = new Zend_Session_Namespace('datosProducto');
            $p_idsigma = $ddatosuserlogA->p_idprod;


            $name = $_FILES['qqfile']['name'];
            $size = $_FILES['qqfile']['size'];
            $ddatosuserlogA->p_file = $_FILES['qqfile']['name'];
            if ($size == 0) {
                return array('error' => 'File is empty.');
            }
            $nomadjunto =  $_FILES['qqfile']['name'];
            //$nomadjunto = $p_idsigma . "_" . $_FILES['qqfile']['name'];
            $carpeta = "FichaTecnica/";
            opendir($carpeta);
            $destino = $carpeta . $nomadjunto;
            copy($_FILES['qqfile']['tmp_name'], utf8_decode($destino));
            $cn = new Model_DataAdapter();
            $procedure = 'Upd_AdjdocProducto';
            $parameters[] = array('@idProducto', $p_idsigma);
            $parameters[] = array('@docadjunto', $nomadjunto);
            $recordsAdjunto = $cn->executeAssocQuery($procedure, $parameters);
            $ddatosuserlogA = new Zend_Session_Namespace('datosProducto');
            $p_idsigma = $ddatosuserlogA->p_idprod;
            echo $this->_helper->json(array('success' => true));
        }
    }
    public function iframedocumentuploadAction()
    {
        $this->_helper->layout->disableLayout();
    }


    public function servicioAction() {
        $func = new Libreria_Pintar();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();

            $idsigma = $this->_request->getParam('idsigma');
         if ($idsigma=='') {
             $idsigma1='123412353452';
         }else{
             $idsigma1=$idsigma;
         }

            $cn = new Model_DataAdapter ();
            $parametros = null;
            $parametros[] = array('@idServicio', $idsigma1);

            $datos = $cn->executeAssocQuery(
                'List_Servicio'
                , $parametros
            );

            $this->view->idsigma = $idsigma;

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->vNombre = '';
                $this->view->vDescrip = "";
                $this->view->idCategoria = "1";
                $this->view->vNomCat = "";
                $this->view->vEstado = '';

            } else {
                $this->view->vNombre = $datos[0]['vNombre'];
                $this->view->vDescrip = $datos[0]['vDescrip'];
                $this->view->idCategoria = $datos[0]['idCategoria'];
                $this->view->vNomCat = $datos[0]['vNomCat'];
                $this->view->vEstado =$datos[0]['vEstado'];
            }
        }

    }

    public function materialAction() {
        $func = new Libreria_Pintar();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();

            $idsigma = $this->_request->getPost('idsigma');
            $this->view->idsigma = $idsigma;
if ($idsigma=='...'){
    $idsigma='';}
            $cn = new Model_DataAdapter ();
            $parametros = null;
            $parametros[] = array('@tBusqueda', '1');
            $parametros[] = array('@vDatoBus', $idsigma);

            $datos = $cn->executeAssocQuery(
                'almacen.Bus_Material'
                , $parametros
            );



            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->idmate = '';
                $this->view->vNombre = '';
                $this->view->idTipoMaterial = '';
                $this->view->vMarca = '';
                $this->view->idUnidadMedida = '';
                $this->view->idCategoria = '';

            } else {
                $this->view->idmate = $datos[0]['idMaterial'];
                $this->view->vNombre = $datos[0]['vNombreMat'];
                $this->view->idTipoMaterial = $datos[0]['idTipoMaterial'];
                $this->view->vMarca = $datos[0]['vMarca'];
                $this->view->idUnidadMedida = $datos[0]['idUnidadMed'];
                $this->view->idCategoria = $datos[0]['idCategoria'];
            }
        }
    }

    public function tasacambioAction() {
        $func = new Libreria_Pintar();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();

            $idsigma = $this->_request->getPost('idsigma');

            $cn = new Model_DataAdapter ();
            $parametros = null;
            $parametros[] = array('@idTasa', $idsigma);

            $datos = $cn->executeAssocQuery(
                'Bus_TasaCambio'
                , $parametros
            );

            $this->view->idsigma = $idsigma;

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->idtasa = '';
                $this->view->ntasa = '';
                $this->view->dfecha = date('d/m/Y');

            } else {
                $this->view->idtasa = $datos[0]['idtasa'];
                $this->view->ntasa = $datos[0]['ntasa'];
                $this->view->dfecha = $datos[0]['dfecha'];
            }
        }
    }
    public function agregarmaterialAction() {
        $func = new Libreria_Pintar();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $idcoti = $this->_request->getPost('idsigma');
            $this->view->idcotizacion = $idcoti;
        }
    }
    public function agregarmaterialservAction() {
        $func = new Libreria_Pintar();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();

            $idsigma = $this->_request->getParam('idsigma');
            $idcotizacion = $this->_request->getParam('idcotizacion');
            $opcional = $this->_request->getParam('opcional');
            $descrip = $this->_request->getParam('Descripcion');
            if ($idsigma=='') {
                $idsigma1='123412353452';
            }else{
                $idsigma1=$idsigma;
            }

            $cn = new Model_DataAdapter ();
            $parametros = null;
            $parametros[] = array('@idServicio', $idsigma1);

            $datos = $cn->executeAssocQuery(
                'List_Servicio'
                , $parametros
            );

            $this->view->idsigma = $idsigma;
            $this->view->idcotizacion = $idcotizacion;

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->vNombre = '';
                $this->view->vDescrip = "";
                $this->view->idCategoria = "1";
                $this->view->vNomCat = "";
                $this->view->vEstado = '';
                $this->view->opcional = '';

            } else {
                $this->view->vNombre = $datos[0]['vNombre'];
                // $this->view->vDescrip = $datos[0]['vDescrip'];
                $this->view->vDescrip = $descrip;
                $this->view->idCategoria = $datos[0]['idCategoria'];
                $this->view->vNomCat = $datos[0]['vNomCat'];
                $this->view->vEstado =$datos[0]['vEstado'];
                $this->view->opcional =$opcional;
            }
        }
    }
    public function guardarmaterialAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;


            $idsigma = $this->_request->getPost('txtidsigma');
            $vnombre = $this->_request->getPost('txtvnombre');
            $cbotipomat = $this->_request->getPost('cbotipomat');
            $vmarca = $this->_request->getPost('txtmarca');
            $cbounidamed = $this->_request->getPost('cboUnidadMed');
            $cbocatego = $this->_request->getPost('cbocatego');
            $estado = $this->_request->getPost('estado');

            if($idsigma=='...'){
                $idsigma='';
                $ttrans='1';
            } else{
                $ttrans='2';
            }

            echo"<pre>";
            // print_r($txtdescrip);


            $texto2 = str_replace(array("á","é","í","ó","ú","ñ","�?","É","�?","Ó","Ú","Ñ"),
                array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
                    "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), $vnombre);
            print_r($texto2);

            echo"</pre>";

            $params = null;
            $params[] = array('@ttrans', $ttrans);
            $params[] = array('@idMaterial', $idsigma);
            $params[] = array('@vNombreMat',utf8_decode(str_replace('"','&quot;',str_replace( "•",'&bull;',$texto2))));
            $params[] = array('@idTipoMaterial', $cbotipomat);
            $params[] = array('@vMarca', $vmarca);
            $params[] = array('@idUnidadMed', $cbounidamed);
            $params[] = array('@vCatego', $cbocatego);
            //$params[] = array('@p_estado', $estado);
            $params[] = array('@vUsernm', $usuario);
            $params[] = array('@vHostnm', $host);

            $person = $cn->ejec_store_procedura_sql('almacen.InsUpd_material', $params);
            $cperson = count($person);
            echo $person[0][0];
        }
    }
    public function guardartasacambioAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idsigma = $this->_request->getPost('txtidsigma');
            $ntasa = $this->_request->getPost('txttasa');
            $fecha = $this->_request->getPost('fecha');
            $estado = $this->_request->getPost('estado');

            if($idsigma==''){
                $idsigma='';
                $ttrans='1';
            } else{
                $ttrans='2';
            }

            $params = null;
            $params[] = array('@ttrans', $ttrans);
            $params[] = array('@idtasa', $idsigma);
            $params[] = array('@ntasa', $ntasa);
            $params[] = array('@fecha', $fecha);
            //$params[] = array('@nestado', $estado);

            $person = $cn->ejec_store_procedura_sql('InsUpd_tasacambio', $params);
            $cperson = count($person);
            echo $person[0][0];
        }
    }
    public function guardarservicioAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;


            $idsigma = $this->_request->getPost('txtidsigma');
            $vnombre = $this->_request->getPost('txtvnombre');
            $vcate = $this->_request->getPost('cbocategoser');
            //$txtdescrip = $this->_request->getPost('txtdescrip1');
            $txtdescrip = $this->_request->getPost('txtdescrip');
            $estado = $this->_request->getPost('estado');
            $seleccion= $this->_request->getPost('seleccion');
            $txtdescrip = str_replace('#1', '&',  $txtdescrip);

            $params = null;
            $params[] = array('@idServicio',$idsigma );
            $detcot = $cn->executeAssocQuery('Limpiar_ServMaterial', $params);


            if($idsigma==''){
                $idsigma='';
                $ttrans='1';
            } else{
                $ttrans='2';
            }

            //$texto = htmlentities(utf8_decode($txtdescrip));

            echo"<pre>";
           // print_r($txtdescrip);
            $texto = str_replace(array("á","é","í","ó","ú","ñ","�?","É","�?","Ó","Ú","Ñ"),
                array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
                    "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), $txtdescrip);
            print_r($texto);

            $texto1 = str_replace(array("á","é","í","ó","ú","ñ","�?","É","�?","Ó","Ú","Ñ"),
                array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
                    "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), $vnombre);
            print_r($texto1);

            echo"</pre>";
            $params = null;
            $params[] = array('@ttrans', $ttrans);
            $params[] = array('@idServicio', $idsigma);
            $params[] = array('@vNombre',utf8_decode(str_replace('"','&quot;',str_replace( "•",'&bull;',$texto1))));
            $params[] = array('@vDescrip', utf8_decode(str_replace('"','&quot;',str_replace( "•",'&bull;',$texto))));
            $params[] = array('@idCategoria', $vcate);
            //$params[] = array('@p_estado', $estado);
            $params[] = array('@vUsernm', $usuario);
            $params[] = array('@vHostnm', $host);

            $person = $cn->ejec_store_procedura_sql('InsUpd_Servicio', $params);
            $cperson = count($person);
            if($idsigma=='') {
                $idsigma = $person[0][0];
            }

            if(is_array($seleccion))
            {
            while(list($key,$value) = each($seleccion)) {
              // echo $key .'->'.$value;
                $params = null;
                $params[] = array('@idServicio',$idsigma );
                $params[] = array('@idMaterial',$value);
                $params[] = array('@vUsernm', $usuario);
                $params[] = array('@vHostnm', $host);
                $detcot = $cn->executeAssocQuery('Ins_ServMaterial', $params);
            }
            }

            echo $person[0][0];
        }
    }



    public function agregarprodservAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;


            $idsigma = $this->_request->getPost('txtidsigma');
            $vnombre = $this->_request->getPost('txtvnombre');
            $vcate = $this->_request->getPost('cbocatego');
            $txtdescrip = $this->_request->getPost('txtdescrip');
            $estado = $this->_request->getPost('estado');
            $seleccion= $this->_request->getPost('seleccion');
            $idcotiz= $this->_request->getPost('txtidcotizacion');
            $idserv= $this->_request->getPost('txtidservi');
            $txtdescrip = str_replace('#1', '&',  $txtdescrip);

            $texto = str_replace(array("á","é","í","ó","ú","ñ","�?","É","�?","Ó","Ú","Ñ"),
                array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
                    "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), $txtdescrip);

            $texto1 = str_replace(array("á","é","í","ó","ú","ñ","�?","É","�?","Ó","Ú","Ñ"),
                array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
                    "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), $vnombre);

            //Limpiando La tabla Servmaterial
            /*$params = null;
            $params[] = array('@idServicio',$idsigma );
            $detcot = $cn->executeAssocQuery('Limpiar_ServMaterial', $params);*/


            //Limpiando los materiales de la tabla DetCotizacion
            $params = null;
            $params[] = array('@idServicio',$idsigma );
            $params[] = array('@idCotiz',$idcotiz );
            $params[] = array('@opcional','0' );
            $detcot = $cn->executeAssocQuery('Desab_ServMaterialDetCotiz', $params);

            if(is_array($seleccion))
            {
                while(list($key,$value) = each($seleccion)) {
                    // echo $key .'->'.$value;
                    //Insertar los materiales en la tabla sevmaterial
                    /*$params1 = null;
                    $params1[] = array('@idServicio',$idsigma );
                    $params1[] = array('@idMaterial',$value);
                    $params1[] = array('@vUsernm', $usuario);
                    $params1[] = array('@vHostnm', $host);
                    $detcot = $cn->executeAssocQuery('Ins_ServMaterial', $params1);*/

                    //Insertar los materiales en la tabla DetCotizacion
                    $params = null;
                    $params[] = array('@idcotiz',$idcotiz );
                    $params[] = array('@idServicio',$idsigma );
                    $params[] = array('@idMaterial',$value);
                    $params[] = array('@vUsernm', $usuario);
                    $params[] = array('@vHostnm', $host);
                    $params[] = array('@vDescrip', $texto);
                    $detcot = $cn->executeAssocQuery('Ins_ServMaterialDetCot', $params);


                }
            }

            //Limpiando los materiales de la tabla DetCotizacion
            $params = null;
            $params[] = array('@idServicio',$idsigma );
            $params[] = array('@idCotiz',$idcotiz );
            $params[] = array('@opcional','0' );
            $detcot = $cn->executeAssocQuery('Limpiar_ServMaterialDetCotiz', $params);

            //echo $detcot[0][0];
        }
    }
    public function agregarprodservopAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;


            $idsigma = $this->_request->getPost('txtidsigma');
            $vnombre = $this->_request->getPost('txtvnombre');
            $vcate = $this->_request->getPost('cbocatego');
            $txtdescrip = $this->_request->getPost('txtdescrip');
            $estado = $this->_request->getPost('estado');
            $seleccion= $this->_request->getPost('seleccion');
            $idcotiz= $this->_request->getPost('txtidcotizacion');
            $idserv= $this->_request->getPost('txtidservi');
            $txtdescrip = str_replace('#1', '&',  $txtdescrip);

            $texto = str_replace(array("á","é","í","ó","ú","ñ","�?","É","�?","Ó","Ú","Ñ"),
                array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
                    "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), $txtdescrip);

            $texto1 = str_replace(array("á","é","í","ó","ú","ñ","�?","É","�?","Ó","Ú","Ñ"),
                array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
                    "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), $vnombre);

            //Limpiando La tabla Servmaterial
            /*$params = null;
            $params[] = array('@idServicio',$idsigma );
            $detcot = $cn->executeAssocQuery('Limpiar_ServMaterial', $params);*/


            //Limpiando los materiales de la tabla DetCotizacion
            $params = null;
            $params[] = array('@idServicio',$idsigma );
            $params[] = array('@idCotiz',$idcotiz );
            $params[] = array('@opcional','1' );
            $detcot = $cn->executeAssocQuery('Desab_ServMaterialDetCotiz', $params);



            if(is_array($seleccion))
            {
                while(list($key,$value) = each($seleccion)) {
                    // echo $key .'->'.$value;
                    //Insertar los materiales en la tabla sevmaterial
                   /* $params1 = null;
                    $params1[] = array('@idServicio',$idsigma );
                    $params1[] = array('@idMaterial',$value);
                    $params1[] = array('@vUsernm', $usuario);
                    $params1[] = array('@vHostnm', $host);
                    $detcot = $cn->executeAssocQuery('Ins_ServMaterial', $params1);*/

                    //Insertar los materiales en la tabla DetCotizacion
                    $params = null;
                    $params[] = array('@idcotiz',$idcotiz );
                    $params[] = array('@idServicio',$idsigma );
                    $params[] = array('@idMaterial',$value);
                    $params[] = array('@vUsernm', $usuario);
                    $params[] = array('@vHostnm', $host);
                    $params[] = array('@vDescrip', $texto);
                    $detcot = $cn->executeAssocQuery('Ins_ServMaterialDetCotOp', $params);
                }
            }
            //Limpiando los materiales de la tabla DetCotizacion
            $params = null;
            $params[] = array('@idServicio',$idsigma );
            $params[] = array('@idCotiz',$idcotiz );
            $params[] = array('@opcional','1' );
            $detcot = $cn->executeAssocQuery('Limpiar_ServMaterialDetCotiz', $params);

            //echo $detcot[0][0];
        }
    }
    public function addmaterialAction() {
        $func = new Libreria_Pintar();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $idsigma = $this->_request->getPost('idsigma');
            $this->view->idsigma = $idsigma;

        }
    }
    public function listmaterialAction() {
        $func = new Libreria_Pintar();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $idsigma = $this->_request->getPost('idsigma');
            $servicio = $this->_request->getPost('servicio');
            $this->view->idsigma = $idsigma;
            $this->view->servicio = $servicio;

        }
    }
    public function materialaddAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $id = $this->_request->getPost('id');
            $serv = $this->_request->getPost('servicio');

            $params = null;
            $params[] = array('@idServicio',$serv );
            $params[] = array('@idMaterial',$id);
            $params[] = array('@vUsernm', $usuario);
            $params[] = array('@vHostnm', $host);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->executeAssocQuery('Ins_ServMaterial', $params);
            //$cperson = count($detcot);
            //echo json_encode($detcot);
        }
    }

    public function obtenersubcateAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();

        $cidespe = $this->_request->getPost('select');
        $subcat = $this->_request->getPost('subcat');

        echo $this->view->util()->getComboContenedorOtro($cidespe,$subcat,'Cmb_SubCategoria','@idCat');
    }

    public function obtenersubcate1Action() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();

        $cidespe = $this->_request->getPost('select');
        $subcat = $this->_request->getPost('subcat');

        echo $this->view->util()->getComboContenedorOtro1($cidespe,$subcat,'Cmb_SubCategoria','@idCat');
    }

    public function obtenerprovinciaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();

        $cidespe = $this->_request->getPost('select');
        $provincia = $this->_request->getPost('provincias');

        echo $this->view->util()->getComboContenedorOtro1($cidespe,$provincia,'Cmb_provincia','@idDep');
    }

    public function obtenerdistritoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();

        $cidespe = $this->_request->getPost('select');
        $distrito = $this->_request->getPost('distritos');

        echo $this->view->util()->getComboContenedorOtro1($cidespe,$distrito,'Cmb_distrito','@idprov');
    }


    public function obtenermarcaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();

        $cidespe = $this->_request->getPost('select');
        $subcat = $this->_request->getPost('subcat');

        //echo $this->view->util()->getComboContenedorOtro($cidespe,$subcat,'Cmb_Marca','@idCat');
        echo $this->view->util()->getComboContenedorxDescrip($cidespe,$subcat,'Cmb_Marca','@idCat');
    }


    public function arreglocheckAction(){
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $categ = $this->_request->getPost('catego');
            $serv = $this->_request->getPost('serv');

            $seleccion= $this->_request->getParam('selecionados');
            $decodeSeleccion = json_decode($seleccion, true);
            $cseleccion = count($decodeSeleccion);

            $params = null;
            $params[] = array('@idCatego', $categ);
            $params[] = array('@idServicio', $serv);

            $detcot = $cn->ejec_store_procedura_sql('list_materiales', $params);
            //$detcot = $cn->executeAssocQuery('Ins_ServMaterial', $params);
            $contenhijos='';
            $mitad=1;
            if(count($detcot)>1) {
                $mitad=round(count($detcot)/2);
            }

            $contenhijos .="<table border=\"0\"><tr><td>";

            if($cseleccion>0)
            {
                for ($i = 0; $i < count($detcot); $i++) {
                    $cod = $detcot[$i][0];
                    $nombre = $detcot[$i][1];
                    $marcado = $detcot[$i][2];
                    if($mitad==$i){
                        $contenhijos .="</td><td width=\"10\">&nbsp;&nbsp;&nbsp;</td><td>";
                    }
                    $marcado=0;
                    for ($j = 0; $j < $cseleccion; $j++) {
                        if($decodeSeleccion[$j]==$cod){
                            $marcado=1;
                        }
                    }
                    if($marcado==1){
                        $contenhijos .= "<input type=\"checkbox\" name=\"seleccion[]\"  checked id=\"seleccion\" value=\"".$cod."\">".$nombre."<br>";
                    }else{
                        $contenhijos .= "<input type=\"checkbox\" name=\"seleccion[]\"  id=\"seleccion\" value=\"".$cod."\">".$nombre."<br>";
                    }
                }

            }else {

                for ($i = 0; $i < count($detcot); $i++) {
                    $cod = $detcot[$i][0];
                    $nombre = $detcot[$i][1];
                    $marcado = $detcot[$i][2];
                    if($mitad==$i){
                        $contenhijos .="</td><td width=\"10\">&nbsp;&nbsp;&nbsp;</td><td>";
                    }
                    if($marcado>'0'){
                        $contenhijos .= "<input type=\"checkbox\" name=\"seleccion[]\"  checked id=\"seleccion\" value=\"".$cod."\">".$nombre."<br>";
                    }else{
                        $contenhijos .= "<input type=\"checkbox\" name=\"seleccion[]\"  id=\"seleccion\" value=\"".$cod."\">".$nombre."<br>";
                    }
                }

            }


            $contenhijos .="</td><tr></table>";
          echo $contenhijos;
        }

    }

    public function forzardescargaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $carpeta = "FichaTecnica/";
        $file = utf8_decode($carpeta . $_GET['file']);
        header("Content-disposition: attachment; filename=$file");
        header("Content-type: application/octet-stream");
        readfile($file);
    }

    public function guardarusuarioAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $cn = new Model_DataAdapter();

            $cidusuario = $this->_request->getParam('cidusuario');
            $nombre = $this->_request->getParam('nombre');
            $tipodoc = $this->_request->getParam('tipodoc');
            $nrodoc = $this->_request->getParam('nrodoc');
            $fechanac = $this->_request->getParam('fechanac');
            $direcc = $this->_request->getParam('direc');
            $ubigeo= $this->_request->getParam('ubigeo');
            $telefono = $this->_request->getParam('telefono');
            $celular = $this->_request->getParam('celular');
            $correo = $this->_request->getParam('correo');
            $cargo = $this->_request->getParam('cargo');
            $usuario = $this->_request->getParam('usuario');
            $pass = $this->_request->getParam('pass');
            $estado = $this->_request->getParam('estado');

            $permisos = $this->_request->getParam('permisos');
            $decodePermisos = json_decode($permisos, true);
            $cpermisos = count($decodePermisos);

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usernm = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $params = null;
            $params[] = array('@p_cidusuario', $cidusuario);
            $params[] = array('@p_vnombre', $nombre);
            $params[] = array('@p_tipodoc', $tipodoc);
            $params[] = array('@p_nrodoc', $nrodoc);
            $params[] = array('@p_fechanac', $fechanac);
            $params[] = array('@p_direccion', $direcc);
            $params[] = array('@p_idubigeo', $ubigeo);
            $params[] = array('@p_telefono', $telefono);
            $params[] = array('@p_celular', $celular);
            $params[] = array('@p_correo', $correo);
            $params[] = array('@p_cargo', $cargo);
            $params[] = array('@p_usuario', strtoupper($usuario));
            $params[] = array('@p_pass', $pass);
            $params[] = array('@p_estado', $estado);
            $params[] = array('@p_vusernm', $usernm);
            $params[] = array('@p_vhostnm', $host);
            $usuario = $cn->ejec_store_procedura_sql('seguridad.guardar_usuario', $params);

            // Permisos
            for ($i = 0; $i < $cpermisos; $i++) {
                if ($decodePermisos[$i]['estado_f'] !== $decodePermisos[$i]['estado_i']) {
                    $params = null;
                    $params[] = array('@p_cidusuario', $cidusuario);
                    $params[] = array('@p_cidobjeto', $decodePermisos[$i]['idObjeto']);
                    $params[] = array('@p_estado', $decodePermisos[$i]['estado_f']);

                    $params[] = array('@p_vhostnm', $host);
                    $params[] = array('@p_vusernm', $usernm);

                    $permiso = $cn->ejec_store_procedura_sql('seguridad.guardar_permiso', $params);
                    //}
                }
            }

            //echo $usuario[0][0];
            echo json_decode($permisos);
        }
    }














    public function buscarhijosmconten($padre, $depth, $arraydatos) {

        $url = $this->view->util()->getPath();

        $depth++;

        for ($i = 0; $i < count($arraydatos); $i++) {
            $idsigma = $arraydatos[$i][0];
            $vdescri = $arraydatos[$i][1];
            $cidtabl = $arraydatos[$i][2];
            $hijos = $arraydatos[$i][3];
            $ctipdat = $arraydatos[$i][4];
            $vobser = $arraydatos[$i][5];
            $nlongit = $arraydatos[$i][6];
            $ndecima = $arraydatos[$i][7];
            $ndefault = $arraydatos[$i][8];
            $nestado = $arraydatos[$i][9];

            if ($idsigma != $cidtabl && $cidtabl == $padre) {
                if ($hijos == 0) {
                    $array[] = array('text' => $vdescri, 'id' => $idsigma, 'depth' => $depth, 'leaf' => true, 'checked' => false, 'children' => '', 'enlace' => $idsigma, 'canthijos' => $hijos, 'icon' => (($nestado == 1) ? '' : $url . 'css/images/newdropx.png'));
                } else {
                    $arrayhijos = $this->buscarhijosmconten($idsigma, $depth, $arraydatos);
                    $array[] = array('text' => $vdescri, 'id' => $idsigma, 'depth' => $depth, 'leaf' => false, 'checked' => false, 'children' => $arrayhijos, 'enlace' => $idsigma, 'canthijos' => $hijos, 'icon' => (($nestado == 1) ? '' : $url . 'css/images/newdropx.png'));
                }
            }
        }

        return $array;
    }

    public function pintararbolconten() {
        $url = $this->view->util()->getPath();

        $mconten = new Zend_Session_Namespace('mcontendata');
        //echo $mconten->schemaid;
        //$nombrestore = '"public".obt_mconten'; -- POSTGRES
        $nombrestore = $mconten->schemaid . 'obt_mconten';
        $parametros[0] = array('@p_idsigma', '');
        $parametros[1] = array('@p_cidtabl', '');
        $cn = new Model_DataAdapter ();
        $datos = $cn->ejec_store_procedura_sql($nombrestore, $parametros);

        $depth = 1;

        for ($i = 0; $i < count($datos); $i++) {

            $idsigma = $datos[$i][0];
            $vdescri = $datos[$i][1];
            $cidtabl = $datos[$i][2];
            $hijos = $datos[$i][3];
            $ctipdat = $datos[$i][4];
            $vobser = $datos[$i][5];
            $nlongit = $datos[$i][6];
            $ndecima = $datos[$i][7];
            $ndefault = $datos[$i][8];
            $nestado = $datos[$i][9];

            if ($idsigma == $cidtabl && $hijos > 0) {
                $arrayhijos = $this->buscarhijosmconten($idsigma, $depth, $datos);
                $arrayprinc[] = array('text' => $vdescri, 'id' => $idsigma, 'depth' => $depth, 'leaf' => false, 'checked' => false, 'children' => $arrayhijos, 'enlace' => $idsigma, 'canthijos' => $hijos, 'icon' => (($nestado == 1) ? '' : $url . 'css/images/newdropx.png'));
            }if ($idsigma == $cidtabl && $hijos == 0) {
                $arrayprinc[] = array('text' => $vdescri, 'id' => $idsigma, 'depth' => $depth, 'leaf' => true, 'checked' => false, 'children' => '', 'enlace' => $idsigma, 'canthijos' => $hijos, 'icon' => (($nestado == 1) ? '' : $url . 'css/images/newdropx.png')); //drop-no.gif
            }
        }
        $arrayroot[0] = array('text' => 'TABLAS GENERALES', 'id' => '0000000000', 'depth' => '0', 'leaf' => false, 'checked' => false, 'children' => $arrayprinc);

        $cont = '
            <script type="text/javascript">
                Ext.BLANK_IMAGE_URL = "' . $url . 'css/images/s.gif";
                Ext.EventManager.onDocumentReady(function() {
                    tree = new Ext.tree.TreePanel(\'tree-mconten\',{
                    animate:true,
                    //loader: new Ext.tree.CustomUITreeLoader({baseAttr:{uiProvider: Ext.tree.CheckboxNodeUI}}),
                    loader: new Ext.tree.TreeLoader({}),
                    enableDD:false,
                    collapsible : true,
                    animCollapse: false,
                    containerScroll: true,
                    //rootUIProvider: Ext.tree.CheckboxNodeUI,
                    //selModel:new Ext.tree.CheckNodeMultiSelectionModel(),
                    rootVisible:false
                });

                tree.on(\'check\', function() {
                //aki va el ajax para llenar los registros!!
                var registros = this.getChecked().join(\'^\');
                }, tree);

                tree.on(\'click\', function(node, event){
                detallenodomconten(node.attributes.id,\'\');
                });
		
                // set the root node
                root = new Ext.tree.AsyncTreeNode({
                text: \'root\',
                draggable:false,
                id:\'source\',
                //uiProvider: Ext.tree.CheckboxNodeUI,
                children: ' . json_encode($arrayroot) . '
                });

                tree.setRootNode(root);
		
                // render the tree
                tree.render();
                root.expand(false, false, function() {
                root.firstChild.expand(false);
                });

            });
            </script>
        ';
        echo $cont;
    }

    public function mcontenAction() {
        /* $this->pintararbolconten();
          $func = new Libreria_Pintar();
          $evt[] = array('btnnuevonodo', 'click', 'detallenodomconten(\'\',\'\')');
          echo "<script>pathReport='" . $this->view->util()->getPathReport() . "'</script>";
          $func->PintarEvento($evt); */
        $this->pintararbolconten();
        $func = new Libreria_Pintar();
        $evt[] = array('btnnuevonodo', 'click', 'detallenodomconten(\'\',\'\')');
        $evt[] = array('btncambiaresquema', 'click', 'selectEsquemaConten()');

        echo "<script>pathReport='" . $this->view->util()->getPathReport() . "'</script>";
        $func->PintarEvento($evt);

        $mconten = new Zend_Session_Namespace('mcontendata');
        //echo $mconten->schemaid;
        $this->view->schema = $mconten->schemaid;
    }

    public function mcontenesquemaAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();

            $schema = $this->_request->getPost('schemaid');
            $mconten = new Zend_Session_Namespace('mcontendata');
            $mconten->schemaid = $schema;

            echo 'OK';
        }
    }

    public function mcontennodoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->getHelper('ajaxContext')->initContext();

        if ($this->getRequest()->isXmlHttpRequest()) {

            $idnodo = $this->_request->getPost('idnodo');
            $idpadre = $this->_request->getPost('idpadre');

            $func = new Libreria_Pintar();
            $cn = new Model_DataAdapter ();

            //$nombrestore = '"public".obt_mconten';
            $mconten = new Zend_Session_Namespace('mcontendata');
            $nombrestore = $mconten->schemaid . 'obt_mconten';

            $arrayestado = array(array('1', 'HABILITADO'), array('0', 'DESHABILITADO'));

            if ($idnodo == '' || $idnodo == null) {
                $parametros[0] = array('@p_idsigma', '');
                $parametros[1] = array('@p_cidtabl', '');
                $datosmconten = $cn->ejec_store_procedura_sql($nombrestore, $parametros);
                $val[] = array('cb_padre', $func->ContenidoCombo($datosmconten, ($idpadre == '') ? '' : $idpadre), 'html');
                $val[] = array('cb_estado', $func->ContenidoCombo($arrayestado, '1'), 'html');
            } else {
                $parametros[0] = array('@p_idsigma', $idnodo);
                $parametros[1] = array('@p_cidtabl', '');
                $datosnodo = $cn->ejec_store_procedura_sql($nombrestore, $parametros);

                if (count($datosnodo) == 0) {
                    return;
                }

                $idsigma = $datosnodo[0][0];
                $vdescri = $datosnodo[0][1];
                $cidtabl = $datosnodo[0][2];
                $hijos = $datosnodo[0][3];
                $ctipdat = $datosnodo[0][4];
                $vobser = $datosnodo[0][5];
                $nlongit = $datosnodo[0][6];
                $ndecima = $datosnodo[0][7];
                $ndefault = $datosnodo[0][8];
                $nestado = $datosnodo[0][9];

                $val[] = array('c_codigo', $idsigma, 'html');
                $val[] = array('txt_descripcion', $vdescri, 'val');

                $parametros[0] = array('@p_idsigma', '');
                $parametros[1] = array('@p_cidtabl', '');
                $datosmconten = $cn->ejec_store_procedura_sql($nombrestore, $parametros);
                $val[] = array('cb_padre', $func->ContenidoCombo($datosmconten, $cidtabl), 'html');
                $val[] = array('txa_observ', $vobser, 'val');
                $val[] = array('txt_long', $nlongit, 'val');
                $val[] = array('txt_decimal', $ndecima, 'val');
                $val[] = array('txt_defecto', $ndefault, 'val');
                $val[] = array('cb_estado', $func->ContenidoCombo($arrayestado, $nestado), 'html');

                $contenhijos = '';
                $tienehijos = 0;

                for ($i = 0; $i < count($datosmconten); $i++) {
                    $didsigma = $datosmconten[$i][0];
                    $dvdescri = str_replace(array("'", "/"), array("", ""), $datosmconten[$i][1]);
                    $dcidtabl = $datosmconten[$i][2];
                    $dhijos = $datosmconten[$i][3];
                    $dctipdat = $datosmconten[$i][4];
                    $dvobser = $datosmconten[$i][5];
                    $dnlongit = $datosmconten[$i][6];
                    $dndecima = $datosmconten[$i][7];
                    $dndefault = $datosmconten[$i][8];
                    $dnestado = $datosmconten[$i][9];

                    if ($dcidtabl == $idsigma && $didsigma != $idsigma) {
                        $tienehijos = 1;
                        $contenhijos .= '<tr><td style="width: 90px;">' . $didsigma
                                . '</td><td style="width: 246px">' . $dvdescri
                                . '</td><td style="width: 42px" align="center"><button onclick="detallenodomconten(\'' . $didsigma . '\',\'\');" >Buscar</button></td></tr>';
                    }
                }
                if ($tienehijos == 0) {
                    $contenhijos .= '<tr><td colspan="3">No tiene nodo hijos registrados</td></tr>';
                }

                $val[] = array('c_nodohijos', '<table id="tblDetalle" style="width: 372px; padding-left: 2px;" border="0" cellspacing="0" cellpadding="0"><tbody class="ui-table-body">' . $contenhijos . '</tbody></table>', 'html');
                $evt[] = array('btnaniadirnodo', 'click', 'detallenodomconten(\'\',\'' . $idsigma . '\');');
            }
            //$evt[] = array('btnguardarmcontennodo', 'click', 'guardarmcontennodo();');
            $evt[] = array('txa_observ', 'keypress', 'if(event.keyCode == 13){return false;}');
            $evt[] = array("txt_long", "keypress", "return validarnumeros(event);");
            $evt[] = array("txt_decimal", "keypress", "return validarnumeros(event);");

            $val[] = array('btnimprimir', $idnodo, 'val');

            //$fn[] = array("$('#bntguardarmcontennodo').unbind('click');");
            //$fn[] = array("$('#btnguardarmcontennodo').bind('click', guardarmcontennodo);");
            $fn[] = array("$('#tblDetalle button').button({icons: {primary: 'ui-icon-search'}, text: false});");
            $fn[] = array("mouseHover('tblDetalle');");

            $func->IniciaScript();
            $func->PintarValor($val);
            $func->PintarEvento($evt);
            $func->EjecutarFuncion($fn, "function");
            $func->FinScript();
        }
    }

    public function guardarmcontennodoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->getHelper('ajaxContext')->initContext();

        if ($this->getRequest()->isXmlHttpRequest()) {

            $codigo = $this->_request->getPost('codigo');
            $descripcion = $this->_request->getPost('descripcion');
            $padre = $this->_request->getPost('padre');
            $observ = $this->_request->getPost('observ');
            $long = $this->_request->getPost('long');
            $decimal = $this->_request->getPost('decimal');
            $defecto = $this->_request->getPost('defecto');
            $estado = $this->_request->getPost('estado');

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $cidpers = $ddatosuserlog->cidpers;

            $cn = new Model_DataAdapter ();

            /* @p_idsigma varchar(10)
              , @p_descripcion varchar(250)
              , @p_padre varchar(10)
              , @p_observ varchar(250)
              , @p_long int
              , @p_decimal int
              , @p_defecto varchar(1)
              , @p_estado int
              , @p_host varchar(25)
              , @p_user varchar(60) */
            $mconten = new Zend_Session_Namespace('mcontendata');
            $nombrestore = $mconten->schemaid . 'guardarmcontennodo';
            $parametros [0] = array('@p_idsigma', $codigo);
            $parametros [1] = array('@p_descripcion', $descripcion);
            $parametros [2] = array('@p_padre', $padre);
            $parametros [3] = array('@p_observ', $observ);
            $parametros [4] = array('@p_long', $long);
            $parametros [5] = array('@p_decimal', $decimal);
            $parametros [6] = array('@p_defecto', $defecto);
            $parametros [7] = array('@p_estado', $estado);
            $parametros [8] = array('@p_host', '');
            $parametros [9] = array('@p_user', $cidpers);

            $datos = $cn->ejec_store_procedura_sql($nombrestore, $parametros);

            if ($datos[0][0] == '1') {
                echo '<script language=\"JavaScript\">window.open(\'' . $this->view->util()->getLink('mantenimientos/mconten') . '\', \'_self\')</script>';
            } else {
                echo 'Error en el guardado...';
            }
        }
    }



    public function personavalidardocumentoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $tipodoc = $this->_request->getParam('');
            $nrodocu = $this->_request->getParam('');
        }
    }





    public function configdocAction() {

        $func = new Libreria_Pintar();
        $val[] = array('cboestruc', $this->view->util()->getComboContenedorTramite('0000000005', '9999999999'), 'html');
        $func->PintarValor($val);
    }

    public function configdocsaveAction() {

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $type = $this->_request->getParam('type');
            $configdoc = $this->_request->getParam('configdoc');
            $ctipdocu = $this->_request->getParam('ctipdocu');
            $ctipestrdocu = $this->_request->getParam('ctipestrdocu');
            $norden = $this->_request->getParam('norden');

            $cn = new Model_DataAdapter();
            $procedure = 'tramite.mconfigdoc_insupd';
            $parameters[] = array("@ptype", $type);
            $parameters[] = array("@pconfigdoc", $configdoc);
            $parameters[] = array("@pctipdocu", $ctipdocu);
            $parameters[] = array("@pctipestrdocu", $ctipestrdocu);
            $parameters[] = array("@pnorden", $norden);
            $recordsDdocument = $cn->executeAssocQuery($procedure, $parameters);
            echo json_encode($recordsDdocument);
        }
    }

    public function backupAction() {
        
    }

    public function backupfilesAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();

        if ($this->getRequest()->isXmlHttpRequest()) {
            echo $this->view->Util()->backupUploadedFiles();
        }
    }

    public function backupdbAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();

        if ($this->getRequest()->isXmlHttpRequest()) {
            echo $this->view->Util()->backupDatabase();
        }
    }

    public function corusudocAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->getHelper('ajaxContext')->initContext();
        $pcidUsuario = $this->_request->getParam('pcidUsuario');
        $cn = new Model_DataAdapter();
        $proc ='tramite.mDocuUsuPeriodos';
        $prmts[] = array("@pUsuario",$pcidUsuario);
        
        $func = new Libreria_Pintar();
        $rPeriodos = $cn->ejec_store_procedura_sql($proc, $prmts);
        $this->view->optionsPeriodo = $func->ContenidoCombo( (is_array($rPeriodos)? $rPeriodos : array(array("","Sin Periodos"))) , (int) date("Y"),'0');
        
        //print_r($cn->executeAssocQuery($proc, $prmts));
/*
        $cn = new Model_DataAdapter();
        $procedure = 'tramite.sp_mDocuNotUsu';
        $parameters[] = array("@pcidUsuario", $pcidUsuario);
        $this->view->jsonResult = json_encode($cn->executeAssocQuery($procedure, $parameters));
        $procedure = 'tramite.sp_mDocuUsu';
        $this->view->jsonResultDocUsu = json_encode($cn->executeAssocQuery($procedure, $parameters));*/
        $this->view->idUsuario = $pcidUsuario;
    }

    public function corusudocinsertAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $pXmlDocuUsu = $this->_request->getParam('pXmlDocuUsu');

            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $pHost = $ddatosuserlog->vhostnm;
            $pUser = $ddatosuserlog->userlogin;

            $cn = new Model_DataAdapter();
            $procedure = 'tramite.sp_mDocuUsuInsert';
            $parameters[] = array("@pXmlDocuUsu", $pXmlDocuUsu);
            $parameters[] = array("@pHost", $pHost);
            $parameters[] = array("@pUser", $pUser);
            $result = $cn->executeAssocQuery($procedure, $parameters);
            echo json_encode($result);
        }
    }

    public function getmdocusucAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $pcidUsuario = $this->_request->getParam('pcidUsuario');
            $pcperanio = $this->_request->getParam('pcperanio');
            $cn = new Model_DataAdapter();
            $procedure = 'tramite.sp_mDocuUsu';
            $parameters[] = array("@pcidUsuario", $pcidUsuario);
            $parameters[] = array("@pcperanio", $pcperanio);
            echo json_encode(array("list"=> $cn->executeAssocQuery($procedure, $parameters)));
        }
    }
    
    public function getmdocnotusuAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $pcidUsuario = $this->_request->getParam('pcidUsuario');
            $pcperanio = $this->_request->getParam('pcperanio');
            $cn = new Model_DataAdapter();
            $procedure = 'tramite.sp_mDocuNotUsu';
            $parameters[] = array("@pcidUsuario", $pcidUsuario);
            $parameters[] = array("@pcperanio", $pcperanio);
            echo json_encode(array("list" => $cn->executeAssocQuery($procedure, $parameters)));
        }
    }
    
    public function corusudocupdateAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $pvalor = $this->_request->getParam('valor');
            $pvsiglas = $this->_request->getParam('vsiglas');
            $pestado = $this->_request->getParam('estado');
            $poper = $this->_request->getParam('oper');
            $pid = $this->_request->getParam('id');
            
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $pHost = $ddatosuserlog->vhostnm;
            $pUser = $ddatosuserlog->userlogin;

            $cn = new Model_DataAdapter();
            $procedure = 'tramite.sp_mDocuUsuUpdate';
            $parameters[] = array("@pvalor", $pvalor);
            $parameters[] = array("@pvsiglas", $pvsiglas);
            $parameters[] = array("@pestado", $pestado);
            $parameters[] = array("@poper", $poper);
            $parameters[] = array("@pid", $pid);
            $parameters[] = array("@pHost", $pHost);
            $parameters[] = array("@pUser", $pUser);
            $result = $cn->executeAssocQuery($procedure, $parameters);
            echo json_encode($result);
        }
    }

    public function corusudoccrearperiodoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $pcidUsuario = $this->_request->getParam('pcidUsuario');
            $pPeriodoPredeterminado = $this->_request->getParam('pPeriodoPredeterminado');
            
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $pHost = $ddatosuserlog->vhostnm;
            $pUser = $ddatosuserlog->userlogin;

            $cn = new Model_DataAdapter();
            $procedure = 'tramite.sp_mDocuUsuCrearPeriodo';
            $parameters[] = array("@pcidUsuario", $pcidUsuario);
            $parameters[] = array("@pPeriodoPredeterminado", $pPeriodoPredeterminado);
            $parameters[] = array("@pHost", $pHost);
            $parameters[] = array("@pUser", $pUser);
            $result = $cn->executeAssocQuery($procedure, $parameters);
            echo json_encode($result);
        }
    }

    
}
