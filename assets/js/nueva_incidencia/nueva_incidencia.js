(function($) {
    $(document).on('click', '#alguien-mas', function(){
        if($('#alguien-mas').is(':checked')){
            $('.search_usuario').css({'visibility':'visible'});
            $('.label-alguien-mas').css({'visibility':'hidden'});

        }else{
            $('.search_usuario').css({'visibility':'hidden'});
            $('.label-alguien-mas').css({'visibility':'visible'});
        }
    });

    //Evento que se ejecuta cuando el usuario este escribiendo en la barra de busqueda
    $(".search_usuario").keyup(function(ev) {
        //$('#opciones-buscar').css('display','flex');
        if($('.search_usuario').val()){
            let search_usuario = $('.search_usuario').val();
            //console.log(search_usuario)

            $.ajax({
                url: 'buscar_empleado',
                type: 'POST',
                data: { search_usuario },
                success: function(data) {
                    let empleado = JSON.parse(data);
                    //let template = "";
                    console.log(empleado);
                }
            });
        }
    });

})(jQuery)