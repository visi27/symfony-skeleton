<?php
/**
 * Created by PhpStorm.
 * User: evis
 * Date: 6/7/17
 * Time: 10:45 AM
 */

namespace AppBundle\Menu;


use AppBundle\Entity\Menu;

class MenuHelper
{
    /**
     * @var Menu[]|array $menuObjects
     */
    private $menuObjects;

    /**
     * MenuHelper constructor.
     * @param Menu[] $menuObjects
     */
    public function __construct(array $menuObjects)
    {
        $this->menuObjects = $menuObjects;
    }

    /**
     * @return array
     */
    public function getMenuTree()
    {
        $menuTree = array();
        foreach ($this->menuObjects as $menuRecord) {

            if ($menuRecord->getParentId() == 0) {
                $menuTree[$menuRecord->getId()] = [
                    "icon" => $menuRecord->getIcon(),
                    "name" => $menuRecord->getName(),
                    "link" => $menuRecord->getLink(),
                    "hasChildren" => false,
                    "childrens" => array(),
                ];
            } else {
                $menuTree[$menuRecord->getParentId()]["hasChildren"] = true;
                array_push(
                    $menuTree[$menuRecord->getParentId()]["childrens"],
                    [
                        "name" => $menuRecord->getName(),
                        "link" => $menuRecord->getLink(),
                        "icon" => $menuRecord->getIcon(),
                        "header" =>$menuRecord->getNavHeader()
                    ]
                );
            }
        }

        return $menuTree;
    }
}