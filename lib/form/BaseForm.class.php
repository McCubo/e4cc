<?php

/**
 * Base project form.
 * 
 * @package    e4cc
 * @subpackage form
 * @author     cubiascaceres@gmail.com
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 * @version    1.5
 */
class BaseForm extends sfFormSymfony {

    public function getErrorList() {
        $err = array();
        foreach ($this as $form_field) {
            if ($form_field->hasError()) {
                $err_obj = $form_field->getError();
                $err[] = $err_obj->getMessage();
            }
        }
        return $err;
    }

}
