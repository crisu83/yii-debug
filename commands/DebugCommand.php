<?php

class DebugCommand extends CConsoleCommand
{
	const STATE_ON = 'on';
	const STATE_OFF = 'off';

	/**
	 * @var string the path to the environment configurations.
	 */
	public $runtimePath = 'application.runtime';

	/**
	 * Provides the command description.
	 * @return string the command description.
	 */
	public function getHelp()
	{
		return <<<EOD
USAGE
  yiic debug <state> <ip-filter>

DESCRIPTION
  @todo

EXAMPLES
 * yiic debug on 127.0.0.1
   Enables debugging mode from ip address '127.0.0.1'.
 * yiic debug off
   Disables debugging mode.
EOD;
	}


	/**
	 * Executes the command.
	 * @param array $args command line parameters for this command.
	 * @return integer application exit code.
	 */
	public function run($args)
	{
		if (!isset($args[0]))
			$this->usageError('The debugging state is not specified.');

		$state = $args[0];
		$runtimePath = Yii::getPathOfAlias($this->runtimePath);

		if (!is_dir($runtimePath) && !mkdir($runtimePath, 0777, true))
			throw new CException('Failed to create the runtime directory.');

		$debugFile = $runtimePath . DIRECTORY_SEPARATOR . 'debug';

		if ($state === self::STATE_ON)
		{
			if (!file_exists($debugFile))
				@chmod($debugFile, 0644);

			if (isset($args[1]))
			{
				$ipFilter = $args[1];
				file_put_contents($debugFile, $ipFilter);
				echo "Debugging enabled from {$ipFilter}.\n";
			}
			else
			{
				file_put_contents($debugFile, '');
				echo "Debugging enabled.\n";
			}
		}
		else
		{
			if (file_exists($debugFile))
				unlink($debugFile);

			echo "Debugging disabled.\n";
		}

		return 0;
	}
}