<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="./css/index.css" rel="stylesheet">
        <title>Página Inicial</title>
    </head>



    <body class="modal-open">
        <div class="container pt-4">

            <h3>Verificação Financeiro</h3>

            <div class="tab-container">
                <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                    <li class="nav-item">
                        <a class="nav-link <?php if ($_GET['tab'] == 0) {echo "active";}?> " data-bs-toggle="tab" data-bs-target="#verificacao" type="button" role="tab" aria-controls="verificacao" aria-selected="true">Verificação</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($_GET['tab'] == 1) {echo "active";}?> " data-bs-toggle="tab" data-bs-target="#questionamento" type="button" role="tab" aria-controls="questionamento">Questionamento</a>
                    </li>
                </ul>

                <div id="my-tab-content" class="tab-content">
                    <div class="tab-pane fade show active" id="verificacao">
                        <?php include 'includes/filters.php';?>


                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">ACESSOR</th>
                                    <th scope="col">CLIENTE</th>
                                    <th scope="col">CORRETORA</th>
                                    <th scope="col">PRODUTO</th>
                                    <th scope="col">ATIVO</th>
                                    <th scope="col">RECEITA IDEAL</th>
                                    <th scope="col">RECEITA ATUAL</th>
                                    <th scope="col">AÇÔES</th>

                                </tr>
                            </thead>
                            <tbody>
                            <?php include 'includes/table-result.php';?>
                            </tbody>
                        </table>
                    </div>


                    <div class="tab-pane fade" id="questionamento">
                            <?php include 'includes/filters.php';?>


                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">ACESSOR</th>
                                        <th scope="col">CLIENTE</th>
                                        <th scope="col">CORRETORA</th>
                                        <th scope="col">PRODUTO</th>
                                        <th scope="col">ATIVO</th>
                                        <th scope="col">RECEITA IDEAL</th>
                                        <th scope="col">RECEITA ATUAL</th>
                                        <th scope="col">AÇÔES</th>

                                    </tr>
                                </thead>
                                <tbody>
                                <?php include 'includes/table-result.php';?>
                                </tbody>
                            </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade modal-dark" id="modalDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Questionamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- vindo da chamada ajax -->
                    </div>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>


        <script>


           $(document).ready(function(){
                $('.userinfo').click(function() {

                    var userid = $(this).data('id');
                    var tabid = $(this).data('tab');

                    $.ajax({
                        url: 'modal-details.php',
                        type: 'post',
                        data: {userid: userid, tabid: tabid},
                        success: function(response){
                                $('.modal-body').html(response);
                                $('#modalDetails').modal('show');

                            //Ação de atualizar as informações do modal.
                            $('#update-button').click(function() {
                                const id = $(this).data('id');


                                $.ajax({
                                    url: "update-question.php",
                                    type: "POST",
                                    cache: false,
                                    data:{
                                        id: id,
                                        question: $('#pergunta').val(),
                                        comment: $('#comentario').val(),
                                        answer: $('#resposta').val(),
                                    },
                                    success: function(dataResult){
                                        $('#modalDetails').modal().hide();
                                        alert('Dados alterados.');
                                        location.reload();

                                    }
                                });

                            });
                        }
                    });
                });


            });

        <?php if (isset($_GET['advisor'])) {?>
            $("#asessor").val( '<?php echo $_GET['advisor'] ?>');
        <?php }?>
        <?php if (isset($_GET['client'])) {?>
            $("#cliente").val( '<?php echo $_GET['client'] ?>');
        <?php }?>
        <?php if (isset($_GET['product'])) {?>
            $("#produto").val( '<?php echo $_GET['product'] ?>');
        <?php }?>
        <?php if (isset($_GET['brokker'])) {?>
            $("#corretora").val( '<?php echo $_GET['brokker'] ?>');
        <?php }?>
        <?php if (isset($_GET['asset'])) {?>
            $("#ativo").val( '<?php echo $_GET['asset'] ?>');
        <?php }?>



        // select do filtro cliente
        $('.select-filter').change(function() {
            const tab = $('.tab-content .active').attr('id') === "verificacao" ? 0 : 1;
            const asessor = $('#asessor').val() ? $('#asessor').val() : '';
            const cliente = $('#cliente').val() ? $('#cliente').val() : '';
            const produto = $('#produto').val() ? $('#produto').val() : '';
            const corretora = $('#corretora').val() ? $('#corretora').val() : '';
            const ativo = $('#ativo').val() ? $('#ativo').val() : '';

        var urlToSend =  "?tab="+ tab +"&advisor=" + asessor + "&client="+cliente + "&product=" + produto + "&brokker=" + corretora+ "&asset=" + ativo;
            location.replace(urlToSend);
        })

        $(function () {
             $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                    const tab = $(e.target).attr('aria-controls') === "verificacao" ? 0 : 1;
                    const asessor = $('#asessor').val() ? $('#asessor').val() : '';
                    const cliente = $('#cliente').val() ? $('#cliente').val() : '';
                    const produto = $('#produto').val() ? $('#produto').val() : '';
                    const corretora = $('#corretora').val() ? $('#corretora').val() : '';
                    const ativo = $('#ativo').val() ? $('#ativo').val() : '';

                var urlToSend =  "?tab="+ tab +"&advisor=" + asessor + "&client="+cliente + "&product=" + produto + "&brokker=" + corretora+ "&asset=" + ativo;
                    location.replace(urlToSend);
             });
         })

        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>

</html>
