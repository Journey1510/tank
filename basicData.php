<?php
/**
 * Created by PhpStorm.
 * User: think
 * Date: 2017/11/15
 * Time: 16:52
 */

class  Basic_Data
{
    private $gameState;
    private $tanks;
    private $shells;
    private $yourFlags;
    private $enemyFlags;

    private $noOfTanks;
    private $TSpeed;
    private $SSpeed;

    private $file = "gameState.txt";
    private $gameData = array(
        'tanks' => array(
            array('id' => 0,
                'position' => array(
                    'x' => 0,
                    'y' => 0,
                ),
                'direction' => 1,
                'hp' => 3),
            array('id' => 1,
                'position' => array(
                    'x' => 1,
                    'y' => 1,
                ),
                'direction' => 1,
                'hp' => 3),
        ),
        'shells' => array(
            array('id' => 0,
                'position' => array(
                    'x' => 0,
                    'y' => 0,
                ),
                'direction' => 1,),
            array('id' => 1,
                'position' => array(
                    'x' => 1,
                    'y' => 1,
                ),
                'direction' => 1,),
        ),
        'yourFlags' => 3,
        'enemyFlags' => 2,
    );

    public function saveGameState ()
    {
        $file = "ganmeState.txt";

        file_put_contents($file, $this->getGameData() );
    }

    public function getGameData()
    {
        //调接口
    }


    private function initialize ()
    {
        $this->noOfTanks = count($this->tanks);
        $this->TSpeed = $this->tanks[0]->getSpeed();
        $this->SSpeed = $this->shells[0]->getSpeed();
    }

    public function getGameStateInfo ()
    {
        $this->gameState = "";
        $this->tanks = array();
        $this->shells = array();
        $this->yourFlags = 0;
        $this->enemyFlags = 0;
    }

    public function getTankSpeed ()
    {
        return $this->TSpeed ?? 0;
    }

    public function getShellSpeed ()
    {
        return $this->SSpeed ?? 0;
    }

    public function separateTanks ()
    {
        //划分我方，敌方坦克
    }

    public function sortTanksByHP ()
    {
        $yourResult = array_multisort(array_column($this->tanks,'hp'),SORT_ASC, $this->tanks);

        $enemyResult = [];
    }


    public function getHpById (int $id)
    {
        if (array_key_exists($id,$this->tanks))
        {
            return $this->tanks[$id]['hp'];
        }
        return 0;
    }

    public function getYourFlags ()
    {
        return $this->yourFlags ?? 0;
    }

    public function getEnemyFlags ()
    {
        return $this->enemyFlags ?? 0;
    }
}