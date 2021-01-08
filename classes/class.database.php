<?php 

include_once('class.Connection.php'); //my connection is here

class Database extends Connection{


	public function __construct($username, $password, $host, $dbname, $options){
		//__construct($username, $password, $host, $dbname, $options)
		parent::__construct($username, $password, $host, $dbname, $options);//code copy the default constructor of the class extended

	}//endDefaultConstructor

	//disconnect is in the parent class in Connection.php

	//get row
	public function getRow($query, $params = []){
		try {
			$stmt = $this->datab->prepare($query);
			$stmt->execute($params);
			return $stmt->fetch(PDO::FETCH_ASSOC);	
		} catch (PDOException $e) {
			throw new Exception($e->getMessage());	
		}


	}//end getRow

	//get rows
	public function getRows($query, $params = []){
		try {
			$stmt = $this->datab->prepare($query);
			$stmt->execute($params);
			return $stmt->fetchAll(PDO::FETCH_ASSOC);	
		} catch (PDOException $e) {
			throw new Exception($e->getMessage());	
		}
	}//end getRows

	//insert row
	public function insertRow($query, $params = []){
		try {
			$stmt = $this->datab->prepare($query);
			$stmt->execute($params);
			return true;	
		} catch (PDOException $e) {
			throw new Exception($e->getMessage());	
		}

	}//end insertRow

	//update row
	public function updateRow($query, $params = []){
		$this->insertRow($query, $params);
		return true;
	}//end updateRow

	//delete row
	public function deleteRow($query, $params = []){
		$this->insertRow($query, $params);
		return true;
	}//end deleteRow

	//get the last inserted ID
	public function lastID(){
		$lastID = $this->datab->lastInsertId(); 
		return $lastID;
	}//end lastID func

	public function transactionInsert($query, $params = [], $query2, $params2 = []){
		try {
			$this->Begin();
				$stmt = $this->datab->prepare($query);
				$stmt->execute($params);

				$stmt2 = $this->datab->prepare($query2);
				$stmt2->execute($params2);

			$this->Commit();
		} catch (PDOException $e) {
			$this->transaction->rollBack();
			throw new Exception($e->getMessage());	
		}
	}//end transac func


	public function Begin(){
		$this->transaction->beginTransaction();
	}

	public function Commit(){
		$this->transaction->commit();
	}

	public function RollBack(){
		$this->transaction->rollBack();
	}

	public function test()
	{
		echo 'database class test';
	}
}


 ?>