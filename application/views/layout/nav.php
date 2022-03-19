
<nav class="navbar navbar-light mt-3">
    <div class="col-6">
        <a class="navbar-brand" href="#"><img src="https://www.colima.gob.mx/portal/wp-content/uploads/2021/02/logo_institucional.png" alt=""></a>
    </div>
    <div class="col-6 text-right">
        <div class="row d-inline-block text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
            </svg>    
            <h6> <?= $this->session->nombre." ".$this->session->apellido_paterno." ".$this->session->apellido_materno;?> </h6>
            <a href="<?= base_url('login/logout') ?>">Cerrar Sesion</a>
        </div>
    </div>
    <a class="navbar-brand"><?= $this->session->rol ?></a>
    <form class="form-inline">
        <button class="btn btn-outline-success my-2 my-sm-0 mr-4" type="submit">Administración</button>
        <button class="btn btn-outline-success my-2 my-sm-0 mr-4" type="submit">Crear reporte</button>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Mis reportes</button>
        <input name="search" id="search" class="form-control ml-4 mr-2" type="search" placeholder="Buscar reporte" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
    </form>
</nav>
<hr>  