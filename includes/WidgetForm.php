<?php declare(strict_types = 0);

namespace Modules\LatestDataConnector\Includes;

use Modules\LatestDataConnector\Widget;

use Zabbix\Widgets\CWidgetField;
use Zabbix\Widgets\CWidgetForm;
use Zabbix\Widgets\Fields\{
	CWidgetFieldCheckBox,
	CWidgetFieldCheckBoxList,
	CWidgetFieldColor,
	CWidgetFieldHostPatternSelect,
	CWidgetFieldIntegerBox,
	CWidgetFieldMultiSelectGroup,
	CWidgetFieldMultiSelectOverrideHost,
	CWidgetFieldRadioButtonList,
	CWidgetFieldSelect,
	CWidgetFieldTags,
	CWidgetFieldTextBox
};


class WidgetForm extends CWidgetForm {


	public function addFields(): self {
		return $this
			->addField($this->isTemplateDashboard()
				? null
				: new CWidgetFieldMultiSelectGroup('groupids', _('Host groups'))
			)
			->addField($this->isTemplateDashboard()
				? null
				: new CWidgetFieldHostPatternSelect('hosts', _('Host pattern')
			))
			->addField(
				(new CWidgetFieldRadioButtonList('evaltype', _('Item tags'), [
					TAG_EVAL_TYPE_AND_OR => _('And/Or'),
					TAG_EVAL_TYPE_OR => _('Or')
				]))->setDefault(TAG_EVAL_TYPE_AND_OR)
			)
			->addField(
				new CWidgetFieldTags('item_tags')
			)
			->addField(
				new CWidgetFieldTextBox('metric_name', _('Metric name'))
			)
			->addField(
				(new CWidgetFieldRadioButtonList('sort_order', _('Sort order'), Widget::SORT_ORDER))
					->setDefault(0)
			)
			->addField(
				(new CWidgetFieldSelect('sort_field', _('Sort field'), Widget::SORT_FIELDS))
					->setDefault(0)
			)
			->addField(
				(new CWidgetFieldCheckBox('url_target', _('Open in new tab')))
					->setDefault(0)
			)
			->addField(
				(new CWidgetFieldSelect('font_family', _('Font family'), Widget::FONT_FAMILY))
					->setDefault(0)
				)
			->addField(
				(new CWidgetFieldIntegerBox('font_size', _('Font size'), 12, 48))
					->setDefault(18)
			)
			->addField(
				new CWidgetFieldCheckBoxList('font_style', _('Font style'), [
					Widget::FONT_STYLE_BOLD => _('Bold'),
					Widget::FONT_STYLE_UNDERLINE => _('Underline'),
					Widget::FONT_STYLE_ITALIC => _('Italic'),
				])
			)
			->addField(
				new CWidgetFieldColor('font_color', _('Font color'))
			)
			->addField(
				new CWidgetFieldColor('background_color', _('Background color'))
			)
			->addField(
				new CWidgetFieldMultiSelectOverrideHost()
			)
		;
	}

}
