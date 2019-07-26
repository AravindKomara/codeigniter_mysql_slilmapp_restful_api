<?php

class Dbo {

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "users";

    //private $mongodb_path = "mongodb://localhost:27017"; //your mongodb path
   
    function selectDBMySQL() {
        $connect = new mysqli($this->servername, $this->username, $this->password, $this->db);
        //print_r($connect);exit;
        if ($connect->connect_error) {
            die("Failed to connect database:" . $connect->connect_error);
        } else {
            return $connect;
        }
    }
    
    function commonWhereConditionsSetUp($where){
         foreach ($where as $key => $value) {
            $conditionSets[] = $key . " = '" . $value . "'";
        }
        return $conditionSets;
    }
    
    function commoneSetConditionsSetUp($set){
        foreach ($set as $key => $value) {
            $valueSets[] = $key . " = '" . $value . "'";
        }      
        return $valueSets;
    }

    function insert($tableName, $payload) {
        $keyArray = array_keys($payload);//for getting keys of array
        $fields = implode(',', $keyArray);//seperating keyArray by comma
      //print_r($fields);exit;
        $valueArray = array_values($payload);//for getting keys of array
        $fieldValues = '"' . implode('","', $valueArray) . '"'; //seperating valueArray by comma
     // print_r($fieldValues);exit;
        
        //connection to DB
        $dbconn = $this->selectDBMySQL(); //calling DB Method
        $sql = "INSERT INTO " . $tableName . " (" . $fields . ") VALUES (" . $fieldValues . ")"; //preparing SQL Query
     // print_r($sql);exit;
        if (mysqli_query($dbconn, $sql)) {
             return "inserted";
        } else {
            return "Error: " . $sql . "<br>" . mysqli_error($dbconn);
        }

        mysqli_close($dbconn);
    }
    
    function get($tableName,$select,$where,$type,$sort_columun,$sort,$limit) {
        $dbconn = $this->selectDBMySQL(); //calling method for selecting db(mandatory)
        //for getting result from DB
        if($type == "result"){
            $sql = "SELECT ".$select." FROM " . $tableName . " ORDER BY ".$sort_columun." ".$sort." LIMIT ".$limit." ";
           // echo $sql;exit;
            $result = mysqli_query($dbconn, $sql);
            if($result->num_rows > 0){
                  while($row = $result->fetch_assoc()){ //getting each and every row of table
                           $results[] = $row;//assiging each row into an array
                 }
                
                return $results;
            }
          
        }
     //for getting result from DB
        else if($type == "row"){
           $conditionSets = $this->commonWhereConditionsSetUp($where);//calling and prepaing WHERE conditions
           //print_r($conditionSets);exit;
            $sql = "SELECT ".$select." FROM " . $tableName . " WHERE " . join(" AND ", $conditionSets)." ORDER BY ".$sort_columun." ".$sort." LIMIT ".$limit." ";
            //echo $sql;exit;
            $result = mysqli_query($dbconn, $sql);
            if($result->num_rows > 0){
                   $row = mysqli_fetch_assoc($result);//for getting row
                
                return $row;
            }
        }
        
        mysqli_close($dbconn);
    }

    function update($tableName, $where, $set) {
        $conditionSets = $this->commonWhereConditionsSetUp($where);
        $valueSets = $this->commoneSetConditionsSetUp($set);

        $dbconn = $this->selectDBMySQL(); //calling method for selecting db(mandatory)
        $sql_fetch_data = "SELECT * FROM " . $tableName . " WHERE " . join(" AND ", $conditionSets);
        $res = mysqli_query($dbconn, $sql_fetch_data);
     // print_r($res->num_rows);exit;
        if ($res->num_rows > 0) {
              $sql = "UPDATE $tableName SET " . join(",", $valueSets) . " WHERE " . join(" AND ", $conditionSets);
            //print_r($sql);exit;
            if (mysqli_query($dbconn, $sql)) {
                return 1;
            } else {
                return "Error: " . $sql . "<br>" . mysqli_error($dbconn);
            }
        }
        mysqli_close($dbconn);


    }
    
    function delete($tableName,$where) {
        $conditionSets = $this->commonWhereConditionsSetUp($where);
        $dbconn = $this->selectDBMySQL(); 
        $sql= "DELETE FROM " . $tableName . " WHERE " . join(" AND ", $conditionSets);
        if (mysqli_query($dbconn, $sql)) {
             return "deleted";
        } else {
            return "Error: " . $sql . "<br>" . mysqli_error($dbconn);
        }
        mysqli_close($dbconn);


    }

}

?>