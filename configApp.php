<?php

/* Go to My Apps dashboard: https://developers.mercadolibre.com.ar/apps/home, and get the information you need in order to the following enviroment variables */

/* Your Application Id */
$appId = '8165220320761420';

/* Your Secret Key */
$secretKey = 'Z25tEGV3CvvdHqar46o55Mp7TJyRmL7p';

/* The Redirect url */
$redirectURI = 'http://localhost/php-sdk/autoanswer/auto-answering/';

/* The site id of the country where your application will work.
If you don't know your site_id go to our sites resources: https://api.mercadolibre.com/sites  */
$siteId = 'MCO';



//////////////////////////////////////////////////////////////////////////////////////////////////////
//If you don't use Heroku use the next config

// $appId = 'App_ID';

// $secretKey = 'Secret_Key';

// $redirectURI = 'Redirect_URI';

// $siteId = 'MLB';