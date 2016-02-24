<?php
//希尔排序算法3
function shellSort( &$arrSrc ) {
    $len = count( $arrSrc );
    $h = 1;
    while ( $h < $len / 3 ) {
        $h = 3*$h + 1;
    }
    while ( $h>=1 ) {
        //通过小规模插入排序 控制 间隔h的数组元素相对有序
        for( $i=$h;$i<$len;$i++){
            for( $j=$i;$j>=$h && $arrSrc[$j]<$arrSrc[$j-$h]; $j=$j-$h){
                $tmp = $arrSrc[$j];
                $arrSrc[$j] = $arrSrc[$j-$h];
                $arrSrc[$j-$h] = $tmp;
            }
        }
        //控制间隔H 实现小规模继续有序
        $h = intval($h/3);
    }
}


$arr = [ 3,5,6,7,8,9,21,1,0,-1 ];
shellSort($arr);
var_dump($arr);
