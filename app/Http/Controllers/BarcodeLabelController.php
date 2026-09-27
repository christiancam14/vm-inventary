<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\BarcodeLabelService;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class BarcodeLabelController extends Controller
{
    public function download(Request $request, BarcodeLabelService $labels): Response
    {
        $code = trim((string) $request->query('code', ''));
        $productName = trim((string) $request->query('name', ''));

        if ($code === '' || strlen($code) > 64 || preg_match('/^[\x20-\x7E]+$/', $code) !== 1) {
            abort(422, __('Enter or generate a barcode first.'));
        }

        try {
            $svg = $labels->labelSvg(
                $code,
                (string) Setting::get('store_name', 'VM POS'),
                $productName,
            );
        } catch (InvalidArgumentException) {
            abort(422, __('This barcode cannot be printed.'));
        }

        $filename = 'etiqueta-'.preg_replace('/[^A-Za-z0-9._-]+/', '-', $code).'.svg';

        return response($svg, 200, [
            'Content-Type' => 'image/svg+xml; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}
