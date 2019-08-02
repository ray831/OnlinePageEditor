var page_name;
$(function () {
	page_name = getQueryVariable("pgn");
    if( !page_name ){
		ShowEditorPageSelector();
		return false;
	}
	
	$.ajax ({
		url: 'page_editor/ajax/new_thread_ajax.php',
		type: 'post',
		data: {
			oper: 'check_file_exist',
			pgn: page_name
		},
		success: function (result) {
			if(result === "1")
				InitializeEditor();
			else
				ShowEditorPageSelector();
		}
	});
});

function RedirectToWizard()
{
	window.location.replace("new_thread_wizard.php");
}



function ShowEditorPageSelector()
{
	$('#editor_main').remove();
	
	$.post('page_editor/ajax/new_thread_ajax.php',
            {
				oper: 'qry_page_name'
            },
            function(data) {
				$("select[name='pgn']").select2({
					data: data
				});
				
				$('.spinner').slideUp('slow', function(){
					$('#editor_selector').slideDown();
				});
            },"json"
    );
}

//prototype
var ace_editors = {
	js: undefined,
	ss: undefined
};

var contents_buffer = {
	htm: {},
	js: {},
	ss: {}
};

var atsvTimer = $('#autosaveClock').countdown( new Date().getTime() );
var AutoSave = function( isEnable, intv )
{
	if( isEnable ) {
		atsvTimer.countdown( new Date().getTime() + intv * 1000 )
		.on('update.countdown', function(event) {
			$(this).html(event.strftime('自動保存: <span>%H:%M:%S</span>'));
		})
		.on('finish.countdown', function(event) {
			$(this).countdown( new Date().getTime() + intv * 1000 );
		});
	}
	else {
		atsvTimer.countdown('stop');
		$('#autosaveClock').html("自動保存已終止");
	}
};

function InitializeEditor()
{
	/*
	window.onbeforeunload = function(){
		return "hihihi";
	if( UrlExists( page_name + ".php" ) ){
		$('#FullViewFrame').attr('src', page_name + ".php");
	}
	}
	*/
	$('#editor_selector').remove();
	
	// Initialize ACE Editor setting
	!function(){
		ace.require("ace/ext/language_tools");
		ace_editors.js = ace.edit("ace_js_edit_area");
		ace_editors.ss = ace.edit("ace_ss_edit_area");

		ace.config.loadModule("ace/ext/keybinding_menu", function(module) {
			module.init(ace_editors.js);
			module.init(ace_editors.ss);
		});
		ace_editors.js.getSession().setMode("ace/mode/javascript");
		ace_editors.js.setOptions({
			enableBasicAutocompletion: true,
			enableSnippets: true,
			enableLiveAutocompletion: true,
			showPrintMargin: false,
			minLines: 15,
			maxLines: 30
		});
		ace_editors.js.$blockScrolling = Infinity;
		//var firepad = Firepad.fromACE(firepadRef, ace_editors.js);
		
		ace_editors.ss.getSession().setMode("ace/mode/php");
		ace_editors.ss.setOptions({
			enableBasicAutocompletion: true,
			enableSnippets: true,
			enableLiveAutocompletion: true,
			showPrintMargin: false,
			minLines: 15,
			maxLines: 30
		});
		ace_editors.ss.$blockScrolling = Infinity;
		
		//ace_editors.js.resize();
		//ace_editors.ss.resize();
	}();
	
	// Initialize CKEDITOR setting
	!function(){
		CKEDITOR.replace( 'ck_htm_ediotr', {
			on: {
				change: function (){
					$("#editor_live_preview").html(
						this.getData()
					);
				},
				instanceReady: function (){
					LoadFile("temp", {showMsg: false});
					LoadFile("public", {setAfterloaded: true, showMsg: false, callback: toastr["success"]("初始化已完成")});
				}
			}
		} );
	}();
	
	
	
	
	// InitializeComponent, such as button...
	!function(){
		
		// bootbox setting
		bootbox.setDefaults({locale: "zh_TW", backdrop: true, onEscape: true});
		
		//editor button group
		var btn_group = $('.editor_button_group').html();

		$( '#btn_ace_js' ).html(btn_group);
		$( '#btn_ace_ss' ).html(btn_group);
		
		// Page AutoSave event binding
		$('#autosaveToggle').change(function() {
			if ($(this).prop('checked')) 
				$('#autosaveInterval').removeAttr("disabled");
			else 
				$('#autosaveInterval').attr("disabled", "disabled");
		});
		
		$('#editor_style').select2({
			data: (function(){
				var themelist = ace.require("ace/ext/themelist").themes;
				var data = [];
				for (var i = 0; i < themelist.length; i++) {
					var theme = themelist[i];
					data.push({id: theme.name, text: theme.caption});
				}
				return data;
			})()
		});
		
		$('i.coll-edit-ico').tooltip({
			title: '協作編輯'
		});
		$('i.key-shortcut-ico').tooltip({
			title: '快捷鍵'
		});
		//$('#dt_version').DataTable();
		
		//colledit
		//initFirebase();
		//connectFirebase();
		
	}();
	
	
	loadPageSetting();
	
	$('.spinner').slideUp('slow', function(){
		$('#editor_main').slideDown('slow', function(){
			$(this).removeClass('editor-invisible');
		});
	});
}


