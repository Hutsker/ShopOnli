<?php 
	require "db/connectt.php";
	$data = $_POST;
	if (isset($data['in']))
	{
		{
		$eggor = array();
		$user = R::findOne('buyer', 'login = ?', array($data['login']));

		if ($user)	
		{
			if (password_verify($data['passwd'], $user->password))
			{
				$_SESSION['user'] = $user->id;	
				$res = R::getAll("SELECT basket.products FROM `basket`WHERE basket.closed = 0 AND basket.buyer = " . $_SESSION['user']);

				$_SESSION['basket'] = [];
				foreach ($res as $key => $value) {
					array_push($_SESSION['basket'], $value['products']);
				}
				
  				header('location: index.php');
  				exit;
			}else $eggor[] = "Пароль не подходит";
		}
		else 
		{
			$eggor[] = "Пользователь не найден";
		}
		if (!(empty($eggor)))
		foreach ($eggor as $key => $value) {
			echo $value . "</br>";
		}
	}
	}
?>
<title>Вход</title>
<form action="log_in.php" method="POST">

	<p> 
		<p> <strong>Логин</strong> </p>
		<input type="text" name="login" required value="<?php echo @$data['login']; ?>">
	</p>
	<p>
		<p> <strong>Пароль</strong> </p>
		<input type="password" required name="passwd">
	</p>

<p>
	<button type="submit" name="in">Войти</button>
</p>	
<p>
<a href="sign_in.php">Регистрация</a></p>
<a href="dich.php">Главная страница</a></p>
 </form>
