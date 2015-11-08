<?php
	@$db = mysql_connect("localhost","root","") or die("Ошибка при соединении к базе");
	@$er = mysql_select_db("bookshop") or die("Ошибка в выборе базы");
	$nextedit = 'Редактировать';
	if($_POST['submit1'])
	{
		$query = "SELECT AuthorID FROM authors WHERE FIO LIKE '{$_POST["author"]}%'";//запрос пытаеться выбрать ID Автора с заданным ФИО из табл. авторов
		trim($query);
		@$result = mysql_query($query) or die("Ошибка в выполнении запроса 2");
		$rows = mysql_num_rows($result);//получаем кол-во записей у которых ФИО совпадает с введенным через форму
		if($rows == 0)//если таких записей нет то автор новый и его нужно добавить в табл. авторов
		{
			$query = "INSERT INTO authors (FIO) VALUES('{$_POST["author"]}')";//запрос добавляет ФИО нового автора в табл.
			trim($query);
			@$result = mysql_query($query) or die("Ошибка в выполнении запроса 3");
			$query = "SELECT AuthorID FROM authors WHERE FIO='{$_POST["author"]}'";//выбирает ID только что добавленного автора из табл. авторов
			trim($query);
			@$result = mysql_query($query) or die("Ошибка в выполнении запроса 4");
		}			
		$row = mysql_fetch_array($result);//непосредсвенная выборка из базы данных ID автора
		$authorID = $row['AuthorID'];//сохранение в отдельной переменной ,чтобы row можно было опять использовать
		
		$query = "SELECT GenreID FROM genres WHERE GenreName ='{$_POST["genre"]}'";//получаем ключ жанра
		trim($query);
		@$result = mysql_query($query) or die("Ошибка в выполнении запроса 5");
		$row = mysql_fetch_array($result);
		$genreID = $row['GenreID'];//ключ жанра
		
		$query = "SELECT PublishingID FROM publishings WHERE PublishingName LIKE '%{$_POST["publishing"]}%'";//
		trim($query);
		@$result = mysql_query($query) or die("Ошибка в выполнении запроса 6");
		$rows = mysql_num_rows($result);
		if($rows == 0)
		{
			$query = "INSERT INTO publishings(PublishingName,PublishingCity,PublishingAddress) 
					VALUES('{$_POST["publishing"]}','{$_POST[city]}','{$_POST[addres]}')";
			trim($query);
			@$result = mysql_query($query) or die("Ошибка в выполнении запроса 7");
			$query = "SELECT PublishingID FROM publishings WHERE PublishingName='{$_POST["publishing"]}'";
			trim($query);
			@$result = mysql_query($query) or die("Ошибка в выполнении запроса 8");
		}
		$row = mysql_fetch_array($result); 
		$publishingID = $row['PublishingID'];
		//print_r ($_POST);
		if(empty($_POST['bookID']))//если нет записи в книгах
		{
			//echo "www".$_POST['bookID'];
			$query = "INSERT INTO Books (BookName,BookAuthor,BookGenre,BookYear,BookPages,
					  BookAbstract,BookPrice,BookNumb,BookPublishing)
			VALUES('{$_POST["bookname"]}','{$authorID}','{$genreID}','{$_POST["year"]}','{$_POST["pages"]}','{$_POST["abstract"]}',
					'{$_POST["price"]}','{$_POST["number"]}','{$publishingID}')";//записали данные книг
			trim($query);
			@$result = mysql_query($query) or die("Ошибка в выполнении запроса 10");
			
			$query = "SELECT BookID FROM books WHERE BookName ='{$_POST["bookname"]}'";
			trim($query);
			@$result = mysql_query($query) or die("Ошибка в выполнении запроса 11");
			$row = mysql_fetch_array($result);
			$bookID = $row['BookID'];
			
			$query = "INSERT INTO bookstoauthors (AuthorCode,BookCode) VALUES('$authorID','$bookID')";//запись зависемости ключей
			trim($query);
			@$result = mysql_query($query) or die("Ошибка в выполнении запроса 12");
			echo "Информация успешно добавлена !!!";
		}
		else
		{	
			$query = "UPDATE books,publishings,authors SET BookName='{$_POST["bookname"]}',BookAbstract='{$_POST["abstract"]}',BookPrice='{$_POST["price"]}',
			BookNumb='{$_POST["number"]}',BookYear='{$_POST["year"]}',BookPages='{$_POST["pages"]}',BookPublishing='$publishingID',BookGenre='$genreID',
			PublishingCity='{$_POST["city"]}',PublishingAddress='{$_POST["addres"]}',BookAuthor='$authorID',FIO='{$_POST["author"]}'
			WHERE BookID='{$_POST["bookID"]}' AND BookPublishing=PublishingID AND AuthorID=BookAuthor";
			trim($query);
			@$result = mysql_query($query) or die("Ошибка в выполнении запроса 13");
			echo "Информация успешно обновлена !!!";
		}
	}
	$rownum = 1;//номр записи из ответа Б.Д.выводимой первой при переходе в режим редоктирования
	$bnumber = 1;//кол-во книг по умолчанию
	if(($_POST['submit2']) || ($_POST['submit3']))//если зашли на страницу в режиме редоктирования(после нажатия слнд. или пред.)
	{
		$nextedit = 'Следующая';
		$query = "SELECT books.BookID,BookName,BookAbstract,BookPrice,BookNumb,BookYear,BookPages,FIO,GenreName,
		PublishingAddress,PublishingCity,PublishingName FROM books,authors,genres,publishings
		WHERE books.BookAuthor=authors.AuthorID AND books.BookGenre=genres.GenreID AND 
		books.BookPublishing=publishings.PublishingID";
		trim($query);
		@$result = mysql_query($query) or die("Ошибка в выполнении запроса 13");
		$num_rows = mysql_num_rows($result);//общие кол-во записей в ответе базы данных
		if($_POST['submit2'])//если нажата кнопка след.
			$rownum = $_POST["rownum"]+1;//то увеличить номер отображаемой записи на 1цу
		else //если нажата кнопка пред.
			$rownum = $_POST["rownum"]-1;//то уменьшить номер отображаемой записи на 1цу
		if($rownum>$num_rows)//если при увеличении получили номер больше общего числа записей
			$rownum = 0;//то переходим к первой записи
		if($rownum<0)//если при уменьшении получили номер меньше нуля
			$rownum = $num_rows;//то переходим к записи имеюшей макс. номер
		echo $rownum;
		for($i=0;$i<$rownum;$i++)//перебор в пустую первых rownum записей ,чтобы добраться до необходимой: 
		{
			$row = mysql_fetch_array($result);
		}	
	$bname = $row["BookName"];	
	$bauthor = $row["FIO"];	
	$bgenre = $row["GenreName"];	
	$byear = $row["BookYear"];	
	$bpages = $row["BookPages"];	
	$bprice = $row["BookPrice"];	
	$bnumber = $row["BookNumb"];	
	$bpulishing = $row["PublishingName"];	
	$bcity = $row["PublishingCity"];	
	$baddress = $row["PublishingAddress"];
	$babstract = $row["BookAbstract"];
	$b_id = $row["BookID"];
	}

