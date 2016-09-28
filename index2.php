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
<? echo latest("scroller", "room",5,25); ?>
</div>
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