<?php

namespace App\Helpers;

use Jenssegers\Date\Date;

/**
 * Трансформирует использующиеся в приложении шаблоны.
 * |year| => текущий или следующий год
 * 
 * Class Template
 * @package App\Helpers
 */
class TemplateTransformer
{
    /**
     * Параметры трансформации.
     * 
     * @var array 
     */
    private $parameters = [];

    /**
     * Устанавливаем параметры трансформации шаблонов. 
     * 
     * @param array $parameters
     */
    public function setParameters($parameters = [])
    {
        $this->parameters = $parameters;
    }
    
    /**
     * Заменяет все вхождения шаблонов на релевантные значения.
     * 
     * @param $text
     * @return null|string|string[]
     */
    public function transform($text)
    {
        // Заменяем |year| на нужный год.
        $replaced = $this->replaceYear($text);
        
        return $replaced;
    }

    /**
     * Заменяет шаблон года. 
     * 
     * @param string $text
     * @return null|string|string[]
     */
    protected function replaceYear($text)
    {
        $year = date('Y');
        $breakpoint = $this->parameters['breakpoint-date'] ?? null;
        
        if (!empty($breakpoint)) {
            
            // Проверяем, правильный ли формат даты
            try {
                $date = Date::createFromFormat('Y-m-d', $breakpoint);
            }
            Catch (\InvalidArgumentException $exception) {
                $date = null;
            }
            
            // Если текущая дата больше заданной, то ставим следующий год
            if ($date && now() > $date)
                $year = now()->addYear(1)->format('Y');
        }
        
        return preg_replace("!(\|year\|)!is", $year, $text);
    }
}