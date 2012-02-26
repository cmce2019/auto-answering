MeliPHP unofficial MercadoLibre PHP SDK (v.0.0.2)
==========================

This repository contains the open source MeliPHP Unofficial PHP SDK that allows you to access MercadoLibre Platform from your PHP app. 
MeliPHP is licensed under the Apache Licence, Version 2.0
(http://www.apache.org/licenses/LICENSE-2.0.html)


Usage
-----

You need sign up your application [http://en.mercadolibre.io/aplicaciones](http://en.mercadolibre.io/aplicaciones)

		// Try to put this code at the top
		require '../src/meli.php';
	
		// Create our Application instance (replace this with your country, appId and secret).
		$meli = new Meli(array(
			'countryId' 	=> 'ar',
			'appId'  		=> 12345,
			'secret' 		=> dsadsaDWFfs24DF34dgg43T3,
		));


Examples
--------

* Login with MercadoLibre
		
		$userId = $meli->initConnect();
		
		if ($userId) {
		  $user = $meli->getWithAccessToken('/users/me');
		}

	[code](http://github.com/foocoders/meli-php/blob/master/examples/example_login.php),
	[online](http://meliphp.phpfogapp.com/examples/example_login.php)

* Search items
 	
		$query = $_REQUEST['q'];
	
		$search = $meli->get('/sites/#{siteId}/search',array(
			'q' => $query,
		));
	
	[code](http://github.com/foocoders/meli-php/blob/master/examples/example_search.php),
	[online](http://meliphp.phpfogapp.com/examples/example_search.php)

=======
* View item

	[code](http://github.com/foocoders/meli-php/blob/master/examples/example_item.php)
	[online](http://meliphp.phpfogapp.com/examples/example_item.php)