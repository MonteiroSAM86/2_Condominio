$(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'excel', 'pdf', 'colvis' ],
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
            "sSearch": "Pesquisar",
            "buttons": {
                colvis: 'Colunas visiveis'
            },
            "paginate": {
                "previous": "Pág. anterior",
                "next": "Próxima pág."
            }   
         }
         
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );