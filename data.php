<?php
include ('../db_todo.php');
session_start();

try {
    $pdo = new PDO ("mysql:host=$db[host]; dbname=$db[dbname]; port=$db[port];
    charset=$db[charset]",$db['username'],$db['password']);
} catch(PDOException $e) {
    echo "Database Connection failed.";
    echo $e;
    exit;
}

$sql = 'SELECT * FROM todos WHERE user_id = :user_id ORDER BY `order` ASC'; //ASC遞增 DESC遞減
$statement = $pdo->prepare($sql);
$statement -> bindValue(':user_id', $_SESSION["id"], PDO::PARAM_INT);
$statement -> execute();
$todos = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<script>
    var todos = <?= json_encode($todos, JSON_NUMERIC_CHECK) ?>; //確保轉成json時 格式不要從數字變成str
</script>
