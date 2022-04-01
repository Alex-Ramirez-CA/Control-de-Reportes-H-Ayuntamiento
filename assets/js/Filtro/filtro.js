(function($) {
    let url;
    //Función para cuando le de click a la tarjeta
    $(document).on('click', '.btn-ver-filtro', function(){
        let elemento = $(this)[0];
        let id_incidencia = $(elemento).attr('idReporte');
        console.log(id_incidencia);
        $.post('reporte/visualizar_reporte', {id_incidencia}, function(response){
            let json = JSON.parse(response);
            window.open(json.url);
        });
    });

    //Función la opción de complementar la descripción de un reporte
    $(document).on('click', '.btn-comentar-filtro', function(){
        let elemento = $(this)[0];
        let id_incidencia = $(elemento).attr('idReporte');
        $.post('filtro/editar_descripcion', {id_incidencia}, function(response){
            let json = JSON.parse(response);
            $('.titulo-reporte-filtro').html(json.titulo);
            $('#folio-reporte').html("Folio: " + json.id_incidencia);
            $('#fecha-reporte').html("Creado: " + json.fecha_apertura);
            $('#descripcion-reporte').html(json.descripcion);
            $('.guardar-cambios').attr('idReporte',json.id_incidencia);
        });
    });

    //Función para enviar la descripción del reporte editado
    $(document).on('click', '.guardar-cambios', function(){
        let id_incidencia = $('.guardar-cambios').attr('idReporte');
        let descripcion = $('#descripcion-reporte').val();
        $.post('filtro/actualizar_descripcion', {id_incidencia,descripcion}, function(response){
            let json = JSON.parse(response);
            if (id_incidencia === undefined) {
                //Se abre el modal con la imagen incorrecta
                $('.texto-mensaje').css({'color':'#E52141'});
                $('.texto-mensaje').html("Tiene que seleccionar algún reporte");
                $('.img-mensaje').attr('src',$('.img-mensaje').attr('incorrecto'));
                $('.mensaje').css({'visibility':'visible'});
                $('.contenedor-mensaje').css({'height':'35%'});
            }else {
                //Se abre el modal con la imagen correcta
                $('.texto-mensaje').html(json.msg);
                $('.img-mensaje').attr('src',$('.img-mensaje').attr('correcto'));
                $('.mensaje').css({'visibility':'visible'});
                $('.contenedor-mensaje').css({'height':'30%'});
            }
            url = json.url;
        }); 
    }); 

    //Función para cerrar el modal
    $(document).on('click', '.cerrar-mensaje', function(){
        $('.mensaje').css({'visibility':'hidden'});
        window.location.replace(url);
    });

})(jQuery)