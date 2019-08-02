<? if ( basename($_SERVER['PHP_SELF']) == 'new_thread.php' ) : ?>
	
	<script src="page_editor/js/ckeditor/ckeditor.js"></script>
	<script src="page_editor/js/ace-builds/src-min-noconflict/ace.js"></script>
	<script src="page_editor/js/ace-builds/src-min-noconflict/ext-language_tools.js"></script>
	<script src="page_editor/js/ace-builds/src-min-noconflict/ext-themelist.js"></script>
    <script src="page_editor/js/select2.full.min.js"></script>
    <script src="page_editor/js/bootstrapValidator.min.js"></script>
	<script src="page_editor/js/bootstrap-toggle.min.js"></script>
    <script src="page_editor/js/jquery.countdown.min.js"></script>
    <script src="page_editor/js/sha1-min.js"></script>
    <script src="page_editor/js/bootstrap-table.min.js"></script>
    <script src="page_editor/js/sweetalert2.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/3.6.4/firebase.js"></script>
    <script src="page_editor/js/firepad.min.js"></script>
    <script src="page_editor/collproj.js"></script>
    <script src="page_editor/new_thread_extension.js"></script>
    <script src="page_editor/new_thread.js"></script>
	
<? elseif ( basename($_SERVER['PHP_SELF']) == 'new_thread_wizard.php' ) : ?>

	<script src="page_editor/js/ace-builds/src-min-noconflict/ace.js"></script>
	<script src="page_editor/js/ace-builds/src-min-noconflict/ext-language_tools.js"></script>
    <script src="page_editor/js/fuelux/js/fuelux.min.js"></script>
    <script src="page_editor/js/bootstrapValidator.min.js"></script>
	<script src="page_editor/js/bootstrap-toggle.min.js"></script>
	<script src="page_editor/js/select2.full.min.js"></script>
    <script src="page_editor/js/sha1-min.js"></script>
    <script src="page_editor/new_thread_extension.js"></script>
    <script src="page_editor/new_thread_wizard.js"></script>
	
<? endif; ?>
