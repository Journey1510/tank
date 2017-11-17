<?php
/**
 * Created by PhpStorm.
 * User: think
 * Date: 2017/11/16
 * Time: 10:31
 */

class Tank
{
    private $speed;
    private $shell;
    private $hp;

    public function getSpeed()
    {
        return $this->speed ?? 0;
    }
}

