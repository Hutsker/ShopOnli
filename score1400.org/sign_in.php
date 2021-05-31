<?php 
	require "db/connectt.php";
	$data = $_POST;

	$_SESSION['pay'] = 0;
	if (isset($data['pay']))
	{
		echo "Для покупки необходима регистрация<br>";
		$_SESSION['pay'] = 1;
	}

 	if (isset($data['reg']))
	{
		$eggor = array();
		
		if (R::count('client', "login = ?", array($data['login'])) >0)
			$eggor[] = "Такой пользователь уже существует";
		
		if ($data['passwd'] != $data['passwd2'])
			{
			$eggor[] = "Пароли не совпадают";
			}	

		if (empty($eggor))	
		{
			if (!$data['house']) $data['house'] = "NULL";
			if (!$data['flat']) $data['flat'] = "NULL";
			
			R::exec("INSERT INTO `buyer` (`id`, `surname`, `name`, `patronymic`, `city`, `street`, `house`, `flat`, `phone`, `login`, `password`) 
				VALUES (NULL, 
			'" . $data['surname'] . "', 
			'" . $data['name']. "', 
			'" . $data['patr'] . "', 
			'" . $data['city'] . "', 
			'" . $data['street'] . "', 
			" . $data['house'] . ", 
			" . $data['flat'] . ", 
			'" . $data['phone'] . "', 
			'" . $data['login'] . "', 
			'" . password_hash($data['passwd'], PASSWORD_DEFAULT) . "')");
			
			$res = R::getAll("SELECT MAX(id) AS 'max' FROM `buyer`")[0]['max'];

			$_SESSION['user'] = $res;

			if ($_SESSION['pay']  == 0)
 		 		header('location: /index.php');
 		 	else 
 		 	{
 		 		foreach ($_SESSION['basket'] as $key => $value) {
 		 			R::exec("INSERT INTO `basket` (`id`, `buyer`, `products`) VALUES (NULL, '". $_SESSION['user']. "', '".$value."');");
 		 		}
 		 		header('location: /pay.php');
 		 	}
			//echo "<div>Пользователь успешно зарегистрирован<div>";
		}
		else 
		foreach ($eggor as $key => $value) {
			echo $value . "</br>";
		}
	}

 ?>

<title>Регистрация</title>
<form action="sign_in.php" method="POST">
	<p>ФИО должно состоять из русских букв, начинаться с заглавной, не содержать пробелов и чисел</p>
	<p>
		<p><strong>Фамилия</strong> </p>
		<input type="text" name="surname" required pattern = "[А-Я]+([а-я]{1,24})" placeholder="Иванов" value="<?php echo @$data['surname']; ?>">
	</p>
	<p> 	
		<p> <strong>Имя</strong> </p>
		<input type="text" name="name" required pattern = "[А-Я]+([а-я]{1,24})"  placeholder="Иван" value="<?php echo @$data['name']; ?>">
	</p>
	<p> 
		<p> <strong>Отчество</strong> </p>
		<input type="text" name="patr" pattern = "[А-Я]+([а-я]{1,24})"  placeholder="Иванович" value="<?php echo @$data['patr']; ?>">
	</p>
	<p> 
	<p> <strong>Город</strong> </p>
		<input type="text" name="city" placeholder="Иваново" value="<?php echo @$data['city']; ?>">
	</p>
		<p> <strong>Улица</strong> </p>
		<input type="text" name="street" placeholder="Ленина" value="<?php echo @$data['street']; ?>">
	</p>
		<p> <strong>Дом</strong> </p>
		<input type="number" name="house" placeholder="20" value="<?php echo @$data['house']; ?>">
	</p>
	<p> <strong>Квартира</strong> </p>
		<input type="number" name="flat" placeholder="11" value="<?php echo @$data['flat']; ?>">
	</p>

	<p> <strong>Телефон</strong> </p>
    <p><input type="tel" name = "phone" pattern="[0-9]{11}" placeholder="7(123)456-78-90"></p>
	<p>
		<p> <strong>Логин (английские буквы и цифры, не менее 6)</strong> </p>
		<input type="text" name="login" required pattern = "[A-Za-z0-9]{6,}" value="<?php echo @$data['login']; ?>">
	</p>

	<p>
		<p> <strong>Пароль(английские буквы и цифры, не менее 8)</strong> </p>
		<input type="password" name="passwd" required pattern = "[A-Za-z0-9]{8,}" value="<?php echo @$data['passwd']; ?>">
	</p>
	<p>
		<p> <strong>Повтор пароля</strong> </p>
		<input type="password" name="passwd2" required value="<?php echo @$data['passwd2']; ?>">
	</p>

<p>

	<button type="submit" name = "reg">Зарегистрироваться</button>
</p>	
<p>
<a href="log_in.php">Вход</a></br></br>
<a href="index.php">Главная страница</a></p>
</p>

 </form>

 
