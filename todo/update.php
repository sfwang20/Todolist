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

$sql = 'UPDATE todos SET content=:content WHERE id=:id';
$statement = $pdo->prepare($sql);                             /*將sql指令處理一下 */
$statement->bindValue(':content', $_POST['content'], PDO::PARAM_STR);   /*處理輸入的資料 格式 */
$statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$result = $statement -> execute();

if (!$result) {
    echo 'error';
}                                                       
