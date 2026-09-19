<?php

namespace App\Filament\Pages;

use App\Services\SystemDocumentationPdfService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class SystemDocumentation extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static string|UnitEnum|null $navigationGroup = 'Reports';

    protected static ?string $navigationLabel = 'System Manuals & Docs';

    protected static ?string $title = 'System Documentation & Algorithm Manuals';

    protected static ?string $slug = 'system-documentation';

    protected static ?int $navigationSort = 90;

    protected string $view = 'filament.pages.system-documentation';

    public string $activeTab = 'admin';

    public string $adminHtml = '';

    public string $studentHtml = '';

    public function mount(SystemDocumentationPdfService $pdfService): void
    {
        $this->adminHtml = $pdfService->getAdminManualHtml();
        $this->studentHtml = $pdfService->getStudentManualHtml();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadAdminPdf')
                ->label('Download Admin Manual (PDF)')
                ->icon(Heroicon::OutlinedArrowDownTray)
                ->color('success')
                ->url(asset('storage/docs/Loksewa_Admin_and_Algorithms_Manual.pdf'), shouldOpenInNewTab: true),

            Action::make('downloadStudentPdf')
                ->label('Download Student Manual (PDF)')
                ->icon(Heroicon::OutlinedArrowDownTray)
                ->color('info')
                ->url(asset('storage/docs/Loksewa_Student_User_Manual.pdf'), shouldOpenInNewTab: true),

            Action::make('regeneratePdfs')
                ->label('Re-compile PDFs')
                ->icon(Heroicon::OutlinedArrowPath)
                ->color('gray')
                ->action(function (SystemDocumentationPdfService $pdfService) {
                    $pdfService->generateAll();
                    Notification::make()
                        ->title('Documentation PDFs Re-compiled')
                        ->body('Both Admin and Student manuals have been regenerated with the latest specifications.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
