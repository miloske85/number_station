<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-8">
                    <?= form_open($forms['register'], array('class' => 'form', 'id' => 'registerForm'));?>
                        <p>
							<label for="regUsername">Username</label>
                            <?= form_error('username');?>
                            <p id="ajaxRegUsernameNotice"></p>
                            <input class="form-control" name="username" type="text" id="regUsername" value="<?= set_value('username');?>">
                        </p>
                        <p>
							<label for="regEmail">Email Address</label>
                            <?= form_error('email');?>
                            <input class="form-control" name="email" type="text" id="regEmail" value="<?= set_value('email');?>">
                        </p>                        
                        <p>
							<label for="regPassword">Password</label>
                            <?= form_error('password');?>
                            <input class="form-control" name="password" type="password" id="regPassword">
                        </p>
                        <p>Password strength: <span id="passwordMeter">0</span> bit</p>
                        <p>
							<label for="regConfPass">Confirm Password</label>
                            <?= form_error('password2');?>
                            <input class="form-control" name="password2" type="password" id="regConfPass">
                        </p>
                        <p><?= $captcha['image'];?></p>                        
                        
                        <p>
                        <p>
							<label for="regCaptcha">Enter CAPTCHA</label>
                            <?php
                                if(isset($error)):
                            ?>
                            <p class="text-danger"><?= $error;?></p>
                            <?php
                                endif;
                            ?>
                            <input class="form-control" name="captcha" type="text" id="regCaptcha" value="<?= set_value('captcha');?>">
                        </p>
                        <p>By clicking the 'Register' button you agree to the <a href="<?= $urls['TOS'];?>">Terms of Service</a> of this site.</p>
                        <p><button class="btn btn-default">Register</button></p>
                    </form>
                    <script src="<?= $assets['validate_register'];?>"></script>
                    <script src="<?= $assets['ajax_register'];?>"></script>
                    <script src="<?= $assets['password_strength_meter'];?>"></script>
                </div>
            </div>
