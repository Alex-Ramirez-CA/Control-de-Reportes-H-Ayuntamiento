<?= $head; ?>

<?= $nav; ?>

<div class="container" rol="<?= $this->session->id_rol; ?>">
    <!-- Columna para los reportes pendientes -->
    <div class="pendiente">
        <div class="titulo-columna">
            <p class="cantidad-reportes-pendiente"></p>
            <h3><b>Reportes pendientes</b></h3>
        </div>
        <div class="columna-tripleta-pendiente">

        </div>
    </div>

    <div class="proceso">
        <div class="titulo-columna">
            <p class="cantidad-reportes-proceso"></p>
            <h3><b>Reportes en proceso</b></h3>
        </div>
        <div class="columna-tripleta-proceso">
            
        </div>
    </div>

    <div class="finalizado">
        <div class="titulo-columna">
            <p class="cantidad-reportes-finalizado"></p>
            <h3><b>Reportes finalizados</b></h3>
        </div>
        <div class="columna-tripleta-finalizado">
            
        </div>
    </div>

    
</div>
<?= $footer ?>