function QuickLoad(obj)
{
	var type = obj.parentsUntil( ".editor_button_group" )
					.parent().attr('name');
	var loadFrom = obj.prev().val();
	
	if( !loadFrom ) {toastr["error"]("未選擇", "錯誤"); return;}
	
	bootbox.confirm({
		message: "自緩衝區讀取 " + loadFrom + " 內容後寫入編輯器，<br>確定嗎?",
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
				setDataFromBuffer( type, loadFrom );
			}
		}
	});
}


function QuickSave(obj)
{
	var type = obj.parentsUntil( ".editor_button_group" )
					.parent().attr('name');
	var saveTo = obj.prev().val();
	
	if( !saveTo ) {toastr["error"]("未選擇", "錯誤"); return;}
	
	if( saveTo == "public" )
		SaveFile( "public", { types: type } );
	else
		SaveFile( "temp", { types: type, version: saveTo} );
}

function UnionSelectDOM( data )
{
	
	if($('select[name="srcbuffer"] option[value="' + data + '"]')
		.length != 0 ) return;
		
	
	$("select[name='srcbuffer']")
			.append($("<option></option>")
			.attr("value", data)
			.text(data));
}

function AceEditorToolbarFn( opt, id  )
{
	if( opt == 0 ){

		// id: 
		// 	JavaScript = 0,
		// 	Server-Side Script = 1
		(function( id ){
			if ( id > 1 || id < 0 ) return false;
			
			var stText = '開始前將會自動保存目前的內容',
				stTitle = '立即開始協作編輯嗎？',
				endTitle = '確定要中斷協作編輯嗎？';
			
			var type = (id == 0) ? "js" : "ss";
			
			if ( !hasFirepadCreated( id ) ){
				swal({
					title: stTitle,
					text: stText,
					type: 'info',
					confirmButtonText: '開始',
					showCancelButton: true,
					cancelButtonText: '離開',
					showLoaderOnConfirm: true,
					preConfirm: function(){
						return new Promise(function(resolve, reject){
							createFirepad( ace_editors[type], {
								firepadId: id,
								beforeCreated: function(){
									contents_buffer[type]['auto'] = ace_editors[type].session.getValue();
								},
								afterCreated: resolve,
								error: reject
							} );
						})
					},
					allowOutsideClick: false
				}).then(function () {
					swal('已準備就緒', '', 'success');
				});
			}
			else {
				swal({
					title: endTitle,
					type: 'info',
					confirmButtonText: '中斷',
					showLoaderOnConfirm: true,
				}).then(function () {
					destoryFirepad( id, function(){swal('已中斷協作編輯', '', 'success')} );
				});
			}
		})( id );
		
	}
	else if( opt == 1 ){
		
	}
	
}

