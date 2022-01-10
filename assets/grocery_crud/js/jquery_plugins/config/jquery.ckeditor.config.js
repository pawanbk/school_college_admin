$(function(){
	$( 'textarea.texteditor' ).ckeditor({toolbar:'Full'});
});

$(function() {
	$('textarea.texteditor').ckeditor({
			language: 'en',
			extraPlugins : 'placeholder,youtube',
			toolbar: [
			['Source','-','Save','NewPage','Preview','-','Templates'],
	  ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
	['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
	'/',
	['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
	['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
	['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	['Link','Unlink','Anchor','Youtube'],
	['Image','Flash','Table','HorizontalRule','Hhs','Smiley','SpecialChar','PageBreak'],
	'/',
	['Styles','Format','Font','FontSize'],
	['TextColor','BGColor'],
	['Maximize', 'ShowBlocks','-','About','CreatePlaceholder']
	   
	],
			//this code below for kcfinder           
			filebrowserBrowseUrl: '/assets/grocery_crud/texteditor/ckeditor/kcfinder/browse.php?opener=ckeditor&type=files',
			filebrowserImageBrowseUrl: '/assets/grocery_crud/texteditor/ckeditor/kcfinder/browse.php?opener=ckeditor&type=images',
			filebrowserFlashBrowseUrl: '/assets/grocery_crud/texteditor/ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash',
			filebrowserUploadUrl: '/assets/grocery_crud/texteditor/ckeditor/kcfinder/upload.php?opener=ckeditor&type=files',
			filebrowserImageUploadUrl: '/assets/grocery_crud/texteditor/ckeditor/kcfinder/upload.php?opener=ckeditor&type=images',
			filebrowserFlashUploadUrl: '/assets/grocery_crud/texteditor/ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash'
			
   
			
	});
	$('textarea.mini-texteditor').ckeditor({
			language: 'en',
			toolbar: 'Basic',
			width: 700
	});
});