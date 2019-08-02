/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.uiColor = '#AADC6E';
	config.forcePasteAsPlainText = true;
	config.skin = 'office2013';
	//config.language = 'zh';
	
	config.removeButtons = 'Save,Print,NewPage';
	
	config.allowedContent=true;
	config.toolbarCanCollapse = true;
	CKEDITOR.dtd.$removeEmpty['span'] = false;
	CKEDITOR.dtd.$removeEmpty['i'] = false;
	
	
	config.protectedSource.push( /<\?[\s\S]*?\?>/g );   // PHP Code
	
	//sourcedialog
	config.extraPlugins = 'balloonpanel,xml,lineutils,widget,basewidget,mathjax,eqneditor,bootstrapTabs,codemirror,layoutmanager,a11ychecker,autogrow,ajax,btbutton,glyphicons,btgrid,bt_table,codesnippet,cssanim';
	
	
	config.contentsCss = ['bower_components/bootstrap/dist/css/bootstrap.min.css',
						  'bower_components/font-awesome/css/font-awesome.min.css'
						 ];
	
	
	
	config.height = '450px';
	
	config.mathJaxLib = '//cdn.mathjax.org/mathjax/2.6-latest/MathJax.js?config=TeX-AMS_HTML';
	
	config.codeSnippet_theme = 'pojoaque'
	
	config.codemirror = {
		useBeautify: true,
		autoFormatOnStart: true
	};
};
