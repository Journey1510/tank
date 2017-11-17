<?php

class Node
{
    public $x;
    public $y;

    public $f =0;
    public $g =0;
    public $h =0;
    public $parent;

    public function __construct (int $x,int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function caclF ()
    {
        $this->f = $this->g + $this->h;
    }
}


