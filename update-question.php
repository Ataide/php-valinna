<?php
include 'banco.php';

$pdo = Banco::connect();

$id = $_POST['id'];
$answer = $_POST['answer'];
$question = $_POST['question'];
$comment = $_POST['comment'];

$sql = "UPDATE questions SET answer=?, comment=?, question=? WHERE id=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$answer, $comment, $question, $id]);

Banco::disconnect();

exit;
