<?php

class Api_Base_Controller extends Base_Controller {

    protected function respond($response, $status = 200, $headers = array())
    {
        $environment = Request::env();

        if ($environment == 'local')
        {
            return Response::make(json_encode($response), $status, $headers);
        }

        return Response::json($response, $status, $headers);
    }

}