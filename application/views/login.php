<span class="container-fluid">
    <span class="row-fluid">
	<span class="span7 offset2">
	    <div class="well" style="width: 660px; margin: 0 auto 10px;">
		   <?  echo form_open('', array('method' => 'POST', 'class' => 'form-inline'));
		    
		    $username_box = array('type'        => 'text',
					  'name'	=> 'login',
				  'class'          => 'input-small',
				   'placeholder' => 'Username');

		    echo form_input($username_box);
		    
		    $password_box = array('type'        => 'password',
					  'name'	=> 'password',
				  'class'          => 'input-small',
				   'placeholder' => 'Password');
		    
		    echo form_input($password_box);
		    
		    echo form_submit('', 'Search');
		    echo form_close(); ?>
	    </div>
	    
	    <? if(isset($_SESSION['user_id'])) echo $_SESSION['user_id']; ?>
	</span>	
    </span>
</span>