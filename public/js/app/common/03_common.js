$.validity.setup({
    outputMode:"summary"
});

var config = {
    skin: 'office2003',
    toolbar: [
        ['Bold', 'Italic', 'Underline', '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Undo', 'Redo', '-', 'HorizontalRule', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'TextColor', 'BGColor'],
        ['UIColor']
    ]
},
 __gridConfigMaterial = {  //JHIMI 25022018
        height: 300,
        width: 1000,
        colNames: ['Codigo',
            'Nombre',
            'idTipoMaterial',
            'Tipo Material',
            'Marca',
            'idUnidadMed',
            'Unidad de Medida',
            'Stock',
            'idCategoria',
            'Categoria',
            'Estado'
        ],
        colModel: [
            {name: 'idMaterial', index:'idMaterial', width:60},
            {name: 'vNombreMat', index:'vNombreMat', width:150},
            {name: 'idTipoMaterial', index:'idTipoMaterial', hidden:true},
            {name: 'vTipoMaterial', index:'vTipoMaterial', width:120},
            {name: 'vMarca', index:'vMarca', width:100},
            {name: 'idUnidadMed', index:'idUnidadMed', width:80,hidden:true},
            {name: 'vUnidadMed', index:'vUnidadMed', width:120},
            {name: 'nStock', index:'nStock', width:70},
            {name: 'idCategoria', index:'idCategoria', width:150,hidden:true},
            {name: 'vCategoria', index:'vCategoria', width:150},
            {name: 'vEstado', index:'vEstado', width:50, hidden: true, editOptions:{value:"1:0",defaultvalue:"1"},formatter:'checkbox'}
        ],
        caption: "&nbsp;&nbsp;&nbsp;Resultados de la busqueda",
        onSelectRow: function() {},
        ondblClickRow: function() {},
        gridComplete: function() {}
    },
