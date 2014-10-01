<?php

/**
 * Apptha
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.apptha.com/LICENSE.txt
 *
 * ==============================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * ==============================================================
 * This package designed for Magento COMMUNITY edition
 * Apptha does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Apptha does not provide extension support in case of
 * incorrect edition usage.
 * ==============================================================
 *
 * @category    Apptha
 * @package     Apptha_Marketplace
 * @version     1.2.3
 * @author      Apptha Team <developers@contus.in>
 * @copyright   Copyright (c) 2014 Apptha. (http://www.apptha.com)
 * @license     http://www.apptha.com/LICENSE.txt
 * 
 */

/**
 * Header Menu Responsive for mobile and tablet
 */
class Apptha_CustomMenu_Block_Navigation extends Mage_Catalog_Block_Navigation {

    const CUSTOM_BLOCK_TEMPLATE = "custom_menu_%d";

    private $_productsCount = null;
    private $_topMenu = array();
    private $_popupMenu = array();

    /**
     * Function to display mobile responsive menu
     * 
     * Passed the category to get the header menu hierarchy
     * @param int $category
     * 
     * Set the hierarchy level
     * @param int $level
     * 
     * Check whether the sub menu is last or not
     * @param bool $last
     * 
     * This Function will return Header menu display hierarchy for web
     * @return string
     */
    public function drawCustomMenuMobileItem($category, $level = 0, $last = false) {
        if (!$category->getIsActive())
            return '';
        $html = array();
        $id = $category->getId();
        /**
         * Sub Categories
         */
        $activeChildren = $this->_getActiveChildren($category, $level);
        /**
         * class for active category
         */
        $active = '';
        if ($this->isCategoryActive($category))
            $active = ' act';
        $hasSubMenu = count($activeChildren);
        $catUrl = $this->getCategoryUrl($category);
        $html[] = '<div id="menu-mobile-' . $id . '" class="menu-mobile level0' . $active . '">';
        $html[] = '<div class="parentMenu">';
        /**
         * Top Menu Item
         */
        $html[] = '<a href="' . $catUrl . '">';
        $name = $this->escapeHtml($category->getName());
        if (Mage::getStoreConfig('custom_menu/general/non_breaking_space')) {
            $name = str_replace(' ', '&nbsp;', $name);
        }
        $html[] = '<span>' . $name . '</span>';
        $html[] = '</a>';
        if ($hasSubMenu) {
            $html[] = '<span class="button" rel="submenu-mobile-' . $id . '" onclick="SubMenuToggle(this, \'menu-mobile-' . $id . '\', \'submenu-mobile-' . $id . '\');">&nbsp;</span>';
        }
        $html[] = '</div>';
        /**
         * Add Popup block (hidden)
         */
        if ($hasSubMenu) {
            /**
             *  draw Sub Categories
             */
            $html[] = '<div id="submenu-mobile-' . $id . '" rel="level' . $level . '" class="custom-menu-submenu" style="display: none;">';
            $html[] = $this->drawMobileMenuItem($activeChildren);
            $html[] = '<div class="clearBoth"></div>';
            $html[] = '</div>';
        }
        $html[] = '</div>';
        $html = implode("\n", $html);
        return $html;
    }

    /**
     * Get the Top menu array      
     * 
     * This Function will return the top menu's
     * @return string
     */
    public function getTopMenuArray() {
        return $this->_topMenu;
    }

    /**
     * Get the pop up menu array      
     * 
     * This Function will return the pop up menu's
     * @return string
     */
    public function getPopupMenuArray() {
        return $this->_popupMenu;
    }

