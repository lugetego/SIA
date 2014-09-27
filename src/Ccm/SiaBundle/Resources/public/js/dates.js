var inicio = document.getElementById('ccm_siabundle_solicitud_inicio');
var fin = document.getElementById('ccm_siabundle_solicitud_fin');

fin.onfocus = function(){

    var a = moment(inicio.value,"YYYY MM DD");
    var b = moment(fin.value, "YYYY MM DD");

    if ( a.isValid() && b.isValid() && b.isAfter(a) ){
        var days = b.diff(a,'days') ;

        if( days > 45 ){
            document.getElementById('days').innerHTML= ' no se pueden solicitar más de 45 días ' + days + ' días solicitados';
            fin.value = '';
        }

        else{//alert( days );
            document.getElementById('days').innerHTML= days + ' días solicitados';
        }
    }

    else {
        if( a.isValid == false ){
            document.getElementById('days').innerHTML= 'Fecha de inicio inválida';
            inicio.value = '';}
        if( b.isValid == false ){
            fin.value = '';
        }

        document.getElementById('days').innerHTML= 'Fechas inválidas';
        inicio.value = '';
        fin.value = '';



    }


}
