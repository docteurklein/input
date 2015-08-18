<?php

namespace Knp;

class Input
{
    private $raw;

    public static function fromValue($data)
    {
        $input = new self;
        $input->raw = $data;

        return $input;
    }

    public function all()
    {
        return $this->raw;
    }

    public function contains($key)
    {
        return array_key_exists($key, $this->raw);
    }
}
