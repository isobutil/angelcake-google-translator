<?php
declare(strict_types=1);

require '../vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Translate\TranslateClient;





#[\AllowDynamicProperties]
class IBMWatson
{
    private string $apikey;
    private $client;

   
    public function __construct($apikey, $url)
    {
        $this->apikey = $apikey;
        $this->url = $url ?? '';

        $opts = [
            'suppressKeyFileNotice' => true,
        ];
        if (!empty($this->apikey)) {
            $opts['key'] = $this->apikey;
        }

        $this->client = new TranslateClient($opts);
    }
  /**
     * Translate a full document (placeholder)
     */
    public function translateDoc($inputFile, $source = 'it', $target = 'en')
    {
        // implement document translation if needed
        return null;
    }

    /**
     * waitForTranslation (placeholder)
     */
    private function waitForTranslation($docId)
    {
        // implement polling if needed
        return null;
    }

    /**
     * downloadTranslation (placeholder)
     */
    private function downloadTranslation($docId)
    {
        // implement download if needed
        return null;
    }

    /**
     * Translate Sentence
     *
     * @param mixed $sentences string or array of strings
     * @param string $source source language
     * @param string $target target language
     * @return string translated text
     */
    public function translateSentence($sentences, string $source, string $target): string
    {
        $response = $this->client->translate($sentences, [
            'target' => $target,
            'source' => $source,
        ]);

        $text = $response['text'] ?? $response['translatedText'] ?? '';
        if (is_array($text)) {
            $text = implode(' ', $text);
        }

        return (string)$text;
    }

    /**
     * Identify Language
     *
     * @param string $data
     * @return string language code or message
     */
    public function identifyLanguage(string $data): string
    {
        if (!is_string($data)) {
            throw new \InvalidArgumentException('Data must be a string');
        }

        $response = $this->client->detectLanguage($data);

        // Normalize response shapes
        $detected = null;
        if (is_array($response) && isset($response['languageCode'])) {
            $detected = $response;
        } elseif (is_array($response) && isset($response[0]) && is_array($response[0]) && isset($response[0]['languageCode'])) {
            $detected = $response[0];
        }

        if ($detected !== null && isset($detected['languageCode'], $detected['confidence'])) {
            if ((float)$detected['confidence'] >= 0.8) {
                return (string)$detected['languageCode'];
            }
            return (string)$detected['languageCode'] . ' (low confidence)';
        }

        return 'Impossibile determinare';
    }
}



