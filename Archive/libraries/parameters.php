<?php

function getParametersForRoute(string $route): array
{
    $path = substr(parse_url($_SERVER["REQUEST_URI"])["path"], strlen('/'));
    $pathSeparatorPattern = "#/#";

    $routeParts = preg_split($pathSeparatorPattern, trim($route, "/"));
    $pathParts = preg_split($pathSeparatorPattern, trim($path, "/"));

    if (count($routeParts) !== count($pathParts)) {
        return [];
    }

    $parameters = [];

    foreach ($routeParts as $routePartIndex => $routePart) {
        $pathPart = $pathParts[$routePartIndex];

        if (str_starts_with($routePart, ":")) {
            $parameterName = substr($routePart, 1);
            $parameters[$parameterName] = $pathPart;
            continue;
        }

        if ($routePart !== $pathPart) {
            return [];
        }
    }

    return $parameters;
}
