<?php

class Zend_View_Helper_Util extends Zend_View_Helper_Abstract {

    private $widthLayout = 1030;
    private $widthLayoutIndex = 1202;
    private $heightLayout = 480;

    public function util() {
        return $this;
    }

    public function getTheme() {
        return "humanity"; //pepper-grinder
    }

    public function getTitle() {
        return "Almacen";
    }

    public function getEntidad() {
        return "Almacen";
    }

    public function getRUC() {
        return "";
    }

    public function getAreaCobranza() {
        return "Almacen";
    }

    public function getProtocol() {
        return "http://";
    }

    public function getHost() {
        // return str_replace(":" . $_SERVER["SERVER_PORT"], "", $_SERVER["HTTP_HOST"]);
        return $_SERVER["HTTP_HOST"];
    }

    public function getPath() {
        $path = explode("/index.php", $_SERVER["PHP_SELF"]);
        return $this->getProtocol() . $this->getHost() . $path[0] . "/" . PATH;
    }

    public function getPath2() {
        $path = explode("/index.php", $_SERVER["PHP_SELF"]);
        return $this->getProtocol() . $this->getHost() . $path[0] . "/";
    }

    public function getPathReport() {
        //return $this->getProtocol() . $this->getHost() . ':8080/Rpt_titania_tramite/index.jsp?';
		
		$currHost = str_replace(":" . $_SERVER["SERVER_PORT"], "", $_SERVER["HTTP_HOST"]);
		return $this->getProtocol() . $currHost . ':8080/Rpt_camaras/index.jsp?';
		
		
    }

    public function getLink($url) {
        return $this->getPath2() . "index.php/" . $url;
    }

    public function getImage($image) {
        return $this->getPath() . "img/$image";
    }

    public function getImageAdjunto($image) {
    	return $this->getPath() . "uploadDdocuments/$image";
    }
    public function getFichaTecnica($image) {
        return $this->getPath() . "FichaTecnica/$image";
    }
    public function getPhoto($image) {
        $file = getcwd() . "/fotos/" . $image . ".png";
        if (file_exists($file)) {
            $file = $this->getPath() . "fotos/$image.png";
        } else {
            $file = $this->getPath() . "fotos/0000000000.png";
        }
        return $file;
    }
    public function getCabecera($nompers) {
        if(trim($nompers != '' && $nompers != null)<>"")
        {
            $imgcabecera="barTitle";
            $this->widthLayout=1030;
        }
        else
            $imgcabecera="";

        return $imgcabecera;
    }
    public function getPhotosType($image) {
        $file = getcwd() . "/fotos/" . $image;

        if (file_exists($file)) {
            $file = $this->getPath() . "fotos/$image";
        } else {
            $file = $this->getPath() . "fotos/0000000000.png";
        }
        return $file;
    }

    public function getScript($pathJS) {
        $script = "\n";
        $files = $this->readFile($pathJS, $this->getPath());
        foreach ($files as $value) {
            if (!is_array($value)) {
                $script .= "\t\t<script type='text/javascript' src='$value'></script>\n";
            }
        }
        return $script;
    }

    public function isMap() {
        $session = new Zend_Session_Namespace("map");

        if ($session->data) {
            $script = "<script type=\"text/javascript\" src=\"http://maps.google.com/maps/api/js?sensor=false\"></script>";
            $session->data = false;
        } else {
            $script = "";
        }

        return $script;
    }

    public function registerScriptJSController(Zend_Controller_Request_Abstract $request) {
        $controller = $request->getControllerName();
        $script = "\t\t<script type='text/javascript' src='" . $this->getPath() . "js/js_" . $controller . ".js'/></script>\n";
        $session = new Zend_Session_Namespace("scriptController");
        $session->data = $script;
        return $script;
    }

    public function registerScriptJSControllerAction(Zend_Controller_Request_Abstract $request) {
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        $script = "\t\t<script type='text/javascript' src='" . $this->getPath() . "js/" . $controller . "/" . $action . ".js'/></script>\n";
        $session = new Zend_Session_Namespace("scriptControllerAction");
        $session->data = $script;
        return $script;
    }

