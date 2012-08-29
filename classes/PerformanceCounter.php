<?php
/**
 * Performance Counter
 *
 * PHP version 5
 *
 * Copyright (C) Ere Maijala 2012.
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
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://github.com/KDK-Alli/RecordManager
 */

/**
 * PerformanceCounter
 *
 * This class provides average speed estimation for different processes
 *
 * @category DataManagement
 * @package  RecordManager
 * @author   Ere Maijala <ere.maijala@helsinki.fi>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://github.com/KDK-Alli/RecordManager
 */
class PerformanceCounter
{
    protected $counts = array();
    
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->reset();
    } 
    
    /**
     * Reset counter
     * 
     * @return void
     */
    public function reset()
    {
        $this->counts = array(array('t' => microtime(true), 'c' => 0));
    }
    
    /**
     * Add the current count 
     * 
     * @param number $count Current progress
     * 
     * @return void
     */
    public function add($count)
    {
        $this->counts[] = array('t' => microtime(true), 'c' => $count);
        if (count($this->counts) > 30) {
            array_shift($this->counts);
        }
    }
    
    /**
     * Get the speed as units / second
     * 
     * @return number
     */
    public function getSpeed()
    {
        if (count($this->counts) < 2) {
            return 0;
        }
        $total = 0;
        $prev = $this->counts[0];
        for ($i = 1; $i < count($this->counts); $i++) {
            $count = $this->counts[$i]; 
            $sum = $count['c'] - $prev['c'];
            $time = $count['t'] - $prev['t'];
            if ($time > 0) {
                $total += round($sum / $time);
            }
            $prev = $count;
        }
        return round($total / (count($this->counts) - 1));
    }
}
