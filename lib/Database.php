<?php

class Database {    


    

    public  function getConnection() {
        // Create connection
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        // Check connection
        if ($conn->connect_error) { 
            die("Connection failed: " . $conn->connect_error);
            return false;
        } else {
            return $conn;
        }
    }


    public  function get($table,$conditions = array())
    {
        $conn = $this->getConnection();

        $sql = 'SELECT ';
        $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
        $sql .= ' FROM '.$table;
        if(array_key_exists("where",$conditions)){
            $sql .= ' WHERE ';
            $i = 0;
            foreach($conditions['where'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }
        
        if(array_key_exists("order_by",$conditions)){
            $sql .= ' ORDER BY '.$conditions['order_by']; 
        }
        
        if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit']; 
        }elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['limit']; 
        }
        
        $result = $conn->query($sql);
        
        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
            switch($conditions['return_type']){
                case 'count':
                    $data = $result->num_rows;
                    break;
                case 'single':
                    $data = $result->fetch_assoc();
                    break;
                default:
                    $data = '';
            }
        }else{
            $data = array();
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $data[] = $row;
                }
            }
        }
        $conn->close();
        return !empty($data)?$data:false;
    }


    public function execute($sql,$return_type)
    {
        $conn = $this->getConnection();
        $result = $conn->query($sql);
        if($result)
        {    
        switch($return_type){
                case 'count':
                    $data = $result->num_rows;
                    break;
                case 'single':
                    $data = $result->fetch_assoc();
                    break;
                case 'all' : 
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $data[] = $row;
                        }
                    }
                    break;
                case 'affected' :
                    $data = $conn->affected_rows;
                    break;
            }
        }    
        $conn->close();
        return $data;
    }

  
    public function insert($table,$data){
        $conn = $this->getConnection();
        if(!empty($data) && is_array($data)){
            $columns = '';
            $values  = '';
            $i = 0;
           
            foreach($data as $key=>$val){
                $pre = ($i > 0)?', ':'';
                $columns .= $pre.$key;
                $values  .= $pre."'".$val."'";
                $i++;
            }
            $query = "INSERT INTO ".$table." (".$columns.") VALUES (".$values.")";
            $insert = $conn->query($query);
            $result =  $insert?$conn->insert_id:false;
            $conn->close();
            return $result;
        }else{
            $conn->close();
            return false;
        }
    }
    
 
    public function update($table,$data,$conditions){
        $conn = $this->getConnection();
        if(!empty($data) && is_array($data)){
            $colvalSet = '';
            $whereSql = '';
            $i = 0;
         
            foreach($data as $key=>$val){
                $pre = ($i > 0)?', ':'';
                $colvalSet .= $pre.$key."='".$val."'";
                $i++;
            }
            if(!empty($conditions)&& is_array($conditions)){
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach($conditions as $key => $value){
                    $pre = ($i > 0)?' AND ':'';
                    $whereSql .= $pre.$key." = '".$value."'";
                    $i++;
                }
            }
            $query = "UPDATE ".$table." SET ".$colvalSet.$whereSql;
            
            $update = $conn->query($query);
            $result = $update?$conn->affected_rows:false;
            $conn->close();
            return $result;
        }else{
            $conn->close();
            return false;
        }
    }
    
   
    public function delete($table,$conditions){
        $conn = $this->getConnection();
        $whereSql = '';
        if(!empty($conditions)&& is_array($conditions)){
            $whereSql .= ' WHERE ';
            $i = 0;
            foreach($conditions as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $whereSql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }
        $query = "DELETE FROM ".$table.$whereSql;
        $delete = $conn->query($query);
        $conn->close();
        return $delete?true:false;
    }


	

}



