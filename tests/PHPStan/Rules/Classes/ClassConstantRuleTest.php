<?php declare(strict_types = 1);

namespace PHPStan\Rules\Classes;

use PHPStan\Rules\Rule;

class ClassConstantRuleTest extends \PHPStan\Rules\AbstractRuleTest
{

	protected function getRule(): Rule
	{
		return new ClassConstantRule($this->createBroker());
	}

	public function testClassConstant()
	{
		$this->analyse(
			[
				__DIR__ . '/data/class-constant.php',
				__DIR__ . '/data/class-constant-defined.php',
			],
			[
				[
					'Class ClassConstantNamespace\Bar not found.',
					6,
				],
				[
					'Using self outside of class scope.',
					7,
				],
				[
					'Access to undefined constant ClassConstantNamespace\Foo::DOLOR.',
					10,
				],
				[
					'Access to undefined constant ClassConstantNamespace\Foo::DOLOR.',
					16,
				],
				[
					'Using static outside of class scope.',
					18,
				],
				[
					'Using parent outside of class scope.',
					19,
				],
			]
		);
	}

	/**
	 * @requires PHP 7.1
	 */
	public function testClassConstantVisibility()
	{
		$this->analyse([__DIR__ . '/data/class-constant-visibility.php'], [
			[
				'Access to private constant PRIVATE_BAR of class ClassConstantVisibility\Bar.',
				25,
			],
			[
				'Access to parent::BAZ but ClassConstantVisibility\Foo does not extend any class.',
				27,
			],
			[
				'Access to undefined constant ClassConstantVisibility\Bar::PRIVATE_FOO.',
				45,
			],
			[
				'Access to private constant PRIVATE_FOO of class ClassConstantVisibility\Foo.',
				46,
			],
			[
				'Access to private constant PRIVATE_FOO of class ClassConstantVisibility\Foo.',
				47,
			],
			[
				'Access to protected constant PROTECTED_FOO of class ClassConstantVisibility\Foo.',
				63,
			],
		]);
	}

}
