BuscadorContribuyentePredio = {
    // Constantes Publicas
    MODO_PERSONA: 1,
    MODO_PREDIO: 2,
    MODO_FULL: 3,
    PROCEDIMIENTO_BUSCAR_PERSONA: "public.buscar_persona",
    PROCEDIMIENTO_BUSCAR_PREDIO_ASIGNADO: "pl_function.buscar_predio_asignado",
    PROCEDIMIENTO_BUSCAR_PREDIO_SIN_ASIGNAR: "pl_function.buscar_predio_sin_asignar",
    PROCEDIMIENTO_BUSCAR_PREDIO: "pl_function.buscar_predio",
    
    // Propiedades Publicas
    procedimientoBuscarPersona: "",
    procedimientoBuscarPredio: "",
    gridConfigPersona: __gridConfigContribuyente,
    gridConfigPredio: __gridConfigViaPredio,
    titleDialog: "Buscador de Contribuyentes y Predios",
    
    // Metodos
    buscar: function() {
        var valid = [false, false];

        if (trim($("#c_codigocontrib").val()).length > 0) {
            $("#c_codigocontrib").val(LPad($("#c_codigocontrib").val(), 10, '0'));
        }

        valid[0] = valid[0] || (trim($("#c_nombrecontrib").val()).length > 0);
        valid[0] = valid[0] || (trim($("#c_apepatcontrib").val()).length > 0);
        valid[0] = valid[0] || (trim($("#c_codigocontrib").val()).length > 0);

        if (trim($("#c_predial").val()).length > 0) {
            $("#c_predial").val(LPad($("#c_predial").val(), 10, '0'));
        }

        valid[1] = valid[1] || (trim($("#c_nroviacontrib").val()).length > 0);
        valid[1] = valid[1] || (trim($("#c_mzacontrib").val()).length > 0);
        valid[1] = valid[1] || (trim($("#c_lotecontrib").val()).length > 0);
        valid[1] = valid[1] || (trim($("#c_viacontrib").val()).length > 0);
        valid[1] = valid[1] || (trim($("#c_predial").val()).length > 0);

        if (valid[0]) {
            BuscadorContribuyentePredio.buscarAjax(BuscadorContribuyentePredio.MODO_PERSONA);
        } else if (valid[1]) {
            BuscadorContribuyentePredio.buscarAjax(BuscadorContribuyentePredio.MODO_PREDIO);
        } else {
            openDialogWarning("Ingrese un valor en los campos de busqueda.", 380, 150);
        }
    },
    
    init: function (modo, modoAjax) {
        $("#dialogMensaje").dialog({
            title: "Titania",
            modal: true,
            minHeight: 'auto',
            width: 340,
            position: ['center', 'center'],
            resizable: false,
            autoOpen: false,
            closeOnEscape: true
        });

        $("#c_codigocontrib").numeric({
            decimal: false,
            negative: false
        }, function() {
            openDialogWarning("Solo Numeros Enteros Positivos.", 150, 90);
            this.value = "";
            this.focus();
        });

        inicializarGrid("tblResult", (modo == this.MODO_PERSONA || modo == this.MODO_FULL ? this.gridConfigPersona : this.gridConfigPredio));

        $("#panelBuscarContribuyente").on("keyup", "input", function(e) {
            if (e.keyCode == 13) {
                $("#btnbuscar").click();
            }
        });

        $("#panelBuscarPredio").on("keyup", "input", function(e) {
            var name = $(this).attr("id");
            if (e.keyCode == 13 && name != 'c_viacontrib') {
                $("#btnbuscar").click();
            }
        });

        $("#c_codigocontrib, #c_predial").on("focus", function() {
            $("#panelBuscarContribuyente input.ui-text").val("");
            $("#panelBuscarPredio input.ui-text").val("");
        });

        $(".pnl").on("focus", function() {
            var name = $(this).attr("id");
            if (name == 'c_apepatcontrib' || name == 'c_nombrecontrib' || name == 'c_viacontrib' || name == 'c_nroviacontrib' || name == 'c_mzacontrib' || name == 'c_lotecontrib') {
                $("#panelBuscarContribuyente input.ui-text").val("");
                $("#c_predial").val("");
            } else {
                $("#panelBuscarPredio input.ui-text").val("");
                $("#c_codigocontrib").val("");
            }
        });

        $("#btnbuscar").button({ icons: {primary: 'ui-icon-search'} }).click(this.buscar);

        if(modoAjax == true) {
            $("#btnBuscarNuevoPredio, #btnBuscarNuevoContribuyente, #btnBuscarAceptar").button();
        }

        $("#btnBuscarNuevoPredio").click(function(){
            verPredioEdit();
            $("#dialogMensaje").dialog("close");
        });
        $("#btnBuscarNuevoContribuyente").click(function(){
            $("#dialogMensaje").dialog("close");
            Persona.agregar();
        });
        $("#btnBuscarAceptar").click(function(){
            $("#dialogMensaje").dialog("close");
        });

        this.procedimientoBuscarPersona = this.PROCEDIMIENTO_BUSCAR_PERSONA;
        this.procedimientoBuscarPredio = this.PROCEDIMIENTO_BUSCAR_PREDIO;
        if (modo == this.MODO_PERSONA) {
            this.titleDialog = "Buscador de Contribuyentes";
            if ($(".rowBuscarContribuyente").hasClass("row-hide")) {
                $(".rowBuscarContribuyente").removeClass("row-hide");
            }
            if (!$(".rowBuscarPredio").hasClass("row-hide")) {
                $(".rowBuscarPredio").addClass("row-hide");
            }
        } else if (modo == this.MODO_PREDIO) {
            this.titleDialog = "Buscador de Predio";
            if (!$(".rowBuscarContribuyente").hasClass("row-hide")) {
                $(".rowBuscarContribuyente").addClass("row-hide");
            }
            if ($(".rowBuscarPredio").hasClass("row-hide")) {
                $(".rowBuscarPredio").removeClass("row-hide");
            }
        } else if (modo == this.MODO_FULL) {
            this.titleDialog = "Buscador de Contribuyentes y Predios";
            if ($(".rowBuscarContribuyente").hasClass("row-hide")) {
                $(".rowBuscarContribuyente").removeClass("row-hide");
            }
            if ($(".rowBuscarPredio").hasClass("row-hide")) {
                $(".rowBuscarPredio").removeClass("row-hide");
            }
        }
    },
    bindkeysPersona: {"onEnter": function() {}},
    bindkeysPredio: {"onEnter": function() {}},
    configurarDialog: function() {
        $("#dialogBuscarContribuyentePredio").dialog({
            title: this.titleDialog,
            modal: true,
            minHeight: 'auto',
            width: 1030,
            position: ['center', 'center'],
            resizable: false,
            autoOpen: false,
            closeOnEscape: true
        });
    },
    configBeforeGrid: function(request) {
    },
    obtenerParameterPredio: function() {
        return '{' +
                '"p_ccodpre":"' + $("#c_predial").val().toUpperCase() + '",' +
                '"p_ccodvia":"' + ccodvia.toUpperCase() + '",' +
                '"p_cnrovia":"' + $("#c_nroviacontrib").val().toUpperCase() + '",' +
                '"p_cmanzan":"' + $("#c_mzacontrib").val().toUpperCase() + '",' +
                '"p_cnrlote":"' + $("#c_lotecontrib").val().toUpperCase() + '"' +
                '}';
    },
    obtenerParameterContribuyente: function() {
        return '{' +
                '"p_nvar1":"' + $("#c_codigocontrib").val().toUpperCase() + '",' +
                '"p_nvar2":"' + $("#c_nombrecontrib").val().toUpperCase() + '",' +
                '"p_nvar3":"",' +
                '"p_nvar4":"",' +
                '"p_nvar5":"' + $("#c_apepatcontrib").val().toUpperCase() + '"' +
                '}';
    },
    buscarAjax: function(modo) {
        var
        parameters = {
            "name": "tblResult",
            "procedure": (modo == this.MODO_PERSONA ? this.procedimientoBuscarPersona : this.procedimientoBuscarPredio),
            "print": "true",
            "parameters": (modo == this.MODO_PERSONA ? this.obtenerParameterContribuyente() : this.obtenerParameterPredio())
        },
        proceso = function(request) {
            $("#panelResult").html('<table id="tblResult"></table><div id="ptblResult"></div><input type="hidden" id="ctblResult" name="ctblResult" value="" />');
            var 
                records = request.length,
                bindkeys = (modo == BuscadorContribuyentePredio.MODO_PERSONA ? BuscadorContribuyentePredio.bindkeysPersona : BuscadorContribuyentePredio.bindkeysPredio),
                gridConfig = $.extend((modo == BuscadorContribuyentePredio.MODO_PERSONA ? BuscadorContribuyentePredio.gridConfigPersona : BuscadorContribuyentePredio.gridConfigPredio), {
                    data: request,
                    datatype: "local"
                });
            inicializarGrid("tblResult", gridConfig, bindkeys);
            if (records == 0) {
                if (modo == BuscadorContribuyentePredio.MODO_PERSONA) {
                    if (!$("#btnBuscarNuevoPredio").hasClass("row-hide")) {
                        $("#btnBuscarNuevoPredio").addClass("row-hide");
                    }
                    if ($("#btnBuscarNuevoContribuyente").hasClass("row-hide")) {
                        $("#btnBuscarNuevoContribuyente").removeClass("row-hide");
                    }
                } else {
                    if ($("#btnBuscarNuevoPredio").hasClass("row-hide")) {
                        $("#btnBuscarNuevoPredio").removeClass("row-hide");
                    }
                    if (!$("#btnBuscarNuevoContribuyente").hasClass("row-hide")) {
                        $("#btnBuscarNuevoContribuyente").addClass("row-hide");
                    }
                }
                $("#dialogMensaje").dialog("open");
            }
            BuscadorContribuyentePredio.configBeforeGrid(request);
        };
        procesarConsultaSubProceso('registrar', parameters, proceso, 'json');
    }
},
        
