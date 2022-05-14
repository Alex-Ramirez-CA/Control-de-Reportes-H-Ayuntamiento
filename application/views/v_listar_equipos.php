<?= $head; ?>
<?= $nav; ?>

<div class="container_lista_usuarios">
    <div class="filtros_lista_usurios">
        <h1 class="titulo_filtros_lista_usurios">Aplicar filtros</h1>
        <div class="filtro_dependencia_usuarios">
            <div class="titulo_filtro_usuarios" idFiltroUsuario="1">
                <h2>Dependencia</h2>
                <div class="marcar_filtro_seleccionado">

                </div>
            </div>
            <div class="lista_dependencias_usuarios">
                <?php 
                    foreach($dependencias as $item):
                ?>
                        <p class="opcion_dependencia_usuarios" idDependencia="<?= $item->id_dependencia;?>"><?= $item->nombre; ?></p>
                <?php 
                    endforeach; 
                       
                ?>
            </div>
        </div>
        <div class="filtro_direccion_usuarios">
            <div class="titulo_filtro_usuarios" idFiltroUsuario="2">
                    <h2>Dirección</h2>
                <div class="marcar_filtro_seleccionado">
                    
                </div>
            </div>
            <div class="lista_direcciones_usuarios">
                <?php 
                    foreach($direcciones as $item):
                ?>
                    <p class="opcion_direccion_usuarios" idDireccion="<?= $item->id_direccion; ?>"><?= $item->nombre; ?></p>
                <?php 
                    endforeach;    
                ?>
            </div>
        </div>
        <div class="filtro_status_usuarios">
            <div class="titulo_filtro_usuarios" idFiltroUsuario="5">
                    <h2>Estatus del equipo</h2>
                <div class="marcar_filtro_seleccionado">
                    
                </div>
            </div>
            <div class="lista_status_usuarios">
                <p class="opcion_status_usuarios" status="1">Activos</p>
                <p class="opcion_status_usuarios" status="0">De baja</p>
            </div> 
        </div>
        <div class="filtro_tipo_equipo">
            <div class="titulo_filtro_usuarios" idFiltroUsuario="6">
                    <h2>Tipo de equipo</h2>
                <div class="marcar_filtro_seleccionado">
                    
                </div>
            </div>
            <div class="lista_tipo_equipo">
                <p class="opcion_tipo_equipo" tipoEquipo="PC">Computadora</p>
                <p class="opcion_tipo_equipo" tipoEquipo="Impresora">Impresora</p>
            </div> 
        </div>
        <button class="aplicar_filtros_usuarios">Aplicar filtros</button>
    </div>
    <div class="ocultar_filtros">
        <img src="<?=base_url('assets/img/iconos/desplegar.svg')?>" alt="">
    </div>
    <div class="lista_usuarios">
        <table class="table tabla_lista_usuarios">
            <thead>
                <tr>
                    <th scope="col">Dirección IP</th>
                    <th scope="col">Nombre del equipo</th>
                    <th scope="col">Tipo de equipo</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody class="tbody_lista_equipos">
                
            </tbody>
        </table>
    </div>
</div>

<?= $footer ?>