<?php

namespace Modules\LatestDataConnector;


use Zabbix\Core\CWidget;

class Widget extends CWidget {

	public const FONT_STYLE_BOLD = 0;
	public const FONT_STYLE_ITALIC = 1;
	public const FONT_STYLE_UNDERLINE = 2;

	public const FONT_FAMILY = [
		0 => 'Arial',
		1 => 'Arial Black',
		2 => 'Comic Sans',
		3 => 'Courier New',
		4 => 'Georgia',
		5 => 'Helvetica',
		6 => 'Impact',
		7 => 'Lucida Console',
		8 => 'Lucida Sans',
		9 => 'Palatino',
		10 => 'Tahoma',
		11 => 'Times New Roman',
		12 => 'Verdana'
	];

	public const SORT_ORDER = [
		0 => ZBX_SORT_UP,
		1 => ZBX_SORT_DOWN
	];

	public const SORT_FIELDS = [
		0 => 'host',
		1 => 'name'
	];

	public function getDefaultName(): string {
		return _('Latest data connector');
	}

}
