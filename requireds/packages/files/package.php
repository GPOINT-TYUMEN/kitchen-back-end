<?php 
	class file {
		static public $types = [
			'JPG' => 'image/jpeg',
			'PNG' => 'image/png',
			'SVG' => 'image/svg+xml',
			'GIF' => '',
			'PDF' => '',
			'DOC' => '',
			'JS'  => '',
			'CSS' => '',
		];

		//Загружает файл на сервер
		static public function load($type = false, $dir = 'uploads/images/') {
			$file = self::check_file();
			$success = true;

			if($file) {
				//Если файл зависим от типа то сперва запретим загрузку файла
				if ($type) {
					$success = false;
				}

				//Нам нужны только изображения JPG, PNG
				if ($type === 'IMG') {
					$data = self::format($file, ['JPG', 'PNG']);

					if ($data) {
						$success = true;
					}
				}

				//Нам нужны только документы PDF, DOC
				if ($type === "DOCS") {
					$data = self::format($file, ['JPG', 'PNG']);	//Пока не сделано

					if ($data) {
						$success = true;
					}
				}
			}

			if ($success === true ) {
				return self::upload($file, $dir);
			} else {
				return ["success" => false];
			}

		}

		static private function upload ($file, $dir) {
		    $tmp_name = $file['tmp_name'];
		    $name 	  = $file['name'];
		    $nameLen  = strlen($name);

		    $format   = $name[$nameLen - 3] . $name[$nameLen - 2] . $name[$nameLen - 1];
		    $name =  time() . self::generate_name() .'.' .$format;

		    move_uploaded_file($tmp_name, $dir . $name);

		    return [
		    	'name' => $name,
		    	'dir'  => $dir,
		    	'success' => true,
		    	'format'  => $format
		    ];
		}

		static private function check_file() {
			return isset($_FILES['file']) ? $_FILES['file'] : null;
		}


		//Проверяет формат
		static public function format($file, $formats = null) {
			$result = false;

			//Проверяем на соотвествующий формат
			if ($formats) {
				$result = self::type_file($file, $formats);
			}

			return $result;
		}


		//Проверка файла на соответсвующий формат
		static private function type_file($file, $formats) {
			$result = false;

			foreach ($formats as $key => $value) {
				if (isset(self::$types[$value])) {
					if ($file['type'] === self::$types[$value]) {
						$result = true;
						break;
					} 	

				}
			}

			return $result;
		}

		static private function generate_name($len = 50) {
			$symbols = ['a','b','c', 'd', 'f','g','h', 'j', 'k', 'l','m','n', 'b'];

			$result = '';
			for ($index = 0; $index < $len; $index++) {
				$result .= $symbols[mt_rand(0, 12)];
			}

			return $result;
		} 
	}
