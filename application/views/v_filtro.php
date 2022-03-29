<?= $head; ?>

<?= $nav; ?>

<div class="container">

    <!-- Columna de los incidencias pendientes -->
    
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
                    <div class="card" idCard="<?= $item->id_incidencia;?>">
                        <div class="card-title">
                            <h5> <?= $item->titulo; ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="texto-medio">
                                <p class="atiende"><b>Atendido por: </b>Por asignar</p>                        
                                <p class="departamento"><b>Departamento: </b>Por asignar</p>                        
                            </div>
                            <div class="fecha">
                                <h5>Creado</h5>
                                <p><?= date("d/m/Y", strtotime($item->fecha_apertura)); ?></p>
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

        </div>
    </div>

</div>

<?= $footer ?>