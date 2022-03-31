<?= $head; ?>

<?= $nav; ?>

<div class="contenedor-filtro">

    <!-- Columna donde se muestran todos los reportes -->
    
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
                    <div class="card-filtro">
                        <div class="card-title-filtro">
                            <h5> <?= $item->titulo; ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="fecha-filtro">
                                <b><h5>Creado</h5></b>
                                <p><?= date("d/m/Y", strtotime($item->fecha_apertura)); ?></p>
                            </div>
                            <div class="asignar-departamento">
                                <button class="administracion">Administración</button>
                                <button class="soporte-tecnico">Soporte técnico</button>
                                <button class="redes">Redes</button>
                            </div>
                        </div>
                        <div class="opciones-filtro">
                                <p class="btn-ver-filtro" idReporte="<?= $item->id_incidencia;?>">Ver</p>
                                <p class="btn-comentar-filtro" idReporte="<?= $item->id_incidencia;?>">Comentar</p> 
                                <p class="btn-enviar-filtro" idReporte="<?= $item->id_incidencia;?>">Enviar</p>  
                        </div>
                    </div>
                    <form action="<?= base_url('filtro/asignar_departamento') ?>" method="POST" id="frm_login">
                        <!-- Titulo del formulario -->
                        <div class="form-group" id="asignar">
                        <input type="hidden" name="id_incidencia" value="<?= $item->id_incidencia;?>">
                        <input type="checkbox" name="soporte" id="soporte" value="1"> <label>Soporte técnico</label><br>
                        <input type="checkbox" name="redes" id="redes" value="2"> <label for="cbox2">Redes</label>
                        <input type="checkbox" name="administracion" id="administracion" value="3"> <label for="cbox2">Adminstración</label>
                        </div>
                        <!-- Boton para enviar los datos del formulario -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary form-control boton-enviar">Asignar</button>
                        </div>
                    </form>
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
                <h4 class="titulo-reporte-filtro">Titulo</h4>
                <div class="folio-fecha-filtro">
                    <h4 id="folio-reporte">Folio </h4>
                    <h4 id="fecha-reporte">Fecha de creación </h4>
                </div>
                <textarea name="descripcion-reporte" id="descripcion-reporte" cols="50" rows="10"></textarea>
                <button class="guardar-cambios">Guardar cambios</button>
        </div>
    </div>

</div>

<?= $footer ?>