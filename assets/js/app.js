(function($) {
    let direccion = null;
    let departamento = null;
    let dependencia = null;

    //Obtener las incidencia para el cliente tipo Administrador
    if (($('.container').attr('rol')) == 3){
        obtenerIncidencias ();
    }

    //Función para cuando le de click al boton de ver
    $(document).on('click', '.ver', function(){
        let elemento = $(this)[0];
        let id_incidencia = $(elemento).attr('idReporte');
        $.post('reporte/visualizar_reporte', {id_incidencia}, function(response){
            let json = JSON.parse(response);
            window.open(json.url);
        });
    });

    //Función para el boton de atender incidencia
    $(document).on('click', '.atender', function(){
        let elemento = $(this)[0];
        let id = $(elemento).attr('idReporte');
        let titulo = $(elemento).attr('titulo');
        $('.folio').html("Folio: " + id);
        $('.participante').html("0");
        $('.nombres-asignados').html("Por definir");
        $('.titulo-reporte-tecnico').html("Titulo: " + titulo);
        $('.mensaje').css({'visibility':'visible'});
        $('.contenedor-mensaje').css({'transform':'translateY(0%)'});
        $('.enviar-comentario').attr('idReporte',id);
        $('.enviar-comentario').attr('titulo',titulo);

        $(document).on('click', '.enviar-comentario', function(){
            let elemento = $(this)[0];
            let id_incidencia = $(elemento).attr('idReporte');
            let comentario = $('#comentario-tecnico').val();
            $.post('tecnico/atender', {id_incidencia, comentario}, function(response){
                let json = JSON.parse(response);
                window.location.replace(json.url);
            });

        });
    });

    $(document).on('click', '.unirme', function(){
        let elemento = $(this)[0];
        let id = $(elemento).attr('idReporte');
        let titulo = $(elemento).attr('titulo');
        let participantes = ($(elemento).attr('participantes')).split(',');
        $('.folio').html("Folio: " + id);
        //$('.participante').css({'padding-left':'8px'});
        $('.participante').html(participantes.length);
        $('.nombres-asignados').html("Atendido por " + participantes);
        $('.titulo-reporte-tecnico').html("Titulo: " + titulo);
        $('.mensaje').css({'visibility':'visible'});
        $('.contenedor-mensaje').css({'transform':'translateY(0%)'});
        $('.enviar-comentario').attr('idReporte',id);
        $(document).on('click', '.enviar-comentario', function(){
            let elemento = $(this)[0];
            let id_incidencia = $(elemento).attr('idReporte');
            let comentario = $('#comentario-tecnico').val();
            console.log(id_incidencia);
            console.log(comentario);
            $.post('tecnico/unirme', {id_incidencia, comentario}, function(response){
                let json = JSON.parse(response);
                window.location.replace(json.url);
            });

        });
    });

    $(document).on('click', '.reabrir', function(){
        let elemento = $(this)[0];
        let id = $(elemento).attr('idReporte');
        let titulo = $(elemento).attr('titulo');
        let participantes = ($(elemento).attr('participantes')).split(',');
        $('.folio').html("Folio: " + id);
        $('.participante').html(participantes.length);
        $('.nombres-asignados').html("Atendido por " + participantes);
        $('.titulo-reporte-tecnico').html("Titulo: " + titulo);
        $('.mensaje').css({'visibility':'visible'});
        $('.contenedor-mensaje').css({'transform':'translateY(0%)'});
        $('.enviar-comentario').attr('idReporte',id);

        $(document).on('click', '.enviar-comentario', function(){
            let elemento = $(this)[0];
            let id_incidencia = $(elemento).attr('idReporte');
            let comentario = $('#comentario-tecnico').val();
            $.post('tecnico/reabrir', {id_incidencia, comentario}, function(response){
                let json = JSON.parse(response);
                window.location.replace(json.url);
            });

        });
    });

    $(document).on('click', '.finalizar', function(){
        let elemento = $(this)[0];
        let id = $(elemento).attr('idReporte');
        let titulo = $(elemento).attr('titulo');
        let participantes = ($(elemento).attr('participantes')).split(',');
        $('.folio').html("Folio: " + id);
        $('.participante').html(participantes.length);
        $('.nombres-asignados').html("Atendido por " + participantes);
        $('.titulo-reporte-tecnico').html("Titulo: " + titulo);
        $('.mensaje').css({'visibility':'visible'});
        $('.contenedor-mensaje').css({'transform':'translateY(0%)'});
        $('.enviar-comentario').attr('idReporte',id);

        $(document).on('click', '.enviar-comentario', function(){
            let elemento = $(this)[0];
            let id_incidencia = $(elemento).attr('idReporte');
            let comentario = $('#comentario-tecnico').val();
            $.post('atendiendo/finalizar', {id_incidencia, comentario}, function(response){
                let json = JSON.parse(response);
                window.location.replace(json.url);
            });

        });
    });

    $(document).on('click', '.reabrir-atendido', function(){
        let elemento = $(this)[0];
        let id = $(elemento).attr('idReporte');
        let titulo = $(elemento).attr('titulo');
        let participantes = ($(elemento).attr('participantes')).split(',');
        $('.folio').html("Folio: " + id);
        $('.participante').html(participantes.length);
        $('.nombres-asignados').html("Atendido por " + participantes);
        $('.titulo-reporte-tecnico').html("Titulo: " + titulo);
        $('.mensaje').css({'visibility':'visible'});
        $('.contenedor-mensaje').css({'transform':'translateY(0%)'});
        $('.enviar-comentario').attr('idReporte',id);

        $(document).on('click', '.enviar-comentario', function(){
            let elemento = $(this)[0];
            let id_incidencia = $(elemento).attr('idReporte');
            let comentario = $('#comentario-tecnico').val();
            $.post('atendiendo/reabrir', {id_incidencia, comentario}, function(response){
                let json = JSON.parse(response);
                window.location.replace(json.url);
            });

        });
    });

    //Función para cerrar el modal
    $(document).on('click', '.cerrar-mensaje-tecnico', function(){
        $('.enviar-comentario').removeAttr('idReporte');
        $('.mensaje').css({'visibility':'hidden'});
        $('.contenedor-mensaje').css({'transform':'translateY(-200%)'});
        if (($('.container').attr('rol')) == 2){
            $.post('tecnico/recargar', {}, function(response){
                let json = JSON.parse(response);
                window.location.replace(json.url);
            });
        }else if(($('.container').attr('rol')) == 3){
            obtenerIncidencias ();
        }
    });

    /*
    ------------------------------------------------------------------------------------------------------------
    Funciones para usuario administrador
    ------------------------------------------------------------------------------------------------------------
    */
    //Evento cuando se clica el boton de aplicar filtros
    $(document).on('click', '#btn-filtros', function(){
        $('.mensaje').css({'visibility':'visible'});
        $('.contenedor-mensaje').css({'transform':'translateY(0%)'});
    });

    //Eventos cuando selccione algun departamento
    $(document).on('click', '.opcion-departamento', function(){
        if($(this).hasClass('active')){
            $(this).toggleClass('active');
            departamento = null;
        }else{
            $('.lista-departamentos').children().removeClass('active');
            $(this).toggleClass('active');
            departamento = $(this).attr('idDepartamento');
            //console.log("departamento " + departamento);
        }
    });

    //Evento de cuando clique una dependencia
    $(document).on('click', '.opcion-dependecia', function(){
        if($(this).hasClass('active')){
            $(this).toggleClass('active');
            dependencia = null;
        }else{
            $('.lista-dependecias').children().removeClass('active');
            $(this).toggleClass('active');
            dependencia = $(this).attr('idDependecia');
            //console.log("dependecia " + dependecia);
        }
    });

    //Evento de cuando clique una dirección
    $(document).on('click', '.opcion-direccion', function(){
        if($(this).hasClass('active')){
            $(this).toggleClass('active');
            direccion = null;
        }else{
            $('.lista-direcciones').children().removeClass('active');
            $(this).toggleClass('active');
            direccion = $(this).attr('idDireccion');
            //console.log("direccion " + direccion);
        }
    });

    //Evento de cuando clique en enviar filtros
    $(document).on('click', '#aplicar-filtros', function(){
        let fecha_inicio = $('#fecha_inicio').val();
        let fecha_fin = $('#fecha_fin').val();
        console.log("Depa "+ departamento);
        console.log("Depe " + dependencia);
        console.log("Dir " + direccion);
        console.log("Inicio " + fecha_inicio);
        console.log("Fin " + fecha_fin);
        console.log("--------------------------");
        $.post('administrador/filtrar_incidencias', {dependencia, direccion, departamento, fecha_inicio, fecha_fin}, function(response){
            // let json = JSON.parse(response);
            // console.log(json);
        });
        $('.mensaje').css({'visibility':'hidden'});
        $('.contenedor-mensaje').css({'transform':'translateY(-200%)'});
    });

    //Función que carga las incidencias
    function obtenerIncidencias (){
        $.ajax({
            url: 'administrador/cargar_datos',
            type: 'GET',
            success: function(response) {
                let incidencias = JSON.parse(response);
                let template_pendientes = "";
                let template_proceso = "";
                let template_finalizados = "";
                let cantidad_pendientes;
                let cantidad_proceso;
                let cantidad_finalizados;

                //Para las incidencias pendientes
                if(incidencias.pendientes){
                    (incidencias.pendientes).forEach(incidencia_pendiente => {
                        if(incidencia_pendiente.departamento == null){
                            incidencia_pendiente.departamento = ": Por asignar";
                        }
                        if(incidencia_pendiente.encargado == null){
                            incidencia_pendiente.encargado = ": Por asignar";
                        }
                        template_pendientes += `
                        <div class="card-tres-columnas">
                            <div class="card-title">
                                <b><h5>${incidencia_pendiente.titulo}</h5></b>
                            </div>
                            <div class="card-body-tres-columnas">
                                <div class="fecha">
                                    <b><h5>Folio</h5></b>
                                    <p>${incidencia_pendiente.id_incidencia}</p>
                                </div>
                                <div class="fecha">
                                    <b><h5>Creado</h5></b>
                                    <p>${incidencia_pendiente.fecha_apertura}</p>
                                </div>
                                <div class="opciones-card">
                                    <button class="ver" idReporte="${incidencia_pendiente.id_incidencia}">Ver</button>
                                </div>
                            </div>
                            <div class="tecnico-departamento">
                                <div class="nom-tecnicos">
                                    <figcaption>
                                        <p class="nombre-tecnicos">Atendido por</b>${incidencia_pendiente.encargado}</p>
                                    </figcaption>
                                    <img src='./assets/img/iconos/tecnicos.svg' alt=''>
                                </div>
                                <div class="nom-departamentos">
                                    <figcaption>
                                        <p class="nombre-departamentos">Se asigno a </b>${incidencia_pendiente.departamento}</p>
                                    </figcaption>
                                    <img src='./assets/img/iconos/departamentos.svg' alt=''>
                                </div>                                
                            </div>
                        </div>
                        `;
                        //console.log(incidencia_pendiente);
                    });
                }   
                
                //Para las incidencias en proceso
                if(incidencias.en_proceso){
                    (incidencias.en_proceso).forEach(incidencia_proceso => {
                        template_proceso += `
                        <div class="card-tres-columnas">
                            <div class="card-title">
                                <b><h5>${incidencia_proceso.titulo}</h5></b>
                            </div>
                            <div class="card-body-tres-columnas">
                                <div class="fecha">
                                    <b><h5>Folio</h5></b>
                                    <p>${incidencia_proceso.id_incidencia}</p>
                                </div>
                                <div class="fecha">
                                    <b><h5>Creado</h5></b>
                                    <p>${incidencia_proceso.fecha_apertura}</p>
                                </div>
                                <div class="opciones-card">
                                    <button class="ver" idReporte="${incidencia_proceso.id_incidencia}">Ver</button>
                                </div>
                            </div>
                            <div class="tecnico-departamento">
                                <div class="nom-tecnicos">
                                    <figcaption>
                                        <p class="nombre-tecnicos">Atendido por </b>${incidencia_proceso.encargado}</p>
                                    </figcaption>
                                    <img src='./assets/img/iconos/tecnicos.svg' alt=''>
                                </div>
                                <div class="nom-departamentos">
                                    <figcaption>
                                        <p class="nombre-departamentos">Se asigno a </b>${incidencia_proceso.departamento}</p>
                                    </figcaption>
                                    <img src='./assets/img/iconos/departamentos.svg' alt=''>
                                </div>                                
                            </div>
                        </div>
                        `;
                        //console.log(incidencia_proceso);
                    });
                }

                //Para las incidencias finalizadas
                if(incidencias.finalizados){
                    (incidencias.finalizados).forEach(incidencia_finalizada => {
                        template_finalizados += `
                        <div class="card-tres-columnas">
                            <div class="card-title">
                                <b><h5>${incidencia_finalizada.titulo}</h5></b>
                            </div>
                            <div class="card-body-tres-columnas">
                                <div class="fecha">
                                    <b><h5>Folio</h5></b>
                                    <p>${incidencia_finalizada.id_incidencia}</p>
                                </div>
                                <div class="fecha">
                                    <b><h5>Creado</h5></b>
                                    <p>${incidencia_finalizada.fecha_apertura}</p>
                                </div>
                                <div class="opciones-card">
                                    <button class="ver" idReporte="${incidencia_finalizada.id_incidencia}">Ver</button>
                                </div>
                            </div>
                            <div class="tecnico-departamento">
                                <div class="nom-tecnicos">
                                    <figcaption>
                                        <p class="nombre-tecnicos">Atendido por </b>${incidencia_finalizada.encargado}</p>
                                    </figcaption>
                                    <img src='./assets/img/iconos/tecnicos.svg' alt=''>
                                </div>
                                <div class="nom-departamentos">
                                    <figcaption>
                                        <p class="nombre-departamentos">Se asigno a </b>${incidencia_finalizada.departamento}</p>
                                    </figcaption>
                                    <img src='./assets/img/iconos/departamentos.svg' alt=''>
                                </div>                                
                            </div>
                        </div>
                        `;
                        //console.log(incidencia_finalizada);
                    });
                }
                
                //Pintar los reportes en sus columnas correspondientes
                $('.columna-tripleta-pendiente').html(template_pendientes);
                $('.columna-tripleta-proceso').html(template_proceso);
                $('.columna-tripleta-finalizado').html(template_finalizados);

                if(((incidencias.pendientes).length) == null){
                    cantidad_pendientes = 0;
                }else if(((incidencias.pendientes).length) > 999){
                    cantidad_pendientes = ((incidencias.pendientes).length).toFixed(1) + "k";
                }else{
                    cantidad_pendientes = (incidencias.pendientes).length;
                }

                if(((incidencias.en_proceso).length) == null){
                    cantidad_proceso = 0;
                }else if(((incidencias.en_proceso).length) > 999){
                    cantidad_proceso = ((incidencias.en_proceso).length).toFixed(1) + "k";
                }else {
                    cantidad_proceso = (incidencias.en_proceso).length;
                }

                if(((incidencias.finalizados).length) == null){
                    cantidad_finalizados = 0;
                }else if(((incidencias.finalizados).length) > 999){
                    cantidad_finalizados = ((incidencias.finalizados).length).toFixed(1) + "k";
                }else{
                    cantidad_finalizados = (incidencias.finalizados).length;
                }

                //Pintar la cantidad de reportes de cada columna
                $('.cantidad-reportes-pendiente').html(cantidad_pendientes);
                $('.cantidad-reportes-proceso').html(cantidad_proceso);
                $('.cantidad-reportes-finalizado').html(cantidad_finalizados);
            }
        });
    }
    
})(jQuery)