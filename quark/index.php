<?php
include __DIR__ . '/loader.php';

use Quark\Quark;
use Quark\QuarkConfig;

use Quark\AuthorizationProviders\Session;

use Quark\DataProviders\MySQL;

use Models\User;

const PS_DATA = 'data';
const PS_SESSION = 'session';

$config = new QuarkConfig(__DIR__ . '/runtime/application.ini');

$config->Localization(__DIR__ . '/localization.ini');

$config->DataProvider(PS_DATA, new MySQL());

$config->AuthorizationProvider(PS_SESSION, new Session(), new User());

Quark::Run($config);