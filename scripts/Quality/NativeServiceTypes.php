<?php

declare(strict_types=1);

namespace Quality;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;

/**
 * Class NativeServiceTypes
 */
final class NativeServiceTypes implements DynamicFunctionReturnTypeExtension
{
    /**
     * Constructs NativeServiceTypes
     */
    public function __construct(private readonly ReflectionProvider $reflection)
    {
    }

    /**
     * @inheritDoc
     */
    public function isFunctionSupported(FunctionReflection $functionReflection): bool
    {
        return in_array($functionReflection->getName(), ['service', 'config'], true);
    }

    /**
     * Resolves literal native discovery names without executing a factory
     */
    public function getTypeFromFunctionCall(
        FunctionReflection $functionReflection,
        FuncCall $functionCall,
        Scope $scope
    ): ?Type {
        $argument = $functionCall->getArgs()[0] ?? null;
        if ($argument === null) {
            return null;
        }
        $names = $scope->getType($argument->value)->getConstantStrings();
        if (count($names) !== 1) {
            return null;
        }
        $name = $names[0]->getValue();
        if ($functionReflection->getName() === 'config') {
            $class = str_contains($name, '\\') ? $name : 'Config\\'.$name;

            return $this->reflection->hasClass($class) ? new ObjectType($class) : null;
        }
        $factories = ['Config\\Services', 'CodeIgniter\\Config\\Services', 'CodeIgniter\\Queue\\Config\\Services'];
        foreach ($factories as $class) {
            $factory = $this->reflection->getClass($class);
            if ($factory->hasNativeMethod($name)) {
                return $factory->getNativeMethod($name)->getVariants()[0]->getReturnType();
            }
        }

        return null;
    }
}
