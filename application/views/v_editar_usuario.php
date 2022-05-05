<?= $head; ?>
<?= $nav; ?>

<div class="container">
    <div class="formulario_agregar_usuario">
        <div class="titulo_formulario">
            <h1>Ingrese los nuevos datos del usuario</h1>
        </div>
        <div class="columnas_formulario">
            <div class="columna_formulario">
                <label for="nombre">
                    Nombre(s)
                    <input id="nombre" type="text" value="<?= $datos_usuario->nombre?>">
                    <div class="error_message_nombre">
                        
                    </div>
                </label>
                <label for="apellido_paterno">
                    Apellido paterno
                    <input id="apellido_paterno" type="text" value="<?= $datos_usuario->apellido_paterno?>">
                    <div class="error_message_apellidoP">
                        
                    </div>
                </label>
                <label for="apellido_materno">
                    Apellido materno
                    <input id="apellido_materno" type="text" value="<?= $datos_usuario->apellido_materno?>">
                    <div class="error_message_apellidoM">
                        
                    </div>
                </label>
                <label for="email">
                    Correo electrónico
                    <input id="email" type="email" value="<?= $datos_usuario->email?>">
                    <div class="error_message_email">
                        
                    </div>
                </label>
                <label for="contraseña">
                    Contraseña
                    <input id="contraseña" type="text" value="<?= $datos_usuario->password?>">
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
                        <option <?= $item->id_direccion == $datos_usuario->id_direccion? 'selected' : ''; ?> value="<?= $item->id_direccion?>"><?= $item->nombre?></option>
                    <?php 
                        endforeach; 
                            
                    ?>                         
                    </select>
                </label>
                <label for="direccion_ip">
                    Dirección IP
                    <?php if(empty($PC_usuario->id_equipo)){?>
                        <input id="direccion_ip" type="text">
                        <div class="opciones_busqueda_ip">
                            
                        </div>
                    <?php
                    }else{
                    ?>
                        <input id="direccion_ip" type="text" idEquipo="<?= $PC_usuario->id_equipo?>" value="<?= $PC_usuario->direccion_ip?>">
                        <div class="opciones_busqueda_ip">
                            
                        </div>
                    <?php
                    }
                    ?>
                </label>
                <label for="tipo_usuario">
                    Tipo de usuario
                    <select name="tipo_usuario" id="tipo_usuario">
                    <?php
                        foreach($roles as $item):
                    ?>
                        <option <?= $item->id_rol == $datos_usuario->id_rol ? 'selected' : ''; ?> value="<?= $item->id_rol?>"><?= $item->nombre?></option>
                    <?php 
                        endforeach; 
                            
                    ?>
                    </select>
                </label>
                <label for="departamento">
                    Departamento interno
                    <select name="departamento" id="departamento">
                        <option class="departamento_indefinido" selected value="0">Seleccione un departamento</option>
                    <?php
                        foreach($departamentos as $item):
                    ?>
                        <option <?= $item->id_departamento == $datos_usuario->id_departamento ? 'selected' : ''; ?> value="<?= $item->id_departamento?>"><?= $item->nombre?></option>
                    <?php 
                        endforeach; 
                            
                    ?>
                    </select>
                </label>
                <button id="btn_guardar_cambios_usuario" noEmpleado="<?= $datos_usuario->no_empleado?>">Guardar cambios</button>
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