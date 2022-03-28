<?= $head ?>
<?= $nav ?>
    
    <div class="container-crear-incidencia">
        <div class="titulo-crear-reporte">
            <b><h1>Ingresar datos de reporte</h1></b>
        </div>
        <form action="<?= base_url('reporte/guardar_incidencia') ?>" method="POST" id="frm_incidencia" enctype="multipart/form-data">
            <div class="parte1-formulario">
                <div class="form-group pb-2" id="titulo"> 
                    <input type="text" name="titulo" class="form-control" id="titulo" placeholder="Ingrese un titulo">
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
                const fileReader = new FileReader();
                fileReader.readAsDataURL(file);
                fileReader.addEventListener('load', (e) => {
                    img.setAttribute('src', e.target.result);   
                });
                nombreArchivo.innerText = archivo.files[0].name;     
            });



        </script>
   
<?= $footer ?>