<?php

namespace Omnivox\Models;

use Omnivox\Libraries\Curl;

abstract class Endpoint
{
    /**
     * The Curl instance used during scraping.
     *
     * @var Curl
     */
    protected $curl;

    /**
     * Create a new API endpoint route controller.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->curl = new Curl();
    }
}
