<?php

/**
*	
*	Класс для работы с базами данных
*	
**/

class db {

	public static $con;																																			// Ссылка на подключение

	public static function init() {
		return new self();
	}
	
/**
*	
*	Класс для работы с базами данных
*	
**/
	private function db() {
	
		global $GAMINAS;
		
		$host = 'localhost';
		$user = 'srv44030_gaminas';
		$pw = '230105';
		$base = 'srv44030_gaminas';
		
// Подключаемся к базе, устанавливаем чарсет, ловим ошибки и формируем бэктрейс

		$link = mysqli_connect($host, $user, $pw, $base);
		
		if (!$link) {
			printf("<h2>Невозможно подключиться к базе данных.</h2> Код ошибки: %s\n", mysqli_connect_error());
			exit;
		} else self::$con = $link;
		
		if (!mysqli_set_charset($link, "utf8")) {
			$GAMINAS['backtrace'][] = "Error loading character set utf8: " . mysqli_error($link);
		} else {
			$GAMINAS['backtrace'][] = "Current character set: " . mysqli_character_set_name($link);
		}
	}
	
	public static function query($query) {
		$query_result = mysqli_query(self::$con, $query);
		fb(gettype($query_result));
		if (gettype($query_result) !== 'boolean') $res = mysqli_fetch_all($query_result);
		else $res = ($query_result === FALSE) ? 'FALSE: ' . mysqli_error(self::$con) : $query_result;
		fb($res);
		if (mysqli_error(self::$con) != '') return mysqli_error(self::$con);
		return $res;
	}
	
}

?>