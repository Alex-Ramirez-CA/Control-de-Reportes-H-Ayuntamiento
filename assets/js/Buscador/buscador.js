(function($) {
    $("#search").keyup(function(ev) { 
        if($('#search').val()){
            let search = $('#search').val();
            console.log(search);
            $.ajax({
                url: 'cliente/buscar_incidencia',
                type: 'POST',
                data: { search },
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

    $(document).on('click', '.card', function(){
        let elemento = $(this)[0];
        let id_incidencia = $(elemento).attr('idCard');
        $.post('cliente/visualizar_reporte', {id_incidencia});
        console.log(id_incidencia);
    });

    $(document).on('click', '.autocompletado', function(){
        let elemento = $(this)[0]; 
        let id_incidencia = $(elemento).attr('idCard');
        $.post('cliente/visualizar_reporte', {id_incidencia});
        console.log(id_incidencia);
    });

})(jQuery)