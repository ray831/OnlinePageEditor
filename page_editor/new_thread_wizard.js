var pgname, tpname;
$(function () {
	$( "#btn_for_new" ).on( "click", function(){SelectWizard("new")});
	$( "#btn_for_edit" ).on( "click", function(){SelectWizard("edit")});

});

function SelectWizard(sel)
{
	if(sel === "new"){
		$('div.wizard-begin').fadeOut('fast', function(){
			$('#wizard_editpage').remove();
			$('.loader').show();
			
			$('#newPageWizard').wizard().on('finished.fu.wizard', function (evt) {
				new_WizardComplete();
			});
			
			$.post('page_editor/ajax/new_thread_wizard_ajax.php',
					{
						oper: 'qry_template'
					},
					function(data) {
						$('.list-template').select2({
							data: data
						})
						.on("select2:close", function () {
							if (tpname === $('.list-template').val()) return false;
							
							tpname = $('.list-template').val();
							$.post('page_editor/ajax/new_thread_wizard_ajax.php',
									{
										oper: 'req_template_content',
										tpname: tpname
									},
									function(data) {
										$('#template_preview').html( data );
									},"json"
							);
						});
						
						$('.loader').hide();
						$('#wizard_newpage').show(300);
					},"json"
			);

		});
	}
	else if(sel === "edit"){
		$('div.wizard-begin').fadeOut('fast', function(){
			$('#wizard_newpage').remove();
			$('.loader').show();
			
			$('#editPageWizard').wizard().on('finished.fu.wizard', function (evt) {
				edit_WizardComplete();
			});
			
			$.post('page_editor/ajax/new_thread_wizard_ajax.php',
					{
						oper: 'qry_page_name'
					},
					function(data) {
						$('.list-pubpage').select2({
							data: data
						});
						
						$('.loader').hide();
						$("#wizard_editpage").show(300);
					},"json"
			);

		});
	}
}

function new_WizardComplete()
{
	pgname = $('#new_page_name').val();
	tpname = $('.list-template').val();
	
	if( !pgname ) {
		toastr["error"]("尚未設定頁面名稱", "未完成");
		return;
	}
	
	$.ajax ({
		url: 'page_editor/ajax/new_thread_wizard_ajax.php',
		type: 'post',
		data: {
			oper: 'check_file_exist',
			pgn: pgname
		},
		success: function (result) {
				if(result == "1")
					toastr["error"]("已存在相同頁面名稱", "錯誤");
				else {
					bootbox.confirm({
						message: "將會建立新頁面："+ pgname +"，<br>確定嗎?",
						buttons: {
							confirm: {
								label: '確定',
								className: 'btn-danger'
							},
							cancel: {
								label: '取消',
								className: 'btn-default'
							}
						},
						callback: function (result) {
							if( result ) {
								$.post('page_editor/ajax/new_thread_wizard_create.php',
									{
										oper: "create",
										pgname: pgname,
										tpname: tpname
									},
									function(data) {
										bootbox.alert("已建立新頁面", function(){window.location.replace("new_thread.php?pgn=" + pgname);});
									}
								);
							}
						}
					});
				}
		}
	});
}

function edit_WizardComplete()
{
	pgname = $('.list-pubpage').val();
	
	
	bootbox.confirm({
		message: "將會為此頁面："+ pgname +" 建立編輯頁，<br>確定嗎?",
		buttons: {
			confirm: {
				label: '確定',
				className: 'btn-danger'
			},
			cancel: {
				label: '取消',
				className: 'btn-default'
			}
		},
		callback: function (result) {
			if( result ) {
				$.post('page_editor/ajax/new_thread_wizard_create.php',
					{
						oper: "edit",
						pgname: pgname
					},
					function(data) {
						bootbox.alert("已建立編輯頁", function(){window.location.replace("new_thread.php?pgn=" + pgname);});
					}
				);
			}
		}
	});

}


function showIframe()
{
	$('.PreView-IFrame').attr("src", $('.list-pubpage').val() + ".php");
	$('#fullscrModal').modal('show');
}