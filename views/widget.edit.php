<?php declare(strict_types = 0);

$groupids = array_key_exists('groupids', $data['fields'])
	? new CWidgetFieldMultiSelectGroupView($data['fields']['groupids'])
	: null;

(new CWidgetFormView($data))
	->addField(
		(new CWidgetFieldTextAreaView($data['fields']['content']))
			->setWidth(ZBX_TEXTAREA_STANDARD_WIDTH)
			->setFieldHint(
				makeHelpIcon([_('Add text or raw html in this field to customize the widget container'), BR(),
					_('If you want to encode a URL built by this widget for connecting to the latest data page, add this macro to your HTML:'), BR(),
					_('{#URL}'), BR(), BR(),
					_('<div style="
						height: 100%;
						width: 100%;
						box-sizing: border-box;
						padding: 5px;
						font-family: Arial, sans-serif;
						background-color: #3b3b3b;
						display: flex;
						flex-direction: column;
						justify-content: center;
						align-items: center;
						text-align: center;
					">
						<h3 style="margin: 0 0 10px 0; color: #ff5722; font-weight: bold; font-size: 16px;">💡 Did you know...</h3>
						<p style="color: #f0f0f0; padding: 0 20px;">Click here for some metrics by host!</p>
						<p style="color: #007BFF; margin: 10px 0; padding: 0 30px; text-decoration: none;">
						  {#URL}
						</p>
					</div>')])
			)
	)
	->addField($groupids)
	->addField(array_key_exists('hostids', $data['fields'])
		? (new CWidgetFieldMultiSelectHostView($data['fields']['hostids']))
			->setFilterPreselect([
				'id' => $groupids->getId(),
				'accept' => CMultiSelect::FILTER_PRESELECT_ACCEPT_ID,
				'submit_as' => 'groupid'
			])
		: null
	)
	->addField(array_key_exists('hosts', $data['fields'])
		? (new CWidgetFieldPatternSelectHostView($data['fields']['hosts']))
			->setPlaceholder(_('host pattern'))
			->setFieldHint(
				makeHelpIcon(_('Enter a host pattern using \'*\' as a wildcard'))
			)
		: null
	)
	->addField(
		new CWidgetFieldRadioButtonListView($data['fields']['evaltype'])
	)
	->addField(
		new CWidgetFieldTagsView($data['fields']['item_tags'])
	)
	->addField(
		(new CWidgetFieldSelectView($data['fields']['latest_data_dashboard']))
			->setFieldHint(
				makeHelpIcon(_('These filters match the ones on the Latest data page and serve as a quick filter in lieu of using tags and/or a metric name.'))
			)
	)
	->addField(
		(new CWidgetFieldTextBoxView($data['fields']['metric_name']))
			->setFieldHint(
				makeHelpIcon(_('This field uses the \'Name\' field from the Latest data page'))
			)
			->setPlaceholder('metric name or name substring')
	)
	->addField(
		new CWidgetFieldRadioButtonListView($data['fields']['sort_order'])
	)
	->addField(
		(new CWidgetFieldSelectView($data['fields']['sort_field']))
			->setFieldHint(
				makeHelpIcon(_('Which column to sort by on the Latest data page'))
			)
	)
	->addField(
		(new CWidgetFieldCheckBoxView($data['fields']['url_target']))
			->setFieldHint(
				makeHelpIcon(_('Check the box to open the page in a new browser tab'))
			)
	)
	->addField(
		new CWidgetFieldSelectView($data['fields']['font_family'])
	)
	->addField(
		new CWidgetFieldIntegerBoxView($data['fields']['font_size'])
	)
	->addField(
		(new CWidgetFieldCheckBoxListView($data['fields']['font_style']))
			->setColumns(3)
	)
	->addField(
		new CWidgetFieldColorView($data['fields']['font_color']),
		'js-row-bg-color'
	)
	->addField(
		new CWidgetFieldColorView($data['fields']['background_color']),
	)
	->includeJsFile('widget.edit.js.php')
	->initFormJs('widget_latest_data_connector_form.init();')
	->show();
