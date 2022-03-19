<?= $head ?>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh">
            <div class="col-lg-4 col-md-6 col-sm-7 text-center">
                 <form action="<?= base_url('login/validar') ?>" method="POST" id="frm_login">
                    <div class="form-group pb-2">
                        <h1>Inicio de sesión</h1>
                    </div>
                    <div class="form-group pb-2" id="email"> 
                        <label for="email">Correo electrónico</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Ingrese su email">
                        <div class="invalid-feedback">
                            
                        </div>
                    </div>
                    <div class="form-group pb-2" id="password">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Ingrese su contraseña">
                        <div class="invalid-feedback">
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary form-control">Ingresar</button>
                    </div>
                    <div class="form-group" id="alert"></div>
                </form>
            </div>
        </div>
    </div>
    <a href="<?= base_url('login/logout') ?>">Cerrar Sesion</a>
<?= $footer ?>