<?php
/**
 * Metadata Preview Front-End
 *
 * PHP version 5
 *
 * Copyright (C) Eero Heikkinen 2013.
 * Copyright (C) The National Library of Finland 2013.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @category DataManagement
 * @package  RecordManager
 * @author   Ere Maijala <ere.maijala@helsinki.fi>
 * @author   Eero Heikkinen <eero.heikkinen@gmail.com>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://github.com/KDK-Alli/RecordManager
 */

if (!isset($_REQUEST['source']) || !isset($_REQUEST['data'])) {
    die('Missing parameters');
}
$format = isset($_REQUEST['format']) ? $_REQUEST['format'] : '';
$source = isset($_REQUEST['source']) ? $_REQUEST['source'] : '';

if (!preg_match('/^[\w_]*$/', $format) || !preg_match('/^[\w_]*$/', $source)) {
    die('Invalid parameters');
}

$basePath = substr(__FILE__, 0, strrpos(__FILE__, DIRECTORY_SEPARATOR));
require_once 'classes/RecordManager.php';
$configArray = parse_ini_file($basePath . '/conf/recordmanager.ini', true);
$configArray['dataSourceSettings']
    = parse_ini_file($basePath . '/conf/datasources.ini', true);
$manager = new RecordManager();

$record = $manager->previewRecord($_REQUEST['data'], $format, $source);

header('Content-Type: application/json');
echo json_encode($record);
