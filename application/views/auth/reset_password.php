
<div class="row">
	<div class="col-md-6">

<h3 class="text-center"><?php echo lang('reset_password_heading');?></h3>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open('auth/reset_password/' . $code, array('class' => 'form'));?>

	<p>
		<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label> <br />
		<?php //echo form_input($new_password);?>
		<input type="password" name="new" id="new" class="form-control">

	</p>

	<p>
		<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?> <br />
		<?php //echo form_input($new_password_confirm);?>
		<input type="password" name="new_confirm" id="new_confirm" class="form-control">
	</p>

	<?php echo form_input($user_id);?>
	<?php echo form_hidden($csrf); ?>

	<p><?php //echo form_submit('submit', lang('reset_password_submit_btn'));?></p>
	<p><button class="btn btn-primary">Submit</button></p>

<?php echo form_close();?>

	</div>
</div>