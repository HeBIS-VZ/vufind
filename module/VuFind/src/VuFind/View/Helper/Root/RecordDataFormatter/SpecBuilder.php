<?php
/**
 * Specification builder for record driver data formatting view helper
 *
 * PHP version 5
 *
 * Copyright (C) Villanova University 2016.
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
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category VuFind
 * @package  View_Helpers
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org/wiki/development Wiki
 */
namespace VuFind\View\Helper\Root\RecordDataFormatter;

/**
 * Specification builder for record driver data formatting view helper
 *
 * @category VuFind
 * @package  View_Helpers
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org/wiki/development Wiki
 */
class SpecBuilder
{
    /**
     * Spec
     *
     * @var array
     */
    protected $spec = [];

    /**
     * Highest position value so far.
     *
     * @var int
     */
    protected $maxPos = 0;

    /**
     * Constructor
     *
     * @param array $spec Existing specification lines (optional)
     */
    public function __construct($spec = [])
    {
        $this->spec = $spec;
        foreach ($spec as $current) {
            if (isset($current['pos']) && $current['pos'] > $this->maxPos) {
                $this->maxPos = $current['pos'];
            }
        }
    }
    /**
     * Set a generic spec line.
     *
     * @param string $key        Label to associate with this spec line
     * @param string $dataMethod Method of data retrieval for rendering element
     * @param string $renderType Type of rendering to use to generate output
     * @param array  $options    Additional options
     *
     * @return array
     */
    public function setLine($key, $dataMethod, $renderType = null, $options = [])
    {
        $options['dataMethod'] = $dataMethod;
        $options['renderType'] = $renderType;
        if (!isset($options['pos'])) {
            $this->maxPos += 100;
            $options['pos'] = $this->maxPos;
        }
        $this->spec[$key] = $options;
    }

    /**
     * Construct a record driver template spec line.
     *
     * @param string $key        Label to associate with this spec line
     * @param string $dataMethod Method of data retrieval for rendering element
     * @param string $template   Record driver template to render with data
     * @param array  $options    Additional options
     *
     * @return array
     */
    public function setTemplateLine($key, $dataMethod, $template, $options = [])
    {
        $options['template'] = $template;
        return $this->setLine($key, $dataMethod, 'RecordDriverTemplate', $options);
    }

    /**
     * Get the spec.
     *
     * @return array
     */
    public function getArray()
    {
        return $this->spec;
    }
}