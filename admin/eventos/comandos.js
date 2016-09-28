function cargar(nombre) {
	$("#portatabla").html('<div class="col s12 push-m2 m8 push-l4 l4"><div class="progress"><div class="indeterminate"></div></div></div>');
    $.ajax({
        type:'POST',
        url:'_tabla.php', //archivo del calculo
        data: {buscar : nombre},
        success:function(data){
            $("#portatabla").html(data);
            $('.lean-overlay').remove();
            $('.modal-trigger').leanModal();
        }
    });
}
function eliminar(id) {
	$("#portatabla").html('<div class="col s12 push-m2 m8 push-l4 l4"><div class="progress"><div class="indeterminate"></div></div></div>');
    $.ajax({
        type:'POST',
        url:'_herr.php', //archivo del calculo
        data: {e : id},
        success:function(data){
            switch (data) {
                case '-1':
                    Materialize.toast('No tiene permiso para hacer eso.', 4000);
                    break;
                case '1':
                    Materialize.toast('Eliminado correctamente.', 4000);
                    break;
                default:
                    Materialize.toast('Error desconocido.', 8000);
                    break;
            }
            cargar($('#buscar').val());
        }
    });
}
function permutar(id, es) {
	$("#portatabla").html('<div class="col s12 push-m2 m8 push-l4 l4"><div class="progress"><div class="indeterminate"></div></div></div>');
    $.ajax({
        type:'POST',
        url:'_herr.php', //archivo del calculo
        data: {o : id, x : es},
        success:function(data){
            switch (data) {
                case '-1':
                    Materialize.toast('No tiene permiso para hacer eso.', 4000);
                    break;
                case '1':
                    Materialize.toast((es == 0 ? 'Ocultado' : 'Mostrado') + ' correctamente.', 4000);
                    break;
                default:
                    Materialize.toast('Error desconocido.', 8000);
                    break;
            }
            cargar($('#buscar').val());
        }
    });
}
var ULM = '';
function disponible(ide){
    var nn = $('#nombre_evento').val().trim();
    $('#preloaderX').html('<div class="preloader-wrapper small active">' +
                    '<div class="spinner-layer spinner-green-only">' +
                        '<div class="circle-clipper left">' +
                            '<div class="circle"></div>' +
                        '</div>' +
                        '<div class="gap-patch">' +
                            '<div class="circle"></div>' +
                        '</div>' +
                        '<div class="circle-clipper right">' +
                            '<div class="circle"></div>' +
                        '</div>' +
                    '</div>' +
                '</div>');
    var val = new RegExp("^[a-zA-Z \x7f-\xff]{1,25}$");
    if (val.test(nn)) {
        $.ajax({
            type:'POST',
            url:'_herr.php', //archivo del calculo
            data: {n : nn, o : ide},
            success:function(data){
                switch (data) {
                    case '1': break;
                    default:
                        ULMN = 'Ya está en uso este nombre: ' + nn;
                        if (ULM != ULMN)
                            Materialize.toast(ULMN, 8000, '', function(){ ULM = ''; });
                        ULM = ULMN;
                        break;
                }
                $('#preloaderX').html('');
            }
        });
    } else {
        ULMN = 'Ese nombre no es válido.';
        if (ULM != ULMN)
            Materialize.toast(ULMN, 8000, '', function(){ ULM = ''; });
        ULM = ULMN;
        $('#preloaderX').html('');
    }
}