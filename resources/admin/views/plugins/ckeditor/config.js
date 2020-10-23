/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'vi';	
	// config.uiColor = '#AADC6E';	
	config.height = '200px';
	config.toolbar = [
						{name: 'styles', items : ['Styles', 'Font', 'FontSize']},
						{name: 'basicsstyles', items : [ 'Bold', 'Italic', 'Underline', 'Strike', '-', 'TextColor', 'BGColor', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']}
													
					];
};
