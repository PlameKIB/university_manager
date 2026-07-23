<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\GeneratedDocument;

class Verify extends Controller
{
    public function __invoke(string $code)
    {
        $document = GeneratedDocument::with('generatedBy')
            ->where('code', $code)
            ->first();

        return view('documents.verify', [
            'document' => $document,
        ]);
    }
}