function EditorOptionAction( opt )
{
	if( opt === 1 ) {
		var msg = 
			CKEDITOR.instances['ck_htm_ediotr'].getData() || " ";
		bootbox.alert({ 
			size: "large",
			title: "即時預覽",
			message: msg
		});
	}
	else if( opt === 2 ) {
		if ( $('#autoQsaveToggle').prop('checked') ) {
			var loaddlg = bootbox.dialog({
				message: '<p><i class="fa fa-spin fa-spinner"></i> 保存中，請稍後...</p>',
				closeButton: false
			});
			SaveFile( "public", {
				showMsg: false,
				callback: function(){
					loaddlg.modal('hide');
					showIframe();
				}
			} );
		} else {
			showIframe();
		}
	}
	else if( opt === 3 ) {
		$('#live_preview_panel').slideDown();
	}
	else if( opt === 4 ) {
		$('#live_preview_panel').slideUp();
	}
	else if( opt === 5 ) {
		var loaddlg = bootbox.dialog({
			message: '<p><i class="fa fa-spin fa-spinner"></i> 讀取中...</p>',
			closeButton: false
		});
		
		$.post('page_editor/ajax/new_thread_ajax.php',
            {
				oper: 'qry_page_version',
				pgn: page_name
            },
            function(data) {
				loaddlg.modal('hide');
				
				data.push({text:"頁面資料夾", value:"public"});
				
				bootbox.prompt({
					title: "請選擇一個版本",
					inputType: 'select',
					inputOptions: data,
					className: "version-select",
					callback: function (ver) {
						if ( ver ){
							if( ver == "public" ) {
								LoadFile( "public" );
							}
							else {
								LoadFile( "temp", {version: ver} );
								UnionSelectDOM( ver );
							}
						}
					}
				})
				.init( function() {
					$(this).find('.version-select').find('.bootbox-body' ).append('<br><p>說明：</p><p>將至暫存資料夾讀取指定版本，並寫入至緩衝區中</p>');
				});
				
				
            },"json"
		);
	}
	else if( opt === 6 ) {
		bootbox.confirm({
			message: "操作不可復原，編輯器的內容可能會遺失，確定嗎?",
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
				if( result ){
					CKEDITOR.instances.ck_htm_ediotr.destroy();
					CKEDITOR.replace( 'ck_htm_ediotr', {
						on: {
							change: function (){
								$("#editor_live_preview").html(
									this.getData()
								);
							},
							instanceReady: function (){
								toastr["success"]("已重建編輯器");
							}
						}
					} );
				}
			}
		});
	}
	else if( opt === 7 ) {
		$('#editor_menu').find('a').find("span").toggleClass("text-hide");
		
		$('#editor_menu').toggleClass("col-sm-2 col-sm-1");
		$('#editor_body').toggleClass("col-sm-10 col-sm-11");
	}
}

function savePageSetting()
{
	setCookie("editor_fnsize", $('#editor_fnsize').val() );
	setCookie("editor_style", $('#editor_style').val() );
	
	setCookie("autosaveToggle",
			$('#autosaveToggle').prop('checked') ? "on" : "off");
	
	setCookie("autoQsaveToggle",
			$('#autoQsaveToggle').prop('checked') ? "on" : "off");
	
	setCookie("autosaveInterval", $('#autosaveInterval').val() );
	
	
	loadPageSetting();
	bootbox.alert("設定已變更");
}

function loadPageSetting()
{
	var editor_fnsize    = getCookie("editor_fnsize")	|| "16",
		editor_style     = getCookie("editor_style")	|| "monokai",
		autosaveToggle   = getCookie("autosaveToggle")	|| "on",
		autoQsaveToggle  = getCookie("autoQsaveToggle") || "off",
		autosaveInterval = getCookie("autosaveInterval")|| "1800";
	
	for(var inst in ace_editors){
		ace_editors[inst].setTheme("ace/theme/" + editor_style, function(){
			var aceColor = $('div.ace_gutter').css("color"),
				aceBg 	 = $('div.ace_gutter').css("background");
			
			$('.editor-toolbar').css("color", aceColor);
			$('.editor-toolbar').css("background", aceBg);
		} );
		ace_editors[inst].setFontSize( parseInt( editor_fnsize ) );
	}
	
	// setting form
	$('#editor_fnsize').val(editor_fnsize);
	$('#editor_style').val(editor_style).trigger("change");
	$('#autoQsaveToggle').bootstrapToggle( autoQsaveToggle );
	$('#autosaveToggle').bootstrapToggle( autosaveToggle );
	$('#autosaveInterval').val( autosaveInterval );
	
	if ( $('#autosaveToggle').prop('checked') ) {
		AutoSave( true, parseInt( autosaveInterval ) );
	} else {
		AutoSave( false );
	}
}


function LoadFile( loadFrom, options )
{
	if( !loadFrom.match(/^(temp|public)$/) ) {
		throw new Error('undefined "loadFrom" parameter.');
	}
	
	var defaults = {
		version: "auto",
		types: ['htm', 'js', 'ss'],
		setAfterloaded: false,
		showMsg: true,
		callback: null
	};
	
	var param = 
		$.extend( defaults, options );
	
	param.version = (loadFrom == "public")
				  ? loadFrom : param.version;
	$.loadPageData( 
		{
			pgname: page_name,
			version: param.version,
			types: param.types,
			loadFrom : loadFrom
		},
		function( JData ) {
			
			for( var key in JData ) {
				switch (key){
					case 'htm':
						contents_buffer.htm[param.version] = JData.htm;
						break;
					case 'js':
						contents_buffer.js[param.version] = JData.js;
						break;
					case 'ss':
						contents_buffer.ss[param.version] = JData.ss;
						break;
				}
			}
			
			if( param.showMsg ){
				toastr["success"]("已讀取檔案至緩衝區", 
					loadFrom.toUpperCase() +"："+ param.version);
			}
			
			if( param.setAfterloaded )
				setDataFromBuffer( param.types, param.version );
			
			if ( typeof param.callback === "function" )
				param.callback( JData );
		}
    );
}

