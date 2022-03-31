<header class="menu">
    <!-- Segunda parte (parte de abajo) del menú de opciones -->
    <div class="parte2">
        <a class="navbar-brand m-0" href="<?= base_url($this->session->rol_nombre) ?>"><img class="logo-nav" src="<?= base_url('assets/img/logotipos/logo_ayto1-01.png');?>" alt=""></a>
            <nav class="navbar navbar-light p-0">
                <form class="form-inline mt-2" autocomplete="off">
                    <div class="opciones">
                        <a class=" <?= $this->uri->segment(1) == 'administrador' ? 'visible' : 'invisible'; ?> btn my-2 my-sm-0 mr-2" href="#">Administración</a>
                        <a class="btn my-2 my-sm-0 mr-2" href="<?=base_url('reporte/agregar_incidencia');?>">Crear reporte</a>
                        <a class="btn my-2 my-sm-0 mr-2 btn-misreportes" href="<?=base_url('reporte');?>">Mis reportes</a>
                    </div>
                    <div class="autocompletar">
                        <input name="search" id="search" url="<?= $this->uri->segment(1);?>" class="form-control mr-2" type="search" placeholder="Buscar reporte" aria-label="Search">                        
                        <div id="opciones-buscar">
                            
                        </div>
                    </div>
                    
                    <div class="usuario-icono">
                        <p style="color: #fff;"><?= substr($this->session->nombre, 0, 1).substr($this->session->apellido_paterno, 0, 1)?></p>
                    </div>
                    <div class="menu-cerrar-sesion">
                        <p><?=$this->session->nombre." ".$this->session->apellido_paterno." ".$this->session->apellido_materno?></p>
                        <p><?= $this->session->email ?></p>
                        <p>Registrado como <?= strtoupper($this->session->rol_nombre); ?></p>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item py-1" href="<?= base_url('login/logout') ?>">Cerrar sesión</a>
                    </div>
                    
                </form>
            </nav>   
    </div>
</header>


