# Basic lib to write PPP modules in PHP

[![Build Status](https://scrutinizer-ci.com/g/ProjetPP/PPP-LibModule-PHP/badges/build.png?b=master)](https://scrutinizer-ci.com/g/ProjetPP/PPP-LibModule-PHP/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/ProjetPP/PPP-LibModule-PHP/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ProjetPP/PPP-LibModule-PHP/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ProjetPP/PPP-LibModule-PHP/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ProjetPP/PPP-LibModule-PHP/?branch=master)

On [Packagist](https://packagist.org/packages/ppp/libmodule):
[![Latest Stable Version](https://poser.pugx.org/ppp/libmodule/version.png)](https://packagist.org/packages/ppp/libmodule)
[![Download count](https://poser.pugx.org/ppp/libmodule/d/total.png)](https://packagist.org/packages/ppp/libmodule)


## Installation

Use one of the below methods:

1 - Use composer to install the library and all its dependencies using the master branch:

    composer require "ppp/libmodule":dev-master"

2 - Create a composer.json file that just defines a dependency on version 0.2 of this package, and run 'composer install' in the directory:

    {
        "require": {
            "ppp/ppp/libmodule"": "~0.2.0"
        }
    }


## Example

Here is a small usage example:

```php
// Load everything
require_once(__DIR__ . "/vendor/autoload.php");

// A very simple class implementing RequestHandler interface
class MyRequestHandler implements PPP\Module\RequestHandler {
	public function buildResponse(PPP\Module\DataModel\ModuleRequest $request) {
		return new PPP\Module\DataModel\ModuleResponse(
			$request->getLanguageCode(),
			new PPP\DataModel\MissingNode(),
			0
		);
	}
}

// Lets run the entry point!
$entryPoint = new PPP\Module\ModuleEntryPoint(new MyRequestHandler());
$entryPoint->exec();
```
