<?= $head; ?>

<?= $nav; ?>

<div class="container">
    <div class="row mt-4 justify-content-center">
        <div class="col-lg-4 col-md-5 col-sm-8" id="titulo-pendiente">
            <h3>Reportes pendientes</h3>
        </div>

        <div class="col-lg-4 col-md-5 col-sm-8 offset-lg-2 offset-md-1" id="titulo-proceso">
            <h3>Reportes en proceso</h3>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-4 col-md-5 col-sm-8" id="columna-pendiente">
            <div class="card" >
                <div class="card-body">
                    <div class="texto-medio">
                        <h5>Fallo de red</h5>
                        <p class="atiende">Atendido por Luis Gerardo</p>                        
                        <p class="departamento">Departamento: Soporte técnico</p>                        
                    </div>
                    <div class="fecha">
                        <h5>Creado</h5>
                        <p>20/05/2020</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-5 col-sm-8 offset-lg-2 offset-md-1" id="columna-proceso">
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