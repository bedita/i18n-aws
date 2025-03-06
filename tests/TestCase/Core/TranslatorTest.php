<?php
declare(strict_types=1);

/**
 * BEdita, API-first content management framework
 * Copyright 2023 Atlas Srl, Chialab Srl
 *
 * This file is part of BEdita: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * See LICENSE.LGPL or <http://gnu.org/licenses/lgpl-3.0.html> for more details.
 */
namespace BEdita\I18n\Aws\Test\Core;

use Aws\Translate\TranslateClient;
use BEdita\I18n\Aws\Core\Translator;
use Cake\TestSuite\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use ReflectionClass;

/**
 * {@see \BEdita\I18n\AWS\Core\Translator} Test Case
 */
#[CoversClass(Translator::class)]
#[CoversMethod(Translator::class, 'setup')]
#[CoversMethod(Translator::class, 'translate')]
class TranslatorTest extends TestCase
{
    /**
     * Test setup.
     *
     * @return void
     * @covers ::setup()
     */
    public function testSetup(): void
    {
        $translator = new class extends Translator {
            public function getAwsClient(): TranslateClient
            {
                return $this->awsClient;
            }
        };
        $translator->setup(['profile' => 'test-profile', 'region' => 'test-region']);
        $expected = [
            'profile' => 'test-profile',
            'region' => 'test-region',
            'version' => 'latest',
        ];
        $reflection = new ReflectionClass($translator);
        $property = $reflection->getProperty('options');
        $property->setAccessible(true);
        $actual = $property->getValue($translator);
        static::assertSame($expected, $actual);
        static::assertNotEmpty($translator->getAwsClient());
    }

    /**
     * Test translate.
     * It throws an error during translation, so this will return an empty translation `{"translation":[]}`.
     *
     * @return void
     * @covers ::translate()
     */
    public function testTranslate(): void
    {
        $translator = new class extends Translator {
            public function getAwsClient(): TranslateClient
            {
                return $this->awsClient;
            }
        };
        $translator->setup([
            'profile' => 'test-profile',
            'region' => 'test-region',
        ]);
        $result = $translator->translate(['test'], 'en', 'it');
        static::assertEquals('{"translation":[]}', $result);
    }
}
