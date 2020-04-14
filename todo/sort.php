<?php
include ('../../db_todo.php');

header('Content-Type: application/json; charset=utf-8'); 

try {
    $pdo = new PDO ("mysql:host=$db[host]; dbname=$db[dbname]; port=$db[port]; 
    charset=$db[charset]",$db['username'],$db['password']);
} catch(PDOException $e) {
    echo "Database Connection failed.";
    exit;
}

$sql = 'UPDATE todos SET `order`=:order WHERE id=:id';
$statement = $pdo->prepare($sql);  
foreach($_POST['orderpair'] as $key => $orderpair) {              
    $statement->bindValue(':order', $_POST['order'], PDO::PARAM_STR);   
    $statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
    $result = $statement -> execute();
}

if (!$result) {
    echo 'error';
}                 