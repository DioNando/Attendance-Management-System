<?php

namespace App\Livewire\Pages\Guests;

use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class Export extends Component
{
    public $event;

    public function downloadCsv()
    {
        // Get the file name
        $fileName = 'invites_' . ($this->event->slug ?? slugify($this->event->name)) . '_' . date('Y-m-d') . '.csv';

        // Get guests from the event
        $guests = $this->event->guests()->get();

        // Define columns to export
        $columns = ['first_name', 'last_name', 'email', 'phone', 'invitation_sent'];

        // Generate CSV content
        $csvContent = $this->generateCsvContent($guests, $columns);

        // Return the file for download
        return response()->streamDownload(function () use ($csvContent) {
            echo $csvContent;
        }, $fileName, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment',
        ]);
    }

    public function downloadPdf()
    {
        // Get guests from the event
        $guests = $this->event->guests()->get();

        // Get the file name
        $fileName = 'invites_' . ($this->event->slug ?? slugify($this->event->name)) . '_' . date('Y-m-d') . '.pdf';

        // Generate PDF using the template
        $pdf = PDF::loadView('livewire.pages.guests.pdf-template', [
            'event' => $this->event,
            'guests' => $guests
        ]);

        // Configuration optionnelle
        $pdf->setPaper('a4', 'portrait');

        // Télécharger le PDF
        return response()->streamDownload(
            fn () => print($pdf->output()),
            $fileName,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment',
            ]
        );
    }

    private function generateCsvContent($guests, $columns)
    {
        $output = fopen('php://temp', 'r+');

        // Add header row
        fputcsv($output, $columns);

        // Add data rows
        foreach ($guests as $guest) {
            $row = [];
            foreach ($columns as $column) {
                if ($column == 'invitation_sent') {
                    $row[] = $guest->$column ? 'Oui' : 'Non';
                } else {
                    $row[] = $guest->$column;
                }
            }
            fputcsv($output, $row);
        }

        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);

        return $csvContent;
    }

    public function render()
    {
        return view('livewire.pages.guests.export');
    }
}
