<?php

/*
This class has four methods.
The name comes from the first letter of the name of the functions:
Create, Read, Update, and Delete
Create creates a new row in a table
Read reads a table
Update updates a row a table
and Delete deletes a row in a table
*/
class CRUD{

	/*
	This method creates a new row in a specified table.
	*/
	public function Create($table, array $rows){

		global $con;

		$columns = '';
		$values = '';

		foreach($rows as $rowName => $rowValue){

			$columns .= "$rowName,";
			$values .= "'$rowValue',";

		}

		$columns = substr_replace($columns, "", -1);
		$values = substr_replace($values, "", -1);

		$sql="INSERT INTO $table ($columns) VALUES ($values)";

		$con->query($sql);
	}//end of Create method

	public function Read($table, array $rows, $other=""){

		global $con;

		$rowsStr ='';

		foreach($rows as $rowName) {

			$rowsStr.= $rowName .",";

		}

		$rowsStr = substr_replace($rowsStr, "", -1);

		$result = $con->query("SELECT $rowsStr FROM $table $other");

		return $result;

	}//end of Read method

	public function Update($table, array $rowArray, $id){

		global $con;

		$rowsUpdate = '';

		foreach($rowArray as $tableName => $tableValue){

			$rowsUpdate .= $tableName."='".$tableValue."',";

		}

		$rowsUpdate = substr_replace($rowsUpdate, "", -1);

		$sql = "UPDATE $table SET $rowsUpdate WHERE id = $id";

		// echo $rowsUpdate.'<br><br><br>';
		//
		// echo $sql.'<br>';

		$con->query($sql);

	}//end of Update method

	/*
	This method deletes a id-specified row from a specified table. That's it
	*/
	public function Delete($table,$id){

		global $con;
		$table = $con->real_escape_string($table);
		$id = $con->real_escape_string($id);

		$con->query("DELETE FROM $table WHERE id=$id");

	}//end of Delete method

}
