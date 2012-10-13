<?php

class cre8WidgetFormMultiSelectAsm extends sfWidgetFormChoice {

    /**
     * Constructor.
     *
     * Available options:
     *
     *  * choices:               An array of possible choices
     *  * propel:                If specified widget will work as a Propel - sfWidgetFormPropelChoice
     *                           The available propel options are:
     *                                 * model:       The model class (required)
     *                                 * add_empty:   Whether to add a first empty value or not (false by default). If the option is not a Boolean, the value will be used as the text value
     *                                 * method:      The method to use to display object values (__toString by default)
     *                                 * key_method:  The method to use to display the object keys (getPrimaryKey by default)
     *                                 * order_by:    An array composed of two fields:  The column to order by the results (must be in the PhpName format), asc or desc
     *                                 * query_methods: An array of method names listing the methods to execute on the model's query object
     *                                 * criteria:    A criteria to use when retrieving objects
     *                                 * connection:  The Propel connection to use (null by default)
     *                                 * multiple:    true if the select tag must allow multiple selections
     *
     *  * listType:              Specify what type of list will be created as part of the bsmSelect, allowed values: 'ol' or 'ul'
     *  * sortable:              May the user drag and drop to sort the list of elements they have selected? Allowed values: true or false, Note: In order to use this option, you must have jQuery-UI Draggables, Droppables, and Sortables enabled.
     *  * highlight:             Show a quick highlight of what item was added or removed? Allowed values: true/fals, an animation function, the name of an animation function as a properties of $.fn.bsmSelect.effects
     *  * animate:               Animate the adding or removing of items from the list? true/false, an object with properties 'add' and 'drop' which are either:(animation function OR the name of an animation function as a properties of $.fn.bsmSelect.effects)
     *  * hideWhenAdded:         Stop showing in select after item has been added? Allowed values: true or false. Note: Only functional in Firefox 3 at this time.
     *  * addItemTarget:         Where to place new selected items that are added to the list. Allowed values: 'top' or 'bottom'
     *  * debugMode:             Keeps original select multiple visible so that you can monitor live changes made to it when debugging.
     *
     *  * title:                 Text used for the default select label (when original select title attribute is not set)
     *  * removeLabel:           Text used for the remove link of each list item.
     *  * highlightAddedLabel:   Text that precedes highlight of item added.
     *  * highlightRemovedLabel: Text that precedes highlight of item removed.
     *  * template:              The HTML template to use to render this widget
     *                           The available placeholders are:
     *                                 * select_list
     *                                 * add_field.html
     *                                 * monitor.html
     *                                 * select_all.html
     *
     *  * containerClass         Class for container that wraps the entire bsmSelect.
     *  * selectClass            Class for the newly created .
     *  * listClass              Class for the newly created list of listType (ol or ul).
     *  * listSortableClass      Another class given to the list when sortable is active.
     *  * listItemClass          Class given to the list items.
     *  * listItemLabelClass     Class for the label text that appears in list items.
     *  * removeClass            Class given to the remove link in each list item.
     *  * highlightClass         Class given to the highlight .
     *  *
     *  * add_field              Enbable extra field to add options to select list true/false
     *  * add_field.javascript   Javasript to append value to select list. Can be redefined, in example to store sended value in database
     *  * add_field.html         The HTML of extra field
     *  * add_field.html.option  Array of extra field options:
     *                                 * add_label
     *                                 * add_button
     *
     *  * monitor                Enbable extra field to add options to select list true/false
     *  * monitor.javascript     Javasript to append value to select list. Can be redefined, in example to store sended value in database
     *  * monitor.html           The HTML of monitor
     *  * monitor.javascript.option Array of extra js options:
     *                                 * add_label
     *                                 * drop_label
     *
     *  * select_all             Enable select all button
     *  * select_all.javascript  Javasctipt to set up action for button
     *  * select_all.html        The HTML
     *  * select_all.html.option Array of button options
     *                                 * a - href anchor text
     *
     * @param array $options     An array of options
     * @param array $attributes  An array of default HTML attributes
     *
     * @see sfWidgetForm
     * @see http://github.com/vicb/bsmSelect
     */
    protected function configure($options = array(), $attributes = array()) {
        $this->addOption('choices', null);
        $this->addOption('propel', null);

        //Primary Options
        $this->addOption('listType', 'ol');
        $this->addOption('sortable', 'false');
        $this->addOption('highlight', 'false');
        $this->addOption('animate', 'false');
        $this->addOption('hideWhenAdded', 'false');
        $this->addOption('addItemTarget', 'bottom');
        $this->addOption('debugMode', 'false');

        //Text Labels
        $this->addOption('title', 'Select ...');
        $this->addOption('removeLabel', 'remove');
        $this->addOption('highlightAddedLabel', 'Added: ');
        $this->addOption('highlightRemovedLabel', 'Removed: ');

        //Modifiable CSS Classes
        $this->addOption('containerClass', 'bsmContainer');
        $this->addOption('selectClass', 'bsmSelect');
        $this->addOption('listClass', 'bsmList');
        $this->addOption('listSortableClass', 'bsmListSortable');
        $this->addOption('listItemClass', 'bsmListItem');
        $this->addOption('listItemLabelClass', 'bsmListItemLabel');
        $this->addOption('removeClass', 'bsmListItemRemove');
        $this->addOption('highlightClass', 'bsmHighlight');

        //Extra (non jQuery specific) behaviours
        $this->addOption('add_field', false);
        $this->addOption('add_field.html.option', array('add_label' => 'add a ...?', 'add_button' => 'add'));
        $this->addOption('add_field.javascript', <<<EOF
         jQuery("#%widget_id%_add_elem_btn").click(function() {
        var field_value = jQuery("#%widget_id%_add_elem").val();
        if(field_value != '') {
        jQuery("#%widget_id%").append(jQuery("<option>", { text: field_value, selected: "selected"})).change();
        jQuery("#%widget_id%_add_elem").val('');
        }
        return false;
      });
EOF
        );
        $this->addOption('add_field.html', <<<EOF
        <div>
          <label for="%widget_id%_add_elem">%add_field.html.add_label%</label>
          <input type="text" id="%widget_id%_add_elem" value="" />
          <button type="button" id="%widget_id%_add_elem_btn">%add_field.html.add_button%</button>
        </div>
EOF
        );

        $this->addOption('monitor', false);
        $this->addOption('monitor.javascript.option', array('add_label' => 'Added', 'drop_label' => 'Dropped'));
        $this->addOption('monitor.javascript', <<<EOF
      jQuery("#%widget_id%").change(function(e, data) {
        var action = "";
        if(data.type == "add")
            action = "%monitor.javascript.add_label%";
        else if(data.type == "drop")
            action = "%monitor.javascript.drop_label%";
        jQuery("#%widget_id%_monitor").prepend(jQuery("<li>").html(action + ": " + this.options[data.value].text));
      });
EOF
        );
        $this->addOption('monitor.html', <<<EOF
        <ul id="%widget_id%_monitor"></ul>
EOF
        );

        $this->addOption('select_all', false);
        $this->addOption('select_all.html.option', array('a' => 'Select all'));
        $this->addOption('select_all.javascript', <<<EOF
jQuery("#%widget_id%_select_all").click(function() {
        jQuery("#%widget_id%").children().attr("selected", "selected").end().change();
        return false;
      })
EOF
        );
        $this->addOption('select_all.html', <<<EOF
        <a href="#" id="%widget_id%_select_all">%select_all.html.a%</a>
EOF
        );

        //Main template
        $this->addOption('template.javascript', <<<EOF
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#%widget_id%").bsmSelect({
				listType: '%listType%',
				sortable: %sortable%,
				highlight: %highlight%,
				animate: %animate%,
                                hideWhenAdded: %hideWhenAdded%,
                                addItemTarget: '%addItemTarget%',
                                debugMode: %debugMode%,
                                title: '%title%',
                                removeLabel: '%removeLabel%',
                                highlightAddedLabel: '%highlightAddedLabel%',
                                highlightRemovedLabel: '%highlightRemovedLabel%',
                                containerClass: '%containerClass%',
                                selectClass: '%selectClass%',
                                listClass: '%listClass%',
                                listSortableClass: '%listSortableClass%',
                                listItemClass: '%listItemClass%',
                                listItemLabelClass: '%listItemLabelClass%',
                                removeClass: '%removeClass%',
                                highlightClass: '%highlightClass%'
			});
                %add_field.javascript%
                %monitor.javascript%
                %select_all.javascript%
		});
	</script>
