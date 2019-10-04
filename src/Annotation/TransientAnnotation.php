<?php

declare(strict_types=1);

namespace Ssch\TYPO3Rector\Annotation;

use PhpParser\Node;
use PhpParser\Node\Stmt\Property;
use Rector\Rector\AbstractRector;
use Rector\RectorDefinition\ConfiguredCodeSample;
use Rector\RectorDefinition\RectorDefinition;

final class TransientAnnotation extends AbstractRector
{
    /**
     * @var string
     */
    private $oldAnnotation = 'transient';

    /**
     * @var string
     */
    private $newAnnotation = 'TYPO3\CMS\Extbase\Annotation\ORM\Transient';

    public function getNodeTypes(): array
    {
        return [Property::class];
    }

    /**
     * Process Node of matched type.
     */
    public function refactor(Node $node): ?Node
    {
        if (!$this->docBlockManipulator->hasTag($node, $this->oldAnnotation)) {
            return null;
        }

        $this->docBlockManipulator->replaceAnnotationInNode($node, $this->oldAnnotation, $this->newAnnotation);

        return $node;
    }

    public function getDefinition(): RectorDefinition
    {
        return new RectorDefinition(
            'Turns properties with `@annotation` to properties with `@newAnnotation`',
            [
                new ConfiguredCodeSample(
                    <<<'CODE_SAMPLE'
/**
 * @transient
 */
private $someProperty;
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
/**
 * @TYPO3\CMS\Extbase\Annotation\ORM\Transient
 */
private $someProperty;

CODE_SAMPLE
                    ,
                    [
                    ]
                ),
            ]
        );
    }
}
