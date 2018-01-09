<?php

namespace Indicadores\Controller;

use Base\Controller\AppController as BaseController;


class AppController extends BaseController
{
	
	public function formatDate($date){
		$data = substr($date,0,10);
		$hora = substr($date,10,strlen($date));
	
		$parts_d = explode('-',$data);
	
		return $parts_d[2].'/'.$parts_d[1].'/'.$parts_d[0] .$hora;
	}
	
}
