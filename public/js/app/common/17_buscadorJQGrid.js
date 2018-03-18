function buscadorJQGrid() {
    // Html Tags Props
    this.panel = '';
    this.table = '';
    // Data Props
    this.procedure = '';
    this.print = true;
    this.params = {};
    // Grid Config
    this.option = {};
    // Methods
    this.prepareParams = null;
    this.gridBindKeys = null;
    this.gridNavPanel = null;
    this.execPrint = function(overrideOptions){
        var currentOptions = this.option;
        if(overrideOptions != undefined && overrideOptions != null){
            currentOptions = $.extend(this.option, overrideOptions);
        }
        actualizarGrid(
            this.table,
            currentOptions,
            this.gridBindKeys,
            this.gridNavPanel
        );
    };
    this.execSearch = function(overrideOptions){
        if (this.prepareParams != undefined && this.prepareParams != null){
            this.prepareParams();
        }
        var currentOptions = this.option;
        if(overrideOptions != undefined && overrideOptions != null){
            currentOptions = $.extend(this.option, overrideOptions);
        }
        console.log(JSON.stringify(this.params));
        var searchParams = {
            "name": this.table,
            "procedure": this.procedure,
            "print": this.print,
            "parameters" : JSON.stringify(this.params)
        };
        procesarProcedimientoJSON(
            this.panel,
            this.table,
            currentOptions,
            searchParams,
            this.gridBindKeys, //bindKeysPersona,
            this.gridNavPanel //navPanelPersona
        );
    };
    this.getSelectedRow = function(){
        var grid = $('#' + this.table);
        var selID = grid.jqGrid('getGridParam', 'selrow');
        return grid.jqGrid('getRowData', selID);
    };
    this.getSelectedRows = function(){
        var grid = $('#' + this.table);
        var selIDs = grid.jqGrid('getGridParam', 'selarrrow');
        var c_selIDs = selIDs.length;
        var sRows = new Array();
        for (var i = 0; i < c_selIDs; i++){
            var row = grid.jqGrid('getRowData', selIDs[i]);
            sRows[i] = row;
        }
        return sRows;
    };
    this.getSelectedRows_Column = function(field, separator){
        if(separator == undefined || separator == null){
            separator = ',';
        }
        var vText = '';
        var sRows = this.getSelectedRows();
        var c_sRows = sRows.length;
        for (var i = 0; i < c_sRows; i++){
            vText = vText + sRows[i][field] + separator;
        }
        vText = vText.substr(0, vText.length - separator.length);
        return vText;
    };
}
/*
var buscadorJQGrid = {
    // Html Tags Props
    panel : '',
    table : '',
    // Data Props
    procedure : '',
    print : true,
    params : {},
    // Grid Config
    option : {},
    // Methods
    execPrint : function(overrideOptions){
        var currentOptions = this.option;
        if(overrideOptions != undefined && overrideOptions != null){
            currentOptions = $.extend(this.option, overrideOptions);
        }
        actualizarGrid(
            this.table,
            currentOptions,
            null
        );
    },
    execSearch : function(overrideOptions){
        var currentOptions = this.option;
        if(overrideOptions != undefined && overrideOptions != null){
            currentOptions = $.extend(this.option, overrideOptions);
        }
        var searchParams = {
            "name": this.table,
            "procedure": this.procedure,
            "print": this.print,
            "parameters" : JSON.stringify(this.params)
        };
        procesarProcedimientoJSON(
            this.panel,
            this.table,
            currentOptions,
            searchParams,
            null,//bindKeysPersona,
            null //navPanelPersona
        );
    },
    getSelectedRows : function(){
        return null;
    }
};
*/

/*
var buscadorJQGrid = {
    // Html Tags Props
    panel : 'panelDistrito',
    table : 'tblDistrito',
    // Data Props
    procedure : 'registro.mubigeodistr',
    print : true,
    params : {
        p_iddepartamento : $('#cbodepartamento_b').val(),
        p_idprovincia : $('#cboprovincia_b').val(),
        p_iddistrito : ''
    },
    // Grid Config
    option : {
        // Props
        caption: 'Distrito',
        height: 140,
        width: 700,
        colNames: [
            'Código',
            'Descripción',
            'nestado'
        ],
        colModel: [
            {name:'idsigma', index:'idsigma', width: 75, hidden: false},
            {name:'vnombres', index:'vnombres', width: 200, hidden: false},
            {name:'nestado', index:'nestado', width: 80, hidden: true}
        ]
        // Methods
    },
    // Methods
    execPrint : function(overrideOptions){
        var currentOptions = this.option;
        if(overrideOptions != undefined && overrideOptions != null){
            currentOptions = $.extend(this.option, overrideOptions);
        }
        actualizarGrid(
            this.table,
            currentOptions,
            null
        );
    },
    execSearch : function(overrideOptions){
        var currentOptions = this.option;
        if(overrideOptions != undefined && overrideOptions != null){
            currentOptions = $.extend(this.option, overrideOptions);
        }
        var searchParams = {
            "name": this.table,
            "procedure": this.procedure,
            "print": this.print,
            "parameters" : JSON.stringify(this.params)
        };
        procesarProcedimientoJSON(
            this.panel,
            this.table,
            currentOptions,
            searchParams,
            null,//bindKeysPersona,
            null //navPanelPersona
        );
    },
    getSelectedRows : function(){
        var valorSeleccionado = '';
        var selRows = $('#' + this.table).jqGrid('getGridParam', 'selarrrow');
        var cselRows = selRows.length;
        if (cselRows > 0) {
            for (var i = 0; i < cselRows; i++) {
                var tRow = $('#' + this.table).jqGrid('getRowData', selRows[i]);
                console.log(tRow);
                //valorSeleccionado += '' + tRow.idsigma + ':' + tRow.vnombres + '\n';
                valorSeleccionado += tRow.vnombres + ', ';
            }
            valorSeleccionado = valorSeleccionado.substr(0, valorSeleccionado.length - 2);
        }
        return valorSeleccionado;
    }
};
*/