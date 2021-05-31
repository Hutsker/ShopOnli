<?php 
	require "db/connectt.php"; 

	$data = $_POST;

	if (isset($data['paying']))
	{
		foreach ($_SESSION['basket'] as $key => $value) 
		{
			$res = R::getAll("SELECT id FROM `basket` WHERE buyer = " . $_SESSION['user'] . " AND products = ". $value)[0];
			
			R::exec("UPDATE `basket` SET `closed` = '1' WHERE `basket`.`id` = " . $res['id']);
		}
		$_SESSION['basket'] = [];
		echo "Заказ оплачен<br>";
	}

	if (count($_SESSION['basket']) > 0)
	{
		$sql = "SELECT products.id, products.name AS 'Название', products.price AS 'Цена' FROM products WHERE ";

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

		echo "<form action='' method='POST'>
	<button type='submit' name = 'paying'>Оплатить ". $_SESSION['sum']."</button>
	</form>";
	}
	else
		echo "Корзина пуста";


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

			$f = 1;
		}
		echo "<tr>";
		foreach ($value as $name => $val)
		{
			if ($name != "id")
			echo "<td>" .  $val . "</td>";
			if ($name == "Цена") $sum += $val;
		}

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