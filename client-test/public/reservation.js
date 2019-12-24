/**
 * Created by nasolo on 24/12/19.
 */
$( document ).ready(function() {
    $('body').on('change', '#reservation_ville', function(e) {

        var id_ville = $(this).children("option:selected").val();
        var array_id_ville = id_ville.split('/');
        //alert(id_ville);
        $.ajax({
            url: $('#path_get_hotel').val(),
            data: {
                'ville': array_id_ville[3]},
            method: 'GET',
            dataType: 'Json',
            success : function(result, statut){
                // traitemet en cas de succes
            }
        });

    });
});
