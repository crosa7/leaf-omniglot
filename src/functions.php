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
     * @return \LeafOmniglot\Omniglot
     */
    function omniglot(): \LeafOmniglot\Omniglot
    {
        $instance = \LeafOmniglot\Reader\ConfigReader::config(
            \LeafOmniglot\Constants\ConfigConstants::KEY_OMNIGLOT
        );

        if (!$instance) {
            $instance = new \LeafOmniglot\Omniglot();
            \LeafOmniglot\Reader\ConfigReader::config(
                \LeafOmniglot\Constants\ConfigConstants::KEY_OMNIGLOT, $instance
            );
        }

        return $instance;
    }
}