    /**
     * Function to display custom menu(home) mobile responsive menu
     * 
     * Passed the category to get the header menu hierarchy
     * @param int $category
     * 
     * Set the hierarchy level
     * @param int $level
     * 
     * Check whether the sub menu is last or not
     * @param bool $last
     * 
     * This Function will return Header menu display hierarchy for web 
     * @return string
     */
    public function drawCustomMenuItem($category, $level = 0, $last = false) {
        if (!$category->getIsActive())
            return;
        $htmlTop = array();
        $id = $category->getId();
        $imageSrc = Mage::getModel('catalog/category')->load($id)->getThumbnail();
        /**
         * Static Block
         */
        $blockId = sprintf(self::CUSTOM_BLOCK_TEMPLATE, $id);
        /**
         * Mage::log($blockId);
         */
        $collection = Mage::getModel('cms/block')->getCollection()
                ->addFieldToFilter('identifier', array(array('like' => $blockId . '_w%'), array('eq' => $blockId)))
                ->addFieldToFilter('is_active', 1);
        $blockId = $collection->getFirstItem()->getIdentifier();
        /**
         * Mage::log($blockId);
         */
        $blockHtml = Mage::app()->getLayout()->createBlock('cms/block')->setBlockId($blockId)->toHtml();
        /**
         *  Sub Categories 
         */
        $activeChildren = $this->_getActiveChildren($category, $level);
        /**
         * Class for active category
         */
        $active = '';
        if ($this->isCategoryActive($category))
            $active = ' act';
        /**
         *  Popup functions for show 
         */
        $drawPopup = ($blockHtml || count($activeChildren));
        if ($drawPopup) {
            $htmlTop[] = '<div id="menu' . $id . '" class="menu' . $active . '" onmouseover="ShowMenuPopup(this, event, \'popup' . $id . '\');" onmouseout="HideMenuPopup(this, event, \'popup' . $id . '\', \'menu' . $id . '\')">';
        } else {
            $htmlTop[] = '<div id="menu' . $id . '" class="menu' . $active . '">';
        }
        /**
         *  Top Menu Item 
         */
        $htmlTop[] = '<div class="parentMenu">';
        if ($level == 0 && $drawPopup) {
            $htmlTop[] = '<a href="javascript:void(0);" rel="' . $this->getCategoryUrl($category) . '">';
        } else {
            $htmlTop[] = '<a href="' . $this->getCategoryUrl($category) . '">';
        }
       $name = $this->escapeHtml($category->getName());
      $categoryImage = $category->getThumbnail();
        if (Mage::getStoreConfig('custom_menu/general/non_breaking_space')) {
            $name = str_replace(' ', '&nbsp;', $name);
        }
        $htmlTop[] = '<span>' . $name . '</span>';
        $htmlTop[] = '</a>';
        $htmlTop[] = '</div>';
        $htmlTop[] = '</div>';
        $this->_topMenu[] = implode("\n", $htmlTop);
        /**
         * Add Popup block (hidden)
         */
        if ($drawPopup) {
            $htmlPopup = array();
            /**
             *  Popup function for hide 
             */
            $htmlPopup[] = '<div id="popup' . $id . '" class="custom-menu-popup" onmouseout="HideMenuPopup(this, event, \'popup' . $id . '\', \'menu' . $id . '\')" onmouseover="PopupOver(this, event, \'popup' . $id . '\', \'menu' . $id . '\')">';
            /**
             *  draw Sub Categories
             */
            if (count($activeChildren)) {
                $columns = (int) Mage::getStoreConfig('custom_menu/columns/count');
                $htmlPopup[] = '<div class="block1">';
                $htmlPopup[] = $this->drawColumns($activeChildren, $columns);
                $htmlPopup[] = '<div class="clearBoth"></div>';
                $htmlPopup[] = '</div>';
                if ($imageSrc!='') {
	                $htmlPopup[] = '<div class="category-image-menu">';
	                $htmlPopup[] = '<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'catalog/category/' . $imageSrc.'"/>';
	                $htmlPopup[] = '</div>';
                }
            }

                
            /**
             * draw Custom User Block
             */
            if ($blockHtml) {
                $htmlPopup[] = '<div id="' . $blockId . '" class="block2">';
                $htmlPopup[] = $blockHtml;
                $htmlPopup[] = '</div>';
            }
            $htmlPopup[] = '</div>';
            $this->_popupMenu[] = implode("\n", $htmlPopup);
        }
    }

