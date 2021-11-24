<?php
  // DB Params
  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');
  define('DB_PASS', '');
  define('DB_NAME', 'DuesPaymentSystem');

  // fb credentials
	define( 'FB_APP_ID', '597967324656000' );
	define( 'FB_APP_SECRET', '96b5f8442fa44b01bc8ee03d17da0271' );
	define( 'FB_REDIRECT_URI', 'http://localhost/DuesPaymentSystem/users/login' );

  // GOOGLE credentials
  define( 'GOOGLE_CLIENT_ID', '339949192946-oeiqofcjp8j81t759usbnm5eamp20uvn.apps.googleusercontent.com' );
	define( 'GOOGLE_CLIENT_SECRET', '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' );
	define( 'GOOGLE_REDIRECT_URI', 'http://localhost/DuesPaymentSystem/users/login' );

  // App Root
  define('APPROOT', dirname(dirname(__FILE__)));
  // URL Root
  define('URLROOT', 'http://localhost/DuesPaymentSystem');
  // Site Name
  define('SITENAME', 'PDO-DCC');
  // App Version