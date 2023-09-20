<?php

namespace Btw\Core\Cells\Forms;

use RuntimeException;


class InputCell
{

    protected $type = 'text';
    protected $label;
    protected $placeholder;
    protected $name;
    protected $value;
    protected $min;
    protected $step;
    protected $xType;
    protected $xModel;
    protected $required;
    protected $class;
    protected $xInput;
    protected $classError;
    protected $disabled;

    public function renderList($params)
    {
        $this->min = (isset($params['min'])) ? 'min="' . $params['min'] : '';
        $this->step = (isset($params['step'])) ? 'step="' . $params['step'] : '';
        $this->xType = (isset($params['xType'])) ? ':type="' . $params['xType'] . '"' : '';
        $this->xModel = (isset($params['xModel'])) ? 'x-model="' . $params['xModel'] . '"' : '';
        $this->xInput = (isset($params['xInput'])) ? '@input="' . $params['xInput'] . '"' : '';
        $this->required = (isset($params['required'])) ? 'required' : '';
        $this->class = (isset($params['class'])) ? $params['class'] : '';
        $this->disabled = (isset($params['disabled'])) ? 'disabled="disabled"' : '';
        $this->placeholder = (isset($params['placeholder'])) ? 'placeholder="' . $params['placeholder'] . '"' : '';

        $html = $this->getLabel($params);
        $html .= '<div class="relative">';
        $html .= $this->getInput($params);
        $html .= '</div>';
        if (isset($params['description'])) {
            $html .= ' <p class="text-sm text-gray-500">' . $params['description'] . '</p>';
        }
        $html .= $this->getValidation($params);

        return $html;
    }

    public function getLabel($params)
    {
        if ($params['label'] == false)
            return false;
        $html = "";
        $required = ($this->required) ? '<sup class="text-red-600">*</sup>' : '';
        if (isset($params['lang']) && $params['lang'] == true) {
            $html .= '<label for="' . $params['name'] . '" class="block text-sm font-medium text-gray-700 mt-px pb-2 dark:text-gray-300"> ' . $params['label'] . ' ' . $required . ' </label>';
        } else {
            $html .= '<label for="' . $params['name'] . '" class="block text-sm font-medium text-gray-700 mt-px pb-2 dark:text-gray-300"> ' . $params['label'] . ' ' . $required . ' </label>';
        }

        return $html;
    }

    public function getInput($params)
    {
        $html = "";

        if ($params['type'] == 'password') {
            $html .= '<div class="relative">';
        }

        if (request()->is('post')) {
            $requestOld = request()->getPost();
            if (isset($requestOld[$params['name']])) {
                $params['value'] = $requestOld[$params['name']];
            }
        }

        if (service('validation')->hasError($params['name'])) :
            $this->classError = "border-red-500 focus:border-red-500";
        endif;

        if (isset($params['lang']) && $params['lang'] == true) {

            $html .= '<div class="relative rounded-md shadow-sm">';
            $html .= '<div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-2 bg-gray-600 rounded-l-lg text-center">';
            $html .= '<span class="h-5 w-5 text-gray-200">' . service('language')->getLocale() . '</span>';
            $html .= ' </div>';
            $html .= '<input ' . $this->disabled . ' ' . $this->required . ' type="' . $params['type'] . '" name="' . $params['name'] . '" ' . $this->placeholder . ' id="' . uniforme($params['name']) . '" autocomplete="' . $params['type'] . '" value="' . $params['value'] . '" ' . $this->min . ' ' . $this->step . ' ' . $this->xModel . ' ' . $this->xType . ' class="field appearance-none block px-4 py-3 w-full rounded-md bg-gray-100 border-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0 text-sm pl-10 leading-tight focus:outline-none dark:text-gray-200 dark:bg-gray-900 ' . $this->class . ' ' . $this->classError . ' ">';
            $html .= ' </div>';
        } else {
            $html .= '<input ' . $this->disabled . ' ' . $this->required . ' type="' . $params['type'] . '" name="' . $params['name'] . '" id="' . uniforme($params['name']) . '" autocomplete="' . $params['type'] . '" ' . $this->placeholder . '  value="' . $params['value'] . '" ' . $this->min . ' ' . $this->step . ' ' . $this->xModel . ' ' . $this->xType . ' class="field appearance-none block px-4 py-3 w-full rounded-md bg-gray-100 border-gray-100 focus:border-gray-500 focus:bg-white focus:ring-0 text-sm leading-tight focus:outline-none dark:text-gray-200 dark:bg-gray-900 ' . $this->class . ' ' . $this->classError . ' ">';
        }

        if (!empty($this->classError)) {
            $html .= '<div class="absolute inset-y-0 right-0 flex items-center pointer-events-none pr-4">
                <svg class="h-4 w-4 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"></path>
                </svg>
            </div>';
        }

        if ($params['type'] == 'password') {
            $html .= $this->getEyesPassword();
            $html .= '</div>';
        }

        return $html;
    }

    public function getValidation($params)
    {

        $html = '';
        // if (isset($params['lang']) && $params['lang'] == true) {

        //     if (service('validation')->hasError('lang.' . service('language')->getLocale() . '.' . uniforme($params['name']))) :
        //         // print_r($params['validation']); exit;
        //         $html = '<div class="invalid-feedback block text-red-600 text-xs mt-2">';
        //         $html .= service('validation')->getError('lang.' . service('language')->getLocale() . '.' . uniforme($params['name']));
        //         $html .= '</div>';
        //     endif;
        // } else {
        //     if (service('validation')->hasError($params['name'])) :
        //         $html = '<div class="invalid-feedback block text-red-600 text-xs mt-2">';
        //         $html .= service('validation')->getError($params['name']);
        //         $html .= '</div>';
        //     endif;
        // }
        if (service('validation')->hasError($params['name'])) :
            $html = '<div class="invalid-feedback block text-red-600 text-xs mt-2">';
            $html .= service('validation')->getError($params['name']);
            $html .= '</div>';
        endif;
        return $html;
    }

    public function getEyesPassword()
    {
        return '<div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                    <svg class="h-6 text-gray-400 dark:text-gray-200" fill="none" @click="show = !show" :class="{\'hidden\': !show, \'block\':show }" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 576 512">
                        <path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                        </path>
                    </svg>

                    <svg class="h-6 text-gray-400 dark:text-gray-200" fill="none" @click="show = !show" :class="{\'block\': !show, \'hidden\':show }" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 640 512">
                        <path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                        </path>
                    </svg>
                </div>';
    }
}
