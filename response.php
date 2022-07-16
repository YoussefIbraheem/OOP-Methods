<?php 

namespace database;
//to handle errors
use Exception ;
use mysqli;
//to turn the format into parsed
header('Content-Type: application/json; charset=utf-8');
// to surpress system errors
mysqli_report(MYSQLI_REPORT_OFF);


//EXCEPTION class is added in order to handle any errors
class Response extends Exception{
    // to be assigned to the outcome of the query and used in multiple if conditions
    public $result;
    // Database name and SQL query required
    public function checkConnection($db , $query){
        //@ to surpress warnings
        $connection = @new mysqli("localhost","root","",$db);
        // in case if a wrong DB entered
        if($connection->connect_errno){
            throw new Exception("Error connecting to Database: $connection->connect_error");
            exit();
        }else{
            // assign the query result
            $this->result = $connection->query($query);
        }
        // in case if the select query was incorrect
        if(!isset($this->result)){
            throw new Exception("Error fetching Data! Query : $query is not adhering to MDB");
            // in case if the add/update/delete query was incorrect
        }elseif (!$this->result) {
            throw new Exception("Error fetching Data! Query : $query is not adhering to MDB");
            
        }else{
            echo $this->result ;
            echo "Request Processed Successfully\n";
            echo "Status Code: ".http_response_code(200)."\n";
            // in case if the query result fetch request **SElECT** therefore the outcome isnt a bool
            if(!is_bool($this->result)){
                $resultArray = mysqli_fetch_all($this->result,MYSQLI_ASSOC) ;
                print_r($resultArray);
            }else{
                // to terminate exit the case
                exit();
            }
        }
        
    }
}

// in case if there are any errors in the query the CATCH part will return the error type and code
try{
    $response = new Response;
    $response->checkConnection("crud","update posts set title='empty' where id=1");
}catch(Exception $e){
    echo $e->getMessage()."\n";
    echo "Status Code: ".$e->getCode();
}



?>