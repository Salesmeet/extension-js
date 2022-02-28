<?php

namespace App\Application\Actions\v1;


class Common
{

    public function __construct()
    {
    }


    public function getOutputMessage($message)
    {
        return json_encode($message);
        // array('message' => $message);
    }

}
