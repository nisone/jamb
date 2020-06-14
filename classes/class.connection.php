<?php 
class Connection{

	protected $isConn;
	protected $datab;
	protected $transaction;

	public function __construct($username="root", $password ="", $host="localhost", $dbname="iot", $options = []){
		
		try{
			$this->datab = new PDO("mysql:host={$host};  dbname={$dbname}; charset=utf8", $username, $password, $options);
			$this->datab->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->transaction = $this->datab;
			$this->datab->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

			$this->isConn = TRUE;
		}catch(PDOException $e){
			throw new Exception($e->getMessage());
			$this->isConn = FALSE;
		}

	}//endDefaultConstructor
 

	//disconnect from db
	public function Disconnect(){
		$this->datab = NULL;//close connection in PDO
		$this->isConn = FALSE;
	}//endDisconnectFunction


	


}//endClassDatabase

 ?>