### Code snippets

```php

    /**
     * Decodes MIME/HTTP encoded header values.
     *
     * @param string $header
     *   The header to decode.
     *
     * @return string
     *   The mime-decoded header.
     */
    public function mimeHeaderDecode($header)
    {
        $callback = function ($matches) {
            $data = (strtolower($matches[2]) === 'b') ? base64_decode($matches[3]) : str_replace('_', ' ', quoted_printable_decode($matches[3]));
            if (strtolower($matches[1]) !== 'utf-8') {
                $data = $this->convertToUtf8($data, $matches[1]);
            }
            return $data;
        };
        // First step: encoded chunks followed by other encoded chunks (need to collapse whitespace)
        $header = preg_replace_callback('/=\?([^?]+)\?([Qq]|[Bb])\?([^?]+|\?(?!=))\?=\s+(?==\?)/', $callback, $header);
        // Second step: remaining chunks (do not collapse whitespace)
        return preg_replace_callback('/=\?([^?]+)\?([Qq]|[Bb])\?([^?]+|\?(?!=))\?=/', $callback, $header);
    }

    /**
     * Converts data to UTF-8.
     *
     * Requires the iconv, GNU recode or mbstring PHP extension.
     *
     * @param string $data
     *   The data to be converted.
     * @param string $encoding
     *   The encoding that the data is in.
     *
     * @return string|bool
     *   Converted data or FALSE.
     */
    public function convertToUtf8($data, $encoding)
    {
        return @iconv($encoding, 'utf-8', $data);
    }
```
