<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login
 *
 * @author Faiz
 */
class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {



        $data = array();
        $data['is_blog'] = false;
        $data['page_title'] = 'LIITTest';
        $data['css'] = 'liit/static_pages,liit/common_liit,liit/register';
        $data['js'] = 'jquery, liit/static_pages,jquery.validate.min, liit/register';


        $vars['header'] = $this->load->view('_blocks/liit_common/header', $data, true);
        $this->load->library('session');
        $this->load->library('register_form_builder');
        $this->load->helper('file');





        $vars['status'] = '';
        $this->session->set_flashdata('success', false);

        if (!empty($_POST)) {
            // put your processing code here... we show what we do for emailing. You will need to add a correct email address
            if ($this->_process($_POST)) {
                $this->session->set_flashdata('success', TRUE);
            } else {
                $this->session->set_flashdata('error', true);
            }
              redirect(current_url());
        }



        $fields = array();

        $fields['user_name'] = array('required' => TRUE, 'label' => 'Username', 'class' => 'small');
        $fields['user_name']['after_html'] = '<span id="user_name_check"></span>';

        $fields['password'] = array('required' => TRUE, 'type' => 'password', 'class' => 'small');
        $fields['password']['after_html'] = '<span id="pass_check"></span>';
        $this->register_form_builder->set_fields($fields);

        // will set the values of the fields if there is an error... must be after set_fields
        $this->register_form_builder->set_validator($this->validator);
        $this->register_form_builder->set_field_values($_POST);
        $this->register_form_builder->display_errors = TRUE;
        $this->register_form_builder->form_attrs = 'method="post" action="" id="register"';
        $vars['action'] = 'Login';
        $this->register_form_builder->submit_value = 'Login';
        $this->register_form_builder->cancel_value = 'Cancel';
        $this->register_form_builder->show_required = false;
        $this->register_form_builder->required_text = '<b>User Login</b><span class="required">*</span>required fields';
        $vars['form'] = $this->register_form_builder->render($fields, 'divs');

        $this->load->view('_development/login', $vars);
    }

    function _process($data) {
        $this->load->library('validator');
        $this->validator->add_rule('user_name', 'required', '', $this->input->post('user_name'));
        $this->validator->add_rule('password', 'required', '', $this->input->post('user_name'));
        if ($this->validator->validate()) {
            $this->load->model('users_model');

            $user_data = $this->users_model->valid_user($data['user_name'], $data['password']);
            if (!empty($user_data)) {
                $this->session->set_userdata('login_user_info', $user_data);
                //   $this->_CI->session->set_userdata($this->get_session_namespace(), $user_data);
                var_dump($this->users_model->user_data());
                return TRUE;
            } else {
                $this->session->set_flashdata('msg', "User name or password missmatch");
            }
        }
    }

}