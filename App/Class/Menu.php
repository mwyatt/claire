<?php

namespace OriginalAppName;


/**
 * build menu using passed data structure
 * can be outputted as html
 * utilises some attributes from model class
 * @todo allow this to pass specific templates to customise each layer further
 *       work with the view class to fire out each template?
 * @todo untested
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version 0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Menu extends \OriginalAppName\View
{


    /**
     * modifies the class names to customise the menu
     * @var string
     */
    protected $label = 'primary';


    protected $element = 'div';


    protected $templateContainer = '_menu/container';


    protected $templateSingle = '_menu/single';


    protected $templateSingleLink = '_menu/link';


    /**
     * builds a tree using categories array
     * @param  array $categories 
     * @return object             
     */
    public function buildTree($categories)
    {
        $this->setData($this->recurse(['categories' => $categories]));
        return $this;
    }


    /**
     * get a class friendly part for label set
     * @return string 
     */
    public function getClassPartLabel()
    {
        return $this->getLabel() ? '-' . $this->getLabel() : '';
    }


    /**
     * iterates through category list generates html output
     * @param  array $config categories, idParent and level
     * @return string         
     */
    public function recurse($config)
    {

        // resources
        $classPartLabel = $this->getClassPartLabel();
        $output = '';
        $element = $this->getElement();
        $elementClose = '</' . $element . '>';

        // default values
        if (! isset($config['idParent'])) {
            $config['idParent'] = 0;
        }
        if (! isset($config['level'])) {
            $config['level'] = 1;
        }

        // not root levels
        if ($config['idParent']) {
            $output = '<' . $element . ' class="menu' . $classPartLabel . '-level-' . $config['level'] . ' js-menu' . $classPartLabel . '-level-' . $config['level'] . '">';
        }

        // category loop
        foreach ($config['categories'] as $category) {

            // must have a positive parent
            if ($category->getIdParent() != $config['idParent']) {
                continue;
            }

            // children?
            $hasChildren = $this->hasChild([
                'categories' => $config['categories'],
                'categoryId' => $category->getId()
            ]);

            // single menu item
            if ($hasChildren) {
                $output .= '<' . $element . ' class="menu' . $classPartLabel . '-level-' . $config['level'] . ' js-menu' . $classPartLabel . '-level-' . $config['level'] . '">';
            }
            $output .= '<a href="' . $this->getUrl() . $category->getUrl() . '" class="menu' . $classPartLabel . '-level-' . $config['level'] . '-link">' . $category->getName() . '</a>';

            // recurse to children
            if ($hasChildren) {
                $output .= $this->recurse([
                    'categories' => $config['categories'],
                    'idParent' => $category->getId(),
                    'level' => $config['level'] + 1
                ]);
            }
            if ($hasChildren) {
                $output .= $elementClose;
            }
        }

        // not root levels
        if ($config['idParent']) {
            $output .= $elementClose;
        }

        // html
        return $output;
    }


    /**
     * looks for child in category list, to avoid empty uls
     * @param  array  $categories 
     * @param  integer  $idParent   
     * @return boolean|null             if found true
     */
    public function hasChild($config)
    {
        if (! $config['categoryId']) {
            return;
        }
        foreach ($config['categories'] as $category) {
            if ($category->getIdParent() == $config['categoryId']) {
                return true;
            }
        }
    }   


    /**
     * @return string 
     */
    public function getLabel() {
        return $this->label;
    }
    
    
    /**
     * @param string $label 
     */
    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }


    /**
     * @return string 
     */
    public function getElement() {
        return $this->element;
    }
    
    
    /**
     * @param string $element 
     */
    public function setElement($element) {
        $this->element = $element;
        return $this;
    }
}
