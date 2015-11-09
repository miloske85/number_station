<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>          <div class="row">
                <div class="col-md-8 center-block" id="install-info">
                    <h3>This will install database tables</h3>
                    <p class="bg-warning">Before proceeding check that database parameters are set correctly in <code>application/config/database.php</code> dbdriver will have to be set to mysqli or else the installation will have to be done manually.</p>
                    <p class="bg-info">Default username is <code>administrator</code> and password <code>password</code></p>
                    <p class="bg-danger">Make sure to change the password after installation.</p>
                    <p class="bg-danger">After installation is complete, remove or disable access to <code>application/controllers/Install.php</code>, <code>application/sql</code>.</p>
                    <p class="bg-danger">Do not upload <code>application/tests</code> to the production server</p>
                    <p><a href="<?= $urls['install'];?>"><button class="btn btn-primary">Install</button></a></p>

                </div>
            </div>
