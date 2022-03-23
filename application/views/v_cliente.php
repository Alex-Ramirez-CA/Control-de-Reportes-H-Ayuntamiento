<?= $head; ?>

<?= $nav; ?>

<div class="container">

    <!-- Columna de los reportes en proceso -->
    
    <div class="pendiente">
        <div class="titulo-pendiente">
            <h3>Reportes pendientes</h3>
        </div>

        <div class="columna-pendiente">   
            <?php foreach($en_proceso as $item): ?>
                <div class="card">
                    <div class="card-title">
                        <h5><?= $item->titulo; ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="texto-medio">
                            <p class="atiende">Atendido por <?= $item->encargado; ?> </p>                        
                            <p class="departamento"><?= "Departamento: ".$item->departamento; ?></p>                        
                        </div>
                        <div class="fecha">
                            <h5>Creado</h5>
                            <p><?= $item->fecha_apertura; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>   
        </div>
    </div>

    <!-- Columna de los reportes en proceso -->
    <div class="proceso">
        <div class="titulo-proceso">
            <h3>Reportes en proceso</h3>
        </div>
        
        <div class="columna-proceso">   
            <?php foreach($en_proceso as $item): ?>
                <div class="card">
                    <div class="card-title">
                        <h5><?= $item->titulo; ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="texto-medio">
                            <p class="atiende">Atendido por <?= $item->encargado; ?> </p>                        
                            <p class="departamento"><?= "Departamento: ".$item->departamento; ?></p>                        
                        </div>
                        <div class="fecha">
                            <h5>Creado</h5>
                            <p><?= $item->fecha_apertura; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>   
        </div>

    </div>

</div>

<?= $footer ?>