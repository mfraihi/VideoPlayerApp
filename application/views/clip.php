<meta name="twitter:image" content="<?php echo $clip_thumbnail?>">
<meta name="twitter:title" content="DishClips: <?php echo $dish_name?> at <?php echo $restaurant_name?>">
<meta name="twitter:description" content="Check out this DishClip">

	<!--facebook like button-->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=226263367428796";
	fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>
	
<link rel="image_src" href="<?= $clip_thumbnail?>" / >
<span class="container-fluid">
    <span class="row-fluid">
	<span class="span8 offset2" id="my_content_span">
		<div id="clip_card">
			<h1 style="font-size: 76px; line-height: 1.2;"><?= $dish_name?></h1>
		    	at <a href="<?= site_url('restaurant/'. $restaurant_id);?>"><?= $restaurant_name?></a> in <span style="font-weight: bold; color: #636363;"><?= $restaurant_city?>, <?= $restaurant_state; ?></span>
		</div>
			
		<table class="table" id="restaurant_info">
			<tr>
				<td colspan="3" id="clip_area" style="text-align: center;">
					<table class="borderless">
							<tr>
								<td style="width: 15%; text-align: center; vertical-align: top;">
									<div class="fb-like" data-send="true" data-layout="box_count" data-width="100" data-show-faces="true" data-font="arial"></div>
									
									<br><br>
									
									<a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php echo $tweet_msg;?>" data-url="<?php echo $short_url; ?>" data-via="DishClips" data-lang="en" data-related="anywhereTheJavascriptAPI" data-count="vertical">Tweet</a>
									<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
									
									<br><br>
										
									<div class="g-plus" data-action="share" data-annotation="vertical-bubble" data-height="60"></div>									
									
									<script type="text/javascript">
									  (function() {
									    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
									    po.src = 'https://apis.google.com/js/plusone.js';
									    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
									  })();
									</script>
								</td>
								
								<td style="text-align: center; width: 70%;">
									<?php if($isMobile):?>
										<div style="margin-top:30px;"><center><video id="DishClips" class="video-js vjs-default-skin" controls width="480" height="360" poster="<?= $clip_thumbnail;?>" preload="auto" data-setup="{}">  <source type="video/mp4" src="<?= $clip_url;?>"></video></center>
									<?php else:?>
										<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="480" height="360">
											<param name="movie" value="http://flash.webestools.com/flv_player/v1_27.swf"><param name="quality" value="high"><param name="bgcolor" value="#000000">
											<param name="allowScriptAccess" value="always"><param name="allowFullScreen" value="true"><param name="wmode" value="transparent">
											<param name="flashvars" value="fichier=<?= $clip_url?>&amp;apercu=<?= $clip_thumbnail?>">
											<embed src="http://flash.webestools.com/flv_player/v1_27.swf" width="480" height="360" quality="high" bgcolor="#000000" allowscriptaccess="always" allowfullscreen="true" wmode="transparent" flashvars="fichier=<?= $clip_url?>&apercu=<?= $clip_thumbnail?>" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer">
										</object>
									<?php endif;?>
								</td>
								
								<td style="width: 15%; text-align: center; vertical-align: top;">
									 <div>
<<<<<<< HEAD
						<div class="heart"><?php echo $dish_rating; ?></div>
=======
									    <img   src="<?= $user_image_url?>" class="user_image"/>
									    <a href="<?= site_url('user/' . $user_id);?>"><?= $user_name ?></a>
									    <br>
										<small>uploaded <?= $create_time?></small>
										<br><br<br><br>
						<div class="heart"><?= $dish_rating; ?></div>
>>>>>>> 5ac900d0bcc4d9996b2ae96f5212299e9d734e74
						<br>
						<span style="font-weight: bold; color: #bd8c94;">Average Rating</span>
					    </div>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<!--<tr>
	        			<td align="center">
							<!--share buttons
					</td>
				</tr>-->
				
				<tr>
	        			<td align="center" colspan="3" style="display: none;">
						<?php foreach($comments_list as $comment): ?>
						    <table class="comment_box" style="bac/jwplayer/ground: #f7f7f7; border: 1px  dotted;">
							<tr>
							    <td style="width: 10%; text-align: center;">
								<img src="<?php echo $comment['image_url']?>" style='width: 65px; height: 65px;' />
								<br>
								<?php echo $comment['name']; ?>
							    </td>
							    
							    <td>
								<?php echo $comment['message']; ?>
							    </td>
							</tr>
						    </table>
						<?php endforeach; ?>
					</td>
				</tr>
				
				<!--other clips of same dish-->
				<?php if(count($clips_list) > 1): ?>
				<tr>
				    <td colspan="3">
					<table class="borderless">
					    <tr>
						<td style="text-align: left;">
						    <h5>Other clips of <?php echo $dish_name; ?>:</h5>
						    <?php _print_clips($clips_list, $clip_id); ?>
						</td>
					    
					    </tr>
					</table>
			    	    </td>
				</tr>
				<?php endif;?>
				
				<!--other dishes from restaurant-->
				<tr>
				    <td colspan="3">
					<table class="borderless">
					    <thead>
						<td colspan="4">
						    <h4>Discover other dishes from <?php echo $restaurant_name; ?>:</h4>
						</td>
					    </thead>
<<<<<<< HEAD
						<?php _print_dishes($dishes_list, 'clip', $restaurant_id); ?>
=======
						<? _print_dishes($dishes_list, 'clip', $restaurant_id, true, $dish_id); ?>
>>>>>>> 5ac900d0bcc4d9996b2ae96f5212299e9d734e74
					</table>
			    	    </td>
				</tr>
			</table>
		    </span>
		</span>
	    </span>
	
	
	
	
<!--	modal test-->


<!--<a class="btn" data-toggle="modal" href="#myModal" >Launch Modal</a>-->

<div id="myModal" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	      <img src="<?= $user_data['image_url']?>"/>
              <?= $user_data['name'];?>
            </div>
            <div class="modal-body">
		<h3><?= $user_data['name'];?></h3>
		<h3><?= $user_data['gender'];?></h3>
		
	    </div>
           <!-- <div class="modal-footer">
              <button class="btn" data-dismiss="modal">Close</button>
              <button class="btn btn-primary">Save changes</button>
            </div>-->
</div>

<script type="text/javascript">
// fade in dish boxes		
$(".hidden").each(function(i) {
    $(this).delay(i * 200).fadeIn();
});
</script>