function setDataFromBuffer( types, ver )
{
	if ( !Array.isArray(types) ) {
		
		if( !types.match(/^(htm|js|ss)$/) ) 
			throw new Error('undefined "types" prototype.');
		else
			types = [types];
	}
	
	var version = ver || "auto";
	
	for (var i = 0; i < types.length; i++) {
		if ( !contents_buffer[types[i]][version] ){
			var caption = ( types[i] == 'htm') ? 'HTML' :
						  ( types[i] == 'js')  ? 'JavaScript' : 
						  ( types[i] == 'ss')  ? 'Server-Side Script' : '';
			toastr["error"]("無內容", caption);
			continue;
		}
		
		switch (types[i])
		{
		case 'htm':
			CKEDITOR.instances['ck_htm_ediotr'].setData(contents_buffer.htm[version],{
				callback: function(){$("#editor_live_preview").html(contents_buffer.htm[version]);}
			});
			break;
			
		case 'js':
			ace_editors.js.session.setValue(contents_buffer.js[version]);
			break;
			
		case 'ss':
			ace_editors.ss.session.setValue(contents_buffer.ss[version]);
			break;
		}
	}
	
}

function SaveFile( to, options )
{
	if( !to.match(/^(temp|public)$/) ) {
		throw new Error('undefined "to" parameter.');
	}
	
	var defaults = {
		version: "auto",
		types: ['htm', 'js', 'ss'],
		showMsg: true,
		callback: null
	};
	
	var param = 
		$.extend( defaults, options );
		
	if ( !Array.isArray(param.types) ) {
		param.types = [param.types];
	}
	
	param.version = (to == "public")
				  ?  to : param.version;

	var contents = {};
	for (var i = 0; i < param.types.length; i++) 
	{
		switch (param.types[i])
		{
		case 'htm':
			var data = CKEDITOR.instances['ck_htm_ediotr'].getData();
			
			contents.htm = data;
			contents_buffer.htm[param.version] = data;
			break;
		case 'js':
			var data = ace_editors.js.session.getValue();
			
			contents.js = data;
			contents_buffer.js[param.version] = data;
			break;
		case 'ss':
			var data = ace_editors.ss.session.getValue();
		
			contents.ss = data;
			contents_buffer.ss[param.version] = data;
			break;
		}
	}

	
	$.savePageData( 
		{
			pgname: page_name,
			version: param.version,
			contents: JSON.stringify(contents),
			saveTo : to
		},
		function( JData ) {

			if ( param.showMsg ){
				for( var key in JData ) 
				{
					switch (key)
					{
					case 'htm':
						toastr["success"]("共寫入" + JData.htm + "位元組", 
											"完成");
						break;
					case 'js':
						toastr["success"]("共寫入" + JData.js + "位元組", 
											"完成");
						break;
					case 'ss':
						toastr["success"]("共寫入" + JData.ss + "位元組", 
											"完成");
						break;
					}
				}
				toastr["success"]("已寫入檔案至指定資料夾", 
							to.toUpperCase() +"："+ param.version);
			}
							
			if ( typeof param.callback === "function" )
				param.callback();
		}
    );
	
}


function SaveMany( saveTo, ver )
{
	var data = {
		htm: CKEDITOR.instances['ck_htm_ediotr'].getData(),
		js:  ace_editors.js.session.getValue(),
		ss:  ace_editors.ss.session.getValue()
	};
	
	$.savePageData( 
		{
			pgname: page_name,
			version: ver || "auto",
			contents: JSON.stringify(data),
			saveTo : saveTo || 'temp'
		},
		function( JData ) {
			toastr["success"]("已保存至目的資料夾", "成功");
		}
    );
}

function showIframe()
{
	$('.PreView-IFrame').attr("src", page_name + ".php");
	$('#fullscrModal').modal('show');
}

//check if file exists used for full-view page context in iframe
function UrlExists(url)
{
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    return http.status!=404;
}