    public function registerLeaveControllerAction(Zend_Controller_Request_Abstract $request) {
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        $script = "\t\t<script type='text/javascript'/>var __rw = " . 'false' . ";</script>\n";
        $session = new Zend_Session_Namespace("leave");
        $session->data = $script;
        return $script;
    }

    public function getScriptJSController() {
        $session = new Zend_Session_Namespace("scriptController");
        $script = $session->data;
        $session->data = "";
        return $script;
    }

    public function getScriptJSControllerAction() {
        $session = new Zend_Session_Namespace("scriptControllerAction");
        $script = $session->data;
        $session->data = "";
        return $script;
    }

    public function getScriptLeave() {
        $session = new Zend_Session_Namespace("leave");
        $script = $session->data;
        $session->data = "";
        return $script;
    }

    public function getStyle() {
        $files = $this->readFile("css", $this->getPath());
        $script = $this->style($files);
        return $script;
    }

    public function getWidthLayout() {
        return $this->widthLayout . "px";
    }

    public function getSubstractWidthLayout($size) {
        return ($this->widthLayout - $size) . "px";
    }

    public function getHeightLayout() {
        return $this->heightLayout;
    }

    public function getSubstractHeightLayout($size) {
        return ($this->heightLayout - $size) . "px";
    }

    public function getNow() {
        return date("Y-m-d H:i:s");
    }

    public function getPeriodos() {
        $result = "<select id='cboPeriodo' style='width: 60px;'>";
        $year = (int) date("Y");
        $year = 2016;
        for ($i = $year; $i >= 2014; $i--) {
            $result .= "\n\t<option value='$i'>$i</option>";
        }
        $result .= "\n</select>";

        return $result;
    }

    public function getPeriodosDeclaradoCheckBox($mhresum) {
        $parameters[] = $mhresum;
        $dataAdapter = new Model_DataAdapter();
        $rows = $dataAdapter->ejec_store_procedura_sql("pl_function.listar_periodo", $parameters);
        $result = "<div id='dialogPeriodoCheckBox' style='width: 120px;'><table align='center' cellpadding='2' cellspacing='2'>";
        $anioact = date("Y");
        if (count($rows) > 0) {
            foreach ($rows as $k => $v) {
                $result .= "<tr><td><input type='checkbox' class='chkPnlPeriodo' ".($anioact==$v[0] ?"checked" : "")." value='" . $v[0]. "' /></td><td><b>" . $v[0] . "</b></td></tr>";
            }
        }
        $result .= "\n</table><br/><center><button id='btnDialogPeriodoCheckBoxAceptar'>Aceptar</button><button id='btnDialogPeriodoCheckBoxCancelar'>Cancelar</button></center></div>";

        return $result;
    }

    public function getPeriodosDeclarado($mhresum, $selected) {
        $parameters[] = $mhresum;
        $dataAdapter = new Model_DataAdapter();
        $rows = $dataAdapter->ejec_store_procedura_sql("pl_function.listar_periodo", $parameters);
        $result = "<select id='cboPeriodo' style='width: 60px;'>";
        if (count($rows) > 0) {
            foreach ($rows as $k => $v) {
                if ($v[0] == $selected) {
                    $result .= "<option value=\"" . $v[0] . "\" selected=\"selected\">" . $v[0] . "</option>";
                } else {
                    $result .= "<option value=\"" . $v[0] . "\">" . $v[0] . "</option>";
                }
            }
        }
        $result .= "\n</select>";

        return $result;
    }

    // todo : Revisar
    public function getAsuntoRequisitos($mdocumento,$dasunto){
        $dataAdapter = new Model_DataAdapter();
        $params[] = array('@p_mdocumento', $mdocumento);
        $params[] = array('@p_dasunto', $dasunto);
        $records = $dataAdapter->ejec_store_procedura_sql('tramite.listar_dasunto_req_bydocum', $params);
        $crecords = count($records);
        $reqs = 'Requisitos faltantes ('.$crecords.') : <br/>';
        for($i=0;$i<$crecords;++$i){
            $reqs .= '<a href="javascript:void(0)" onclick="InsertarDocRequisito(\''.$records[$i][3].'\')">'.$records[$i][4].'</a>, ';
        }
        $reqs = trim($reqs, ', ');
        return $reqs;

    }
            
