<?= $head ?>
    
    <div class="container-Login">
        <div class="row justify-content-center align-items-center" style="height: 100vh">
            <div class="col-5 text-center">
                <form action="<?= base_url('cliente/guardar_incidencia') ?>" method="POST" id="frm_incidencia" enctype="multipart/form-data">
                    <div class="form-group pb-2">
                        <h1>Ingresar datos de reporte</h1>
                    </div>
                    <div class="form-group pb-2" id="titulo"> 
                        <label for="titulo">Titulo</label>
                        <input type="text" name="titulo" class="form-control" id="titulo" placeholder="Ingrese su email">
                        <?php if(form_error('titulo')):?>
                            <div class="alert alert-danger" role="alert"><?= form_error('titulo')?></div>
                        <?php endif;?>
                    </div>
                    <div class="form-group pb-2" id="descripcion">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" cols="30" rows="10"></textarea>
                        <?php if(form_error('descripcion')):?>
                            <div class="alert alert-danger" role="alert"><?= form_error('descripcion')?></div>
                        <?php endif;?>
                    </div>
                    <div class="form-group pb-2" id="archivo">
                        <input class="form-control" type="file" name="archivo">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary form-control">Guardar</button>
                    </div>
                    <div class="form-group" id="alert"></div>
                </form>
            </div>
        </div>
    </div>
   
<?= $footer ?>