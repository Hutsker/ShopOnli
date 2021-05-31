<?php  
class Buyer 
{
	public $id,
	$surname,
	$name,
	$patronymic,
	$city,
	$street,
	$house,
	$flat,
	$phone,
	$login,
	$password;

	public function __construct($id,	$surname,$name,	$patronymic,$city,	$street,$house,	$flat,	$phone, $login,	$password)
	{
	   $this->id = $id; 
	   $this->surname = $surname;
	   $this->name = $name;
	   $this->patronymic = $patronymic;
	   $this->city = $city;
	   $this->street = $street;
	   $this->house = $house;
	   $this->flat = $flat;
	   $this->phone = $phone;
	   $this->login = $login;
	   $this->password = $password;
	}

}

?>