<?php

	incl::package('files');

	class indexController extends controller {

		// Главная страница	
		 public function home () {
			$this -> template('site/views/index');
		}

		// Главная страница	 2
		 public function index2 () {
			$this -> template('site/views/index2');
		}

		// Страница материалы	
		 public function materials () {
			$this -> template('site/views/material');
		}

		// Страница преимущества	
		 public function advantages () {
			$this -> template('site/views/advantages');
		}

		// Страница blum	
		 public function blum () {
			$this -> template('site/views/blum');
		}	

		// Страница калькулятор	
		 public function calc () {
			$this -> template('site/views/calc');
		}	

		// Страница отзывы
		 public function comments () {
			$this -> template('site/views/comments');
		}	

		// Страница о компании
		 public function company () {
			$this -> template('site/views/company');
		}		

		// Страница контакты
		 public function form () {
			$this -> template('site/views/form');
		}		

		// Страница акции
		 public function podarok () {
			$this -> template('site/views/podarok');
		}

		// Страница портфлио
		 public function work () {
			$this -> template('site/views/work');
		}

		public function upload () {
			echo json_encode(file::load('IMG'));
		}																			
	}


