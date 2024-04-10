<?php

namespace Modules\LatestDataConnector\Actions;

use API;
use CProfile;
use CControllerDashboardWidgetView;
use CControllerResponseData;

class WidgetView extends CControllerDashboardWidgetView {

	protected function doAction(): void {

		$data = [
			'name' => $this->getInput('name', $this->widget->getDefaultName()),
			'user' => [
				'debug_mode' => $this->getDebugMode()
			],
			'is_template_dashboard' => $this->isTemplateDashboard()
		];

		$hostids = [];
		$groupids = [];

		if ($this->isTemplateDashboard() && !$this->fields_values['override_hostid']) {
			$data['error'] = _('No data.');
		}
		else {
			if ($this->isTemplateDashboard()) {
				$hostids = $this->fields_values['override_hostid'];
			}
			else {
				$groupids = $this->fields_values['groupids'] ?: [];
				$hosts = $this->fields_values['hosts'] ?: [];
				$hostids = [];
				foreach ($hosts as $host_pattern) {
					$hostids += API::Host()->get([
						'output' => ['hostid'],
						'search' => [
							'name' => $host_pattern
						],
						'searchWildcardsEnabled' => true,
						'preservekeys' => true
					]);
				}
			}
		}

		// We need to reset the home funnel so that when the user clicks
		// any prior profile settings do not interfere
		CProfile::update('web.monitoring.latest.properties', '{"filter_name":""}', 3);

		$data += [
			'error' => null,
			'groupids' => $groupids,
			'fields_values' => $this->fields_values,
			'hostids' => $hostids
		];

		$this->setResponse(new CControllerResponseData($data));
	}

}
