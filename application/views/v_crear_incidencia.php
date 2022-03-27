<?= $head ?>
<?= $nav ?>
    
    <div class="container-crear-incidencia">
        <div class="titulo-crear-reporte">
            <b><h1>Ingresar datos de reporte</h1></b>
        </div>
        <form action="<?= base_url('cliente/guardar_incidencia') ?>" method="POST" id="frm_incidencia" enctype="multipart/form-data">
            <div class="parte1-formulario">
                <div class="form-group pb-2" id="titulo"> 
                    <input type="text" name="titulo" class="form-control" id="titulo" placeholder="Ingrese un titulo">
                    <?php if(form_error('titulo')):?>
                        <div class="alert alert-danger" role="alert"><?= form_error('titulo')?></div>
                    <?php endif;?>
                </div>
                <div class="form-group pb-2" id="descripcion">
                    <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Ingrese una descripción al reporte" cols="30" rows="10"></textarea>
                    <?php if(form_error('descripcion')):?>
                        <div class="alert alert-danger" role="alert"><?= form_error('descripcion')?></div>
                    <?php endif;?>
                </div>
            </div>
            <div class="parte2-formulario">
                <div class="form-group pb-2" id="archivo">
                    <h2>Seleccione o arrastre el archivo</h2>
                    <input class="input-file" class="form-control" type="file" name="archivo" hidden>
                    <button class="btn-archivo">Elegir archivo</button>
                    <div id="preview"></div>
                </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary form-control boton-guardar-incidencia">Guardar</button>
                    </div>
                <div class="form-group" id="alert"></div>
            </div>
        </form>
   
<?= $footer ?>