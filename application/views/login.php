<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap/bootstrap.min.css');?>">
</head>
<body>
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
<script src="<?= base_url('assets/js/jquery/jquery-3.6.0.min.js');?>"></script>
<script src="<?= base_url('assets/js/bootstrap/bootstrap.min.js');?>"></script>
<script src="<?= base_url('assets/js/Auth/login.js');?>"></script>
</body>
</html>