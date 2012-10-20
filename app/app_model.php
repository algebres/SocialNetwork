<?php
/**
 * Application wide functions set up for controllers.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 */
/**
 * Class short description
 *
 * Class long description
 *
 */
class AppModel extends Model{

    function slug ($str) {
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);
        return $str;
    }

/**
 * Unbinds validation rules and optionally sets the remaining rules to required.
 *
 * @param string $type 'Remove' = removes $fields from $this->validate
 *                       'Keep' = removes everything EXCEPT $fields from $this->validate
 * @param array $fields
 * @param bool $require Whether to set 'required'=>true on remaining fields after unbind
 * @return null
 * @access public
 */
    function unbindValidation ($type, $fields, $require=false) {
        if ($type === 'remove')
        {
            $this->validate = array_diff_key($this->validate, array_flip($fields));
        }
        else
        if ($type === 'keep')
        {
            $this->validate = array_intersect_key($this->validate, array_flip($fields));
        }

        if ($require === true)
        {
            foreach ($this->validate as $field=>$rules)
            {
                if (is_array($rules))
                {
                    $rule = key($rules);

                    $this->validate[$field][$rule]['required'] = true;
                }
                else
                {
                    $ruleName = (ctype_alpha($rules)) ? $rules : 'required';

                    $this->validate[$field] = array($ruleName=>array('rule'=>$rules,'required'=>true));
                }
            }
        }
    }
}