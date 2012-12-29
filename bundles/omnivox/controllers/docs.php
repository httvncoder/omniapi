<?php

class Omnivox_Docs_Controller extends Base_Controller
{
    public function action_index()
    {
        return View::make('omnivox::docs.index');
    }

    public function action_api($a, $b = null)
    {
        $view = 'omnivox::docs.api.' . $a;

        if ($b !== null) {
            $view .= '.' . $b;
        }

        return View::exists($view)
            ? View::make($view)
            : Response::error('404');
    }

}
