<?= $head; ?>

<?= $nav; ?>

<div class="container" rol="<?= $this->session->id_rol; ?>">
    <!-- Columna para los reportes pendientes -->
    <div class="pendiente">
        <div class="titulo-columna">
            <p class="cantidad-reportes-pendiente"></p>
            <h3><b>Reportes pendientes</b></h3>
        </div>
        <div class="columna-tripleta-pendiente">

        </div>
    </div>

    <div class="proceso">
        <div class="titulo-columna">
            <p class="cantidad-reportes-proceso"></p>
            <h3><b>Reportes en proceso</b></h3>
        </div>
        <div class="columna-tripleta-proceso">
            
        </div>
    </div>

    <div class="finalizado">
        <div class="titulo-columna">
            <p class="cantidad-reportes-finalizado"></p>
            <h3><b>Reportes finalizados</b></h3>
        </div>
        <div class="columna-tripleta-finalizado">
            
        </div>
    </div>

    
</div>

<div class="mensaje">
    <div class="cerrar-ventana">
        <p class="cerrar-mensaje-tecnico">x</p>
    </div>
    <div class="contenedor-mensaje">
        <div class="titulo-mensaje">
            <b><h1>Filtros</h1></b>
        </div>
        <div class="mensaje-body">
            <div class="parte1-filtros">
                <div class="filtro">
                    <h2>Por dependencia</h2>
                    <img class="filtro-dependecia" src="./assets/img/iconos/dependencias.svg" alt="">
                    <div class="lista-dependecias">
                        <p class="opcion-dependecia">Regidores</p>
                        <p class="opcion-dependecia">Presidencia municipal</p>
                        <p class="opcion-dependecia">Secretaria del ayuntamiento</p>
                        <p class="opcion-dependecia">Oficialia mayor</p>
                        <p class="opcion-dependecia">Tesorería mayor</p>
                        <p class="opcion-dependecia">Dirección general de recursos jurídicos</p>
                        <p class="opcion-dependecia">Dirección general de servicios públicos</p>
                        <p class="opcion-dependecia">Dirección general de desarrollo urbano y medio</p>
                        <p class="opcion-dependecia">Contraloría municipal</p>
                        <p class="opcion-dependecia">Policía municipal de Colima</p>
                        <p class="opcion-dependecia">Dirección general de desarrollo económico, social y humano</p>
                        <p class="opcion-dependecia">Dirección general de obras públicas</p>
                        <p class="opcion-dependecia">Jubilados y pensionados</p>
                        <p class="opcion-dependecia">Organismos autónomos</p>
                    </div>
                </div>
                <div class="filtro">
                    <h2>Por fecha</h2>
                    <img class="filtro-fecha" src="./assets/img/iconos/fechas.svg" alt="">
                    <div class="fechas-filtro">
                        <div class="inicio">
                            <label for="fecha_inicio">Fecha apertura</label>
                            <input id="fecha_inicio" type="date">
                        </div>
                        <div class="fin">
                            <label for="fecha_fin">Fecha cierre</label>
                            <input id="fecha_fin" type="date">
                        </div>
                    </div>
                </div>
            </div>
            <div class="parte2-filtros">
                <div class="filtro">
                    <h2>Por equipo</h2>
                    <img class="filtro-equipo" src="./assets/img/iconos/equipos.svg" alt="">
                </div>
            </div>
            <div class="parte3-filtros">
                <div class="filtro">
                    <h2>Por dirección</h2>
                    <img class="filtro-direccion" src="./assets/img/iconos/direcciones.svg" alt="">
                    <div class="lista-direcciones">
                        <p class="opcion-direccion">Regidores</p>
                        <p class="opcion-direccion">Presidencia municipal</p>
                        <p class="opcion-direccion">Secretaria del ayuntamiento</p>
                        <p class="opcion-direccion">Oficialia mayor</p>
                        <p class="opcion-direccion">Tesorería mayor</p>
                        <p class="opcion-direccion">Dirección general de recursos jurídicos</p>
                        <p class="opcion-direccion">Dirección general de servicios públicos</p>
                        <p class="opcion-direccion">Dirección general de desarrollo urbano y medio</p>
                        <p class="opcion-direccion">Contraloría municipal</p>
                        <p class="opcion-direccion">Policía municipal de Colima</p>
                        <p class="opcion-direccion">Dirección general de desarrollo económico, social y humano</p>
                        <p class="opcion-direccion">Dirección general de obras públicas</p>
                        <p class="opcion-direccion">Jubilados y pensionados</p>
                        <p class="opcion-direccion">Organismos autónomos</p>
                    </div>
                </div>
                <div class="filtro">
                    <h2>Por departamento</h2>
                    <img class="filtro-departamento" src="./assets/img/iconos/departamentos.svg" alt="">
                    <div class="lista-departamentos">
                        <p class="administracion">Administración</p>
                        <p class="soporte_tecnico">Soporte técnico</p>
                        <p class="redes">Redes</p>
                    </div>
                </div>
            </div>
        </div>
        <button>Aplicar filtros</button>
    </div>
</div>

<?= $footer ?>