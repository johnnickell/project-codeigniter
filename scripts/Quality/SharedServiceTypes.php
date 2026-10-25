<?php

declare(strict_types=1);

namespace Quality;

use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicStaticMethodReturnTypeExtension;
use PHPStan\Type\Type;

/**
 * Class SharedServiceTypes
 */
final class SharedServiceTypes implements DynamicStaticMethodReturnTypeExtension
{
    /**
     * @inheritDoc
     */
    public function getClass(): string
    {
        return 'Config\\Services';
    }

    /**
     * @inheritDoc
     */
    public function isStaticMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection->getName() === 'getSharedInstance';
    }

    /**
     * Resolves the shared branch from the literal factory's declared contract
     */
    public function getTypeFromStaticMethodCall(
        MethodReflection $methodReflection,
        StaticCall $methodCall,
        Scope $scope
    ): ?Type {
        $argument = $methodCall->getArgs()[0] ?? null;
        $class = $scope->getClassReflection();
        if ($argument === null || $class === null) {
            return null;
        }
        $names = $scope->getType($argument->value)->getConstantStrings();
        if (count($names) !== 1 || !$class->hasNativeMethod($names[0]->getValue())) {
            return null;
        }

        return $class->getNativeMethod($names[0]->getValue())->getVariants()[0]->getReturnType();
    }
}
