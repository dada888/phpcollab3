<?php
/**
 * This file is part of the phpCollab3 package.
 * (c) 2009 Ideato s.r.l. <phpcollab@ideato.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * pager_navigation function
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Helpers
 */

/**
 * Helper for displaying pages navigation.
 *
 * @package    phpCollab3
 * @subpackage idProjectManagementPlugin Helpers
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 * @see http://trac.symfony-project.org/wiki/sfDoctrinePager
 */


function pager_navigation_log_time($pager, $uri)
{
  $navigation = '';

  if ($pager->haveToPaginate())
  {
    $uri .= (preg_match('/\?/', $uri) ? '&' : '?').'page=';

    // First and previous page
    if ($pager->getPage() != 1)
    {
      $navigation .= '<li>'.link_to('<img title="First" alt="First" src="images/pagination-left.png">',$uri.'1').'</li>';
      $navigation .= '<li>'.link_to('<img title="Previous" alt="Previous" src="images/pagination-left.png">',$uri.$pager->getPreviousPage()).'</li>';
    }

    // Pages one by one
    $links = array();
    foreach ($pager->getLinks() as $page)
    {
      $class = ($page == $pager->getPage()) ? 'current_page': '';

      $links[] = '<li><a href="'.url_for($uri.$page).'" class="'.$class.'">'.$page.'</a></li>';
    }
    $navigation .= join('  ', $links);

    // Next and last page
    if ($pager->getPage() != $pager->getLastPage())
    {
      $navigation .= '<li>'.link_to('<img title="Next" alt="Next" src="images/pagination-left.png">',$uri.$pager->getNextPage()).'</li>';
      $navigation .= '<li>'.link_to('<img title="Last" alt="Last" src="images/pagination-left.png">',$uri.$pager->getLastPage()).'</li>';
    }

  }

  return $navigation;
}


function pager_navigation($pager, $uri)
{
  $navigation = '';

  if ($pager->haveToPaginate())
  {
    $uri .= (preg_match('/\?/', $uri) ? '&' : '?').'page=';

    // First and previous page
    if ($pager->getPage() != 1)
    {
      $navigation .= link_to(image_tag('/sf/sf_admin/images/first.png', 'align=absmiddle'), $uri.'1');
      $navigation .= link_to(image_tag('/sf/sf_admin/images/previous.png', 'align=absmiddle'), $uri.$pager->getPreviousPage()).' ';
    }

    // Pages one by one
    $links = array();
    foreach ($pager->getLinks() as $page)
    {
      $links[] = link_to_unless($page == $pager->getPage(), $page, $uri.$page);
    }
    $navigation .= join('  ', $links);

    // Next and last page
    if ($pager->getPage() != $pager->getLastPage())
    {
      $navigation .= ' '.link_to(image_tag('/sf/sf_admin/images/next.png', 'align=absmiddle'), $uri.$pager->getNextPage());
      $navigation .= link_to(image_tag('/sf/sf_admin/images/last.png', 'align=absmiddle'), $uri.$pager->getLastPage());
    }

  }

  return $navigation;
}

function ajax_pager_navigation($pager, $uri)
{
  $navigation = '';

  if ($pager->haveToPaginate())
  {
    $uri .= (preg_match('/\?/', $uri) ? '&' : '?').'page=';

    // First and previous page
    if ($pager->getPage() != 1)
    {
      $navigation .= link_to(image_tag('/sf/sf_admin/images/first.png', 'align=absmiddle'), $uri.'1', array('onclick' => 'loadAjaxCommentList(\''.$uri.'1\'); return false;'));
      $navigation .= link_to(image_tag('/sf/sf_admin/images/previous.png', 'align=absmiddle'), $uri.$pager->getPreviousPage(), array('onclick' => 'loadAjaxCommentList(\''. $uri.$pager->getPreviousPage().'\'); return false;')).' ';
    }

    // Pages one by one
    $links = array();
    foreach ($pager->getLinks() as $page)
    {
      if ($page == $pager->getPage())
      {
        $links[] = '<span>'.$pager->getPage().'</span>';
        continue;
      }

      $links[] = link_to($page, $uri.$page, array('onclick' => 'loadAjaxCommentList(\''.$uri.$page.'\'); return false;'));
    }
    
    $navigation .= join('  ', $links);

    // Next and last page
    if ($pager->getPage() != $pager->getLastPage())
    {
      $navigation .= ' '.link_to(image_tag('/sf/sf_admin/images/next.png', 'align=absmiddle'), $uri.$pager->getNextPage(), array('onclick' => 'loadAjaxCommentList(\''.$uri.$page.'\'); return false;'));
      $navigation .= link_to(image_tag('/sf/sf_admin/images/last.png', 'align=absmiddle'), $uri.$pager->getLastPage(), array('onclick' => 'loadAjaxCommentList(\''.$uri.$page.'\'); return false;'));
    }

  }

  return $navigation;
}
