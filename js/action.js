$(document).ready(function(){              //$(this)等同$(e.currentTarget)
  
  var source = $('#todolist_template').html();
  var todoTemplate = Handlebars.compile(source);
  
  //prepare all todo list items
  var todolistUI = '';
  $.each(todos, function (index, todo) {    //data.php宣告的todos  每一次todos都會丟進f 索引/值
    todolistUI = todolistUI + todoTemplate(todo);  //每做一次each就生出一個li
  });
  $('#todolist').find('li.new').before(todolistUI);

  $('#todolist')
  .on('dblclick', '.content', function(e){            //edit功能
      $(this).prop('contenteditable', true).focus(); 
  })
  .on('blur', '.content', function(e){               //blur事件會存在e裡面  因為同樣是監聽blur所以寫在一起
    var isNew = $(this).closest('li').is('.new');
    //create
    if (isNew) {
      var todo = $(this).text();        //把user輸入的資料存在todo變數
      todo = todo.trim();               //清掉空白,以防user沒輸入

      if (todo.length > 0) {
        var order = $('#todolist').find('li:not(.new').length + 1;

        //AJAX: create API  傳3個參數:到達的網址/要傳的資料/成功後要做的事
        $.post("todo/create.php", {content: todo, order: order},
          function (data, textStatus, jqXHR) { //data就是剛剛json_encode完的資料
            todo = {                          //複寫todo
              id: data.id,
              is_complete: false,             //預設就是未完成
              content: todo,                  //是之前抓到的todo(user輸入的資料)
            };
            var li = todoTemplate(todo);           //生成完整的li 包含自動判斷有無complete和內容
            $(e.currentTarget).closest('li').before(li);  //從事主找上層最接近的<li>,插入上面的li物件
          },
        );
      }
    $(this).empty();                   //把輸入的內容清掉
    } 

    //update
    else {                               //若不是新的,把可編輯關掉
        //AJAX CALL
        var id = $(this).closest('li').data('id');    //準備好要更新的id和content 
        var content = $(this).text();
        $.post("todo/update.php", {id: id, content: content},
        function (data, textStatus, jqXHR) {});
        $(this).prop('contenteditable', false);  
    }
  })
  .on('click', '.delete', function(e){                  //delete
    var result = confirm('Do you want to delete?');
    if (result) {
      //AJAX CALL  back-end的刪除
      var id = $(this).closest('li').data('id');
      $.post("todo/delete.php", {id: id},
      function (data, textStatus, jqXHR) {
        $(e.currentTarget).closest('li').remove();    //front-end的刪除  不一定要用f接 在外面做掉也可(像update)
      });  
    }
  })
  .on('click', '.checkbox', function(e){
    //AJAX CALL
    var id = $(this).closest('li').data('id');
    $.post("todo/complete.php", {id: id},
    function (data, textStatus, jqXHR) {
      $(e.currentTarget).closest('li').toggleClass('complete');
    });
    
  });

  $('#todolist').find('ul').sortable({
    items: "li:not(.new)",
    stop: function(){
      var orderpair = [];
      $('#todolist').find('li:not(.new)').each(function(index, li){
        orderpair.push({
          id : $(li).data('id'),
          order : index +1,
        })
      })
      $.post('todo/sort.php', {orderpair: orderpair});
    },
  });
});
