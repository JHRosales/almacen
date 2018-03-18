function detallenodomconten(_idnodo, _idpadre){
    var parameters = {
        idnodo: _idnodo, 
        idpadre: _idpadre
    };
    var _post = $.post(path + "mantenimientos/mcontennodo/", parameters);
    _post.success(function(requestData){
        $("#cont_form").html(requestData);
    });
    _post.error(postError);
}

function guardarmcontennodo(){
    var codigo 		= $('#c_codigo').html();
    var descripcion = $('#txt_descripcion').val();
    var padre 		= $('#cb_padre').val();
    var observ 		= $('#txa_observ').val();
    var long 		= 0; // $('#txt_long').val();
    var decimal 	= 0; // $('#txt_decimal').val();
    var defecto 	= ''; // $('#txt_defecto').val();
    var estado 		= $('#cb_estado').val();

    $.ajax({
        dataType: "html",
        type: "POST",
        url: path + "mantenimientos/guardarmcontennodo/", // Ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
        data: "codigo="+codigo
        +"&descripcion="+descripcion
        +"&padre="+padre
        +"&long="+long
        +"&observ="+observ
        +"&decimal="+decimal
        +"&defecto="+defecto
        +"&estado="+estado,
        success: function(requestData){ 	//Llamada exitosa)
            $("#div_mensaje").html(requestData);
        },		
        error: function(requestData, errNumber, errMessage){
            if(errNumber == '') {
                openDialogError("No se puede determinar el error.");
            } else {
                openDialogError(errNumber +': ' + errMessage);
            }
        }
    });

}

function selectEsquemaConten(){
    $.ajax({
        dataType: "html",
        type: "POST",
        url: path + "mantenimientos/mcontenesquema/", // Ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
        data: "schemaid="+$("#cboesquema").val(),
        success: function(requestData){ 	//Llamada exitosa)
            window.open(path + 'mantenimientos/mconten', '_self');
        },
        error: function(requestData, errNumber, errMessage){
        }
    });

}

function imprimirmconten(id){	
	window.open(pathReport+"reporte=report_contenedores&opt=P_cidtabl^"+id , '_blank');
}