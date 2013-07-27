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
            $msg = $this->session->flashdata('msg');

            if (isset($action) && $action == 'Update' && (isset($success) && $success == true)) {
                ?><div style="text-align: center" class="">Your account successfully completed.</div>
                <?php
            } elseif (isset($action) && $action == 'Update' && (isset($success) && $error == true)) {
                ?><div style="text-align: center" class="">Please check your data.</div>
                <?php
            } elseif (isset($action) && $action == 'Login' && ($error == true)) {
                ?><div style="text-align: center;color: red;font-size: 11px" class=""><?= $msg ?></div>
                <?php
            } else if (isset($success) && $success == true) {
                ?><div style="text-align: left" class="">Welcome to LIITest!</div>
            <?php } ?>

        </section>

        <?php echo $form ?>

    </div>

</div>  
