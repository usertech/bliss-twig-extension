<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('be', array($this, 'be')),
            new TwigFilter('bm', array($this, 'bm')),
        );
    }

    private function item($prefix, $modifiers, $classes)
    {
        $blissClass = [$prefix];

        if(count($modifiers) > 0){
            foreach ($modifiers as &$modifier) {
                array_push($blissClass, $prefix.'--'.$modifier);
            }
        }

        if(count($classes) > 0){
            $blissClass = array_merge($blissClass, $classes);
        }

        return join(' ',$blissClass);
    }

    public function bm($moduleName, $modifiers = null, $classes = null)
    {
        if($modifiers != null && is_string($modifiers)){
            $modifiers = [$modifiers];
        }

        if($classes != null && is_string($classes)){
            $classes = [$classes];
        }

        return $this->item($moduleName, $modifiers, $classes);
    }

    public function be($moduleName, $elementName, $modifiers = null, $classes = null)
    {
        return $this->bm($moduleName.'-'.$elementName, $modifiers, $classes);
    }
}
