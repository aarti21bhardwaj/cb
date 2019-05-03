<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.8
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

/*
 * Configure paths required to find CakePHP + general filepath constants
 */
require __DIR__ . '/paths.php';

/*
 * Bootstrap CakePHP.
 *
 * Does the various bits of setup that CakePHP needs to do.
 * This includes:
 *
 * - Registering the CakePHP autoloader.
 * - Setting the default application paths.
 */
require CORE_PATH . 'config' . DS . 'bootstrap.php';

use Cake\Cache\Cache;
use Cake\Console\ConsoleErrorHandler;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Core\Plugin;
use Cake\Database\Type;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorHandler;
use Cake\Http\ServerRequest;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\Utility\Inflector;
use Cake\Utility\Security;
use Cake\Routing\Router;
// use Cake\Database\Type;

/**
 * Uncomment block of code below if you want to use `.env` file during development.
 * You should copy `config/.env.default to `config/.env` and set/modify the
 * variables as required.
 */
// if (!env('APP_NAME') && file_exists(CONFIG . '.env')) {
//     $dotenv = new \josegonzalez\Dotenv\Loader([CONFIG . '.env']);
//     $dotenv->parse()
//         ->putenv()
//         ->toEnv()
//         ->toServer();
// }

/*
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */
try {
    Configure::config('default', new PhpConfig());
    Configure::load('app', 'default', false);
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}

/*
 * Load an environment local configuration file.
 * You can use a file like app_local.php to provide local overrides to your
 * shared configuration.
 */
//Configure::load('app_local', 'default');

/*
 * When debug = true the metadata cache should only last
 * for a short time.
 */
//Plugin HTML to PDF convertor

if (Configure::read('debug')) {
    Configure::write('Cache._cake_model_.duration', '+2 minutes');
    Configure::write('Cache._cake_core_.duration', '+2 minutes');
    // disable router cache during development
    Configure::write('Cache._cake_routes_.duration', '+2 seconds');
}

/*
 * Set the default server timezone. Using UTC makes time calculations / conversions easier.
 * Check http://php.net/manual/en/timezones.php for list of valid timezone strings.
 */
date_default_timezone_set(Configure::read('App.defaultTimezone'));

/*
 * Configure the mbstring extension to use the correct encoding.
 */
mb_internal_encoding(Configure::read('App.encoding'));

/*
 * Set the default locale. This controls how dates, number and currency is
 * formatted and sets the default language to use for translations.
 */
ini_set('intl.default_locale', Configure::read('App.defaultLocale'));

/*
 * Register application error and exception handlers.
 */
$isCli = PHP_SAPI === 'cli';
if ($isCli) {
    (new ConsoleErrorHandler(Configure::read('Error')))->register();
} else {
    (new ErrorHandler(Configure::read('Error')))->register();
}

/*
 * Include the CLI bootstrap overrides.
 */
if ($isCli) {
    require __DIR__ . '/bootstrap_cli.php';
}

/*
 * Set the full base URL.
 * This URL is used as the base of all absolute links.
 *
 * If you define fullBaseUrl in your config file you can remove this.
 */
if (!Configure::read('App.fullBaseUrl')) {
    $s = null;
    if (env('HTTPS')) {
        $s = 's';
    }

    $httpHost = env('HTTP_HOST');
    if (isset($httpHost)) {
        Configure::write('App.fullBaseUrl', 'http' . $s . '://' . $httpHost);
    }
    unset($httpHost, $s);
}

Cache::setConfig(Configure::consume('Cache'));
ConnectionManager::setConfig(Configure::consume('Datasources'));
Email::setConfigTransport(Configure::consume('EmailTransport'));
Email::setConfig(Configure::consume('Email'));
Log::setConfig(Configure::consume('Log'));
Security::setSalt(Configure::consume('Security.salt'));

/*
 * The default crypto extension in 3.0 is OpenSSL.
 * If you are migrating from 2.x uncomment this code to
 * use a more compatible Mcrypt based implementation
 */
//Security::engine(new \Cake\Utility\Crypto\Mcrypt());

/*
 * Setup detectors for mobile and tablet.
 */
ServerRequest::addDetector('mobile', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isMobile();
});
ServerRequest::addDetector('tablet', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isTablet();
});

/*
 * Enable immutable time objects in the ORM.
 *
 * You can enable default locale format parsing by adding calls
 * to `useLocaleParser()`. This enables the automatic conversion of
 * locale specific date formats. For details see
 * @link https://book.cakephp.org/3.0/en/core-libraries/internationalization-and-localization.html#parsing-localized-datetime-data
 */
Type::build('time')
    ->useImmutable();
Type::build('date')
    ->useImmutable();
Type::build('datetime')
    ->useImmutable();
Type::build('timestamp')
    ->useImmutable();

/*
 * Custom Inflector rules, can be set to correctly pluralize or singularize
 * table, model, controller names or whatever other string is passed to the
 * inflection functions.
 */
//Inflector::rules('plural', ['/^(inflect)or$/i' => '\1ables']);
//Inflector::rules('irregular', ['red' => 'redlings']);
//Inflector::rules('uninflected', ['dontinflectme']);
//Inflector::rules('transliteration', ['/å/' => 'aa']);

