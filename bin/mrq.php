<?php

$ch = curl_init();

$startTime = time();
echo "sTime: ".date('d/m/Y H:i:s', $startTime)."\n";
$i = 0;
$authorization = "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1NjcxNzcyODYsImV4cCI6MTU2NzE4MDg4Niwicm9sZXMiOlsiUk9MRV9VU0VSIl0sImVtYWlsIjoiZ2lsYmVydDI5QG5ndXllbi5mciJ9.QL6T37GQlWRROCcVmr6LiJknLysOoe_68euSS6kAv_1S4j9qw3CuA294Y5NZSVR1RXmpqfZQ8zK76NKdznHXQ5-U1A1JFXjQhOzk_2GVhdeiXa-Twr4xkIzv0LZTW931-_9eFUabTjIodrgy_kB_JPR1Z2XVe5mTGswqV7LHNClgjTZEtrm01-ioU-WLNXrQJkXEEO1APH3HXLRRrjrWyAZdZpZikB9Xeny6177O91q9Hb8P5rhxIsoIxWfwrfCdBtMDBA72KIjd0LSV-kdxJ0EZugUZJjMPuSIb2CXl3HhnYUUULhgYpo1Dntn37qIEk4mTlk0CeGhBmrTPPWtjhH74HeVQa13Z5WDfSfFX5g8Txlo81EMUDFDuo_TF1BM9GgkqvyC5DJoMPB3F9BF92qgH0fZrPvB3UiOuYQrMgv8J5or_bLtuEPbFXrNt-OBVo0VNyQi9GSPqOwlj_a3C4EIVbAwrrr6gfveYY5ctHvkgh4eaKgBe0qH-MKcCaGxIc9AZncJulov1mHzU_kCgqWC3NBGHUR8y132riVitYonkD95GHSDRzJANXu58mms42vf6bWXyuFyI9ty-GCrG0-a_cBV_mKYzbFtE0xv4tEpIpTpwL8rlsK-2CTB7_jQG2PE-TL8eCu_zEIdgMeoJ2TsXZbWy_eQVsy_qQvsHIDc";
while ($i < 100) {
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization));
    curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/products/303');

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($ch);
    $i++;
}
curl_close($ch);
$endTime = time();

$totalTime = $endTime - $startTime;
echo $totalTime . ' s (end time = ' . date('d/m/Y H:i:s', $endTime) . ')';