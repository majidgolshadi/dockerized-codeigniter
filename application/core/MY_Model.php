<?php

class MY_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
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
