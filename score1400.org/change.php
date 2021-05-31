<?php
	require "db/connectt.php"; 

	$data = $_POST;

	if (isset($data['save']))
	{

		if (!$data['house']) $data['house'] = "NULL";
		if (!$data['flat']) $data['flat'] = "NULL";
	/*	
		echo "UPDATE `buyer` SET 
			`surname` = '". $data['surname']. "',
			name = '". $data['name']. "',
			`patronymic` = '". $data['patr']. "', 
			city =  '". $data['city']. "',
			street =  '". $data['street']. "',
			house = ". $data['house']. ",
			flat =  ". $data['flat']. ",
			phone =  '". $data['phone']. "',
			WHERE `buyer`.`id` = ". $_SESSION['user'];*/

		R::exec("UPDATE `buyer` SET 
			`surname` = '". $data['surname']. "',
			name = '". $data['name']. "',
			`patronymic` = '". $data['patr']. "', 
			city =  '". $data['city']. "',
			street =  '". $data['street']. "',
			house = ". $data['house']. ",
			flat = ". $data['flat']. ",
			phone =  '". $data['phone']. "'
			WHERE `buyer`.`id` = ". $_SESSION['user']);

 		 		header('location: /lk.php');
		
	}

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

		echo '<form action="" method="POST">
		<p>Изменение информации о себе</p>
	<p>ФИО должно состоять из русских букв, начинаться с заглавной, не содержать пробелов и чисел</p>
	<p>
		<p><strong>Фамилия</strong> </p>
		<input type="text" name="surname" required pattern = "[А-Я]+([а-я]{1,24})" placeholder="Иванов"
		value = '. $res['surname']. '>
	</p>
	<p> 	
		<p> <strong>Имя</strong> </p>
		<input type="text" name="name" required pattern = "[А-Я]+([а-я]{1,24})"  placeholder="Иван" value = '. $res['name']. '>
	</p>
	<p> 
		<p> <strong>Отчество</strong> </p>
		<input type="text" name="patr" pattern = "[А-Я]+([а-я]{1,24})"  placeholder="Иванович"
		value = '. $res['patronymic']. '>
	</p>
	<p> 
	<p> <strong>Город</strong> </p>
		<input type="text" name="city" placeholder="Иваново" 
		value = '. $res['city']. '>
	</p>
		<p> <strong>Улица</strong> </p>
		<input type="text" name="street" placeholder="Ленина" 
		value = '. $res['street']. '>
	</p>
		<p> <strong>Дом</strong> </p>
		<input type="number" name="house" placeholder="20" 
		value = '. $res['house']. '>
	</p>
	<p> <strong>Квартира</strong> </p>
		<input type="number" name="flat" placeholder="11" 
		value = '. $res['flat']. '>
	</p>
	<p> <strong>Телефон</strong> </p>
    <p><input type="tel" name = "phone" pattern="[0-9]{11}" placeholder="7(123)456-78-90"    
		value = '. $res['phone']. '></p>
    <button type="submit" name = "save">Сохранить</button></form>
    ';
	}

?>

<form action='index.php' method='POST'>
	<button type='submit' name = 'back'>Вернуться</button>
</form>