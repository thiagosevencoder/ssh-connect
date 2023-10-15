##CONNECT SSH WITH PHP

Simple manager of connections SSH with PHP using lib SSH2

## INSTALATION

To install this dependency, execute the comment below.
```shell
composer require sevencoder/ssh-connect 
```

## Utilization

To use the this lib, follow the example below

```php

<?php

require __DIR__.'/vendor/autoload.php';

//Dependency
use SevenCoder\SecureShell\SSH;

//Instance
$connectionSSH = new SSH;

$host = '127.0.0.1';
$port = '2222';

//Connection
if(!$connectionSSH->connect($host, $port)) {
    die('Conection Fail');
}

//Authentication with user && password
if($connectionSSH->authPassword('user','password')) {
    die('Athentication Fail');
}

//Authentication with pair keys
if($connectionSSH->authPublicKeyFile('user', 'id_rsa.pub', 'id_rsa.pem')) {
    die('Athentication Fail');    
}

//Execute Comands
$stdIo = $connectionSSH->exec('ls -l', $stdErr);
echo "STDERR:\n".$stdErr;
echo "STDIO:\n".$stdIo;

```

## Requirements
- PHP 7.0
- lib SSH2