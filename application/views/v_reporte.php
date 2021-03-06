<?= $head ?>

<div class="container-reporte">
    <div class="encabezado-reporte">
        <a class="navbar-brand m-0" href="<?= base_url($this->session->rol_nombre) ?>"><img class="logo-nav" src="<?= base_url('assets/img/logotipos/logo_ayto1-01.png');?>" alt=""></a> 
        <div class="nombre-usuario-ver-reporte">
            <h3>Usuario: <?=$this->session->nombre." ".$this->session->apellido_paterno." ".$this->session->apellido_materno?></h3>
        </div>
        
    </div>   
    <div class="reporte">
        <div class="datos-reporte">
            <h1>Datos generales del reporte</h1>
            <div class="titulo">
                <h2>Folio y titulo del reporte</h2>
            </div>
            <div class="tabla-datos-creador">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Folio</th>
                            <th scope="col">Titulo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?=$generales->id_incidencia?></td> 
                            <td><?=$generales->titulo?></td> 
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="titulo">
                <h2>Descripción del reporte</h2>
            </div>
            <h3><?=$generales->descripcion?></h3>

            <div class="titulo">
                <h2>Datos del creador del reporte</h2>
            </div>
            <div class="tabla-datos-creador">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Dato</th>
                            <th scope="col">Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Nombre</th>
                            <td><?= $generales->usuario ?></td> 
                        </tr>
                        <tr>
                            <th scope="row">Dependecia</th>
                            <td><?= $generales->dependencia ?></td> 
                        </tr>
                        <tr>
                            <th scope="row">Dirección</th>
                            <td><?= $generales->direccion ?></td> 
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="fechas-status">
                <?php
                    $fecha_apertura = strtotime($generales->fecha_apertura);
                    $fecha_cierre = strtotime($generales->fecha_cierre);
                ?>
                <div class="titulo">
                    <h2>Fechas y status actual</h2>
                </div>
                <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Fecha apertura</th>
                            <th scope="col">Fecha cierre</th>
                            <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <!--Dar formato a las fechas-->
                                <td><?= date("d/m/Y", $fecha_apertura) ?></td>
                                <?php
                                    if($fecha_cierre == ""){
                                ?>
                                    <td><?= $fecha_cierre ?></td>
                                <?php
                                    }else{
                                ?>
                                    <td><?= date("d/m/Y", $fecha_cierre) ?></td>
                                <?php
                                    }
                                ?>
                                <?php
                                    $status;
                                    if ($generales->status == 0) {
                                        $status = "Pendiente";
                                    }elseif($generales->status == 1){
                                        $status = "En proceso";  
                                    }else{
                                        $status = "Finalizado"; 
                                    }
                                ?>
                                <td><?= $status ?></td> 
                            </tr>
                        </tbody>
                </table>
            </div>
            
            <div class="tabla-especificaciones">
                <div class="titulo">
                    <h2>Especificaciones del equipo dañado</h2>
                </div>

                <?php if(empty($equipo)){ ?>
                    <h3>No se selecciono algún equipo</h3>
                <?php }else{ ?>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Especificación</th>
                            <th scope="col">Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Nombre</th>
                                <td><?= $equipo->nombre ?></td>
                            </tr>
                            <tr>
                                <th scope="row">IP</th>
                                <td><?= $equipo->direccion_ip ?></td>                        
                            </tr>
                            <tr>
                                <th scope="row">Marca</th>
                                <td><?= $equipo->marca ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Sistema operativo</th>
                                <td><?= $equipo->sistema_operativo ?></td>
                            </tr>
                            <tr>
                                <th scope="row">RAM</th>
                                <td><?= $equipo->ram ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Disco duro</th>
                                <td><?= $equipo->disco_duro ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php } ?>                       
            </div>

            <div class="titulo">
                <h2>Archivo adjuto (descargable)</h2>
            </div>
            <?php
                $imagen = array("gif", "svg", "jpe", "jpg", "jpeg", "png","GIF", "JPE", "JPG", "JPEG", "PNG", "jfif", "ief");
                $word = array("doc","dot","docx");
                $pdf = array("pdf");
                $tipo_archivo;
                $size;
                if($generales->ext == null){
            ?>
                    <h3 class="no-archivo">No se selecciono algún archivo</h3>
            <?php
                }elseif (in_array($generales->ext, $imagen)) {
                    $tipo_archivo = base_url('uploads/').$generales->archivo;
                    $size = 100;
            ?>
                    <a class="archivo-descarga" href="<?= base_url('uploads/').$generales->archivo?>" download>
                        <img src="<?= $tipo_archivo ?>" alt="<?= $generales->archivo?>" width="<?=$size?>">
                    </a>
                    <p class="nombre-archivo-descarga"><?= $generales->archivo?></p>
            <?php
                }elseif(in_array($generales->ext, $word)){
                    $tipo_archivo = base_url('assets/img/iconos/file-word.png');
                    $size = 48;
            ?>
                    <a class="archivo-descarga" href="<?= base_url('uploads/').$generales->archivo?>" download>
                        <img src="<?= $tipo_archivo ?>" alt="<?= $generales->archivo?>" width="<?=$size?>">
                    </a>
                    <p class="nombre-archivo-descarga"><?= $generales->archivo?></p>
            <?php
                }elseif(in_array($generales->ext, $pdf)){
                    $tipo_archivo = base_url('assets/img/iconos/file-pdf.png');
                    $size = 48;
            ?>
                    <a class="archivo-descarga" href="<?= base_url('uploads/').$generales->archivo?>" download>
                        <img src="<?= $tipo_archivo ?>" alt="<?= $generales->archivo?>" width="<?=$size?>">
                    </a>
                    <p class="nombre-archivo-descarga"><?= $generales->archivo?></p>
            <?php
                }else{
                    $tipo_archivo = base_url('assets/img/iconos/file-excel.png');
                    $size = 48;
            ?>
                    <a class="archivo-descarga" href="<?= base_url('uploads/').$generales->archivo?>" download>
                        <img src="<?= $tipo_archivo ?>" alt="<?= $generales->archivo?>" width="<?=$size?>">
                    </a>
                    <p class="nombre-archivo-descarga"><?= $generales->archivo?></p>
            <?php } ?>

        </div>
        <div class="comentarios-reporte">
            <h1>Comentarios del reporte</h1>
            <?php 
                if (empty($comentarios)) {
            ?>
            <img class="contenido-vacio" src="<?= base_url('assets/img/logotipos/flor.png');?>" alt="" width="150">
            <?php 
                }else{
                    foreach($comentarios as $item):
                        $fecha = strtotime(substr($item->fecha, 0, 10));
                        $hora = strtotime(substr($item->fecha, 11, 5));
            ?>
            <p class="fecha-comentario"><?= date("d/m/Y", $fecha)?></p>
            <div class="comentario">
                <p class="nombre-comentador"><?= $item->comentario_by; ?></p>
                <p class="texto-comentario"><?= $item->comentario; ?></p>
                <div class="hora-comentario">
                    <p><?= date("h:i A", $hora)?></p>
                </div>
            </div>
            <?php 
                    endforeach; 
                }
            ?>
        </div>

    </div>
</div>

<?= $footer ?>