BuscadorContribuyente = {
    // Constantes Publicas
    MODO_PERSONA: 1,
    PROCEDIMIENTO_BUSCAR_PERSONA: "public.buscar_persona",
    
    // Propiedades Publicas
    procedimientoBuscarPersona: "",
    gridConfigPersona: __gridConfigContribuyente,
    titleDialog: "Buscador de Contribuyentes",
    
    // Metodos
    buscar: function() {
        var valid = [false, false];

        if (trim($("#c_codigocontribPersona").val()).length > 0) {
            $("#c_codigocontribPersona").val(LPad($("#c_codigocontribPersona").val(), 10, '0'));
        }

        valid[0] = valid[0] || (trim($("#c_nombrecontribPersona").val()).length > 0);
        valid[0] = valid[0] || (trim($("#c_apepatcontribPersona").val()).length > 0);
        valid[0] = valid[0] || (trim($("#c_codigocontribPersona").val()).length > 0);

        if (valid[0]) {
            BuscadorContribuyente.buscarAjax(BuscadorContribuyente.MODO_PERSONA);
        } else {
            openDialogWarning("Ingrese un valor en los campos de busqueda.", 380, 150);
        }
    },
    
    init: function (modoAjax) {
        $("#dialogMensajePersona").dialog({
            title: "Titania",
            modal: true,
            minHeight: 'auto',
            width: 340,
            position: ['center', 'center'],
            resizable: false,
            autoOpen: false,
            closeOnEscape: true
        });

        $("#c_codigocontribPersona").numeric({
            decimal: false,
            negative: false
        }, function() {
            openDialogWarning("Solo Numeros Enteros Positivos.", 150, 90);
            this.value = "";
            this.focus();
        });

        inicializarGrid("tblResultPersona", this.gridConfigPersona);

        $("#panelBuscarContribuyentePersona").on("keyup", "input", function(e) {
            if (e.keyCode == 13) {
                $("#btnbuscarPersona").click();
            }
        });

        $("#c_codigocontribPersona, #c_predialPersona").on("focus", function() {
            $("#panelBuscarContribuyentePersona input.ui-text").val("");
        });

        $(".pnlPersona").on("focus", function() {
            var name = $(this).attr("id");
            if (name == 'c_apepatcontribPersona' || name == 'c_nombrecontribPersona') {
                $("#panelBuscarContribuyentePersona input.ui-text").val("");
            } else {
                $("#c_codigocontribPersona").val("");
            }
        });

        $("#btnbuscarPersona").button({ icons: {primary: 'ui-icon-search'} }).click(this.buscar);

        if(modoAjax == true) {
            $("#btnBuscarNuevoPredioPersona, #btnBuscarNuevoContribuyentePersona, #btnBuscarAceptarPersona").button();
        }

        $("#btnBuscarNuevoContribuyentePersona").click(function(){
            $("#dialogMensajePersona").dialog("close");
            Persona.agregar();
        });
        $("#btnBuscarAceptarPersona").click(function(){
            $("#dialogMensajePersona").dialog("close");
        });

        this.procedimientoBuscarPersona = this.PROCEDIMIENTO_BUSCAR_PERSONA;
        this.titleDialog = "Buscador de Contribuyentes";
        if ($(".rowBuscarContribuyentePersona").hasClass("row-hide")) {
            $(".rowBuscarContribuyentePersona").removeClass("row-hide");
        }
        if (!$(".rowBuscarPredioPersona").hasClass("row-hide")) {
            $(".rowBuscarPredioPersona").addClass("row-hide");
        }
    },
    bindkeysPersona: {"onEnter": function() {}},
    configurarDialog: function() {
        $("#dialogBuscarContribuyentePredioPersona").dialog({
            title: this.titleDialog,
            modal: true,
            minHeight: 'auto',
            width: 1030,
            position: ['center', 'center'],
            resizable: false,
            autoOpen: false,
            closeOnEscape: true
        });
    },
    configBeforeGrid: function(request) {
    },
    obtenerParameterContribuyente: function() {
        return '{' +
                '"p_nvar1":"' + $("#c_codigocontribPersona").val().toUpperCase() + '",' +
                '"p_nvar2":"' + $("#c_nombrecontribPersona").val().toUpperCase() + '",' +
                '"p_nvar3":"",' +
                '"p_nvar4":"",' +
                '"p_nvar5":"' + $("#c_apepatcontribPersona").val().toUpperCase() + '"' +
                '}';
    },
    buscarAjax: function(modo) {
        var
        parameters = {
            "name": "tblResultPersona",
            "procedure": this.procedimientoBuscarPersona,
            "print": "true",
            "parameters": this.obtenerParameterContribuyente()
        },
        proceso = function(request) {
            $("#panelResultPersona").html('<table id="tblResultPersona"></table><div id="ptblResultPersona"></div><input type="hidden" id="ctblResultPersona" name="ctblResultPersona" value="" />');
            var 
                records = request.length,
                bindkeys = BuscadorContribuyente.bindkeysPersona,
                gridConfig = $.extend(BuscadorContribuyente.gridConfigPersona, {
                    data: request,
                    datatype: "local"
                });
            inicializarGrid("tblResultPersona", gridConfig, bindkeys);
            if (records == 0) {
                if (modo == BuscadorContribuyente.MODO_PERSONA) {
                    if ($("#btnBuscarNuevoContribuyentePersona").hasClass("row-hide")) {
                        $("#btnBuscarNuevoContribuyentePersona").removeClass("row-hide");
                    }
                }
                $("#dialogMensajePersona").dialog("open");
            }
            BuscadorContribuyente.configBeforeGrid(request);
        };
        procesarConsultaSubProceso('registrar', parameters, proceso, 'json');
    }
},
        
