<?php

declare(strict_types=1);

use Ssch\TYPO3Rector\Rector\v10\v0\RemoveFormatConstantsEmailFinisherRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/../../../../../../config/config.php');

    $services = $containerConfigurator->services();
    $services->set(RemoveFormatConstantsEmailFinisherRector::class);
};
