(function($) {
    $("#search").keyup(function(ev) {
        let search = $('#search').val();
        console.log(search);

        $.ajax({
            url: 'cliente/buscar_incidencia',
            type: 'POST',
            data: { search },
            success: function(data) {
                let incidencias = JSON.parse(data);
                let template = '';

                incidencias.forEach(element => {
                    template += `<li>
                        ${element.titulo}
                    </li>`;
                });

                $('#opciones-buscar').html(template);

                //window.location.replace(json.url);
            },
        });        
    });
})(jQuery)