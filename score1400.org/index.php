<?php 
	require "db/connectt.php"; 

	if (!isset($_SESSION['user']))
	{
		$_SESSION['user'] = 0;	
		$_SESSION['basket'] = [];	
	}

	$data = $_POST;

	print_search();
	print_categories();

	if ($_SESSION['user'] != 0)
	{
		$res = R::getAll("SELECT buyer.surname, buyer.name, buyer.patronymic FROM `buyer` WHERE buyer.id = ". $_SESSION['user'])[0];
		echo "<div>Вы вошли как ". $res['surname'] ." ". $res['name'] ." ". $res['patronymic']. "<div>";
	}

	if (isset($data['choice']))
	{
		if (!in_array($data['choice'], $_SESSION['basket']))
		{
			array_push($_SESSION['basket'], $data['choice']);
			if ($_SESSION['user'] != 0)
				R::exec("INSERT INTO `basket` (`id`, `buyer`, `products`, closed) VALUES (NULL, '". $_SESSION['user']. "', '".$data['choice']."', 0);");

			echo "Товар добавлен";
		}else echo "Товар уже есть в корзине ";
	}

	if (isset($data['apply_filter']))
	{
		echo "Результат по запросу '" . $data['filter'] . "' <form action='' method='POST'>
	<input type='submit' name='reset' value = 'Сбросить'>";
		print_table(R::getAll("SELECT products.id, products.name AS 'Название', products.category AS 'Категория', products.description AS 'Описание', products.price AS 'Цена' FROM products WHERE LOCATE('". $data['filter']."', products.name) != 0"));
	}
	else 
	if (isset($data['apply_category']))
	{
		echo "Выбрана категория '" . $data['category'] . "' <form action='' method='POST'>
	<input type='submit' name='reset' value = 'Сбросить'>";
		
		print_table(R::getAll("SELECT products.id, products.name AS 'Название', products.category AS 'Категория', products.description AS 'Описание', products.price AS 'Цена' FROM products WHERE category = '". $data['category'] . "'"));
	}else 
		print_table(R::getAll("SELECT products.id, products.name AS 'Название', products.category AS 'Категория', products.description AS 'Описание', products.price AS 'Цена' FROM products"));

?>



<?php

function print_table($table)
{
	$f = 0;

	if (count($table) > 0 )
	{	
	$style = "<style>
        	table 
        	{
            	border: solid 1px; 
            	border-collapse: collapse;
        	}	
        	TD, TH {
			    padding: 3px; 
   				border: 1px solid black; 
   			}	
    		</style>";

		echo "
	<div class = 'fortable'> 
	<form action='' method='POST'>
	<table>" . $style;


	foreach ($table as $key => $value) 
	{
		if ($f==0) 
		{
			echo "<tr>";
			foreach ($value as $name => $val)
				if ($name != "id")
					echo "<td>" .  $name . "</td>";

			echo "</tr>";
			$f = 1;
		}
		echo "<tr>";
		foreach ($value as $name => $val)
		{
			if ($name != "id")
			echo "<td>" .  $val . "</td>";
		}

		echo "<td><button type='submit' name = 'choice' value='" . $value['id'] . "'>Купить</button></td>"; 

		echo "</tr>";
	}
	echo "</table></form></div>";
}
else echo "Данных нет";
}

function print_search()
{
	echo "<div class = 'search'><form action='' method='POST'>
	<input type='text' name='filter' required>
	<input type='submit' name='apply_filter' value = 'Поиск' ></form></div>";
}
	

function print_categories()
{
	$res = R::getAll("SELECT DISTINCT products.category FROM products");
	echo "<div><form action='' method='POST'><select name='category'>";
	$f = 0;
	foreach ($res as $key => $value) 
	{
		if ($f == 0){
			echo "<option selected value=". $value['category']. ">" .$value['category'] ."</option>";
			$f = 1;
		}
		else echo "<option value=". $value['category']. ">" .$value['category'] ."</option>";
	}
	echo "</select><input type='submit' name='apply_category' value = 'Выбрать категорию'></form></div>";
}

?>


<div>
	<style>
		div{
			overflow: auto;	
			margin: 5px;
		}
		.search
		{
			height: 30px;
		}
		.fortable{
			height: 450px;
		}
	</style>
	<form action="basket.php" method="POST">
		<button type='submit' name = 'add'>Корзина</button>
	</form>
	<form action="sing_in.php" method="POST">
		<button type='submit' name = 'add'>Регистрация</button>
	</form>
	<?php 
	if ($_SESSION['user'] == 0) 
	echo " 
	<form action='log_in.php' method='POST'>
		<button type='submit' name = 'add'>Вход</button>
	</form>";
	else 	{

		echo " 
		<form action='lk.php' method='POST'>
			<button type='submit' name = 'lk'>Личный кабинет</button>
		</form>";
		echo " 
		<form action='log_out.php' method='POST'>
			<button type='submit' name = 'add'>Выйти</button>
		</form>";
	}
	?>
</div>
