<?php

$gameState = array(
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

$gameEngine = array(
    mapFile => "",
    noOfTanks => 0,
    tankSpeed => 2,
    shellSpeed => 4,
    tankHP => 3,
    tankScore => 1,
    flagScore => 1,
    maxRound => 200,
    roundTimeout => 3000,
    playerAAddress => "",
    playerBAddress => "",

);

$player = array(
    name => "",
    tanks => array();//list id
noOfFlag =>
	);

$tank => array(
    id =>
        speed
    direction
    shellSpeed =>
    hp =>
    destroyed => false,
	);



