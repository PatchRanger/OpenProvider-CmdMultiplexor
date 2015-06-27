# Via Composer
1. Install Composer: http://getcomposer.org
2. Open the directory where you want to install the library.
3. Create a file called `composer.json` with the following inside:
```
{
  "minimum-stability": "dev",
  "prefer-stable" : true,
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/PatchRanger/OpenProvider-CmdMultiplexor"
    }
  ],
  "require": {
    "PatchRanger/OpenProvider-CmdMultiplexor": "dev-master"
  }
}
```
4. Create the `index.php` file with the following:
```
<?php
require_once 'vendor/autoload.php';
require_once 'vendor/PatchRanger/index.php';
```
