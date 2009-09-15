<?php

use_helper('Text');

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
 * @subpackage idProjectManagmentPlugin Helpers
 */

/**
 * Helper for displaying formatted text
 *
 * @package    phpCollab3
 * @subpackage idProjectManagmentPlugin Helpers
 * @author     Filippo (p16) De Santis <fd@ideato.it>
 * @author     Andrea (giorg) Giorgini <ag@ideato.it>
 */
function auto_link($text, $link = 'all')
{
  if ($link == 'all')
  {
    return _auto_link(_auto_link_email_addresses($text));
  }
  else if ($link == 'email_addresses')
  {
    return _auto_link_email_addresses($text);
  }
  else if ($link == 'urls')
  {
    return _auto_link($text);
  }
}

function _auto_link($text)
{
   return preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '<a href="$1">$1</a>', $text);
}