<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head_main.php');
?>
<div id="mthumb">
<?php 
$hp_imgwidth = "300";  // 표시할 이미지의 가로사이즈 
$hp_imgheight  = "200";  // 표시할 이미지의 세로사이즈 
$hp_minSlides = "3";  // 슬라이드 최소개수 
$hp_maxSlides = "5" ;  // 슬라이드 최대개수 
$hp_slideMargin = "40";  // 슬라이드 이미지 간격 
echo latest("hp5_slidersjs", "room", 5, 20, 1, "$hp_imgwidth, $hp_imgheight, $hp_minSlides, $hp_maxSlides, $hp_slideMargin"); 
?></div>
<div><img src="<?php echo G5_IMG_URL ?>/call.png" /></div>
<!--최신글/퀵메뉴-->
<div id="mcontent">
   <div id="latest_notice">
       <?php
        // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
        // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
        // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
        echo latest("theme/basic", notice, 5, 25);
        ?>
   </div>
   <div id="quickmenu">
        <ul><li><a href="<?php echo G5_BBS_URL ?>/content.php?co_id=menu02B"><img src="<?php echo G5_IMG_URL ?>/quick_menu3.png" /></a></li>
        <li><a href="<?php echo G5_BBS_URL ?>/content.php?co_id=menu04"><img src="<?php echo G5_IMG_URL ?>/quick_menu1.png" /></a></li>
         <li><a href="<?php echo G5_BBS_URL ?>/content.php?co_id=menu04A"><img src="<?php echo G5_IMG_URL ?>/quick_menu2.png" /></a></li>
        </ul>
   </div>
</div>
<?php
include_once(G5_THEME_PATH.'/tail.php');
?>