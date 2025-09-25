<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * Instance of the session
     *
     * @var \CodeIgniter\Session\Session
     */
    protected $session;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * InitController: Se ejecuta en todos los controladores que hereden BaseController
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // No tocar esta línea
        parent::initController($request, $response, $logger);

        // Inicializar sesión
        $this->session = \Config\Services::session();
    }
}
