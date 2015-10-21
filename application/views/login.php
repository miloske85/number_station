<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>          <div class="row">
                <div class="col-md-8 center-block">
                    <?= form_open($forms['login'], array('class' => 'form', 'id' => 'loginForm'));?>
                        <p>
							<label for="loginUsername">Username</label>
                            <?= form_error('username');?>
                            <input class="form-control" name="username" type="text" id="loginUsername" value="<?= set_value('username');?>">
                        </p><p>
							<label for="loginPassword">Password</label>
                            <?= form_error('password');?>
                            <input class="form-control" name="password" type="password" id="loginPassword" value="<?= set_value('password');?>">
                        </p>
                            <input type="hidden" name="isposted" value="isposted">
                        <button class="btn btn-default">Log In</button>
                    </form>
                    <script src="<?= $assets['validate_login'];?>"></script>
                    <p class="pull-right"><a href="<?= $urls['forgot_password'];?>">Forgot password?</a></p>
                </div>
            </div>
