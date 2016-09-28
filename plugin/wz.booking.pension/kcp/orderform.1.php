<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<script type="text/javascript">
/****************************************************************/
/* m_Completepayment  설명                                      */
/****************************************************************/
/* 인증완료시 재귀 함수                                         */
/* 해당 함수명은 절대 변경하면 안됩니다.                        */
/* 해당 함수의 위치는 payplus.js 보다먼저 선언되어여 합니다.    */
/* Web 방식의 경우 리턴 값이 form 으로 넘어옴                   */
/* EXE 방식의 경우 리턴 값이 json 으로 넘어옴                   */
/****************************************************************/
function m_Completepayment( FormOrJson, closeEvent )
{
    var frm = document.wzfrm;

    /********************************************************************/
    /* FormOrJson은 가맹점 임의 활용 금지                               */
    /* frm 값에 FormOrJson 값이 설정 됨 frm 값으로 활용 하셔야 됩니다.  */
    /* FormOrJson 값을 활용 하시려면 기술지원팀으로 문의바랍니다.       */
    /********************************************************************/
    GetField( frm, FormOrJson );

    if( frm.res_cd.value == "0000" )
    {
        document.getElementById("display_pay_button").style.display = "none" ;
        document.getElementById("display_pay_process").style.display = "" ;
        
        frm.action = "<?php echo $action_url;?>";
        frm.submit();
    }
    else
    {
        alert( "[" + frm.res_cd.value + "] " + frm.res_msg.value );

        closeEvent();
    }
}
function pg_pay(f) {

    f.site_cd.value = f.def_site_cd.value;
    f.payco_direct.value = "";

    var payment = $(":input:radio[name=bk_payment]:checked").val();
    switch(payment)
    {
        case "계좌이체":
            f.pay_method.value   = "010000000000";
            break;
        case "가상계좌":
            f.pay_method.value   = "001000000000";
            break;
        case "휴대폰":
            f.pay_method.value   = "000010000000";
            break;
        case "신용카드":
            f.pay_method.value   = "100000000000";
            break;
        case "간편결제":
            <?php if($wzpconfig['pn_pg_test']) { ?>
            f.site_cd.value      = "S6729";
            <?php } ?>
            f.pay_method.value   = "100000000000";
            f.payco_direct.value = "Y";
            break;
        default:
            f.pay_method.value   = "무통장";
            break;
    }

    f.buyr_name.value = f.bk_name.value;
    f.buyr_mail.value = f.bk_email.value;

    var buyr_tel1 = f.bk_hp1.value +'-'+ f.bk_hp2.value +'-'+ f.bk_hp3.value;
    f.buyr_tel1.value = buyr_tel1;

    if(f.pay_method.value != "무통장") {
        return jsf__pay( f );
    } else {
        return true;
    }

}
</script>

<script src="<?php echo $g_conf_js_url; ?>"></script>
<script>
/* Payplus Plug-in 실행 */
function jsf__pay( form )
{
    try
    {
        KCP_Pay_Execute( form );
    }
    catch (e)
    {
        /* IE 에서 결제 정상종료시 throw로 스크립트 종료 */
    }
}
</script>
