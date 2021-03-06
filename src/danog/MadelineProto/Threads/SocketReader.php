<?php
/*
Copyright 2016-2017 Daniil Gentili
(https://daniil.it)
This file is part of MadelineProto.
MadelineProto is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
MadelineProto is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU Affero General Public License for more details.
You should have received a copy of the GNU General Public License along with MadelineProto.
If not, see <http://www.gnu.org/licenses/>.
*/

namespace danog\MadelineProto\Threads;

/**
 * Manages packing and unpacking of messages, and the list of sent and received messages.
 */
class SocketReader extends \Threaded implements \Collectable
{
    public $ready = false;

    public function __construct($me, $current)
    {
        return;
        $this->API = $me;
        $this->current = $current;

        var_dump('OK');
    }

    public function __sleep()
    {
        return ['current', 'API', 'garbage'];
    }

    public function __destruct()
    {
        \danog\MadelineProto\Logger::log(['Shutting down reader pool '.$this->current], \danog\MadelineProto\Logger::NOTICE);
    }

    /**
     * Reading connection and receiving message from server. Check the CRC32.
     */
    public function run()
    {
        var_dump('BLOCK');
        while (true);
        require_once __DIR__.'/../SecurityException.php';
        require_once __DIR__.'/../RPCErrorException.php';
        require_once __DIR__.'/../ResponseException.php';
        require_once __DIR__.'/../TL/Conversion/Exception.php';
        require_once __DIR__.'/../TL/Exception.php';
        require_once __DIR__.'/../NothingInTheSocketException.php';
        require_once __DIR__.'/../Exception.php';

        $handler_pool = new \Pool($this->API->settings['threading']['handler_workers']);

        $this->ready = true;

        //while ($this->API->run_workers) {
           //try {
           //var_dump('READING');
             //   $this->API->recv_message($this->current);
            //    $handler_pool->submit(new SocketHandler($this->API, $this->current));
            //} catch (\danog\MadelineProto\NothingInTheSocketException $e) { \danog\MadelineProto\Logger::log(['Nothing in the socket for dc '.$this->current], \danog\MadelineProto\Logger::VERBOSE); }
        //}
        while ($number = $handler_pool->collect()) {
            \danog\MadelineProto\Logger::log(['Shutting down handler pool for dc '.$this->current.', '.$number.' jobs left'], \danog\MadelineProto\Logger::NOTICE);
        }
        $this->setGarbage();
    }

    public $garbage = false;

    public function setGarbage():void
    {
        $this->garbage = true;
    }

    public function isGarbage():bool
    {
        return $this->garbage;
    }
}
