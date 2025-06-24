<?php

namespace App\Exports;

use App\Models\Reservation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReservationsExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{
    protected $reservations;

    public function __construct($reservations)
    {
        $this->reservations = $reservations;
    }

    public function collection()
    {
        return $this->reservations;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Guest Name',
            'Hotel',
            'Room Type',
            'Room Number',
            'Check-in Date',
            'Check-out Date',
            'Total Cost',
            'Status',
            'Booking Date',
            'Payment Method',
        ];
    }

    public function map($reservation): array
    {
        return [
            $reservation->id,
            $reservation->customer ? $reservation->customer->name() : $reservation->travelCompany->company_name,
            $reservation->hotel->name,
            $reservation->roomType->name,
            $reservation->room->room_number ?? '-',
            $reservation->check_in_date->format('d-m-Y'),
            $reservation->check_out_date->format('d-m-Y'),
            $reservation->totalEstimatedCost(),
            $reservation->statusLabel(),
            $reservation->created_at->format('d-m-Y H:i'),
            $reservation->payment_method ?? 'N/A',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set default font
        $sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

        return [
            // Header row style
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 11,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => '2F75B5'], // Nice blue
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],

            // Data rows style
            'A2:K' . ($this->reservations->count() + 1) => [
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'D9D9D9'],
                    ],
                ],
            ],

            // Numeric and date formatting
            'A' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]],
            'F:G' => ['numberFormat' => ['formatCode' => NumberFormat::FORMAT_DATE_DDMMYYYY]],
            'H' => ['numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1]],
            'J' => ['numberFormat' => ['formatCode' => 'dd-mm-yyyy hh:mm']],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Freeze the first row
                $event->sheet->freezePane('A2');

                // Set alternate row coloring
                $totalRows = $this->reservations->count() + 1; // +1 for header
                $range = 'A2:K' . $totalRows;

                $event->sheet->getDelegate()->getStyle($range)
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FFFFFF');

                // Apply alternate row coloring
                for ($i = 2; $i <= $totalRows; $i++) {
                    if ($i % 2 == 0) {
                        $event->sheet->getDelegate()->getStyle('A'.$i.':K'.$i)
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('F2F2F2');
                    }
                }

                // Apply conditional formatting for status column
                $statusColumn = 'I';
                for ($i = 2; $i <= $totalRows; $i++) {
                    $cellValue = $event->sheet->getCell($statusColumn.$i)->getValue();
                    $color = null;

                    if (str_contains($cellValue, 'Confirmed')) {
                        $color = 'C6EFCE'; // Light green
                    } elseif (str_contains($cellValue, 'Cancelled')) {
                        $color = 'FFC7CE'; // Light red
                    } elseif (str_contains($cellValue, 'Pending')) {
                        $color = 'FFEB9C'; // Light yellow
                    } elseif (str_contains($cellValue, 'Checked In')) {
                        $color = '8DB4E2'; // Light blue
                    }

                    if ($color) {
                        $event->sheet->getDelegate()->getStyle($statusColumn.$i)
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB($color);
                    }
                }

                // Add filters to header row
                $event->sheet->setAutoFilter('A1:K1');

                // Set print settings
                $event->sheet->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                    ->setFitToWidth(1)
                    ->setFitToHeight(0);
            },
        ];
    }
}
