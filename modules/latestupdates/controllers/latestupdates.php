<?php defined("SYSPATH") or die("No direct script access.");
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
class latestupdates_Controller extends Controller {
  
  public function albums($id) {
    // Figure out how many items to display on each page.
    $itemsPerPage = module::get_var("gallery", "page_size", 9);
    
    // Figure out which page # the visitor is on and 
    //	don't allow the visitor to go below page 1.
    $page = $this->input->get("page", 1);
    if ($page < 1) {
      url::redirect("latestupdates/albums/{$item->id}");
    }
    
    // First item to display.
    $offset = ($page - 1) * $itemsPerPage;
    
    // Determine the total number of items,
    //	for page numbering purposes.     
    $count = ORM::factory("item", $id)
      ->viewable()
      ->where("type !=", "album")
      ->orderby("created", "DESC")
      ->descendants()
      ->count();
    
    // Figure out what the highest page number is.
    $max_pages = ceil($count / $itemsPerPage);   
  	
    // Don't let the visitor go past the last page.
  	if ($max_pages && $page > $max_pages) {
      url::redirect("latestupdates/albums/{$item->id}?page=$max_pages");
    }
    
    // Figure out which items to display on this page.
    $children = ORM::factory("item", $id)
      ->viewable()
      ->where("type !=", "album")
      ->orderby("created", "DESC")
      ->limit($itemsPerPage)
      ->offset($offset)
      ->descendants();      
              
    // Set up the previous and next page buttons.
    if ($page > 1) {
      $previous_page = $page - 1;
      $view->previous_page_link = url::site("latestupdates/albums/{$item->id}?page={$previous_page}");
    }
    if ($page < $max_pages) {
      $next_page = $page + 1;
      $view->next_page_link = url::site("latestupdates/albums/{$item->id}?page={$next_page}");
    }

    // Set up and display the actual page.
    $template = new Theme_View("page.html", "updates");
    $template->set_global("page_size", $itemsPerPage);
    $template->set_global("children_count", $count);
    $template->content = new View("updates.html");
    $template->content->items = $children;
    $template->content->q = count($children);
    print $template;
  }

  public function updates() {
   // Figure out how many items to display on each page.
   $itemsPerPage = module::get_var("gallery", "page_size", 9);

   // Figure out which page # the visitor is on and 
   //	don't allow the visitor to go below page 1.
   $page = $this->input->get("page", 1);
    if ($page < 1) {
      url::redirect("latestupdates/updates");
    }
    
    // First item to display.
    $offset = ($page - 1) * $itemsPerPage;
    
    // Determine the total number of items,
    //	for page numbering purposes. 
    $count = ORM::factory("item")
      ->viewable()
      ->where("type !=", "album")
      ->find_all()
      ->count();
    
    // Figure out what the highest page number is.
    $max_pages = ceil($count / $itemsPerPage);
    
    // Don't let the visitor go past the last page.
    if ($max_pages && $page > $max_pages) {
      url::redirect("latestupdates/updates?page=$max_pages");
    }
    
    // Figure out which items to display on this page.
    $items = ORM::factory("item")
      ->viewable()
      ->where("type !=", "album")
      ->orderby("created", "DESC")
      ->find_all($itemsPerPage, $offset);
          
    // Set up the previous and next page buttons.
    if ($page > 1) {
      $previous_page = $page - 1;
      $view->previous_page_link = url::site("latestupdates/updates?page={$previous_page}");
    }
    if ($page < $max_pages) {
      $next_page = $page + 1;
      $view->next_page_link = url::site("latestupdates/updates?page={$next_page}");
    }
    
    // Set up and display the actual page.
    $template = new Theme_View("page.html", "updates");
    $template->set_global("page_size", $itemsPerPage);
    $template->set_global("children_count", $count);
    $template->content = new View("updates.html");
    $template->content->items = $items;
    $template->content->q = count($items);
    print $template;
  }

}