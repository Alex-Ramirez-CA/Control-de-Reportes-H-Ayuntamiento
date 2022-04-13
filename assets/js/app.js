(function($) {
    if (($('.container').attr('rol')) == 3){
        obtenerIncidencias ();
    }

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
                                <div class="opciones-tecnico">
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
                                <div class="opciones-tecnico">
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
                                <div class="opciones-tecnico">
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