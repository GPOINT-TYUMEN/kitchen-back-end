$(function () {

	//> Изменение данных профиля
	$('.account-info button').on('click', function () {
		var nickname = $('.account-info #nickname').val(),
			password = $('.account-info #password').val();

		var data = {
			src: '/back/admin/profile/edit',
			action: 'show_msg_edit_profile',
			post: {
				'nickname': nickname,
				'password': password				
			}
		};	
		ajaxPost(data);

	});
	//< Изменение данных профиля

});


function show_msg_edit_profile($data) {
	if ($data["success"] === 1) {
		location.reload();
	} else {
		$('#error-nickname').text($data["message"]);
	}

	console.log($data);
}