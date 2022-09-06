<?php

namespace Core;

class Router
{

    protected $routes = [];

    protected $params = [];
 
    //add route to the routing table

    public function add($route, $params = [])
    {
        // $this->routes[$route] = $params;

        //escape forward slashes
        $route = preg_replace('/\//','\\/', $route);

        //convert variable eg {controller}
        $route = preg_replace('/\{([a-z]+)\}/','(?P<\1>[a-z-]+)',$route);

        //CONVERT WITH CUSTON REGULAR EXPRESSIONS EG {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/','(?P<\1>\2)',$route);

        //add start and end delimeters and case intensitive flag
        $route = '/^'.$route.'$/i';

        $this->routes[$route] = $params;
    }

    public function getRoutes()
    {
        return $this->routes;
    }
    


    //searchig match 
    public function match($url)
    {
        //$reg_exp = "/^(?P<controller>[a-z-]+)\/(?P<action>[a-z-]+)$/";
        
        foreach ($this->routes as $route => $params){
            if (preg_match($route, $url, $matches)){
               
                //get named capture group values
                //gdy mamy match wuodrebniamy wartości z pasującej tablicy kontrolet i action 
                //i ustawiamy je we własciwości parameters
               // $params = [];

                foreach ($matches as $key => $match){
                    if (is_string($key)){
                        $params[$key]  =$match;
                    }
                }
         
                 $this->params = $params;
                return true;
             }
        }

        return false;
    }

     /**
     * Get the currently matched parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;

    }


   //  /**
    // * Dispatch the route, creating the controller object and running the
   // *action method
     
   public function dispatch($url)
   {

        $url = $this-> removeQueryStringVariables($url);

       if ($this->match($url)) {
           $controller = $this->params['controller'];
           $controller = $this->convertToStudlyCaps($controller);
           //$controller = "App\Controllers\\$controller";
           $controller = $this->getNamespace() . $controller;

           if (class_exists($controller)) {
               $controller_object = new $controller($this->params);

               $action = $this->params['action'];
               $action = $this->convertToCamelCase($action);

               if (preg_match('/action$/i', $action) == 0) {
                $controller_object->$action();

            } else {
                throw new \Exception("Method $action (in controller $controller) not found");
            }
        } else {
            throw new \Exception("Controller class $controller not found");
        }
    } else {
        throw new \Exception('No route matched.', 404);
    }
   }


    /**
     * Convert the string with hyphens to StudlyCaps,
     * e.g. post-authors => PostAuthors
     */

    protected function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }


    /**
     * Convert the string with hyphens to camelCase,
     * e.g. add-new => <addNew>
      */

      protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

   protected function removeQueryStringVariables($url)
   {
       if ($url != '') {
           $parts = explode('&', $url, 2);

           if (strpos($parts[0], '=') === false) {
               $url = $parts[0];
           } else {
               $url = ''; 
           }
       }

       return $url;
   }

   protected function getNamespace()
   {
       $namespace = 'App\Controllers\\';

       if (array_key_exists('namespace', $this->params)) {
           $namespace .= $this->params['namespace'] . '\\';

        //    echo '<p>Query string parameters: <pre>'.
        //    htmlspecialchars(print_r($this->params, true)),'</pre></p>';
   
       }

       return $namespace;
   }

    
    
}
?>