    public function getComboContenedor($idsigma, $selected) {
        $procedure = 'obtener_tabla';
        $parameters[0] = array("@idsigma",$idsigma);
        $dataAdapter = new Model_DataAdapter();
        $records = $dataAdapter->ejec_store_procedura_sql($procedure, $parameters);

        $library = new Libreria_Pintar();
        $html = $library->ContenidoCombo($records, $selected);

        return $html;
    }

    public function getComboContenedorTramite($idsigma, $selected) {
        $procedure = 'tramite.obtener_tabla';
        $parameters[0] = array("@idsigma",$idsigma);
        $dataAdapter = new Model_DataAdapter();
        $records = $dataAdapter->ejec_store_procedura_sql($procedure, $parameters);
        $library = new Libreria_Pintar();
        $html = $library->ContenidoCombo($records, $selected);
        return $html;
    }
    public function getComboContenedorUbigeo($idsigma, $selected) {
        $procedure = 'ubigeo.obtener_tabla';
        $parameters[0] = array("@idsigma",$idsigma);
        $dataAdapter = new Model_DataAdapter();
        $records = $dataAdapter->ejec_store_procedura_sql($procedure, $parameters);

        $library = new Libreria_Pintar();
        $html = $library->ContenidoCombo($records, $selected);

        return $html;
    }
    public function getComboContenedorMateriaLegal($idsigma, $selected) {
        $procedure = 'legal.listarMateria';
        $parameters[0] = array("@cidespe",$idsigma);
        $dataAdapter = new Model_DataAdapter();
        $records = $dataAdapter->ejec_store_procedura_sql($procedure, $parameters);

        $library = new Libreria_Pintar();
        $html = $library->ContenidoCombo($records, $selected);

        return $html;
    }

    public function getComboContenedorJuzgadoLegal($idsigma, $selected) {
        $procedure = 'legal.listarJuzgado';
        $parameters[0] = array("@cidespe",$idsigma);
        $dataAdapter = new Model_DataAdapter();
        $records = $dataAdapter->ejec_store_procedura_sql($procedure, $parameters);

        $library = new Libreria_Pintar();
        $html = $library->ContenidoCombo($records, $selected);

        return $html;
    }

    public function getComboContenedorOtro($idsigma, $selected, $procedure, $prmname = '') {
        if($prmname == ''){
            $parameters[0] = $idsigma;
        }else{
            $parameters[0] = array($prmname, $idsigma);
        }

        $dataAdapter = new Model_DataAdapter();
        $records = $dataAdapter->ejec_store_procedura_sql($procedure, $parameters);

        if(count($records) > 0){
            $library = new Libreria_Pintar();
            $html = $library->ContenidoComboOtro($records, $selected);
        }else{
            $html = '<option value=\"9999999999\">SELECCIONE</option>';
        }


        return $html;
    }
    public function getComboContenedorxDescrip($idsigma, $selected, $procedure, $prmname = '') {
        if($prmname == ''){
            $parameters[0] = $idsigma;
        }else{
            $parameters[0] = array($prmname, $idsigma);
        }

        $dataAdapter = new Model_DataAdapter();
        $records = $dataAdapter->ejec_store_procedura_sql($procedure, $parameters);

        if(count($records) > 0){
            $library = new Libreria_Pintar();
            $html = $library->ContenidoComboSeleccionaporDescripcion($records, $selected);
        }else{
            $html = '<option value=\"9999999999\">SELECCIONE</option>';
        }


        return $html;
    }

