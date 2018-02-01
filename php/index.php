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
		$conn_string = "host=localhost port=5432 dbname=postgres user=postgres password=kara";
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

		function Gano(string $id,string $t){
			$upd1 = $this->db->Query("SELECT cant FROM pelota WHERE cant=(SELECT sum FROM pelota WHERE it=$t AND id_co=$id);");
			if (isset($upd1[0])) {
				return "Si";
			}else{
				return "No";
			}
		}
		function Put(){
			$id1=(int)$this->form["id1"];
			$id2=(int)$this->form["id2"];
			$ip1=(int)$this->form["v1"];
			$ip2=(int)$this->form["v2"];
			// echo json_encode(array("ok"=>true,"for"=>$this->db->Query("UPDATE pelota SET cant=8 WHERE it=1;")));

			$upd1 = $this->db->Query("UPDATE pelota SET cant=(SELECT cant FROM pelota WHERE it=$ip1 AND id_co=$id1)-1 WHERE it=$ip1 AND id_co=$id1;");
			$upd2 = $this->db->Query("UPDATE pelota SET cant=(SELECT cant FROM pelota WHERE it=$ip2 AND id_co=$id1)+1 WHERE it=$ip2 AND id_co=$id1;");
			$upd3 = $this->db->Query("UPDATE pelota SET cant=(SELECT cant FROM pelota WHERE it=$ip2 AND id_co=$id2)-1 WHERE it=$ip2 AND id_co=$id2;");
			$upd4 = $this->db->Query("UPDATE pelota SET cant=(SELECT cant FROM pelota WHERE it=$ip1 AND id_co=$id2)+1 WHERE it=$ip1 AND id_co=$id2;");
			
			$r1=$this->Gano($id1,$ip2);
			if ($r1=="No") {
				$r1=$this->Gano($id2,$ip1); 
			}
			
			echo json_encode(array("ok"=>true,"Gano"=>$r1));

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
		$sum=0;
		while (true) {
			
			if($j==(int)$this->form['puntos']){
			$row = $this->db->Query("UPDATE pelota SET sum=$sum WHERE id_co=$i;");
			$j=0;
			$i++;
			
			$sum=0;
			}
			if ($i==(int)$this->form['contenedor']) {
				break;
			}
			$inex="{$i}/{$j}";
			$cant=$this->form[$inex];
			$sum+=(int)$cant;
			$row = $this->db->Query("INSERT INTO pelota (it,cant,id_co) values ($j,$cant,$i);");
			$j++;
		}
		
		}

		}
		function Delete(){
			$row = $this->db->Query("DELETE FROM componente;");
			echo json_encode(array("ok"=>true));
		}


	}



if ($_POST) {
	// echo json_encode(array("ok"=>"1",));
	$reg=new Request("Post",$_POST);   

}elseif ($_GET) {
	$reg=new Request("Get",$_GET);
}elseif ($_SERVER["REQUEST_METHOD"]=="PUT") {
	parse_str(file_get_contents("php://input"),$_PUT);
	$reg=new Request("Put",$_PUT);
}elseif ($_SERVER["REQUEST_METHOD"]=="DELETE") {
	parse_str(file_get_contents("php://input"),$_DELETE);
	$reg=new Request("Delete",$_DELETE);
}else{
	echo "nada";
}

?>