<?php
require_once 'banco.php';
$pdo = Banco::connect();

$sql = 'SELECT * FROM questions';

// Verificar se os parâmetros GET foram definidos
$parameters = array();

if (isset($_GET['tab']) && $_GET['tab'] !== "") {
    $tab = $_GET['tab'];
}

if (isset($_GET['advisor']) && $_GET['advisor'] !== "") {
    $sql .= ' WHERE advisor = :advisor';
    $parameters[':advisor'] = $_GET['advisor'];
}

if (isset($_GET['client']) && $_GET['client'] !== "") {
    if (empty($parameters)) {
        $sql .= ' WHERE client = :client';
    } else {
        $sql .= ' AND client = :client';
    }
    $parameters[':client'] = $_GET['client'];
}
if (isset($_GET['product']) && $_GET['product'] !== "") {
    if (empty($parameters)) {
        $sql .= ' WHERE product = :product';
    } else {
        $sql .= ' AND product = :product';
    }
    $parameters[':product'] = $_GET['product'];
}
if (isset($_GET['brokker']) && $_GET['brokker'] !== "") {
    if (empty($parameters)) {
        $sql .= ' WHERE brokker = :brokker';
    } else {
        $sql .= ' AND brokker = :brokker';
    }
    $parameters[':brokker'] = $_GET['brokker'];
}
if (isset($_GET['asset']) && $_GET['asset'] !== "") {
    if (empty($parameters)) {
        $sql .= ' WHERE asset = :asset';
    } else {
        $sql .= ' AND asset = :asset';
    }
    $parameters[':asset'] = $_GET['asset'];
}

$sql .= ' ORDER BY id';

$stmt = $pdo->prepare($sql);
$stmt->execute($parameters);

foreach ($stmt->fetchAll() as $row) {?>

    <tr>
    <th scope="row"><?php echo $row['advisor'] ?> </th>
      <td><?php echo $row['client'] ?> </td>
      <td><?php echo $row['brokker'] ?> </td>
      <td><?php echo $row['product'] ?> </td>
      <td><?php echo $row['asset'] ?> </td>
      <td><?php echo $row['ideal_amount'] ?> </td>
      <td><?php echo $row['amount'] ?> </td>
      <td width=250>
        <?php if ($tab == 0) {
    ?>
            <a class="btn btn-primary userinfo" data-tab="<?php echo $tab ?>" data-id=<?php echo $row['id'] ?> >Responder</a>
            <?php
}?>

        <?php if ($tab == 1) {
    ?>
            <a class="btn btn-primary userinfo" data-tab="<?php echo $tab ?>" data-id=<?php echo $row['id'] ?> >Questionamento</a>
            <?php
}?>

      </td>
    </tr>

<?php }

Banco::disconnect();
?>