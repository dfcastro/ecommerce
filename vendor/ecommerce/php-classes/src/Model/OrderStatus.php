<?php 

namespace Ecommerce\Model;

use \Ecommerce\DB\Sql;
use \Ecommerce\Model;
use \Ecommerce\Model\User;


class OrderStatus extends Model
{

	const EM_ABERTO = 1;
	const AGUARDANDO = 2;
	const PAG0 = 3;
	const ENTREGUE = 4;


	public static function listAll()
	{
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_ordersstatus ORDER BY desstatus");

	}
}

 ?>