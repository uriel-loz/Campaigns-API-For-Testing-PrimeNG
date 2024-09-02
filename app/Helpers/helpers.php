<?php

function convertToArrayFilter($filters) : array
{
    if (!$filters) 
        return [];

    $all_filters = [];

    $input_filters = array_values(array_filter(explode('&', $filters)));
        
    foreach ($input_filters as $filter) {
        list($field, $value) = explode('=', $filter);
        $all_filters[$field] = $value;
    }

    return $all_filters;
}