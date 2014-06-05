<?
    $text_param = !empty($q) ? "value" : "placeholder";
    $text_param_val = !empty($q) ? $q : "Search Restaurants/Dishes/Categories..";
?>
<span class="container-fluid">
    <span class="row-fluid">
	<span class="span8 offset2" id="my_content_span">
	    <div id="search_fields">
		<form action="" accept-charset="utf-8" method="GET">
		    <div class="search_textarea">
			<i class="icon-search" style="margin-left: 10px;"></i>
			<input type="text" name="q" <?php echo $text_param . '="' . $text_param_val .'"'; ?> class="input-medium search-query" id="search_query" style="width: 20%" data-provide="typeahead" data-items="4" autocomplete="off">
			near
			<input type="text" name="loc" value="<?= $loc?>" class="input-medium search-query" id="location_box" style="width: 42%">
			<div id="detect_location"></div>
			<span style="float: right;">
			    <span class="clips_only"><input type="checkbox" name="clipsOnly" value="1" id="inlineCheckbox1"> with clips only</span>
			    <button name="" type="submit" value="true" class="btn">Search</button>
			</span>
		    </div>
		</form>
	    </div>
	</span>	
    </span>
    
    <? if($show_results): ?>
    <span class="row-fluid">
	<span class="span8 offset2" id="my_content_span">
	    <table class="table borderless" id="results_table" width="height: 500px;">
		    <?
		    foreach($restaurants_list as $param => $restaurant_group):
			if($param == "success") break;
			
			foreach($restaurant_group as $restaurant):
			    
			    $isDishClipsRestaruant = $restaurant['dishclips'] == 1 ? true : false;
			    $restaurant_name = $restaurant['name'];			
			    $restaurant_id = $isDishClipsRestaruant ? $restaurant['unique_id'] : $restaurant['foursquare_id'];
			    $restaurant_category = !empty($restaurant['category']) ? $restaurant['category'] : "";
			    $address1 = !empty($restaurant['address1']) ? $restaurant['address1'] . ", " : "";
			    $city = !empty($restaurant['city']) ? $restaurant['city'] . ", " : "";
			    $state = !empty($restaurant['state']) ? $restaurant['state']: "";
			    $zip = !empty($restaurant['zip']) ? $restaurant['zip'] : "";
			    $distance = !empty($restaurant['distance']) ? $restaurant['distance'] : "";
			    $num_clips = !empty($restaurant['num_clips']) && $restaurant['num_clips'] > 0 ? $restaurant['num_clips'] : "no";
			    $has_clips = is_numeric($num_clips) && $num_clips > 0 ? true : false;
			    $restaurant_address = !empty($address1) || !empty($city) ? $address1 . $city . $state . " " . $zip : "";
		    ?>
			
			<? if($has_clips): ?>
			<tr style="background: rgb(248, 248, 248);">
			    <? else: ?>
			    
			    <? endif;?>
			    <td>
				<img class="category_icon" src="<?= site_url('application_images/category_icons/' . getIcon($restaurant_category));?>">
				<b>
				<a href="<?= site_url('/restaurant/' . $restaurant_id);?>"><?= $restaurant_name?></a>
				<span id="category"><?= $restaurant_category?></span>
			    </b>
			    
			    <br>
			    <span style="font-size: small; font-weight: bold; color: #464646;"><?= $restaurant_address;?> <?= number_format($distance, 2)?> away</small>
			    </td>
			    
			    <? if($has_clips and $num_clips == 1): ?>
			    <td><b><?= $num_clips?> clip</b></td>
			    <? elseif($has_clips and $num_clips > 0): ?>
			    <td><b><?= $num_clips?> clips</b></td>
			    <? else: ?>
			    <td>no clips</td>
			    <? endif;?>
			</tr>
			
		    <? endforeach; ?>
		    <? endforeach; ?>
	    </table>
	</span>
    </span>
    <? endif; ?>
</span>

<script src="<?= site_url('bootstrap/js/bootstrap-typeahead.js')?>"></script>
<script src="<?= site_url('js/categories.js')?>"></script>

<script type="text/javascript">
	$("#detect_location").click(function(){
	    if (readCookie('address') != null) {
		$("#location_box").val(readCookie('address'));
	    } else{
		getAddress("#location_box"); 
	    }
	});
	
	///////
	
	//search autocomplete
    
    $('#search_query').typeahead({
	'source': get_categories(),
	'autoSelect': false
    });
</script>