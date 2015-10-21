<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h3 class="text-center">Listing of a message</h3>
                        <table class="table table-striped table-bordered table-condensed">
                            <tr>
                                <th>Property</th><th>Value</th>
                            </tr>
                            <tr>
                                <td>Username</td><td><?= $message->username;?></td>
                            </tr>                            
                            <tr>
                                <td>Date</td><td><?= date('Y-m-d H:i:s', $message->date_mess);?></td>
                            </tr>
                            <tr>
                                <td>Message</td><td><?= $message->message;?></td>
                            </tr>                            
                        </table>
                </div>
            </div>
