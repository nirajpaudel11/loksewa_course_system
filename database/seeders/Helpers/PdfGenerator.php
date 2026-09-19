<?php

namespace Database\Seeders\Helpers;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Generates professional study-note PDFs using DomPDF.
 * Automatically ensures DomPDF PSR-4 autoloader and Cpdf helper are registered.
 */
class PdfGenerator
{
    private string $title = '';

    private string $subtitle = '';

    private string $htmlContent = '';

    private static bool $autoloadRegistered = false;

    public function __construct()
    {
        self::ensureAutoload();
    }

    private static function ensureAutoload(): void
    {
        if (self::$autoloadRegistered) {
            return;
        }

        // Require Cpdf if not already loaded
        $cpdfPath = base_path('vendor/dompdf/dompdf/lib/Cpdf.php');
        if (file_exists($cpdfPath) && ! class_exists('Dompdf\Cpdf', false)) {
            require_once $cpdfPath;
        }

        spl_autoload_register(function ($class) {
            $prefixes = [
                'Dompdf\\' => base_path('vendor/dompdf/dompdf/src/'),
                'FontLib\\' => base_path('vendor/dompdf/php-font-lib/src/FontLib/'),
                'Svg\\' => base_path('vendor/dompdf/php-svg-lib/src/Svg/'),
                'Sabberworm\\CSS\\' => base_path('vendor/sabberworm/php-css-parser/src/'),
                'Barryvdh\\DomPDF\\' => base_path('vendor/barryvdh/laravel-dompdf/src/'),
            ];

            foreach ($prefixes as $prefix => $baseDir) {
                $len = strlen($prefix);
                if (strncmp($prefix, $class, $len) !== 0) {
                    continue;
                }

                $relativeClass = substr($class, $len);
                $file = $baseDir.str_replace('\\', '/', $relativeClass).'.php';

                if (file_exists($file)) {
                    require_once $file;

                    return;
                }
            }
        });

        self::$autoloadRegistered = true;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function setHtmlContent(string $html): self
    {
        $this->htmlContent = $html;

        return $this;
    }

    public function save(string $path): void
    {
        $dir = dirname($path);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $html = $this->buildFullHtml();

        $options = new Options;
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        file_put_contents($path, $dompdf->output());
    }

    private function buildFullHtml(): string
    {
        $title = htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
        $subtitle = htmlspecialchars($this->subtitle, ENT_QUOTES, 'UTF-8');

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
    @page {
        margin: 50px 45px 50px 45px;
    }
    body {
        font-family: 'Helvetica', 'Arial', sans-serif;
        font-size: 10pt;
        line-height: 1.5;
        color: #1a1a2e;
    }
    .header {
        text-align: center;
        border-bottom: 2.5px solid #16213e;
        padding-bottom: 12px;
        margin-bottom: 20px;
    }
    .header h1 {
        font-size: 18pt;
        color: #16213e;
        margin: 0 0 4px 0;
    }
    .header .subtitle {
        font-size: 10pt;
        color: #0f3460;
        font-style: italic;
    }
    .header .badge {
        display: inline-block;
        background: #e94560;
        color: #ffffff;
        padding: 3px 12px;
        border-radius: 4px;
        font-size: 8.5pt;
        font-weight: bold;
        margin-top: 6px;
    }
    h2 {
        font-size: 12.5pt;
        color: #16213e;
        border-left: 4px solid #e94560;
        padding-left: 8px;
        margin-top: 16px;
        margin-bottom: 6px;
    }
    h3 {
        font-size: 10.5pt;
        color: #0f3460;
        margin-top: 12px;
        margin-bottom: 5px;
    }
    p {
        margin: 4px 0;
        text-align: justify;
    }
    ul, ol {
        margin: 4px 0 6px 15px;
        padding-left: 10px;
    }
    li {
        margin-bottom: 3px;
    }
    .highlight-box {
        background: #f0f4ff;
        border: 1px solid #c5cae9;
        border-left: 4px solid #0f3460;
        padding: 8px 12px;
        margin: 8px 0;
        border-radius: 4px;
        font-size: 9.5pt;
    }
    .key-point {
        background: #fff3e0;
        border-left: 4px solid #e94560;
        padding: 6px 10px;
        margin: 8px 0;
        font-size: 9.5pt;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 8px 0;
        font-size: 8.5pt;
    }
    table th {
        background: #16213e;
        color: #ffffff;
        padding: 5px 7px;
        text-align: left;
        font-weight: bold;
    }
    table td {
        border: 1px solid #dcdcdc;
        padding: 4px 7px;
    }
    table tr:nth-child(even) td {
        background: #f9f9f9;
    }
    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 7.5pt;
        color: #777;
        border-top: 1px solid #ddd;
        padding-top: 4px;
    }
    strong { color: #16213e; }
</style>
</head>
<body>
<div class="footer">Loksewa Course System &mdash; {$title} &mdash; Official Syllabus Study Notes</div>
<div class="header">
    <h1>{$title}</h1>
    <div class="subtitle">{$subtitle}</div>
    <div class="badge">Nepal Public Service Commission (Lok Sewa Aayog)</div>
</div>
{$this->htmlContent}
</body>
</html>
HTML;
    }
}
