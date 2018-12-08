$(document).ready(function() {
  
  // Authentication
  $( "#login" ).on('click',function() {

    var username = $('#username').val(); 
    var password = $('#password').val();

    $.ajax({
        method : 'POST',
           url : '/task-management/authentication',
      dataType : 'json',
          data : {username : username, password : password},
      success : function(resp){
          if (resp.status == 200) {
              window.location.href = '/task-management/user-profile'; 
          }else{
              $('.alert STRONG').text(resp.message);
              $('.alert').show();
          }
      },
      error : function(resp){
         console.log(resp);
      }

    });
  });

  // Updating tasks
  $( "#ediTheTask" ).on('click',function() {

    var etask = $('#etask').val(); 
    var taskid = $('#taskid').val();

    $.ajax({
        method : 'POST',
           url : '/task-management/edit-task',
      dataType : 'json',
          data : {etask : etask, taskid : taskid},
      success : function(resp){
          if (resp.status == 200) {
              $('.alert').addClass('alert-success');
              $('.alert STRONG').text(resp.message);
              $('.alert').show(); 
          }else{
              $('.alert').addClass('alert-danger');
              $('.alert STRONG').text(resp.message);
              $('.alert').show();
          }
      },
      error : function(resp){
         console.log(resp);
      }

    });
  });

  // Changing task's status
  $('body').on('change','.check-status',function(){
        if(this.checked){
        	$('#idstatus').val($(this).data('id'));
        	$('#status').val('checked');
        	$("#form-status").submit();
        }else{
          $('#idstatus').val($(this).data('id'));
        	$('#status').val('unchecked');
        	$( "#form-status" ).submit();
        }
  });

  // Trigger of pagination tasks
	$( ".paginate" ).click(function() {

		var current = $('#curentPage').text();
		var total   = $('#totalPage').text();
		var _this   = $(this).data('page');
    var admin   = $(this).data('admin');

		if (_this == 'previous') {
			current = parseInt(current);
			if (current > 1) {
  				current--;
  				$('#curentPage').text(current);
  				$('#page_n').val(current);
          paginate(current, admin);
			}
		}else{
			if (current < parseInt(total)) {
  				current++;
  				$('#curentPage').text(current);
  				$('#page_n').val(current);
          paginate(current, admin);
			}
		}
		
	});

	$('#preview').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget);
          var name   = $('#name').val();
          var email  = $('#email').val();
          var task   = $('#task').val();
          var modal  = $(this);
          modal.find('#name').text(name);
          modal.find('#email').text(email);
          modal.find('#task').text(task);
  });

  // Display modal for editing tasks
  $('#ediTask').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget);
          var task   = button.data('task');
          var id     = button.data('id');
          var modal  = $(this);
          modal.find('#etask').val(task);
          modal.find('#taskid').val(id);
  });

  // Hidding alerts messages  
	$('.close').click(function(){
		 $('.alert').hide();
     window.location.reload();
	});

  // Sorting taks by keys
	$('#nameUp, #nameDown, #emailUp, #emailDown, #statusUp, #statusDown').each(function(){
	        var table = $('#sortTable');  
	 		var th = $(this),
                thIndex = th.index(),
                inverse = false;

            th.click(function(){
                
                table.find('td').filter(function(){
                    
                    return $(this).index() === thIndex;
                    
                }).sortElements(function(a, b){
                    
                    return $.text([a]) > $.text([b]) ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
                    
                }, function(){
                    return this.parentNode; 
                    
                });
                
                inverse = !inverse;
                    
            });          
	});
	
});


function loadFile(event) {
	var preview = document.getElementById('imagePreview');
    preview.src = URL.createObjectURL(event.target.files[0]);
};

/**
* function for paginate the tasks
* @param int var current
* @param string var admin
* @return array tasks 
*/
function paginate(current, admin){
    $.ajax({
          method : 'POST',
             url : '/task-management/paginate',
        dataType : 'json',
            data : {page_n : current},
        success : function(resp){
            var data = resp['tasks'];
            var table = $("#container-table");
            var table_a = $("#container-table-a");
            table.html('');
            table_a.html('');
            if (resp.status == 200) {
                 if (admin == 'admin') {
                    for (var i = 0; i < data.length; i++) {
                       var task = data[i];
                       status = task.status == 'checked' ? 'Approved' : 'Pending';
                       table_a.append(
                          "<tr><td><img src='build/img/tasks/"+task.image+"' style='width: 100px;'/></td><td>"+task.name+"</td><td>"+task.email+"</td><td class='text-justify'>"+
                          task.task+"</td><td><span data-toggle='modal' data-target='#ediTask' data-task='"+task.task+"' data-id='"+task.id+"'><i class='fa fa-edit' style='font-size: 1.5em;'></i></span>"+
                                                            "<span class='checkbox'>"+
                                                              "<label>"+
                                                                "<input type='checkbox' class='check-status' data-id='"+task.id+"' "+task.status+">"+
                                                                "<span class='cr'><i class='cr-icon fa fa-check'></i></span>"+
                                                              "</label></span></td> </tr>"
                       );
                   }
                 }else{
                   for (var i = 0; i < data.length; i++) {
                       var task = data[i];
                       status = task.status == 'checked' ? 'Approved' : 'Pending';
                       table.append(
                          "<tr><td><img src='build/img/tasks/"+task.image+"' style='width: 100px;'/></td><td>"+task.name+"</td><td>"+task.email+"</td><td class='text-justify'>"+
                          task.task+"</td><td colspan='2'>"+status+"</td> </tr>"
                       );
                   }
                 }
            }
        },
        error : function(resp){
           console.log(resp);
        }

      });
}
