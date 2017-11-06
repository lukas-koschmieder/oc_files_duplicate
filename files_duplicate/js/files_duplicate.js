/**
 * ownCloud - files_duplicate
 * @author Lukas Koschmieder <lukas.koschmieder@rwth-aachen.de>
 * @author Alper Topaloglu <alper.topaloglu@iehk.rwth-aachen.de>
 * @copyright Lukas Koschmieder 2017
 */

(function(OC, OCA) {
$(document).ready(function() {
try {

// Register "Duplicate" action in Files app.
// Create custom "Duplicate" menu item. Define click callback.
OCA.Files.fileActions.registerAction({
	name          : 'duplicate',
	displayName   : 'Duplicate',
	mime          : 'all',
	permissions   : OC.PERMISSION_UPDATE,
	type          : OCA.Files.FileActions.TYPE_DROPDOWN, // TYPE_DROPDOWN | TYPE_INLINE
	order         : -50, // Place "Duplicate" item between "Details" and "Rename"
	icon          : OC.imagePath('core', 'actions/add'),
	actionHandler : function (fileName, fileObject) {
		OC.dialogs.info("Duplicating " + fileName + ". Please wait...", "Duplicate", function() {}, true);

		// Send duplicate request to PHP backend via HTTP POST
		request = $.ajax({
			type : "post",
			url  : OC.generateUrl("/apps/files_duplicate/duplicate"),
			data : { dirname: fileObject.dir, basename: fileName }
		});
		// Process backend response
		request.done(function (data) {
			$('.oc-dialog-content').each(function() { $(this).ocdialog('close'); }); // @TODO Close only above dialog
			if(data.success) {
				OC.Notification.showHtml(data.message, { timeout: 10 });
				FileList.add(data.info); // Refresh view
			} else {
				OC.dialogs.alert(data.message ? data.message : "Failed to duplicate file", 'Error', function() {}, true);
			}
		});
		request.fail(function (jqXHR, textStatus, errorThrown) {
			$('.oc-dialog-content').each(function() { $(this).ocdialog('close'); }); // @TODO Close only above dialog
			OC.dialogs.alert('Failed to duplicate file: ' + errorThrown, 'Connection Failure', function() {}, true);
		});
	}
});

} catch(e) {}
});
})(OC, OCA);