EOF
        );

        $this->addOption('template.html', <<<EOF
        %select_list%
        %add_field.html%
        %monitor.html%
        %select_all.html%
EOF
        );

        parent::configure($options, $attributes);
    }

    /**
     * Renders the widget.
     *
     * @param  string $name        The element name
     * @param  string $value       The value selected in this widget
     * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
     * @param  array  $errors      An array of errors for the field
     *
     * @return string An HTML tag string
     *
     * @see sfWidgetForm
     */
    public function render($name, $value = null, $attributes = array(), $errors = array()) {
        if (is_null($value)) {
            $value = array();
        }

        if (is_null($this->getOption('propel')) && is_null($this->getOption('choices')))
            throw new Exception('You must specify "propel" or "choices" option');

        $choices = array();

        if (is_null($this->getOption('propel'))) {
            $choices = $this->getOption('choices');
            if ($choices instanceof sfCallable) {
                $choices = $choices->call();
            }
        } else {
            $this->configurePropelOptions();
            $choices = $this->getChoices();
        }

        if ($this->getOption('sortable') === 'true')
            $selectWidget = new cre8WidgetFormSelect(array('choices' => $choices));
        else
            $selectWidget = new sfWidgetFormSelect(array('choices' => $choices));

        $this->configureAddFieldOptions($name);
        $this->configureMonitorOptions($name);
        $this->configureSelectAllOptions($name);

        return strtr($this->getOption('template.html') . $this->getOption('template.javascript'), array(
            '%listType%' => $this->getOption('listType'),
            '%sortable%' => $this->getOption('sortable'),
            '%highlight%' => $this->getOption('highlight'),
            '%animate%' => $this->getOption('animate'),
            '%hideWhenAdded%' => $this->getOption('hideWhenAdded'),
            '%addItemTarget%' => $this->getOption('addItemTarget'),
            '%debugMode%' => $this->getOption('debugMode'),
            '%title%' => $this->getOption('title'),
            '%removeLabel%' => $this->getOption('removeLabel'),
            '%highlightAddedLabel%' => $this->getOption('highlightAddedLabel'),
            '%highlightRemovedLabel%' => $this->getOption('highlightRemovedLabel'),
            '%containerClass%' => $this->getOption('containerClass'),
            '%selectClass%' => $this->getOption('selectClass'),
            '%listClass%' => $this->getOption('listClass'),
            '%listSortableClass%' => $this->getOption('listSortableClass'),
            '%listItemClass%' => $this->getOption('listItemClass'),
            '%listItemLabelClass%' => $this->getOption('listItemLabelClass'),
            '%removeClass%' => $this->getOption('removeClass'),
            '%highlightClass%' => $this->getOption('highlightClass'),
            '%widget_id%' => $this->generateId($name),
            '%select_list%' => $selectWidget->render($name . '[]', $value, array('multiple' => 'multiple', 'id' => $this->generateId($name))),
            '%add_field.html%' => $this->getOption('add_field.html'),
            '%add_field.javascript%' => $this->getOption('add_field.javascript'),
            '%monitor.html%' => $this->getOption('monitor.html'),
            '%monitor.javascript%' => $this->getOption('monitor.javascript'),
            '%select_all.html%' => $this->getOption('select_all.html'),
            '%select_all.javascript%' => $this->getOption('select_all.javascript')
        ));
    }

    public function getJavascripts() {
        return array('/cre8MultiSelectFormPlugin/js/jquery.bsmselect.js');
    }

    public function getStylesheets() {
        return array('/cre8MultiSelectFormPlugin/css/jquery.bsmselect.css' => 'screen');
    }

    public function __clone() {
        if ($this->getOption('choices') instanceof sfCallable) {
            $callable = $this->getOption('choices')->getCallable();
            if (is_array($callable)) {
                $callable[0] = $this;
                $this->setOption('choices', new sfCallable($callable));
            }
        }
    }

    protected function configurePropelOptions() {
        $this->addOption('add_empty', false);
        $this->addOption('method', '__toString');
        $this->addOption('key_method', 'getPrimaryKey');
        $this->addOption('order_by', null);
        $this->addOption('query_methods', array());
        $this->addOption('criteria', null);
        $this->addOption('connection', null);
        $this->addOption('multiple', true);

        $propelOptions = $this->getOption('propel');

        if (!array_key_exists('model', $propelOptions) && empty($propelOptions['model']))
            throw new Exception('Name of "model" in "propel" options is required');

        foreach ($propelOptions as $key => $value) {
            $this->addOption($key, $value);
        }
    }

    protected function configureAddFieldOptions($widgetName) {
        if ($this->getOption('add_field')) {
            $fieldOptions = $this->getOption('add_field.html.option');

            $this->setOption('add_field.html', strtr($this->getOption('add_field.html'), array(
                        '%widget_id%' => $this->generateId($widgetName),
                        '%add_field.html.add_label%' => $fieldOptions['add_label'],
                        '%add_field.html.add_button%' => $fieldOptions['add_button']
                    )));
            $this->setOption('add_field.javascript', strtr($this->getOption('add_field.javascript'), array('%widget_id%' => $this->generateId($widgetName))));
        } else {
            $this->setOption('add_field.html', '');
            $this->setOption('add_field.javascript', '');
        }
    }

    protected function configureMonitorOptions($widgetName) {
        if ($this->getOption('monitor')) {
            $fieldOptions = $this->getOption('monitor.javascript.option');

            $this->setOption('monitor.html', strtr($this->getOption('monitor.html'), array('%widget_id%' => $this->generateId($widgetName))));
            $this->setOption('monitor.javascript', strtr($this->getOption('monitor.javascript'), array(
                        '%widget_id%' => $this->generateId($widgetName),
                        '%monitor.javascript.add_label%' => $fieldOptions['add_label'],
                        '%monitor.javascript.drop_label%' => $fieldOptions['drop_label']
                    )));
        } else {
            $this->setOption('monitor.html', '');
            $this->setOption('monitor.javascript', '');
        }
    }

    protected function configureSelectAllOptions($widgetName) {
        if ($this->getOption('select_all')) {
            $fieldOptions = $this->getOption('select_all.html.option');

            $this->setOption('select_all.html', strtr($this->getOption('select_all.html'), array(
                        '%widget_id%' => $this->generateId($widgetName),
                        '%select_all.html.a%' => $fieldOptions['a']
                    )));
            $this->setOption('select_all.javascript', strtr($this->getOption('select_all.javascript'), array('%widget_id%' => $this->generateId($widgetName))));
        } else {
            $this->setOption('select_all.html', '');
            $this->setOption('select_all.javascript', '');
        }
    }

    /**
     * Returns the choices associated to the model.
     *
     * @return array An array of choices
     *
     * @see sfWidgetFormPropelChoice
     */
    public function getChoices() {
        $choices = array();
        if (false !== $this->getOption('add_empty')) {
            $choices[''] = true === $this->getOption('add_empty') ? '' : $this->getOption('add_empty');
        }

        $criteria = PropelQuery::from($this->getOption('model'));
        if ($this->getOption('criteria')) {
            $criteria->mergeWith($this->getOption('criteria'));
        }
        foreach ($this->getOption('query_methods') as $method) {
            $criteria->$method();
        }
        if ($order = $this->getOption('order_by')) {
            $criteria->orderBy($order[0], $order[1]);
        }
        $objects = $criteria->find($this->getOption('connection'));

        $methodKey = $this->getOption('key_method');
        if (!method_exists($this->getOption('model'), $methodKey)) {
            throw new RuntimeException(sprintf('Class "%s" must implement a "%s" method to be rendered in a "%s" widget', $this->getOption('model'), $methodKey, __CLASS__));
        }

        $methodValue = $this->getOption('method');
        if (!method_exists($this->getOption('model'), $methodValue)) {
            throw new RuntimeException(sprintf('Class "%s" must implement a "%s" method to be rendered in a "%s" widget', $this->getOption('model'), $methodValue, __CLASS__));
        }

        foreach ($objects as $object) {
            $choices[$object->$methodKey()] = $object->$methodValue();
        }

        return $choices;
    }

}