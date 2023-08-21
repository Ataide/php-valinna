<?php

require_once 'banco.php';

$pdo = Banco::connect();

if (isset($_POST['userid']) && isset($_POST['tabid'])) {

    $sql = "SELECT * FROM QUESTIONS where id=" . $_POST['userid'];

    $row = $pdo->query($sql)->fetch();

    $response_with_answer = '<div class="mb-3 row">
                    <label for="modal_cliente" class="col-sm-2 col-form-label">Cliente</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="modal_cliente" disabled value="' . $row['client'] . '">
                    </div>
                </div>
            <div class="mb-3 row">
                <label for="modal_produto" class="col-sm-2 col-form-label">Produto</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="modal_produto" disabled value="' . $row['product'] . '">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="modal_receita" class="col-sm-2 col-form-label">Receita</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="modal_receita" disabled value="' . $row['amount'] . '">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-12">
                    <textarea class="form-control" id="pergunta" rows="3" disabled>' . $row['question'] . '</textarea>
                </div>
            </div>
            <div class="mb-3">
                <label for="comentario" class="form-label">Comentario</label>
                <textarea class="form-control" id="comentario" rows="3" disabled>' . $row['comment'] . '</textarea>
            </div>
            <div class="form-check form-switch">
                <label class="form-check-label" for="flexSwitchCheckChecked">Status</label>
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
            </div>
            <div class="mb-3">
                <label for="resposta" class="col-sm-2 form-label">Resposta</label>
                <textarea class="form-control" id="resposta" rows="3">' . $row['answer'] . '</textarea>
            </div>
            <div class="mb-3">
                <a class="btn btn-primary" id="update-button" data-id=' . $row['id'] . '>Salvar</a>
            </div>
        ';

    $response_without_answer = '<div class="mb-3 row">
                    <label for="modal_cliente" class="col-sm-2 col-form-label">Cliente</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="modal_cliente" disabled value="' . $row['client'] . '">
                    </div>
                </div>
            <div class="mb-3 row">
                <label for="modal_produto" class="col-sm-2 col-form-label">Produto</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="modal_produto" disabled value="' . $row['product'] . '">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="modal_receita" class="col-sm-2 col-form-label">Receita</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="modal_receita" disabled value="' . $row['amount'] . '">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-12">
                    <textarea class="form-control" id="pergunta" rows="3">' . $row['question'] . '</textarea>
                </div>
            </div>
            <div class="mb-3">
                <label for="comentario" class="form-label">Comentario</label>
                <textarea class="form-control" id="comentario" rows="3">' . $row['comment'] . '</textarea>
            </div>
            <div class="form-check form-switch">
                <label class="form-check-label" for="flexSwitchCheckChecked">Status</label>
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
            </div>
            <div class="mb-3">
                <a class="btn btn-primary" id="update-button" data-id=' . $row['id'] . '>Salvar</a>
            </div>
        ';

    if ($_POST['tabid'] == 0) {
        echo $response_with_answer;
    } else {
        echo $response_without_answer;
    }
}

Banco::disconnect();
exit;
