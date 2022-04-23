<?= $head; ?>
<?= $nav; ?>

<div class="container">
    <div class="formulario_agregar_usuario">
        <div class="titulo_formulario">
            <h1>Ingrese datos del nuevo usuario</h1>
        </div>
        <div class="columnas_formulario">
            <div class="columna_formulario">
                <label for="nombre">
                    Nombre(s)
                    <input id="nombre" type="text">
                    <div class="error_message_nombre">
                        
                    </div>
                </label>
                <label for="apellido_paterno">
                    Apellido paterno
                    <input id="apellido_paterno" type="text">
                    <div class="error_message_apellidoP">
                        
                    </div>
                </label>
                <label for="apellido_materno">
                    Apellido materno
                    <input id="apellido_materno" type="text">
                    <div class="error_message_apellidoM">
                        
                    </div>
                </label>
                <label for="email">
                    Correo electrónico
                    <input id="email" type="email">
                    <div class="error_message_email">
                        
                    </div>
                </label>
                <label for="contraseña">
                    Contraseña
                    <input id="contraseña" type="text">
                    <div class="error_message_password">
                        
                    </div>
                </label>
            </div>

            <div class="columna_formulario">
                <label for="direccion">
                    Dirección
                    <select name="direccion" id="direccion">
                    <?php
                        foreach($direcciones as $item):
                    ?>
                        <option value="<?= $item->id_direccion?>"><?= $item->nombre?></option>
                    <?php 
                        endforeach; 
                            
                    ?>                         
                    </select>
                </label>
                <label for="direccion_ip">
                    Dirección IP
                    <input id="direccion_ip" type="text">
                    <div class="opciones_busqueda_ip">
                        
                    </div>
                    <div class="error_message_direccionIP">
                        
                    </div>
                </label>
                <label for="tipo_usuario">
                    Tipo de usuario
                    <select name="tipo_usuario" id="tipo_usuario">
                    <?php
                        foreach($roles as $item):
                    ?>
                        <option <?= $item->id_rol == '0' ? 'selected' : ''; ?> value="<?= $item->id_rol?>"><?= $item->nombre?></option>
                    <?php 
                        endforeach; 
                            
                    ?>
                    </select>
                </label>
                <label for="departamento">
                    Departamento interno
                    <select name="departamento" id="departamento" disabled>
                        <option class="departamento_indefinido" selected value="0">Seleccione un departamento</option>
                    <?php
                        foreach($departamentos as $item):
                    ?>
                        <option value="<?= $item->id_departamento?>"><?= $item->nombre?></option>
                    <?php 
                        endforeach; 
                            
                    ?>
                    </select>
                </label>
                <button id="btn_guardar_usuario">Guardar usuario</button>
            </div>
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
        <img style="margin-top: 15px" src="<?= base_url('assets/img/iconos/correcto.svg') ?>" width="250" alt="">
        <div class="mensaje-body">

        </div>
    </div>
            
</div>

<?= $footer ?>