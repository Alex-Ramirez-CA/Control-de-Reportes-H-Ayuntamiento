<?= $head; ?>

<?= $nav; ?>

<div class="container-tecnico">
    <!-- Columna de los reportes en proceso -->
    <div class="proceso-atendiendo">
        <div class="titulo-proceso">
            <h3><b>Reportes en proceso</b></h3>
        </div>
        
        <div class="columna-atendiendo"> 
            <?php 
                if (empty($en_proceso)) {
            ?>
                    <img class="contenido-vacio-cliente" src="<?= base_url('assets/img/logotipos/flor.png');?>" alt="" width="150">
            <?php 
                }else{
                    foreach($en_proceso as $item):
            ?>
                        <div class="card-atendiendo" idCard="<?= $item->id_incidencia;?>">
                            <div class="card-title">
                                <b><h5><?= $item->titulo; ?></h5></b>
                            </div>
                            <div class="card-body">
                                <div class="fecha">
                                    <b><h5>Creado</h5></b>
                                    <p><?= date("d/m/Y", strtotime($item->fecha_apertura)); ?></p>
                                </div>
                                <div class="opciones-tecnico">
                                    <button class="ver" idReporte="<?= $item->id_incidencia;?>">Ver</button>
                                    <button class="finalizar" idReporte="<?= $item->id_incidencia;?>" titulo="<?= $item->titulo;?>">Finalizar</button>
                                </div>
                            </div>
                        </div>
            <?php 
                    endforeach; 
                }    
            ?>   
        </div>

    </div>
    
    <!-- Columna de los reportes finalizados -->
    <div class="finalizados-atendiendo">
        <div class="titulo-finalizado">
            <h3><b>Reportes finalizados</b></h3>
        </div>
        
        <div class="columna-atendiendo"> 
            <?php 
                if (empty($finalizados)) {
            ?>
                    <img class="contenido-vacio-cliente" src="<?= base_url('assets/img/logotipos/flor.png');?>" alt="" width="150">
            <?php 
                }else{
                    foreach($finalizados as $item):
            ?>
                        <div class="card-atendiendo" idCard="<?= $item->id_incidencia;?>">
                            <div class="card-title">
                                <b><h5><?= $item->titulo; ?></h5></b>
                            </div>
                            <div class="card-body">
                                <div class="fecha">
                                    <b><h5>Creado</h5></b>
                                    <p><?= date("d/m/Y", strtotime($item->fecha_apertura)); ?></p>
                                </div>
                                <div class="opciones-tecnico">
                                    <button class="ver" idReporte="<?= $item->id_incidencia;?>">Ver</button>
                                    <button class="reabrir-atendido" idReporte="<?= $item->id_incidencia;?>" titulo="<?= $item->titulo;?>">Reabrir</button>
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
                <button>El problema quedo completamente solucionado</button>
                <button>Me gustaria ayudar a solucionar el problema</button>
                <button>El día de hoy comenzaré a darle solución al reporte</button>
                <button>Ya quedo completamente solucionado el problema</button>
            </div>
        </div>
        <button class="enviar-comentario">Enviar comentario</button>
    </div>
</div>

<?= $footer ?>