    /**
     * Function to display mobile menu
     * 
     * Passed the sub menu item 
     * @param int $children
     * 
     * Set the hierarchy level
     * @param int $level     
     * 
     * This Function will return Header mobile menu display hierarchy for mobile view
     * @return string
     */
    public function drawMobileMenuItem($children, $level = 1) {
        $keyCurrent = $this->getCurrentCategory()->getId();
        $html = '';
        foreach ($children as $child) {
            if (is_object($child) && $child->getIsActive()) {
                /**
                 * class for active category
                 */
                $active = '';
                $id = $child->getId();
                $activeChildren = $this->_getActiveChildren($child, $level);
                if ($this->isCategoryActive($child)) {
                    $active = ' actParent';
                    if ($id == $keyCurrent)
                        $active = ' act';
                }
                $html.= '<div id="menu-mobile-' . $id . '" class="itemMenu level' . $level . $active . '">';
                /**
                 * format category name
                 */
                $name = $this->escapeHtml($child->getName());
                if (Mage::getStoreConfig('custom_menu/general/non_breaking_space'))
                    $name = str_replace(' ', '&nbsp;', $name);
                $html.= '<div class="parentMenu">';
                $html.= '<a class="itemMenuName level' . $level . '" href="' . $this->getCategoryUrl($child) . '"><span>' . $name . '</span></a>';
                if (count($activeChildren) > 0) {
                    $html.= '<span class="button" rel="submenu-mobile-' . $id . '" onclick="SubMenuToggle(this, \'menu-mobile-' . $id . '\', \'submenu-mobile-' . $id . '\');">&nbsp;</span>';
                }
                $html.= '</div>';
                if (count($activeChildren) > 0) {
                    $html.= '<div id="submenu-mobile-' . $id . '" rel="level' . $level . '" class="custom-menu-submenu level' . $level . '" style="display: none;">';
                    $html.= $this->drawMobileMenuItem($activeChildren, $level + 1);
                    $html.= '<div class="clearBoth"></div>';
                    $html.= '</div>';
                }
                $html.= '</div>';
            }
        }
        return $html;
    }

    /**
     * Function to display top level menu 
     * 
     * Passed the sub menu item 
     * @param int $children
     * 
     * Set the hierarchy level
     * @param int $level     
     * 
     * This Function will return Header mobile menu display hierarchy for mobile view
     * @return string
     */
    public function drawMenuItem($children, $level = 1) {
        $html = '<div class="itemMenu level' . $level . '">';
        $keyCurrent = $this->getCurrentCategory()->getId();
        foreach ($children as $child) {
            if (is_object($child) && $child->getIsActive()) {
                /**
                 *  class for active category
                 */
                $active = '';
                if ($this->isCategoryActive($child)) {
                    $active = ' actParent';
                    if ($child->getId() == $keyCurrent)
                        $active = ' act';
                }
                /**
                 * format category name
                 */
                $name = $this->escapeHtml($child->getName());
                if (Mage::getStoreConfig('custom_menu/general/non_breaking_space'))
                    $name = str_replace(' ', '&nbsp;', $name);
                $html.= '<a class="itemMenuName level' . $level . $active . '" href="' . $this->getCategoryUrl($child) . '"><span>' . $name . '</span></a>';
                $activeChildren = $this->_getActiveChildren($child, $level);
                if (count($activeChildren) > 0) {
                    $html.= '<div class="itemSubMenu level' . $level . '">';
                    $html.= $this->drawMenuItem($activeChildren, $level + 1);
                    $html.= '</div>';
                }
            }
        }
        $html.= '</div>';
        return $html;
    }

