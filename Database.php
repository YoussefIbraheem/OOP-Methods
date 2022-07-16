<?php 
namespace database ;
class Connect {
    public $connection ;
    public $result ;
    public function __construct($db)
    {
      $this->connection = mysqli_connect("localhost","root","",$db);

        return $this->connection ;
    }

    public function selectAll($table){
    $query = mysqli_query($this->connection,"select * from $table") ;
     
    if(mysqli_num_rows($query)>0){
    $this->result = mysqli_fetch_all($query,MYSQLI_ASSOC);
    return $this->result ;     
     }else{
     
        echo "something went wrong" ;
     }

    }
     
    public function selectColumns($table , $columns , $condition = ""){
        $query = mysqli_query($this->connection,"select $columns from $table $condition") ;
         
        if(mysqli_num_rows($query)>0){
         $this->result = mysqli_fetch_all($query,MYSQLI_ASSOC);
        return $this->result ;     
         }else{
            echo "something went wrong" ;
         }

}


public function Delete($table , $condition ){
   $this->result = mysqli_query($this->connection,"delete from $table where $condition") ;
     
    if($this->result){
        return $this->result ;
     }else{
        return "something went wrong" ;
     }

}

public function Update($table , $condition){
   $this->result = mysqli_query($this->connection,"update $table set $condition") ;
     
    if($this->result){
        return $this->result ;
     }else{
        return "something went wrong" ;
     }

    

}



}

$connection = new Connect("crud") ;




?>