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

$sql = 'DELETE  FROM todos WHERE id=:id';
$statement = $pdo->prepare($sql);                             /*將sql指令處理一下 */
$statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$result = $statement -> execute();

if ($result) {
    echo json_encode(['id' => $_POST['id']]);  //這邊印什麼無所謂, 只是讓f有東西接收, 才會successful
}              
else {
    echo 'error';
}                                         
