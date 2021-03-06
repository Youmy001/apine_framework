<?php
/**
 * Main Application Execution
 * This script contains the representation of an APIne application
 *
 * @license MIT
 * @copyright 2015 Tommy Teasdale
 */

declare(strict_types=1);

namespace Apine\Application;

use Apine\Application\ServiceAwareTrait;
use Apine\Core\Error\ErrorHandler;
use Apine\Core\Error\Http\HttpException;
use Apine\Core\Http\Response;
use Apine\Core\Http\Stream;
use Apine\Core\Config;
use Psr\Http\Message\ResponseInterface;

use const Apine\Core\PROTOCOL_HTTPS;

use function Apine\Core\Utility\executionTime;

/**
 * Apine Application
 *
 * @author Tommy Teasdale <tteasdaleroads@gmail.com>
 * @package Apine\Application
 */
final class Application
{
    use ServiceAwareTrait;
    //use MiddlewareAwareTrait;
    
    /**
     * Version number of the framework
     *
     * @var string
     */
    public static $version = '2.0.0-dev';
    
    /**
     * Name of the folder where the framework is located
     *
     * @var string
     */
    private $apineFolder;
    
    /**
     * @var string
     */
    private $includePath;
    
    /**
     * Application constructor.
     */
    public function __construct(string $projectDirectory = null)
    {
        try {
            executionTime();
            $this->setPaths($projectDirectory);
            
            ErrorHandler::set(E_ALL, true);
            $this->services= ServiceProvider::registerDefaultServices();
        } catch (\Exception $e) {
            $this->outputException($e);
            die();
        }
        
    }
    
    /**
     * Move the include path to the project's root
     * rather than the server's root
     *
     * @param string|null $projectDirectory
     */
    private function setPaths(string $projectDirectory = null) : void
    {
        $documentRoot = $_SERVER['DOCUMENT_ROOT'];
        $this->apineFolder = realpath(dirname(__FILE__) . '/..'); // The path to the framework itself
        
        if (null === $projectDirectory) {
            $directory = $documentRoot;
        
            while (!file_exists($directory . '/composer.json')) {
                $directory = dirname($directory);
            }
        
            $projectDirectory = $directory;
        }
    
        $this->includePath = $projectDirectory;
        set_include_path($this->includePath);
        chdir($this->includePath);
    }
    
    /**
     * Run the application
     */
    public function run() : void
    {
        $config = null;
        //$headers = getallheaders();
        //$isHttp = (isset($headers['HTTPS']) && !empty($headers['HTTPS']));
        
        /**
         * Main Execution
         */
        try {
            // Verify if the protocol is allowed
            // TODO Move that to a middleware
            /*if (!$isHttp && !extension_loaded('xdebug')) {
                // Remove trailing slash
                $helper = new URLHelper();
                $uri = rtrim($_SERVER['REQUEST_URI']);
                
                $redirection = new RedirectionView(new Uri($helper->path($uri, PROTOCOL_HTTPS)), 301);
                $this->output($redirection->respond());
            }*/
    
            $config = new Config('config/error.json');
    
            // Make sure application runs with a valid execution mode
            if ($config->reporting_level !== null) {
                $level = eval('return ' . $config->reporting_level . ';');
                ErrorHandler::set($level, $config->show_trace);
            }
    
            $request = $this->services->get('request');
            $router = $this->services->get('router');
            $route = $router->find($request);
            $response = $router->run($route, $request);
            
            $this->output($response);
        } catch (\Throwable $e) {
            $this->outputException($e);
        }
    }
    
    /**
     * Output a response to the client
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function output(ResponseInterface $response) : void
    {
        if (!headers_sent()) {
            header(sprintf(
                'HTTP/%s %s %s',
                $response->getProtocolVersion(),
                $response->getStatusCode(),
                $response->getReasonPhrase()
            ));
        
            foreach ($response->getHeaders() as $name => $values) {
                if (is_array($values)) {
                    $values = implode(", ", $values);
                }
            
                header(sprintf('%s: %s', $name, $values), false);
            }
        }
        
        $body = $response->getBody();
    
        if ($body->isSeekable()) {
            $body->rewind();
        }
    
        print $body->getContents();
        die;
    }
    
    /**
     * Output a caught exception to the client
     *
     * @param \Throwable $e
     */
    public function outputException(\Throwable $e) : void
    {
        $response = new Response(500);
        $response = $response->withAddedHeader('Content-Type', 'text/plain');
    
        if ($e instanceof HttpException) {
            $response = $response->withStatus($e->getCode());
        }
    
        $result = $e->getMessage() . "\n\r";
    
        if (ErrorHandler::$showTrace === true) {
            $trace = explode("\n", $e->getTraceAsString());
        
            foreach ($trace as $step) {
                $result .= "\n";
                $result .= $step;
            }
        }
    
        $content = new Stream(fopen('php://memory', 'r+'));
        $content->write($result);
    
        $response = $response->withBody($content);
        
        $this->output($response);
    }
}