BuscadorPredio = {
    // Constantes Publicas
    MODO_PREDIO: 2,
    PROCEDIMIENTO_BUSCAR_PREDIO_ASIGNADO: "pl_function.buscar_predio_asignado",
    PROCEDIMIENTO_BUSCAR_PREDIO_SIN_ASIGNAR: "pl_function.buscar_predio_sin_asignar",
    PROCEDIMIENTO_BUSCAR_PREDIO: "pl_function.buscar_predio",
    
    // Propiedades Publicas
    procedimientoBuscarPredio: "",
    gridConfigPredio: __gridConfigViaPredio,
    titleDialog: "Buscador de Predios",
    
    // Metodos
    navPanelPredio: function() {
    },
    
    guardarPredio: function(request) {
    	var optionViaPredio = $.extend(BuscadorPredio.gridConfigPredio, {data: request.data});
    	procesarJSON("panelResultPredio", "tblResultPredio", optionViaPredio, null, BuscadorPredio.navPanelPredio);
    	openDialogWarning("Los datos han sido guardados.", 380, 150);
    	closeDialog('jqDialog1');
    },
    
    buscar: function() {
        var valid = [false, false];

        if (trim($("#c_predialPredio").val()).length > 0) {
            $("#c_predialPredio").val(LPad($("#c_predialPredio").val(), 10, '0'));
        }

        valid[1] = valid[1] || (trim($("#c_nroviacontribPredio").val()).length > 0);
        valid[1] = valid[1] || (trim($("#c_mzacontribPredio").val()).length > 0);
        valid[1] = valid[1] || (trim($("#c_lotecontribPredio").val()).length > 0);
        valid[1] = valid[1] || (trim($("#c_viacontribPredio").val()).length > 0);
        valid[1] = valid[1] || (trim($("#c_predialPredio").val()).length > 0);
        
        if (valid[1]) {
            BuscadorPredio.buscarAjax(BuscadorPredio.MODO_PREDIO);
        } else {
            openDialogWarning("Ingrese un valor en los campos de busqueda.", 380, 150);
        }
    },
    
    init: function (modoAjax) {
        $("#dialogMensajePredio").dialog({
            title: "Titania",
            modal: true,
            minHeight: 'auto',
            width: 340,
            position: ['center', 'center'],
            resizable: false,
            autoOpen: false,
            closeOnEscape: true
        });

        inicializarGrid("tblResultPredio", this.gridConfigPredio);

        $("#panelBuscarPredioPredio").on("keyup", "input", function(e) {
            var name = $(this).attr("id");
            if (e.keyCode == 13 && name != 'c_viacontribPredio') {
                $("#btnbuscarPredio").click();
            }
        });

        $("#c_predialPredio").on("focus", function() {
            $("#panelBuscarPredio input.ui-text").val("");
        });

        $(".pnlPredio").on("focus", function() {
            var name = $(this).attr("id");
            if (name == 'c_viacontribPredio' || name == 'c_nroviacontribPredio' || name == 'c_mzacontribPredio' || name == 'c_lotecontribPredio') {
                $("#c_predialPredio").val("");
            } else {
                $("#panelBuscarPredioPredio input.ui-text").val("");
            }
        });

        $("#btnbuscarPredio").button({ icons: {primary: 'ui-icon-search'} }).click(this.buscar);

        if(modoAjax == true) {
            $("#btnBuscarNuevoPredioPredio, #btnBuscarNuevoContribuyentePredio, #btnBuscarAceptarPredio").button();
        }

        $("#btnBuscarNuevoPredioPredio").click(function(){
            verPredioEdit();
            $("#dialogMensajePredio").dialog("close");
        });
        $("#btnBuscarAceptarPredio").click(function(){
            $("#dialogMensajePredio").dialog("close");
        });

        this.procedimientoBuscarPredio = this.PROCEDIMIENTO_BUSCAR_PREDIO;
        this.titleDialog = "Buscador de Predio";
        if (!$(".rowBuscarContribuyentePredio").hasClass("row-hide")) {
            $(".rowBuscarContribuyentePredio").addClass("row-hide");
        }
        if ($(".rowBuscarPredioPredio").hasClass("row-hide")) {
            $(".rowBuscarPredioPredio").removeClass("row-hide");
        }
    },
    bindkeysPredio: {"onEnter": function() {}},
    configurarDialog: function() {
        $("#dialogBuscarContribuyentePredioPredio").dialog({
            title: this.titleDialog,
            modal: true,
            minHeight: 'auto',
            width: 1030,
            position: ['center', 'center'],
            resizable: false,
            autoOpen: false,
            closeOnEscape: true
        });
    },
    configBeforeGrid: function(request) {
    },
    obtenerParameterPredio: function() {
        return '{' +
                '"p_ccodpre":"' + $("#c_predialPredio").val().toUpperCase() + '",' +
                '"p_ccodvia":"' + ccodvia.toUpperCase() + '",' +
                '"p_cnrovia":"' + $("#c_nroviacontribPredio").val().toUpperCase() + '",' +
                '"p_cmanzan":"' + $("#c_mzacontribPredio").val().toUpperCase() + '",' +
                '"p_cnrlote":"' + $("#c_lotecontribPredio").val().toUpperCase() + '"' +
                '}';
    },
    buscarAjax: function(modo) {
        var
        parameters = {
            "name": "tblResult",
            "procedure": this.procedimientoBuscarPredio,
            "print": "true",
            "parameters": this.obtenerParameterPredio()
        },
        proceso = function(request) {
            $("#panelResultPredio").html('<table id="tblResultPredio"></table><div id="ptblResultPredio"></div><input type="hidden" id="ctblResultPredio" name="ctblResultPredio" value="" />');
            var 
                records = (request == null ? 0 : request.length),
                bindkeys = BuscadorPredio.bindkeysPredio,
                gridConfig = $.extend(BuscadorPredio.gridConfigPredio, {
                    data: request,
                    datatype: "local"
                });
            inicializarGrid("tblResultPredio", gridConfig, bindkeys);
            if (records == 0) {
                if ($("#btnBuscarNuevoPredioPredio").hasClass("row-hide")) {
                    $("#btnBuscarNuevoPredioPredio").removeClass("row-hide");
                }
                if (!$("#btnBuscarNuevoContribuyentePredio").hasClass("row-hide")) {
                    $("#btnBuscarNuevoContribuyentePredio").addClass("row-hide");
                }
                $("#dialogMensajePredio").dialog("open");
            }
            BuscadorPredio.configBeforeGrid(request);
        };
        procesarConsultaSubProceso('registrar', parameters, proceso, 'json');
    }
}
    BuscadorMaterial = {
    // Constantes Publicas
    MODO_CERO: 0,
    MODO_FULL: 1,
    PROCEDIMIENTO_BUSCAR_PERSONA: "almacen.Bus_Material",

    // Propiedades Publicas
    procedimientoBuscarPersona: "",
    gridConfigPersona: __gridConfigMaterial,
    titleDialog: "Buscador de Materiales",

    // Metodos
    buscar: function() {
        var valid = [false, false];

        valid[0] = valid[0] || (trim($("#cbotipob").val()).length > 0);
        valid[0] = valid[0] || (trim($("#c_textbusqueda").val()).length > 0);

        if (valid[0]) {
            BuscadorMaterial.buscarAjax(BuscadorMaterial.MODO_CERO);
        }  else {
            openDialogWarning("Ingrese un valor en los campos de busqueda.", 380, 150);
        }
    },

    init: function (modo, modoAjax) {
        $("#dialogMensaje").dialog({
            title: "Almacen",
            modal: true,
            minHeight: 'auto',
            width: 340,
            position: ['center', 'center'],
            resizable: false,
            autoOpen: false,
            closeOnEscape: true
        });

        $("#c_codigocontrib").numeric({
            decimal: false,
            negative: false
        }, function() {
            openDialogWarning("Solo Numeros Enteros Positivos.", 150, 90);
            this.value = "";
            this.focus();
        });

        inicializarGrid("tblResult", ( this.gridConfigPersona));

        $("#panelBuscarContribuyente").on("keyup", "input", function(e) {
            if (e.keyCode == 13) {
                $("#btnbuscar").click();
            }
        });

        $("#c_codigocontrib, #c_predial").on("focus", function() {
            $("#panelBuscarContribuyente input.ui-text").val("");
            $("#panelBuscarPredio input.ui-text").val("");
        });

        $(".pnl").on("focus", function() {
            var name = $(this).attr("id");
            if (name == 'c_apepatcontrib' || name == 'c_nombrecontrib' || name == 'c_viacontrib' || name == 'c_nroviacontrib' || name == 'c_mzacontrib' || name == 'c_lotecontrib') {
                $("#panelBuscarContribuyente input.ui-text").val("");
                $("#c_predial").val("");
            } else {
                $("#panelBuscarPredio input.ui-text").val("");
                $("#c_codigocontrib").val("");
            }
        });

        $("#btnbuscar").button({ icons: {primary: 'ui-icon-search'} }).click(this.buscar);

        if(modoAjax == true) {
            $("#btnBuscarNuevoPredio, #btnBuscarNuevoContribuyente, #btnBuscarAceptar").button();
        }

        $("#btnBuscarAceptar").click(function(){
            $("#dialogMensaje").dialog("close");
        });

        this.procedimientoBuscarPersona = this.PROCEDIMIENTO_BUSCAR_PERSONA;
      if (modo == this.MODO_FULL) {
            this.titleDialog = "Buscador de Materiales";
            if ($(".rowBuscarContribuyente").hasClass("row-hide")) {
                $(".rowBuscarContribuyente").removeClass("row-hide");
            }
            if ($(".rowBuscarPredio").hasClass("row-hide")) {
                $(".rowBuscarPredio").removeClass("row-hide");
            }
        }
    },
    bindkeysPersona: {"onEnter": function() {}},
    configurarDialog: function() {
        $("#dialogBuscarContribuyentePredio").dialog({
            title: this.titleDialog,
            modal: true,
            minHeight: 'auto',
            width: 1030,
            position: ['center', 'center'],
            resizable: false,
            autoOpen: false,
            closeOnEscape: true
        });
    },
    configBeforeGrid: function(request) {
    },
    obtenerParameterContribuyente: function() {
        return '[' +
            '["@tBusqueda", "' + $("#cbotipob").val() + '"],' +
            '["@vDatoBus", "' + $("#c_textbusqueda").val() + '"]' +
            ']';

    },
    buscarAjax: function(modo) {
        var
            parameters = {
                "name": "tblResult",
                "procedure": (this.procedimientoBuscarPersona ),
                "print": "true",
                "parameters": ( this.obtenerParameterContribuyente())
            },
            proceso = function(request) {
                $("#panelResult").html('<table id="tblResult"></table><div id="ptblResult"></div><input type="hidden" id="ctblResult" name="ctblResult" value="" />');
                var
                    records = request.length,
                    bindkeys = ( BuscadorMaterial.bindkeysPersona ),
                    gridConfig = $.extend(( BuscadorMaterial.gridConfigPersona ), {
                        data: request,
                        datatype: "local"
                    });
                inicializarGrid("tblResult", gridConfig, bindkeys);
                if (records == 0) {
                    if (modo == BuscadorMaterial.MODO_CERO) {
                        if (!$("#btnBuscarNuevoPredio").hasClass("row-hide")) {
                            $("#btnBuscarNuevoPredio").addClass("row-hide");
                        }
                        if ($("#btnBuscarNuevoContribuyente").hasClass("row-hide")) {
                            $("#btnBuscarNuevoContribuyente").removeClass("row-hide");
                        }
                    }
                    $("#dialogMensaje").dialog("open");
                }
                BuscadorMaterial.configBeforeGrid(request);
            };
        procesarConsultaSubProceso('registrar', parameters, proceso, 'json');
    }
};

