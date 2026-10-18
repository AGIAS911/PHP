<?php 
require_once __DIR__ . '/db.php';

if($_SERVER['REQUEST_METHOD']==='POST'){

$id=$_POST['id'];

$stmt= $pdo->prepare('DELETE FROM products where id=?');
$stmt->execute([$id]);

}


header('Location: dashboard.php');
exit;
?>