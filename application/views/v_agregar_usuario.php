<?= $head; ?>
<?= $nav; ?>

<div class="container" rol="<?= $this->session->id_rol; ?>">
    <div class="formulario_agregar_usuario">
        <div class="titulo_formulario">
            <h1>Ingrese datos del nuevo usuario</h1>
        </div>
        <div class="columnas_formulario">
            <div class="columna_formulario">
                <label for="nombre">
                    Nombre(s)
                    <input id="nombre" type="text">
                </label>
                <label for="apellido_paterno">
                    Apellido paterno
                    <input id="apellido_paterno" type="text">
                </label>
                <label for="apellido_materno">
                    Apellido materno
                    <input id="apellido_materno" type="text">
                </label>
                <label for="email">
                    Correo electrónico
                    <input id="email" type="email">
                </label>
                <label for="contraseña">
                    Contraseña
                    <input id="contraseña" type="text">
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
                </label>
                <label for="tipo_usuario">
                    Tipo de usuario
                    <select name="tipo_usuario" id="tipo_usuario">
                    <?php
                        foreach($roles as $item):
                    ?>
                        <option value="<?= $item->id_rol?>"><?= $item->nombre?></option>
                    <?php 
                        endforeach; 
                            
                    ?>
                    </select>
                </label>
                <label for="departamento">
                    Departamento interno
                    <select name="departamento" id="departamento">
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

<?= $footer ?>