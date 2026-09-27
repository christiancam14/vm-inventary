<?php

namespace App\Services;

use App\Models\Product;
use Picqer\Barcode\BarcodeGenerator;
use Picqer\Barcode\BarcodeGeneratorSVG;
use Picqer\Barcode\Exceptions\BarcodeException;
use Throwable;

class BarcodeLabelService
{
    /**
     * EAN-13 for in-store use. Prefix 20 is reserved for codes that stay inside the shop.
     */
    public function generateUniqueEan13(?int $ignoreProductId = null): string
    {
        for ($attempt = 0; $attempt < 25; $attempt++) {
            $body = '20'.str_pad((string) random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
            $code = $body.$this->eanCheckDigit($body);

            $exists = Product::query()
                ->when($ignoreProductId, fn ($query) => $query->where('id', '!=', $ignoreProductId))
                ->where('barcode', $code)
                ->exists();

            if (! $exists) {
                return $code;
            }
        }

        throw new \RuntimeException('Could not generate a unique barcode.');
    }

    public function labelSvg(string $code, string $storeName, string $productName = ''): string
    {
        $code = trim($code);
        $storeName = trim($storeName) !== '' ? trim($storeName) : 'VM POS';
        $productName = trim($productName);

        $generator = new BarcodeGeneratorSVG();
        $type = preg_match('/^\d{13}$/', $code) === 1
            ? BarcodeGenerator::TYPE_EAN_13
            : BarcodeGenerator::TYPE_CODE_128;

        try {
            $bars = $generator->getBarcode($code, $type, 2, 78);
        } catch (BarcodeException $e) {
            throw new \InvalidArgumentException($e->getMessage(), previous: $e);
        } catch (Throwable $e) {
            throw new \InvalidArgumentException('Invalid barcode.', previous: $e);
        }

        $bars = preg_replace('/^<\?xml.*?\?>\s*/s', '', $bars) ?? $bars;
        $bars = preg_replace('/<!DOCTYPE.*?>\s*/s', '', $bars) ?? $bars;

        if (! preg_match('/width="([\d.]+)"/', $bars, $widthMatch) || ! preg_match('/height="([\d.]+)"/', $bars, $heightMatch)) {
            throw new \RuntimeException('Could not build the barcode label.');
        }

        $barWidth = (float) $widthMatch[1];
        $barHeight = (float) $heightMatch[1];
        $productName = $this->clip($productName, 42);
        $storeName = $this->clip($storeName, 36);

        $labelWidth = max($barWidth + 72, 320, (mb_strlen($storeName) * 8.2) + 48);
        $barcodeX = round(($labelWidth - $barWidth) / 2, 2);
        $top = $productName !== '' ? 28 : 16;
        $barcodeY = $top + ($productName !== '' ? 10 : 0);
        $codeY = $barcodeY + $barHeight + 18;
        $storeY = $codeY + 26;
        $labelHeight = $storeY + 18;

        $productLine = $productName === '' ? '' : sprintf(
            '<text x="%s" y="%s" text-anchor="middle" font-family="Segoe UI, Arial, sans-serif" font-size="13" fill="#161513">%s</text>',
            $this->num($labelWidth / 2),
            $this->num($top),
            $this->xml($productName),
        );

        return sprintf(
            '<svg xmlns="http://www.w3.org/2000/svg" width="%s" height="%s" viewBox="0 0 %s %s">'.
            '<rect width="100%%" height="100%%" fill="#ffffff"/>'.
            '%s'.
            '<g transform="translate(%s %s)">%s</g>'.
            '<text x="%s" y="%s" text-anchor="middle" font-family="Consolas, Courier New, monospace" font-size="14" letter-spacing="1.5" fill="#161513">%s</text>'.
            '<text x="%s" y="%s" text-anchor="middle" font-family="Segoe UI, Arial, sans-serif" font-size="15" font-weight="600" letter-spacing="0.6" fill="#161513">%s</text>'.
            '</svg>',
            $this->num($labelWidth),
            $this->num($labelHeight),
            $this->num($labelWidth),
            $this->num($labelHeight),
            $productLine,
            $this->num($barcodeX),
            $this->num($barcodeY),
            $bars,
            $this->num($labelWidth / 2),
            $this->num($codeY),
            $this->xml($this->readableCode($code)),
            $this->num($labelWidth / 2),
            $this->num($storeY),
            $this->xml($storeName),
        );
    }

    private function eanCheckDigit(string $twelve): int
    {
        $sum = 0;
        foreach (str_split($twelve) as $index => $digit) {
            $sum += (int) $digit * ($index % 2 === 0 ? 1 : 3);
        }

        return (10 - ($sum % 10)) % 10;
    }

    private function readableCode(string $code): string
    {
        if (preg_match('/^\d{13}$/', $code) === 1) {
            return $code[0].' '.substr($code, 1, 6).' '.substr($code, 7, 6);
        }

        return $code;
    }

    private function clip(string $value, int $max): string
    {
        if (mb_strlen($value) <= $max) {
            return $value;
        }

        return rtrim(mb_substr($value, 0, $max - 1)).'…';
    }

    private function xml(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }

    private function num(float $value): string
    {
        return rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.');
    }
}
