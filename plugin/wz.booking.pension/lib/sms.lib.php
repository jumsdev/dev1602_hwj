<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

class wz_sms extends SMS5 {

    private $od = array();

    function __construct($bk_ix) {
        
        global $g5;

        $bk_ix = (int)$bk_ix;
        $query = "select bk_ix, bk_status, bk_name, bk_price, bk_bank_account, bk_hp, bk_subject from {$g5['wzp_booking_table']} where bk_ix = '{$bk_ix}' ";
        $this->od = sql_fetch($query);

    }

    function wz_send() { 
        
        global $config, $g5, $sms5;
        $send_cnt = 0;

        $send_number = str_replace('-', '', trim($sms5['cf_phone'])); // 발송번호(발신번호 등록되어 있어야함)
        
        $str_msg = "";
		
        if($this->od['bk_status'] == "대기" || $this->od['bk_status'] == "예약대기"){
		    $add_text = "\n입금계좌 : ".$this->od['bk_bank_account']." ".number_format($this->od['bk_price'])."원\n예약 24시간 이내 입금 확인이 되지 않는경우 예약이 취소 될 수 있는점 양해바랍니다.";
		} else {
		    $add_text = "\n감사합니다.";
		}

        if ($config['cf_sms_type'] == 'LMS') {
            $arr_msg = array();
            $result = sql_query("select * from ".$g5['wzp_booking_room_table']." where bk_ix = '".$this->od['bk_ix']."'");
            while($row = sql_fetch_array($result)) { 
                $str_msg = "객실명 : ".$row['bkr_subject']."\n이용일자 : ".wz_get_hangul_date_md($row['bkr_frdate'])."(".get_yoil($row['bkr_frdate']).") ~ ".wz_get_hangul_date_md($row['bkr_todate'])."(".get_yoil($row['bkr_todate']).") ". $row['bkr_day']."박".($row['bkr_day']+1)."일\n인원 : ". $row['bkr_cnt_adult']."명 ".$add_text;
                $arr_msg[] = $str_msg;
            }
            $str_msg = implode("\n\n", $arr_msg);
        }

        $is_user = $is_adm = false;
        $sms_content_user = $sms_content_adm = '';
        $lms_subject_user = $lms_subject_adm = '';
        switch ($this->od['bk_status']) {
            case '대기':
            case '예약대기':
                $lms_subject_user = "{이름}님의 예약신청정보 입니다.";    
                $sms_content_user = "[".$config['cf_title']."] {이름}님 예약신청이 완료되었습니다.";
                if ($config['cf_sms_type'] == 'LMS') { // 객실상세정보
                    $sms_content_user .= "\n\n". $str_msg;
                } 
                $is_user = true;
            
                $lms_subject_adm  = "{이름}님의 예약신청정보 입니다.";
                $sms_content_adm = "{이름}님의 예약신청이 완료되었습니다. {연락처}";
                if ($config['cf_sms_type'] == 'LMS') { // 객실상세정보
                    $sms_content_adm .= "\n\n". $str_msg;
                } 
                $is_adm = true;
            break;
            case '완료':
            case '예약완료':
                $lms_subject_user = "{이름}님의 예약정보 입니다.";
                $sms_content_user = "[".$config['cf_title']."] {이름}님 예약이 완료되었습니다.";
                if ($config['cf_sms_type'] == 'LMS') { // 객실상세정보
                    $sms_content_user .= "\n\n". $str_msg;
                } 
                $is_user = true;
                
                $lms_subject_adm  = "{이름}님의 예약정보 입니다.";
                $sms_content_adm = "{이름}님의 예약이 완료되었습니다. {연락처}";
                if ($config['cf_sms_type'] == 'LMS') { // 객실상세정보
                    $sms_content_adm .= "\n\n". $str_msg;
                } 
                $is_adm = true;
            break;
            case '취소':
            case '예약취소':
                $lms_subject_user = "{이름}님의 예약취소정보 입니다.";    
                $sms_content_user = "[".$config['cf_title']."] {이름}님 예약이 취소되었습니다.";
                if ($config['cf_sms_type'] == 'LMS') { // 객실상세정보
                    $sms_content_user .= "\n\n". $str_msg;
                } 
                $is_user = true;
            
                $lms_subject_adm  = "{이름}님의 예약취소정보 입니다.";
                $sms_content_adm = "{이름}님의 예약신청이 취소되었습니다. {연락처}";
                if ($config['cf_sms_type'] == 'LMS') { // 객실상세정보
                    $sms_content_adm .= "\n\n". $str_msg;
                } 
                $is_adm = true;
            break;
        }

        if ($config['cf_sms_type'] == 'LMS')
            $port_setting = get_icode_port_type($config['cf_icode_id'], $config['cf_icode_pw']);
        else
            $port_setting = $config['cf_icode_server_port'];

        if (!$port_setting)
            $is_user = $is_adm = false;

        $this->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $port_setting);

        // 예약자
        if ($is_user) { 
            $lms_subject_user = str_replace('{이름}', $this->od['bk_name'], $lms_subject_user); // LMS 제목
            $sms_content_user = str_replace('{이름}', $this->od['bk_name'], $sms_content_user);
            $sms_content_user = str_replace('{예약금}', number_format($this->od['bk_price']), $sms_content_user);
            $recv_number    = get_hp($this->od['bk_hp'],0); // 예약자 수신
            $sms_content    = $sms_content_user;
           
            if ($config['cf_sms_type'] == 'LMS') {

                unset($strDest);
                $strDest     = array();
                $strDest[]   = $recv_number;
                $strCallBack = $send_number;
                $strCaller   = trim($config['cf_title']);
                $strSubject  = '';
                $strURL      = '';
                $strData     = $sms_content;
                $strDate     = '';
                $nCount      = 1;

                $this->Add($strDest, $strCallBack, $strCaller, $strSubject, $strURL, $strData, $strDate, $nCount);
                $this->send();
            }
            else {
                $sms_content = iconv_euckr($sms_content);
                $this->Add($recv_number, $send_number, '', $sms_content, '');  
            }

            $send_cnt++;
        }
       
        // 관리자
        if ($is_adm) { 
            $lms_subject_adm = str_replace('{이름}', $this->od['bk_name'], $lms_subject_adm); // LMS 제목
            $sms_content_adm = str_replace('{이름}', $this->od['bk_name'], $sms_content_adm);
            $sms_content_adm = str_replace('{연락처}', $this->od['bk_hp'], $sms_content_adm);
            $sms_content_adm = str_replace('{예약금}', number_format($this->od['bk_price']), $sms_content_adm);
            $recv_number    = get_hp($send_number,0);
            $sms_content    = $sms_content_adm;

            if ($config['cf_sms_type'] == 'LMS') {

                unset($strDest);
                $strDest     = array();
                $strDest[]   = $recv_number;
                $strCallBack = $send_number;
                $strCaller   = trim($config['cf_title']);
                $strSubject  = $lms_subject_adm;
                $strURL      = '';
                $strData     = $sms_content;
                $strDate     = '';
                $nCount      = 1;

                $this->Add($strDest, $strCallBack, $strCaller, $strSubject, $strURL, $strData, $strDate, $nCount);
                $this->send();
            }
            else {
                $sms_content = iconv_euckr($sms_content);
                $this->Add($recv_number, $send_number, '', $sms_content, '');  
            }

            $send_cnt++;
        }

        if ($config['cf_sms_type'] != 'LMS') {
            $this->send();
        }

        $this->Init();

    } 

}

?>                                       