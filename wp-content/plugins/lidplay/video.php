<?php

/*  Copyright 2017  LidPlay  (email: contact@lidplay.net)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

function get_domain($url) {
    $url = str_replace('http://', '', $url);
    $url = str_replace('https://', '', $url);
    $url = str_replace('m.', '', $url);
    $url = str_replace('www.', '', $url);
    $url = str_replace('mobile.', '', $url);
    $url = explode('/', $url);

    return reset($url);
}

if (get_domain($_SERVER['HTTP_HOST']) != get_domain($_SERVER['HTTP_REFERER'])) {
    die('Access denied');
}

header('Location: https://lidplay.net/video/?' . http_build_query($_GET));
