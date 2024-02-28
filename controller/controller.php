<?php 
require_once "../model/model.php";

class controller extends model{

    public function __construct()
    {
        parent::__construct();
        if (!isset($_SERVER["PATH_INFO"]) || $_SERVER["PATH_INFO"] == NULL) {
            $path = "default";
        } else {
            $arr = explode("/", $_SERVER['REQUEST_URI']);
            $path = $arr[3] . $_SERVER["PATH_INFO"];
        };
        switch ($path) {
            case 'public/home':
                $this->public_view("../view/public/home.php");
                break;
            case "public/api/adduser":{
                $func = function($data){
                    $requested_data = $this->insert("users",$data);
                    return json_encode($requested_data);
                };
                $data = $this->post_api_callback($func);
                header("content-type: application/json");
                print_r($data);
                break;
            }
            case "public/login":{
                $this->public_view("../view/public/login.php");
                break;
            }
            case "public/api/login-user":{
                $func = function($data){
                    $requested_data = $this->select("users",['*'],$data);
                    return json_encode($requested_data);
                };
                $data = $this->post_api_callback($func);
                header("content-type: application/json");
                print_r($data);
                break;
            }
            case "public/api/getalldata":{
                $func = function(){
                    $requested_data = $this->select("users",['*'],['1'=>'1']);
                    return json_encode($requested_data);
                };
                $data = $this->post_api_callback($func);
                header("content-type: application/json");
                print_r($data);
                break;
            }
            
            default:
                echo "<h1>GO HOME</h1>";
                break;
        }

    }
    function post_api_callback($func){
        if(isset($_POST)){
                   
            $is_emty = $this->chack_data_not_empty($_POST);
            if($is_emty['return'] == true){
               return json_encode(['data'=>$is_emty['data'],'error'=>"YOUR DATA IS NULL",'status'=>400]);
            };
            $data = $func($_POST);
            return $data;
        }else{
            return json_encode(["data"=>NULL,"error"=>"USE POST METHODE","status"=>400]);
        };
    }
    function get_api_callback($func){
        $data = $func();
        return $data;
    }
    public function chack_data_not_empty($arr){
        $emty=array();
        $return = false;
        foreach ($arr as $key => $value) {
            if(!isset($key) || !isset($value)){
                $return = true;
                $emty[$key];
            };
        }
        return ['data'=>$emty,'return'=>$return];
    }
    public function public_view($location){
        require_once "../view/public/header.php";
        require_once $location;
        require_once "../view/public/footer.php";
    }

}

$obj = new controller();    