<?php

namespace li3_element\extensions\helper;

use lithium\template\View;

/**
 * A template helper that manipulates and formats lithium's elements. Accessible in templates via
 * `$this->element`, which will auto-load this helper into the rendering context.
 */
class Element extends \lithium\template\Helper {

	/**
	 * Renders an element.
	 *
	 * @param string $element
	 * @param array $data
	 * @return string Rendered HTML
	 */
	public function render ($element, array $data = []) {
		$view = new View($this->_context->view()->_config);
		return $view->render(['element' => $element], $data);
	}

	/**
	 * Iterates through items and renders an element per item. The elements are wrapped in row and
	 * column divs and returned as a rendered HTML string.
	 *
	 * @param string $element
	 * @param array $data
	 * @param array $options
	 * @return string Rendered HTML
	 */
	public function columns ($element, array $data, array $options = []) {

		$render = '';

		$defaults = [
			'offset' => 0,
			'max' => 0,
			'per_row' => 1,
			'row' => [],
			'column' => []
		];
		$options += $defaults;

		// Decipher what data to iterate through
		if (!isset($options['key']) || !isset($data[$options['key']])) {
			$options['key'] = array_keys($data)[0];
		}
		$items = $data[$options['key']];

		$loopCount = 0;
		$itemCount = 0;
		$itemTotal = count(is_object($items) ? $items->data() : $items);

		foreach ($items as $item) {

			$first = false;
			$last = false;
			$loopCount++;

			if ($loopCount > $options['offset']) {

				$itemCount++;

				// Break if the maximum items has been reached
				if ($options['max'] > 0 && $itemCount > $options['max']) break;

				// Decipher first and last columns
				if (($itemCount - 1) % $options['per_row'] == 0) {
					$first = true;
				}
				if (
					$itemCount % $options['per_row'] == 0
					|| $itemCount == $options['max']
					|| $loopCount == $itemTotal
				) {
					$last = true;
				}

				// Open rows and columns
				if ($first) {
					$render .= '<div ';
					if (isset($options['row'])) {
						$render .= $this->_attributes($options['row']);
					}
					$render .= '>';
				}
				$render .= '<div ';
				if ($first && !$last && isset($options['first_column'])) {
					$render .= $this->_attributes($options['first_column']);
				} elseif (!$first && $last && isset($options['last_column'])) {
					$render .= $this->_attributes($options['last_column']);
				} elseif ($first && $last && isset($options['first_and_last_column'])) {
					$render .= $this->_attributes($options['first_and_last_column']);
				} else {
					$render .= $this->_attributes($options['column']);
				}
				$render .= '>';

				// Render the element
				$elementData = $data;
				$elementData[$options['key']] = $item;
				$render .= $this->render($element, $elementData);

				// Close rows and columns
				$render .= '</div>';
				if ($last) $render .= '</div>';

			}
		}

		return $render;

	}

}