BuscadorSeries = {
    // Constantes Publicas
    MODO_CERO: 0,
    MODO_FULL: 1,
    PROCEDIMIENTO_BUSCAR_PERSONA: "almacen.Bus_ProdSeries",

    // Propiedades Publicas
    procedimientoBuscarPersona: "",
    gridConfigPersona: __gridConfigSeries,
    titleDialog: "Buscador de Series",

    // Metodos
    buscar: function() {
        var valid = [false, false];

      if(trim($("#cbotipob").val())==1 && IsNumeric($("#c_textbusqueda").val())==false){  //Validar si es por id el campo de busqueda tiene que ser un numero entero.
          openDialogWarning("Ingrese un Numero.", 380, 150);
          return;
      }



        valid[0] = valid[0] || (trim($("#cbotipob").val()).length > 0);
        valid[0] = valid[0] || (trim($("#c_textbusqueda").val()).length > 0);
        console.log($("#cbotipob").val());
        if (valid[0]) {
            if(trim($("#cbotipob").val())==5){
                BuscadorSeries.buscarAjax(BuscadorSeries.MODO_CERO);
            }else{
                BuscadorSeries.buscarAjax(BuscadorSeries.MODO_FULL);
            }

        }  else {
            openDialogWarning("Ingrese un valor en los campos de busqueda.", 380, 150);
        }
    },

    init: function (modo, modoAjax) {
        $("#dialogMensaje").dialog({
            title: "Almacen",
            modal: true,
            minHeight: 'auto',
            width: 340,
            position: ['center', 'center'],
            resizable: false,
            autoOpen: false,
            closeOnEscape: true
        });

        $("#c_codigocontrib").numeric({
            decimal: false,
            negative: false
        }, function() {
            openDialogWarning("Solo Numeros Enteros Positivos.", 150, 90);
            this.value = "";
            this.focus();
        });

        inicializarGrid("tblResult", ( this.gridConfigPersona));

        $("#rowBuscarContribuyente").on("keyup", "input", function(e) {
            if (e.keyCode == 13) {
                $("#btnbuscar").click();
            }
        });

        $("#c_codigocontrib, #c_predial").on("focus", function() {
            $("#dialogBuscarSeries input.ui-text").val("");
        });

        $(".pnl").on("focus", function() {
            var name = $(this).attr("id");
            if (name == 'c_apepatcontrib' || name == 'c_nombrecontrib' || name == 'c_viacontrib' || name == 'c_nroviacontrib' || name == 'c_mzacontrib' || name == 'c_lotecontrib') {
                $("#dialogBuscarSeries input.ui-text").val("");
                $("#c_predial").val("");
            }
        });

        $("#btnbuscar").button({ icons: {primary: 'ui-icon-search'} }).click(this.buscar);

        if(modoAjax == true) {
            $("#btnBuscarNuevoPredio, #btnBuscarNuevoContribuyente, #btnBuscarAceptar").button();
        }

        $("#btnBuscarAceptar").click(function(){
            $("#dialogMensaje").dialog("close");
        });

        this.procedimientoBuscarPersona = this.PROCEDIMIENTO_BUSCAR_PERSONA;
        if (modo == this.MODO_FULL || modo==this.MODO_CERO) {
            this.titleDialog = "Buscador de Series";
            if ($(".rowBuscarContribuyente").hasClass("row-hide")) {
                $(".rowBuscarContribuyente").removeClass("row-hide");
            }
            if ($(".rowBuscarPredio").hasClass("row-hide")) {
                $(".rowBuscarPredio").removeClass("row-hide");
            }
        }
    },
    bindkeysPersona: {"onEnter": function() {}},
    configurarDialog: function() {
        $("#dialogBuscarSeries").dialog({
            title: this.titleDialog,
            modal: true,
            minHeight: 'auto',
            width: 1030,
            position: ['center', 'center'],
            resizable: false,
            autoOpen: false,
            closeOnEscape: true
        });
    },
    configBeforeGrid: function(request) {
    },
    obtenerParameterContribuyente: function() {
        return '[' +
            '["@tBusqueda", "' + $("#cbotipob").val() + '"],' +
            '["@vDatoBus", "' + $("#c_textbusqueda").val() + '"]' +
            ']';

    },
    obtenerParameterSeriesSalida: function() {
        return '[' +
            '["@tBusqueda", "5"],' +
            '["@vDatoBus", "' + $("#c_textbusqueda").val() + '"]' +
            ']';

    },
    buscarAjax: function(modo) {

        var
            parameters = {
                "name": "tblResult",
                "procedure": (this.procedimientoBuscarPersona ),
                "print": "true",
                "parameters": ( modo == this.MODO_FULL ? this.obtenerParameterContribuyente() : this.obtenerParameterSeriesSalida() )
            },
            proceso = function(request) {
                $("#panelResult").html('<table id="tblResult"></table><div id="ptblResult"></div><input type="hidden" id="ctblResult" name="ctblResult" value="" />');
                var
                    records = request.length,
                    bindkeys = ( BuscadorSeries.bindkeysPersona ),
                    gridConfig = $.extend(( BuscadorSeries.gridConfigPersona ), {
                        data: request,
                        datatype: "local"
                    });
                inicializarGrid("tblResult", gridConfig, bindkeys);
                if (records == 0) {
                    if (modo == BuscadorSeries.MODO_CERO) {
                        if (!$("#btnBuscarNuevoPredio").hasClass("row-hide")) {
                            $("#btnBuscarNuevoPredio").addClass("row-hide");
                        }
                        if ($("#btnBuscarNuevoContribuyente").hasClass("row-hide")) {
                            $("#btnBuscarNuevoContribuyente").removeClass("row-hide");
                        }
                    }
                    $("#dialogMensaje").dialog("open");
                }
                BuscadorSeries.configBeforeGrid(request);
            };
        procesarConsultaSubProceso('registrar', parameters, proceso, 'json');
    }
};