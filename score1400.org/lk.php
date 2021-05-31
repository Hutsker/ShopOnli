<?php
	require "db/connectt.php"; 

	$data = $_POST;

	if ($_SESSION['user'] == 0)
	{
		echo "Вы не вошли в аккаунт
		<form action='log_in.php' method='POST'>
		<button type='submit' name = 'back'>Вход</button>
		</form>";
		echo "
		<form action='sing_in.php' method='POST'>
		<button type='submit' name = 'back'>Регистрация</button>
		</form>";
	}
	else 
	{
		$res = R::getAll("SELECT buyer.surname, buyer.name, buyer.patronymic,  buyer.city,  buyer.street,  buyer.house,  buyer.flat,  buyer.phone FROM `buyer` WHERE buyer.id = ". $_SESSION['user'])[0];
		echo "<div>Вы вошли как ". $res['surname'] ." ". $res['name'] ." ". $res['patronymic']. "<div>";

		$address = "Ваш адрес: ";
		if ($res['city'] != '') $address = $address . $res['city'];
		if ($res['street'] != '') $address = $address ." ул.". $res['street'];
		if ($res['house']) $address = $address  ." дом №". $res['house'];
		if ($res['flat'] != '') $address = $address   ." кв. №". $res['flat'];
		if ($address != "Ваш адрес: ") echo $address . "<br>";

		if ($res['phone'] != '') echo "Ваш телефон: " . $res['phone'];

		echo "
		<form action='change.php' method='POST'>
		<button type='submit' name = 'back'>Изменить информацию о себе</button>
		</form>";
	}

?>

<form action='index.php' method='POST'>
	<button type='submit' name = 'back'>Вернуться</button>
</form>