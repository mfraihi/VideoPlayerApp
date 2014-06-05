<? $perRow = 4; ?>
<span class="container">
    <span class="row-fluid">
	<span class="span8 offset2" id="my_content_span">
		<div id="user_page_info">
                    <div id="user_info_main_row">
                        <img id="user_image" src="<?= $image_url;?>" />
                        
                        <div id="user_extended_info">
                            <span id="name"><?= $name?></span>
                            <br>
			    <small>Member Since: <?= $joined?></small>
                        </div>
		    </div>
		    
		    <div id="user_info_stats">
			<table class="borderless">
			    <tr>
                                <td>
                                    Clips: <?= $num_clips;?>
				</td>
				<td>
				   Followers: <?= $followers;?>
				</td>
			    </tr>
			    
			    <tr>
				<td>
				   Points: <?= $points;?>
				</td>
				
				<td>
				   Following: <?= $following;?>
				</td>
			    </tr>
			</table>
		    </div>
		</div>
		    
		    
                <table class="table borderless" id="user_page_clips">
		    <tr>
			<td colspan="4">
			    <ul id="myTab" class="nav nav-tabs">
				<li class=""><a href="#Clips" data-toggle="tab">All Clips</a></li>
				<li class=""><a href="#Kitchen" data-toggle="tab">Kitchen Clips</a></li>
			    </ul>
			</td>
		    </tr>
		    
		    <? _print_user_clips($clips_list, "all-clips");?>
		    <? _print_user_clips($kitchen_list, "kitchen-clips");?>
		</table>        	
	    </table>
	</span>
    </span>
</span>

<script type="text/javascript">
if (window.location.hash == "#Kitchen") {
    toggleClips("#Kitchen");
} else{
    toggleClips("#Clips");
}

$('#myTab a[href="#Kitchen"]').click(function(){
    toggleClips("#Kitchen");
});

$('#myTab a[href="#Clips"]').click(function(){
    toggleClips("#Clips");
});

function toggleClips(id) {
    if (id == "#Kitchen") {
	$(".all-clips").css('display', 'none');
	$(".kitchen-clips").css('display', 'table-row');
	$('#myTab').children("li").removeClass('active');
	$('#myTab li:last-child').addClass('active');
    }
    else{
	$(".all-clips").css('display', 'table-row');
	$(".kitchen-clips").css('display', 'none');
	$('#myTab').children("li").removeClass('active');
	$('#myTab li:first-child').addClass('active');
    }
}
</script>

<script type="text/javascript">
// fade in dish boxes		
$(".hidden").each(function(i) {
    $(this).delay(i * 200).fadeIn();
});
</script>