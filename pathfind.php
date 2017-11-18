<?php
/**
 * Created by PhpStorm.
 * User: think
 * Date: 2017/11/18
 * Time: 12:56
 */

include "Astar.php";
include "Node.php";

class Path_Find
{
    public $map;
    public $flagPosition;
    public $tanks;
    public $mytanks;

    public $tankSpeed;
    private $astar;

    /**
     * 初始化tank map等信息
     * Path_Find constructor.
     */
    public function __construct()
    {
        $this->astar = new Astar();
        //$this->map = //getMap()
    }

    public function getTanksOrder(Node $end)
    {
        $orders = [];
        $paths = [];
        $nexts = [];
        //$this->tanks = Updatetanks();更新tank信息
        $tempMap = $this->map;
        $this->changeMapBarrier($tempMap, $this->tanks);

        //求路径
        foreach ($this->mytanks as $tank)
        {
            $start = new Node($tank->pos->x, $tank->pos->y);

            $paths[$tank->id] = $this->getPath($tempMap,$start,$end);
        }

        $times = 1;
        while($times <= count($this->mytanks))
        {
            foreach ($nexts as $key => $node)
            {
                foreach ($this->tanks as &$t)
                {
                    if($t->id == $key)
                    {
                        $t->pos->x = $node->x;
                        $t->pos->y = $node->y;
                    }
                }
            }

            $tempMap = $this->map;
            $this->changeMapBarrier($tempMap, $this->tanks);

            //如果有路径，获得指令
            foreach ($this->mytanks as $tank)
            {
                if(!empty($paths[$tank->id]))
                {
                    $orders[$tank->id] = $this->getOrderByPath($tempMap, $paths[$tank->id],$tank,$nexts);
                }
            }
        }

        return $orders;
    }

    private function getOrderByPath ($tempMap, $path, $tank,&$nexts)
    {

        $fir = $path[count($path)-1];
        $sec = $path[count($path)-2];
        $xdiff = $sec->x - $fir->x;
        $ydiff = $sec->y - $fir->y;

        if(($xdiff > 0) && ($tank->dir == 2) )
        {
            for ($i = 1; $i <= $this->tankSpeed; $i++)
            {
                if($tempMap[$fir->x + $i][$fir->y] == 1)
                {
                    $nexts[$tank->id] = new Node($fir->x + $i - 1, $fir->y);
                    break;
                }
            }
            $nexts[$tank->id] = new Node($fir->x + $this->tankSpeed, $fir->y);
            return "move";
        }
        if(($xdiff > 0) && ($tank->dir != 2))
        {
            switch ($tank->dir)
            {
                case 1 :
                    return "掉头";
                case 3 :
                    return "左转";
                case 4 :
                    return "右转";
            }
        }

        if(($xdiff < 0) && ($tank->dir == 1) )
        {
            for ($i = 1; $i <= $this->tankSpeed; $i++)
            {
                if($tempMap[$fir->x - $i][$fir->y] == 1)
                {
                    $nexts[$tank->id] =  new Node($fir->x - $i + 1, $fir->y);
                    break;
                }
            }
            $nexts[$tank->id] =  new Node($fir->x - $this->tankSpeed, $fir->y);
            return "move";
        }
        if(($xdiff < 0) && ($tank->dir != 1))
        {
            switch ($tank->dir)
            {
                case 2 :
                    return "掉头";
                case 4 :
                    return "左转";
                case 3 :
                    return "右转";
            }
        }

        if(($ydiff > 0) && ($tank->dir == 4) )
        {
            for ($i = 1; $i <= $this->tankSpeed; $i++)
            {
                if($tempMap[$fir->x][$fir->y + $i] == 1)
                {
                    $nexts[$tank->id] =  new Node($fir->x , $fir->y + $i - 1);
                    break;
                }
            }
            $nexts[$tank->id] =  new Node($fir->x , $fir->y + $this->tankSpeed);
            return "move";
        }
        if(($ydiff > 0) && ($tank->dir != 4))
        {
            switch ($tank->dir)
            {
                case 3 :
                    return "掉头";
                case 2 :
                    return "左转";
                case 1 :
                    return "右转";
            }
        }

        if(($ydiff < 0) && ($tank->dir == 3) )
        {
            for ($i = 1; $i <= $this->tankSpeed; $i++)
            {
                if($tempMap[$fir->x ][$fir->y - $i] == 1)
                {
                    $nexts[$tank->id] =  new Node($fir->x , $fir->y - $i + 1);
                    break;
                }
            }
            $nexts[$tank->id] =  new Node($fir->x , $fir->y - $this->tankSpeed);
            return "move";
        }
        if(($ydiff < 0) && ($tank->dir != 3))
        {
            switch ($tank->dir)
            {
                case 4 :
                    return "掉头";
                case 1 :
                    return "左转";
                case 2 :
                    return "右转";
            }
        }
        return null;
    }

    public function getPath($tempMap, Node $start, Node $end)
    {
        //if() 坐标校验
        $this->astar->map = $tempMap;
        $path = $this->astar->getShortestPath($start, $end);

        return $path;
    }

    /**
     * 将坦克位置转换成障碍
     * @param array $map
     * @param array $tankPo
     */
    public function changeMapBarrier(array &$tmap, array $tanks)
    {
        if(!$tanks)
        {
            foreach ($tanks as $tank)
            {
                $tmap[$tank->x][$tank->y] = 1;
            }
        }
    }
}