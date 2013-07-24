<?php echo $header; ?>
<div class="register_container" id="hl_page">
    
    <div id="register_left_col">
        &nbsp;
    </div>
    <div id="register_right_col">
        <section id="reg-wrapper">
         

            <?php
            $success = $this->session->flashdata('success');
            $error = $this->session->flashdata('error');
            if (isset($action) && $action == 'Update' && (isset($success) && $success == true)) {
                ?><div style="text-align: center" class="">Your account successfully completed.</div>
                <?php
            } elseif (isset($action) && $action == 'Update' && (isset($success) && $error == true)) {
                ?><div style="text-align: center" class="">Please check your data.</div>
                <?php
            } else if (isset($success) && $success == true) {
                ?><div style="text-align: center" class="">Your account has been created. please click <a href="fuel/login">here </a> to login.</div>
            <?php } ?>

        </section>

        <?php echo $form ?>

    </div>
     	
</div>  
