<?php

class Register extends CI_Controller {

    function __construct() {


        parent::__construct();
    }

    function index() {



        $data = array();
        $data['is_blog'] = false;
        $data['page_title'] = 'Register';
        $data['css'] = 'liit/static_pages,liit/common_liit,liit/register';
        $data['js'] = 'jquery, liit/static_pages,jquery.validate.min, liit/register';


        $vars['header'] = $this->load->view('_blocks/liit_common/header', $data, true);
        $this->load->library('session');
        $this->load->library('register_form_builder');
        $this->load->helper('file');





        $vars['status'] = '';
        $this->load->model('countries_model');
        $this->session->set_flashdata('success', false);



        $fields = array();

        $fields['user_name'] = array('required' => TRUE, 'label' => 'Username', 'class' => 'small');
        $fields['user_name']['after_html'] = '<span id="user_name_check"></span>';

        $fields['password'] = array('required' => TRUE, 'type' => 'password', 'class' => 'small');
        $fields['password']['after_html'] = '<span id="pass_check">(6+ alpha/numeric characters)</span>';
        $fields['confirm_password'] = array('required' => TRUE, 'type' => 'password', 'class' => 'small');
        $fields['confirm_password']['after_html'] = '<span id="password_matched"></span>';
        $fields['first_name'] = array('required' => TRUE, 'class' => 'small');
        $fields['last_name'] = array('required' => TRUE, 'class' => 'small');
        $fields['email'] = array('required' => TRUE, 'label' => 'Email Address', 'class' => 'small');
        $fields['email']['after_html'] = '<span id="email_check"></span>';
//        $fields['gender'] = array('required' => FALSE, 'label' => 'Gender', 'class' => 'small');
//        $fields['gender']['after_html'] = '<span id="gender_check"></span>';
        $fields['country'] = array('required' => TRUE, 'value' => 'Bangladesh', 'class' => 'small', 'type' => 'select',
            'options' => $this->countries_model->options_list()
        );
        $fields['gender'] = array('required' => TRUE, 'value' => 'Male', 'class' => 'small', 'type' => 'select',
            'options' => $this->countries_model->gender_option_list()
        );
        $fields['address'] = array('required' => FALSE, 'label' => 'Mailing Address', 'class' => 'small');
        $fields['mobile'] = array('required' => FALSE, 'label' => 'Mobile', 'class' => 'small');
        //     var_dump($this->countries_model->gender_option_list());
        $this->register_form_builder->set_fields($fields);

        // will set the values of the fields if there is an error... must be after set_fields
        $this->register_form_builder->set_validator($this->validator);
        $this->register_form_builder->set_field_values($_POST);
        $this->register_form_builder->display_errors = TRUE;
        $this->register_form_builder->form_attrs = 'method="post" action="" id="register"';
        $vars['action'] = 'Register';
        $this->register_form_builder->submit_value = 'Register';
        $this->register_form_builder->cancel_value = 'Cancel';
        $this->register_form_builder->show_required = false;
        $this->register_form_builder->required_text = '<b>Login Info</b><span class="required">*</span>required fields';
        $vars['form'] = $this->register_form_builder->render($fields, 'divs');

        $this->load->view('_development/register', $vars);
    }

    function _process($data) {
        $this->load->library('validator');
    }

}