    public function getComboContenedorOtro1($idsigma, $selected, $procedure, $prmname = '') {
        if($prmname == ''){
            $parameters[0] = $idsigma;
        }else{
            $parameters[0] = array($prmname, $idsigma);
        }

        $dataAdapter = new Model_DataAdapter();
        $records = $dataAdapter->ejec_store_procedura_sql($procedure, $parameters);

        if(count($records) > 0){
            $library = new Libreria_Pintar();
            $html = $library->ContenidoCombo($records, $selected);
        }else{
            $html = '<option value=\"9999999999\">SELECCIONE</option>';
        }


        return $html;
    }

    private function style($files) {
        $script = "\n";
        foreach ($files as $value) {
            if (!is_array($value)) {
                $ext = explode(".", $value);
                if (strtolower($ext[count($ext) - 1]) == 'css') {
                    $script .= "\t<link href='$value' rel=\"stylesheet\" type=\"text/css\"/>\n";
                }
            } else {
                $script .= $this->style($value);
            }
        }
        return $script;
    }

    private function readFile($carpeta, $path) {
        $script = array();
        if (is_dir(PATH . $carpeta)) {
            if (($_carpeta = opendir(PATH . $carpeta))) {
                while (($archivo = readdir($_carpeta)) !== false) {
                    if (is_dir(PATH . $carpeta . "/" . $archivo) && $archivo != "." && $archivo != "..") {
                        $script[] = $this->readFile($carpeta . "/" . $archivo, $path);
                    } else {
                        if ($archivo != "." && $archivo != "..") {
                            $script[] = $path . $carpeta . "/" . $archivo;
                        }
                    }
                }
                closedir($_carpeta);
            }
        }

        sort($script);
        return $script;
    }

    function getRecursiveArraySearch($needle,$haystack) {
    	foreach($haystack as $key=>$value) {
    		$current_key=$key;
    		if($needle===$value OR (is_array($value) && $this->getRecursiveArraySearch($needle,$value) !== false)) {
    			return $current_key;
    		}
    	}
    	return false;
    }

    function sendMail_tramite($musuario, $mdocumento, $vobserv) {
        $procedure = 'tramite.sp_dataformail';

        $params[] = array("@p_cidusuario", $musuario);
        $params[] = array("@p_mdocumento", $mdocumento);

        $dataAdapter = new Model_DataAdapter();
        $records = $dataAdapter->ejec_store_procedura_sql($procedure, $params);

        if ($records[0][2] !== '') {

            $to = $records[0][2];

            // subject
            $subject = 'Tramite Documentario - Nuevo Expediente Recibido';

            // message
            $message = '
            <html>
            <head>
              <title>Expediente ' . $records[0][1] . '</title>
            </head>
            <body>
                <table>
                    <tr>
                        <th>Expediente </th>
                        <th>' . $records[0][1] . '</th>
                    </tr>
                    <tr>
                        <th>Observacion</th>
                        <td>' . $vobserv . '</td>
                    </tr>

                </table>

            </body>
            </html>
            ';

            $mail = new Libreria_PHPMailer();
            $mail->isSMTP();
            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;
            //Ask for HTML-friendly debug output
            $mail->Debugoutput = 'html';
            //Set the hostname of the mail server
            $mail->Host = "apcvperu.gob.pe";
            //Set the SMTP port number - likely to be 25, 465 or 587
            $mail->Port = 25;
            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;
            //Username to use for SMTP authentication
            $mail->Username = "costaverde@apcvperu.gob.pe";
            //Password to use for SMTP authentication
            $mail->Password = "greencoast2013";

            //Set who the message is to be sent from
            $mail->setFrom('costaverde@apcvperu.gob.pe', 'Tramite ');
            //Set who the message is to be sent to
            $mail->addAddress($to, '');
            $mail->AddBCC("@gmail.com");
            //Set the subject line
            $mail->Subject = $subject;
  
            $mail->msgHTML($message);
            #$mail->send();
                    /*
            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                echo "Message sent!";
            }*/
            
            #$headers = 'MIME-Version: 1.0' . "\r\n";
            #$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            // Additional headers
            //$headers .= 'From: Tramite <noreply@tramite.com>' . "\r\n";
            #$headers .= 'From: Tramite <costaverde@apcvperu.gob.pe>' . "\r\n";

            // Mail it
            #mail($to, $subject, $message, $headers);
        }
    }
    
