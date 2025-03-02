<?php

/** Handel sidebar */
function setActive(array $routes ,$class_name) {

    if(is_array($routes)) {

        foreach ($routes as $r) {

            if(request()->routeIs($r)) {

                return $class_name;
            }

        }

    }

}

