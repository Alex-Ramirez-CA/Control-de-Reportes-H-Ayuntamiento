(function ($) {
	//Obtener la base url
	var getUrl = window.location;
	var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split("/")[1];
	let direccion = null;
	let departamento = null;
	let dependencia = null;
	let equipo = null;
	let rol = null;
	let status = null;
	let tipo_equipo = null;
	let id_direccion_modif = 0;
	let id_equipo_modif = 0;
	let direccion_ip_modif = 0;

	if (getUrl == baseUrl + "/atendiendo") {
		let cantidad_reportes = $(".proceso").children(".columna-proceso").children(".card-atendiendo").length;
		if (cantidad_reportes > 999) {
			cantidad_reportes = (cantidad_reportes/1000).toFixed(1) + "k";
		}
		$(".cantidad-reportes-proceso-tecnico").html(cantidad_reportes);
	} 
	
	// else if (incidencias.pendientes.length > 999) {
	// 	cantidad_pendientes = incidencias.pendientes.length.toFixed(1) + "k";
	// } else {
	// 	cantidad_pendientes = incidencias.pendientes.length;
	// }

	if(getUrl == baseUrl + "/equipos/lista_equipos"){
		$("#search").attr("placeholder", "Buscar equipo").blur();
	}else if(getUrl == baseUrl + "/usuarios/lista_usuarios"){
		$("#search").attr("placeholder", "Buscar usuario").blur();
		$(".buscador_menu_nav").css({ display: "flex" });
	}else{
		$("#search").attr("placeholder", "Buscar reporte").blur();
	}
	if(getUrl == baseUrl + "/usuarios"){
		$(".buscador_menu_nav").css({ display: "none" });
	}
	if(getUrl == baseUrl + "/equipos"){
		$(".buscador_menu_nav").css({ display: "none" });
	}
	if(getUrl == baseUrl + "/reporte/agregar_incidencia"){
		$(".buscador_menu_nav").css({ display: "none" });
	}

	//Evento para las respuetas rapidas
	//Función para cuando le de click al boton de ver
	$(document).on("click", ".respuesta", function () {
		let elemento = $(this)[0];
		$('#comentario-tecnico').val($(elemento).text() + ".");
	});

	//Evento que se ejecuta cuando el usuario este escribiendo en la barra de busqueda
	$("#search").keyup(function() {
		if(getUrl == baseUrl + "/equipos/lista_equipos"){
			if($('#search').val()){
				let search_equipo = $('#search').val();
				$.ajax({
					url: 'buscar_equipo',
					type: 'POST',
					data: { search_equipo},
					success: function(response) {
						obtenerListaEquipos(response);
					}
				});
			}else{
				obtenerListaCompletaEquipos();
			}
		}else if(getUrl == baseUrl + "/usuarios/lista_usuarios"){
			if($('#search').val()){
				let search_empleado = $('#search').val();
				$.ajax({
					url: 'buscar_empleado',
					type: 'POST',
					data: { search_empleado},
					success: function(response) {
						obtenerListaUsuarios(response);
					}
				});
			}else{
				obtenerListaCompletaUsuarios();
			}
		}else{
			$('#opciones-buscar').css('display','flex');
			if($('#search').val()){
				let search = $('#search').val();
				let uri = $('#search').attr('url');
				$.ajax({
					url: 'busqueda/buscar_incidencia',
					type: 'POST',
					data: { search, uri },
					success: function(data) {
						let incidencias = JSON.parse(data);
						let template = "";

						if (incidencias){
							incidencias.forEach(element => {
								template += `<a class="autocompletado" href="#" idCard="${element.id_incidencia}">
								${element.titulo}
								</a>`;
							});
							$('#opciones-buscar').html(template);
						}
					}
				});
			}else{
				template = "";
			}
		}       
	});

	//Obtener las incidencia para el cliente tipo Administrador
	if ($(".container").attr("rol") == 3) {
		obtenerTodasIncidencias();
		obtenerDatosFiltros();
	}

    //Listar a todos los usuarios solo cuando este la url correcta
	if (getUrl == baseUrl + "/usuarios/lista_usuarios") {
		obtenerListaCompletaUsuarios();
	}

	//Listar a todos los equipos solo cuando este la url correcta
	if (getUrl == baseUrl + "/equipos/lista_equipos") {
		obtenerListaCompletaEquipos();
	}

	//Función para cuando le de click al boton de ver
	$(document).on("click", ".ver", function () {
		let elemento = $(this)[0];
		let id_incidencia = $(elemento).attr("idReporte");
		$.post(
			"reporte/visualizar_reporte",
			{ id_incidencia },
			function (response) {
				let json = JSON.parse(response);
				window.open(json.url);
			}
		);
	});

	//Función para el boton de atender incidencia
	$(document).on("click", ".atender", function () {
		let elemento = $(this)[0];
		let id = $(elemento).attr("idReporte");
		let titulo = $(elemento).attr("titulo");
		$(".folio").html("Folio: " + id);
		$(".participante").html("0");
		$(".nombres-asignados").html("Por definir");
		$(".titulo-reporte-tecnico").html("Titulo: " + titulo);
		$(".mensaje").css({ visibility: "visible" });
		$(".contenedor-mensaje").css({ transform: "translateY(0%)" });
		$(".enviar-comentario").attr("idReporte", id);
		$(".enviar-comentario").attr("titulo", titulo);

		$(document).on("click", ".enviar-comentario", function () {
			let elemento = $(this)[0];
			let id_incidencia = $(elemento).attr("idReporte");
			let comentario = $("#comentario-tecnico").val();
			$.post(
				"tecnico/atender",
				{ id_incidencia, comentario },
				function (response) {
					let json = JSON.parse(response);
					$('.mensaje_aceptacion').css({visibility: "visible"});
					$('.mensaje_aceptacion').html(`
						<h1>${json.msg}</h1>
						<img src="${baseUrl}/assets/img/iconos/correcto.svg" alt=""><br>
						<button class="aceptar_mensaje">Aceptar</button>
					`);
					$(document).on("click", ".aceptar_mensaje", function () {
						while ($('.mensaje_aceptacion').firstChild) {
							$('.mensaje_aceptacion').removeChild($('.mensaje_aceptacion').firstChild);
						}
						$('.mensaje_aceptacion').css({visibility: "hidden"});
						window.location.replace(json.url);
					});
				}
			);
		});
	});

	$(document).on("click", ".unirme", function () {
		let elemento = $(this)[0];
		let id = $(elemento).attr("idReporte");
		let titulo = $(elemento).attr("titulo");
		let participantes = $(elemento).attr("participantes").split(",");
		$(".folio").html("Folio: " + id);
		//$('.participante').css({'padding-left':'8px'});
		$(".participante").html(participantes.length);
		$(".nombres-asignados").html("Atendido por " + participantes);
		$(".titulo-reporte-tecnico").html("Titulo: " + titulo);
		$(".mensaje").css({ visibility: "visible" });
		$(".contenedor-mensaje").css({ transform: "translateY(0%)" });
		$(".enviar-comentario").attr("idReporte", id);
		$(document).on("click", ".enviar-comentario", function () {
			let elemento = $(this)[0];
			let id_incidencia = $(elemento).attr("idReporte");
			let comentario = $("#comentario-tecnico").val();
			console.log(id_incidencia);
			console.log(comentario);
			$.post(
				"tecnico/unirme",
				{ id_incidencia, comentario },
				function (response) {
					let json = JSON.parse(response);
					$('.mensaje_aceptacion').css({visibility: "visible"});
					$('.mensaje_aceptacion').html(`
						<h1>${json.msg}</h1>
						<img src="${baseUrl}/assets/img/iconos/correcto.svg" alt=""><br>
						<button class="aceptar_mensaje">Aceptar</button>
					`);
					$(document).on("click", ".aceptar_mensaje", function () {
						while ($('.mensaje_aceptacion').firstChild) {
							$('.mensaje_aceptacion').removeChild($('.mensaje_aceptacion').firstChild);
						}
						$('.mensaje_aceptacion').css({visibility: "hidden"});
						window.location.replace(json.url);
					});
				}
			);
		});
	});

	$(document).on("click", ".reabrir", function () {
		let elemento = $(this)[0];
		let id = $(elemento).attr("idReporte");
		let titulo = $(elemento).attr("titulo");
		let participantes = $(elemento).attr("participantes").split(",");
		$(".folio").html("Folio: " + id);
		$(".participante").html(participantes.length);
		$(".nombres-asignados").html("Atendido por " + participantes);
		$(".titulo-reporte-tecnico").html("Titulo: " + titulo);
		$(".mensaje").css({ visibility: "visible" });
		$(".contenedor-mensaje").css({ transform: "translateY(0%)" });
		$(".enviar-comentario").attr("idReporte", id);

		$(document).on("click", ".enviar-comentario", function () {
			let elemento = $(this)[0];
			let id_incidencia = $(elemento).attr("idReporte");
			let comentario = $("#comentario-tecnico").val();
			$.post(
				"tecnico/reabrir",
				{ id_incidencia, comentario },
				function (response) {
					let json = JSON.parse(response);
					$('.mensaje_aceptacion').css({visibility: "visible"});
					$('.mensaje_aceptacion').html(`
						<h1>${json.msg}</h1>
						<img src="${baseUrl}/assets/img/iconos/correcto.svg" alt=""><br>
						<button class="aceptar_mensaje">Aceptar</button>
					`);
					$(document).on("click", ".aceptar_mensaje", function () {
						while ($('.mensaje_aceptacion').firstChild) {
							$('.mensaje_aceptacion').removeChild($('.mensaje_aceptacion').firstChild);
						}
						$('.mensaje_aceptacion').css({visibility: "hidden"});
						window.location.replace(json.url);
					});
				}
			);
		});
	});

	$(document).on("click", ".finalizar", function () {
		let elemento = $(this)[0];
		let id = $(elemento).attr("idReporte");
		let titulo = $(elemento).attr("titulo");
		let participantes = $(elemento).attr("participantes").split(",");
		$(".folio").html("Folio: " + id);
		$(".participante").html(participantes.length);
		$(".nombres-asignados").html("Atendido por " + participantes);
		$(".titulo-reporte-tecnico").html("Titulo: " + titulo);
		$(".mensaje").css({ visibility: "visible" });
		$(".contenedor-mensaje").css({ transform: "translateY(0%)" });
		$(".enviar-comentario").attr("idReporte", id);

		$(document).on("click", ".enviar-comentario", function () {
			let elemento = $(this)[0];
			let id_incidencia = $(elemento).attr("idReporte");
			let comentario = $("#comentario-tecnico").val();
			$.post(
				"atendiendo/finalizar",
				{ id_incidencia, comentario },
				function (response) {
					let json = JSON.parse(response);
					$('.mensaje_aceptacion').css({visibility: "visible"});
					$('.mensaje_aceptacion').html(`
						<h1>${json.msg}</h1>
						<img src="${baseUrl}/assets/img/iconos/correcto.svg" alt=""><br>
						<button class="aceptar_mensaje">Aceptar</button>
					`);
					$(document).on("click", ".aceptar_mensaje", function () {
						while ($('.mensaje_aceptacion').firstChild) {
							$('.mensaje_aceptacion').removeChild($('.mensaje_aceptacion').firstChild);
						}
						$('.mensaje_aceptacion').css({visibility: "hidden"});
						window.location.replace(json.url);
					});
				}
			);
		});
	});

	$(document).on("click", ".reabrir-atendido", function () {
		let elemento = $(this)[0];
		let id = $(elemento).attr("idReporte");
		let titulo = $(elemento).attr("titulo");
		let participantes = $(elemento).attr("participantes").split(",");
		$(".folio").html("Folio: " + id);
		$(".participante").html(participantes.length);
		$(".nombres-asignados").html("Atendido por " + participantes);
		$(".titulo-reporte-tecnico").html("Titulo: " + titulo);
		$(".mensaje").css({ visibility: "visible" });
		$(".contenedor-mensaje").css({ transform: "translateY(0%)" });
		$(".enviar-comentario").attr("idReporte", id);

		$(document).on("click", ".enviar-comentario", function () {
			let elemento = $(this)[0];
			let id_incidencia = $(elemento).attr("idReporte");
			let comentario = $("#comentario-tecnico").val();
			$.post(
				"atendiendo/reabrir",
				{ id_incidencia, comentario },
				function (response) {
					let json = JSON.parse(response);
					$('.mensaje_aceptacion').css({visibility: "visible"});
					$('.mensaje_aceptacion').html(`
						<h1>${json.msg}</h1>
						<img src="${baseUrl}/assets/img/iconos/correcto.svg" alt=""><br>
						<button class="aceptar_mensaje">Aceptar</button>
					`);
					$(document).on("click", ".aceptar_mensaje", function () {
						while ($('.mensaje_aceptacion').firstChild) {
							$('.mensaje_aceptacion').removeChild($('.mensaje_aceptacion').firstChild);
						}
						$('.mensaje_aceptacion').css({visibility: "hidden"});
						window.location.replace(json.url);
					});
				}
			);
		});
	});

	//Función para cerrar el modal
	$(document).on("click", ".cerrar-mensaje-tecnico", function () {
		$(".enviar-comentario").removeAttr("idReporte");
		$(".mensaje").css({ visibility: "hidden" });
		$(".contenedor-mensaje").css({ transform: "translateY(-200%)" });
		if ($(".container").attr("rol") == 2) {
			$.post("tecnico/recargar", {}, function (response) {
				let json = JSON.parse(response);
				window.location.replace(json.url);
			});
		}
	});

	/*
    ------------------------------------------------------------------------------------------------------------
    Funciones para usuario administrador
    ------------------------------------------------------------------------------------------------------------
    */
	//Evento cuando se clica el boton de filtros
	$(document).on("click", "#btn-filtros", function () {
		$(".mensaje").css({ visibility: "visible" });
		$(".contenedor-mensaje").css({ transform: "translateY(0%)" });
	});

	//Evento cuando se clica en algunos de los filtros
	$(document).on("click", ".filtro-dependecia", function () {
		if ($('.lista-dependecias').is(':hidden')) {
			$('.lista-dependecias').css({display : "flex"});
		}else {
			$('.lista-dependecias').css({display : "none"});
		}
	});
	$(document).on("click", ".filtro-fecha", function () {
		if ($('.fechas-filtro').is(':hidden')) {
			$('.fechas-filtro').css({display : "flex"});
		}else {
			$('.fechas-filtro').css({display : "none"});
		}
	});
	$(document).on("click", ".filtro-equipo", function () {
		if ($('#search_equipo').is(':visible')) {
			$('#search_equipo').hide();
		} else {
			$('#search_equipo').show();
		}
	});
	$(document).on("click", ".filtro-direccion", function () {
		if ($('.lista-direcciones').is(':hidden')) {
			$('.lista-direcciones').css({display : "flex"});
		}else {
			$('.lista-direcciones').css({display : "none"});
		}
	});
	$(document).on("click", ".filtro-departamento", function () {
		if ($('.lista-departamentos').is(':hidden')) {
			$('.lista-departamentos').css({display : "flex"});
		}else {
			$('.lista-departamentos').css({display : "none"});
		}
	});

	//Eventos cuando selccione algun departamento
	$(document).on("click", ".opcion-departamento", function () {
		if ($(this).hasClass("active")) {
			$(this).toggleClass("active");
			departamento = null;
		} else {
			$(".lista-departamentos").children().removeClass("active");
			$(this).toggleClass("active");
			departamento = $(this).attr("idDepartamento");
			//console.log("departamento " + departamento);
		}
	});

	//Evento de cuando clique una dependencia
	$(document).on("click", ".opcion-dependecia", function () {
		if ($(this).hasClass("active")) {
			$(this).toggleClass("active");
			dependencia = null;
		} else {
			$(".lista-dependecias").children().removeClass("active");
			$(this).toggleClass("active");
			dependencia = $(this).attr("idDependecia");
			//console.log("dependecia " + dependecia);
		}
	});

	//Evento de cuando clique una dirección
	$(document).on("click", ".opcion-direccion", function () {
		if ($(this).hasClass("active")) {
			$(this).toggleClass("active");
			direccion = null;
		} else {
			$(".lista-direcciones").children().removeClass("active");
			$(this).toggleClass("active");
			direccion = $(this).attr("idDireccion");
			//console.log("direccion " + direccion);
		}
	});

	//Evento de cuando el administrador busque los reportes por filtro
	$("#search_equipo").keyup(function (ev) {
		if ($("#search_equipo").val()) {
			$(".opciones-busqueda-equipo").css("display", "block");
			let search_equipo = $("#search_equipo").val();
			//console.log(search_usuario)
			$.ajax({
				url: "administrador/buscar_equipo",
				type: "POST",
				data: { search_equipo },
				success: function (data) {
					let equipos = JSON.parse(data);
					let template = "";
					if (equipos) {
						equipos.forEach((element) => {
							template += ` <p class="opcion-equipo" idEquipo="${element.id_equipo}">${element.nombre}</p> `;
						});
					} else {
						template = "";
					}
					$(".opciones-busqueda-equipo").html(template);
				},
			});
		} else {
			equipo = null;
			template = "";
			$(".opciones-busqueda-equipo").html(template);
		}
	});

	$(document).on("click", ".opcion-equipo", function () {
		let elemento = $(this)[0];
		equipo = $(elemento).attr("idEquipo");
		$("#search_equipo").val($(this).text());
		$(".opciones-busqueda-equipo").css("display", "none");
	});

	//Evento de cuando clique en enviar filtros
	$(document).on("click", "#aplicar-filtros", function () {
		let fecha_inicio = $("#fecha_inicio").val();
		let fecha_fin = $("#fecha_fin").val();
		$.post(
			"administrador/filtrar_incidencias",
			{ dependencia, direccion, departamento, fecha_inicio, fecha_fin, equipo },
			function (response) {
				obtenerIncidencias(response);
			}
		);
		$(".mensaje").css({ visibility: "hidden" });
		$(".contenedor-mensaje").css({ transform: "translateY(-200%)" });
	});

	//Habilitar los campos del formulario
	$("#tipo_usuario").change(function () {
		if ($("#tipo_usuario").val() !== "0") {
			$("#departamento").prop("disabled", false);
		} else {
			$("#departamento").prop("disabled", "disabled");
			$(".departamento_indefinido").prop("selected", "selected");
		}
	});

	//Evento de cuando el administrador un equipo por su IP al ingresar un usuario nuevo
	$("#direccion_ip").keyup(function (ev) {
		if ($("#direccion_ip").val()) {
			$(".opciones_busqueda_ip").css("display", "block");
			let search_IP = $("#direccion_ip").val();
			//console.log(search_IP)
			$.ajax({
				url: baseUrl + "/usuarios/buscar_direccionIP",
				type: "POST",
				data: { search_IP },
				success: function (data) {
					let equipos = JSON.parse(data);
					let template = "";
					if (equipos) {
						equipos.forEach((element) => {
							template += ` <p class="opcion_equipo_ip" idEquipo="${element.id_equipo}">${element.direccion_ip}</p> `;
						});
					} else {
						template = "";
					}
					$(".opciones_busqueda_ip").html(template);
				},
			});
		} else {
			template = "";
			$(".opciones_busqueda_ip").css("display", "none");
			$(".opciones_busqueda_ip").html(template);
			$("#direccion_ip").removeAttr("idEquipo");
		}
	});
	
	//Detectar si cambia el campo de la direccion ip a la hora de modificar usuario
	$(document).on("change", "#direccion_ip", function () {
		id_equipo_modif = 1;
	});

	//Detectar si cambia el campo de la direccion a la hora de modificar usuario
	$(document).on("change", "#direccion", function () {
		id_direccion_modif = 1;
	});

	//Evento de cuando clique en enviar filtros
	$(document).on("click", ".opcion_equipo_ip", function () {
		let elemento = $(this)[0];
		$("#direccion_ip").val($(this).text());
		$("#direccion_ip").attr("idEquipo", $(elemento).attr("idEquipo"));
		$(".opciones_busqueda_ip").css("display", "none");
	});

	//Evento cuando se clica guardar los datos a la hora de guardar un usuario
	$("#btn_guardar_usuario").click(function (ev) {
		let nombre = $("#nombre").val();
		let apellido_paterno = $("#apellido_paterno").val();
		let apellido_materno = $("#apellido_materno").val();
		let email = $("#email").val();
		let password = $("#contraseña").val();
		let id_direccion = $("#direccion").val();
		let id_rol = $("#tipo_usuario").val();
		let id_departamento = $("#departamento").val();
		let id_equipo = $("#direccion_ip").attr("idEquipo");
		$.ajax({
			url: "usuarios/guardar_usuario",
			type: "POST",
			data: {
				nombre,
				apellido_paterno,
				apellido_materno,
				email,
				password,
				id_direccion,
				id_rol,
				id_departamento,
				id_equipo,
			},
			success: function (data) {
				let json = JSON.parse(data);
				$(".titulo-mensaje").html(`<b><h1>${json.msg}</h1></b>`);
				$(".mensaje").css({ visibility: "visible" });
				$(".contenedor_mensaje_guardar_usuario").css({
					transform: "translateY(0%)",
				});
				$(document).on("click", ".cerrar_ventana_guardar_usuario", function () {
					$(".mensaje").css({ visibility: "hidden" });
					$(".contenedor_mensaje_guardar_usuario").css({
						transform: "translateY(-200%)",
					});
					window.location.replace(json.url);
				});
			},
			statusCode: {
				400: function (xhr) {
					let json = JSON.parse(xhr.responseText);
					//Para mostrar los mensajes de error en caso de tener en los campos del formulario
					if (json.nombre !== "") {
						$(".error_message_nombre").css({ transform: "translateY(0px)" });
						$(".error_message_nombre").css({ "z-index": "1" });
						$(".error_message_nombre").html(`<p>${json.nombre}</p>`);
					}

					if (json.apellido_paterno !== "") {
						$(".error_message_apellidoP").css({ transform: "translateY(0px)" });
						$(".error_message_apellidoP").css({ "z-index": "1" });
						$(".error_message_apellidoP").html(
							`<p>${json.apellido_paterno}</p>`
						);
					}

					if (json.apellido_materno !== "") {
						$(".error_message_apellidoM").css({ transform: "translateY(0px)" });
						$(".error_message_apellidoM").css({ "z-index": "1" });
						$(".error_message_apellidoM").html(
							`<p>${json.apellido_materno}</p>`
						);
					}

					if (json.email !== "") {
						$(".error_message_email").css({ transform: "translateY(0px)" });
						$(".error_message_email").css({ "z-index": "1" });
						$(".error_message_email").html(`<p>${json.email}</p>`);
					}

					if (json.password !== "") {
						$(".error_message_password").css({ transform: "translateY(0px)" });
						$(".error_message_password").css({ "z-index": "1" });
						$(".error_message_password").html(`<p>${json.password}</p>`);
					}

					if (json.id_equipo !== "") {
						$(".error_message_direccionIP").css({
							transform: "translateY(0px)",
						});
						$(".error_message_direccionIP").css({ "z-index": "1" });
						$(".error_message_direccionIP").html(`<p>${json.id_equipo}</p>`);
					}
				},
			},
		});
		ev.preventDefault();
	});

	//Evento cuando se clica guardar los cambios de los datos del usuario
	$("#btn_guardar_cambios_usuario").click(function (ev) {
        let no_empleado = $(this).attr("noEmpleado");
		let nombre = $("#nombre").val();
		let apellido_paterno = $("#apellido_paterno").val();
		let apellido_materno = $("#apellido_materno").val();
		let email = $("#email").val();
		let password = $("#contraseña").val();
		let id_direccion = $("#direccion").val();
		let id_rol = $("#tipo_usuario").val();
		let id_departamento = $("#departamento").val();
		let id_equipo = $("#direccion_ip").attr("idEquipo");
        // console.log("Empleado " + no_empleado)
		// console.log(nombre);
		// console.log(apellido_paterno);
		// console.log(apellido_materno);
		// console.log(email);
		// console.log(password);
		// console.log(id_direccion);
		// console.log(id_rol);
		// console.log(id_departamento);
		// console.log(id_equipo);
		$.ajax({
		    url: baseUrl + "/usuarios/actualizar_usuario",
		    type: 'POST',
		    data: {id_direccion_modif, id_equipo_modif, no_empleado, nombre, apellido_paterno, apellido_materno, email, password, id_direccion, id_rol, id_departamento, id_equipo},
		    success: function(data) {
		        let json = JSON.parse(data);
		        $(".titulo-mensaje").html(`<b><h1>${json.msg}</h1></b>`);
		        $('.mensaje').css({'visibility':'visible'});
		        $('.contenedor_mensaje_guardar_usuario').css({'transform':'translateY(0%)'});
		        $(document).on('click', '.cerrar_ventana_guardar_usuario', function(){
		            $('.mensaje').css({'visibility':'hidden'});
		            $('.contenedor_mensaje_guardar_usuario').css({'transform':'translateY(-200%)'});
		            window.location.replace(json.url);
		        });
		    },
		    statusCode: {
		        400: function(xhr) {
		            let json = JSON.parse(xhr.responseText);
		            //Para mostrar los mensajes de error en caso de tener en los campos del formulario
		            if (json.nombre !== ""){
		                $('.error_message_nombre').css({'transform':'translateY(0px)'});
		                $('.error_message_nombre').css({'z-index':'1'});
		                $(".error_message_nombre").html(`<p>${json.nombre}</p>`);
		            }

		            if (json.apellido_paterno !== "") {
		                $('.error_message_apellidoP').css({'transform':'translateY(0px)'});
		                $('.error_message_apellidoP').css({'z-index':'1'});
		                $(".error_message_apellidoP").html(`<p>${json.apellido_paterno}</p>`);
		            }

		            if (json.apellido_materno !== "") {
		                $('.error_message_apellidoM').css({'transform':'translateY(0px)'});
		                $('.error_message_apellidoM').css({'z-index':'1'});
		                $(".error_message_apellidoM").html(`<p>${json.apellido_materno}</p>`);
		            }

		            if (json.email !== "") {
		                $('.error_message_email').css({'transform':'translateY(0px)'});
		                $('.error_message_email').css({'z-index':'1'});
		                $(".error_message_email").html(`<p>${json.email}</p>`);
		            }

		            if (json.password !== "") {
		                $('.error_message_password').css({'transform':'translateY(0px)'});
		                $('.error_message_password').css({'z-index':'1'});
		                $(".error_message_password").html(`<p>${json.password}</p>`);
		            }

		            if (json.id_equipo !== "") {
		                $('.error_message_direccionIP').css({'transform':'translateY(0px)'});
		                $('.error_message_direccionIP').css({'z-index':'1'});
		                $(".error_message_direccionIP").html(`<p>${json.id_equipo}</p>`);
		            }
		        }
		    },
		});
		ev.preventDefault();
	});

	//Funciones para ocultar los mensajes de error del formulario cuando el usuario comience a escribir
	$(document).on("keyup", ("#nombre"), function () {
		$(".error_message_nombre").css({ transform: "translateY(-10px)" });
		$(".error_message_nombre").css({ "z-index": "-1" });
	});

	$(document).on("keyup", ("#nombre_equipo"), function () {
		$(".error_message_nombre").css({ transform: "translateY(-30px)" });
		$(".error_message_nombre").css({ "z-index": "-1" });
	});

	$(document).on("keyup", "#apellido_paterno", function () {
		$(".error_message_apellidoP").css({ transform: "translateY(-10px)" });
		$(".error_message_apellidoP").css({ "z-index": "-1" });
	});

	$(document).on("keyup", "#apellido_materno", function () {
		$(".error_message_apellidoM").css({ transform: "translateY(-10px)" });
		$(".error_message_apellidoM").css({ "z-index": "-1" });
	});

	$(document).on("keyup", "#email", function () {
		$(".error_message_email").css({ transform: "translateY(-10px)" });
		$(".error_message_email").css({ "z-index": "-1" });
	});

	$(document).on("keyup", "#contraseña", function () {
		$(".error_message_password").css({ transform: "translateY(-10px)" });
		$(".error_message_password").css({ "z-index": "-1" });
	});

	$(document).on("keyup", ("#direccion_ip"), function () {
		$(".error_message_direccionIP").css({ transform: "translateY(-10px)" });
		$(".error_message_direccionIP").css({ "z-index": "-1" });
	});

	$(document).on("keyup", ("#direccion_ip_equipo"), function () {
		$(".error_message_direccionIP").css({ transform: "translateY(-30px)" });
		$(".error_message_direccionIP").css({ "z-index": "-1" });
	});

	$(document).on("keyup", "#segmento_red_equipo", function () {
		$(".error_message_segmento_red").css({ transform: "translateY(-30px)" });
		$(".error_message_segmento_red").css({ "z-index": "-1" });
	});

	$(document).on("keyup", "#serie_equipo", function () {
		$(".error_message_serie").css({ transform: "translateY(-30px)" });
		$(".error_message_serie").css({ "z-index": "-1" });
	});

	$(document).on("keyup", "#sistema_operativo_equipo", function () {
		$(".error_message_sistema_operativo").css({ transform: "translateY(-30px)" });
		$(".error_message_sistema_operativo").css({ "z-index": "-1" });
	});

	$(document).on("keyup", "#marca_equipo", function () {
		$(".error_message_marca").css({ transform: "translateY(-30px)" });
		$(".error_message_marca").css({ "z-index": "-1" });
	});

	$(document).on("keyup", "#inventario_equipo", function () {
		$(".error_message_inventario").css({ transform: "translateY(-30px)" });
		$(".error_message_inventario").css({ "z-index": "-1" });
	});

	$(document).on("keyup", "#procesador_equipo", function () {
		$(".error_message_procesador").css({ transform: "translateY(-30px)" });
		$(".error_message_procesador").css({ "z-index": "-1" });
	});

	//Función para dar de baja o de alta algún empleado
	$(document).on("click", "#status_empleado", function () {
		let status;
		let no_empleado = $(this).val();

		var opcion = confirm(
			"¿Está seguro de cambiar el estatus actual del trabajador?"
		);
		if (opcion == true) {
			if ($(this).is(":checked")) {
				// Hacer algo si el checkbox ha sido seleccionado
				status = 1;
				$.post("modificar_status", { status, no_empleado });
				// obtenerListaCompletaUsuarios ();
			} else {
				// Hacer algo si el checkbox ha sido deseleccionado
				status = 0;
				$.post("modificar_status", { status, no_empleado });
				// obtenerListaCompletaUsuarios ();
			}
		} else {
			//console.log("No paso nada");
			obtenerListaCompletaUsuarios();
		}
	});

	//Función para dar de baja o de alta algún equipo
	$(document).on("click", "#status_equipo", function () {
		let status;
		let id_equipo = $(this).val();
		let direccion_ip = $(this).attr("direccionIP");

		var opcion = confirm(
			"¿Está seguro de cambiar el estatus actual del equipo?"
		);
		if (opcion == true) {
			if ($(this).is(":checked")) {
				// Hacer algo si el checkbox ha sido seleccionado
				status = 1;
				$.post("modificar_status", { status, id_equipo, direccion_ip }, function (response) {
					if(response){
						let json = JSON.parse(response);
						$(".titulo-mensaje").html(`<b><h1>${json.msg}</h1></b>`);
						$('.mensaje').css({'visibility':'visible'});
						$('.contenedor_mensaje_guardar_usuario').children("img").attr("src",$('.contenedor_mensaje_guardar_usuario').children("img").attr("correcto"));
						$('.contenedor_mensaje_guardar_usuario').css({'transform':'translateY(0%)'});
						$(document).on('click', '.cerrar_ventana_listar_equipos', function(){
							$('.mensaje').css({'visibility':'hidden'});
							$('.contenedor_mensaje_guardar_usuario').css({'transform':'translateY(-200%)'});
							obtenerListaCompletaEquipos();
						});
					}
				});
			} else {
				// Hacer algo si el checkbox ha sido deseleccionado
				status = 0;
				$.post("modificar_status", { status, id_equipo, direccion_ip}, function (response) {
					if(response){
						let json = JSON.parse(response);
						$(".titulo-mensaje").html(`<b><h1>${json.msg}</h1></b>`);
						$('.mensaje').css({'visibility':'visible'});
						$('.contenedor_mensaje_guardar_usuario').children("img").attr("src",$('.contenedor_mensaje_guardar_usuario').children("img").attr("correcto"));
						$('.contenedor_mensaje_guardar_usuario').css({'transform':'translateY(0%)'});
						$(document).on('click', '.cerrar_ventana_listar_equipos', function(){
							$('.mensaje').css({'visibility':'hidden'});
							$('.contenedor_mensaje_guardar_usuario').css({'transform':'translateY(-200%)'});
							obtenerListaCompletaEquipos();
						});
					}
				});	
			}
			obtenerListaCompletaEquipos();
		} else {
			//console.log("No paso nada");
			obtenerListaCompletaEquipos();
		}
	});

	//Evento de cuando clique una dependencia en filtros de listado de usuarios
	$(document).on("click", ".opcion_dependencia_usuarios", function () {
		if ($(this).hasClass("active")) {
			$(this).toggleClass("active");
			dependencia = null;
		} else {
			$(".lista_dependencias_usuarios").children().removeClass("active");
			$(this).toggleClass("active");
			dependencia = $(this).attr("idDependencia");
			//console.log("dependencia " + dependencia);
		}
	});

	//Evento de cuando clique una dirección en filtros de listado de usuarios
	$(document).on("click", ".opcion_direccion_usuarios", function () {
		if ($(this).hasClass("active")) {
			$(this).toggleClass("active");
			direccion = null;
		} else {
			$(".lista_direcciones_usuarios").children().removeClass("active");
			$(this).toggleClass("active");
			direccion = $(this).attr("idDireccion");
			//console.log("direccion " + direccion);
		}
	});

	//Evento de cuando clique una departamento en filtros de listado de usuarios
	$(document).on("click", ".opcion_departamento_usuarios", function () {
		if ($(this).hasClass("active")) {
			$(this).toggleClass("active");
			departamento = null;
		} else {
			$(".lista_departamentos_usuarios").children().removeClass("active");
			$(this).toggleClass("active");
			departamento = $(this).attr("idDepartamento");
			//console.log("departamento " + departamento);
		}
	});

	//Evento de cuando clique una opcion de tipo de usuario en filtros de listado de usuarios
	$(document).on("click", ".opcion_tipo_usuarios", function () {
		if ($(this).hasClass("active")) {
			$(this).toggleClass("active");
			rol = null;
		} else {
			$(".lista_tipos_usuarios").children().removeClass("active");
			$(this).toggleClass("active");
			rol = $(this).attr("rol");
			//console.log("rol " + rol);
		}
	});

	//Evento de cuando clique una opcion de status de usuario en filtros de listado de usuarios
	$(document).on("click", ".opcion_status_usuarios", function () {
		if ($(this).hasClass("active")) {
			$(this).toggleClass("active");
			status = null;
		} else {
			$(".lista_status_usuarios").children().removeClass("active");
			$(this).toggleClass("active");
			status = $(this).attr("status");
			//console.log("status " + status);
		}
	});

	//Evento de cuando clique una opcion de tipo de equipo
	$(document).on("click", ".opcion_tipo_equipo", function () {
		if ($(this).hasClass("active")) {
			$(this).toggleClass("active");
			tipo_equipo = null;
		} else {
			$(".lista_tipo_equipo").children().removeClass("active");
			$(this).toggleClass("active");
			tipo_equipo = $(this).attr("tipoEquipo");
		}
	});

	//Evento de cuando clique una opcion de status de usuario en filtros de listado de usuarios
	$(document).on("click", ".titulo_filtro_usuarios", function () {
        if ($(this).attr("idFiltroUsuario") == '1') {
            if ($('.lista_dependencias_usuarios').is(':hidden')) {
                $(this).css({ background: "#f6f8fa" });
                $("h2", this).css('color', '#006e95');
                $(".marcar_filtro_seleccionado", this).css({ transform: "translatex(0%)" });
                $(".lista_dependencias_usuarios").css({ display: "flex" });
            }else {
                $("h2", this).css('color', '#006e95');
                $(this).css({ 'background-color': "#fff" });
                $(".marcar_filtro_seleccionado", this).css({ transform: "translatex(255px)" });
                $(".lista_dependencias_usuarios").css({ display: "none" });
            }
        }

        if ($(this).attr("idFiltroUsuario") == '2') {
            if ($('.lista_direcciones_usuarios').is(':hidden')) {
                $(this).css({ background: "#f6f8fa" });
                $("h2", this).css('color', '#006e95');
                $(".marcar_filtro_seleccionado", this).css({ transform: "translatex(0%)" });
                $(".lista_direcciones_usuarios").css({ display: "flex" });
            }else {
                $("h2", this).css('color', '#006e95');
                $(this).css({ background: "#fff" });
                $(".marcar_filtro_seleccionado", this).css({ transform: "translatex(255px)" });
                $(".lista_direcciones_usuarios").css({ display: "none" });
            }
        }

        if ($(this).attr("idFiltroUsuario") == '3') {
            if ($('.lista_departamentos_usuarios').is(':hidden')) {
                $(this).css({ background: "#f6f8fa" });
                $("h2", this).css('color', '#006e95');
                $(".marcar_filtro_seleccionado", this).css({ transform: "translatex(0%)" });
                $(".lista_departamentos_usuarios").css({ display: "flex" });
            }else {
                $("h2", this).css('color', '#006e95');
                $(this).css({ background: "#fff" });
                $(".marcar_filtro_seleccionado", this).css({ transform: "translatex(255px)" });
                $(".lista_departamentos_usuarios").css({ display: "none" });
            }
        }

        if ($(this).attr("idFiltroUsuario") == '4') {
            if ($('.lista_tipos_usuarios').is(':hidden')) {
                $(this).css({ background: "#f6f8fa" });
                $("h2", this).css('color', '#006e95');
                $(".marcar_filtro_seleccionado", this).css({ transform: "translatex(0%)" });
                $(".lista_tipos_usuarios").css({ display: "flex" });
            }else {
                $("h2", this).css('color', '#006e95');
                $(this).css({ background: "#fff" });
                $(".marcar_filtro_seleccionado", this).css({ transform: "translatex(255px)" });
                $(".lista_tipos_usuarios").css({ display: "none" });
            }
        }

        if ($(this).attr("idFiltroUsuario") == '5') {
            if ($('.lista_status_usuarios').is(':hidden')) {
                $(this).css({ background: "#f6f8fa" });
                $("h2", this).css('color', '#006e95');
                $(".marcar_filtro_seleccionado", this).css({ transform: "translatex(0%)" });
                $(".lista_status_usuarios").css({ display: "flex" });
            }else {
                $("h2", this).css('color', '#006e95');
                $(this).css({ background: "#fff" });
                $(".marcar_filtro_seleccionado", this).css({ transform: "translatex(255px)" });
                $(".lista_status_usuarios").css({ display: "none" });
            }
        }
		if ($(this).attr("idFiltroUsuario") == '6') {
            if ($('.lista_tipo_equipo').is(':hidden')) {
                $(this).css({ background: "#f6f8fa" });
                $("h2", this).css('color', '#006e95');
                $(".marcar_filtro_seleccionado", this).css({ transform: "translatex(0%)" });
                $(".lista_tipo_equipo").css({ display: "flex" });
            }else {
                $("h2", this).css('color', '#006e95');
                $(this).css({ background: "#fff" });
                $(".marcar_filtro_seleccionado", this).css({ transform: "translatex(255px)" });
                $(".lista_tipo_equipo").css({ display: "none" });
            }
        }
	});

	//Evento de cuando clique en enviar filtros
	$(document).on("click", ".aplicar_filtros_usuarios", function () {
		//Listar a todos los usuarios solo cuando este la url correcta
		if (getUrl == baseUrl + "/usuarios/lista_usuarios") {
			$.post(
				"filtrar_usuarios",
				{ dependencia, direccion, departamento, rol, status },
				function (response) {
					obtenerListaUsuarios(response);
				}
			);
		}

		//Listar a todos los equipos solo cuando este la url correcta
		if (getUrl == baseUrl + "/equipos/lista_equipos") {
			$.post(
				"filtrar_equipos",
				{ dependencia, direccion, tipo_equipo, status },
				function (response) {
					obtenerListaEquipos(response);
				}
			);
		}
	});

    //Evento de cuando clique en ocultar los filtros
	$(document).on("click", ".ocultar_filtros", function () {
        if ($('.filtros_lista_usurios').is(':hidden')) {
            $(".filtros_lista_usurios").css({ display: "block" });
            $(this).children("img").css('transform', 'rotate(180deg)');
        }else {
            $(".filtros_lista_usurios").css({ display: "none" });
            $(this).children("img").css('transform', 'rotate(0deg)');
        }
	});

	//Evento que se ejecuta cuando el usuario este escribiendo en la barra de busqueda
    $("#search_usuario").keyup(function(ev) {
        $('.opciones_busqueda_usuario').css('visibility','visible');
        if($('#search_usuario').val()){
            let search_usuario = $('#search_usuario').val();
            //console.log(search_usuario)

            $.ajax({
                url: baseUrl+'/equipos/buscar_empleado',
                type: 'POST',
                data: { search_usuario },
                success: function(data) {
                    let empleados = JSON.parse(data);
					//console.log(empleados);
                    let template = "";
                    if (empleados){
                        empleados.forEach(element => {
                            template += ` <p class="opcion_empleado" no_empleado="${element.no_empleado}">${element.nombre + " " + element.apellido_paterno + " " + element.apellido_materno}</p>`;
                        });
                    }else {
                        template = "";
                    }
                    $('.opciones_busqueda_usuario').html(template);
                }
            });
        }else {
            template = "";
            $('.opciones_busqueda_usuario').html(template);
			$('.opciones_busqueda_usuario').css('visibility','hidden');
			$('#search_usuario').attr("no_empleado",null);
        }
    });

	let no_empleados_modif = 0;
	$(document).on("click", ".opcion_empleado", function () {
		let elemento = $(this)[0];
		let no_empleados = [];
		$(".nombres_empleados_asociados div.tarjeta_empleado_asociado").each(function(){
			no_empleados.push($(this).attr("no_empleado"));
		});
		//Comprobar si el empleado ya existe en la lista de asociados y no agregarlo
		if (!no_empleados.includes($(elemento).attr("no_empleado"))){
			$('.opciones_busqueda_usuario').css('visibility','hidden');
			$(".nombres_empleados_asociados" ).append(`
				<div no_empleado="${$(elemento).attr("no_empleado")}" class="tarjeta_empleado_asociado">
					<p class="nombre_tarjeta_empleado_asociado">${$(this).text()}</p>
					<div class="quitar_empleado_asociado">
						<p>x</p>
					</div>
				</div>
			`);
			no_empleados_modif = 1;
			$("#search_usuario").val("");	
		}
	});

	//Función que se ejecuta cuando se clique en la x para quitar el usuario asociado
	$(document).on("click", ".quitar_empleado_asociado", function () {
		$(this).parent().remove();
		no_empleados_modif = 1;
	});

	//Habilitar los campos del formulario
	$("#tipo_equipo").change(function () {
		if ($("#tipo_equipo").val() === "Impresora") {
			$("#search_usuario").prop("disabled", "disabled");
			$('#search_usuario').attr("no_empleado",null);
			$('#search_usuario').val("");
			$("#invetario_monitor").prop("disabled", "disabled");
			$("#serie_monitor").prop("disabled", "disabled");
			$("#teclado_equipo").prop("disabled", "disabled");
			$("#cantidad_ram_equipo").prop("disabled", "disabled");
			$("#mause_equipo").prop("disabled", "disabled");
			$("#marca_monitor").prop("disabled", "disabled");
			$("#disco_duro_equipo").prop("disabled", "disabled");
			$("#dvd_equipo").prop("disabled", "disabled");
			$("#tamaño_monitor").prop("disabled", "disabled");
			$(".nombres_empleados_asociados").empty()
		} else {
			$("#search_usuario").prop("disabled", false);
			$("#invetario_monitor").prop("disabled", false);
			$("#serie_monitor").prop("disabled", false);
			$("#teclado_equipo").prop("disabled", false);
			$("#cantidad_ram_equipo").prop("disabled", false);
			$("#mause_equipo").prop("disabled", false);
			$("#marca_monitor").prop("disabled", false);
			$("#disco_duro_equipo").prop("disabled", false);
			$("#dvd_equipo").prop("disabled", false);
			$("#tamaño_monitor").prop("disabled", false);
		}
	});

	//Evento de cuando clique en guardar datos del equipo
	$(document).on("click", ".guardar_equipo", function () {
		let no_empleados = [];
		$(".nombres_empleados_asociados div.tarjeta_empleado_asociado").each(function(){
			no_empleados.push($(this).attr("no_empleado"));
		});
		let nombre = $("#nombre_equipo").val();
		let tipo_equipo = $("#tipo_equipo").val();
		let id_direccion = $("#direccion_equipo").val();
		let sistema_operativo = $("#sistema_operativo_equipo").val();
		let marca = $("#marca_equipo").val();
		let inventario = $("#inventario_equipo").val();
		let serie = $("#serie_equipo").val();
		let direccion_ip = $("#direccion_ip_equipo").val();
		let teclado, mouse, dvd, ram, disco_duro, inventario_monitor, serie_monitor, marca_monitor, tamano_monitor;
		let procesador = $("#procesador_equipo").val();
		let segmento_de_red = $("#segmento_red_equipo").val();
		let observaciones = $("#observaciones_equipo").val();
		if($("#tipo_equipo").val() === "Impresora"){
			teclado = null;
			mouse = null;
			dvd = null;
			ram = null;
			disco_duro = null;
			inventario_monitor = null;
			serie_monitor = null;
			marca_monitor = null;
			tamano_monitor = null;
		}else{
			teclado = $("#teclado_equipo").val();
			mouse = $("#mause_equipo").val();
			dvd = $("#dvd_equipo").val();
		 	ram = $("#cantidad_ram_equipo").val();
		 	disco_duro = $("#disco_duro_equipo").val();
		 	inventario_monitor = $("#invetario_monitor").val();
		 	serie_monitor = $("#serie_monitor").val();
		 	marca_monitor = $("#marca_monitor").val();
		 	tamano_monitor = $("#tamaño_monitor").val();
		}
        //console.log("Empleados " + no_empleados)
		// console.log(nombre);
		// console.log(tipo_equipo);
		// console.log(id_direccion);
		// console.log(sistema_operativo);
		// console.log(marca);
		// console.log(inventario);
		// console.log(serie);
		// console.log(direccion_ip);
		// console.log(teclado);
		// console.log(mouse);
		// console.log(dvd);
		// console.log(procesador);
		// console.log(segmento_de_red);
		// console.log(ram);
		// console.log(disco_duro);
		// console.log(inventario_monitor);
		// console.log(serie_monitor);
		// console.log(marca_monitor);
		// console.log(tamano_monitor);
		// console.log(observaciones);
		// console.log($(".nombres_empleados_asociados").children().length);
		$.ajax({
		    url: "equipos/guardar_equipo",
		    type: 'POST',
		    data: {no_empleados, nombre, tipo_equipo, id_direccion, sistema_operativo, marca, inventario, serie, direccion_ip, teclado, mouse, dvd, procesador, segmento_de_red, ram, disco_duro, inventario_monitor, serie_monitor, marca_monitor, tamano_monitor, observaciones},
		    success: function(data) {
		        let json = JSON.parse(data);
		        $(".titulo-mensaje").html(`<b><h1>${json.msg}</h1></b>`);
				if(json.msg === "Equipo agregado correctamente"){
					$('.contenedor_mensaje_guardar_usuario').children("img").attr("src",$('.contenedor_mensaje_guardar_usuario').children("img").attr("correcto"));
				}else{
					$('.contenedor_mensaje_guardar_usuario').children("img").attr("src",$('.contenedor_mensaje_guardar_usuario').children("img").attr("incorrecto"));
					$('.contenedor_mensaje_guardar_usuario').children("img").css({width: "200px"});
				}
		        $('.mensaje').css({'visibility':'visible'});
		        $('.contenedor_mensaje_guardar_usuario').css({'transform':'translateY(0%)'});
		        $(document).on('click', '.cerrar_ventana_guardar_usuario', function(){
		            $('.mensaje').css({'visibility':'hidden'});
		            $('.contenedor_mensaje_guardar_usuario').css({'transform':'translateY(-200%)'});
		            window.location.replace(json.url);
		        });
		    },
		    statusCode: {
		        400: function(xhr) {
		            let json = JSON.parse(xhr.responseText);
		            //Para mostrar los mensajes de error en caso de tener en los campos del formulario
					//console.log(json);
		            if (json.nombre !== ""){
		                $('.error_message_nombre').css({'transform':'translateY(0px)'});
		                $('.error_message_nombre').css({'z-index':'1'});
		                $(".error_message_nombre").html(`<p>${json.nombre}</p>`);
		            }

		            if (json.segmento_de_red !== "") {
		                $('.error_message_segmento_red').css({'transform':'translateY(0px)'});
		                $('.error_message_segmento_red').css({'z-index':'1'});
		                $(".error_message_segmento_red").html(`<p>${json.segmento_de_red}</p>`);
		            }

		            if (json.serie !== "") {
		                $('.error_message_serie').css({'transform':'translateY(0px)'});
		                $('.error_message_serie').css({'z-index':'1'});
		                $(".error_message_serie").html(`<p>${json.serie}</p>`);
		            }

		            if (json.sistema_operativo !== "") {
		                $('.error_message_sistema_operativo').css({'transform':'translateY(0px)'});
		                $('.error_message_sistema_operativo').css({'z-index':'1'});
		                $(".error_message_sistema_operativo").html(`<p>${json.sistema_operativo}</p>`);
		            }

		            if (json.marca !== "") {
		                $('.error_message_marca').css({'transform':'translateY(0px)'});
		                $('.error_message_marca').css({'z-index':'1'});
		                $(".error_message_marca").html(`<p>${json.marca}</p>`);
		            }

		            if (json.direccion_ip !== "") {
		                $('.error_message_direccionIP').css({'transform':'translateY(0px)'});
		                $('.error_message_direccionIP').css({'z-index':'1'});
		                $(".error_message_direccionIP").html(`<p>${json.direccion_ip}</p>`);
		            }

					if (json.inventario !== "") {
		                $('.error_message_inventario').css({'transform':'translateY(0px)'});
		                $('.error_message_inventario').css({'z-index':'1'});
		                $(".error_message_inventario").html(`<p>${json.inventario}</p>`);
		            }
					
					if (json.procesador !== "") {
		                $('.error_message_procesador').css({'transform':'translateY(0px)'});
		                $('.error_message_procesador').css({'z-index':'1'});
		                $(".error_message_procesador").html(`<p>${json.procesador}</p>`);
		            }
		        },
				500: function(xhr) {
					let json = JSON.parse(xhr.responseText);
		            //Para mostrar los mensajes de error en caso de tener en los campos del formulario	
					$(".titulo-mensaje").html(`<b><h1>${json.msg}</h1></b>`);
					$('.mensaje').css({'visibility':'visible'});
					$('.contenedor_mensaje_guardar_usuario').children("img").attr("src",$('.contenedor_mensaje_guardar_usuario').children("img").attr("incorrecto"));
					$('.contenedor_mensaje_guardar_usuario').css({'transform':'translateY(0%)'});
					$(document).on('click', '.cerrar_ventana_guardar_usuario', function(){
						$('.mensaje').css({'visibility':'hidden'});
						$('.contenedor_mensaje_guardar_usuario').css({'transform':'translateY(-200%)'});
					});
				}
		    },
		});
		
	});

	//--------------------------Editar datos del usuario-----------------------------------
	//Detectar si el campo de direccion ha cambiado
	let direccion_actual = $("#direccion_equipo").val();
	$("#direccion_equipo").change(function () {
		if(direccion_actual !== $("#direccion_equipo").val()){
			id_direccion_modif = 1;
		}else{
			id_direccion_modif = 0;
		}
	});

	$(document).on("change", ("#direccion_ip_equipo"), function () {
		direccion_ip_modif = 1;
	});

	//Evento de cuando clique en guardar datos del equipo
	$(document).on("click", ".guardar_cambios_equipo", function () {
		let no_empleados = [];
		$(".nombres_empleados_asociados div.tarjeta_empleado_asociado").each(function(){
			no_empleados.push($(this).attr("no_empleado"));
		});
		let nombre = $("#nombre_equipo").val();
		let tipo_equipo = $("#tipo_equipo").val();
		let id_direccion = $("#direccion_equipo").val();
		let sistema_operativo = $("#sistema_operativo_equipo").val();
		let marca = $("#marca_equipo").val();
		let inventario = $("#inventario_equipo").val();
		let serie = $("#serie_equipo").val();
		let direccion_ip = $("#direccion_ip_equipo").val();
		let teclado;
		let mouse;
		let dvd;
		let ram;
		let disco_duro;
		let inventario_monitor;
		let serie_monitor;
		let marca_monitor;
		let tamano_monitor;
		let procesador = $("#procesador_equipo").val();
		let segmento_de_red = $("#segmento_red_equipo").val();
		let observaciones = $("#observaciones_equipo").val();
		if($("#tipo_equipo").val() === "Impresora"){
			teclado = null;
			mouse = null;
			dvd = null;
			ram = null;
			disco_duro = null;
			inventario_monitor = null;
			serie_monitor = null;
			marca_monitor = null;
			tamano_monitor = null;
		}else{
			teclado = $("#teclado_equipo").val();
			mouse = $("#mause_equipo").val();
			dvd = $("#dvd_equipo").val();
		 	ram = $("#cantidad_ram_equipo").val();
		 	disco_duro = $("#disco_duro_equipo").val();
		 	inventario_monitor = $("#invetario_monitor").val();
		 	serie_monitor = $("#serie_monitor").val();
		 	marca_monitor = $("#marca_monitor").val();
		 	tamano_monitor = $("#tamaño_monitor").val();
		}
		let id_equipo = $('.guardar_cambios_equipo').attr('id_equipo');
		// console.log(id_direccion_modif);
		// console.log(no_empleados_modif);
		// console.log(id_equipo);
        // console.log("Empleados " + no_empleados)
		// console.log(nombre);
		// console.log(tipo_equipo);
		// console.log(id_direccion);
		// console.log(sistema_operativo);
		// console.log(marca);
		// console.log(inventario);
		// console.log(serie);
		// console.log(direccion_ip);
		// console.log(teclado);
		// console.log(mouse);
		// console.log(dvd);
		// console.log(procesador);
		// console.log(segmento_de_red);
		// console.log(ram);
		// console.log(disco_duro);
		// console.log(inventario_monitor);
		// console.log(serie_monitor);
		// console.log(marca_monitor);
		// console.log(tamano_monitor);
		// console.log(observaciones);
		$.ajax({
		    url: baseUrl + "/equipos/actualizar_equipo",
		    type: 'POST',
		    data: {direccion_ip_modif, no_empleados, nombre, tipo_equipo, id_direccion, sistema_operativo, marca, inventario, serie, direccion_ip, teclado, mouse, dvd, procesador, segmento_de_red, ram, disco_duro, inventario_monitor, serie_monitor, marca_monitor, tamano_monitor, observaciones, id_direccion_modif, no_empleados_modif, id_equipo},
		    success: function(data) {
		        let json = JSON.parse(data);
		        $(".titulo-mensaje").html(`<b><h1>${json.msg}</h1></b>`);
		        $('.mensaje').css({'visibility':'visible'});
				$('.contenedor_mensaje_guardar_usuario').children("img").attr("src",$('.contenedor_mensaje_guardar_usuario').children("img").attr("correcto"));
		        $('.contenedor_mensaje_guardar_usuario').css({'transform':'translateY(0%)'});
		        $(document).on('click', '.cerrar_ventana_guardar_usuario', function(){
		            $('.mensaje').css({'visibility':'hidden'});
		            $('.contenedor_mensaje_guardar_usuario').css({'transform':'translateY(-200%)'});
		            window.location.replace(json.url);
		        });
		    },
		    statusCode: {
		        400: function(xhr) {
		            let json = JSON.parse(xhr.responseText);
		            //Para mostrar los mensajes de error en caso de tener en los campos del formulario
					//console.log(json);
		            if (json.nombre !== ""){
		                $('.error_message_nombre').css({'transform':'translateY(0px)'});
		                $('.error_message_nombre').css({'z-index':'1'});
		                $(".error_message_nombre").html(`<p>${json.nombre}</p>`);
		            }

		            if (json.segmento_de_red !== "") {
		                $('.error_message_segmento_red').css({'transform':'translateY(0px)'});
		                $('.error_message_segmento_red').css({'z-index':'1'});
		                $(".error_message_segmento_red").html(`<p>${json.segmento_de_red}</p>`);
		            }

		            if (json.serie !== "") {
		                $('.error_message_serie').css({'transform':'translateY(0px)'});
		                $('.error_message_serie').css({'z-index':'1'});
		                $(".error_message_serie").html(`<p>${json.serie}</p>`);
		            }

		            if (json.sistema_operativo !== "") {
		                $('.error_message_sistema_operativo').css({'transform':'translateY(0px)'});
		                $('.error_message_sistema_operativo').css({'z-index':'1'});
		                $(".error_message_sistema_operativo").html(`<p>${json.sistema_operativo}</p>`);
		            }

		            if (json.marca !== "") {
		                $('.error_message_marca').css({'transform':'translateY(0px)'});
		                $('.error_message_marca').css({'z-index':'1'});
		                $(".error_message_marca").html(`<p>${json.marca}</p>`);
		            }

		            if (json.direccion_ip !== "") {
		                $('.error_message_direccionIP').css({'transform':'translateY(0px)'});
		                $('.error_message_direccionIP').css({'z-index':'1'});
		                $(".error_message_direccionIP").html(`<p>${json.direccion_ip}</p>`);
		            }

					if (json.inventario !== "") {
		                $('.error_message_inventario').css({'transform':'translateY(0px)'});
		                $('.error_message_inventario').css({'z-index':'1'});
		                $(".error_message_inventario").html(`<p>${json.inventario}</p>`);
		            }
					
					if (json.procesador !== "") {
		                $('.error_message_procesador').css({'transform':'translateY(0px)'});
		                $('.error_message_procesador').css({'z-index':'1'});
		                $(".error_message_procesador").html(`<p>${json.procesador}</p>`);
		            }
		        },
				500: function(xhr) {
					let json = JSON.parse(xhr.responseText);
		            //Para mostrar los mensajes de error en caso de tener en los campos del formulario	
					$(".titulo-mensaje").html(`<b><h1>${json.msg}</h1></b>`);
					$('.mensaje').css({'visibility':'visible'});
					$('.contenedor_mensaje_guardar_usuario').children("img").attr("src",$('.contenedor_mensaje_guardar_usuario').children("img").attr("incorrecto"));
					$('.contenedor_mensaje_guardar_usuario').css({'transform':'translateY(0%)'});
					$(document).on('click', '.cerrar_ventana_guardar_usuario', function(){
						$('.mensaje').css({'visibility':'hidden'});
						$('.contenedor_mensaje_guardar_usuario').css({'transform':'translateY(-200%)'});
					});
				},
				504: function(xhr) {
					let json = JSON.parse(xhr.responseText);
		            //Para mostrar los mensajes de error en caso de tener en los campos del formulario	
					$(".titulo-mensaje").html(`<b><h1>${json.msg}</h1></b>`);
					$('.mensaje').css({'visibility':'visible'});
					$('.contenedor_mensaje_guardar_usuario').children("img").attr("src",$('.contenedor_mensaje_guardar_usuario').children("img").attr("incorrecto"));
					$('.contenedor_mensaje_guardar_usuario').css({'transform':'translateY(0%)'});
					$(document).on('click', '.cerrar_ventana_guardar_usuario', function(){
						$('.mensaje').css({'visibility':'hidden'});
						$('.contenedor_mensaje_guardar_usuario').css({'transform':'translateY(-200%)'});
						window.location.replace(json.url);
					});
				}
		    },
		});	
	});
	//Función general para pintar la lista de los empleados de acuerdo a una respuesta
	function obtenerListaCompletaUsuarios() {
		$.ajax({
			url: "obtener_lista",
			type: "GET",
			success: function (response) {
				obtenerListaUsuarios(response);
			},
		});
	}

	//Función general para pintar la lista de los empleados de acuerdo a una respuesta
	function obtenerListaCompletaEquipos() {
		$.ajax({
			url: "obtener_listaEquipos",
			type: "GET",
			success: function (response) {
				obtenerListaEquipos(response);
			},
		});
	}

	//Función general para pintar de acuerdo a una respuesta las incidencias
	function obtenerListaUsuarios(response) {
		let usuarios = JSON.parse(response);
		let template = "";
		if (usuarios) {
			usuarios.forEach((usuario) => {
				template += `
                <tr>
                    <th scope="row">${usuario.no_empleado}</th>
                    <td>${usuario.nombre + " " + usuario.apellido_paterno + " " + usuario.apellido_materno}</td>
                    <td>${usuario.direccion}</td>
                    <td>${(usuario.rol).toUpperCase()}</td>
                    <td class="campo_status_empleado">
                        <a href="${baseUrl}/usuarios/editar_usuario/${usuario.no_empleado}" class="editar_datos_usuarios" idUsuario="${usuario.no_empleado}">Editar</a> 
                        <p class="label_status_empleado" for="status_empleado">
                            Estatus
                            <br>
                            <input id="status_empleado" type="checkbox" ${usuario.status == 1 ? "checked" : ""} value="${usuario.no_empleado}">
                        </p>
                    </td>
                </tr>
                `;
			});
		}
		$(".tbody_lista_usuarios").html(template);
	}

	//Función general para pintar la lista de los equipos de acuerdo a una respuesta
	function obtenerListaEquipos(response) {
		let equipos = JSON.parse(response);
		let template = "";
		if (equipos) {
			equipos.forEach((equipo) => {
				template += `
                <tr>
                    <th scope="row">${equipo.direccion_ip}</th>
                    <td>${equipo.nombre}</td>
					<td>${equipo.tipo_equipo}</td>
                    <td>${equipo.direccion}</td>
                    <td class="campo_status_empleado">
                        <a href="${baseUrl}/equipos/editar_equipo/${equipo.id_equipo}" class="editar_datos_equipo" idEquipo="${equipo.id_equipo}">Editar</a> 
                        <p class="label_status_empleado" for="status_empleado">
                            Estatus
                            <br>
                            <input id="status_equipo" type="checkbox" ${equipo.status == 1 ? "checked" : ""} value="${equipo.id_equipo}" direccionIP="${equipo.direccion_ip}">
                        </p>
                    </td>
                </tr>
                `;
			});
		}
		$(".tbody_lista_equipos").html(template);
	}

	//Función que carga las incidencias
	function obtenerTodasIncidencias() {
		$.ajax({
			url: "administrador/cargar_datos",
			type: "GET",
			success: function (response) {
				obtenerIncidencias(response);
			},
		});
	}

	//Finción para obtener los datos con los cuales el Amnistrador pordraá aplicar filtros
	function obtenerDatosFiltros() {
		$.ajax({
			url: "administrador/datos_filtros",
			type: "GET",
			success: function (response) {
				let datosfiltros = JSON.parse(response);
				let template_departamentos = "";
				let template_direcciones = "";
				let template_dependencias = "";

				if (datosfiltros.departamentos) {
					datosfiltros.departamentos.forEach((departamento) => {
						template_departamentos += `
                        <p class="opcion-departamento" idDepartamento="${departamento.id_departamento}">${departamento.nombre}</p>
                        `;
					});
				}

				if (datosfiltros.dependencias) {
					datosfiltros.dependencias.forEach((dependencia) => {
						template_dependencias += `
                        <p class="opcion-dependecia" idDependecia="${dependencia.id_dependencia}">${dependencia.nombre}</p>
                        `;
					});
				}

				if (datosfiltros.direcciones) {
					datosfiltros.direcciones.forEach((direccion) => {
						template_direcciones += `
                        <p class="opcion-direccion" idDireccion="${direccion.id_direccion}">${direccion.nombre}</p>
                        `;
					});
				}

				//Pintar los datos en sus columnas correspondientes
				$(".lista-dependecias").html(template_dependencias);
				$(".lista-direcciones").html(template_direcciones);
				$(".lista-departamentos").html(template_departamentos);
			},
		});
	}

	//Función general para pintar de acuerdo a una respuesta las incidencias
	function obtenerIncidencias(response) {
		let incidencias = JSON.parse(response);
		let template_pendientes = "";
		let template_proceso = "";
		let template_finalizados = "";
		let cantidad_pendientes;
		let cantidad_proceso;
		let cantidad_finalizados;

		//Para las incidencias pendientes
		if (incidencias.pendientes) {
			incidencias.pendientes.forEach((incidencia_pendiente) => {
				if (incidencia_pendiente.departamento == null) {
					incidencia_pendiente.departamento = ": Por asignar";
				}
				if (incidencia_pendiente.encargado == null) {
					incidencia_pendiente.encargado = ": Por asignar";
				}

				//Dar formato a la fecha de los reportes
				var fecha = new Date(incidencia_pendiente.fecha_apertura);
				var dia = fecha.getDate() + 1;
				var mes = fecha.getMonth() + 1;
				if (dia < 10) {
					dia = "0" + dia;
				}
				if (mes < 10) {
					mes = "0" + mes;
				}
				template_pendientes += `
                <div class="card-tres-columnas">
                    <div class="card-title">
                        <b><h5>${incidencia_pendiente.titulo}</h5></b>
                    </div>
                    <div class="card-body-tres-columnas">
                        <div class="fecha">
                            <b><h5>Folio</h5></b>
                            <p>${incidencia_pendiente.id_incidencia}</p>
                        </div>
                        <div class="fecha">
                            <b><h5>Creado</h5></b>
                            <p>${
															dia + "/" + mes + "/" + fecha.getFullYear()
														}</p>
                        </div>
                        <div class="opciones-card">
                            <button class="ver" idReporte="${
															incidencia_pendiente.id_incidencia
														}">Ver</button>
                        </div>
                    </div>
                    <div class="tecnico-departamento">
                        <div class="nom-tecnicos">
                            <figcaption>
                                <p class="nombre-tecnicos">Atendido por</b>${
																	incidencia_pendiente.encargado
																}</p>
                            </figcaption>
                            <img src='./assets/img/iconos/tecnicos.svg' alt=''>
                        </div>
                        <div class="nom-departamentos">
                            <figcaption>
                                <p class="nombre-departamentos">Se asigno a </b>${
																	incidencia_pendiente.departamento
																}</p>
                            </figcaption>
                            <img src='./assets/img/iconos/departamentos.svg' alt=''>
                        </div>                                
                    </div>
                </div>
                `;
				//console.log(incidencia_pendiente);
			});
		}else {
			template_pendientes = `
			<img class="contenido-vacio-tecnico" src="${baseUrl}/assets/img/logotipos/flor.png" alt="" width="150">
			`;
		}

		//Para las incidencias en proceso
		if (incidencias.en_proceso) {
			incidencias.en_proceso.forEach((incidencia_proceso) => {
				//Dar formato a la fecha de los reportes
				var fecha = new Date(incidencia_proceso.fecha_apertura);
				var dia = fecha.getDate() + 1;
				var mes = fecha.getMonth() + 1;
				if (dia < 10) {
					dia = "0" + dia;
				}
				if (mes < 10) {
					mes = "0" + mes;
				}
				template_proceso += `
                <div class="card-tres-columnas">
                    <div class="card-title">
                        <b><h5>${incidencia_proceso.titulo}</h5></b>
                    </div>
                    <div class="card-body-tres-columnas">
                        <div class="fecha">
                            <b><h5>Folio</h5></b>
                            <p>${incidencia_proceso.id_incidencia}</p>
                        </div>
                        <div class="fecha">
                            <b><h5>Creado</h5></b>
                            <p>${
															dia + "/" + mes + "/" + fecha.getFullYear()
														}</p>
                        </div>
                        <div class="opciones-card">
                            <button class="ver" idReporte="${
															incidencia_proceso.id_incidencia
														}">Ver</button>
                        </div>
                    </div>
                    <div class="tecnico-departamento">
                        <div class="nom-tecnicos">
                            <figcaption>
                                <p class="nombre-tecnicos">Atendido por </b>${
																	incidencia_proceso.encargado
																}</p>
                            </figcaption>
                            <img src='./assets/img/iconos/tecnicos.svg' alt=''>
                        </div>
                        <div class="nom-departamentos">
                            <figcaption>
                                <p class="nombre-departamentos">Se asigno a </b>${
																	incidencia_proceso.departamento
																}</p>
                            </figcaption>
                            <img src='./assets/img/iconos/departamentos.svg' alt=''>
                        </div>                                
                    </div>
                </div>
                `;
				//console.log(incidencia_proceso);
			});
		}else {
			template_proceso = `
			<img class="contenido-vacio-tecnico" src="${baseUrl}/assets/img/logotipos/flor.png" alt="" width="150">
			`;
		}

		//Para las incidencias finalizadas
		if (incidencias.finalizados) {
			incidencias.finalizados.forEach((incidencia_finalizada) => {
				//Dar formato a la fecha de los reportes
				var fecha = new Date(incidencia_finalizada.fecha_apertura);
				var dia = fecha.getDate() + 1;
				var mes = fecha.getMonth() + 1;
				if (dia < 10) {
					dia = "0" + dia;
				}
				if (mes < 10) {
					mes = "0" + mes;
				}
				template_finalizados += `
                <div class="card-tres-columnas">
                    <div class="card-title">
                        <b><h5>${incidencia_finalizada.titulo}</h5></b>
                    </div>
                    <div class="card-body-tres-columnas">
                        <div class="fecha">
                            <b><h5>Folio</h5></b>
                            <p>${incidencia_finalizada.id_incidencia}</p>
                        </div>
                        <div class="fecha">
                            <b><h5>Creado</h5></b>
                            <p>${
															dia + "/" + mes + "/" + fecha.getFullYear()
														}</p>
                        </div>
                        <div class="opciones-card">
                            <button class="ver" idReporte="${
															incidencia_finalizada.id_incidencia
														}">Ver</button>
                        </div>
                    </div>
                    <div class="tecnico-departamento">
                        <div class="nom-tecnicos">
                            <figcaption>
                                <p class="nombre-tecnicos">Atendido por </b>${
																	incidencia_finalizada.encargado
																}</p>
                            </figcaption>
                            <img src='./assets/img/iconos/tecnicos.svg' alt=''>
                        </div>
                        <div class="nom-departamentos">
                            <figcaption>
                                <p class="nombre-departamentos">Se asigno a </b>${
																	incidencia_finalizada.departamento
																}</p>
                            </figcaption>
                            <img src='./assets/img/iconos/departamentos.svg' alt=''>
                        </div>                                
                    </div>
                </div>
                `;
				//console.log(incidencia_finalizada);
			});
		}else {
			template_finalizados = `
			<img class="contenido-vacio-tecnico" src="${baseUrl}/assets/img/logotipos/flor.png" alt="" width="150">
			`;
		}

		//Pintar los reportes en sus columnas correspondientes
		$(".columna-tripleta-pendiente").html(template_pendientes);
		$(".columna-tripleta-proceso").html(template_proceso);
		$(".columna-tripleta-finalizado").html(template_finalizados);

		if (incidencias.pendientes.length == null) {
			cantidad_pendientes = 0;
		} else if (incidencias.pendientes.length > 999) {
			cantidad_pendientes = (incidencias.pendientes.length/1000).toFixed(1) + "k";
		} else {
			cantidad_pendientes = incidencias.pendientes.length;
		}

		if (incidencias.en_proceso.length == null) {
			cantidad_proceso = 0;
		} else if (incidencias.en_proceso.length > 999) {
			cantidad_proceso = (incidencias.en_proceso.length/1000).toFixed(1) + "k";
		} else {
			cantidad_proceso = incidencias.en_proceso.length;
		}

		if (incidencias.finalizados.length == null) {
			cantidad_finalizados = 0;
		} else if (incidencias.finalizados.length > 999) {
			cantidad_finalizados = (incidencias.finalizados.length/1000).toFixed(1) + "k";
		} else {
			cantidad_finalizados = incidencias.finalizados.length;
		}

		//Pintar la cantidad de reportes de cada columna
		$(".cantidad-reportes-pendiente").html(cantidad_pendientes);
		$(".cantidad-reportes-proceso").html(cantidad_proceso);
		$(".cantidad-reportes-finalizado").html(cantidad_finalizados);
	}
})(jQuery);