	function sendMailArea($cidarea, $mdocumento, $vobserv) {
		$procedure = 'tramite.sp_dataformail_Area';
        $params[] = array("@p_cidarea", $cidarea);
        $params[] = array("@p_mdocumento", $mdocumento);
        $dataAdapter = new Model_DataAdapter();
        $records = $dataAdapter->executeAssocQuery($procedure, $params);
         foreach ($records as $values) {
            if ($values["vcorreo"] !== '') {
            $to = $values["vcorreo"] ;
			$area = $values["areadesc"];
            $subject = 'Tramite Documentario - Nuevo Expediente Recibido - '.$area;
            $message = '
            <html>
            <head>
              <title>Expediente ' . $values["vnrodocu"]  . '</title>
            </head>
            <body>
                <table>
                    <tr>
                        <th>Expediente </th>
                        <th>' . $values["vnrodocu"] . '</th>
                    </tr>
                    <tr>
                        <th>Observacion</th>
                        <td>' . $vobserv . '</td>
                   </tr>
                </table>
            </body>
            </html>
            ';
            $mail = new Libreria_PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'html';
            $mail->Host = "apcvperu.gob.pe";
            $mail->Port = 25;
            $mail->SMTPAuth = true;
            $mail->Username = "costaverde@apcvperu.gob.pe";
            $mail->Password = "greencoast2013";
            $mail->setFrom('costaverde@apcvperu.gob.pe', 'Tramite ');
            $mail->addAddress($to, '');
            $mail->AddBCC("@gmail.com");
            $mail->Subject = $subject;
            $mail->msgHTML($message);
            #$mail->send();
        }
        }
        
        
    }
	
    function getDatabaseBackupPath()
    {
        //return APPLICATION_PATH . '/../public/backup/db/';
		return 'D:/';
    }

    function backupDatabase()
    {
        $da = new Model_DataAdapter();

        $params = null;
        $params[] = array('@RutaBkData',$this->getDatabaseBackupPath());
        $db = $da->ejec_store_procedura_sql('Generar_Backup', $params);


        if(count($db) == 0 ){
            return 'No se pudo generar el .bak';
        }else{
            // return $db[0][0];
            $bakname = $db[0][0];
            $dlfile = $this->getPath() . 'backup/db/' . $bakname;
            return "Descargar: <a href='$dlfile'>$bakname</a>";
        }
    }

    function backupUploadedFiles()
    {
        $zip = new ZipArchive();
        // Ruta de los documentos a comprimir
        $dir = APPLICATION_PATH . '/../public/uploadDdocuments/';

        // Ruta donde se creara el archivo Zip
        $rutaFinal = APPLICATION_PATH . '/../public/backup/files/';

        // Nombre del archivo Zip
        $archivoZip = 'BACKUP_FILES_';
        $archivoZip .= date('Ymd_his').'.zip';

        // Ruta para que descargue el archivo Zip
        $dlfile = $this->getPath() . 'backup/files/' . $archivoZip;
        if($zip->open($archivoZip,ZIPARCHIVE::CREATE)===true) {
            if (is_dir($dir)) {
                if ($da = opendir($dir)) {
                    while (($archivo = readdir($da))!== false) {
                        if(is_file($dir.$archivo) && $archivo!="." && $archivo!=".."){
                            $zip->addFile($dir.$archivo, $archivo);
                        }
                    }
                    closedir($da);
                }
            }
            $zip->close();

            // Muevo el archivo a la ruta del filesystem donde se decargara
            @rename($archivoZip, "$rutaFinal$archivoZip");

            //Hasta aqui el archivo zip ya esta creado

            //Verifico si el archivo ha sido creado
            if (file_exists($rutaFinal.$archivoZip)){
                return "Descargar: <a href='$dlfile'>$archivoZip</a>";
            }else{
                return "Error, archivo zip no ha sido creado.";
            }
        }
    }
}
