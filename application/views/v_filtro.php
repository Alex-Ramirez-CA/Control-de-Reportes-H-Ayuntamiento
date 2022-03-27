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
                    echo 'Cuanto vacio';
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
                                <p><?= $item->fecha_apertura; ?></p>
                            </div>
                        </div>
                    </div>
            <?php 
                    endforeach; 
                }
            ?>   
        </div>
    </div>

    <!-- Columna de los reportes en proceso -->
    <div class="proceso">
        <div class="titulo-proceso">
            <h3><b>Nombre del reporte</b></h3>
        </div>
        

    </div>

</div>

<?= $footer ?>