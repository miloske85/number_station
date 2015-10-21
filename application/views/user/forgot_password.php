<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>          <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <?= form_open($forms['forgot_pass'], array('class' => 'form'));?>
                        <p>
							<label for="fgpassEmail">Enter Your Email</label>
                            <?= form_error('email');?>
                            <input class="form-control" name="email" type="text" id="fgpassEmail" value="<?= set_value('email');?>">
                        </p><p>
                            <?= $captcha['image'];?></p>
                            <p>
							<label for="fgpassCaptcha">Enter Captcha Code</label>
                            <?= form_error('captcha');?>
                            <?php
                            if(isset($error)):
                                echo $error;
                            endif;
                            ?>
                            <input class="form-control" name="captcha" type="text" id="fgpassCaptcha">
                        </p>
                        <button class="btn btn-default">Reset Password</button>
                    </form>
                </div>
            </div>
