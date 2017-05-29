;$(function () {
	var $tc = $('#terminal');

	var sendRequest = function (command, terminal) {
		try {
			$.ajax({
				url: 'marsbase.php',
				type: 'post',
				cache: false,
				data: {'command': command},
				dataType: 'json',
				complete: function (xhr, status) {
					/**
					 * @type {{error: string, rovers: Array}}
					 */
					var data = xhr.responseJSON;
					if (data.error) {
						terminal.error(data.error);
					}
					else if (data.rovers.length) {
						terminal.echo("\n");
						terminal.echo("<<<<<<<<<<");
						for (var i in data.rovers) {
							terminal.echo("ROVER " + (+i+1) + ": " + data.rovers[i].position);
						}
					}
				},
				error: function (xhr, status, error) {
					terminal.error(xhr.responseText);
					console.log(arguments);
				}
			});
		}
		catch (e) {
			terminal.error(new String(e));
		}
	};

	var processCommand = function (command, terminal) {
		command = command.replace(/^\s+|\s+$/g, '');

		switch (command) {
			case "":
				terminal.echo('TYPE A COMMAND');
				break;

			case "demo":
				terminal.exec("5 5\n1 2 N\nLMLMLMLMM\n3 3 E\nMMRMMRMRRM");
				break;

			case "demo2":
				terminal.exec("5 5\n3 1 E\nRMRMRMLMLM\n5 5 S\nRMMLMMRM");
				break;

			default:
				sendRequest(command, terminal);
				break;
		}
	};

	$tc.terminal(processCommand, {
		greetings: $('title').text()+"\n\n"+
		"Type commands for Mars rovers using Ctrl+Enter to separate lines.\n"+
		"Type 'demo' or 'demo2' to execute test commands.",
		name: 'Rovers',
		height: "100%",
		prompt: '> '
	});

});