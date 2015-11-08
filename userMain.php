<!DOCTYPE html>
<html>
<head>
<title> Магазин книг. </title>
<meta charset="utf-8">
<link href="style.css" type="text/css" rel="stylesheet">
</head>
	<body>
		<?php  
		@$db = mysql_connect("localhost","root","123456") or die("Ошибка при соединении к базе");
		@$er = mysql_select_db("bookshop") or die("Ошибка в выборе базы");
                mysql_query("SET NAMES utf8");
		$query = "SELECT * FROM genres";
		trim($query);
		@$result = mysql_query($query) or die("Ошибка в выполнении запроса 1");
		?>
	<h2>Выбераем книгу</h2>
	<form action = 'userMain.php' method = 'post'>
	<span class = 'user'>
	<input type = 'radio' name = 'searchtype' value = '1' id = 'rad1' >По автору:
	<input type = 'text' name = 'author' onfocus = 'document.all.rad1.checked=true;'><br /><br />
	<input type = 'radio' name = 'searchtype' value = '2' id = 'rad2' checked >По жанру:
	<select name = 'genre' onfocus = 'document.all.rad2.checked=true;'>
		
		<?php
		$num_rows = mysql_num_rows($result);
		for($i = 0;$i<$num_rows;$i++)
		{
			$row = mysql_fetch_array($result);
			echo '<option>'.$row["GenreName"].'</option>';
		}
		?>
		
	</select><br /><br /><br />
	</span><br />
	<input type = 'submit' name = 'submit1' >
	</form>
		<?php
		if($_POST["submit1"])
		{
			if($_POST["searchtype"]==1)
			{
				echo"<br />Ищем по автору :";
				$author1 = strip_tags(trim($_POST["author"]));
				echo $author1;
				$query = "SELECT BookID,BookName,BookAbstract,BookPrice,BookNumb FROM books WHERE BookID IN
						(SELECT BookCode FROM booksToAuthors WHERE AuthorCode IN
						(SELECT AuthorID FROM authors WHERE FIO LIKE '{$author1}%'))";
			}
			
			if($_POST["searchtype"]==2)
			{
				echo"<br />Ищем по жанру : ";
				$genre1 =strip_tags(trim($_POST["genre"]));
				echo $genre1;
				$query = "SELECT BookID,BookName,BookAbstract,BookPrice,BookNumb FROM books WHERE BookGenre
				IN (SELECT GenreID FROM genres WHERE GenreName ='{$genre1}')";
			}
				trim($query);
				@$result = mysql_query($query) or die("Ошибка в выполнении запроса 2");
				$num_rows = mysql_num_rows($result);
				if($num_rows<1)
				{
					echo "<br /><h2>Книга не найдена!</h2>";
				}
				else
				{
					echo "<table border = 1>";
					for($i = 0;$i<$num_rows;$i++)
					{
						$row = mysql_fetch_array($result);
						echo "<tr><td><a href = 'detail.php?n={$row['BookID']}'>".$row['BookName']."</a></td>
						<td>".$row['BookAbstract']."</td>
						<td>Цена: ".$row['BookPrice']."</td>
						<td>Наличие: ".$row['BookNumb']."</td></tr>";
					}	
					echo "</table>";
				}
		
		}
		?>
	</body>
</html>
