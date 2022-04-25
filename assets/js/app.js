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

	//Obtener las incidencia para el cliente tipo Administrador
	if ($(".container").attr("rol") == 3) {
		obtenerTodasIncidencias();
		obtenerDatosFiltros();
	}

    //Listar a todos los usuarios solo cuando este la url correcta
	if (getUrl == baseUrl + "/usuarios/lista_usuarios") {
		obtenerListaCompletaUsuarios();
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
					window.location.replace(json.url);
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
					window.location.replace(json.url);
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
					window.location.replace(json.url);
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
					window.location.replace(json.url);
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
					window.location.replace(json.url);
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
		    data: {no_empleado, nombre, apellido_paterno, apellido_materno, email, password, id_direccion, id_rol, id_departamento, id_equipo},
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
	$(document).on("keyup", "#nombre", function () {
		$(".error_message_nombre").css({ transform: "translateY(-10px)" });
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

	$(document).on("keyup", "#direccion_ip", function () {
		$(".error_message_direccionIP").css({ transform: "translateY(-10px)" });
		$(".error_message_direccionIP").css({ "z-index": "-1" });
	});

	//Función para dar de baja o de alta algún empleado
	$(document).on("click", "#status_empleado", function () {
		let status;
		let no_empleado = $(this).val();

		var opcion = confirm(
			"¿Está seguro de cambiar el status actual del trabajador?"
		);
		if (opcion == true) {
			if ($(this).is(":checked")) {
				// Hacer algo si el checkbox ha sido seleccionado
				status = 1;
				console.log(
					"El empleado con numero " +
						no_empleado +
						" ha sido seleccionado, nuevo status: " +
						status
				);
				$.post("modificar_status", { status, no_empleado });
				// obtenerListaCompletaUsuarios ();
			} else {
				// Hacer algo si el checkbox ha sido deseleccionado
				status = 0;
				console.log(
					"El empleado con numero " +
						no_empleado +
						" ha sido deseleccionado, nuevo status: " +
						status
				);
				$.post("modificar_status", { status, no_empleado });
				// obtenerListaCompletaUsuarios ();
			}
		} else {
			//console.log("No paso nada");
			obtenerListaCompletaUsuarios();
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
	});

	//Evento de cuando clique en enviar filtros
	$(document).on("click", ".aplicar_filtros_usuarios", function () {
		$.post(
			"filtrar_usuarios",
			{ dependencia, direccion, departamento, rol, status },
			function (response) {
				obtenerListaUsuarios(response);
			}
		);
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
                    <td>${usuario.rol}</td>
                    <td class="campo_status_empleado">
                        <a href="${baseUrl}/usuarios/editar_usuario/${usuario.no_empleado}" class="editar_datos_usuarios" idUsuario="${usuario.no_empleado}">Editar</a> 
                        <p class="label_status_empleado" for="status_empleado">
                            Status
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
		}

		//Pintar los reportes en sus columnas correspondientes
		$(".columna-tripleta-pendiente").html(template_pendientes);
		$(".columna-tripleta-proceso").html(template_proceso);
		$(".columna-tripleta-finalizado").html(template_finalizados);

		if (incidencias.pendientes.length == null) {
			cantidad_pendientes = 0;
		} else if (incidencias.pendientes.length > 999) {
			cantidad_pendientes = incidencias.pendientes.length.toFixed(1) + "k";
		} else {
			cantidad_pendientes = incidencias.pendientes.length;
		}

		if (incidencias.en_proceso.length == null) {
			cantidad_proceso = 0;
		} else if (incidencias.en_proceso.length > 999) {
			cantidad_proceso = incidencias.en_proceso.length.toFixed(1) + "k";
		} else {
			cantidad_proceso = incidencias.en_proceso.length;
		}

		if (incidencias.finalizados.length == null) {
			cantidad_finalizados = 0;
		} else if (incidencias.finalizados.length > 999) {
			cantidad_finalizados = incidencias.finalizados.length.toFixed(1) + "k";
		} else {
			cantidad_finalizados = incidencias.finalizados.length;
		}

		//Pintar la cantidad de reportes de cada columna
		$(".cantidad-reportes-pendiente").html(cantidad_pendientes);
		$(".cantidad-reportes-proceso").html(cantidad_proceso);
		$(".cantidad-reportes-finalizado").html(cantidad_finalizados);
	}
})(jQuery);
