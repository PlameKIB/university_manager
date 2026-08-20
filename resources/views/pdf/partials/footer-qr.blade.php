<div class="footer">
    <div class="footer-rule"></div>
    <table>
        <tr>
            <td class="qr-cell">
                <img src="{{ $qrDataUri }}" alt="QR">
            </td>
            <td class="text-cell">
                Document généré électroniquement le {{ $generatedAt->translatedFormat('d F Y à H:i') }}.
                Son authenticité peut être vérifiée en scannant le QR code ci-contre ou en consultant
                la page de vérification avec le code : <span class="code">{{ $verificationCode }}</span>
                <br>
                {{ config('app.name') }} &middot; Système de Gestion Académique &middot; Empreinte {{ substr($documentHash, 0, 16) }}...
            </td>
        </tr>
    </table>
</div>