<?php

use Modules\LatestDataConnector\Widget;
use Modules\LatestDataConnector\Includes\CDivRawHtml;


$header = new CDivRawHtml();

$groupids = [];
if (array_key_exists('groupids', $this->data)) {
	foreach ($this->data['groupids'] as $g) {
		$groupids[] = $g;
	}
}

$hostids = [];
if ($this->data['is_template_dashboard'] == 1) {
	$hostids = $this->data['fields_values']['override_hostid'];
}
else {
	if (array_key_exists('hostids', $this->data)) {
		foreach ($this->data['hostids'] as $h => $value) {
			$hostids[] = $value['hostid'];
		}
	}
}

$itemtags = Array();
foreach ($this->data['fields_values']['item_tags'] as $index => $values) {
	foreach ($values as $k => $v) {
		$itemtags['tags[' . $index . '][' . $k . ']'] = $v;
	}
}

$url = (new CUrl('zabbix.php'))
	->setArgument('action', 'latest.view')
	->setArgument('groupids', $groupids)
	->setArgument('hostids', $hostids)
	->setArgument('sortorder', Widget::SORT_ORDER[$this->data['fields_values']['sort_order']])
	->setArgument('sort', Widget::SORT_FIELDS[$this->data['fields_values']['sort_field']])
	->setArgument('name', $this->data['fields_values']['metric_name']);

foreach ($itemtags as $key => $value) {
	$url->setArgument($key, $value);
}

$url_base = [];
$wrapper_base = new ArrayObject();
$wrapper_base->append('color: #' . $this->data['fields_values']['font_color']);
$wrapper_base->append('line-height: normal');

$url_base[] = (new CDiv($this->data['name']))
	->addStyle(implode('; ', (array) $wrapper_base));

file_put_contents('/var/log/test', print_r($this, true));

$link = (new CLink($url_base, $url));
if ($this->data['fields_values']['url_target']) {
	$link->setTarget('_blank');
}

$header->addItem(
	(new CDiv([$link]))->addClass(ZBX_STYLE_CENTER)
);

$wrapper = new CDiv($header);
$wrapper->addClass('dashboard-widget-latest-data-connector-wrapper');

$wrapper_style = new ArrayObject();
$wrapper_style->append('font-family: ' . Widget::FONT_FAMILY[$this->data['fields_values']['font_family']]);
$wrapper_style->append('font-size: ' . $this->data['fields_values']['font_size'] . 'px');
$wrapper_style->append('font-weight: ' . ((in_array(Widget::FONT_STYLE_BOLD, $this->data['fields_values']['font_style']))
	? 'bold'
	: 'normal'));

$wrapper_style->append('font-style: '. ((in_array(Widget::FONT_STYLE_ITALIC, $this->data['fields_values']['font_style']))
	? 'italic'
	: 'normal'));

$wrapper_style->append('text-decoration: '. ((in_array(Widget::FONT_STYLE_UNDERLINE, $this->data['fields_values']['font_style']))
	? 'underline'
	: 'none'));

$wrapper_style->append('background-color: #' . $this->data['fields_values']['background_color']);
$wrapper_style->append('margin: auto');

$wrapper->addStyle(implode('; ', (array) $wrapper_style));

$output = [];
$output['name'] = '';

if (array_key_exists('name', $this->data)) {
	$output['name'] = $this->data['name'];
}

$output['body'] = $wrapper->toString();

if ($messages = get_and_clear_messages()) {
	$output['messages'] = array_column($messages, 'message');
}

if (array_key_exists('user', $this->data) && $this->data['user']['debug_mode'] == GROUP_DEBUG_MODE_ENABLED) {
	CProfiler::getInstance()->stop();
	$output['debug'] = CProfiler::getInstance()->make()->toString();
}

echo json_encode($output, JSON_THROW_ON_ERROR);