?>
<!DOCTYPE html>
<html>
<head>
<title> Магазин книг. </title>
<meta charset="utf-8">
<link href="style.css" type="text/css" rel="stylesheet">
</head>
	<body>
	<h2>Заполняем Базу Данных :</h2>
	 <form action = 'admin.php' method = 'post'>
		<span class='user'><label for = 'names'>Введите Название </label></span>
		<input type = 'text' name = 'bookname' id = 'names' autofocus value = '<?=$bname?>' >
		<br /><br />
		
		<span class='user'><label for = 'authors'>Введите Автора </label></span>
		<input type = 'text' name = 'author' id = 'authors' value = '<?=$bauthor?>' >
		<br /><br />
		
		<span class='user'>Введите жанр </span>
		<select name = 'genre' onfocus='document.all.rad2.checked=true;' >

			<?php
			$query = "SELECT * FROM genres";
			trim($query);
			@$result = mysql_query($query) or die("Ошибка в выполнении запроса 1");
			$num_rows = mysql_num_rows($result);
			for($i = 0;$i<$num_rows;$i++)
			{
				$row = mysql_fetch_array($result);
				echo '<option';
				if($row["GenreName"]==$bgenre)
					echo ' selected';
				echo '>'.$row["GenreName"].'</option>';
			}	
			?>
			
		</select>
		<br /><br />
		
		<span class='user'><label for = 'years'>Введите год </label></span>
		<input type = 'number' name = 'year' id = 'years' value = '<?=$byear?>' >
		<br /><br />
		
		<span class='user'><label for = 'pagess'>Введите страницы </label></span>
		<input type = 'number' name = 'pages' id = 'pagess' value = '<?=$bpages?>' >
		<br /><br />
		
		<span class='user'><label for = 'prices'>Введите цену </label></span>
		<input type = 'number' name = 'price' id = 'prices' value = '<?=$bprice?>' >
		<br /><br />
		
		<span class='user'><label for = 'numbers'>Введите количество </label></span>
		<input type = 'number' name = 'number' id = 'numbers' value = '<?=$bnumber?>' >
		<br /><br />
		
		<span class='user'><label for = 'publishings'>Введите издательство </label></span>
		<input type = 'text' name = 'publishing' id = 'publishings' value = '<?=$bpulishing?>' >
		<br /><br />
		
		<span class='user'><label for = 'citys'>Введите город </label></span>
		<input type = 'text' name = 'city' id = 'citys' value = '<?=$bcity?>' >
		<br /><br />
		
		<span class='user'><label for = 'address'>Введите адресс </label></span>
		<input type = 'text' name = 'addres' id = 'address' value = '<?=$baddress?>' >
		<br /><br />
		
		<textarea rows='7' cols='45' name = 'abstract' placeholder = 'Введите аннотацию'><?=$babstract?></textarea><br /><br />
		<input type = 'submit' name = 'submit1' value = 'Сохранить' >
		<input type = 'hidden' name = 'rownum' value = '<?=$rownum?>' >
		<input type = 'hidden' name = 'bookID' value = '<?=$b_id?>' >
		<input type = 'submit' name = 'submit3' value = 'Назад' <?php if((!$_POST['submit2']) && (!$_POST['submit3'])) echo " style = 'display: none'";?> >
		<input type = 'submit' name = 'submit2' value = '<?=$nextedit?>' >
		<br /><br />
	 </form>
	</body>
</html>
