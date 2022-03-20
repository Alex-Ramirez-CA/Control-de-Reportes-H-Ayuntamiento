(function($) {
    $("#enviar").click(function(ev) {

        $.ajax({
            url: 'cliente/buscar_incidencia',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                let json = JSON.parse(data);
                console.log(json);
                //window.location.replace(json.url);
            },

            /* 
                statusCode: {
                400: function(xhr) {
                    let json = JSON.parse(xhr.responseText);
                    console.log(json);
                },
                401: function(xhr) {
                    let json = JSON.parse(xhr.responseText);
                    console.log(json);
                    $("#alert").html(`<div class="alert alert-danger" role="alert">${json.msg}</div>`);
                }
                },
            */
        });

        ev.preventDefault();
        
    });
})(jQuery)