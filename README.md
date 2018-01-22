# CSS Bliss twig extension

This extension helps you with creating classes in [ CSS Bliss](https://github.com/gilbox/css-bliss " CSS Bliss") coding standard in twig templates.

## How to add extension
[How to Write a custom Twig Extension](https://symfony.com/doc/current/templating/twig_extension.html "How to Write a custom Twig Extension")

1. Open `src/Twig/AppExtension.php`
2. Add new filters to `getFilters` function


		return array(
			new TwigFilter('be', array($this, 'be')),
			new TwigFilter('bm', array($this, 'bm')),
			....

3. Add functions


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

## How use ti

### Filter for Bliss MODUL `bm([modifiers], [classes])`
#### Examples

**source**

	<div class="{{ 'Module' | bm }}"></div>
**output**

	<div class="Module"></div>

------------

**source**

	<div class="{{ 'Module' | bm('modifier', 'someClass') }}"></div>
**output**

	<div class="Module Module--modifier someClass"></div>

------------
**source**

	<div class="{{ 'Module' | bm(['modifierOne', 'modifierTwo'], ['someClassOne', 'someClassTwo']) }}"></div>
**output**

	<div class="Module Module--modifierOne Module--modifierTwo someClassOne someClassTwo"></div>


### Filter for Bliss ELEMENT `be(elementName, [modifiers], [classes])`
#### Examples

**source**

	<div class="{{ 'Module' | be('element') }}"></div>
**output**

	<div class="Module-element"></div>

------------

**source**

	<div class="{{ 'Module' | be('element', 'modifier', 'someClass') }}"></div>
**output**

	<div class="Module-element Module-element--modifier someClass"></div>

------------
**source**

	<div class="{{ 'Module' | be('element', ['modifierOne', 'modifierTwo'], ['someClassOne', 'someClassTwo']) }}"></div>
**output**

	<div class="Module-element Module-element--modifierOne Module-element--modifierTwo someClassOne someClassTwo"></div>