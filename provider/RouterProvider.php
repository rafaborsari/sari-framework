<?php
namespace Sari\Provider;

class RouterProvider
{

    public $url;
    protected $uri = array();
    protected $controller;
    protected $action;

    public function __construct()
    {
        $this->url = str_replace('index.php', '', $_SERVER['PHP_SELF']);
        $this->setUri();
    }

    public function setUri()
    {
        $this->uri = ( isset( $_GET['r'] ) )
            ? explode( '/', $_GET['r'] )
            : array('');
    }

    public function getUri()
    {
        $uri = implode($this->uri, '/');
        return $uri;
    }

    public function getParameter( $key )
    {
        if( array_key_exists( $key, $this->uri ) )
        {
            return $this->uri[$key];
        } else {
            return false;
        }
    }

    public function controller()
    {
        $this->controller = ( $this->uri[0] == NULL )
            ? 'index'
            : $this->uri[0] ;

        return ( is_string( $this->controller ) )
            ? $this->controller
            : 'index';
    }

    public function action()
    {
        $this->action = (
                isset( $this->uri[1] )
                && strlen( $this->uri[1] ) != 0
                && is_string( $this->uri[1] )
            )
            ? $this->uri[1]
            : 'main' ;

        return $this->action;
    }

}

