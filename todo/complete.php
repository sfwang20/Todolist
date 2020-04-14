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

//load todo
$sql = 'SELECT is_complete FROM todos WHERE id=:id';
$statement = $pdo->prepare($sql);                           
$statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$result = $statement -> execute();
$todo = $statement -> fetch(PDO::FETCH_ASSOC);

//toggle complete status
//save
$sql = 'UPDATE todos SET is_complete=:is_complete WHERE id=:id';
$statement = $pdo->prepare($sql);                           
$statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$statement->bindValue(':is_complete', !$todo['is_complete'], PDO::PARAM_INT);  //要反轉
$result = $statement -> execute();

if ($result) {
    echo json_encode(['id' => $_POST['id'],'is_complete' => !$todo['is_complete']]);  //這邊印什麼無所謂, 只是讓f有東西接收, 才會successful
}              
else {
    echo 'error';
}                                         
