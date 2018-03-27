<?php
	
	incl::package('mail');
	use PHPMailer\PHPMailer;

	class mailController extends controller {

		// Отправляем сообщение
		public function mail () {
			$mail = $this -> render();

			 if($mail->send()) {
				$data = [
					'success' => 1
				];
			} else {
				$data = [
					'success' => 0
				];				
			} 

			echo json_encode($data);
		}

		//Собирает сообщения для отправки
		private function render() {
			$mail = $this -> configs();

			$dataPost    = $_POST;
			$form 		 = $_POST['form'];
			$data["msg"] = '';

			foreach ($dataPost['inputs'] as $input) {
				$data["msg"] .= $input['mail'] . ':' . $input['value'] . '<br>';
			}

			//Тема письма 
			$mail->Subject = 'Заявка с сайта';
			//Сообщение
			$mail->Body = $data["msg"];	 

			return $mail;
		}

		private function configs () {
			$mail = new PHPMailer\PHPMailer();
			//будем отравлять письмо через СМТП сервер
			$mail->isSMTP();
			//хост
			$mail->Host = 'smtp.yandex.ru';
			//требует ли СМТП сервер авторизацию/идентификацию
			$mail->SMTPAuth = true;
			// логин от вашей почты
			$mail->Username = 'servermessagesgpoint@yandex.ru';
			// пароль от почтового ящика
			$mail->Password = 'smtp_server_jpoint_smtp';
			//указываем способ шифромания сервера
			$mail->SMTPSecure = 'ssl';
			//указываем порт СМТП сервера
			$mail->Port = '465';
			 
			//указываем кодировку для письма
			$mail->CharSet = 'UTF-8';
			//информация от кого отправлено письмо
			$mail->From = 'servermessagesgpoint@yandex.ru';
			//название сообщения
			$mail->FromName = 'Кухни';
			//На какой адрес будет отправлено письмо
			$mail->addAddress('webproger2014@gmail.com');

			$mail->isHTML(true);	

			return $mail;		
		}													
	}


