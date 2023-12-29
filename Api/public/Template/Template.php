<?php
namespace App\public\Template;

Class Template {
    private String $temp;
    private Array $data;
    private String $body;
    public function __construct (String $name, Array $data) {
        $this->temp = $name;
        $this->data = $data;
    }
    public function getBody ()
    {
        require_once($this->temp.'.php');
        return printer($this->data);
    }
}