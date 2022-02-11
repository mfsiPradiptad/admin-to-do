$(function(){

    $('.add').on('click', function(e){
        e.preventDefault();

        var item = $('<li data-id="0">'+
            '<input type="checkbox" title="Mark as Complete"/> <input type="text" value="" placeholder="Write your todo here" class="todoInput" />'+
            '<a href="javascript:void(0);" class ="save-item" title="Save To Do"> &#10004; </a> <a href="#" class="delete">✖</a>'+
            '</li>'); 
        $('#todo').find('ul').append(item);
        $('.nodos').hide();
        
    });

     $('#todo').on('click', '.save-item', function(e){
        var li = $(this).closest('li');
        var liId = li.data('id');
        var data = $(this).closest('li').find('.todoInput').val();
    
        $.ajax({
            type : "post",
            dataType : "json",
            url : ajaxurl,
            data : {action: "todo_ajax", task: "save", id : liId, data: data},
            success: function(response) {
                
                dataId = response.post;
               if(liId != dataId){                 
                    li.data('id', dataId);
                    alert("Your todo saved successfully!");
                }
                if(liId == dataId) {
                    alert("Your todo updated successfully!");
                }             
            }
         });

    }); 

    $('#todo').on('change', 'li input[type=checkbox]',function(e){

        var checkbox = $(this),
        li = checkbox.closest('li');

        li.toggleClass('done', checkbox.is(':checked'));
        var id = li.data('id');
        var task = '';

        if(checkbox.is(':checked')){
            task = 'check'
        }
        else{
            task = 'uncheck';
        }

        $.ajax({
            type : "post",
            dataType : "json",
            url : ajaxurl,
            data : {action: "todo_ajax", task: task, id : id},
            success: function(response) {
                if(response.task == 'marked'){
                    alert("Task is marked as Completed.");
                    $('.save-item').removeClass('visible');
                    $('.save-item').addClass('invisible');
                    
                } else{
                    alert("Task is marked as uncomplete.");
                    $('.save-item').addClass('visible');
                    $('.save-item').removeClass('invisible');
                }            
            }
         });

    });

    $('#todo').on('click', 'li .delete',function(e){

        e.preventDefault();

        var li = $(this).closest('li');

        li.fadeOut(function(){
            li.remove();
        });
        var id = li.data('id');

        if(id != 0){

            $.ajax({
                type : "post",
                dataType : "json",
                url : ajaxurl,
                data : {action: "todo_ajax", task: 'delete', id : id},
                success: function(response) {
                    if(response.task == 'deleted'){
                        alert("Task is deleted.");
                    }            
                }
             });
        }

    });




});