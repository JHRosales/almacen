<?php

require_once 'Zend/Controller/Action.php';

class CotizacionController extends Zend_Controller_Action {

    public function init() {
        $this->view->util()->registerScriptJSController($this->getRequest());
        $map = new Zend_Session_Namespace("map");
        $map->data = false;
    }

    public function indexAction() {
        
    }

    public function listarusuarioAction() {
        
    }

    public function usuarioAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
        }
        $func = new Libreria_Pintar();
        $evt[] = array("txtusuario", "keypress", "return validarletrassinespacios(event);");
        $func->PintarEvento($evt);

        $cidusuario = $this->_request->getPost('cidusuario');
        //$cidusuario = '0000000001';

        $cn = new Model_DataAdapter();

        $params[] = array("@p_cidusuario", $cidusuario);
        $params[] = array("@p_cidarea", "");
        $params[] = array("@p_tipousuario", "");
        $usuario = $cn->executeAssocQuery('seguridad.listar_usuario', $params);
        $cusuario = count($usuario);

        $this->view->cidusuario = $cidusuario;
        if ($cusuario == 0 || $cusuario > 1) {
            $this->view->cidarea = '';
            $this->view->cidpers = '';
            $this->view->vperson = '';
            $this->view->tipousuario = '';
            $this->view->usuario = '';
            $this->view->fechainicio = date('d/m/Y');
            $this->view->fechafin = date('d/m/Y');
            $this->view->nrocaja = '';
            $this->view->estado = '1';
            $this->view->ntramite = '4';
            $this->view->flglegal = '0';
        } else {
            $this->view->cidarea = $usuario[0]['cidarea'];
            $this->view->cidpers = $usuario[0]['cidpers'];
            $this->view->vperson = $usuario[0]['vperson'];
            $this->view->tipousuario = $usuario[0]['tipousuario'];
            $this->view->usuario = $usuario[0]['usuario'];
            $this->view->fechainicio = $usuario[0]['fecha_inicio'];
            $this->view->fechafin = $usuario[0]['fecha_fin'];
            $this->view->nrocaja = $usuario[0]['nrocaja'];
            $this->view->estado = $usuario[0]['estado'];
            $this->view->ntramite = $usuario[0]['ntramite'];
            $this->view->flglegal = $usuario[0]['flaglegal'];
        }
    }

    public function guardarusuarioAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $cn = new Model_DataAdapter();

            $cidusuario = $this->_request->getParam('cidusuario');
            $cidarea = $this->_request->getParam('cidarea');
            $cidpers = $this->_request->getParam('cidpers');
            $tipousuario = $this->_request->getParam('tipousuario');
            $usuario = $this->_request->getParam('usuario');
            $fechainicio = $this->_request->getParam('fechainicio');
            $fechafin = $this->_request->getParam('fechafin');
            $nrocaja = $this->_request->getParam('nrocaja');
            $estado = $this->_request->getParam('estado');
            $ntramite = $this->_request->getParam('ntramite');
            $flglegal = $this->_request->getParam('flglegal');

            $permisos = $this->_request->getParam('permisos');
            $decodePermisos = json_decode($permisos, true);
            $cpermisos = count($decodePermisos);

            $params = null;
            $params[] = array('@p_cidusuario', $cidusuario);
            $params[] = array('@p_cidarea', $cidarea);
            $params[] = array('@p_cidpers', $cidpers);
            $params[] = array('@p_tipousuario', $tipousuario);
            $params[] = array('@p_usuario', strtoupper($usuario));
            $params[] = array('@p_fecha_inicio', $fechainicio);
            $params[] = array('@p_fecha_fin', $fechafin);
            $params[] = array('@p_fecha_vencimiento', date("d/m/Y")); // No se guarda
            $params[] = array('@p_nrocaja', $nrocaja);
            $params[] = array('@p_estado', $estado);
            $params[] = array('@p_vhostnm', '');
            $params[] = array('@p_vusernm', '');
            $params[] = array('@p_ntramite', $ntramite);
            $params[] = array('@p_flglegal', $flglegal);
            $usuario = $cn->ejec_store_procedura_sql('seguridad.guardar_usuario', $params);

            // Permisos
            for ($i = 0; $i < $cpermisos; $i++) {
                if ($decodePermisos[$i]['estado_f'] !== $decodePermisos[$i]['estado_i']) {
                    $params = null;
                    $params[] = array('@p_cidusuario', $cidusuario);
                    $params[] = array('@p_cidobjeto', $decodePermisos[$i]['cidobjeto']);
                    $params[] = array('@p_estado', $decodePermisos[$i]['estado_f']);

                    $params[] = array('@p_vhostnm', 'PC');
                    $params[] = array('@p_vusernm', 'USU');

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
    public function productdelAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('ajaxContext')->initContext();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $cn = new Model_DataAdapter ();

            $idProducto = $this->_request->getPost('idProducto');

            $params = null;
            $params[] = array('@p_idprod', $idProducto);

            $prod = $cn->ejec_store_procedura_sql('eliminar_producto', $params);
            // $cperson = count($prod);
            //echo $prod;
            echo json_encode($prod);
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

    public function buscarpersonaAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsigma = $this->_request->getPost('idsigma');
            $this->view->idsigma = $idsigma;
        }
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
                    'buscar_persona'
                    , $parametros
            );

            $this->view->idsigma = $idsigma;

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->vpatern = '';
                $this->view->vmatern = '';
                $this->view->vnombre = '';

                $this->view->ctipper = '9999999999';
                $this->view->vdirecc = '';
                $this->view->ctipdoc = '9999999999';
                $this->view->vnrodoc = '';
                $this->view->vcorreo = '';

                $this->view->vtelfij = "";
                $this->view->vtelmov = "";
                
                // Ubigeo por defecto
                $this->view->cpais = '0000000001';
                $this->view->cdpto = '0000000002';
                $this->view->cprov = '0000000003';
                $this->view->cdist = '0000000004';
            } else {
                $this->view->vpatern = $datos[0]['vpatern'];
                $this->view->vmatern = $datos[0]['vmatern'];
                $this->view->vnombre = $datos[0]['vnombre'];
                    
                $this->view->ctipper = $datos[0]['ctipper'];
                $this->view->vdirecc = $datos[0]['vdirecc'];
                $this->view->ctipdoc = $datos[0]['ctipdoc'];
                $this->view->vnrodoc = $datos[0]['vnrodoc'];
                $this->view->vcorreo = $datos[0]['vcorreo'];

                $this->view->vtelfij = $datos[0]['ctelfij'];
                $this->view->vtelmov = $datos[0]['ctelmov'];
                // Ubigeo por defecto
                $this->view->cpais = $datos[0]['cpais'];
                $this->view->cdpto = $datos[0]['cdpto'];
                $this->view->cprov = $datos[0]['cprov'];
                $this->view->cdist = $datos[0]['cdist'];
                $this->view->nestado = $datos[0]['nestado'];
            }
        }

        $evt[] = array("txtvnrodoc", "keypress", "return validarnumerossinespacios(event);");
        $func->PintarEvento($evt);
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

   public function guardarpersonaAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $cn = new Model_DataAdapter ();

            $idsigma = $this->_request->getPost('idsigma');
            $vpatern = $this->_request->getPost('vpatern');
            $vmatern = $this->_request->getPost('vmatern');
            $vnombre = $this->_request->getPost('vnombre');
            $ctipper = $this->_request->getPost('ctipper');
            $vdirecc = $this->_request->getPost('vdirecc');
            $ctipdoc = $this->_request->getPost('ctipdoc');
            $vnrodoc = $this->_request->getPost('vnrodoc');
            $vcorreo = $this->_request->getPost('vcorreo');

            $vtelfij = $this->_request->getPost('vtelfij');
            $vtelmov = $this->_request->getPost('vtelmov');
            
            $vcpais = $this->_request->getPost('vcpais');
            $vcdpto = $this->_request->getPost('vcdpto');
            $vcprov = $this->_request->getPost('vcprov');
            $vcdist = $this->_request->getPost('vcdist');

            $estado1 = $this->_request->getPost('nestado');



            $params = null;
            $params[] = array('@p_idsigma', $idsigma);
            $params[] = array('@p_vpatern', strtoupper($vpatern));
            $params[] = array('@p_vmatern', strtoupper($vmatern));
            $params[] = array('@p_vnombre', strtoupper($vnombre));
            $params[] = array('@p_ctipper', $ctipper);
            $params[] = array('@p_vdirecc', strtoupper($vdirecc));
            $params[] = array('@p_ctipdoc', $ctipdoc);
            $params[] = array('@p_vnrodoc', $vnrodoc);
            $params[] = array('@p_vcorreo', $vcorreo);

            $params[] = array('@p_cpais', $vcpais);
            $params[] = array('@p_cdpto', $vcdpto);
            $params[] = array('@p_cprov', $vcprov);
            $params[] = array('@p_cdist', $vcdist);
            
            $params[] = array('@p_ctelfij', $vtelfij);
            $params[] = array('@p_ctelmov', $vtelmov);
            $params[] = array('@p_estado', $estado1);

            $person = $cn->ejec_store_procedura_sql('guardar_mperson', $params);
            $cperson = count($person);
            echo $person[0][0];
        }
    }


    public function cotizacionAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
        }
        //$this->view->fechaini=date('d/m/Y');
        //$this->view->fechafin=date('d/m/Y');
        $this->view->idcotiz="se";

    }
    public function detcotizacionAction() {
        $this->view->tieneop=0;
        $this->view->vMotivo="SISTEMA CCTV HDCVI - HD";
        $this->view->vFormaPago="Al contado";
        $this->view->nreferencial="Seleccione";
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idcotizacion = $this->_request->getParam('idcotizacion');
            $this->view->idcotizacion =$idcotizacion;
            $cn = new Model_DataAdapter ();
            $params[] = array('@p7_idcoti', $idcotizacion);
            $datos = $cn->ejec_store_procedura_sql('buscar_cotizacion', $params);

            $cdatos = count($datos);
            if ($cdatos == 0) {
                $this->view->vnrocot =$datos[0][1];
                $this->view->dfeccot=$datos[0][2];
                $this->view->idcliente=$datos[0][3];
                $this->view->nombrec =$datos[0][4];
                $this->view->vnrodoc=$datos[0][9];
                $this->view->subtotal=$datos[0][5];
                $this->view->igv=$datos[0][6];
                $this->view->total=$datos[0][7];
                $this->view->ctipmon=$datos[0][10];
                $this->view->tasacambio=$datos[0][11];
                $this->view->clientetec=$datos[0][12];
                $this->view->tentrega=$datos[0][13];
                $this->view->garantia=$datos[0][14];
                $this->view->personal=$datos[0][15];
                $this->view->vMotivo=$datos[0][16];
                $this->view->vFormaPago=$datos[0][17];
                $this->view->nreferencial=$datos[0][18];
                $this->view->disco=$datos[0][19];
                $this->view->tiempoo=$datos[0][21];
            }else{
            $this->view->vnrocot =$datos[0][1];
            $this->view->dfeccot=$datos[0][2];
            $this->view->idcliente=$datos[0][3];
            $this->view->nombrec =$datos[0][4];
            $this->view->vnrodoc=$datos[0][9];
            $this->view->subtotal=$datos[0][5];
            $this->view->igv=$datos[0][6];
            $this->view->total=$datos[0][7];
            $this->view->ctipmon=$datos[0][10];
            $this->view->tasacambio=$datos[0][11];
            $this->view->clientetec=$datos[0][12];
            $this->view->tentrega=$datos[0][13];
            $this->view->garantia=$datos[0][14];
            $this->view->personal=$datos[0][15];
            $this->view->vMotivo=$datos[0][16];
            $this->view->vFormaPago=$datos[0][17];
            $this->view->nreferencial=$datos[0][18];
            $this->view->disco=$datos[0][19];
            $this->view->tiempoo=$datos[0][21];
                $paramsop[] = array('@p_idcoti', $idcotizacion);
                $opcional = $cn->ejec_store_procedura_sql('buscar_detopcional', $paramsop);
                $copcional = count($opcional);
                if($copcional==0){
                    $this->view->tieneop=0;
                }else{
                    $this->view->tieneop=1;
                }
            }


        }
    }

    public function cotizacionsaveAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $idcliente = $this->_request->getPost('idsigma');
            $idcotiz = $this->_request->getPost('idcotizacion');
            $params = null;
            $params[] = array('@p_idcotiz', $idcotiz);
            $params[] = array('@p_idclient',$idcliente);
            $params[] = array('@p_idpersonal', $idpersonal);
            $params[] = array('@p_iduser', $usuario);
            $params[] = array('@p_idhost', $host);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $person = $cn->executeAssocQuery('guardar_cotizacion', $params);
            $cperson = count($person);
            echo json_encode($person);
        }
    }

    public function addpsmAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsigma = $this->_request->getPost('idsigma');
            $opcional = $this->_request->getPost('opcional');
            $this->view->idcotizacion = $idsigma;
            $this->view->opcional = $opcional;
        }
    }

    public function detcotizacionaddAction() {
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
            $nombre = $this->_request->getPost('nombre');
            $descri = $this->_request->getPost('descri');
            $pu = $this->_request->getPost('pu');
            $idcotiz = $this->_request->getPost('idcotizacion');
            $tipo = $this->_request->getPost('tipo');
            $opcional = $this->_request->getPost('opcional');
            $tipomon = $this->_request->getPost('tipomon');
            $tasa = $this->_request->getPost('tasa');

            $params = null;
            $params[] = array('@p_idcotiz', $idcotiz);
            $params[] = array('@p_id',$id);
            $params[] = array('@p_nombre', $nombre);
            $params[] = array('@p_descri', $descri);
            $params[] = array('@p_pu', $pu);
            $params[] = array('@p_tipo', $tipo);
            $params[] = array('@p_opcional', $opcional);
            $params[] = array('@p_tipom', $tipomon);
            $params[] = array('@p_tasa', $tasa);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->executeAssocQuery('add_detcotizacion', $params);
            $cperson = count($detcot);
            echo json_encode($detcot);
        }
    }
    public function detcotizacionupdateAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $iddcot = $this->_request->getPost('idDetCotiz');
            $punit = $this->_request->getPost('nPrecUnit');
            $canti = $this->_request->getPost('nCantidad');
            $descu = $this->_request->getPost('nDescu');
            $ptotal = $this->_request->getPost('nPrecTotal');
             if ($descu==''){
                 $descu=0;
             }
            $params = null;
            $params[] = array('@p_idDetCotiz', $iddcot);
            $params[] = array('@p_nPrecUnit',$punit);
            $params[] = array('@p_nCantidad', $canti);
            $params[] = array('@p_nPrecTota', $ptotal);
            $params[] = array('@p_nDescu', $descu);
            $detcot = $cn->ejec_store_procedura_sql('update_detcotizacion', $params);
           //echo json_encode($detcot);
        }
    }

    public function cotizacionupdateAction() {
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
            $tipoMoneda = $this->_request->getPost('tipoMoneda');
            $tasaCambio = $this->_request->getPost('tasaCambio');
            $Clientetec = $this->_request->getPost('Clientetec');
            $tentrega = $this->_request->getPost('TiempoEntrega');
            $garantia = $this->_request->getPost('Garantia');
            $motivo = $this->_request->getPost('Motivo');
            $formapago = $this->_request->getPost('Formapago');
            $referencial = $this->_request->getPost('Referencial');
            $disco = $this->_request->getPost('Disco');
            $tiempo = $this->_request->getPost('Tiempo');

            if ($tasaCambio==''){
                $tasaCambio=0;
            }

            echo"<pre>";
            // print_r($txtdescrip);
            $texto = str_replace(array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ"),
                array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
                    "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), $referencial);
            print_r($texto);

            echo"</pre>";


            echo"<pre>";
            // print_r($txtdescrip);
            $texto2 = str_replace(array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ"),
                array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
                    "&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), $motivo);
            print_r($texto2);

            echo"</pre>";




            $params = null;
            $params[] = array('@p_idcotiz', $idcot);
            $params[] = array('@p_subt',$subtot);
            $params[] = array('@p_igv', $igv);
            $params[] = array('@p_tot', $total);
            $params[] = array('@p_tipoMon', $tipoMoneda);
            $params[] = array('@p_tasacam', $tasaCambio);
            $params[] = array('@p_Clientetec', $Clientetec);
            $params[] = array('@p_tiemEntrega', $tentrega);
            $params[] = array('@p_vgarantia', $garantia);
            $params[] = array('@p_vmotivo', utf8_decode(str_replace('"','&quot;',str_replace( "•",'&bull;',$texto2))));
            $params[] = array('@p_vformapago', $formapago);
            $params[] = array('@p_vreferencial', utf8_decode(str_replace('"','&quot;',str_replace( "•",'&bull;',$texto))));
            $params[] = array('@p_disco', $disco);
            $params[] = array('@p_tiempo', $tiempo);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->ejec_store_procedura_sql('update_cotizacion', $params);
           // echo json_encode($detcot);
        }
    }


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
            $detcot = $cn->ejec_store_procedura_sql('update_cotiz_opcprin', $params);
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
            $detcot = $cn->ejec_store_procedura_sql('delete_cotiz', $params);
             //echo json_encode("Desabilitado.");
        }
    }

    public function cancelarcotizAction() {
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
            $detcot = $cn->ejec_store_procedura_sql('cancelar_cotizacion', $params);
            echo json_encode("Cancelando.");
        }
    }

    public function detcotizaciondelAction() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->viewRenderer->setNoRender();
            $cn = new Model_DataAdapter ();
            $ddatosuserlog = new Zend_Session_Namespace('datosuserlog');
            $idpersonal= $ddatosuserlog->cidusuario;
            $usuario = $ddatosuserlog->userlogin;
            $host = $ddatosuserlog->vhostnm;

            $iddcot = $this->_request->getPost('idDetCotiz');

            $params = null;
            $params[] = array('@p_iddcotiz', $iddcot);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->ejec_store_procedura_sql('delete_dcotiz', $params);
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
            $copiarcot = $cn->executeAssocQuery('copiar_cotizacion', $params);
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
            $copiarcot = $cn->executeAssocQuery('eliminar_cotizacion', $params);
            echo json_encode($copiarcot);
        }
    }

    public function visordocsAction() {

        $img = $this->_request->getParam('img', '');
        $this->_helper->layout->disableLayout();
        $this->view->img = $img;
    }



    
}
