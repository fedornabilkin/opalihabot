<?php


namespace Fp\Filechecker;

use React\EventLoop\Factory;
use ReactFilesystemMonitor\INotifyProcessMonitor;
use React\SocketClient\Connector;

/**
 * Class Main
 * @package Fp\Filechecker
 */
class Main
{

    private $loop;
    private $file = '/update/rev_today.html';
    private $servername = "app";

    public function initMainLoop()
    { 
        $this->loop = Factory::create();
        
        $state = 0;

        $monitor = new INotifyProcessMonitor($this->file);

        $monitor->on('all', function ($p, $s, $event) use (&$state) {
            switch ($event) {
                case "open":
                    $state = 1;
                    break;
                
                case "modify":
                    if ($state === 1) {
                        $state = 2;
                    }
                    break;
                    
                case "close":
                    if ($state === 2) {
                        $state = 3;
                    }
                    break;
            }
            
            var_dump($state);
            
            if ($state === 3) {
                $this->sendRequest("action/user");

                exit();
            }
        });

        $monitor->start($this->loop);
        
        $this->loop->run();
    }

    public function sendRequest($param)
    {
        $uri = "http://" . gethostbyname($this->servername) . ":8082/" . $param;
        
        file_get_contents($uri);
    }

    public function action($action)
    {
        $method = $action . 'Check';
        if (!method_exists($this, $method)) {
            $this->sendRequest("action/$action");
        }

        switch ($action){
            case 'admin':
                $this->adminCheck();
                break;
            case 'user':
                $this->userCheck();
                break;
            case 'ipu':
                $this->ipuCheck();
                break;
        }
    }

    public function adminCheck()
    {
        if (date("Ymd") - date("Ymd", filemtime($this->file)) == 0) {
            $this->sendRequest("action/updated");
        } else {
            $this->sendRequest("action/filed");
        }
    }

    public function userCheck()
    {
//        if (date("Ymd") - date("Ymd", filemtime($this->file)) == 0) {
            $this->sendRequest("action/user");
//            $this->sendRequest("action/group");
//        } else {
//            $this->sendRequest("action/monitoring");
//
//            $this->initMainLoop();
//        }
    }

    public function ipuCheck()
    {
        $this->sendRequest("action/ipu");
    }
}
