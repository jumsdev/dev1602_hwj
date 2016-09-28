<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if ($wzpconfig['pn_pg_test']) {
    $wzpconfig['pn_pg_mid'] = "T0000";
    $wzpconfig['pn_pg_site_key'] = '3grptw1.zW0GSo4PQdaGvsF__';
    $g_conf_js_url = 'https://testpay.kcp.co.kr/plugin/payplus_web.jsp';
}
else {
    $g_conf_js_url = 'https://pay.kcp.co.kr/plugin/payplus_web.jsp';
}

$g_conf_home_dir  = WZP_PLUGIN_PATH.'/kcp';
$g_conf_key_dir   = '';

/*=======================================================================
 KCP 결제처리 로그파일 생성을 위한 로그 디렉토리 절대 경로를 지정합니다.
 로그 파일의 경로는 웹에서 접근할 수 없는 경로를 지정해 주십시오.
 영카트5의 config.php 파일이 존재하는 경로가 /home/youngcart5/www 라면
 로그 디렉토리는 /home/youngcart5/log 등으로 지정하셔야 합니다.
 로그 디렉토리에 쓰기 권한이 있어야 로그 파일이 생성됩니다.
=======================================================================*/
$g_conf_log_dir   = '/home100/kcp'; // 존재하지 않는 경로를 입력하여 로그 파일 생성되지 않도록 함.

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
{
    $g_conf_key_dir   = G5_SHOP_PATH.'/kcp/bin/pub.key';
}

$g_conf_site_cd  = $wzpconfig['pn_pg_mid'];
$g_conf_site_key = $wzpconfig['pn_pg_site_key'];

// 테스트 결제 때 PAYCO site_cd, site_key 재설정
if($wzpconfig['pn_pg_test'] && isset($_POST['bk_payment']) && $_POST['bk_payment'] == '간편결제') {
    $g_conf_site_cd = 'S6729';
    $g_conf_site_key = '';
}

if (preg_match("/^T000/", $g_conf_site_cd) || $wzpconfig['pn_pg_test']) {
    $g_conf_gw_url  = "testpaygw.kcp.co.kr";                    // real url : paygw.kcp.co.kr , test url : testpaygw.kcp.co.kr
}
else {
    $g_conf_gw_url  = "paygw.kcp.co.kr";
}

$g_conf_site_name = $config['cf_title'];
$g_conf_log_level = '3';           // 변경불가
$g_conf_gw_port   = '8090';        // 포트번호(변경불가)
$module_type      = '01';          // 변경불가
?>