__gridConfigContribuyente = {
    height: 300,
    width: 1000,
    colNames: ["C\u00F3digo", "Administrado", "Direcci\u00F3n Fiscal"],
    colModel: [
        {name: 'cidpers', index: 'cidpers', width: 80, align: 'center'},
        {name: 'crazsoc', index: 'crazsoc', width: 420},
        {name: 'direccf', index: 'direccf', width: 420}],
    caption: "&nbsp;&nbsp;&nbsp;Resultados de la busqueda",
    onSelectRow: function() {},
    ondblClickRow: function() {},
    gridComplete: function() {}
},
__gridConfigViaPredio = {
    height: 300,
    width: 1000,
    colNames: [
        'idsigma', 'C\u00F3d. Predio', 'Direcci\u00F3n', 'mviadis', 'dnumero',
        'dmanzan', 'dnlotes', 'ddepart', 'dinteri', 'drefere',
        'dletras', 'destaci', 'ddeposi', 'ccatast', 'cplanos',
        'ctipmer', 'dnummer', 'cdiscat', 'czoncat', 'cmzacat',
        'cseccat', 'cltecat', 'cundcat', 'dbloque', 'dseccio',
        'dunidad', 'mpoblad', 'nestado', 'ctippre', 'idanexo',
        'ccodcuc', 'vhostnm', 'vusernm', 'ddatetm', 'nlatitu',
        'nlongit', 'nzoom', 'tnomvia', 'C\u00F3digo', 'Propietario',
        'direccf', 'vtipdoc', 'pnrodoc', 'vtippro', 'mhresum',
        'vnrodoc', 'cperiod'
    ],
    colModel: [
        {name: 'idsigma', index: 'idsigma', width: 1, hidden: true},
        {name: 'ccodpre', index: 'ccodpre', width: 70, align: 'center'},
        {name: 'vdirpre', index: 'vdirpre', width: 440},
        {name: 'mviadis', index: 'mviadis', width: 1, hidden: true},
        {name: 'dnumero', index: 'dnumero', width: 1, hidden: true},
        {name: 'dmanzan', index: 'dmanzan', width: 1, hidden: true},
        {name: 'dnlotes', index: 'dnlotes', width: 1, hidden: true},
        {name: 'ddepart', index: 'ddepart', width: 1, hidden: true},
        {name: 'dinteri', index: 'dinteri', width: 1, hidden: true},
        {name: 'drefere', index: 'drefere', width: 1, hidden: true},
        {name: 'dletras', index: 'dletras', width: 1, hidden: true},
        {name: 'destaci', index: 'destaci', width: 1, hidden: true},
        {name: 'ddeposi', index: 'ddeposi', width: 1, hidden: true},
        {name: 'ccatast', index: 'ccatast', width: 1, hidden: true},
        {name: 'cplanos', index: 'cplanos', width: 1, hidden: true},
        {name: 'ctipmer', index: 'ctipmer', width: 1, hidden: true},
        {name: 'dnummer', index: 'dnummer', width: 1, hidden: true},
        {name: 'cdiscat', index: 'cdiscat', width: 1, hidden: true},
        {name: 'czoncat', index: 'czoncat', width: 1, hidden: true},
        {name: 'cmzacat', index: 'cmzacat', width: 1, hidden: true},
        {name: 'cseccat', index: 'cseccat', width: 1, hidden: true},
        {name: 'cltecat', index: 'cltecat', width: 1, hidden: true},
        {name: 'cundcat', index: 'cundcat', width: 1, hidden: true},
        {name: 'dbloque', index: 'dbloque', width: 1, hidden: true},
        {name: 'dseccio', index: 'dseccio', width: 1, hidden: true},
        {name: 'dunidad', index: 'dunidad', width: 1, hidden: true},
        {name: 'mpoblad', index: 'mpoblad', width: 1, hidden: true},
        {name: 'nestado', index: 'nestado', width: 1, hidden: true},
        {name: 'ctippre', index: 'ctippre', width: 1, hidden: true},
        {name: 'idanexo', index: 'idanexo', width: 1, hidden: true},
        {name: 'ccodcuc', index: 'ccodcuc', width: 1, hidden: true},
        {name: 'vhostnm', index: 'vhostnm', width: 1, hidden: true},
        {name: 'vusernm', index: 'vusernm', width: 1, hidden: true},
        {name: 'ddatetm', index: 'ddatetm', width: 1, hidden: true},
        {name: 'nlatitu', index: 'nlatitu', width: 1, hidden: true},
        {name: 'nlongit', index: 'nlongit', width: 1, hidden: true},
        {name: 'nzoom', index: 'nzoom', width: 1, hidden: true},
        {name: 'tnomvia', index: 'tnomvia', width: 1, hidden: true},
        {name: 'cidpers', index: 'cidpers', width: 80, align: 'center'},
        {name: 'crazsoc', index: 'crazsoc', width: 390},
        {name: 'direccf', index: 'direccf', width: 1, hidden: true},
        {name: 'vtipdoc', index: 'vtipdoc', width: 1, hidden: true},
        {name: 'pnrodoc', index: 'pnrodoc', width: 1, hidden: true},
        {name: 'vtippro', index: 'vtippro', width: 1, hidden: true},
        {name: 'mhresum', index: 'mhresum', width: 1, hidden: true},
        {name: 'vnrodoc', index: 'vnrodoc', width: 1, hidden: true},
        {name: 'cperiod', index: 'cperiod', width: 1, hidden: true}
    ],
    caption: "&nbsp;&nbsp;&nbsp;Predios Registrados",
    onSelectRow: function() {},
    ondblClickRow: function() {},
    gridComplete: function() {}
},
imageFormat = function(cellvalue, options, rowdata) {
    return '<img src="' + pathImage + cellvalue + '" />';
};

imageUnFormat = function(cellvalue, options) {
    return $('img', cellvalue).attr('src');
};

postError = function(requestData, errMessage, errNumber) {
    if (errNumber == '') {
        openDialogError("No se puede determinar el error.");
    } else {
        openDialogError(errNumber + ': ' + errMessage);
    }
};

function procesarConsultaSubProceso(source, parameters, fnc, dataType) {
    if (dataType != null || dataType != undefined) {
        _post = $.post(path + "jqgrid/" + source, parameters, function(request) {
        }, dataType);
    }
    else {
        _post = $.post(path + "jqgrid/" + source, parameters);
    }
    _post.success(fnc);
}

function procesarSeleccion(idPanel, idx, _options, parameters) {
    procesarConsultaSubProceso('seleccionar', parameters, function(requestData) {
        $("#" + idPanel).html(requestData);
        actualizarGrid(idx, _options);
    });
}

function procesarProcedimiento(idPanel, idx, _options, parameters, bindkeys, navGrid) {
    procesarConsultaSubProceso('registrar', parameters, function(requestData) {
        $("#" + idPanel).html(requestData);
        actualizarGrid(idx, _options, bindkeys, navGrid);
    });
}

function procesarJSON(idPanel, idx, _options, bindkeys, navGrid) {
    html = "<table id=" + idx + "></table>";
    html += "<div id=p" + idx + "></div>";
    html += "<input type='hidden' id='c" + idx + "' name='c" + idx + "' value='' />";

    $("#" + idPanel).html(html);
    reloadJQGrid(idx, _options, bindkeys, navGrid);
}

