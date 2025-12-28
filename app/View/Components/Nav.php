<?php

namespace App\View\Components;

use Auth;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Nav extends Component
{
    /**
     * Create a new component instance.
     */
    public $items ;
    public $active;
    public function __construct()
    {
        $this->items = $this->prepareItems(config('nav'));
        $this->active = Route::currentRouteName();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav');
    }

    protected function prepareItems($items)
    {
        $user = Auth::user() ?? null;
        foreach ($items as $key => $item) {
            if(isset($item['ability']) && !$user->can($item['ability'] , isset($item['model']) ? $item['model'] : null)) {
                unset($items[$key]); // بتحذف العنصر الحالي من مصفوفة العناصر
                continue;
            }  
            if (isset($item['route_params'])) {
                $param = is_callable($item['route_params']) ? $item['route_params']() : $item['route_params'];
            }   
            $items[$key]['url'] =  route($item['route'], $param ?? []);
        }
        return $items;
    }
}
