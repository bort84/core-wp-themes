jQuery(document).ready(function($) {
	// disable check box for Settings > General: Membership 
	$("label[for='users_can_register']").attr('disabled', true);
	$("#users_can_register").attr('disabled', true);
});