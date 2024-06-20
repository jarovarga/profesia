<?php

declare(strict_types=1);

namespace App\View\Helper;

use Cake\Collection\Collection;
use Cake\Collection\CollectionInterface;
use Cake\Core\Configure;
use Cake\View\Helper;
use Cake\View\Helper\UrlHelper;
use Cake\View\StringTemplate;
use Cake\View\StringTemplateTrait;
use Cake\View\View;

/**
 * @property UrlHelper $Url
 */
class MenuHelper extends Helper
{
    use StringTemplateTrait;

    /**
     * @var string[]
     */
    protected array $helpers = ['Url'];

    /**
     * @var CollectionInterface
     */
    protected CollectionInterface $items;

    /**
     * @var StringTemplate
     */
    protected StringTemplate $templater;

    /**
     * @var mixed
     */
    protected mixed $params;

    /**
     * @var mixed|null
     */
    protected mixed $identity;

    /**
     * @var string
     */
    protected string $menu = '';

    /**
     * Constructs a new instance of the class.
     *
     * @param View $view The View object associated with the class.
     *
     * @return void
     */
    public function __construct(View $view)
    {
        parent::__construct($view);

        $config = Configure::read('Menu');

        $this->items = (new Collection($config))->sortBy('position', SORT_ASC);
        $this->templater = $this->templater();
        $this->params = $view->getRequest()->getAttribute('params');
        $this->identity = $view->getRequest()->getAttribute('identity');
    }

    /**
     * Constructs the navigation menu HTML.
     *
     * @return string The generated HTML for the navigation menu.
     */
    public function nav(): string
    {
        $this->templater->add([
            'wrapper' => /** @lang text */ '<ul class="menu">{{content}}</ul>',
            'item' => /** @lang text */ '<li class="menu__item{{isActive}}">
                <a href="{{url}}"{{attrs}}><span>{{text}}</span></a></li>',
        ]);

        $this->buildMenu();

        return $this->formatTemplate('wrapper', ['content' => $this->menu]);
    }

    /**
     * Builds the menu by iterating through the items and generating menu items for accessible items.
     *
     * @return void
     */
    protected function buildMenu(): void
    {
        foreach ($this->items as $item) {
            if ($this->isAccessible($item)) {
                $this->menu .= $this->generateMenuItem($item);
            }
        }
    }

    /**
     * Checks if an item is accessible based on user role.
     *
     * @param array $item The menu item to check.
     *
     * @return bool True if the item is accessible, false otherwise.
     */
    protected function isAccessible(array $item): bool
    {
        return $item['access'] === ['*'] || in_array($this->identity->role, $item['access']);
    }

    /**
     * Generates a menu item HTML string based on the given item array.
     *
     * @param array $item The menu item array containing the following keys:
     * - controller (string) The controller name.
     * - action (string|null) The action name. Default is 'index'.
     * - plugin (string|false|null) The plugin name. Default is false.
     * - prefix (string|false|null) The prefix name. Default is false.
     * - text (string) The text to display for the menu item.
     * - title (string|false|null) The title attribute for the menu item. Default is false.
     * - class (string|false|null) The CSS class or classes for the menu item. Default is false.
     *
     * @return string The generated menu item HTML string.
     */
    protected function generateMenuItem(array $item): string
    {
        $url = $this->Url->build([
            'controller' => $item['controller'],
            'action' => $item['action'] ?? 'index',
            'plugin' => $item['plugin'] ?? false,
            'prefix' => $item['prefix'] ?? false,
        ]);
        $attributes = [
            'url' => $url,
            'text' => $item['text'],
            'attrs' => $this->templater->formatAttributes([
                'title' => $item['title'] ?? false,
                'class' => $item['class'] ?? false,
            ]),
        ];

        if ($this->params['controller'] == $item['controller']) {
            $attributes['isActive'] = ' --is-active';
        }

        return $this->templater->format('item', $attributes);
    }
}
