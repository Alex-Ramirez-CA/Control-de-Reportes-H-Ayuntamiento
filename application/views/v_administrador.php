<?= $head; ?>

<?= $nav; ?>

<div class="container">
    <!-- Columna para los reportes pendientes -->
    <div class="pendientes-filtro">
        <div class="titulo-pendiente">
            <p class="cantidad-reportes"><?= empty($pendientes) ? '0' : count($pendientes); ?></p>
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
                                    <b><h5>Folio</h5></b>
                                    <p><?= $item->id_incidencia;?></p>
                                </div>
                            <div class="fecha">
                                <b><h5>Creado</h5></b>
                                <p><?=  date("d/m/Y", strtotime($item->fecha_apertura)); ?></p>
                            </div>
                            <div class="opciones-tecnico">
                                <button class="ver" idReporte="<?= $item->id_incidencia;?>">Ver</button>
                                <button class="atender" idReporte="<?= $item->id_incidencia;?>" titulo="<?= $item->titulo;?>">Atender</button>
                            </div>
                        </div>
                        <div class="tecnico-departamento">
                                <div class="nom-tecnicos">
                                    <figcaption>
                                        <p class="nombre-tecnicos">Por asignar</p>
                                    </figcaption>
                                    <img src="<?=base_url('assets/img/iconos/tecnicos.svg')?>" alt="">
                                </div>
                                <div class="nom-departamentos">
                                    <figcaption>
                                        <p class="nombre-departamentos">Se asigno a </b><?= $item->departamento; ?></p>
                                    </figcaption>
                                    <img src="<?=base_url('assets/img/iconos/departamentos.svg')?>" alt="">
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