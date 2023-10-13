<?php

declare(strict_types=1);


namespace LeafOmniglot\Handler;


class RouteHandler
{
    /**
     * @param string $path
     * @param string $requestLocaleParamName
     * @param bool $redirectToReferer
     *
     * @return void
     *
     * @throws \Exception
     */
    public function addLanguageSwitchRoute(string $path, string $requestLocaleParamName, bool $redirectToReferer): void
    {
        if (!class_exists('Leaf\App') || !class_exists('Leaf\Router')) {
            throw new \Exception('This method only works on applications with Leaf and Leaf Router');
        }

        app()->post($path, function () use ($requestLocaleParamName, $redirectToReferer) {
            omniglot()->setCurrentLocale(\Leaf\Http\Request::get($requestLocaleParamName));

            if ($redirectToReferer) {
                $refererUrl = str_replace('amp;', '', request()->headers('Referer'));
                response()->redirect($refererUrl);
            } else {
                response()->json(['isSuccess' => true]);
            }
        });
    }
}
