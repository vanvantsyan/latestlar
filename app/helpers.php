<?php

if (! function_exists('morph')) {
    /**
     * Трансформирует слово или словосочетание на основе переданных
     * правил склонений, либо по стандартному алгоритму морфера.
     *
     * @param string $name
     * @param string $case
     * @param array $cases
     * @return string трансформированное слово или словосочетание
     */
    function morph($name, $case, $cases = [])
    {
        $transformedCases = ['Р' => 'r', 'Д' => 'd', 'В' => 'v', 'Т' => 't', 'П' => 'p'];
        $prepositions = ['Р' => '', 'Д' => 'по ', 'В' => 'в ', 'Т' => '', 'П' => 'в '];

        if (!empty($cases[$transformedCases[$case]]))
            return $cases[$transformedCases[$case]];
        
        return $prepositions[$case] . Gliss::case($name, $case);
    }
}
