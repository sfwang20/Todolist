<?php include ('header.php') ?>
<?php include ('data.php') ?>
<?php
session_start();
if ($_SESSION["loggedin"] == false){
  header("location: register.php");
  exit;
}
?>
<div>
  <div>
    <p id="log-out"><a href="logout.php">Log out</a></p>
  </div>
  <div id="panel">
    <h1>Todo List</h1>
    <hr>
    <div id="todolist">
      <ul>
        <li class='new'>
          <div class="actions">
            <div class="addtodo">+</div>
          </div>
          <div class="content" contenteditable="true" placeholder="Add Something..."></div>
      </li>
      </ul>
    </div>
  </div>
</div>



<script id="todolist_template" type="text/x-handlebars-template">
  <li data-id={{id}} class="{{#if is_complete}}complete{{/if}}">   <!--如果完成就印complete-->
    <div class="checkbox"></div>
    <div class="content">{{content}}</div>
    <div class="actions">
      <div class="delete">X</div>
    </div>
  </li>
</script>
<?php include ('footer.php') ?>
