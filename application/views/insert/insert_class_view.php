<div id="content">
	<div id="insert">
		<h1>Create Classification</h1>

      <?php echo form_open('insert/validate_i_class', array('class' => 'login')); ?>

   <p>
      <?php
      		$this->table->add_row(form_label ( 'Name: ', 'i_class_name' ), form_input ( array (
					'id' => 'i_class_name',
					'name' => 'i_class_name',
					'placeholder' => 'New Classification' 
			) ));
      		
      		echo $this->table->generate();
			?>
   </p>
   
   <p id="insert_submit">
      <?php echo form_button(array('class' => 'login-button', 'type' => 'submit', 'content' => 'submit')); ?>
   </p>
   
   <?php
			echo form_close ();
			if (isset ( $error )) {
				?>
         <p class="error" id="insert_error"><?php echo $error; ?></p>
    <?php } ?>
    
    <?php echo validation_errors('<p class="error">'); ?>
      
   </div>
</div>