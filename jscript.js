// https://datatables.net/extensions/scroller/examples/initialisation/server-side_processing.html
$(document).ready(function() {

    // // Intercepta o button e chama a função de 
    // //reload do datatable forçando o mesmo a fazer uma nova requisição com os dados do filtro.
    $('#btn-submit').click(function(){
        // Seta value para a variavel pois como não foi feito submit o value está vazio
      
       document.querySelector('#nome_aux').value = document.getElementById('nome').value;
       document.querySelector('#sexo_aux').value = document.getElementById('sexo').value;

        // $('#example').DataTable().clear().Destroy();
        console.log(nome_aux);
    
        // da um reload no datatable
        $('#example').DataTable().ajax.reload();
    });

    // // Intercepta o submit do formulario
    // $('#form-filtro').submit(function(event){
    //     console.log(event);

    //     // // Resgatando os valores dos inputs do formulario
    //     // var nome = $('#nome').val();
    //     // var sexo = $('#sexo').val();


    //     // // Construindo o map com os valores do filtro.
    //     // var map = {
    //     //     draw : "1",
    //     //     length : "10",
    //     //     start : "0",
    //     //     sexo : sexo,
    //     //     nome : nome
    //     // };

    //     // $.ajax({
    //     //     method: 'POST',
    //     //     url   : '/uteis/02/server-side.php',
    //     //     data  : map,
    //     //     success: function(data){
    //     //         console.log(data);
                
    //     //         // da um reload no datatable
    //     //         $('#example').DataTable().ajax.reload();
    //     //     }
    //     // })

    //     event.preventDefault();
    // });


    $('#example').DataTable({
        serverSide: true,
        processing: true,
        ordering: false,
        searching: false,
        paginate: true,
        destroy: true,
        ajax : {
            url:"/uteis/02/server-side.php",
            type:"POST",
            data: {nome: document.getElementById('nome_aux').value, sexo: document.getElementById('sexo_aux').value},
             dataFilter: function(data){
                console.log(data);
              
                return data;
            }      
        },
        scrollY: 200,
        scroller: {
            loadingIndicator: true
        },
    });

} );