    /**
     * Function to split menu by columns  
     * 
     * Passed the sub menu item 
     * @param int $children
     * 
     * Set the $columns
     * @param int $columns     
     * 
     * This Function will return the number of columns 
     * @return string
     */
    public function drawColumns($children, $columns = 1) {
        $html = '';
        /**
         *  explode by columns
         */
        if ($columns < 1)
            $columns = 1;
        $chunks = $this->_explodeByColumns($children, $columns);
        /**
         * draw columns
         */
        $lastColumnNumber = count($chunks);
        $i = 1;
        foreach ($chunks as $key => $value) {
            if (!count($value))
                continue;
            $class = '';
            if ($i == 1)
                $class.= ' first';
            if ($i == $lastColumnNumber)
                $class.= ' last';
            if ($i % 2)
                $class.= ' odd';
            else
                $class.= ' even';
            $html.= '<div class="column' . $class . '">';
            $html.= $this->drawMenuItem($value, 1);
            $html.= '</div>';
            $i++;
        }
        return $html;
    }

    /**
     * Function to get the active sub menus in header  
     * 
     * Passed the parent menu item 
     * @param int $parent
     * 
     * Set the $level
     * @param int $level     
     * 
     * This Function will return active sub menu items in web
     * @return string
     */
    protected function _getActiveChildren($parent, $level) {
        $activeChildren = array();
        /**
         * check level
         */
        $maxLevel = (int) Mage::getStoreConfig('custom_menu/general/max_level');
        if ($maxLevel > 0) {
            if ($level >= ($maxLevel - 1))
                return $activeChildren;
        }
        /**
         *  check level
         */
        if (Mage::helper('catalog/category_flat')->isEnabled()) {
            $children = $parent->getChildrenNodes();
            $childrenCount = count($children);
        } else {
            $children = $parent->getChildren();
            $childrenCount = $children->count();
        }
        $hasChildren = $children && $childrenCount;
        if ($hasChildren) {
            foreach ($children as $child) {
                if ($this->_isCategoryDisplayed($child)) {
                    array_push($activeChildren, $child);
                }
            }
        }
        return $activeChildren;
    }

    /**
     * Function to display the categories
     * 
     * Passed the child menu item 
     * @param int $child        
     * 
     * This Function will return caregories
     * @return string
     */
    private function _isCategoryDisplayed(&$child) {
        if (!$child->getIsActive())
            return false;
        /**
         *  check products count
         */
        /**
         * get collection info
         */
        if (!Mage::getStoreConfig('custom_menu/general/display_empty_categories')) {
            $data = $this->_getProductsCountData();
            /**
             * check by id
             */
            $id = $child->getId();
            /**
             * Mage::log($id); Mage::log($data);
             */
            if (!isset($data[$id]) || !$data[$id]['product_count'])
                return false;
        }
        /**
         *  check products count
         */
        return true;
    }

    /**
     * Function to get the category wise product count           
     * 
     * This Function will return product count
     * @return int
     */
    private function _getProductsCountData() {
        if (is_null($this->_productsCount)) {
            $collection = Mage::getModel('catalog/category')->getCollection();
            $storeId = Mage::app()->getStore()->getId();
            /**
             *  @var $collection Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Collection 
             */
            $collection->addAttributeToSelect('name')
                    ->addAttributeToSelect('is_active')
                    ->setProductStoreId($storeId)
                    ->setLoadProductCount(true)
                    ->setStoreId($storeId);
            $productsCount = array();
            foreach ($collection as $cat) {
                $productsCount[$cat->getId()] = array(
                    'name' => $cat->getName(),
                    'product_count' => $cat->getProductCount(),
                );
            }
            /**
             * Mage::log($productsCount);
             */
            $this->_productsCount = $productsCount;
        }
        return $this->_productsCount;
    }

