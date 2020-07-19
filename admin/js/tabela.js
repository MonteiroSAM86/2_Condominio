$(document).ready(function() {
    $('#example').DataTable( {
        "lengthMenu": [[15, 20, 50, -1], [15, 20, 50, "All"]],
        "order": [[ 1, "desc" ]],
        "columnDefs": [{"targets": [ 0 ],"visible": false,"searchable": false } ],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registos por pág.",
            "zeroRecords": "Não encontrado - Desculpe",
            "info": "Exibida _PAGE_ pág. de _PAGES_ pág.",
            "infoEmpty": "Não há registos disponíveis",
            "infoFiltered": "(foram encontrados _MAX_ registos no total)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sSearch": "Pesquisar"
         }
    } );
} );

/*$(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );*/



