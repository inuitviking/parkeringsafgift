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

		// tag $con
		global $con;

		// nogle tomme variabler
		$columns = '';
		$values = '';

		// kør $rows gennem en foreach fordi vi skal have key og value
		foreach($rows as $rowName => $rowValue){

			// key er kolonnenavnene fra tabellen
			$columns .= "$rowName,";
			// values er det der skal sættes i de specifikke kolonnenavne
			$values .= "'$rowValue',";

		}

		// Fjern de sidste komma
		$columns = substr_replace($columns, "", -1);
		$values = substr_replace($values, "", -1);

		// put SQL sætningen i en variabel
		$sql="INSERT INTO $table ($columns) VALUES ($values)";
		// INSERT INTO betyder at du laver en ny række i en bestem tabel
		// den første parantes er kolonnenavnene
		// Den næste er det der skal sættes ind

		// send den til databsen
		$con->query($sql);
	}//end of Create method

	/*
	This method reads a table
	*/
	public function Read($table, array $rows, $other=""){
		// tag $con
		global $con;
		// lav en tom variabel
		$rowsStr ='';

		//kør $rows arrayet i en foreach
		foreach($rows as $rowName) {
			// tilføj rækkenavnene i $rowStr
			$rowsStr.= $rowName .",";

		}

		// fjern sidste komma
		$rowsStr = substr_replace($rowsStr, "", -1);

		// Send det til databasen og læg informationen fra DB i en variabel
		$result = $con->query("SELECT $rowsStr FROM $table $other");

		// returner informationerne
		return $result;

	}//end of Read method

	/*
	This method updates a table
	*/
	public function Update($table, array $rowArray, $id){

		// tag $con
		global $con;
		// tom variabel
		$rowsUpdate = '';

		// kør $rowArray gennem en foreach hvor du specifiserer key og value
		foreach($rowArray as $tableName => $tableValue){

			// Sæt det i $rowsUpdate
			$rowsUpdate .= $tableName."='".$tableValue."',";

		}
		// Fjern sidste komma
		$rowsUpdate = substr_replace($rowsUpdate, "", -1);

		// Sæt SQL sætningen i en variabel
		$sql = "UPDATE $table SET $rowsUpdate WHERE id = $id";

		// Send den til databasen, så tabellen kan blive opdateret
		$con->query($sql);

	}//end of Update method

	/*
	This method deletes a id-specified row from a specified table. That's it
	*/
	public function Delete($table,$id){
		// tag $con
		global $con;
		// Sørg for at det er sikkert for SQL-injection
		// Undrer mig nu hvorfor jeg ikke har gjort det med de andre metoder
		$table = $con->real_escape_string($table);
		$id = $con->real_escape_string($id);

		// Send det til databasen, så rækken kan blive slettet
		$con->query("DELETE FROM $table WHERE id=$id");

	}//end of Delete method

}
