<?php

namespace App\Http\Controllers;

use Illuminate\Routing\ResponseFactory;

class HomeController extends Controller
{
    protected $response;

    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;

        parent::__construct($response);
    }

    public function show()
    {
        return $this->response->view('welcome');
    }
}
