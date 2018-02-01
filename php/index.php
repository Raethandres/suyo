<?php
session_start();
/**
* 
*/
class DataBase
{
	public $db;
	function __construct()
	{
		$conn_string = "host=localhost port=5432 dbname=todo user=postgres password=kara";
		$this->db = pg_connect($conn_string);
	}
	function Query(string $qr){
		$result=pg_query($this->db, $qr);
		return pg_fetch_all($result);
	}
}

class Request
	{
		public $tipo;
		public $form;
		public $accion;
		public $db;
		// public $func= array('GET' =>this->Get() ,'POST'=>this->Post() );

		
		function __construct(string $tipo,array $form)
		{
			$this->tipo=$tipo;
			$this->form=$form;
			$this->db=new DataBase();
			if($this->tipo=="Post"){
				$this->Post();
			}elseif ($this->tipo=="Get") {
				$this->Get();
			}elseif ($this->tipo=="Delete") {
				$this->Delete();
			}elseif ($this->tipo=="Put") {
				$this->Put();
			}
		}


		function Put(){
			echo json_encode(array("ok"=>true));

		} 

		function Get(){
			echo json_encode(array("ok"=>true));
		}

		function Post(){
			// echo json_encode(array("ok"=>"1",));
		if ($this->form['crsf']=='matriz') {
		for ($i=0; $i <(int)$this->form['contenedor']; $i++) { 
			$row = $this->db->Query("INSERT INTO componente (n) values ($i);");
		}
		$i=0;
		$j=0;
		while (true) {
			
			if($j==(int)$this->form['puntos']){
			$j=0;
			$i++;
			}
			if ($i==(int)$this->form['contenedor']) {
				break;
			}
			$inex="{$i}/{$j}";
			$cant=$this->form[$inex];
			$row = $this->db->Query("INSERT INTO pelota (it,cant,id_co) values ($j,$cant,$i);");
			$j++;
		}
		
		}

		}
		function Delete(){
			echo json_encode(array("ok"=>true));
		}


	}



if ($_POST) {
	$res = json_decode($_POST);
	echo json_encode(array("ok"=>true,"form"=>$_POST));
	
	// $reg=new Request("Post",$_POST);   

}

?>