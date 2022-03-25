<?= $head ?>

<div class="container-reporte">
    <div class="encabezado-reporte">
        
    </div>   
    <div class="reporte">
        <div class="datos-reporte">
            <h1>Datos generales del reporte</h1>
            <h2><?= $generales->titulo ?></h2>
            <h3><?= $generales->descripcion ?></h3> 
            <div class="fechas-reporte">
                <h3><?= $generales->fecha_apertura ?></h3>
                <h3><?= $generales->fecha_cierre ?></h3>
            </div>
            <h3><?= $generales->status ?></h3>
        </div>
        <div class="comentarios-reporte">
            <h1>Comentarios del reporte</h1>
            <div class="comentario">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet, dignissimos.</p>
                <div class="fecha-comentario">
                    <p>29/05/25</p>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $footer ?>