function procesarProcedimientoJSON(idPanel, idx, _options, parameters, bindkeys, navGrid) {
    html = "<table id=" + idx + "></table>";
    html += "<div id=p" + idx + "></div>";
    html += "<input type='hidden' id='c" + idx + "' name='c" + idx + "' value='' />";

    $("#" + idPanel).html(html);
    procesarConsultaSubProceso('registrar', parameters, function(requestData) {
        $("#c" + idx).val(requestData.length);
        _options = $.extend(_options, {
            datatype: "local",
            data: requestData
        });
        reloadJQGrid(idx, _options, bindkeys, navGrid);
    });
}

function reloadJQGrid(id, _options, bindkeys, navGrid) {
    options = $.extend({
        // scroll: 1,
        // loadComplete: function (data){},
        height: 250,
        data: [],
        datatype: "local",
        rowNum: 10,
        rownumbers: false,
        recordtext: "{0} - {1} de {2} elementos",
        emptyrecords: 'No hay resultados',
        pgtext: 'Pag: {0} de {1}',
        pager: "#p" + id,
        viewrecords: true,
        shrinkToFit: false,
        loadonce: true,
        scrollOffset: 1,
        subGrid: false,
        footerrow: false,
        sortable: false
    }, _options);
    idx = "#" + id;
    $(idx).jqGrid(options);
    $(idx).jqGrid('setFrozenColumns');
    if (bindkeys != undefined || bindkeys != null) {
        $(idx).jqGrid('bindKeys', bindkeys);
    }
    if (navGrid != undefined || navGrid != null) {
        navGrid();
    }
}

function actualizarGrid(id, _options, bindkeys, navGrid) {
    _url = path + "jqgrid/paginar?name=" + id;
    options = $.extend({
        url: _url,
        datatype: "json"
    }, _options);
    reloadJQGrid(id, options, bindkeys, navGrid);
}

function inicializarGrid(id, _options, bindkeys, navGrid) {
    reloadJQGrid(id, _options, bindkeys, navGrid);
}

function contenidocomboContenedorjqGrid(selector, idsigma) {
    var optionsjq = {};
    optionsjq.value = "9999999999:Seleccionar";
    optionsjq.defaultValue = "9999999999";

    _post = $.post(path + "util/combocontenedor", {"idsigma": idsigma}, function(request) {
        $.each(request, function(i, columns) {
            var value = columns[0];
            var label = columns[1];
            optionsjq.value += ';' + value + ':' + label;
        });
    }, 'json');
    return optionsjq;
}

function contenidocomboContenedor(selectId, idsigma) {
    _post = $.post(path + "util/combocontenedor", {"idsigma": idsigma}, function(request) {
        $(selectId).html(contenidocombo(request));
    }, 'json');
}

function contenidocombo(data) {
    var options = '<option value="9999999999">SELECCIONAR</option>';
    $.each(data, function(i, columns) {
        var value = columns[0];
        var label = columns[1];
        options += '<option value="' + value + '">' + label + '</option>';
    });
    return options;
}

function deshabilitarComponente(id, sw) {
    id = "#" + id;

    if (sw == true || sw == 1) {
        $(id).removeAttr('disabled');
    } else if (sw == false || sw != 1) {
        $(id).attr('disabled', 'disabled');
    }
}

function print() {
    $("#divPrincipal").jqprint();
}

function closeDialog(id) {
    $('#' + id).dialog('close');
}

var openDialogData = function(url, data, width, height, title, id, fnc, buttons) {
    var _post;
    if (url != undefined) {
        _post = $.post(path + url, data);
        _post.success(function(requestData) {
            $(id).html(requestData);

            if (width != undefined || width != null)
                $(id).dialog('option', 'width', width);
            if (title != undefined || title != null)
                $(id).dialog('option', 'title', title);
            if (height != undefined || height != null)
                $(id).dialog('option', 'height', height);
            if (buttons != undefined || buttons != null){
                $(id).dialog('option', 'buttons', buttons);
            }else{
                $(id).dialog('option', 'buttons', null);
            }
            $(id).dialog('option', 'close', function(){
            	$(id).html('');
            });

            $(id).dialog('open');

            if (fnc != undefined && fnc != null && fnc != false) {
                fnc();
            }
        });
    }
};

function openDialogDataFunction1(url, data, width, height, title, fnc, buttons) {
    openDialogData(url, data, width, height, title, '#jqDialog1', fnc, buttons);
}

