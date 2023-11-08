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
namespace BEdita\I18n\Aws\Core;

use Aws\Translate\TranslateClient;
use BEdita\I18n\Core\TranslatorInterface;
use Cake\Log\LogTrait;
use Cake\Utility\Hash;
use Exception;
use Psr\Log\LogLevel;

class Translator implements TranslatorInterface
{
    use LogTrait;

    /**
     * The AWS API client.
     *
     * @var \Aws\Translate\TranslateClient
     */
    protected TranslateClient $awsClient;

    /**
     * The engine options.
     *
     * @var array
     */
    protected array $options = [];

    /**
     * Setup translator engine.
     *
     * @param array $options The options
     * @return void
     */
    public function setup(array $options = []): void
    {
        $this->options = $options;
        $this->options['key'] = (string)Hash::get($options, 'auth_key');
        $this->awsClient = new TranslateClient([
            'profile' => $this->options['profile'],
            'region' => $this->options['region'],
            'version' => 'latest',
        ]);
    }

    /**
     * Translate an array of texts $texts from language source $from to language target $to
     *
     * @param array $texts The texts to translate
     * @param string $from The source language
     * @param string $to The target language
     * @param array $options The options
     * @return string The translation in json format, i.e.
     * {
     *     "translation": [
     *         "<translation of first text>",
     *         "<translation of second text>",
     *         [...]
     *         "<translation of last text>"
     *     ]
     * }
     */
    public function translate(array $texts, string $from, string $to, array $options = []): string
    {
        $translation = [];
        try {
            $translation = [];
            foreach ($texts as $key => $text) {
                $translation[$key] = $this->awsClient->translateText([
                    'SourceLanguageCode' => $from,
                    'TargetLanguageCode' => $to,
                    'Text' => $text,
                ])['TranslatedText'];
            }
        } catch (Exception $e) {
            $this->log($e->getMessage(), LogLevel::ERROR);
        }

        return (string)json_encode(compact('translation'));
    }
}
