(function($) {
    $("#search").keyup(function(ev) {
        let search = $('#search').val();
        $.ajax({
            url: 'cliente/buscar_incidencia',
            type: 'POST',
            data: { search },
            success: function(data) {
                let json = JSON.parse(data);
                console.log(json);
                //window.location.replace(json.url);
            },
        });

        ev.preventDefault();
        
    });
})(jQuery)