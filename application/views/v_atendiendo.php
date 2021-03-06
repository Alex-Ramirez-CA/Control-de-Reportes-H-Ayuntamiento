<?= $head; ?>

<?= $nav; ?>

<div class="container">
    <!-- Columna de los reportes en proceso -->
    <div class="proceso">
        <div class="titulo-columna">
            <p class="cantidad-reportes-proceso-tecnico"></p>
            <h3><b>Reportes en proceso</b></h3>
        </div>
        
        <div class="columna-proceso"> 
            <?php 
                if (empty($en_proceso)) {
            ?>
                    <img class="contenido-vacio-cliente" src="<?= base_url('assets/img/logotipos/flor.png');?>" alt="" width="150">
            <?php 
                }else{
                    foreach($en_proceso as $item):
                        if($item->statusbyUsuario == 1){
            ?>
                        <div class="card-atendiendo" idCard="<?= $item->id_incidencia;?>">
                            <div class="card-title">
                                <b><h5><?= $item->titulo; ?></h5></b>
                            </div>
                            <div class="card-body">
                                <div class="fecha">
                                    <b><h5>Folio</h5></b>
                                    <p><?= $item->id_incidencia;?></p>
                                </div>
                                <div class="fecha">
                                    <b><h5>Creado</h5></b>
                                    <p><?= date("d/m/Y", strtotime($item->fecha_apertura)); ?></p>
                                </div>
                                <div class="opciones-card">
                                    <button class="ver" idReporte="<?= $item->id_incidencia;?>">Ver</button>
                                    <button class="finalizar" idReporte="<?= $item->id_incidencia;?>" titulo="<?= $item->titulo;?>" participantes="<?= $item->encargado;?>">Finalizar</button>
                                </div>
                            </div>
                            <div class="tecnico-departamento">
                                <div class="nom-tecnicos">
                                    <figcaption>
                                        <p class="nombre-tecnicos">Atendido por </b><?= $item->encargado; ?></p>
                                    </figcaption>
                                    <img src="<?=base_url('assets/img/iconos/tecnicos.svg')?>" alt="">
                                </div>
                                <div class="nom-departamentos">
                                    <figcaption>
                                        <p class="nombre-departamentos">Se asigno a </b><?= $item->departamento; ?></p>
                                    </figcaption>
                                    <img src="<?=base_url('assets/img/iconos/departamentos.svg')?>" alt="">
                                </div>                                
                            </div>
                        </div>
            <?php
                        }else{
            ?> 
                           <img class="contenido-vacio-cliente" src="<?= base_url('assets/img/logotipos/flor.png');?>" alt="" width="150"> 
            <?php           
                        } 
                    endforeach; 
                }    
            ?>   
        </div>

    </div>
    
    <!-- Columna de los reportes finalizados -->
    <div class="finalizado">
        <div class="titulo-columna">
            <p class="cantidad-reportes"><?= empty($finalizados) ? '0' : count($finalizados); ?></p>
            <h3><b>Reportes finalizados</b></h3>
        </div>
        
        <div class="columna-proceso"> 
            <?php 
                if (empty($finalizados)) {
            ?>
                    <img class="contenido-vacio-cliente" src="<?= base_url('assets/img/logotipos/flor.png');?>" alt="" width="150">
            <?php 
                }else{
                    foreach($finalizados as $item):
            ?>
                        <div class="card-atendiendo" idCard="<?= $item->id_incidencia;?>">
                            <div class="card-title">
                                <b><h5><?= $item->titulo; ?></h5></b>
                            </div>
                            <div class="card-body">
                                <div class="fecha">
                                    <b><h5>Folio</h5></b>
                                    <p><?= $item->id_incidencia;?></p>
                                </div>
                                <div class="fecha">
                                    <b><h5>Creado</h5></b>
                                    <p><?= date("d/m/Y", strtotime($item->fecha_apertura)); ?></p>
                                </div>
                                <div class="opciones-card">
                                    <button class="ver" idReporte="<?= $item->id_incidencia;?>">Ver</button>
                                    <button class="reabrir-atendido" idReporte="<?= $item->id_incidencia;?>" titulo="<?= $item->titulo;?>" participantes="<?= $item->encargado;?>">Reabrir</button>
                                </div>
                            </div>
                            <div class="tecnico-departamento">
                                <div class="nom-tecnicos">
                                    <figcaption>
                                        <p class="nombre-tecnicos">Atendido por </b><?= $item->encargado; ?></p>
                                    </figcaption>
                                    <img src="<?=base_url('assets/img/iconos/tecnicos.svg')?>" alt="">
                                </div>
                                <div class="nom-departamentos">
                                    <figcaption>
                                        <p class="nombre-departamentos">Se asigno a </b><?= $item->departamento; ?></p>
                                    </figcaption>
                                    <img src="<?=base_url('assets/img/iconos/departamentos.svg')?>" alt="">
                                </div>                                
                            </div>
                        </div>
            <?php 
                    endforeach; 
                }    
            ?>   
        </div>

    </div>

</div>

<div class="mensaje">
    <div class="mensaje_aceptacion">
        
    </div>
    <div class="cerrar-ventana">
        <p class="cerrar-mensaje-tecnico">x</p>
    </div>
    <div class="contenedor-mensaje">
        <div class="mensaje-body">
            <div class="comentario-tecnico">
                <b><h1>??Qu?? fue lo que se hizo?</h1></b>
                <textarea name="comentario-tecnico" id="comentario-tecnico" cols="30" rows="10"></textarea>
                <button class="enviar-comentario">Enviar comentario</button>
            </div>
            <div class="respuestas-rapidas">
                <div class="datos-reporte-comentario">
                    <h2 class="titulo-reporte-tecnico"></h2>
                    <div class="folio-participantes">
                        <h2 class="folio"></h2>
                        <div class="participantes">
                            <figcaption>
                                <p class="nombres-asignados"></p>
                            </figcaption>
                            <p class="participantes-texto">Participantes</p>
                            <p class="participante"></p>
                        </div>
                    </div>
                </div>
                <button class="respuesta">El d??a de hoy comenzar?? a darle soluci??n al reporte</button>
                <button class="respuesta">Me gustar??a ayudar a solucionar el problema</button>
                <button class="respuesta">Surgi?? un imprevisto y por eso me regrese</button>
                <button class="respuesta">El problema qued?? completamente solucionado</button>
                <button class="respuesta"></button>
            </div>
        </div>
    </div>
</div>

<?= $footer ?>