(function($) {
    $(document).on('click', '#alguien-mas', function(){
        if($('#alguien-mas').is(':checked')){
            $('.search_usuario').css({'display':'inline'});
            $('.label-alguien-mas').css({'display':'none'});
            $('.creador-reporte').html("Creador del reporte:");
        }else{
            $('.search_usuario').css({'display':'none'});
            $('.label-alguien-mas').css({'display':'inline'});
            $('.creador-reporte').html("Creador del reporte: " + $('.creador-reporte').attr('nombre'));
        }
    });

    //Evento que se ejecuta cuando el usuario este escribiendo en la barra de busqueda
    $(".search_usuario").keyup(function(ev) {
        $('.opciones-usuarios-nueva-incidencia').css('display','block');
        if($('.search_usuario').val()){
            let search_usuario = $('.search_usuario').val();
            //console.log(search_usuario)

            $.ajax({
                url: 'buscar_empleado',
                type: 'POST',
                data: { search_usuario },
                success: function(data) {
                    let empleados = JSON.parse(data);
                    let template = "";
                    if (empleados){
                        empleados.forEach(element => {
                            template += ` <p class="opcion-empleado" no_empleado="${element.no_empleado}">${element.nombre + " " + element.apellido_paterno + " " + element.apellido_materno}</p>`;
                        });
                    }else {
                        template = "";
                    }
                    $('.opciones-usuarios-nueva-incidencia').html(template);
                }
            });
        }else {
            template = "";
            $('.opciones-usuarios-nueva-incidencia').html(template);
        }
    });

    $(document).on('click', 'body', function(){
        if($('.opciones-usuarios-nueva-incidencia').css('display') == 'block'){
            $('.opciones-usuarios-nueva-incidencia').css('display','none');
        }
    });

    $(document).on('click', '.opcion-empleado', function(){
        let elemento = $(this)[0]; 
        let id_usuario = $(elemento).attr('no_empleado');
        console.log(id_usuario);
        let nombre = $(elemento).text();
        $(".search_usuario").val(nombre);
        $('.creador-reporte').html("Creador del reporte: " + nombre);
        $('.creador-reporte').val(id_usuario);
        $.post('obtener_equipos', {id_usuario}, function(response){
            let json = JSON.parse(response);
            let template = "";
            json[Object.keys(json).length] = {"id_equipo" : "0", "nombre" : "Ninguno"}
            if (json){
                json.forEach(element => {
                    template += ` <option value="${element.id_equipo}">${element.nombre}</option> `;
                 });
            }else {
                template = "";
            }
            $('.opciones-usuarios-nueva-incidencia').html(template);
            $('#seleccion-equipo').html(template);
            
            console.log(json);
        });
    });

})(jQuery)