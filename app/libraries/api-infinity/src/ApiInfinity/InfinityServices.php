<?php

namespace ApiInfinity;

class InfinityServices
{
    protected $url = 'http://localhost:8080';

    protected $app_name = 'infinity_sistema';

    private $app_password = '230879';

    public function getTk()
    {
        return md5($this->app_name.date('Y').date('m').date("d").date("H").$this->app_password);
    }
}

?>