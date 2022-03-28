(function($) {
    $("#search").keyup(function(ev) {
        $('#opciones-buscar').css('display','flex');
        if($('#search').val()){
            let search = $('#search').val();
            let url = $('#search').attr('url');
            $.ajax({
                url: 'busqueda/buscar_incidencia',
                type: 'POST',
                data: { search, url },
                success: function(data) {
                    let incidencias = JSON.parse(data);
                    let template = "";

                    if (incidencias){
                        incidencias.forEach(element => {
                            template += `<a class="autocompletado" href="#" idCard="${element.id_incidencia}">
                            ${element.titulo}
                            </a>`;
                        });
                        $('#opciones-buscar').html(template);
                    }
                        
                    
                //window.location.replace(json.url);
                }
            });
        }else{
            template = "";
        }        
    });

    $(document).on('click', '.usuario-icono', function(){
        if($('.menu-cerrar-sesion').css('display') == 'none'){
            $('.menu-cerrar-sesion').css('display','block');
        }else{
            $('.menu-cerrar-sesion').css('display','none');
        }
    });

    $(document).on('click', 'body', function(){
        if($('#opciones-buscar').css('display') == 'flex'){
            $('#opciones-buscar').css('display','none');
        }
    });

    $(document).on('click', '.card', function(){
        let elemento = $(this)[0];
        let id_incidencia = $(elemento).attr('idCard');
        $.post('reporte/visualizar_reporte', {id_incidencia}, function(response){
            let json = JSON.parse(response);
            window.open(json.url);
        });
    });

    $(document).on('click', '.autocompletado', function(){
        let elemento = $(this)[0]; 
        let id_incidencia = $(elemento).attr('idCard');
        $.post('reporte/visualizar_reporte', {id_incidencia}, function(response){
            let json = JSON.parse(response);
            window.open(json.url);
            });
        console.log(id_incidencia);
    });

})(jQuery)