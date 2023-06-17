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
            $nama_menu = ($menu->is_required)?$menu->menu." <label class='text text-danger'>*</label>":$menu->menu ." <label>&nbsp;</label>";
            if(!$menu->hide) {
                $listMenu .= "<li class='nav-item'>
                    <a class='nav-link ".$active."' href='".route($menu->route)."'><i class='".$menu->icon."'></i> ".$nama_menu."</a>
                </li>";
            }
        }
        
        echo $listMenu;
    }

}