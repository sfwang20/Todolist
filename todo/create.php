<?php
include ('../../db_todo.php');
session_start();
/*因最後面傳json格式,所以要設成json格式 */
header('Content-Type: application/json; charset=utf-8'); 

try {
    $pdo = new PDO ("mysql:host=$db[host]; dbname=$db[dbname]; port=$db[port]; 
    charset=$db[charset]",$db['username'],$db['password']);
} catch(PDOException $e) {
    echo "Database Connection failed.";
    exit;
}

$sql = 'INSERT INTO todos (content, is_complete, `order`, `user_id`)     /*用``擋掉關鍵字*/
        VALUES (:content, :is_complete, :order, :user_id)';
$statement = $pdo->prepare($sql);                             /*將sql指令處理一下 */
$statement->bindValue(':content', $_POST['content'], PDO::PARAM_STR);   /*處理輸入的資料 格式 */
$statement->bindValue(':is_complete', 0, PDO::PARAM_INT);
$statement->bindValue(':order', $_POST['order'], PDO::PARAM_INT);
$statement->bindValue(':user_id', $_SESSION["id"], PDO::PARAM_INT);
$result = $statement -> execute();

if ($result) {
    echo json_encode(['id' => $pdo->lastInsertId()]); /*json_encode會將得到的資料丟進去後編碼成json格式 */
}                                                       /*id需跟pdo要 */
else {
    echo $_SESSION["id"];
    // var_dump($pdo->errorInfo());
}   
//這邊可加else{var_drump($pdo->errorInfo();}來看錯誤訊息(在chrome)
//上面做了哪些事情? 刻了一個API 聯繫資料庫 把資料存進去(insert) 之後回傳一個json格式的檔案