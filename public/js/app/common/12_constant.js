//INCONOS DE BOTONES
ICON_SAVE = {icons: {primary:'ui-icon-disk'}};
ICON_CANCEL = {icons: {primary:'ui-icon-arrowreturnthick-1-w'}};
ICON_SEARCH = {icons: {primary: "ui-icon-search"}};
var ArregloMateriales = [];
var PARAMETRO_NIVEL_LLAMADA=0;
function AgregarLista(a){
    //console.log(a);
    var pos = ArregloMateriales.indexOf(a);
    //console.log("Pos="+pos);
    if (pos==-1){
        ArregloMateriales.push(a);
    }else{
        ArregloMateriales.splice(pos, 1);
    }
}