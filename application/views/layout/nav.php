<nav class="menu">
    <nav class="navbar navbar-light" id="navbar">
        <div class="col-6 p-0">
            <a class="navbar-brand p-0 m-0" href="#">Ayuntamiento de Colima</a>
        </div>
        <div class="col-6 text-right">
            <div class="row d-inline-block text-center">  
                <div class="btn-group align-items-center">
                    <p class="pr-2"> <?= "Bienvenido ".$this->session->nombre?> </p>
                    <button id="btn-cerrar" type="button" class="btn pr-2 btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    
                    <div class="dropdown-menu pull-right text-center mr-3">
                        <p class="dropdown-header py-1"><?= $this->session->nombre." ".$this->session->apellido_paterno." ".$this->session->apellido_materno;?></p>
                        <p class="dropdown-header py-1"><?= $this->session->email ?></p>
                        <div class="dropdown-divider"></div>
                            <a class="dropdown-item py-1" href="<?= base_url('login/logout') ?>">Cerrar sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        <a class="navbar-brand"><?= strtoupper($this->session->rol_nombre); ?></a>
        <form class="form-inline mt-2">
            <div class="opciones">
                <button class=" <?= $this->uri->segment(1) == 'administrador' ? 'visible' : 'invisible'; ?> btn my-2 my-sm-0 mr-2" type="submit">Administración</button>
                <button class="btn my-2 my-sm-0 mr-2" type="submit">Crear reporte</button>
                <button class="btn my-2 my-sm-0" type="submit">Mis reportes</button>
            </div>
            <input name="search" id="search" class="form-control ml-2 mr-2" type="search" placeholder="Buscar reporte" aria-label="Search">
            <button class="enviar btn btn-outline-success my-2 my-sm-0" type="submit" >Buscar</button>
        </form>
    </nav>

    <hr>  
</nav>
