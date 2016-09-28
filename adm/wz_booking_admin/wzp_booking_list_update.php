<?php
$sub_menu = '780300';
include_once('./_common.php');
include_once(G5_PLUGIN_PATH.'/wz.booking.pension/config.php');
include_once(G5_PLUGIN_PATH.'/wz.booking.pension/function.lib.php');

check_demo();

if (!count($_POST['chk'])) {
    alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if ($_POST['act_button'] == "선택삭제") {

    auth_check($auth[$sub_menu], 'w');

    for ($i=0; $i<count($_POST['chk']); $i++) {

        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];
        $bkix = (int)$_POST['bk_ix'][$k];
        
        // 객실상태정보 삭제
        $sql = " delete from {$g5['wzp_room_status_table']} where bk_ix = '".$bkix."' ";
        sql_query($sql);
        
        // 객실예약룸정보 삭제
        $sql = " delete from {$g5['wzp_booking_room_table']} where bk_ix = '".$bkix."' ";
        sql_query($sql);

        // 객실예약정보 삭제
        $sql = " delete from {$g5['wzp_booking_table']} where bk_ix = '".$bkix."' ";
        sql_query($sql);
    }

}
else if ($_POST['act_button'] == "선택예약완료") {

    auth_check($auth[$sub_menu], 'w');

    for ($i=0; $i<count($_POST['chk']); $i++) {

        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];
        $bkix = (int)$_POST['bk_ix'][$k];

        // 객실예약정보 변경
        $sql = " update {$g5['wzp_booking_table']} set bk_status = '완료' where bk_ix = '".$bkix."' ";
        sql_query($sql);
		
		// 객실상태정보 변경 2016.05.13추가
		$query = "update {$g5['wzp_room_status_table']} set rms_status = '완료' where bk_ix = '".$bkix."' ";
         sql_query($query);
    }

}
else if ($_POST['act_button'] == "선택예약취소") {

    auth_check($auth[$sub_menu], 'w');

    for ($i=0; $i<count($_POST['chk']); $i++) {

        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];
        $bkix = (int)$_POST['bk_ix'][$k];
        
        // 객실예약정보 변경
        $sql = " update {$g5['wzp_booking_table']} set bk_status = '취소' where bk_ix = '".$bkix."' ";
        sql_query($sql);
		
		//객실상태정보 변경 2016.05.13추가
		$query = "update {$g5['wzp_room_status_table']} set rms_status = '취소' where bk_ix = '".$bkix."' ";
        sql_query($query);
    }

}
else if ($_POST['act_button'] == "선택예약대기") {

    auth_check($auth[$sub_menu], 'w');

    for ($i=0; $i<count($_POST['chk']); $i++) {

        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];
        $bkix = (int)$_POST['bk_ix'][$k];
        
        // 객실예약정보 변경
        $sql = " update {$g5['wzp_booking_table']} set bk_status = '대기' where bk_ix = '".$bkix."' ";
        sql_query($sql);
		
		// 객실상태정보 변경  2016.05.13추가
        $query = "update {$g5['wzp_room_status_table']} set rms_status = '대기' where bk_ix = '".$bkix."' ";
        sql_query($query);
    }

}

if ($_POST['act_button'] == "선택예약완료" || $_POST['act_button'] == "선택예약취소" || $_POST['act_button'] == "선택예약대기") {

    include_once(G5_SMS5_PATH.'/sms5.lib.php');
    include_once(WZP_PLUGIN_PATH.'/lib/sms.lib.php');
    for ($i=0; $i<count($_POST['chk']); $i++) {
        // 실제 번호를 넘김
        $k = $_POST['chk'][$i];
        $bkix = (int)$_POST['bk_ix'][$k];
        $wzsms = new wz_sms($bkix);
        $wzsms->wz_send();
    }
}

goto_url('./wzp_booking_list.php?'.$qstr);
?>
