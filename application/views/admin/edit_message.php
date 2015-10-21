<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-8">
                    <h3 class="text-center">Listing of a message</h3>
                    <?php
                        $formOpen = $urls['admin_edit_message'].'/'.$message->id;
                    ?>
                        <?= form_open($formOpen, array('class' => 'form'));?>
                            <p>
								<label for="message">Message</label>
								<textarea class="form-control" id="message" name="message" rows="10"><?= $message->message;?></textarea>
							</p>
                            <p>
								<label for="active">Active (1|0)</label>
								<input class="form-control" id="active" name="active" value="<?= $message->active;?>">
							</p>
                            <p><button class="btn btn-default">Submit</button></p>
                        </form>
                        <p><a href="<?= $urls['admin_show_message'].'/'.$message->id;?>"><button class="btn btn-default">Cancel</button></a></p>
                </div>
                <div class="col-md-4">
                    <span class="h1">&nbsp;</span>
                    <p><strong>Warning: There is no data validation for submitting messages from this form. Submitting empty form will erase message. All changes are irrecoverable!</strong></p>
                </div>
            </div>
