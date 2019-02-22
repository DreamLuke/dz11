<?php
	// Работа с файлами
	file_put_contents('./test.txt', 'Привет, мир!' . PHP_EOL);
	$file = file_get_contents('./test.txt');

	echo nl2br($file);

	rename('./test.txt', './mir.txt');
	copy('./mir.txt', './world.txt');

	$sizeByte = filesize('./world.txt');
	echo 'Размер файла в байтах: ' . $sizeByte . '<br>';
	echo 'Размер файла в мегабайтах: ' . ($sizeByte/1024) . '<br>';
	echo 'Размер файла в гигабайтах: ' . ($sizeByte/(1024*1024)) . '<br>';

	unlink('./world.txt');

	var_dump(file_exists('./world.txt'));
	var_dump(file_exists('./mir.txt'));

	// Работа с папками, mkdir, rmdir
	if(!file_exists('./test')) {
		mkdir('./test');
		rename('./test', './www');
		rmdir('./www');
	}

	if(!file_exists('./test')) {
		mkdir('./test');
	}
	$strArr = [
		'Папка номер 1',
		'Папка номер 2',
		'Папка номер 3'
	];
	for($i = 0; $i < count($strArr); $i++) {
		if(!file_exists('./test' . '/' . $strArr[$i])) {
			mkdir('./test' . '/' . $strArr[$i]);
		}
	}
	echo '<br><br>';

	// На scandir, is_dir, is_file, PHP_EOL
	function getDirsFiles(string $location)
	{
		$dir = scandir($location);
		for($i = 0; $i < count($dir); $i++) {
			if($dir[$i] != '.' && $dir[$i] != '..') {
				echo $dir[$i] . '<br>';
			}

			if(is_dir($location . '/' . $dir[$i]) && $dir[$i] != '.' && $dir[$i] != '..') {
				getDirsFiles($location . '/' .$dir[$i]);
			}
		}
	}
	getDirsFiles('./test');
	echo '<br>';

	function getFiles(string $location)
	{
		$dir = scandir($location);
		for($i = 0; $i < count($dir); $i++) {
			if($dir[$i] != '.' && $dir[$i] != '..' && is_file($location . '/' . $dir[$i])) {
				echo $dir[$i] . '<br>';
				// echo $location . '/' . $dir[$i] . '<br>';
			}

			if(is_dir($location . '/' . $dir[$i]) && $dir[$i] != '.' && $dir[$i] != '..') {
				getFiles($location . '/' .$dir[$i]);
			}
		}
	}
	getFiles('./test');
	echo '<br>';

	function getFilesContent(string $location)
	{
		$dir = scandir($location);
		for($i = 0; $i < count($dir); $i++) {
			if($dir[$i] != '.' && $dir[$i] != '..' && is_file($location . '/' . $dir[$i])) {
				echo 'Содержимое файла ' . $dir[$i] . ':' . '<br>';
				echo nl2br(file_get_contents($location . '/' . $dir[$i]));
				echo '<br><br>';
			}

		}
	}
	getFilesContent('./test');
	echo '<br>';

	function getFilesExtension(string $location)
	{
		$dir = scandir($location);
		for($i = 0; $i < count($dir); $i++) {
			$info = new SplFileInfo($location . '/' . $dir[$i]);
			if($dir[$i] != '.' && $dir[$i] != '..' && is_file($location . '/' . $dir[$i]) && $info->getExtension() === 'txt') {
				echo $dir[$i] . '<br>';
			}

			if(is_dir($location . '/' . $dir[$i]) && $dir[$i] != '.' && $dir[$i] != '..') {
				getFilesExtension($location . '/' .$dir[$i]);
			}
		}
	}
	getFilesExtension('./test');
	echo '<br>';

	function addToFiles(string $location)
	{
		$dir = scandir($location);
		for($i = 0; $i < count($dir); $i++) {
			$info = new SplFileInfo($location . '/' . $dir[$i]);
			if($dir[$i] != '.' && $dir[$i] != '..' && is_file($location . '/' . $dir[$i])) {
				$addString = $location . '/' . $dir[$i] . PHP_EOL;
				$addString .= file_get_contents($location . '/' . $dir[$i]);
				file_put_contents($location . '/' . $dir[$i], $addString);
				// echo $dir[$i] . '<br>';
			}
		}
	}
	// addToFiles('./test');
	echo '<br>';

	function getDirs(string $location)
	{
		$dir = scandir($location);
		for($i = 0; $i < count($dir); $i++) {
			if($dir[$i] != '.' && $dir[$i] != '..' && is_dir($location . '/' . $dir[$i])) {
				echo $dir[$i] . '<br>';
			}

			if(is_dir($location . '/' . $dir[$i]) && $dir[$i] != '.' && $dir[$i] != '..') {
				getDirs($location . '/' .$dir[$i]);
			}
		}
	}
	getDirs('./test');
	echo '<br>';

	function getSubFilesContent(string $location)
	{
		$dir = scandir($location);
		for($i = 0; $i < count($dir); $i++) {
			if($dir[$i] != '.' && $dir[$i] != '..' && is_file($location . '/' . $dir[$i])) {
				echo 'Содержимое файла ' . $dir[$i] . ':' . '<br>';
				echo nl2br(file_get_contents($location . '/' . $dir[$i]));
				echo '<br><br>';
			}

			if(is_dir($location . '/' . $dir[$i]) && $dir[$i] != '.' && $dir[$i] != '..') {
				getSubFilesContent($location . '/' .$dir[$i]);
			}
		}
	}
	getSubFilesContent('./test');
	echo '<br>';

	function addToSubFiles(string $location)
	{
		$dir = scandir($location);
		for($i = 0; $i < count($dir); $i++) {
			$info = new SplFileInfo($location . '/' . $dir[$i]);
			if($dir[$i] != '.' && $dir[$i] != '..' && is_file($location . '/' . $dir[$i])) {
				$addString = $location . '/' . $dir[$i] . PHP_EOL;
				$addString .= file_get_contents($location . '/' . $dir[$i]);
				file_put_contents($location . '/' . $dir[$i], $addString);
				// echo $dir[$i] . '<br>';
			}

			if(is_dir($location . '/' . $dir[$i]) && $dir[$i] != '.' && $dir[$i] != '..') {
				addToSubFiles($location . '/' .$dir[$i]);
			}
		}
	}
	// addToSubFiles('./test');
	echo '<br>';

	// Задачи
	function removeBySize(string $location, int $size = 1024)
	{
		$dir = scandir($location);
		for($i = 0; $i < count($dir); $i++) {
			$path = $location . '/' . $dir[$i];

			if($dir[$i] != '.' && $dir[$i] != '..' && is_file($path)) {
				if(filesize($path) > $size) {
					unlink($path);
				}
			}

			if(is_dir($path) && $dir[$i] != '.' && $dir[$i] != '..') {
				removeBySize($path);
			}
		}
	}
	removeBySize('./test');
	echo '<br>';

	function getDirSize(string $location)
	{
		$dir = scandir($location);
		$size = 0;
		for($i = 0; $i < count($dir); $i++) {
			$path = $location . '/' . $dir[$i];

			if($dir[$i] != '.' && $dir[$i] != '..' && is_file($path)) {
				$size += filesize($path);
			}

			/*if(is_dir($path) && $dir[$i] != '.' && $dir[$i] != '..') {
				getDirSize($path);
			}*/
		}

		return $size;
	}
	echo 'Размер папки в байтах: ' . getDirSize('./test');
	echo '<br><br>';

	function getSubDirsSize(string $location)
	{
		$dir = scandir($location);
		$size = 0;
		for($i = 0; $i < count($dir); $i++) {
			$path = $location . '/' . $dir[$i];
			if(is_dir($path)) {
				echo 'Размер папки ' . $path . ' ' . getDirSize($path) . ' байт' . '<br>';
			}

			if(is_dir($path) && $dir[$i] != '.' && $dir[$i] != '..') {
				getSubDirsSize($path);
			}
		}

		return $size;
	}

	getSubDirsSize('./test');
	echo '<br><br>';















