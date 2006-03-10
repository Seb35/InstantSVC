/**
* Constructor AsyncRemoteRequest
* bzw. Definition eines AsyncRemoteRequest
*
* Event Handler to override:
*	- doOnStartLoad
*	- doOnLoadCompleted
*	- doOnReqStateChanged
*	- doOnStart
*	- doOnNewRequest
*
*/
function AsyncRemoteRequest() {
	/**
	* @private
	* XMLHTTPRequest request;
	*/
	this.request = null;
	this.aborted = false;
	this.method = 'GET';
	this.requestData = null;
	
	/**
	* Pause Zwischen Requests in Millisekunden
	*/
	this.delayBetweenRequests = 0;
	
	/*** Request Url */
	this.url = "";
	
	this.completed = false; //Ob der vollständige Auftrag abgeschlossen wurde
	//var timer = null; //Referenz zum Timer, der widerkehrend die Ausführung anstößt.
}

/**
* Holt Browserabhängig, das passende XMLHTTPRequest Objekt.
* @private
*/
AsyncRemoteRequest.prototype.getRequestObj = function() {
	var obj = null;
	try {
		obj = new ActiveXObject('Msxml2.XMLHTTP');
	}
	catch (e) {
		//alert(e);
		try {
			obj = new ActiveXObject('Microsoft.XMLHTTP');
		}
		catch (e) {
			obj = new XMLHttpRequest();
		}
	}
	return obj;
}
	
/**
* @public
*/
AsyncRemoteRequest.prototype.isCompleted = function() {
	return this.completed;
}
	
/**
* @public
*/
AsyncRemoteRequest.prototype.isActive = function() {
	if (!this.request) {
		return false;
	}
	return this.request.readyState == 1; //0 = uninitialized, 1 = loading, 2 = loaded, 3 = interactive, 4 = complete,
}
	
/**
* @public
*/
AsyncRemoteRequest.prototype.isFailed = function() {
	var status = null;
	try {
		status = this.request.status;
	}
	catch (e) {
		return false;
	}
	return (status == 200);
}
	
/**
* Überschreiben bzw. redefinieren
*/
AsyncRemoteRequest.prototype.doOnStartLoad = function() {
	//alert('doOnStartLoad not overridden');
};
	
/**
* Überschreiben bzw. redefinieren
*/
AsyncRemoteRequest.prototype.doOnLoadCompleted = function() {
	//alert('doOnLoadCompleted not overridden');
};

/**
* Überschreiben bzw. redefinieren
*/
AsyncRemoteRequest.prototype.doOnReqStateChanged = function() {
	//alert('doOnReqStateChanged not overridden');
};

/**
* Überschreiben bzw. redefinieren
*/
AsyncRemoteRequest.prototype.doOnStart = function() {
	//alert('doOnStart not overridden');
};

/**
* Überschreiben bzw. redefinieren
*/
AsyncRemoteRequest.prototype.doOnNewRequest = function() {
	//alert('doOnNewRequest not overridden');
};


/**
* Verarbeitet Zustandsänderung des Request Objektes
*/
AsyncRemoteRequest.prototype.processReqChange = function() {
	this.doOnReqStateChanged();
	// only if req shows "loaded"
	if (this.request.readyState == 1) {
		this.doOnStartLoad();
	}
	else if (this.request.readyState == 4) {
		this.doOnLoadCompleted();
		if (!this.isCompleted() && !this.aborted) {
			if (this.delayBetweenRequests == 0) {
				this.start();
			}
			else {
				var self = this;
				window.setTimeout(function() {self.start();}, this.delayBetweenRequests);
			}
		}
	}
}
	
/**
* @public
*/
AsyncRemoteRequest.prototype.abort = function() {
	this.aborted = true;
	this.request.abort();
}
	
/**
* @public
*/
AsyncRemoteRequest.prototype.start = function() {
	this.aborted = false;
	var self = this;
	this.request = this.getRequestObj();
	this.request.onreadystatechange = function () {self.processReqChange();};

	/* if (this.timer == null) {
		this.timer = window.setInterval("remoteCallBack()", 500);//Hack
	}*/
	this.doOnStart();
	this.request.open(this.method, this.url, true);
	this.request.send(this.requestData);
	//this.sendReqUntilCompleted();
}

/**
* Sorgt dafür, dass solange Requests verschickt werden, bis die Aufgabe erledigt ist.
*/
/*AsyncRemoteRequest.prototype.sendReqUntilCompleted = function() {
	var self = this;
	if (!this.isCompleted() && !this.isActive()) {
		this.doOnNewRequest();
		this.start();
	}
	
	if (!this.isCompleted()) {
		window.setTimeout(function() {self.sendReqUntilCompleted();}, 100);
	}
}*/