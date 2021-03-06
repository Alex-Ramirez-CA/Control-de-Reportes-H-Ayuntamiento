<header class="menu">
    <!-- Segunda parte (parte de abajo) del menú de opciones -->
    <div class="parte2">
        <a class="navbar-brand m-0" href="<?= base_url($this->session->rol_nombre) ?>"><img class="logo-nav" src="<?= base_url('assets/img/logotipos/logo_ayto1-01.png');?>" alt=""></a>
            <nav class="navbar navbar-light p-0">
                <form class="form-inline mt-2" autocomplete="off">
                    <div class="opciones">
                        <a style="display: <?= $this->uri->segment(1) == 'administrador' ? 'inline-block' : 'none'; ?>;" class="btn my-2 my-sm-0 mr-2" id="btn-filtros" href="#">Filtros</a>
                        <div class="administracion" style="display: <?= $this->session->rol_nombre == 'administrador' ? 'inline-block' : 'none'; ?>;">
                            <a class="btn my-2 my-sm-0 mr-2" href="#">Administración</a>
                            <div class="opciones_administracion">
                                <a href="<?= base_url('usuarios') ?>">Agregar usuario</a> 
                                <a class="opcion_lista_usuarios" href="<?= base_url('usuarios/lista_usuarios') ?>">Listar usuarios</a> 
                                <a href="<?= base_url('equipos') ?>">Agregar equipo</a> 
                                <a href="<?= base_url('equipos/lista_equipos') ?>">Listar equipos</a>  
                            </div>
                        </div>                        
                        <a style="display: <?= $this->session->rol_nombre == 'tecnico' ? 'inline-block' : 'none'; ?>;" class="btn my-2 my-sm-0 mr-2" href="<?=base_url('atendiendo');?>">Atendiendo</a>
                        <a class="btn my-2 my-sm-0 mr-2" href="<?=base_url('reporte/agregar_incidencia');?>">Crear reporte</a>
                        <a class="btn my-2 my-sm-0 mr-2 btn-misreportes" href="<?=base_url('reporte');?>">Mis reportes</a>
                    </div>
                    <div class="autocompletar">
                        <div class="buscador_menu_nav" style="display: <?= $this->uri->segment(2) == 'agregar_incidencia' || $this->uri->segment(2) == 'editar_usuario' || $this->uri->segment(2) == 'editar_equipo' ? 'none' : 'flex'; ?>;">
                            <label for="search_usuario"><img src="<?= base_url('assets/img/iconos/lupa.svg');?>" alt=""></label>
                            <input name="search" id="search" url="<?= $this->uri->segment(1);?>" class="form-control" type="search" autocomplete="off" aria-label="Search">
                        </div>                        
                        <div id="opciones-buscar">
                            
                        </div>
                    </div>
                    
                    <div class="usuario-icono">
                        <p style="color: #fff;"><?= substr($this->session->nombre, 0, 1).substr($this->session->apellido_paterno, 0, 1)?></p>
                        <div class="menu-cerrar-sesion">
                            <p><?=$this->session->nombre." ".$this->session->apellido_paterno." ".$this->session->apellido_materno?></p>
                            <p><?= $this->session->email ?></p>
                            <p>Registrado como <?= strtoupper($this->session->rol_nombre); ?></p>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item py-1" href="<?= base_url('login/logout') ?>">Cerrar sesión</a>
                        </div>
                    </div>
                </form>
            </nav>   
    </div>
</header>


