<?= $head; ?>

<?= $nav; ?>

<div class="container-tecnico">
    <!-- Columna de los reportes pendientes -->
    <div class="pendientes-filtro">
        <div class="titulo-pendiente">
            <h3><b>Reportes pendientes</b></h3>
        </div>
        <div class="columna-filtro">
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
        <div class="columna-filtro">
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

        <div class="columna-filtro">
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

<?= $footer ?>