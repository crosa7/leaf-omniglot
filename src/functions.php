<?php

if (! function_exists('tl')) {

    /**
     * @param string $key
     * @param array $params
     *
     * @return string
     */
    function tl(string $key, array $params = []): string
    {
        return omniglot()->translate($key, $params);
    }
}

if (! function_exists('omniglot')) {

    /**
     * @return \App\src\Omniglot
     */
    function omniglot(): \App\src\Omniglot
    {
        $instance = \App\src\Reader\ConfigReader::config(
            \App\src\Constants\ConfigConstants::KEY_OMNIGLOT
        );

        if (!$instance) {
            $instance = new \App\src\Omniglot();
            \App\src\Reader\ConfigReader::config(
                \App\src\Constants\ConfigConstants::KEY_OMNIGLOT, $instance
            );
        }

        return $instance;
    }
}
