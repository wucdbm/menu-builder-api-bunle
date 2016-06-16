<?php

namespace Wucdbm\Bundle\MenuBuilderApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Wucdbm\Bundle\MenuBuilderBundle\Entity\MenuItem;
use Wucdbm\Bundle\WucdbmBundle\Controller\BaseController;

class MenuController extends BaseController {

    public function getAction($id, Request $request) {
        if ($request->query->get('secret') != $this->container->getParameter('wucdbm_menu_builder_api.secret')) {
            return $this->json([]);
        }

        $manager = $this->container->get('wucdbm_menu_builder.manager.menus');

        $menu = $manager->findOneById($id);

        if (!$menu) {
            return $this->json([]);
        }

        if (!$menu->getIsApiVisible()) {
            return $this->json([]);
        }

        $data = [
            'name' => $menu->getName()
        ];

        /** @var MenuItem $item */
        foreach ($menu->getItems() as $item) {
            if ($item->getParent()) {
                continue;
            }
            $data['items'][] = $this->fetchItem($item);
        }

        return $this->json($data);
    }

    protected function fetchItem(MenuItem $item) {
        $manager = $this->container->get('wucdbm_menu_builder.manager.menus');
        $data = [
            'name'     => $item->getName(),
            'url'      => $manager->generateMenuItemUrl($item),
            'children' => []
        ];
        foreach ($item->getChildren() as $child) {
            $data['children'][] = $this->fetchItem($child);
        }

        return $data;
    }

}