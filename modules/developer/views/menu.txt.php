<?php defined("SYSPATH") or die("No direct script access.") ?>
<?= "<?php defined(\"SYSPATH\") or die(\"No direct script access.\");" ?>
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2009 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */
class <?= $module ?>_menu {
  static function admin($menu, $theme) {
    $menu->get("settings_menu")
      ->append(Menu::factory("link")
        ->id("<?= $module ?>_menu")
        ->label(t("<?= $module_name ?> Administration"))
        ->url(url::site("admin/<?= $module ?>")));
  }
  
<? if (!empty($callbacks["album"])): ?>
  static function album($menu, $theme) {
  }
  
<? endif ?>
<? if (!empty($callbacks["photo"])): ?>
  static function photo($menu, $theme) {
  }
  
<? endif ?>
  static function site($menu, $theme) {
    $item = $theme->item();

    if ($item && access::can("edit", $item)) {
      $options_menu = $menu->get("options_menu")
        ->append(Menu::factory("dialog")
          ->id("<?= $module ?>")
          ->label(t("Peform <?= $module_name ?> Processing"))
          ->url(url::site("<?= $module ?>/index/$item->id")));
    }
  }
}
