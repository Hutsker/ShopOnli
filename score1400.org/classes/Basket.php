<?php  
class Basket 
{
	public $id,
	$buyer,
	$products,
	$closed	;

	public function __construct($id,	$buyer,	$products)
	{
	   $this->id = $id; 
	   $this->buyer = $buyer;
	   $this->products = $products;
	   $this->closed = 0;
	}

}

?>