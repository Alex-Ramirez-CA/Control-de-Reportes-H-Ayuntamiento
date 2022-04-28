<?= $head; ?>
<?= $nav; ?>

<div class="container_lista_usuarios">
    <div class="formulario_agregar_usuario">
        <div class="titulo_formulario">
            <h1>Ingrese datos del nuevo equipo</h1>
        </div>
        <div class="columnas_formulario">
            <div class="columna_formulario">
                <label for="tipo_equipo">
                    Tipo de equipo
                    <select name="tipo_equipo" id="tipo_equipo">
                        <option value="PC">Computadora</option>
                        <option value="Impresora">Impresora</option>
                    </select>
                </label>
                <label for="direccion_equipo">
                    Dirección
                    <select name="direccion" id="direccion_equipo">
                    <?php
                        foreach($direcciones as $item):
                    ?>
                        <option value="<?= $item->id_direccion?>"><?= $item->nombre?></option>
                    <?php 
                        endforeach; 
                            
                    ?>                         
                    </select>
                </label>
                <label for="sistema_operativo_equipo">
                    Sistema operativo
                    <input id="sistema_operativo_equipo" type="text">
                    <div class="error_message_sistema_operativo">
                        
                    </div>
                </label>
                <label for="search_usuario">
                    Asignar a
                    <input id="search_usuario" type="text">
                    <div class="opciones_busqueda_usuario">
                        
                    </div>
                </label>
                <label for="invetario_monitor">
                    Inventario monitor
                    <input id="invetario_monitor" type="text">
                    <div class="error_message_email">
                        
                    </div>
                </label>
            </div>

            <div class="columna_formulario">
                <label for="nombre_equipo">
                    Nombre del equipo
                    <input id="nombre_equipo" type="text">
                    <div class="error_message_nombre">
                        
                    </div>
                </label>
                <label for="marca_equipo">
                    Marca
                    <input id="marca_equipo" type="text">
                    <div class="error_message_marca">
                        
                    </div>
                </label>
                <label for="procesador_equipo">
                    Procesador
                    <input id="procesador_equipo" type="text">
                    <div class="error_message_procesador">
                        
                    </div>
                </label>
                <label for="teclado_equipo">
                    Teclado
                    <select name="teclado_equipo" id="teclado_equipo">
                        <option value="1">Si</option>
                        <option value="0">No</option>
                    </select>
                </label>
                <label for="serie_monitor">
                    Serie monitor
                    <input id="serie_monitor" type="text">
                    <div class="error_message_email">
                        
                    </div>
                </label>
            </div>

            <div class="columna_formulario">
                <label for="direccion_ip_equipo">
                    Dirección IP
                    <input id="direccion_ip_equipo" type="text">
                    <div class="error_message_direccionIP">
                        
                    </div>
                </label>
                <label for="inventario_equipo">
                    Inventario
                    <input id="inventario_equipo" type="text">
                    <div class="error_message_inventario">
                        
                    </div>
                </label>
                <label for="cantidad_ram_equipo">
                    Catidad de RAM
                    <input id="cantidad_ram_equipo" type="text">
                    <div class="error_message_email">
                        
                    </div>
                </label>
                <label for="mause_equipo">
                    Mouse
                    <select name="mause_equipo" id="mause_equipo">
                        <option value="1">Si</option>
                        <option value="0">No</option>
                    </select>
                </label>
                <label for="marca_monitor">
                    Marca monitor
                    <input id="marca_monitor" type="text">
                    <div class="error_message_email">
                        
                    </div>
                </label>
            </div>

            <div class="columna_formulario">
                <label for="segmento_red_equipo">
                    Segmento de red
                    <input id="segmento_red_equipo" type="text">
                    <div class="error_message_segmento_red">
                        
                    </div>
                </label>
                <label for="serie_equipo">
                    Serie
                    <input id="serie_equipo" type="text">
                    <div class="error_message_serie">
                        
                    </div>
                </label>
                <label for="disco_duro_equipo">
                    Disco duro
                    <input id="disco_duro_equipo" type="text">
                    <div class="error_message_email">
                        
                    </div>
                </label>
                <label for="dvd_equipo">
                    DVD
                    <select name="dvd_equipo" id="dvd_equipo">
                        <option value="1">Si</option>
                        <option value="0">No</option>
                    </select>
                </label>
                <label for="tamaño_monitor">
                    Tamaño monitor
                    <input id="tamaño_monitor" type="text">
                    <div class="error_message_email">
                        
                    </div>
                </label>
            </div>
        </div>
        <div class="comentario-enviar-datos-equipo">
            <label for="observaciones_equipo" class="observaciones_equipo">
                Observaciones equipo
                <br>
                <input id="observaciones_equipo" type="text">
            </label>
            <button class="guardar_equipo">Guardar equipo</button>
        </div>
    </div>
</div>

<div class="mensaje">
    <div class="contenedor_mensaje_guardar_usuario">
        <div class="cerrar_ventana_guardar_usuario">
            <p>x</p>
        </div>
        <div class="titulo-mensaje">
            
        </div>
        <img style="margin-top: 15px" src="" width="250" correcto="<?= base_url('assets/img/iconos/correcto.svg') ?>" incorrecto="<?= base_url('assets/img/iconos/incorrecto.svg') ?>" alt="">
        <div class="mensaje-body">

        </div>
    </div>
            
</div>

<?= $footer ?>