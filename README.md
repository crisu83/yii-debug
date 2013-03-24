yii-debug
=========

Debugging tools for the Yii PHP framework.

## Configuration

Add the debug command to your console config file (usually **protected/config/console.php**):

```php
// console application configuration
return array(
    .....
    'commandMap' => array(
        'debug' => array(
            'class' => 'path.alias.to.DebugCommand',
            'runtimePath' => 'application.runtime', // the path to the application runtime folder
        ),
    ),
);
```
***console.php***

Update your entry script (usually **index.php**) to use the Debugger:

```php
$debugger = __DIR__ . '/path/to/Debugger.php';
$yii = __DIR__ . '/path/to/yii.php';

require_once($debugger);

Debugger::init(__DIR__ . '/protected/runtime/debug');

require_once($yii);
```
***index.php***

## Usage

To enable debugging with the following command:

```
yiic debug on
```

Optionally you can specify an ip filter (replace `{ip-address}` with the desired ip address):

```
yiic debug on {ip-address}
```

To turn of debugging mode, simply run the following command:

```
yiic debug off
```
