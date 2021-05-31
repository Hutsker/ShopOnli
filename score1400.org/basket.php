<?php 
	require "db/connectt.php"; 

	$data = $_POST;

	if (isset($data['delete']))
	{
		if ($_SESSION['user'] != 0)
		{
			R::exec("DELETE FROM `basket` WHERE buyer = ". $_SESSION['user'] . " AND products = ". $data['delete']);
		}
		unset($_SESSION['basket'][array_search($data['delete'], $_SESSION['basket'])]);
		echo "Товар удалён<br>";
	}

	if (count($_SESSION['basket']) > 0)
	{
		$sql = "SELECT products.id, products.name AS 'Название', products.category AS 'Категория', products.description AS 'Описание', products.price AS 'Цена' FROM products WHERE ";

		$f = 0;
		foreach ($_SESSION['basket'] as $key => $value) {
			if ($f == 0)
			{
				$sql = $sql . " products.id = " . $value;
				$f = 1;
			}
			else		$sql = $sql . " OR products.id = " . $value;
		}

		echo "Состав корзины";
		print_table(R::getAll($sql));

		if ($_SESSION['user'] > 0)
		{
			echo "<form action='pay.php' method='POST'>
			<button type='submit' name = 'pay'>К оплате ". $_SESSION['sum']."</button>
			</form>";
		}else 
		{
			echo "<form action='sign_in.php' method='POST'>
			<button type='submit' name = 'pay'>К оплате ". $_SESSION['sum']."</button>
			</form>";
		}


	}
	else echo "Корзина пуста";

	echo "<form action='index.php' method='POST'>
	<button type='submit' name = 'back'>Вернуться</button>
	</form>";
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

	$sum = 0;
	foreach ($table as $key => $value) 
	{
		if ($f==0) 
		{
			echo "<tr>";
			foreach ($value as $name => $val)
				if ($name != "id")
					echo "<td>" .  $name . "</td>";

			//echo "<td>Количество</td></tr>";
			$f = 1;
		}
		echo "<tr>";
		foreach ($value as $name => $val)
		{
			if ($name != "id")
			echo "<td>" .  $val . "</td>";
			if ($name == "Цена") $sum += $val;
		}

		//echo "<td><input type='number' name = 'count". $value['id']."' value='1' min = 1 max = 10000></button></td>"; 
		echo "<td><button type='submit' name = 'delete' value='" . $value['id'] . "'>Удалить</button>
		<br>
	</td>"; 

		echo "</tr>";
	}
	echo "</table><br>
	</form></div>";
	$_SESSION['sum'] = $sum; 
}
else echo "Корзина пуста";
}
?>