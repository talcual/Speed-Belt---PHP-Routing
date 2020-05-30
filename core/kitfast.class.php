<?php 


/**

 Kompat v2 =>> Speed Belt V0.1

Superfast microrouting system for build a ultrafast php apps or apis.
  
 Author : Luis Toscano
 Web    : www.luistoscano.ml

**/

namespace KompatNs;

class Kompat{
        private $routes;
        private $uri, $uri_parts;
        private $resources = [];

        function __construct($routes){
           $this->routes = $routes;
           $this->uri = $_SERVER['REQUEST_URI'];
        }

        public function run(){
           // parsing uri
           self::parseUri();

           // load keys from routes
           $routes_keys = array_keys($this->routes);
           
           // searching key and load into variable
           foreach ($routes_keys as $key => $route) {

                $last_in_route   = substr($route, -1);
                $boning = explode('/', $this->uri_parts['path']);
                $last_in_request =  $boning[count($boning) - 1];

                if($last_in_route == '?'){
                   $keyy = str_replace($last_in_request, $last_in_route, $this->uri_parts['path']);
                }else{
                   $keyy = $this->uri_parts['path'];
                }

                if(in_array($keyy, $routes_keys)){
                    if($last_in_route == '?'){
                        $fnx = str_replace($last_in_request, $last_in_route, $this->uri_parts['path']);
                    }else{
                        $fnx = $this->uri_parts['path'];
                    }
                    break;
                }
           }


           // control http method 
           switch ($_SERVER['REQUEST_METHOD']) {
                   case 'GET':
                        if(isset($fnx)){
                                if($this->routes[$fnx]['http'] == 'GET'){
                                
                                   if(is_callable($this->routes[$fnx]['action'])){

                                        // obtenemos el parametro a enviar a la funcion
                                        $boning = explode('/', $this->uri_parts['path']);
                                        $param = $boning[count($boning) - 1];

                                        // revolvemos la funcion
                                        return $this->routes[$fnx]['action']($param, $this->resources);
                                   }else{

                                        // obtenemos la ruta del modelo a cargar                                
                                        $oo = explode('/', $this->routes[$fnx]['action']);
                                        $file_include = str_replace('@','',$oo[0]).'/';
                                        $file_include .= $oo[1].'.model.php';

                                        // validamos que el archivo a incluir exista
                                        if(is_file($file_include)){
                                           if(!class_exists($oo[1])){
                                              include $file_include;
                                           }

                                           //definmos el metodo
                                           $method = $oo[2];

                                           // creamos el objeto y llamamos el metodo.
                                           $to = new $oo[1]($this->resources);
                                           $to->$method();

                                        }
                                   }

                                }else{
                                   exit('Access not permited by GET');
                                }
                        }           
                        
                        break;

                   case 'POST':
                        if(isset($fnx)){
                                if($this->routes[$fnx]['http'] == 'POST'){
                                
                                   if(is_callable($this->routes[$fnx]['action'])){
                                        // obtenemos el parametro a enviar a la funcion
                                        $param = substr($this->uri_parts['path'], -1);

                                        // revolvemos la funcion
                                        return $this->routes[$fnx]['action']($param, $this->resources);
                                   }else{

                                        // obtenemos la ruta del modelo a cargar                                
                                        $oo = explode('/', $this->routes[$fnx]['action']);
                                        $file_include = str_replace('@','',$oo[0]).'/';
                                        $file_include .= $oo[1].'.model.php';

                                        // validamos que el archivo a incluir exista
                                        if(is_file($file_include)){
                                           if(!class_exists($oo[1])){
                                              include $file_include;
                                           }

                                           //definmos el metodo
                                           $method = $oo[2];

                                           // creamos el objeto y llamamos el metodo.
                                           $to = new $oo[1]($this->resources);
                                           $to->$method();

                                        }
                                   }

                                }else{
                                   exit('Access not permited by POST');
                                }
                        } 
                        break;                           
           }
           


        }

        private function parseUri(){
           $this->uri_parts = parse_url($this->uri);
        }

        private function handleMethod(){

        }

        public function addResources($key,$res){
            $this->resources[$key] = $res;
        }
}
