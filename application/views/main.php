<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-4">
                	<p>Today, when even the lightbulbs are connected to the Internet, it is easy to communicate with anyone on the planet. Few decades ago this wasn't so easy, especially if you wanted to communicate secretly. In those old days, and even today, the best way of sending secret messages to field agents was with <a href="https://en.wikipedia.org/wiki/Numbers_station" title="Wikipedia: Number Stations">number stations</a>. Number stations are short wave radio stations which broadcast list of numbers or letters. Most of these messages are encrypted with One Time Pad, or Vernam cipher, which is the only cipher (encryption algorithm) that is proven to be unbreakable</p>
                	<p>Operating your own radio station might be a bit complicated, so you can use this site to exchange messages. You can post without registering, or you can register and post without having to enter CAPTCHA code and you will also be able to send private messages.</p>
                	<p>Please post only encrypted messages here, inappropriate content will be removed.</p>
                    <p class="bg-warning">Warning: Whenever you are using the internet your ISP and your government are probably monitoring your activities. This doesn't change the security of your messages, but if you want to stay (reasonably) anonymous use public computers or <a href="https://www.torproject.org/">Tor</a>.</p>

                    <?= form_open($forms['message_search'], array('class' => 'form form-inline'));?>
                        <p>
							<input class="form-control" name="search_message" id="mainSearch" placeholder="Search Messages">&nbsp;
                            <input class="form-control" type="hidden" name="post_check" value="post_check">
                        <button class="btn btn-primary">Search</button></p>
                    </form>                	
        

                </div>
                <div class="col-md-8">


                    <?= form_open($forms['message'], array('class' => 'form', 'id' => 'mainForm'));?>

                        <?php
                            if(!$data['logged_in']):
                            ?>
                                <p>
									<label for="mainName">Name</label>
                                    <?= form_error('name');?>
                                    <input class="form-control" name="name" type="text" id="mainName" value="<?= set_value('name');?>" placeholder="Name">
                                </p>                            
                                <p>
									<label for="mainCaptcha">CAPTCHA code</label>
                                    <?= form_error('captcha');?>
                                    <?php
										if(isset($captcha_error)):
										?>
											<p class="text-danger"><?= $captcha_error;?></p>
										<?php
										endif;
                                    ?>
                                    <input class="form-control" name="captcha" type="text" id="mainCaptcha" value="<?= set_value('captcha');?>" placeholder="Captcha">
                                </p>
                                <p><?= $captcha['image'];?></p>
                            <?php
                                endif;
                            ?>
                            
                            <p>
								<label for="mainMessage">Message</label>
								<?= form_error('message');?>
                            <textarea class="form-control" name="message" id="mainMessage" rows="10" placeholder="Message"><?= set_value('message');?></textarea></p>
                        <p><button class="btn btn-default">Send</button></p>
                    </form>
                    <script src="<?= $assets['validate_main'];?>"></script>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 clearfix">
                    <div class="h1">&nbsp;</div>
                </div>
                <?php
					if(isset($messages) and count($messages)>0):
                ?>
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="text-center">Messages</h2>
                    <?php						
						foreach($messages as $message):
							?>
								<p><strong>
									<?php
										if($message['user_id'] == 0):
											echo $message['name'];
										else:
                                            ?>
                                            <a href="<?= $urls['show_user'].'/'.$message['user_id'];?>"><?= $message['username'];?></a>
                                            <?php
										endif;									
									?>
								</strong> on <?= date($data['date_format'],$message['date_mess']);?>
								<?php
									//display delete link
									if($data['logged_in']):
										if($message['user_id'] == $data['iauth_user_id']){
										?>
											&nbsp;&nbsp;&nbsp;<a href="<?=$urls['message_delete'].'/'.$message['id'];?>">X</a>
										<?php
										}
									endif;
								?>
								<br>
								<?= nl2br($message['message']);?></p>
								<p>&nbsp;</p>
							<?php
						endforeach;                        
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
					<?php
						if(isset($pag_links)):
							echo $pag_links;
						endif;
					?>
                </div>
                <?php
					endif;
                ?>
            </div>
