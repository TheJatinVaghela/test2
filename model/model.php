<?php 

class model{
    public $con ;
    public $hostname = "localhost";
    public $dir = "root";
    public $pass = "";
    public $db = "test2";
    public function __construct(){
        $this->connect_to_server($this->hostname, $this->dir, $this->pass, $this->db);

    }
    protected function connect_to_server($hostname, $dir, $pass, $db){
        try{
            $this->con = new mysqli($hostname, $dir, $pass, $db);
        }catch(\Exception $e){
            die($e->getMessage());
        }
    }
    protected function insert($tbl , $data){
       
        $sql1 = "INSERT INTO $tbl (";
        $sql2 = ") VALUES (";
        $sql3 = ")";
        foreach($data as $key => $value){
            $sql1 .= "$key ,";
            $sql2 .= "'$value' ,";
        }
        $sql1 = substr($sql1,0,-1);
        $sql2 = substr($sql2,0,-1);
        $sql = $sql1.$sql2.$sql3;
        $query_data = $this->simple_run_query($sql);
        return $query_data;
    }
    protected function select($tbl,$what,$where){
        $sql = "SELECT ";
        foreach($what as $key => $value){
            $sql .= "$value ,";
        };
        $sql = substr($sql,0,-1);
        $sql .= "FROM $tbl WHERE";
        foreach($where as $key => $value){
            $sql .= " $key = '$value' AND";
        };
        $sql = substr($sql,0,-3);
        $query_data = $this->get_all_run_query($sql);
        return $query_data;
    }
    public function simple_run_query($query){
        try {
            $query_data = $this->con->query($query);
            return ['data'=>$query_data,"message"=>"Query executed successfully",'status'=>200];
        } catch (\Throwable $th) {
            return ["data"=>NULL , 'error'=>$th->getMessage(),"status"=>500];
        };
        
    }
    public function get_all_run_query($query){
        try {
            $query_data = $this->con->query($query);
            if($query_data->num_rows <= 0) {
                return ["data"=>NULL,"message"=>"There Is no Data Available","status"=>200,"error"=>NULL];
            };
            
            $data = $this->get_all_data_query($query_data);
            return ["data"=>$data,"message"=>"success","status"=>200,"error"=>null];
        } catch (\Exception $e) {
            return ["data"=>NULL,"error"=>$e->getMessage(),"status"=>500];
        }
    }
    public function get_all_data_query($query_data){
       
        $data = array();
        while($a = $query_data->fetch_object()){
            foreach ($a as $key => $value){
                $data[$key]=$value;
            };
        }
        return $data;
    }
    public function print_stuf($stuf){
        echo "<pre>";
        print_r($stuf);
        echo "<pre>";
    }

}