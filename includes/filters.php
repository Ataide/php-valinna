<?php
require_once 'banco.php';

$pdo = Banco::connect();

$sql = 'SELECT * FROM questions';

$sql_amount_sum = 'SELECT sum(amount) FROM questions';

$sql_qtd_brokker = 'SELECT brokker FROM questions';

$sql_all_products = 'SELECT product FROM questions GROUP BY product';

$sql_all_asset = 'SELECT asset FROM questions GROUP BY asset';

$sql_all_client = 'SELECT client FROM questions GROUP BY client';

$sql_all_advisor = 'SELECT advisor FROM questions GROUP BY advisor';

$sql_all_brokker = 'SELECT brokker FROM questions GROUP BY brokker';

// Verificar se os parâmetros GET foram definidos
$parameters = array();
if (isset($_GET['advisor']) && $_GET['advisor'] !== "") {
    $sql .= ' WHERE advisor = :advisor';
    $sql_amount_sum .= ' WHERE advisor = :advisor';
    $sql_qtd_brokker .= ' WHERE advisor = :advisor';
    $parameters[':advisor'] = $_GET['advisor'];
}

if (isset($_GET['client']) && $_GET['client'] !== "") {
    if (empty($parameters)) {
        $sql .= ' WHERE client = :client';
        $sql_amount_sum .= ' WHERE client = :client';
        $sql_qtd_brokker .= ' WHERE client = :client';
    } else {
        $sql .= ' AND client = :client';
        $sql_amount_sum .= ' AND client = :client';
        $sql_qtd_brokker .= ' AND client = :client';
    }
    $parameters[':client'] = $_GET['client'];
}

if (isset($_GET['brokker']) && $_GET['brokker'] !== "") {
    if (empty($parameters)) {
        $sql .= ' WHERE brokker = :brokker';
        $sql_amount_sum .= ' WHERE brokker = :brokker';
        $sql_qtd_brokker .= ' WHERE brokker = :brokker';
    } else {
        $sql .= ' AND brokker = :brokker';
        $sql_amount_sum .= ' AND brokker = :brokker';
        $sql_qtd_brokker .= ' AND brokker = :brokker';
    }
    $parameters[':brokker'] = $_GET['brokker'];
}

if (isset($_GET['product']) && $_GET['product'] !== "") {
    if (empty($parameters)) {
        $sql .= ' WHERE product = :product';
        $sql_amount_sum .= ' WHERE product = :product';
        $sql_qtd_brokker .= ' WHERE product = :product';
    } else {
        $sql .= ' AND product = :product';
        $sql_amount_sum .= ' AND product = :product';
        $sql_qtd_brokker .= ' AND product = :product';
    }
    $parameters[':product'] = $_GET['product'];
}
if (isset($_GET['asset']) && $_GET['asset'] !== "") {
    if (empty($parameters)) {
        $sql .= ' WHERE asset = :asset';
        $sql_amount_sum .= ' WHERE asset = :asset';
        $sql_qtd_brokker .= ' WHERE asset = :asset';
    } else {
        $sql .= ' AND asset = :asset';
        $sql_amount_sum .= ' AND asset = :asset';
        $sql_qtd_brokker .= ' AND asset = :asset';
    }
    $parameters[':asset'] = $_GET['asset'];
}

$sql_qtd_brokker .= " GROUP BY brokker";

$stmt = $pdo->prepare($sql);
$stml_sum = $pdo->prepare($sql_amount_sum);
$stml_brokker = $pdo->prepare($sql_qtd_brokker);

$stmt->execute($parameters);
$stml_sum->execute($parameters);
$stml_brokker->execute($parameters);

$qtd_linhas = $stmt->rowCount();

$stats_financeiro = $stml_sum->fetch()[0];

$stats_corretora = $stml_brokker->rowCount();
?>
  <div class=" row mt-4">
    <div class="col-12">
        <h5>Filtros</h5>
    </div>

    <div class="col-2">
        <label class="visually-hidden" for="asessor">Asessor</label>
        <select class="form-select select-filter" name="asessor" id="asessor" >
        <option value="" selected>Selecione asessor</option>
        <?php foreach ($pdo->query($sql_all_advisor) as $row) {?>
          <option value="<?php echo $row['advisor'] ?>" <?php echo $row['advisor'] ?>><?php echo $row['advisor'] ?></option>
        <?php }?>
        </select>
    </div>

    <div class="col-2">
        <label class="visually-hidden" for="cliente">Cliente</label>
        <select class="form-select select-filter" id="cliente">
        <option value="" selected>Selecione cliente</option>
        <?php foreach ($pdo->query($sql_all_client) as $row) {?>
          <option value="<?php echo $row['client'] ?>"><?php echo $row['client'] ?></option>
        <?php }?>
        </select>
    </div>

    <div class="col-2">
        <label class="visually-hidden" for="corretora">Corretora</label>
        <select class="form-select select-filter" id="corretora">
        <option value="" selected>Selecione corretora</option>
        <?php foreach ($pdo->query($sql_all_brokker) as $row) {?>
          <option value="<?php echo $row['brokker'] ?>"><?php echo $row['brokker'] ?></option>
        <?php }?>
        </select>
    </div>
    <div class="col-2">
        <label class="visually-hidden" for="produto">Produto</label>
        <select class="form-select select-filter" id="produto">
        <option value="" selected>Selecione produto</option>
        <?php foreach ($pdo->query($sql_all_products) as $row) {?>
          <option value="<?php echo $row['product'] ?>"><?php echo $row['product'] ?></option>
        <?php }?>
        </select>
    </div>
    <div class="col-2">
        <label class="visually-hidden" for="ativo">Ativo</label>
        <select class="form-select select-filter" id="ativo" </select>>
        <option value="" selected>Selecione ativo</option>
        <?php foreach ($pdo->query($sql_all_asset) as $row) {?>
          <option value="<?php echo $row['asset'] ?>"><?php echo $row['asset'] ?></option>
        <?php }?>
        </select>
    </div>
  </div>
  <div class="row mt-4 stats mb-4">
      <div class="mb-3 col-3">
          <label for="linhas" class="form-label">Linhas</label>
          <input type="text" class="form-control" id="linhas" disabled="true" value="<?php echo $qtd_linhas ?>"/>
      </div>
      <div class="mb-3 col-3">
          <label for="financeiro" class="form-label">Financeiro</label>
          <input type="text" class="form-control" id="financeiro" disabled="true" value="R<?php echo $stats_financeiro ?>"/>
      </div>
      <div class="mb-3 col-3">
          <label for="afetados" class="form-label">AAIs Afetados</label>
          <input type="text" class="form-control" id="afetados" disabled="true" value="<?php echo $stats_corretora ?>"/>
      </div>
      <div class="mb-3 col-3">
          <label for="corretoras" class="form-label">Corretoras</label>
          <input type="text" class="form-control" id="corretoras" disabled="true" value="<?php echo $stats_corretora ?>"/>
      </div>
  </div>



<?php

Banco::disconnect();
?>