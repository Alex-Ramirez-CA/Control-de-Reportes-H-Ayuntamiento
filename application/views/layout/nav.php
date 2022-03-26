<header class="menu">
    <!-- Segunda parte (parte de abajo) del menú de opciones -->
    <div class="parte2">
        <a class="navbar-brand m-0" href="<?= base_url($this->session->rol_nombre) ?>"><img class="logo-nav" src="<?= base_url('assets/img/logotipos/logo_ayto1-01.png');?>" alt=""></a>
            <nav class="navbar navbar-light p-0">
                <form class="form-inline mt-2" autocomplete="off">
                    <div class="opciones">
                        <a class=" <?= $this->uri->segment(1) == 'administrador' ? 'visible' : 'invisible'; ?> btn my-2 my-sm-0 mr-2" type="submit">Administración</a>
                        <a class="btn my-2 my-sm-0 mr-2" href="cliente/agregar_incidencia">Crear reporte</a>
                        <a class="btn my-2 my-sm-0 mr-2" href="<?= base_url($this->session->rol_nombre) ?>">Mis reportes</a>
                    </div>
                    <div class="autocompletar">
                        <input name="search" id="search" class="form-control mr-2" type="search" placeholder="Buscar reporte" aria-label="Search">                        
                        <div id="opciones-buscar">
                            
                        </div>
                    </div>
                    
                    
                    <div class="btn-group align-items-center pull-right">
                        <p style="color: #006E95;">A</p>
                        <button id="btn-cerrar" type="button" class="btn p-0 pr-2 pl-2 btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                                        
                        <div class="dropdown-menu">
                            <p class="dropdown-header py-1"><?=$this->session->nombre." ".$this->session->apellido_paterno." ".$this->session->apellido_materno?></p>
                            <p class="dropdown-header py-1"><?= $this->session->email ?></p>
                            <p class="dropdown-header py-1">Registrado como <?= strtoupper($this->session->rol_nombre); ?></p>
                            <div class="dropdown-divider"></div>
                                <a class="dropdown-item py-1" href="<?= base_url('login/logout') ?>">Cerrar sesión</a>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </nav>   
    </div>
</header>

