<?php

namespace App\Helpers;
use App\Models\MenuManager;

class MenuManagers {

    public static function listMenu(){
        $menus = MenuManager::all();
        $listMenu = "";
        foreach($menus as $menu) {
            $splitRoute = explode(".",$menu->route);
            $active = (request()->is($splitRoute[0]."*")) ? "active" : "";
            $listMenu .= "<li class='nav-item'>
                <a class='nav-link ".$active."' href='".route($menu->route)."'><i class='".$menu->icon."'></i> ".$menu->menu."</a>
            </li>";
        }
        
        echo $listMenu;
    }

}