    /**
     * Function to split the menu by columns
     * 
     * Passed the target column to split the menu
     * @param int $target        
     * 
     * Passed the number of column to be split the menu
     * @param int $num 
     *  
     * This Function will return caregories
     * @return string
     */
    private function _explodeByColumns($target, $num) {
        if ((int) Mage::getStoreConfig('custom_menu/columns/divided_horizontally')) {
            $target = self::_explodeArrayByColumnsHorisontal($target, $num);
        } else {
            $target = self::_explodeArrayByColumnsVertical($target, $num);
        }
        /**
         * return $target;
         */
        if ((int) Mage::getStoreConfig('custom_menu/columns/integrate') && count($target)) {
            /**
             * combine consistently numerically small column
             */
            /**
             *  1. calc length of each column
             */
            $max = 0;
            $columnsLength = array();
            foreach ($target as $key => $child) {
                $count = 0;
                $this->_countChild($child, 1, $count);
                if ($max < $count)
                    $max = $count;
                $columnsLength[$key] = $count;
            }
            /**
             *  2. merge small columns with next 
             */
            $xColumns = array();
            $column = array();
            $cnt = 0;
            $xColumnsLength = array();
            $k = 0;
            foreach ($columnsLength as $key => $count) {
                $cnt+= $count;
                if ($cnt > $max && count($column)) {
                    $xColumns[$k] = $column;
                    $xColumnsLength[$k] = $cnt - $count;
                    $k++;
                    $column = array();
                    $cnt = $count;
                }
                $column = array_merge($column, $target[$key]);
            }
            $xColumns[$k] = $column;
            $xColumnsLength[$k] = $cnt - $count;
            /**
             * 3. integrate columns of one element
             */
            $target = $xColumns;
            $xColumns = array();
            $nextKey = -1;
            if ($max > 1 && count($target) > 1) {
                foreach ($target as $key => $column) {
                    if ($key == $nextKey)
                        continue;
                    if ($xColumnsLength[$key] == 1) {
                        /**
                         * merge with next column
                         */
                        $nextKey = $key + 1;
                        if (isset($target[$nextKey]) && count($target[$nextKey])) {
                            $xColumns[] = array_merge($column, $target[$nextKey]);
                            continue;
                        }
                    }
                    $xColumns[] = $column;
                }
                $target = $xColumns;
            }
        }
        $_rtl = Mage::getStoreConfigFlag('custom_menu/general/rtl');
        if ($_rtl) {
            $target = array_reverse($target);
        }
        return $target;
    }

    /**
     * Function to count the child categories
     * 
     * Passed the children category to get the count
     * @param int $children 
     *      
     * Passed the count of the children
     * @param int $count 
     * 
     * Set the hierarchy level
     * @param int $level
     *  
     * This Function will return caregories
     * @return string
     */
    private function _countChild($children, $level, &$count) {
        foreach ($children as $child) {
            if ($child->getIsActive()) {
                $count++;
                $activeChildren = $this->_getActiveChildren($child, $level);
                if (count($activeChildren) > 0)
                    $this->_countChild($activeChildren, $level + 1, $count);
            }
        }
    }

    /**
     * Function to split the menu by columns in Horizontal
     * 
     * Passed the list of menu
     * @param int $list        
     * 
     * Passed the number of column to be split the menu
     * @param int $num 
     *  
     * This Function will return caregories
     * @return string
     */
    private static function _explodeArrayByColumnsHorisontal($list, $num) {
        if ($num <= 0)
            return array($list);
        $partition = array();
        $partition = array_pad($partition, $num, array());
        $i = 0;
        foreach ($list as $key => $value) {
            $partition[$i][$key] = $value;
            if (++$i == $num)
                $i = 0;
        }
        return $partition;
    }

    /**
     * Function to split the menu by columns in Vertical
     * 
     * Passed the list of menu
     * @param int $list        
     * 
     * Passed the number of column to be split the menu
     * @param int $num 
     *  
     * This Function will return caregories
     * @return string
     */
    private static function _explodeArrayByColumnsVertical($list, $num) {
        if ($num <= 0)
            return array($list);
        $listlen = count($list);
        $partlen = floor($listlen / $num);
        $partrem = $listlen % $num;
        $partition = array();
        $mark = 0;
        for ($column = 0; $column < $num; $column++) {
            $incr = ($column < $partrem) ? $partlen + 1 : $partlen;
            $partition[$column] = array_slice($list, $mark, $incr);
            $mark += $incr;
        }
        return $partition;
    }

}
