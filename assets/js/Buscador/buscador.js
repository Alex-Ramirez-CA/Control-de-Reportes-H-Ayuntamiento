(function($) {
    $(".enviar").click(function(ev) {

        $.ajax({
            url: 'cliente/buscar_incidencia',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                let json = JSON.parse(data);
                console.log(json);
                //window.location.replace(json.url);
            },
        });

        ev.preventDefault();
        
    });
})(jQuery)