<?php declare(strict_types = 0);

namespace Modules\LatestDataConnector\Includes;

use Modules\LatestDataConnector\Widget;

use Zabbix\Widgets\{
	CWidgetField,
	CWidgetForm
};

use Zabbix\Widgets\Fields\{
	CWidgetFieldCheckBox,
	CWidgetFieldCheckBoxList,
	CWidgetFieldColor,
	CWidgetFieldPatternSelectHost,
	CWidgetFieldIntegerBox,
	CWidgetFieldMultiSelectGroup,
	CWidgetFieldMultiSelectOverrideHost,
	CWidgetFieldMultiSelectHost,
	CWidgetFieldRadioButtonList,
	CWidgetFieldSelect,
	CWidgetFieldTags,
	CWidgetFieldTextArea,
	CWidgetFieldTextBox
};


class WidgetForm extends CWidgetForm {


	public function addFields(): self {
		return $this
			->addField(
				new CWidgetFieldTextArea('content', _('Content'))
			)
			->addField($this->isTemplateDashboard()
				? null
				: new CWidgetFieldMultiSelectGroup('groupids', _('Host groups'))
			)
			->addField($this->isTemplateDashboard()
				? null
				: new CWidgetFieldMultiSelectHost('hostids', _('Hosts'))
			)
			->addField($this->isTemplateDashboard()
				? null
				: new CWidgetFieldPatternSelectHost('hosts', _('Host pattern')
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
				$this->createLatestDataDashboardSelect('latest_data_dashboard')
					->setDefault(0)
			)
			->addField(
				new CWidgetFieldTextBox('metric_name', _('Metric name'))
			)
			->addField(
				(new CWidgetFieldRadioButtonList('sort_order', _('Sort order'), [
					0 => _('Ascending'),
					1 => _('Descending')
				]))->setDefault(0)
			)
			->addField(
				$this->createSortOptions('sort_field')
					->setDefault(0)
			)
			->addField(
				(new CWidgetFieldCheckBox('url_target', _('Open in new tab')))
					->setDefault(0)
			)
			->addField(
				$this->createFontSelect('font_family')
					->setDefault(3)
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

	function createFontSelect(string $name): CWidgetFieldSelect {
		return (new CWidgetFieldSelect($name, _('Font family'), Widget::FONT_FAMILY));
	}

	function createLatestDataDashboardSelect(string $name): CWidgetFieldSelect {
		$latest_data_filters = Widget::LATEST_DATA_FILTER_NAMES;
		asort($latest_data_filters);
		return (new CWidgetFieldSelect($name, _('Latest data filter'), $latest_data_filters));
	}

	function createSortOptions(string $name): CWidgetFieldSelect {
		return (new CWidgetFieldSelect($name, _('Sort Field'), Widget::SORT_FIELDS));
	}

}
