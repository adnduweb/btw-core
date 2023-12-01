<?php

/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Libraries\Menus;

/**
 * Represents an individual item in a menu.
 *
 * @property string $altText
 * @property string $faIcon
 * @property string $icon
 * @property string $iconUrl
 * @property string $title
 * @property string $url
 * @property string $bg
 * @property string $target
 * @property int    $weight
 */
class MenuChildItem
{
    use HasMenuIcons;

    /**
     * @var string|null
     */
    protected $title;

    /**
     * @var string|null
     */
    protected $color;

    /**
     * @var string|null
     */
    protected $url;

    /**
 * @var string|null
 */
    protected $hxboost = 'hx-boost="false"';

    /**
     * @var string|null
     */
    protected $bg = 'gray';

    /**
     * @var string|null
     */
    protected $target;

    /**
     * @var string|null
     */
    protected $altText;

    /**
     * The 'weight' used for sorting.
     *
     * @var int|null
     */
    protected $weight;

    /**
     * The permission to check to see if the
     * user can view the menu item or not.
     *
     * @var string
     */
    protected $permission;

    public function __construct(?array $data = null)
    {
        if (!is_array($data)) {
            return;
        }

        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->{$method}($value);
            }
        }
    }

    /**
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return $this
     */
    public function setColor(string $color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return $this
     */
    public function setUrl(string $url)
    {
        $this->url = strpos($url, '://') !== false
            ? $url
            : '/' . ltrim($url, '/ ');

        return $this;
    }

    /**
     * @return $this
     */
    public function setHxboost(string $hxboost)
    {
        $this->hxboost = (isset($hxboost) && !empty($hxboost)) ? 'hx-boost="' . $hxboost . '"' : 'hx-boost="false"';

        return $this;
    }

    /**
     * Sets the URL via reverse routing, so can
     * use named routes to set the URL by.
     *
     * @return $this
     */
    public function setNamedRoute($alias)
    {
        if (!is_array($alias)) {
            $alias = [$alias];
        }

        $this->url = (isset($alias[1]) && !empty($alias[1])) ? route_to($alias[0], $alias[1]) : route_to($alias[0]);

        return $this;
    }

    /**
     * Set Bg div
     *
     * @return $this
     */
    public function setBg($alias)
    {

        $this->bg = (isset($alias) && !empty($alias)) ? $alias : '';

        return $this;
    }

    /**
     * Set Bg div
     *
     * @return $this
     */
    public function setTarget($alias)
    {

        $this->target = (isset($alias) && !empty($alias)) ? 'target="' . $alias . '"' : '';

        return $this;
    }

    /**
     * @return $this
     */
    public function setAltText(string $text)
    {
        $this->altText = $text;

        return $this;
    }

    /**
     * Sets the "weight" of the menu item.
     * The large the value, the later in the menu
     * it will appear.
     *
     * @return $this
     */
    public function setWeight(int $weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Sets the permission required to see this menu item.
     *
     * @return $this
     */
    public function setPermission(string $permission)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * @return string
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function color()
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function url()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function hxboost()
    {
        return $this->hxboost;
    }


    /**
     * @return string
     */
    public function bg()
    {
        return $this->bg;
    }

    /**
     * @return string
     */
    public function target()
    {
        return $this->target;
    }

    /**
     * @return string
     */
    public function altText()
    {
        return $this->altText;
    }

    /**
     * @return int
     */
    public function weight()
    {
        return $this->weight ?? 0;
    }

    /**
     * Can the active user see this menu item?
     */
    public function userCanSee(): bool
    {
        // No permission set means anyone can view.
        if (empty($this->permission)) {
            return true;
        }

        helper('auth');

        return auth()->user()->can($this->permission);
    }

    public function __get(string $key)
    {
        if (method_exists($this, $key)) {
            return $this->{$key}();
        }
    }
}
