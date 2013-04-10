// JavaScript Document
var LBGalleryCore = LBGalleryCore || {};
LBGalleryCore.doTask = function(task, frm){
	var form = frm || document.adminForm;
	form.task.value = task;
	form.submit();
}
LBGalleryCore.listItemTask = function( id, task ) {
    var f = document.adminForm,
		action = f.action || '';	
    cb = eval( 'f.' + id );
    if (cb) {
        for (i = 0; true; i++) {
            cbx = eval('f.cb'+i);
            if (!cbx) break;
            cbx.checked = false;
        } // for
        cb.checked = true;
        f.boxchecked.value = 1;
        LBGalleryCore.doTask(task);
    }
    return false;
}
LBGalleryCore.checkAll = function(checked){
	var f = document.adminForm;
	for (var i = 0; true; i++) {
		cbx = eval('f.cb'+i);
		if (!cbx) break;
		cbx.checked = checked;
	} // for
	jQuery('.chk-all').attr('checked', checked);
}
LBGalleryCore.isChecked = function(checked){
	var f = document.adminForm,
		allChecked = true;
	
	for (var i = 0; true; i++) {
		cbx = eval('f.cb'+i);
		if (!cbx) break;
		if(cbx.checked == false){
			allChecked = false;
			break;
		}
	} // for
	jQuery('.chk-all').attr('checked', allChecked);
}