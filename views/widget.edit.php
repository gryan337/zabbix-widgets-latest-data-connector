<?php declare(strict_types = 0);


(new CWidgetFormView($data))
	->addField(array_key_exists('groupids', $data['fields'])
		? new CWidgetFieldMultiSelectGroupView($data['fields']['groupids'])
		: null
	)
	->addField(array_key_exists('hosts', $data['fields'])
		? (new CWidgetFieldHostPatternSelectView($data['fields']['hosts']))
			->setPlaceholder(_('host pattern'))
			->setFieldHint(
				makeHelpIcon(_('Unlike the Latest data page, enter a host pattern using \'*\' as a wildcard'))
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
		(new CWidgetFieldTextBoxView($data['fields']['metric_name']))
			->setFieldHint(
				makeHelpIcon(_('This field uses the \'Name\' field from the Latest data page'))
			)
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
	->addJavaScript('widget_latest_data_connector_form.init();')
	->show();
