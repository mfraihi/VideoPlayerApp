<?php $perRow = 4; ?>
<span class="container">
    <span class="row-fluid">
	<span class="span8 offset2" id="my_content_span">
	    <div id="restaurant_name">
		    <h1 style="font-size: 76px; line-height: 1.2"><?php echo $name?></h1>
	    </div>
	    <table class="table borderless" id="restaurant_info">
		<tr>
		    <td colspan="<?php echo $perRow?>">
			<table class="borderless" id="restaurant_info_details">
			    <tr>
				<td>
				    <p id="restaurant_address"><?php echo "$address <br>$city, $state $zip"?></p>
				    <p>
					<? if($url != false): ?><i class="icon-globe"></i><a href="<? echo $url?>" target="_blank"> <?php echo $url?></a><? endif;?>
				    </p>
				    <p>
					<? if(isset($phone) and !empty($phone)): ?><i class="icon-phone"></i> <a href="tel:<?php echo $phone?>"><?php echo $phone?></a><? endif;?>
				    </p>
				</td>
				
				<td style="vertical-align: top;">
				    <button class="btn btn-primary btn-small" data-toggle="modal" href="#RestaurantOwner">
				    Are you the restaurant owner? 
				    </button>
				</td>
				
				<td>
				    <div id="googleMap" style="width:100%;height:150px;"></div>
				</td>
			    </tr>
			    
			    <tr>
				<td>
				</td>
			    </tr>
			</table>
		    </td>
		</tr>
		<?php _print_dishes($dishes_list, 'restaurant');?>
	    </table>
	</span>
    </span>
</span>

<script>
var myCenter=new google.maps.LatLng(<?php echo $lat ?>, <?php echo $lon;?>);

function initialize() {

  // Create an array of styles.
  var styles = [
  {
    "featureType": "water",
    "elementType": "geometry.fill",
    "stylers": [
      { "lightness": -25 },
      { "weight": 0.1 },
      { "hue": "#005eff" },
      { "visibility": "on" }
    ]
  },{
    "featureType": "landscape",
    "stylers": [
      { "hue": "#00c3ff" }
    ]
  },{
  }
];

  // Create a new StyledMapType object, passing it the array of styles,
  // as well as the name to be displayed on the map type control.
  var styledMap = new google.maps.StyledMapType(styles,
    {name: "Styled Map"});

  // Create a map object, and include the MapTypeId to add
  // to the map type control.
  var mapOptions = {
    zoom: 13,
    center: new google.maps.LatLng(<?php echo $lat?>, <?php echo $lon?>),
    mapTypeControlOptions: {
      mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
    }
  };
  var map = new google.maps.Map(document.getElementById('googleMap'),
    mapOptions);

  //Associate the styled map with the MapTypeId and set it to display.
  map.mapTypes.set('map_style', styledMap);
  map.setMapTypeId('map_style');
  
  var marker = new google.maps.Marker({
  position: myCenter,
  });

marker.setMap(map);

var infowindow = new google.maps.InfoWindow({
  content:"<?php echo $name . " | " . $num_clips . " clips"; ?>"
  });

google.maps.event.addListener(marker, 'click', function() {
  infowindow.open(map,marker);
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>

<!--modals-->




<!--//////////////////-->

<div id="RestaurantOwner" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
	<div class="modal-header" style="background: #e6e6e6; text-align: center;">
	<?php
	    $numHrs = abs(1358121600 - time())/60/60;
	    $HrsPerNewCustomer = 4;
	    $aheadOfYou = number_format($numHrs/$HrsPerNewCustomer);
	?>
	
	<span class="lead">
	    <strong>There are <?php echo $aheadOfYou?> people are ahead of you!</strong>
	</span>
	
	<h6 class="text" style="text-align: justify;">
	    You can manage this restaurant's profile, but there's currently a waitlist for assigning users to restaurants
	    . There are <?php echo $aheadOfYou;?> people ahead of you. We're working hard to verify more users everyday. Sign up now to secure your place in line.
	    We'll notify you by e-mail when your account is ready!
	</h6>
	
	</div>
            <div class="modal-body" style="max-height: 600px;">
		<form class="form-horizontal" method="post">
		    <fieldset>
		    <!-- Text input-->
		    <div class="control-group">
		      <label class="control-label">Name:</label>
		      <div class="controls">
			<input id="ROName" name="ROName" type="text" placeholder="Name" class="input-xlarge">
			<p class="help-block"></p>
		      </div>
		    </div>
		    
		    <!-- Appended Input-->
		    <div class="control-group">
		      <label class="control-label">E-mail:</label>
		      <div class="controls">
			<div class="input-append">
			  <input id="ROEmail" name="ROEmail" class="span2" placeholder="Enter Email" type="text">
			  <span class="add-on">@</span>
			</div>
			<p class="help-block"></p>
		      </div>
		    </div>
		    
		    <!-- Text input-->
		    <div class="control-group">
		      <label class="control-label">Website:</label>
		      <div class="controls">
			<input id="ROWebsite" name="ROWebsite" type="text" placeholder="URL" class="input-xlarge">
			<p class="help-block"></p>
		      </div>
		    </div>
		    
		    <!-- Text input-->
		    <div class="control-group">
		      <label class="control-label">Phone #:</label>
		      <div class="controls">
			<input id="ROPhone" name="ROPhone" type="text" placeholder="Phone Number" class="input-xlarge">
			<p class="help-block"></p>
		      </div>
		    </div>
		    
		    <!-- Multiple Checkboxes -->
		    <div class="control-group">
		      <label class="control-label"></label>
		      <div class="controls">
			<label class="checkbox">
			  <input type="checkbox" name="ROMailList" value="Keep me updated with latest news and updates from DishClips">
			  Keep me updated with latest news and updates from DishClips
			</label>
		      </div>
		    </div>
		    
		    <!-- Button -->
		    <div class="control-group">
		      <label class="control-label"></label>
		      <div class="controls">
			<button id="ROSubmit" name="ROSubmit" class="btn btn-primary">Submit</button>
		      </div>
		    </div>
		    
		    </fieldset>
		    </form>

	    </div>
</div>

<script type="text/javascript">
// fade in dish boxes		
$(".hidden").each(function(i) {
    $(this).delay(i * 200).fadeIn();
});
</script>