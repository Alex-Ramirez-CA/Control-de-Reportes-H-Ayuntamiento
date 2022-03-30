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
                    <div class="card-filtro" idCard="<?= $item->id_incidencia;?>">
                        <div class="card-title-filtro">
                            <h5> <?= $item->titulo; ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="fecha-filtro">
                                <b><h5>Creado</h5></b>
                                <p><?= date("d/m/Y", strtotime($item->fecha_apertura)); ?></p>
                            </div>
                            <div class="opciones-filtro">
                                <p class="btn-comentar-filtro">Comentar</p>
                                <p class="btn-asignar-filtro">Asignar</p> 
                                <p class="btn-enviar-filtro">Enviar</p>  
                            </div>
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
                <h4 class="titulo-reporte-filtro">Poblemas con mi impresora</h4>
                <div class="folio-fecha-filtro">
                    <h4>Folio: 122121</h4>
                    <h4>Creado: 22/11/2020</h4>
                </div>
                <textarea name="descripcion-reporte" id="descripcion-reporte" cols="50" rows="10"></textarea>
        </div>
        <div class="guardar-cambios">
            <a href="#">Guardar cambios</a>
        </div>
    </div>

</div>

<?= $footer ?>