<?= $head; ?>

<?= $nav; ?>

<div class="container">
    <div class="row mt-4 justify-content-center">
        <div class="col-6" id="titulo-pendiente">
            <h3>Reportes pendientes</h3>
        </div>

        <div class="col-6" id="titulo-proceso">
            <h3>Reportes en proceso</h3>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-6" id="columna-pendiente">
        <?php foreach($en_proceso as $item): ?>
            <div class="card" >
                <div class="card-body">
                    <div class="texto-medio">
                        <h5><?= $item->titulo; ?></h5>
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

        <div class="col-6" id="columna-proceso">
            <div class="card" >
                <div class="card-body">
                    <div class="texto-medio">
                        <h5>Impresora sin tinta</h5>
                        <p class="atiende">Atendido por Carlos Alejandro</p>                        
                        <p class="departamento">Departamento: Soporte técnico</p>                        
                    </div>
                    <div class="fecha">
                        <h5>Creado</h5>
                        <p>25/10/2021</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $footer ?>