<?php

// no direct access
defined('_JEXEC') or die;

class plgContentTimifyWidget extends JPlugin {

	/**
	 *	Use this method to show booking button after each article
	 */
	public function onContentAfterDisplay($context, &$article, &$params, $limitstart = 1) {

		$timifyWidgetId					= $this->params->get('timify_widget_id', false);
		$timifyWidgetLanguage		= $this->params->get('timify_widget_language', false);
		$timifyWidgetPosition		= $this->params->get('timify_widget_position', false);
		$timifyWidgetButtonLabel= $this->params->get('timify_widget_button_label', false);

		if ($timifyWidgetId !== false &&
				$timifyWidgetPosition == 'after_post') {

			$article->text			= $article->text .
				'<button class="timify-button" data-account-id="' . $timifyWidgetId . '" style="height: 40px; background: #ca3b43; color: #fff; font-size: 14px; font-weight: normal; text-transform: uppercase; border: 0; padding: 0 15px; cursor: pointer; border-radius: 3px;">' .
						($timifyWidgetButtonLabel !== false ? $timifyWidgetButtonLabel : 'Book an appointment') .
				'</button>';
		}

		return '';
	}

	/**
	 *	Use this method to append booking javascript code before closing the body tag
	 */
	public function onAfterRender() {
		$app      = JFactory::getApplication();

		if ($app->getName() != 'site') {
			return true;
		}

		$buffer   = JFactory::getApplication()->getBody();

		$timifyWidgetId					= $this->params->get('timify_widget_id', false);
		$timifyWidgetLanguage		= $this->params->get('timify_widget_language', false);
		$timifyWidgetPosition		= $this->params->get('timify_widget_position', false);

		if ($timifyWidgetId !== false) {

			$widget   = '<script async id="timify" ' .
					($timifyWidgetPosition == 'left' || $timifyWidgetPosition == 'right' ?
						'data-account-id="' . $timifyWidgetId . '"' : '') . '
					data-locale="' . ($timifyWidgetLanguage !== false ? $timifyWidgetLanguage : 'en') . '"
					type="text/javascript"
					data-position="' . ($timifyWidgetPosition !== false ?
															($timifyWidgetPosition == 'left' || $timifyWidgetPosition == 'right' ?
															 $timifyWidgetPosition : 'multiple')
															: 'left') . '"
					src="https://book.timify.com/widget/widget.min.js">
				</script>';

			$buffer   = str_ireplace('</body>', $widget . '</body>', $buffer);
		}

		JFactory::getApplication()->setBody($buffer);

		return true;
	}

}

?>