function openDialogDataFunction2(url, data, width, height, title, fnc, buttons) {
    openDialogData(url, data, width, height, title, '#jqDialog2', fnc, buttons);
}

function openDialogDataFunction3(url, data, width, height, title, fnc, buttons) {
    openDialogData(url, data, width, height, title, '#jqDialog3', fnc, buttons);
}

function openDialogDataFunction4(url, data, width, height, title, fnc, buttons) {
    openDialogData(url, data, width, height, title, '#jqDialog4', fnc, buttons);
}

function openDialogData1(url, data, width, height, title) {
    openDialogData(url, data, width, height, title, '#jqDialog1', null, null);
}

function openDialogData2(url, data, width, height, title) {
    openDialogData(url, data, width, height, title, '#jqDialog2', null, null);
}

function openDialog1(url, width, height, title) {
    openDialogData(url, {}, width, height, title, '#jqDialog1', null, null);
}

function openDialog2(url, width, height, title) {
    openDialogData(url, {}, width, height, title, '#jqDialog2', null, null);
}

function openDialogConfirm1(contenido, width, buttons) {
    $('#jqConfirmacion1').html(contenido);
    if (width != undefined)
        $('#jqDialogConfirmacion1').dialog('option', 'width', width);
    if (buttons != undefined)
        $('#jqDialogConfirmacion1').dialog('option', 'buttons', buttons);
    $('#jqDialogConfirmacion1').dialog('open');
}

function openDialogConfirm2(contenido, width, buttons) {
    $('#jqConfirmacion2').html(contenido);
    if (width != undefined)
        $('#jqDialogConfirmacion2').dialog('option', 'width', width);
    if (buttons != undefined)
        $('#jqDialogConfirmacion2').dialog('option', 'buttons', buttons);
    $('#jqDialogConfirmacion2').dialog('open');
}

function openDialogError(contenido, width, height,close) {
    $('#jqError').html(contenido);
    if (width != undefined)
        $('#jqDialogError').dialog('option', 'width', width);
    if (close != undefined)
        $('#jqDialogError').dialog('option', 'close', close);
    $('#jqDialogError').dialog('open');
}

function openDialogWarning(contenido, width,close) {
    $('#jqWarning').html(contenido);
    if (width != undefined)
        $('#jqDialogWarning').dialog('option', 'width', width);
    $('#jqDialogWarning').dialog('open');
    if (close != undefined)
        $('#jqDialogWarning').dialog('option', 'close', close);
}

function openDialogInfo(contenido, width, height, buttons, close) {
    $('#jqInfo').html(contenido);
    if (width != undefined)
        $('#jqDialogInfo').dialog('option', 'width', width);
    if (buttons != undefined)
        $('#jqDialogInfo').dialog('option', 'buttons', buttons);
    if (close != undefined)
        $('#jqDialogInfo').dialog('option', 'close', close);
    $('#jqDialogInfo').dialog('open');
}

function mouseHover(idTable) {
    idTable = '#' + idTable + " tbody";

    $(idTable).delegate('tr', 'hover', function() {
        $(this).toggleClass("ui-state-highlight").next().stop(true, true);
    });
}

function DoNavrow(theUrl) {
    window.open(theUrl, '_self');
}

function themeTextBox(selector) {
    if (selector == undefined || selector == null) {
        selector = ".ui-text";
    }
    $(selector).on("blur", function() {
        if ($(this).hasClass("ui-text-highlight")) {
            $(this).removeClass("ui-text-highlight");
        }
    });
    $(selector).on("focus", function() {
        if (!$(this).hasClass("ui-text-highlight")) {
            $(this).addClass("ui-text-highlight");
        }
    });
}

function themeComboBox(selector) {
    if (selector == undefined || selector == null) {
        selector = 'select:not(".notcombobox")';
    }

    _selector = $(selector);
    _selector.combobox();
    _selector.each(function() {
        var id = $(this).attr("id").replace('cbo', '#txt');
        $(id).bind("focus", function() {
            if (!$(this).hasClass("ui-combobox-input-highlight")) {
                $(this).addClass("ui-combobox-input-highlight");
            }
        });
        $(id).bind("blur", function() {
            if ($(this).hasClass("ui-combobox-input-highlight")) {
                $(this).removeClass("ui-combobox-input-highlight");
            }
        });
    });
}

