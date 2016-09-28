<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
<!--link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet"-->
<link rel="stylesheet" href="<?php echo $latest_skin_url ?>/css/juicyslider.css" type="text/css" />
<style type="text/css">

	/* Not required for template or sticky footer method. */
	#bannerwrap > .bcontainer {
		padding-bottom: 60px;
	}
	.bcontainer{width:1100px}		/* content size */
	#myslider{margin:0 auto;}
</style>
<!-- Part 1: Wrap all page content here -->
        <div id="bannerwrap">
			<!-- Begin page content -->
            <div class="bcontainer">
                        <div id="myslider" class="juicyslider">
                            <ul>
<?							for ($i=0; $i<count($list); $i++) {
									$noimage = "$latest_skin_url/images/1.jpg";
									$list[$i][file] =get_file($bo_table, $list[$i][wr_id]);
									$imagepath = $list[$i][file][0][path]."/".$list[$i][file][0][file];
?>									<li><img src="<?echo $imagepath ?>" alt=""></li>
<?							}
?>
                            </ul>
                            <!--div class="mnav next"></div>
                            <div class="mnav prev"></div>
                            <div class="mask"></div-->
                        </div>
                    </div>
                </div>


        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>
        <!--script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script-->
        <script type="text/javascript" src="<?php echo $latest_skin_url ?>/js/juicyslider.js"></script>
        <!-- initialize Juicy Slider with a jQuery doc ready -->
        <script type="text/javascript">
            // start to run when document ready
             $(function() {
                $('#myslider').juicyslider({
                    width: '1100px',
                    height: 645,
                    mask: 'strip',
                    show: {effect: 'fade', duration: 2000},
                    hide: {effect: 'fade', duration: 2000},
                });
            });
        </script>
        <!-- end of Juicy Slider -->

<!-- } <?php echo $bo_subject; ?> 최신글 끝 -->
