<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/tail.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/tail.php');
    return;
}
?>

    </div>
</div>

<!-- } 콘텐츠 끝 -->

<hr>

<!-- 하단 시작 { -->
<div id="ft">
    <div id="ft_copy">
        <div class="graylogo"><img src="<?php echo G5_IMG_URL ?>/gray_logo.png" /></div>
        <div class="copyright">
        주소 : 충남 청양군 남양면 나래미길 60-4 (봉암리 150-13)&nbsp;&nbsp;&nbsp;  대표 : 고 동 미 &nbsp;&nbsp;&nbsp; 사업자등록번호 : 220-19-00232<br>
        고객문의 : 010.6484.8764 / 010.5283.8764 &nbsp;&nbsp;&nbsp;Copyright &copy; <b>방기옥가옥</b> All rights reserved.
            <a href="#hd" id="ft_totop">상단으로</a>
        </div>
    </div>
</div>

<!--?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
<a href="<?php echo get_device_change_url(); ?>" id="device_change">모바일 버전으로 보기</a>
<!--?php
}

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<!-- } 하단 끝 -->

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_PATH."/tail.sub.php");
?>