<?= $head; ?>

<?= $nav; ?>

<div class="container" style="width: 1000px;">
    <div class="row mt-4 justify-content-center" style="width: 1000px;">
        <div class="col-4 text-center border">
            <h3>Reportes por hacer</h3>
            <?php foreach($pendientes as $item): ?>
                <p><?= $item->id_incidencia; ?></p>
                <p><?= $item->titulo; ?></p>
                <p><?= $item->fecha_apertura; ?></p>
            <?php endforeach; ?>
        </div>

        <div class="col-4 offset-2 text-center border">
            <h3>Reportes en proceso</h3>
            <?php foreach($en_proceso as $item): ?>
                <p><?= $item->id_incidencia; ?></p>
                <p><?= $item->titulo; ?></p>
                <p><?= $item->fecha_apertura; ?></p>
                <p><?= $item->departamento; ?></p>
                <p><?= $item->encargado; ?></p>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="row mt-4 justify-content-center" style="width: 1000px;">
        <div class="col-4 text-center border" style="height: 400px">
            <h7>Aqui se ponen los reportes por hacer</h7>
        </div>

        <div class="col-4 offset-2 text-center border" style="height: 400px">
            <h7>Aqui se ponen los reportes en proceso</h7>
        </div>
    </div>
</div>

<?= $footer ?>