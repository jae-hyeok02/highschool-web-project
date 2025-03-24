<?php 

	/**
	 * 
	 */
	class DB
	{
		static $pdo = false;

		public static function mq($s, $q = [])
		{
			if (!self::$pdo) {
				self::$pdo = new PDO("mysql:host=localhost; charset=utf8; dbname=busanmovie;", "root", "", [
					19 => 2, 3 => 2
				]);
			}

			$s = self::$pdo->prepare($s);
			$s->execute(arr($q));

			return $s;
		}

		public static function all($o = '')
		{
			$table = get_called_class();
			return self::mq("SELECT * FROM $table $o")->fetchAll();
		}

		public static function get($id)
		{
			$table = get_called_class();
			return self::mq("SELECT * FROM $table WHERE id = ?", $id)->fetch();
		}

		public static function find($c, $d)
		{
			$table = get_called_class();
			return self::mq("SELECT * FROM $table WHERE $c", $d)->fetch();
		}

		public static function findAll($c, $d)
		{
			$table = get_called_class();
			return self::mq("SELECT * FROM $table WHERE $c", $d)->fetchAll();
		}

		public static function insert($d)
		{
			$table = get_called_class();
			$sql = implode(" = ?, ", array_keys($d))." = ?";
			self::mq("INSERT INTO $table SET $sql", array_values($d));
			return self::$pdo->lastInsertId();
		}

		public static function update($id, $d)
		{
			$table = get_called_class();
			$sql = implode(" = ?, ", array_keys($d))." = ?";
			self::mq("UPDATE $table SET $sql WHERE idx = ?", array_merge(array_values($d), [$id]));
		}

		public static function delete($id)
		{
			$table = get_called_class();
			self::mq("DELETE FROM $table WHERE idx = ?", [$id]);
		}

	}


	class member extends DB {};
	class cinema extends DB {};
	class sponsor extends DB {};
	class movtime extends DB {};
	class moviebuy extends DB {};
	class requestmov extends DB {};
	class officialmov extends DB {};