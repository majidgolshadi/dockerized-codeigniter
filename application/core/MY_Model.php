<?php

use MongoDB\Driver\Manager;

class MY_Model extends CI_Model
{
    protected $manager;

    protected $db;

    public function __construct()
    {
        parent::__construct();

        $mongoCfg = $this->config->item('mongo');

        if (isset($mongoCfg['database'])) {
            $this->db = $mongoCfg['database'];
        }

        $this->manager = new Manager($this->getUri($mongoCfg));
    }

    private function getUri($mongoConfig)
    {
        $uri = 'mongodb://'.$mongoConfig['hostname'];

        if (isset($mongoConfig['port'])) {
            $uri = $uri.':'.$mongoConfig['port'];
        }

        return $uri;
    }

//    protected function modelToEntityMapper($classType, $dataArray)
//    {
//
//    }

    protected function NormalizedFieldName($fields = array())
    {
        $result = [];

        foreach ($fields as $key => $value) {
            $key = $this->camelCaseToUnderscore($key);
            $result[$key] = $value;
        }

        return $result;
    }

    private function camelCaseToUnderscore($input) {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];

        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        return implode('_', $ret);
    }
}
