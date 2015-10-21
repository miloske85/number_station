<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>          <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h3 class="text-center">User Control Panel</h3>
                    <?= form_open($forms['change_password'], array('class' => 'form'));?>
	                    <p>
							<label for="chpassOld">Old Password</label>
		                    <?= form_error('oldpass');?>
		                    <input class="form-control" type="password" name="oldpass" id="chpassOld">
		                </p>
	                    <p>
							<label for="chpassNew">New Password</label>
	                    	<?= form_error('newpass1');?>
	                    	<input class="form-control" type="password" name="newpass1" id="chpassNew">
	                    </p>
	                    <p>
							<label for="chpassConf">Confirm Password</label>
	                    	<?= form_error('newpass2');?>
	                    	<input class="form-control" type="password" name="newpass2" id="chpassConf">
	                    </p>
	                    <p><button class="btn btn-default">Submit</button></p>
                    </form>
                </div>
            </div>
