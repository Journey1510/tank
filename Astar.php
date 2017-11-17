<?php
include "Node.php";

class Astar
{
    public $map =
        [
            [0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 1, 0, 0, 0, 0, 0],
            [0, 0, 0, 1, 0, 0, 0, 0, 0],
            [0, 0, 0, 1, 0, 0, 0, 0, 0],
            [0, 0, 0, 1, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0, 0, 0, 0, 0],
        ];

    const STEP = 1;

    private $openList = [];
    private $closeList = [];

    public function findMinFNodeInOpneList ()
    {
        $tempNode = $this->openList[0];
        foreach ($this->openList as $node)
        {
            if($node->f < $tempNode->f)
            {
                $tempNode = $node;
            }
        }

        return $tempNode;
    }

    public function findNeighborNodes (Node $currentNode)
    {
        $result = [];
        $topX = $currentNode->x;
        $topY = $currentNode->y - 1;
        if($this->canReach($topX,$topY) && !$this->exists($this->closeList, $topX, $topY))
        {
            $result[] = new Node($topX,$topY);
        }

        $bottomX = $currentNode->x;
        $bottomY = $currentNode->y + 1;
        if($this->canReach($bottomX,$bottomY) && !$this->exists($this->closeList, $bottomX, $bottomY))
        {
            $result[] = new Node($bottomX,$bottomY);
        }

        $leftX = $currentNode->x - 1;
        $leftY = $currentNode->y;
        if($this->canReach($leftX,$leftY) && !$this->exists($this->closeList, $leftX, $leftY))
        {
            $result[] = new Node($leftX,$leftY);
        }

        $rightX = $currentNode->x + 1;
        $rightY = $currentNode->y;
        if($this->canReach($rightX,$rightY) && !$this->exists($this->closeList, $rightX, $rightY))
        {
            $result[] = new Node($rightX,$rightY);
        }

        return $result;
    }

    public function findPath (Node $startNode, Node $endNode)
    {
        $this->openList[] = $startNode;

        while(!empty($this->openList))
        {
            $currentNode = $this->findMinFNodeInOpneList();

            $k = array_search($currentNode, $this->openList);
            if($k !== false)
            {
                array_splice($this->openList, $k);
            }

            $this->closeList[] = $currentNode;

            $neighborNodes = $this->findNeighborNodes($currentNode);
            foreach ($neighborNodes as $node)
            {
                if($this->exists($this->openList, $node->x, $node->y))
                {
                    $this->foundPoint($currentNode, $node);
                } else
                {
                    $this->notFoundPoint($currentNode,$endNode,$node);
                }
            }
            if($this->find($this->openList, $endNode) != null)
            {
                return $this->find($this->openList, $endNode);
            }
        }
        return $this->find($this->openList, $endNode);
    }

    public function notFoundPoint(Node $tempStart,Node $end, Node $node)
    {
        $node->parent = $tempStart;
        $node->g = $this->calcG($tempStart,$node);
        $node->h = $this->calcH($end,$node);
        $node->caclF();
        $this->openList[] = $node;
    }

    public function foundPoint(Node $tempStart, Node $node)
    {
        $g = $this->calcG($tempStart, $node);
        if($g < $node->g)
        {
            $node->parent = $tempStart;
            $node->g = $g;
            $node->caclF();
        }

    }

    public function calcG(Node $start, Node $node)
    {
        $g = self::STEP;
        $parentg = $node->parent->g ?? 0;
        return $parentg + $g;
    }

    public function calcH(Node $end, Node $node)
    {
        $step = abs($node->x - $end->x) + abs($node->y - $end->y) ;

        return $step * self::STEP;
    }

    public function canReach (int $x,int $y)
    {
        if($x >=0 && $x < count($this->map) && $y >=0 && $y < count($this->map))
        {
            return $this->map[$x][$y] == 0;
        }
        return false;
    }

    public function exists (array $nodes,int $x,int $y)
    {
        foreach ($nodes as $node)
        {
            if (($node->x == $x) && ($node->y == $y))
            {
                return true;
            }
        }
        return false;
    }

    public function find (array $nodes, Node $node)
    {
        foreach ($nodes as $n)
        {
            if(($n->x == $node->x) && ($n->y == $node->y))
            {
                return $n;
            }
        }
        return null;
    }

    public function getShortestStep (Node $start, Node $end)
    {
        $path = [];
        $parent = $this->findPath($start,$end);

        while ($parent != null)
        {
            $path[] = $parent;
            $parent = $parent->parent;
        }

        return count($path) - 1;
    }

    public function show ()
    {
        $start = new Node(5,1);
        $end = new Node(5,5);

        $size = count($this->map);

        for($i = 0; $i<$size; $i++){
            for($j = 0; $j<$size; $j++){
                echo $this->map[$i][$j] . " ";
            }
            echo "\n";
        }

        $path = [];
        $parent = $this->findPath($start,$end);

        while ($parent != null)
        {
            $path[] = $parent;
            $parent = $parent->parent;
        }

        echo "\n";

        for($i = 0; $i<$size; $i++){
            for($j = 0; $j<$size; $j++){
                if($this->exists($path, $i, $j))
                {
                    echo "* ";
                }
                else
                {
                    echo $this->map[$i][$j] . " ";
                }
            }
            echo "\n";
        }
    }

}

$test = new Astar();

$test->show();