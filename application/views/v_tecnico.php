<?= $head; ?>

<?= $nav; ?>

<div class="container-tecnico">
    <!-- Columna de los reportes pendientes -->
    <div class="pendientes-filtro">
        <div class="titulo-pendiente">
            <h3><b>Reportes pendientes</b></h3>
        </div>
        <div class="columna-tecnico">
            <?php 
                if (empty($pendientes)) {
            ?>
                    <img class="contenido-vacio-cliente" src="<?= base_url('assets/img/logotipos/flor.png');?>" alt="" width="150">
            <?php 
                }else{
                    foreach($pendientes as $item):
            ?>
                    <div class="card-tecnico" idCard="<?= $item->id_incidencia;?>">
                        <div class="card-title">
                            <b><h5> <?= $item->titulo; ?></h5></b>
                        </div>
                        <div class="card-body-tecnico">
                            
                            <div class="fecha">
                                <b><h5>Creado</h5></b>
                                <p><?=  date("d/m/Y", strtotime($item->fecha_apertura)); ?></p>
                            </div>
                            <div class="opciones-tecnico">
                                <button class="ver" idReporte="<?= $item->id_incidencia;?>">Ver</button>
                                <button class="atender" idReporte="<?= $item->id_incidencia;?>" titulo="<?= $item->titulo;?>">Atender</button>
                            </div>

                        </div>
                    </div>
            <?php 
                    endforeach; 
                }
            ?>    
        </div>
    </div>

    <!-- Columna de los reportes pendientes -->
    <div class="proceso-filtro">
        <div class="titulo-proceso">
            <h3><b>Reportes en proceso</b></h3>
        </div> 
        <div class="columna-tecnico">
            <?php 
                if (empty($en_proceso)) {
            ?>
                    <img class="contenido-vacio-cliente" src="<?= base_url('assets/img/logotipos/flor.png');?>" alt="" width="150">
            <?php 
                }else{
                    foreach($en_proceso as $item):
            ?>
                        <div class="card-tecnico"  idCard="<?= $item->id_incidencia;?>">
                            <div class="card-title">
                                <b><h5><?= $item->titulo; ?></h5></b>
                            </div>
                            <div class="card-body-tecnico">
                            
                                <div class="fecha">
                                    <b><h5>Creado</h5></b>
                                    <p><?=  date("d/m/Y", strtotime($item->fecha_apertura)); ?></p>
                                </div>
                                <div class="opciones-tecnico">
                                    <button class="ver" idReporte="<?= $item->id_incidencia;?>">Ver</button>
                                    <button class="unirme" idReporte="<?= $item->id_incidencia;?>" titulo="<?= $item->titulo;?>">Unirme</button>
                                </div>

                            </div>
                        </div>
            <?php 
                    endforeach; 
                }    
            ?>
        </div>
    </div>

    <!-- Columna de los reportes pendientes -->
    <div class="finalizados-filtro">
        <div class="titulo-finalizado">
            <h3><b>Reportes finalizados</b></h3>
        </div>

        <div class="columna-tecnico">
            <?php 
                if (empty($finalizados)) {
            ?>
                    <img class="contenido-vacio-tecnico" src="<?= base_url('assets/img/logotipos/flor.png');?>" alt="" width="150">
            <?php 
                }else{
                    foreach($finalizados as $item):
            ?>
                        <div class="card-tecnico"  idCard="<?= $item->id_incidencia;?>">
                            <div class="card-title">
                                <b><h5><?= $item->titulo; ?></h5></b>
                            </div>
                            <div class="card-body-tecnico">
                            
                                <div class="fecha">
                                    <b><h5>Creado</h5></b>
                                    <p><?=  date("d/m/Y", strtotime($item->fecha_apertura)); ?></p>
                                </div>
                                <div class="opciones-tecnico">
                                    <button class="ver" idReporte="<?= $item->id_incidencia;?>">Ver</button>
                                    <button class="reabrir" idReporte="<?= $item->id_incidencia;?>" titulo="<?= $item->titulo;?>">Reabrir</button>
                                </div>

                            </div>
                        </div>
            <?php 
                    endforeach; 
                }    
            ?>
        </div>    
    </div>
    

</div>

<div class="mensaje">
    <div class="contenedor-mensaje">
        <p class="cerrar-mensaje-tecnico">x</p>
        <h2>¿Qué fue lo que se hizo?</h2>
        <div class="mensaje-comentario">
            <div class="texto-comentario">
                <h3 class="titulo-reporte-mensaje"></h3>
                <textarea name="comentario-tecnico" id="comentario-tecnico" cols="30" rows="10"></textarea>
            </div>
            <div class="respuestas-rapidas">
                <button>El problema quedó completamente solucionado</button>
                <button>Me gustaría ayudar a solucionar el problema</button>
                <button>El día de hoy comenzaré a darle solución al reporte</button>
                <button>Ya quedó completamente solucionado el problema</button>
            </div>
        </div>
        <button class="enviar-comentario">Enviar comentario</button>
    </div>
</div>

<?= $footer ?>