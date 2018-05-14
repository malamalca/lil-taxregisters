<?php
	use Cake\Core\Configure;
	use Cake\Core\Configure\Engine\PhpConfig;
	use Cake\Event\EventManager;
    use Cake\Log\Log;
    
	use LilTaxRegisters\Event\LilTaxRegistersEvents;
	
	Configure::load('LilTaxRegisters.config');
	
	$LilTaxRegistersEvents = new LilTaxRegistersEvents();
	EventManager::instance()->on($LilTaxRegistersEvents);
    
    Log::setConfig('taxRegister', [
        'className' => 'File',
        'path' => LOGS,
        'levels' => [],
        'scopes' => ['taxrSign', 'taxrSoap'],
        'file' => 'tax_registers.log',
    ]);
