<?= $head ?>
<?= $nav ?>
    
    <div class="container-crear-incidencia">
        <div class="titulo-crear-reporte">
            <b><h1>Ingresar datos de reporte</h1></b>
        </div>
        <div>
            <input type="checkbox" id="alguien-mas"> <label for="alguien-mas" class="label-alguien-mas">Hacer reporte para alguien más</label>
            <input class="search_usuario" type="text" placeholder="Ingrese el número o nombre del trabajador">
            <div class="opciones-usuarios-nueva-incidencia">
            
            </div>
        </div>
        <form action="<?= base_url('reporte/guardar_incidencia') ?>" method="POST" id="frm_incidencia" enctype="multipart/form-data">
            <div class="parte1-formulario">
            <input type="text" name="id_usuario" id="id_usuario">
                <h2 class="creador-reporte" nombre="<?=$this->session->nombre." ".$this->session->apellido_paterno." ".$this->session->apellido_materno?>">Creador del reporte: <?=$this->session->nombre." ".$this->session->apellido_paterno." ".$this->session->apellido_materno?></h2>
                <div class="form-group pb-2" id="titulo"> 
                    <input type="text" name="titulo" minlength="4" maxlength="45" class="form-control" id="titulo" placeholder="Ingrese un titulo">
                    <?php if(form_error('titulo')):?>
                        <div class="alert alert-danger" role="alert"><?= form_error('titulo')?></div>
                    <?php endif;?>
                </div>
                <div class="form-group pb-2" id="descripcion">
                    <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Ingrese una descripción al reporte" cols="30" rows="10"></textarea>
                    <?php if(form_error('descripcion')):?>
                        <div class="alert alert-danger" role="alert"><?= form_error('descripcion')?></div>
                    <?php endif;?>
                </div>
            </div>
            <div class="parte2-formulario">
                <div class="form-group pb-2 equipo">
                    <h3>Seleccione el equipo que esta fallando</h3>
                    <select name="id_equipo" id="seleccion-equipo">
                        <option value="">Ninguno</option>
                        <?php 
                            if (empty($equipos)) {
                        ?>
                            
                        <?php 
                            }else{
                                foreach($equipos as $item):
                        ?>
                                    <option value="<?=$item->id_equipo?>"><?=$item->nombre?></option>
                        <?php 
                                endforeach; 
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group pb-2 file">
                    <h2>Arrastre y sulte el archivo</h2>
                    <span>o</span>
                    <label for="archivo">Elegir archivo</label>
                    <input id="archivo" class="form-control" type="file" name="archivo">
                    <img id="preview" width="50">
                    <p id="nombre-archivo"></p>
                </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary form-control boton-guardar-incidencia">Guardar</button>
                    </div>
                <div class="form-group" id="alert"></div>
            </div>
        </form>

        <script type="text/javascript">
            let archivo = document.querySelector('#archivo');
            let nombreArchivo = document.querySelector('#nombre-archivo');
            let img = document.querySelector('#preview');
            archivo.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if ((/\.(jpg|jpe|svg|jpeg|jfif|ief|png|gif)$/i).test(file.name)) {
                    const fileReader = new FileReader();
                    fileReader.readAsDataURL(file);
                    fileReader.addEventListener('load', (e) => {
                        img.setAttribute('src', e.target.result);   
                    });
                    console.log('Es una imagen');
                }else if((/\.(doc|dot|docx)$/i).test(file.name)){ 
                    img.setAttribute('src', 'http://localhost/Control-de-Reportes-H-Ayuntamiento/assets/img/iconos/file-word.png'); 
                    console.log('Es un Word');
                }else if((/\.(pdf)$/i).test(file.name)){
                    img.setAttribute('src', 'http://localhost/Control-de-Reportes-H-Ayuntamiento/assets/img/iconos/file-pdf.png');
                    console.log('Es un PDF');
                }else if((/\.(xlsx|xlsm|xlsb|xltx|xltm|xls|xlt|xlw|xla|xml|csv)$/i).test(file.name)){
                    img.setAttribute('src', 'http://localhost/Control-de-Reportes-H-Ayuntamiento/assets/img/iconos/file-excel.png');
                    console.log('Es un Excel');
                }else{
                    console.log('Es otro tipo de archivo');
                }
                nombreArchivo.innerText = archivo.files[0].name;     
            });



        </script>
   
<?= $footer ?>