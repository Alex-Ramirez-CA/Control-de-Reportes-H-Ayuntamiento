$(function() {

    $('#search').keyup(function(e) {
        let search = $('#search').val();
        console.log(search);
        /*
        $.ajax({
            url: 'cliente',
            type: 'POST',
            data: { search },
            success: function(response){
                console.log(response);
            }
        })
        */     
    })
});