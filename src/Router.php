<?php

namespace Framework;

class Router extends API
{
    public static function identify($args, $config, $options = null)
    {
        $model = array(
            'namespace' => null,
            'query' => null
        );

        // Handle query string
        if (isset($args[1]) && substr($args[1], 0, 1) == '?') {
            $args[2] = $args[1];
            $args[1] = '';

        } elseif (isset($args[2]) && substr($args[2], 0, 1) == '?') {
            $args[3] = $args[2];
            $args[2] = '';
        }

        // Route!
        if (isset($args[1]) && $args[1] !== '') {
            if (isset($args[2])) {
                if (isset($options['queryChild']) && $options['queryChild']) {
                    $model['namespace'] = 'App\\' . ucfirst($args[1]) . '\\Index';

                    if (isset($args[2])) {
                        $model['query'] = $args[2];
                    }
                } else {
                    $model['namespace'] = 'App\\' . ucfirst($args[1]) . '\\' . ucfirst($args[2]);

                    if (isset($args[3])) {
                        $model['query'] = $args[3];
                    }
                }
            } else {
                $model['namespace'] = 'App\\' . ucfirst($args[1]) . '\\Index';

                if (isset($args[2])) {
                    $model['query'] = $args[2];
                }
            }
        } else {
            // No endpoint specified
            throw new \Exception('No endpoint specified.');
        }

        return $model;
    }
}