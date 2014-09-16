<?php


/**
 * build menu using passed data structure
 * can be outputted as html
 * @author Martin Wyatt <martin.wyatt@gmail.com> 
 * @version 0.1
 * @license http://www.php.net/license/3_01.txt PHP License 3.01
 */
class Menu
{


    /**
     * modifies the class names to customise the menu
     * @var string
     */
    public $label = '';


    /**
     * generic storage
     * @var string
     */
    public $data;


    /**
     * @return string 
     */
    public function getData() {
        return $this->data;
    }
    
    
    /**
     * @param string $data 
     */
    public function setData($data) {
        $this->data = $data;
        return $this;
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
     * builds a tree using categories array
     * @param  array $categories 
     * @return object             
     */
    public function buildTree($categories)
    {
        $this->setData($this->recurse($categories));
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
     * @param  array  $categories 
     * @param  integer $parentId   
     * @param  integer $level      
     * @return string              html
     */
    public function recurse($categories, $parentId = 0, $level = 1)
    {

        // not root levels
        if ($parentId) {
            $output = '<div class="menu' . $this->getClassPartLabel() . '-level-' . $level . ' js-menu' . $this->getClassPartLabel() . '-level-' . $level . '">';
        }

        // category loop
        foreach ($categories as $category) {

            // must have a positive parent
            if ($category->parent != $parentId) {
                continue;
            }

            // children?
            $hasChildren = $this->hasChild($categories, $category->id);

            // single menu item
            if ($hasChildren) {
                $output .= '<div class="menu' . $this->getClassPartLabel() . '-level-' . $level . ' js-menu' . $this->getClassPartLabel() . '-level-' . $level . '">';
            }
            $output .= '<a href="' . $category->url . '" class="menu' . $this->getClassPartLabel() . '-level-' . $level . '-link">' . $category->name . '</a>';

            // recurse to children
            if ($hasChildren) {
                $output .= $this->recurse(
                    $categories,
                    $category->id,
                    $level + 1
                );
            }
            if ($hasChildren) {
                $output .= '</div>';
            }
        }

        // not root levels
        if ($parentId) {
            $output .= '</div>';
        }

        // html
        return $output;
    }


    /**
     * looks for child in category list, to avoid empty uls
     * @param  array  $categories 
     * @param  integer  $parentId   
     * @return boolean|null             if found true
     */
    public function hasChild($categories, $categoryId)
    {
        if (! $categoryId) {
            return;
        }
        foreach ($categories as $category) {
            if ($category->parent == $categoryId) {
                return true;
            }
        }
    }   
}
