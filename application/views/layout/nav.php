<header class="menu">
    <!-- Primera parte (parte de arriba) del menú de opciones -->
    <div class="parte1">
        <h1 class="navbar-brand p-0 m-0" style="color: #006E95;" id="menu-titulo" href="#">Control de reportes internos del H. Atuntamiento de Colima</h1>
        <div>
            <nav class="navbar navbar-light p-0">
                <div class="btn-group align-items-center">
                    <p class="pr-2" style="color: #006E95;">Bienvenido <?=$this->session->nombre?> </p>
                    <button id="btn-cerrar" type="button" class="btn p-0 pr-2 pl-2 btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                            
                    <div class="dropdown-menu pull-right text-center">
                        <p class="dropdown-header py-1">Registrado como <?= strtoupper($this->session->rol_nombre); ?></p>
                        <p class="dropdown-header py-1"><?= $this->session->email ?></p>
                        <div class="dropdown-divider"></div>
                            <a class="dropdown-item py-1" href="<?= base_url('login/logout') ?>">Cerrar sesión</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!-- Segunda parte (parte de abajo) del menú de opciones -->
    <div class="parte2">
        <a class="navbar-brand m-0" href="#">Logo de Ayuntamiento de Colima</a>
            <div>
                <form class="form-inline mt-2" autocomplete="off">
                    <div class="opciones" >
                        <button class=" <?= $this->uri->segment(1) == 'administrador' ? 'visible' : 'invisible'; ?> btn my-2 my-sm-0 mr-2" type="submit">Administración</button>
                        <button class="btn my-2 my-sm-0 mr-2" type="submit">Crear reporte</button>
                        <button class="btn my-2 my-sm-0 mr-2" type="submit">Mis reportes</button>
                    </div>
                    <div class="autocompletar">
                        <input name="search" id="search" class="form-control" type="search" placeholder="Buscar reporte" aria-label="Search">                        
                        <div id="opciones-buscar">
                            
                        </div>
                    </div>
                </form>
            </div>   
    </div>
</header>
