<?php


namespace learn\services;

use FormBuilder\Form\IviewForm;

/**
 * 表单构建
 * Class FormBuilderService
 * @package learn\services
 */
class FormBuilderService
{
    /**
     * 生成表单返回html
     * @param $rule
     * @param $url
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public static function make_post_form($rule, $url)
    {
        $form = new IviewForm($url);
        $form->setMethod('POST');
        $form->setRule($rule);
        $form->formConfig(['width'=>"50%"]);
        return $form->view();
    }
}