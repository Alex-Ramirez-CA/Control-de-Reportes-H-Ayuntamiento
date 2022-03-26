<?= $head ?>

    <div class="container-login">
        <h1 class="titulo-pagina">Control de reportes internos H. Ayuntamiento de Colima</h1>
        <div class="formulario-ingreso">
            <form action="<?= base_url('login/validar') ?>" method="POST" id="frm_login">
                <!-- Titulo del formulario -->
                <div class="form-group" id="titulo-login">
                    <img class="logo-login" src="<?= base_url('assets/img/logotipos/logo_ayto1-01.png');?>" alt="">
                    <h3>Inicio de sesión</h3>
                </div>
                <!-- Parte del formulario donde se coloca el correo-->
                <div class="form-group" id="email"> 
                    <input type="email" name="email" class="form-control" id="email" placeholder="Ingrese su email">
                    <div class="invalid-feedback">
                                
                    </div>
                </div>
                <!-- Parte del formulario donde se coloca la contraseña-->
                <div class="form-group" id="password">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña">
                    <div class="invalid-feedback">
                                
                    </div>
                </div>
                <!-- Boton para enviar los datos del formulario -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary form-control boton-ingreso">Ingresar</button>
                </div>
                <!-- Div para colocar la alerta en caso de error -->
                <div class="form-group" id="alert"></div>

            </form>

        </div>
        
    </div>
   
<?= $footer ?>