<?php

namespace Btw\Core\Cells;

use Michelf\Markdown;
use RuntimeException;


class TextAreaCell
{

    protected $type = 'textearea';

    protected $label;

    protected $name;

    protected $value;

    protected $min;

    protected $step;

    protected $xType;

    protected $xModel;

    protected $xInput;

    protected $placeholder;

    protected $wysiwyg;

    public function renderList($params)
    {
        if (!isset($params['label'])) {
            throw new RuntimeException('You must provide the Filter view cell with the model to use.');
        }

        $this->placeholder = (isset($params['placeholder'])) ? $params['placeholder'] : '';
        $this->xType = (isset($params['xType'])) ? ':type="' . $params['xType'] . '"' : '';
        $this->xModel = (isset($params['xModel'])) ? 'x-model="' . $params['xModel'] . '"' : '';
        $this->xInput = (isset($params['xInput'])) ? '@input="' . $params['xInput'] . '"' : '';
        $this->wysiwyg = (isset($params['wysiwyg'])) ? $params['wysiwyg'] : false;

        $html = $this->getLabel($params);
        $html .= $this->getTextarea($params);
        $html .= $this->getValidation($params);

        return $html;
    }

    public function getLabel($params)
    {
        $html = "";
        if (isset($params['lang']) && $params['lang'] == true) {
            // $html .= '<label for="lang[' . request()->getLocale() . '][' . $params['name'] . ']" class="block text-sm font-medium text-gray-700 mt-px pb-2 dark:text-gray-300"> ' . $params['label'] . ' </label>';
            $html .= '<label for="' . $params['name'] . '" class="block text-sm font-medium text-gray-700 mt-px pb-2 dark:text-gray-300"> ' . $params['label'] . ' </label>';
        } else {
            $html .= '<label for="' . $params['name'] . '" class="block text-sm font-medium text-gray-700 mt-px pb-2 dark:text-gray-300"> ' . $params['label'] . ' </label>';
        }

        return $html;
    }

    public function getTextarea($params)
    {

        $html = "";
        $ckeditor = "";

        switch ($this->wysiwyg) {
            case 'ckeditor':
                $html .= view('Btw\Core\Cells\views\ckeditor', ['params' => $params, 'viewMeta' => $this->intlScript()]);
                break;
            case 'quilljs':
                $html .= view('Btw\Core\Cells\views\quilljs', ['params' => $params, 'viewMeta' => $this->intlScript()]);
                break;
            case 'simplemde':
                $html .= view('Btw\Core\Cells\views\simplemde', ['params' => $params, 'viewMeta' => $this->intlScript()]);
                break;
            default:
                if (isset($params['lang']) && $params['lang'] == true) {
                    // $html .= '<textarea rows="3" '.$this->placeholder.' name="lang[' . request()->getLocale() . '][' . $params['name'] . ']" id="' . $params['name'] . '" ' .$this->xModel. ' ' .$this->xType. ' class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500  dark:text-gray-200 dark:bg-gray-900"> ' . $params['value'] . ' </textarea>';
                    $html .= '<textarea ' . $ckeditor . ' rows="3" ' . $this->placeholder . ' name="' . $params['name'] . '" id="' . $params['name'] . '" ' . $this->xModel . ' ' . $this->xType . ' class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 dark:border-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500  dark:text-gray-200 dark:bg-gray-900"> ' . $params['value'] . ' </textarea>';
                } else {
                    $html .= '<textarea ' . $ckeditor . ' rows="3" ' . $this->placeholder . ' name="' . $params['name'] . '" id="' . $params['name'] . '" ' . $this->xModel . ' ' . $this->xType . ' class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 dark:border-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500  dark:text-gray-200 dark:bg-gray-900"> ' . $params['value'] . ' </textarea>';
                }
        }


        // if ($this->ckeditor == true) {
        //     // $params['value'] = Markdown::defaultTransform($params['value']);
        //     // $html .= view('Btw\Core\Cells\views\ckeditor', ['params' => $params]);
        //     $html .= view('Btw\Core\Cells\views\quilljs', ['params' => $params]);
        // } else {

        //     if (isset($params['lang']) && $params['lang'] == true) {
        //         // $html .= '<textarea rows="3" '.$this->placeholder.' name="lang[' . request()->getLocale() . '][' . $params['name'] . ']" id="' . $params['name'] . '" ' .$this->xModel. ' ' .$this->xType. ' class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500  dark:text-gray-200 dark:bg-gray-900"> ' . $params['value'] . ' </textarea>';
        //         $html .= '<textarea ' . $ckeditor . ' rows="3" ' . $this->placeholder . ' name="' . $params['name'] . '" id="' . $params['name'] . '" ' . $this->xModel . ' ' . $this->xType . ' class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 dark:border-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500  dark:text-gray-200 dark:bg-gray-900"> ' . $params['value'] . ' </textarea>';
        //     } else {
        //         $html .= '<textarea ' . $ckeditor . ' rows="3" ' . $this->placeholder . ' name="' . $params['name'] . '" id="' . $params['name'] . '" ' . $this->xModel . ' ' . $this->xType . ' class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 dark:border-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500  dark:text-gray-200 dark:bg-gray-900"> ' . $params['value'] . ' </textarea>';
        //     }
        // }

        if (isset($params['description'])) {
            $html .= ' <p class="text-sm text-gray-500">' . $params['description'] . '</p>';
        }

        return $html;
    }

    public function getValidation($params)
    {

        $html = '';
        if (isset($params['lang']) && $params['lang'] == true) {

            if (service('validation')->hasError('lang.' . request()->getLocale() . '.' . uniforme($params['name']))):
                // print_r($params['validation']); exit;
                $html = '<div class="invalid-feedback block text-red-600 text-sm">';
                $html .= service('validation')->getError('lang.' . request()->getLocale() . '.' . uniforme($params['name']));
                $html .= '</div>';
            endif;
        } else {
            if (service('validation')->hasError(uniforme($params['name']))):
                $html = '<div class="invalid-feedback block text-red-600 text-sm">';
                $html .= service('validation')->getError(uniforme($params['name']));
                $html .= '</div>';
            endif;
        }
        return $html;
    }

    /**
     * Displays the chart blocks in the admin dashboard.
     */
    public function intlScript()
    {
        /** @var Metadata */
        $meta = service('viewMeta');

        switch ($this->wysiwyg) {
            case 'ckeditor':
                // $meta->addScript(['src' => 'https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js']);
                break;
            case 'quilljs':
                $meta->addStyle(['rel' => 'stylesheet', 'href' => 'https://cdn.quilljs.com/1.3.6/quill.snow.css']);
                $meta->addScript(['src' => 'https://cdn.quilljs.com/1.3.6/quill.js']);
                break;
            case 'simplemde':
                 $meta->addStyle(['rel' => 'stylesheet', 'href' => 'https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css']);
                // $meta->addScript(['src' => 'https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js']);

                break;
            default:

        }
    }
}