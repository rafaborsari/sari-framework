<?php
namespace Sari\Provider;

use PDO;

class DataBaseProvider
{
	public $dbh;

	public function __construct()
	{
		include('src/Config/prod-config.php');
		$this->pdo = new PDO("".$db['dsn'].":host=".$db['host'].";dbname=".$db['dbname']."", $db['username'], $db['password']);
	}

	public function listAll($sql, $placeholders = array())
	{
		$sth = $this->pdo->prepare($sql);
		foreach ($placeholders as $placeholder => $value) {
			$sth->bindValue(
				$placeholder,
				$value
			);
		}

		$sth->execute();

		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function findBy($table, $filters, $limit = '', $oderBy = array())
	{
		
		foreach ($filters as $column => $value) {
			$columns[] = $column;
			$placeholders[] = ":" . $column;
			$values[] = $value;
		}
		$sql = "SELECT * FROM ".$table."";

		for ($i=0; $i < count($values); $i++) { 
			$prefix = ($i == 0 ? 'WHERE' : 'AND');
			$sql .= " ".$prefix." ".$columns[$i]." LIKE ".$placeholders[$i]." ";
		}

		$sth = $this->pdo->prepare($sql);
		for ($i=0; $i < count($values); $i++) { 
			$sth->bindValue(
				$placeholders[$i],
				$values[$i]
			);
		}

		$sth->execute();
		return $sth->fetchAll(PDO::FETCH_ASSOC);
	}

	public function findOneBy($table, $row, $id)
	{
		$sql = "SELECT * FROM ".$table." WHERE ".$row." = :id LIMIT 1";
		
		$sth = $this->pdo->prepare($sql);
		$sth->bindValue(':id', $id);

		$sth->execute();
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		return $result[0];
	}

	public function insert($table, $data = array())
	{
		foreach ($data as $column => $value) {
			if ($this->existColumn($table, $column)) {
				$columns[] = $column;
				$placeholders[] = ":" . $column;
				$values[] = $value;
			}
		}

		$sql = "INSERT INTO ".$table."(".implode(',', $columns).") VALUES (".implode(',', $placeholders).")";

		$sth = $this->pdo->prepare($sql);

		// Generate bindValues
		for ($i=0; $i < count($values); $i++) { 
			$sth->bindValue(
				$placeholders[$i],
				$values[$i]
			);
		}

		return $sth->execute();
	}

	public function update($table, $data = array(), $id)
	{
		foreach ($data as $column => $value) {
			if ($this->existColumn($table, $column)) {
				$updates[] = $column . '=:' . $column;
				$placeholders[] = ":" . $column;
				$values[] = $value;			
			}
		}

		$sql = "UPDATE ".$table." SET ".implode(',', $updates)." WHERE ".$id[0]." = ".$id[1]." ";

		$sth = $this->pdo->prepare($sql);

		// Generate bindValues
		for ($i=0; $i < count($values); $i++) { 
			$sth->bindValue(
				$placeholders[$i],
				$values[$i]
			);
		}
		return $sth->execute();
	}

	public function delete($table, $id)
	{
		$sql = "DELETE FROM ".$table." WHERE ".$id[0]." = ".$id[1]." ";
		$sth = $this->pdo->prepare($sql);

		return $sth->execute();
	}

	private function existColumn($table, $column)
	{
		$sql = "SHOW COLUMNS FROM ".$table." WHERE Field = '".$column."' ";
		$sth = $this->pdo->prepare($sql);
		$sth->execute();
		$existRow = $sth->fetch(PDO::FETCH_ASSOC);

		return $existRow;
	}

	public function getError()
	{
		return $this->pdo->errorInfo();
	}

}

