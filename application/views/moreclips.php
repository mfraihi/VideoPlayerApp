<table class="table borderless" id = "one"><?php 
 $stuff = array();
	for($i = 0; $i < 20; $i++):
		array_push($stuff, $latest_clips[$i]);
	endfor;
_print_user_clips($stuff); ?></table> 


<table class="table borderless" id = "two"><?php 
 $stuff = array();
	for($i = 20; $i < 40; $i++):
		array_push($stuff, $latest_clips[$i]);
	endfor;
_print_user_clips($stuff); ?></table> 

<table class="table borderless" id = "three"><?php 
 $stuff = array();
	for($i = 40; $i < 60; $i++):
		array_push($stuff, $latest_clips[$i]);
	endfor;
_print_user_clips($stuff); ?></table> 

<table class="table borderless" id = "four"><?php 
 $stuff = array();
	for($i = 60; $i < 80; $i++):
		array_push($stuff, $latest_clips[$i]);
	endfor;
_print_user_clips($stuff); ?></table> 