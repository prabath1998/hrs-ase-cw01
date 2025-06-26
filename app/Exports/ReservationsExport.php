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
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

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
            __('ID'),
            __('Guest Name'),
            __('Hotel'),
            __('Room Type'),
            __('Room Number'),
            __('Check-in Date'),
            __('Check-out Date'),
            __('Nights'),
            __('Total Cost'),
            __('Status'),
            __('Booking Date'),
            __('Payment Method'),
            __('Booked By'),
            __('Special Requests'),
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
            $reservation->check_in_date->format('Y-m-d'),
            $reservation->check_out_date->format('Y-m-d'),
            $reservation->check_in_date->diffInDays($reservation->check_out_date),
            $reservation->totalEstimatedCost(),
            $reservation->statusLabel(),
            $reservation->created_at->format('Y-m-d H:i'),
            $reservation->payment_method ?? 'N/A',
            $reservation->bookedBy->name ?? 'System',
            $reservation->special_requests ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set default font
        $sheet->getParent()->getDefaultStyle()
            ->getFont()
            ->setName('Calibri')
            ->setSize(10);

        // Set column widths for specific columns
        $sheet->getColumnDimension('A')->setWidth(8);  // ID
        $sheet->getColumnDimension('B')->setWidth(25); // Guest Name
        $sheet->getColumnDimension('C')->setWidth(20); // Hotel
        $sheet->getColumnDimension('D')->setWidth(20); // Room Type
        $sheet->getColumnDimension('N')->setWidth(30); // Special Requests

        return [
            // Header row style
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => Color::COLOR_WHITE],
                    'size' => 11,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => '4472C4'], // Darker blue
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                ],
            ],

            // Data rows style
            'A2:N' . ($this->reservations->count() + 1) => [
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

            // Specific column formatting
            'A' => [ // ID column
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'numberFormat' => ['formatCode' => '0'],
            ],
            'F:G' => [ // Date columns
                'numberFormat' => ['formatCode' => NumberFormat::FORMAT_DATE_YYYYMMDD],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            'H' => [ // Nights column
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'numberFormat' => ['formatCode' => '0'],
            ],
            'I' => [ // Total Cost column
                'numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
            ],
            'K' => [ // Booking Date column
                'numberFormat' => ['formatCode' => 'yyyy-mm-dd hh:mm'],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            'N' => [ // Special Requests column
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $totalRows = $this->reservations->count() + 1; // +1 for header

                // Freeze the header row
                $sheet->freezePane('A2');

                // Set auto-filter
                $sheet->setAutoFilter('A1:N1');

                // Apply alternate row coloring
                for ($i = 2; $i <= $totalRows; $i++) {
                    $fillColor = $i % 2 == 0 ? 'FFFFFF' : 'F2F2F2';
                    $sheet->getStyle('A'.$i.':N'.$i)
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB($fillColor);
                }

                // Apply conditional formatting for status column
                $statusColumn = 'J';
                $statusColors = [
                    'Confirmed' => 'C6EFCE', // Light green
                    'Cancelled' => 'FFC7CE', // Light red
                    'Pending' => 'FFEB9C',   // Light yellow
                    'Checked In' => '8DB4E2', // Light blue
                    'Checked Out' => 'A9D08E', // Green
                    'No Show' => 'FF9C9C',    // Red
                ];

                for ($i = 2; $i <= $totalRows; $i++) {
                    $cellValue = $sheet->getCell($statusColumn.$i)->getValue();
                    foreach ($statusColors as $status => $color) {
                        if (str_contains($cellValue, $status)) {
                            $sheet->getStyle($statusColumn.$i)
                                ->getFill()
                                ->setFillType(Fill::FILL_SOLID)
                                ->getStartColor()
                                ->setARGB($color);
                            break;
                        }
                    }
                }

                // Format total row if needed
                if ($totalRows > 1) {
                    $lastRow = $totalRows + 1;
                    $sheet->setCellValue('H'.$lastRow, 'Total:');
                    $sheet->setCellValue('I'.$lastRow, '=SUM(I2:I'.$totalRows.')');
                    $sheet->getStyle('H'.$lastRow.':I'.$lastRow)
                        ->applyFromArray([
                            'font' => ['bold' => true],
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'color' => ['rgb' => 'D9E1F2'],
                            ],
                            'borders' => [
                                'top' => ['borderStyle' => Border::BORDER_MEDIUM],
                            ],
                        ]);
                }

                // Set print settings
                $sheet->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                    ->setFitToWidth(1)
                    ->setFitToHeight(0)
                    ->setHorizontalCentered(true);

                // Set header/footer
                $sheet->getHeaderFooter()
                    ->setOddHeader('&C&H&"Calibri,Bold"&14' . __('Reservations Report'))
                    ->setOddFooter('&L&D &RPage &P of &N');
            },
        ];
    }
}
