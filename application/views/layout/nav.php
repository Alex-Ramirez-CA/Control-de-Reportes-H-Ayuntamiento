
<nav class="navbar navbar-light mt-3 mr-3 ml-3">
    <div class="col-6">
        <a class="navbar-brand " href="#"><img src="https://www.colima.gob.mx/portal/wp-content/uploads/2021/02/logo_institucional.png" alt=""></a>
    </div>
    <div class="col-6 text-right">
        <div class="row d-inline-block text-center">  
            <div class="btn-group align-items-center">
                <h6 class="pr-2"> <?= "Bienvenido ".$this->session->nombre?> </h6>
                <button type="button" class="btn pr-2 btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                
                <div class="dropdown-menu pull-right text-center mr-3">
                    <h6 class="dropdown-header"><?= $this->session->nombre." ".$this->session->apellido_paterno." ".$this->session->apellido_materno;?></h6>
                    <h6 class="dropdown-header"><?= $this->session->email ?></h6>
                    <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?= base_url('login/logout') ?>">Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </div>
            
        </div>
    </div>
    <a class="navbar-brand ml-4"><?= strtoupper($this->session->rol_nombre); ?></a>
    <form class="form-inline">
        <button class=" <?= $this->uri->segment(1) == 'administrador' ? 'visible' : 'invisible'; ?> btn btn-outline-success my-2 my-sm-0 mr-4" type="submit">Administración</button>
        <button class="btn btn-outline-success my-2 my-sm-0 mr-4" type="submit">Crear reporte</button>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Mis reportes</button>
        <input name="search" id="search" class="form-control ml-4 mr-2" type="search" placeholder="Buscar reporte" aria-label="Search">
        <button class="enviar btn btn-outline-success my-2 my-sm-0" id="enviar" type="submit" >Buscar</button>
    </form>
</nav>
<hr>  