_FsFiltrarCombo = function(_datos, _datbus, _indexbus, _indexcod, _indexdes, _excep) {
    _options = '';
    _datbus = _datbus.toUpperCase();
    _cadena = '';
    for (var i = 0; i < _datos.length; i++) {
        _cadena = _datos[i][_indexbus];
        if (_datbus.indexOf(_cadena) != -1 && _datos[i][_indexcod] != _excep) {
            descrip = _datos[i][_indexdes];
            ncodcon = _datos[i][_indexcod];
            _options += '<option value="' + ncodcon + '"> ' + descrip + '</option>';
        }
    }
    return _options;
};

(function($) {
    $.fn.getCheckboxValues = function() {
        var values = [];
        var i = 0;
        this.each(function() {
            values[i++] = $(this).val();
        });
        return values;
    };
})(jQuery);


Number.prototype.decimal = function(num) {
    pot = Math.pow(10, num);
    return parseInt(this * pot) / pot;
};

function NumberFormat(num, numDec, decSep, thousandSep) {
    var arg;
    var Dec;
    Dec = Math.pow(10, numDec);
    if (typeof(num) == 'undefined')
        return;
    if (typeof(decSep) == 'undefined')
        decSep = ',';
    if (typeof(thousandSep) == 'undefined')
        thousandSep = '.';
    if (thousandSep == '.')
        arg = /./g;
    else
    if (thousandSep == ',')
        arg = /,/g;
    if (typeof(arg) != 'undefined')
        num = num.toString().replace(arg, '');
    num = num.toString().replace(/,/g, '.');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * Dec + 0.50000000001);
    cents = num % Dec;
    num = Math.floor(num / Dec).toString();
    if (cents < (Dec / 10))
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + thousandSep + num.substring(num.length - (4 * i + 3));
    if (Dec == 1)
        return (((sign) ? '' : '-') + num);
    else
        return (((sign) ? '' : '-') + num + decSep + cents);
}

function openventcambiarpsswd() {
    openDialogData1("logeo/cambiarpasswd", "", "260", "180", "Cambiar Contrase\u00f1a");
}

$(function() {
    $("#itemMenu1").menuBar({
        content: $("#itemMenu1").next().html(),
        showSpeed: 1,
        flyOut: true
    });

    $("#itemMenu2").menuBar({
        content: $("#itemMenu2").next().html(),
        showSpeed: 1,
        flyOut: true
    });

    $("#itemMenu3").menuBar({
        content: $("#itemMenu3").next().html(),
        showSpeed: 1,
        flyOut: true
    });

    $("#itemMenu4").menuBar({
        content: $("#itemMenu4").next().html(),
        showSpeed: 1,
        flyOut: true
    });
    $("#itemMenu5").menuBar({
        content: $("#itemMenu5").next().html(),
        showSpeed: 1,
        flyOut: true
    });
    $("#itemMenu6").menuBar({
        content: $("#itemMenu6").next().html(),
        showSpeed: 1,
        flyOut: true
    });
    themeTextBox();
    themeComboBox();

    /*
     var brw = new Browser();
     console.log('fullName: ' + brw.fullName);
     console.log('name: ' + brw.name);
     console.log('fullVersion: ' + brw.fullVersion);
     console.log('version: ' + brw.version);
     console.log('platform: ' + brw.platform);
     console.log('mobile: ' + brw.mobile);
     console.log('resolution: ' + brw.width + 'x' + brw.height);
     console.log('availWidth: ' + screen.availWidth);
     console.log('width: ' + screen.width);
     console.log('availHeight: ' + screen.availHeight);
     console.log('height: ' + screen.height);
     */
    //window.moveTo(screen.width - screen.availWidth, screen.height - screen.availHeight);
    //window.resizeTo(screen.availWidth + screen.availWidth - screen.width, screen.availHeight + screen.availHeight - screen.height);

    // console.log("#west.height: " + $("#west").css("height"));
});

function getInternetExplorerVersion()
//Returns the version of Windows Internet Explorer or a -1
//(indicating the use of another browser).
{
var rv = -1; // Return value assumes failure.
if (navigator.appName == 'Microsoft Internet Explorer')
{
   var ua = navigator.userAgent;
   var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
   if (re.exec(ua) != null)
      rv = parseFloat( RegExp.$1 );
}
return rv;
}

function checkIEVersion()
{
var msg = "You're not using Windows Internet Explorer.";
var ver = getInternetExplorerVersion();
if ( ver> -1 )
{
   if ( ver>= 8.0 )
      msg = "You're using Windows Internet Explorer 8.";
   else if ( ver == 7.0 )
 	  msg = "You're using Windows Internet Explorer 7.";
   else if ( ver == 6.0 )
 	  msg = "You're using Windows Internet Explorer 6.";
   else
 	  msg = "You should upgrade your copy of Windows Internet Explorer";
 }
alert( msg );
}
