<?php

namespace App\Filament\Resources\QuoteResource\Pages;

use App\Filament\Resources\QuoteResource;
use App\Mail\InvoiceMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;
use App\Rules\MultipleEmails;

class EditQuote extends EditRecord
{
    protected static string $resource = QuoteResource::class;

    /**
     * Gera o nome do arquivo PDF com o formato desejado,
     * removendo espaços do nome do cliente.
     */
    protected function generatePdfFileName()
    {
        $quote = $this->record;
        $clientNamePart = substr(str_replace(' ', '_', $quote->client->name), 0, 10);
        return 'Orçamento_'
            . 'N' . $quote->quote_number
            . '_' . $clientNamePart
            . '_' . $quote->created_at->format('d-m-Y')
            . '.pdf';
    }

    /**
     * Gera o assunto do e-mail.
     */
    protected function generateEmailSubject()
    {
        $quote = $this->record;
        return 'Orçamento ' . $quote->quote_number . ' ' . $quote->client->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            // Ação para Exportar PDF
            Actions\Action::make('Exportar PDF')
                ->label('Exportar PDF')
                ->color('info')
                ->action(function () {
                    $quote = $this->record;
                    $pdf = Pdf::loadView('filament.pages.pdf', ['quote' => $quote]);
                    $fileName = $this->generatePdfFileName();
                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        $fileName
                    );
                }),

            // Ação para Enviar por E-mail com modal
            Actions\Action::make('Enviar por E-mail')
                ->label('Enviar por E-mail')
                ->color('success')
                ->form([
                    Forms\Components\Card::make()
                        ->schema([
                            Forms\Components\Section::make('Dados do E-mail')
                                ->schema([
                                    // Grid de 3 colunas: Assunto ocupa 2 colunas e o nome do anexo, de forma discreta, na terceira
                                    Forms\Components\Grid::make(3)
                                        ->schema([
                                            Forms\Components\TextInput::make('email_subject')
                                                ->label('Assunto')
                                                ->default(fn() => $this->generateEmailSubject())
                                                ->required()
                                                ->columnSpan(2),
                                            Forms\Components\Placeholder::make('anexo')
                                                ->label('')
                                                ->content(fn() => 'anexo: ' . $this->generatePdfFileName())
                                                ->extraAttributes([
                                                    'class' => 'text-right text-xs text-gray-500'
                                                ])
                                                ->columnSpan(1),
                                            Forms\Components\TextInput::make('recipient_emails')
                                                ->label('E-mails do Destinatário')
                                                ->helperText('Separe múltiplos e-mails com vírgula. Ex: joao@ex.com, maria@ex.com')
                                                ->default(fn() => $this->record->client->email)
                                                ->required()
                                                ->rules([
                                                    new MultipleEmails,
                                                ])
                                                ->columnSpan(3),
                                        ]),
                                    // Corpo do e-mail ocupando toda a largura
                                    Forms\Components\Textarea::make('email_body')
                                        ->label('Corpo do E-mail')
                                        ->default(fn() => 'Prezado(a) ' . $this->record->client->name . ', segue em anexo o orçamento solicitado. Atenciosamente, Sua Empresa.')
                                        ->rows(6)
                                        ->required()
                                        ->columnSpan('full'),
                                ]),
                        ]),
                ])
                ->action(function (array $data) {
                    $quote = $this->record;

                    // Gera o PDF
                    $pdf = Pdf::loadView('filament.pages.pdf', ['quote' => $quote]);

                    // Converte a string em array de e-mails
                    $emails = array_map('trim', explode(',', $data['recipient_emails']));

                    // Envia o e-mail para todos os destinatários
                    Mail::to($emails)->send(new InvoiceMail(
                        $quote,
                        $quote->client->name,
                        $pdf,
                        $data['email_subject'],
                        nl2br($data['email_body'])
                    ));

                    // Notifica o usuário
                    Notification::make()
                        ->title('Orçamento enviado por e-mail com sucesso!')
                        ->success()
                        ->send();
                }),

            // Ações padrão do Filament
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
