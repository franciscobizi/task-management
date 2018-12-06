$(document).ready(function() {

	var $checked = $('.check-status');
    $checked.change(function(){
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

	$( ".paginate" ).click(function() {

		$current = $('#curentPage').text();
		$total   = $('#totalPage').text();
		$this    = $(this).data('page');

		if ($this == 'previous') {
			$current = parseInt($current);
			if ($current > 1) {
				$current--;
				$('#curentPage').text($current);
				$('#page_n').val($current);
				$( "#form-pagination" ).submit();
			}
		}else{
			if ($current < parseInt($total)) {
				$current++;
				$('#curentPage').text($current);
				$('#page_n').val($current);
				$( "#form-pagination" ).submit();
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

    $('#ediTask').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget);
          var task   = button.data('task');
          var id     = button.data('id');
          var modal  = $(this);
          modal.find('#task').val(task);
          modal.find('#taskid').val(id);
    });

	$('.close').click(function(){
		$id = $(this).data('id');
		if ($id == 'closeAdmin') {
			window.location.href = 'user-profile';
		}else{
			window.location.href = '/';
		}
	});

    
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
