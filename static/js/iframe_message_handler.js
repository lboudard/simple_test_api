(function(window) {
	MessagesDispatcher = function() {
		return {
			init: function(targetDomain, targetFrame) {
                var that = this;
                this.targetDomain = targetDomain;
				this.targetFrame = targetFrame;
				this.sourceDomain = window.location.protocol + '//' + window.location.host;
				this.messageHandlers = [];
                this.messageCallback = function(message) { that.processMessage(that, message); };
                window.addEventListener('message', this.messageCallback, false);
			},
			getWindow: function(name) {
                if (name === 'parent') {
                    return window[name];
                } else {
    				return parent.frames[name];
                }
			},
			post: function(data) {
				this.castMessage({
					'data' : data,
					'sourceDomain' : this.sourceDomain,
					'targetOrigin' : this.targetDomain,
				});
			},
            castMessage: function(message) {
                this.getWindow(this.targetFrame).postMessage(JSON.stringify(message), message.targetOrigin);
            },
			addMessageHandler: function(h) {
				this.messageHandlers.push(h);
			},
            processMessage: function(self, message) {
                var data = JSON.parse(message.data);
                if (data && (data.sourceDomain == self.targetDomain)) {
                    for (var i = 0; i < this.messageHandlers.length; i++) {
                        this.messageHandlers[i](data.data, message.source, self);
                    }
                }
            },
		}
	};
})(this);
