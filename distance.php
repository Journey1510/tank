<?php

function getDistance(array $map, int $x1, int $y1, int $x2, int $y2)
{
    //changeMapBarrier($map, $tankPos);地图障碍处理
    //if() 坐标校验


}

/**
 * 将坦克位置转换成障碍
 * @param array $map
 * @param array $tankPo
 */
function changeMapBarrier(array &$map, array $tankPos)
{
    if(!$tankPos)
    {
        foreach ($tankPos as $tankPo)
        {
            $map[$tankPo['x']][$tankPo['y']] = 1;
        }
    }
}