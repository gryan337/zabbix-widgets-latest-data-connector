class CWidgetLatestDataConnector extends CWidget {
	hasPadding() {
		return false;
	}

	setContents(response) {
		super.setContents(response);

		if (this._fields.content !== '') {
			var rawHtml = `${this._fields.content}`;
			const widgetBody = this._container.querySelector('.dashboard-grid-widget-body');

			let url = '';
			if (widgetBody.innerHTML) {
				url = widgetBody.innerHTML;
				widgetBody.innerHTML = '';
			}

			if (url !== '') {
				rawHtml = rawHtml.replace(/{#URL}/g, url);
			}

			var wrapperDiv = document.createElement('div');
			widgetBody.innerHTML = rawHtml;
		}
		else {
			if (this._fields.groupids?.hasOwnProperty('_reference')) {
				var elem = this._target.querySelector('[groupname]');
				if (elem) {
					var value = elem.getAttribute('groupname');
					elem.innerHTML = elem.innerHTML + ": <br /><br />" + "(" + value + ")";
				}
			}

			if (this._fields.hostids?.hasOwnProperty('_reference')) {
				var elem = this._target.querySelector('[hostname]');
				if (elem) {
					var value = elem.getAttribute('hostname');
					elem.innerHTML = elem.innerHTML + ": <br /><br />" + "(" + value + ")";
				}
			}
		}
	}
}
