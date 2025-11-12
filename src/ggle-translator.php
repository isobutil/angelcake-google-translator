<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

# [START translate_quickstart]
# Includes the autoloader for libraries installed with composer
require '../vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Translate\TranslateClient;
use Dotenv\Dotenv;

# Load .env from project root (safeLoad won't throw if missing)
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

# Global API key (loaded from .env or environment)
# .env should contain API_KEY=your_key
$apiKey = $_ENV['API_KEY'] ?? getenv('API_KEY') ?? null;

/**
 * @param string $text The text to translate.
 * @param string $targetLanguage Language to translate to.
 */
function translate(string $text, string $targetLanguage): void
{
    /** Uncomment and populate these variables in your code */
    // $text = 'The text to translate.';
    // $targetLanguage = 'ja';  // Language to translate to
    global $apiKey;
    $translate = new TranslateClient([
    'key' => $apiKey
    ]);

    # The text to translate
    $text = 'Hello, world!';
    # The target language
    $target = 'it';

    # Translates some text into Russian
    $translation = $translate->translate($text, [
        'target' => $target
    ]);
    
    print('Translation: ' . $translation['text']);
}


/**
 * @param string $text The text whose language to detect.  This will be detected as en.
 */
function detect_language(string $text): void
{
    global $apiKey; 
    $translate = new TranslateClient([
    'key' => $apiKey
    ]);
    $result = $translate->detectLanguage($text);
    print("Language code: $result[languageCode]\n");
    print("Confidence: $result[confidence]\n");
}


translate("Hello, world!", "it");
detect_language("che sturia"); 