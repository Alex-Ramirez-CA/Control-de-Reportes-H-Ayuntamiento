<?= $head ?>

<div class="container-reporte">
    <div class="encabezado-reporte">
        
    </div>   
    <div class="reporte">
        <div class="datos-reporte">
            <h1>Datos generales del reporte</h1>
            <div class="titulo-status">
                <h2><?= $generales->titulo ?></h2>
                <h3 class="status">Status: <?= $generales->status ?></h3>
            </div>
            <div class="dir-dep">
                <h3><?= $generales->dependencia ?></h3>
                <h3><?= $generales->direccion ?></h3>
            </div>
            <h3>Descripción del reporte: <?= $generales->descripcion ?></h3> 
            <div class="fechas-reporte">
                <h3>Fecha de apertura: <?= $generales->fecha_apertura ?></h3>
                <h3>Fecha de cierre: <?= $generales->fecha_cierre ?></h3>
            </div>

            <div class="tabla-especificaciones">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Especificación</th>
                    <th scope="col">Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">Nombre</th>
                        <td><?= $generales->nombre ?></td>
                    </tr>
                    <tr>
                        <th scope="row">IP</th>
                        <td><?= $generales->direccion_ip ?></td>                        
                    </tr>
                    <tr>
                        <th scope="row">Marca</th>
                        <td><?= $generales->marca ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Sistema operativo</th>
                        <td><?= $generales->sistema_operativo ?></td>
                    </tr>
                    <tr>
                        <th scope="row">RAM</th>
                        <td><?= $generales->ram ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Disco duro</th>
                        <td><?= $generales->disco_duro ?></td>
                    </tr>
                </tbody>
                </table>
            </div>

        </div>
        <div class="comentarios-reporte">
            <h1>Comentarios del reporte</h1>
            <?php 
                if (empty($comentarios)) {
                    echo 'Cuanto vacio';
                }else{
                    foreach($comentarios as $item):
            ?>
            <div class="comentario">
                <p class="nombre-comentador"><?= $item->comentario_by; ?></p>
                <p><?= $item->comentario; ?></p>
                <div class="fecha-comentario">
                    <p><?= $item->fecha; ?></p>
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