<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                   <h3 class="text-center">Send private message</h3>
                   <span class="h1">&nbsp;</span>
                   <p><a href="<?= $urls['home'];?>">Home</a> | <a href="<?= $urls['private_messages'];?>">Back to private messages</a></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 clearfix">
                    <div class="h1">&nbsp;</div>
                </div>
                <div class="col-md-8 col-md-offset-2">
                    <?= form_open($forms['send_pm_post'], array('class' => 'form'));?>
						<?php if(isset($recepient)): ?>
							<p><input class="form-control" name="recepient" value="<?= $recepient;?>"></p>
						<?php else: ?>
						<p><?= form_error('recepient');?>
							<input class="form-control" name="recepient" value="<?= set_value('recepient');?>" placeholder="Send To"></p>
						<?php endif; ?>
						
                        <?php if(isset($subject)): ?>
                            <p><input class="form-control" name="subject" value="<?= $subject;?>"></p>
                        <?php else: ?>
						<p><?= form_error('subject');?>
							<input class="form-control" name="subject" value="<?= set_value('subject');?>" placeholder="Subject"></p>
                        <?php endif; ?>
                        
						<p><?= form_error('message');?>
							<textarea class="form-control" name="message" rows="10" placeholder="Message"><?= set_value('message');?></textarea></p>
						<p><button class="btn btn-default">Send</button></p>
                    </form>
                </div>
            </div>
