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
            $this->view->idsigma = $idsigma;
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
    /*  public function usuarioAction() {
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
*/
    public function almacensaveAction() {
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
            $params[] = array('@p_sub', $total);
            $params[] = array('@nPrecioTotal', $subtot);
            $params[] = array('@dFecIngreso', $fecha);
            $params[] = array('@vEstado', "1");
            $params[] = array('@vUsernm', $usuario);
            $params[] = array('@vHostnm', $host);

            //$person = $cn->ejec_store_procedura_sql('guardar_cotizacion', $params);
            $detcot = $cn->ejec_store_procedura_sql('almacen.InsUpd_entradaMat', $params);
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

    public function detretornomatAction() {
        $this->view->tieneop=0;
        $this->view->dFecSalida = date('d/m/Y');
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->getHelper('ajaxContext')->initContext();
            $this->_helper->layout->disableLayout();
            $idsalidamat = $this->_request->getParam('idSalidaMat');
            $this->view->idsalidamat =$idsalidamat;
            $cn = new Model_DataAdapter ();
            $params[] = array('@tBusqueda', "0");
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
