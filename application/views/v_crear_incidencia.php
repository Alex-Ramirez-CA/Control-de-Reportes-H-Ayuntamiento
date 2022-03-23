<?= $head ?>
<?= $nav ?>
    
    <div class="container-Login">
        <div class="row justify-content-center align-items-center" style="height: 100vh">
            <div class="col-3 text-center">
                 <form action="<?= base_url('cliente/guardar_incidencia') ?>" method="POST" id="frm_login">
                    <div class="form-group pb-2">
                        <h1>Ingresar datos de reporte</h1>
                    </div>
                    <div class="form-group pb-2" id="titulo"> 
                        <label for="titulo">Titulo</label>
                        <input type="text" name="titulo" class="form-control" id="titulo" placeholder="Ingrese su email">
                        <div class="invalid-feedback">
                            
                        </div>
                    </div>
                    <div class="form-group pb-2" id="descripcion">
                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" cols="30" rows="10"></textarea>
                        <div class="invalid-feedback">
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary form-control">Guardar</button>
                    </div>
                    <div class="form-group" id="alert"></div>
                </form>
            </div>
        </div>
    </div>
   
<!-- <?= $footer ?> -->