<?php

namespace Classes;

class Env {
    const SEPARATOR = '.';

    private $config = [], $file;

    function __construct($file)
    {
        $this->file = $file;
    }

    public function get()
    {
        if (!file_exists($this->file)) {
            throw new Exception('\'' . $this->file . '\' config file not found');
        }

        if (count($env = parse_ini_file($this->file, TRUE, INI_SCANNER_RAW)) > 0) {
            foreach ($env as $key => $value) {
                $explodedRow = explode(self::SEPARATOR, $key);
                $this->config = array_merge_recursive($this->config, $this->parse_string($explodedRow, $value));
            }
        }

        return $this->config;
    }

    private function parse_string($row, $value)
    {
        $result = null;

        $row = array_values($row);

        if (count($row)) {
            $firstItem = $row[0];
            unset($row[0]);
            $result[$firstItem] = $this->parse_string($row, $value);
        } else {
            $result = $value;
        }

        return $result;
    }
}
