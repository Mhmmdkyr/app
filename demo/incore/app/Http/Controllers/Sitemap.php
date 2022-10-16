<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Category;

class Sitemap extends Controller
{

    public function index(){
      $all_posts = new Posts();
      $posts =  $all_posts->all_posts();
      $posts = $posts->orderBy('publish_date', 'desc')->limit(10000)->get();

      $categories = Category::limit(10000)->get();

      $pages = Page::limit(10000)->get();

      header('Content-type: Application/xml; charset="utf8"', true);
      echo '<urlset
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xmlns:xhtml="http://www.w3.org/1999/xhtml"
        xsi:schemaLocation="
            http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
      foreach($posts as $post){
        echo '<url>';
        echo '    <loc>'.uri('post', $post->slug).'</loc>';
        echo '    <lastmod>'.$post->updated_at.'</lastmod>';
        echo '    <changefreq>daily</changefreq>';
        echo '    <priority>1.00</priority>';
        echo '</url>';
      }

      foreach($categories as $category){
        echo '<url>';
        echo '    <loc>'.uri('category', $category->slug).'</loc>';
        echo '    <lastmod>'.$category->updated_at.'</lastmod>';
        echo '    <changefreq>daily</changefreq>';
        echo '    <priority>1.00</priority>';
        echo '</url>';
      }

      foreach($pages as $page){
        echo '<url>';
        echo '    <loc>'.uri('page', $page->slug).'</loc>';
        echo '    <lastmod>'.$page->updated_at.'</lastmod>';
        echo '    <changefreq>daily</changefreq>';
        echo '    <priority>1.00</priority>';
        echo '</url>';
      }
      echo '</urlset>';
    }
}
