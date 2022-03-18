<?= $head ?>
    <div class="container">
        <div class="row justify-content-lg-center align-items-lg-center">
            <div class="col-lg-6 align-self-center">
                 <form action="<?= base_url('login/validar') ?>" method="POST" id="frm_login">
                    <div class="form-group">
                        <h1>Login</h1>
                    </div>
                    <div class="form-group" id="email">
                        <label for="email">Correo</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Ingrese su email">
                        <div class="invalid-feedback">
                            
                        </div>
                    </div>
                    <div class="form-group" id="password">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Ingrese su contraseña">
                        <div class="invalid-feedback">
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary form-control">Submit</button>
                    </div>
                    <div class="form-group" id="alert"></div>
                </form>
            </div>
        </div>
    </div>
    <a href="<?= base_url('login/logout') ?>">Cerrar Sesion</a>
<?= $footer ?>