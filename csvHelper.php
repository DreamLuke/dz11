<?php

class csvHelper
{
	// разбор данных из csv в массив
	public function csvToArray(string $path)
	{
		$fp = fopen($path, 'r');
		$arr = [];

		while (($data = fgetcsv($fp)) !== FALSE) {
			$arr[] = $data;
		}
		return $arr;
	}

	// превращение данных из массива в csv
	public function arrayToCSV(array $csvArray, string $path = 'file.csv', string $delimiter = ',')
	{
		$fp = fopen($path, 'w');
		foreach ($csvArray as $line) {
    		fputcsv($fp, $line, $delimiter);
		}
		fclose($fp);
	}

	// запись данных в базу данных
	public function writeToDB(string $path, string $table = 'users', string $db = 'users', string $user = 'root', string $pass = '')
	{
		$host = 'localhost';
		// $db = 'users';
		// $user = 'root';
		// $pass = '';
		$charset = 'utf8';
		$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		$opt = [
		    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		    PDO::ATTR_EMULATE_PREPARES => false,
		];
		$pdo = new PDO($dsn, $user, $pass, $opt);

		$fp = fopen($path, 'r');

		while (($data = fgetcsv($fp)) !== FALSE) {
		    $sql = 'SELECT * FROM ' . $table . ' WHERE id = :id';
		    $rows = $pdo->prepare($sql);
		    $rows->execute(['id' => $data[0]]);

		    $row = $rows->fetch();

		    if($row) {
		        $sql = 'UPDATE ' . $table . ' SET name = :name, sername = :sername, email = :email, password = :password, role = :role WHERE id = :id';
		        $rows = $pdo->prepare($sql);
		        $rows->execute(['name' => $data[1], 'sername' => $data[2], 'email' => $data[3], 'password' => $data[4], 'role' => $data[5], 'id' => $data[0]]);
		    } else {
		        $sql = 'INSERT INTO ' . $table . ' (id, name, sername, email, password, role) VALUES (:id, :name, :sername, :email, :password, :role)';
		        $rows = $pdo->prepare($sql);
		        $rows->execute(['id' => $data[0], 'name' => $data[1], 'sername' => $data[2], 'email' => $data[3], 'password' => $data[4], 'role' => $data[5]]);
		    }
		}
		fclose($fp);
	}

	// выгрузка данных из бд в csv файл
	public function fromDBtoCSV($path = 'fileDB.csv', string $delimiter = ',', string $table = 'users', string $db = 'users', string $user = 'root', string $pass = '')
	{
		$host = 'localhost';
		// $db = 'users';
		// $user = 'root';
		// $pass = '';
		$charset = 'utf8';
		$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		$opt = [
		    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		    PDO::ATTR_EMULATE_PREPARES => false,
		];
		$pdo = new PDO($dsn, $user, $pass, $opt);

		$sql = 'SELECT * FROM ' . $table;
		$rows = $pdo->query($sql);


		$fp = fopen($path, 'w');

		while ($row = $rows->fetch()) {
			$line = $row['id'] . $delimiter . $row['name'] . $delimiter . $row['sername'] . $delimiter . $row['email'] . $delimiter . $row['password'] . $delimiter . $row['role'] . PHP_EOL;
		    fwrite($fp, $line);
		}

		fclose($fp);
	}
}

$csvHelper = new csvHelper();

$arrCSV = $csvHelper->csvToArray('./users.csv');
$csvHelper->arrayToCSV($arrCSV, 'file.csv');

$csvHelper->fromDBtoCSV();





