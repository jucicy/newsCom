<?php
/**
 * Created by miaov.com - PHP之旅.
 * User: miaov
 * Details: 
 */
$insertCouponNumberArr = [];
if (($handle = fopen('testdata.csv', "r")) !== FALSE) {
    $key = 0;
    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
        if(is_numeric($data[0])&&$data[0]>120006){
            $insertCouponNumberArr[$key] = $data;
            $key++;
        }
    }
    fclose($handle);

    print_r($insertCouponNumberArr);
}