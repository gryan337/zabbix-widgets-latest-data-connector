<?php

namespace Modules\LatestDataConnector\Actions;

use API,
	CControllerDashboardWidgetView,
	CControllerResponseData,
	CProfile,
	CWebUser,
	Modules\LatestDataConnector\Widget;

class WidgetView extends CControllerDashboardWidgetView {

	protected function doAction(): void {
		$idx2 = $this->fields_values['latest_data_dashboard'];
		if ($idx2 == 0) {
			CProfile::update('web.monitoring.latest.properties', '{"filter_name":""}', 3);
		}

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
			$data['error'] = null;
			if ($this->isTemplateDashboard()) {
				$hostids = $this->fields_values['override_hostid'];
			}
			else {
				$groupids = $this->fields_values['groupids'] ?: [];
				if ($groupids) {
					$group_names = API::HostGroup()->get([
						'output' => ['name'],
						'groupids' => $groupids,
						'preservekeys' => true
					]);
				}
				else {
					$group_names = [];
				}

				$hostids = [];
				if ($hostids) {
					$host_names = API::Host()->get([
						'output' => ['host'],
						'hostids' => $hostids,
						'preservekeys' => true
					]);
				}
				else {
					$host_names = [];
				}

				$hosts = $this->fields_values['hosts'] ?: [];
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

		$data += [
			'groupids' => $groupids,
			'fields_values' => $this->fields_values,
			'hostids' => $hostids,
			'group_names' => $group_names,
			'host_names' => $host_names
		];

		$this->setResponse(new CControllerResponseData($data));
	}

}