Plugin::load('InspiniaTheme', ['bootstrap' => true,'routes' => true]);

// Plugin::load('CakePdf', ['bootstrap' => true]);
// CakePlugin::load('CakePdf', [
//                 'bootstrap' => true,
//                 'routes' => true
//             ]);
Plugin::load('Muffin/Trash');

Plugin::load('CakePdf', ['bootstrap' => true]);
Configure::write('CakePdf.crypto', 'CakePdf.Pdftk');
Configure::write('CakePdf', [
    'engine' => 'CakePdf.WkHtmlToPdf',
    'margin' => [
                    'bottom' => 10,
                    'left' =>  10,
                    'right' => 10,
                    'top' => 10
    ],
    'pageSize' => 'A4',
    'orientation' => 'portrait',
    'download' => true
]);

// Load Navogation file from config/navigation.php
if (file_exists(CONFIG . 'navigation.php')) {
    Configure::load('navigation');
}

if (file_exists(CONFIG . 'columnIndex.php')) {
    Configure::load('columnIndex');
}
$client = \Aws\S3\S3Client::factory([
    'credentials' => [
        'key'    => 'your-key',
        'secret' => 'your-secret',
    ],
    'region' => 'your-region',
    'version' => 'latest',
]);
$adapter = new \League\Flysystem\AwsS3v3\AwsS3Adapter(
    $client,
    'your-bucket-name',
    'optional-prefix'
);


Plugin::load('Josegonzalez/Upload');

if(!Configure::read('ImageUpload.uploadPathForTenantsImages')) {
    Configure::write('ImageUpload.uploadPathForTenantsImages',Configure::read('App.webroot').'/tenants_images');
}
if(!Configure::read('ImageUpload.uploadPathForTenantsImages')) {
    Configure::write('ImageUpload.uploadPathForTenantsImages',Configure::read('App.wwwRoot').'tenants_images');
}

if(!Configure::read('ImageUpload.unlinkPathForTenantsImages')) {
    Configure::write('ImageUpload.unlinkPathForTenantsImages',Configure::read('App.wwwRoot').'tenants_images');
}

if(!Configure::read('ImageUpload.uploadPathForInstructorsImages')) {
    Configure::write('ImageUpload.uploadPathForInstructorsImages',Configure::read('App.webroot').'/instructors_images');
}
if(!Configure::read('ImageUpload.uploadPathForInstructorsImages')) {
    Configure::write('ImageUpload.uploadPathForInstructorsImages',Configure::read('App.wwwRoot').'instructors_images');
}

if(!Configure::read('ImageUpload.unlinkPathForInstructorsImages')) {
    Configure::write('ImageUpload.unlinkPathForInstructorsImages',Configure::read('App.wwwRoot').'instructors_images');
}
if(!Configure::read('ImageUpload.uploadPathForInstructorsFiles')) {
    Configure::write('ImageUpload.uploadPathForInstructorsFiles',Configure::read('App.webroot').'/instructors_files');
}

if(!Configure::read('ImageUpload.unlinkPathForInstructorsFiles')) {
    Configure::write('ImageUpload.unlinkPathForInstructorsFiles',Configure::read('App.wwwRoot').'instructors_files');
}
if(!Configure::read('ImageUpload.uploadPathForInstructorsApplications')) {
    Configure::write('ImageUpload.uploadPathForInstructorsApplications',Configure::read('App.webroot').'/instructors_applications');
}
if(!Configure::read('ImageUpload.unlinkPathForInstructorsApplications')) {
    Configure::write('ImageUpload.unlinkPathForInstructorsApplications',Configure::read('App.wwwRoot').'instructors_applications');
}
if(!Configure::read('ImageUpload.uploadPathForInstructorsForms')) {
    Configure::write('ImageUpload.uploadPathForInstructorsForms',Configure::read('App.webroot').'/instructors_forms');
}
if(!Configure::read('ImageUpload.unlinkPathForInstructorsForms')) {
    Configure::write('ImageUpload.unlinkPathForInstructorsForms',Configure::read('App.wwwRoot').'instructors_forms');
}
if(!Configure::read('ImageUpload.uploadPathForCorporateClients')) {
    Configure::write('ImageUpload.uploadPathForCorporateClients',Configure::read('App.webroot').'/corporate_client');
}
if(!Configure::read('ImageUpload.unlinkPathForCorporateClients')) {
    Configure::write('ImageUpload.unlinkPathForCorporateClients',Configure::read('App.wwwRoot').'corporate_client');
}
if (file_exists(CONFIG . 'eventsData.php')) {
    Configure::load('eventsData');
}
// if(!Configure::read('uploadSetting')){
//     Configure::write('uploadSetting','s3');
// }
if(!Configure::read('Josegonzalez/upload')){
    Configure::write('Josegonzalez/upload',$adapter);
}
Type::map('json', 'Cake\Database\Type\JsonType');

Configure::write('siteUrl','http://localhost/classbyte/');
require __DIR__ . '/events.php';