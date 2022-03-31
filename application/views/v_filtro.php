<?= $head; ?>

<?= $nav; ?>

<div class="contenedor-filtro">

    <!-- Columna donde se muestran todos los reportes -->
    
    <div class="pendiente">
        <div class="titulo-pendiente">
            <h3><b>Reportes</b></h3>
        </div>

        <div class="columna-pendiente">

            <?php 
                if (empty($incidencias)) {
            ?>
                    <img class="contenido-vacio-cliente" src="<?= base_url('assets/img/logotipos/flor.png');?>" alt="" width="150">
            <?php 
                }else{
                    foreach($incidencias as $item):
            ?>
                    <div class="card-filtro">
                        <div class="card-title-filtro">
                            <h5> <?= $item->titulo; ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="fecha-filtro">
                                <b><h5>Creado</h5></b>
                                <p><?= date("d/m/Y", strtotime($item->fecha_apertura)); ?></p>
                            </div>
                            <div class="asignar-departamento">
                                <button class="administracion">Administración</button>
                                <button class="soporte-tecnico">Soporte técnico</button>
                                <button class="redes">Redes</button>
                            </div>
                        </div>
                        <div class="opciones-filtro">
                                <p class="btn-ver-filtro" idReporte="<?= $item->id_incidencia;?>">Ver</p>
                                <p class="btn-comentar-filtro" idReporte="<?= $item->id_incidencia;?>">Comentar</p> 
                                <p class="btn-enviar-filtro" idReporte="<?= $item->id_incidencia;?>">Enviar</p>  
                        </div>
                    </div>
            <?php 
                    endforeach; 
                }
            ?>   
        </div>
    </div>

    <!-- Columna para complementar reporte -->
    <div class="complementar-reporte">
        <div class="titulo-pendiente">
            <h3><b>Complementar reporte</b></h3>
        </div>

        <div class="columna-complementar-reporte">
                <h4 class="titulo-reporte-filtro">Titulo</h4>
                <div class="folio-fecha-filtro">
                    <h4 id="folio-reporte">Folio </h4>
                    <h4 id="fecha-reporte">Fecha de creación </h4>
                </div>
                <textarea name="descripcion-reporte" id="descripcion-reporte" cols="50" rows="10"></textarea>
                <button class="guardar-cambios">Guardar cambios</button>
        </div>
    </div>

</div>

<?= $footer ?>