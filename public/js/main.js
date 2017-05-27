;$(function () {
	var $outputConsole = $('#output'),
		$inputConsole = $('#command'),
		$inputForm = $('#input-form'),
		$moonbaseLog = $('#log');

	var getLevelType = function (msgLevel) {
		return (msgLevel > 0 ? 'ok' : (msgLevel === 0 ? 'info' : 'error'));
	};

	var validateInput = function () {
		return true;
	};

	var printLogMessage = function (message, messageLevel) {
		$moonbaseLog.prepend('<p class="rv-message-'+getLevelType(messageLevel)+'">'+message+'</p>');
		console.log(message);
	};

	var receiveResult = function (jqXHR, textStatus) {
		var message;
		if (jqXHR.responseJSON.error) {
			message = jqXHR.responseJSON.error;
			printLogMessage(message, -1);
		}
		else {
			for (var i in jqXHR.responseJSON.rovers) {
				printLogMessage(jqXHR.responseJSON.rovers[i].position);
			}
		}
	};

	var showError = function (jqXHR, textStatus, errorThrown) {
		printLogMessage(jqXHR.responseText, -1);
		console.log(errorThrown);
	};

	var sendCommand = function (dataText, completeFunc, failFunc) {
		$.ajax({
			url: $inputForm.prop('action'),
			type: 'post',
			cache: false,
			data: {'command': dataText},
			dataType: 'json',
			complete: completeFunc,
			error: failFunc
		});
	};

	var processCommand = function (e) {
		var inputText = $inputConsole.val();

		try {
			validateInput(inputText);
			sendCommand(inputText, receiveResult, showError);
		}
		catch (exception) {
			showError(exception.text())
		}

		return false;
	};

	$inputForm.on('submit', processCommand);
});