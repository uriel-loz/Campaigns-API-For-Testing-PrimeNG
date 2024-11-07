<?php

function convertToArrayFilter($filters) : array
{
    if (!$filters) 
        return [];

    $all_filters = [];
        
    foreach ($filters as $key => $filter) {
        $all_filters[$key] = $filter;
    }

    return $all_filters;
}