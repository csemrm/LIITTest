<?php

class register_form_builder extends Form_builder {

    /**
     * Render the HTML output
     * 
     * @access	public
     * @param	array fields values... will overwrite anything done with the set_fields method previously
     * @return	string
     */
    public function render_divs($fields = NULL) {
        if (!empty($fields))
            $this->set_fields($fields);

        // reoarder
        $this->set_field_order();
        $this->_html = '';
        $str = '';
        $begin_str = '';
        $end_str = '';
        if ($this->display_errors) {
            $str .= '<div>';
            $func = $this->display_errors_func;
            if (function_exists($func)) {
                $str .= $func();
            }
            $str .= '</div>';
        }

        $colspan = ($this->label_layout == 'top') ? '1' : '2';

        $str .= "<div class=\"" . $this->css_class . "\"";
        $str .= (!empty($this->id)) ? ' id="' . $this->id . '"' : '';
        $str .= ">\n";
        foreach ($this->_fields as $key => $val) {
            $val = $this->_normalize_value($val);


            if ($val['type'] == 'section') {
                $str .= "<div class=\"section\">" . $this->create_section($val) . "</div>\n";
                continue;
            } else if (!empty($val['section'])) {
                $str .= "<div class=\"section\"><" . $this->section_tag . ">" . $val['section'] . "</" . $this->section_tag . "></div>\n";
                continue;
            }

            if ($val['type'] == 'copy') {
                $str .= "<div class=\"copy\">" . $this->create_copy($val) . "</div>\n";
                continue;
            } else if (!empty($val['copy'])) {
                $str .= "<div class=\"copy\"><" . $this->copy_tag . ">" . $val['copy'] . "</" . $this->copy_tag . "></div>\n";
                continue;
            }

//            if(){
//                 $str = "<div class=\"required\">";
//        $str .= str_replace('{required_indicator}', $this->required_indicator, $this->required_text);
//        $str .= "</div>\n";
//            }
            if (!empty($val['custom'])) {
                $str .= "<div";
                if (!empty($this->row_id_prefix)) {
                    $str .= ' id="' . $this->row_id_prefix . Form::create_id($val['name']) . '"';
                }
                $str .= " class=\"field\">";
                $str .= $this->create_label($val, TRUE);
                $str .= $val['before_html'] . $val['custom'] . $val['after_html'];
                $str .= "</div>\n";
            } else if (in_array($val['name'], $this->hidden) OR $val['type'] == 'hidden') {
                $end_str .= $this->create_hidden($val);
            } else if ((is_array($val['name']) AND in_array($val['name'], $this->displayonly)) OR $val['displayonly'] OR (is_string($this->displayonly) AND strtolower($this->displayonly) == 'all')) {
                $str .= "<div";
                if (!empty($this->row_id_prefix)) {
                    $str .= ' id="' . $this->row_id_prefix . Form::create_id($val['name']) . '"';
                }
                $str .= " class=\"field\">";
                $str .= $this->create_label($val, FALSE);
                $str .= $val['value'] . "\n";
                $str .= $this->create_hidden($val);
                $str .= "</div>\n";
            } else if (!in_array($val['name'], $this->exclude)) {

                if ($val['type'] == 'textarea') {

                    $str .= "<div";
                    if (!empty($this->row_id_prefix)) {
                        $str .= ' id="' . $this->row_id_prefix . Form::create_id($val['name']) . '"';
                    }
                    $str .= " class=\"textarea_field\">";

                    $str .= $val['before_html'] . $this->create_field($val, FALSE) . $val['after_html'];
                    $str .= $this->create_label($val, TRUE);
                    $str .= "</div>\n";
                } else if ($val['name'] == 'first_name') {
                     $str .= "<div";
                    if (!empty($this->row_id_prefix)) {
                        $str .= ' id="' . $this->row_id_prefix . Form::create_id($val['name']) . '"';
                    }
                    $str .= " class=\"my_info_top_border field\">";
                    $str .= '<div class="required_msg" ><b>My Info</b></div>';
                   
                    $str .= $this->create_label($val, TRUE);
                    $str .= $val['before_html'] . $this->create_field($val, FALSE) . $val['after_html'];

                    $str .= "</div>\n";
                } else if ($val['name'] == 'user_name') {
                    $str .= '<div class="required_msg" ><b>Login Info</b><span class="required">*</span>required fields</div>';
                    $str .= "<div";
                    if (!empty($this->row_id_prefix)) {
                        $str .= ' id="' . $this->row_id_prefix . Form::create_id($val['name']) . '"';
                    }
                    $str .= " class=\"field\">";
                    $str .= $this->create_label($val, TRUE);
                    $str .= $val['before_html'] . $this->create_field($val, FALSE) . $val['after_html'];

                    $str .= "</div>\n";
                } else if ($val['name'] == 'terms') {


                    $str .= "<div";
                    if (!empty($this->row_id_prefix)) {
                        $str .= ' id="' . $this->row_id_prefix . Form::create_id($val['name']) . '"';
                    }
                    $str .= " class=\"terms_field\">";
                    $str .= $this->create_label($val, TRUE);
                    $str .= $val['before_html'] . $this->create_field($val, FALSE) . $val['after_html'];
                    $str .= "</div>\n";
                } else {


                    $str .= "<div";
                    if (!empty($this->row_id_prefix)) {
                        $str .= ' id="' . $this->row_id_prefix . Form::create_id($val['name']) . '"';
                    }
                    $str .= " class=\"field\">";
                    $str .= $this->create_label($val, TRUE);
                    $str .= $val['before_html'] . $this->create_field($val, FALSE) . $val['after_html'];
                    $str .= "</div>\n";
                }
            }
        }
        $str .= "<div class=\"actions\">";

        if (!empty($this->submit_value) AND $this->displayonly != 'all') {
            // check if the string has a tag and if so just pump in the string
            if (preg_match("/^</i", $this->submit_value)) {
                $str .= $this->submit_value;
            } else {
                $submit_btn = (preg_match("/(.)+\\.(jp(e){0,1}g$|gif$|png$)/i", $this->submit_value)) ? 'image' : 'submit';
                $str .= $this->form->$submit_btn($this->submit_value, $this->submit_value, array('class' => 'submit'));
            }
        }
        if (!empty($this->reset_value)) {
            if (preg_match("/^</i", $this->reset_value)) {
                $str .= $this->reset_value;
            } else {
                $str .= $this->form->reset($this->reset_value, '', array('class' => 'reset'));
            }
        }
        if (!empty($this->cancel_value)) {
            if (preg_match("/^</i", $this->cancel_value)) {
                $str .= $this->cancel_value;
            } else {
                $cancel_attrs = array('class' => 'cancel', 'id' => 'reset', 'type' => 'reset');

                if (!empty($this->cancel_action)) {
                    $cancel_attrs['onclick'] = $this->cancel_action;
                }

                $str .= $this->form->button($this->cancel_value, '', $cancel_attrs);
            }
        }

        if (!empty($this->other_actions))
            $str .= $this->other_actions;
        $str .= "</div>\n";
        if ($this->has_required AND $this->show_required) {
            $str .= "<div class=\"required\">";
            $str .= str_replace('{required_indicator}', $this->required_indicator, $this->required_text);
            $str .= "</div>\n";
        }
        $str .= "</div>\n";

        if ($this->use_form_tag) {
            $this->_html .= $this->form->open($this->form_attrs);
        }
        if (!empty($this->fieldset)) {
            $this->_html .= $this->form->fieldset_open($this->fieldset);
        }
        $this->_html .= $begin_str;
        $this->_html .= $str;
        $this->_html .= $end_str;

        if (!empty($this->key_check)) {
            $this->_html .= $this->create_hidden(array('name' => $this->key_check_name, 'value' => $this->key_check));
        }
        if (!empty($this->fieldset)) {
            $this->_html .= $this->form->fieldset_close();
        }

        if ($this->use_form_tag) {
            $this->_html .= $this->form->close('', FALSE); // we set the token above just in case form tags are turned off	
        }
        return $this->_html;
    }

    // --------------------------------------------------------------------
}