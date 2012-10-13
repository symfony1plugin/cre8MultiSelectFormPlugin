<?php

/**
 * cre8WidgetFormSelect represents a select HTML tag with order by input values (it support sortable values)
 * This widget doesn't support list with options group
 *
 * @see sf8WidgetFormSelect
 */
class cre8WidgetFormSelect extends sfWidgetFormSelect {

    /**
     * Returns an array of option tags for the given choices
     *
     * @param  string $value    The selected value
     * @param  array  $choices  An array of choices
     *
     * @return array  An array of option tags
     */
    protected function getOptionsForSelect($value, $choices) {
        $mainAttributes = $this->attributes;
        $this->attributes = array();

        if (!is_array($value)) {
            $value = array($value);
        }

        $value = array_map('strval', array_values($value));
        $value_set = array_flip($value);

        $optionsSelected = $value_set;
        $options = array();

        foreach ($choices as $key => $option) {
            if (is_array($option))
                throw new Exception('This widget doesn\'t support list with options group');

            $attributes = array('value' => self::escapeOnce($key));

            if (isset($value_set[strval($key)])) {
                $attributes['selected'] = 'selected';
            }
            
            if (isset($attributes['selected']))
                $optionsSelected[$key] = $this->renderContentTag('option', self::escapeOnce($option), $attributes);
            else
                $options[] = $this->renderContentTag('option', self::escapeOnce($option), $attributes);
        }

        $this->attributes = $mainAttributes;

        return array_merge_recursive($options, $optionsSelected);
    }

}
