<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel {
    
    public function __construct() {
        // Initialize Excel library
    }
    
    public function createExcel($data, $filename = 'export', $download = true) {
        // Create proper Excel file using PHPSpreadsheet or similar
        // For now, we'll create a CSV file that Excel can open
        
        if ($download) {
            // Set headers for Excel download
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
            header('Cache-Control: max-age=0');
            header('Pragma: public');
            
            // Create output stream
            $output = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Write data
            foreach ($data as $row) {
                fputcsv($output, $row);
            }
            
            fclose($output);
        } else {
            // Return CSV content as string
            $output = fopen('php://temp', 'w');
            
            // Add BOM for UTF-8
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Write data
            foreach ($data as $row) {
                fputcsv($output, $row);
            }
            
            rewind($output);
            $csv = stream_get_contents($output);
            fclose($output);
            
            return $csv;
        }
    }
    
    public function createExcelFromArray($array_data, $filename = 'export', $download = true) {
        // Convert array data to CSV format
        $csv_data = array();
        
        // Add headers if first row contains headers
        if (!empty($array_data)) {
            $headers = array_keys((array)$array_data[0]);
            $csv_data[] = $headers;
            
            // Add data rows
            foreach ($array_data as $row) {
                $csv_row = array();
                foreach ($headers as $header) {
                    $csv_row[] = isset($row->$header) ? $row->$header : (isset($row[$header]) ? $row[$header] : '');
                }
                $csv_data[] = $csv_row;
            }
        }
        
        return $this->createExcel($csv_data, $filename, $download);
    }
    
    // Alternative method using PHPSpreadsheet (if available)
    public function createExcelWithPHPSpreadsheet($data, $filename = 'export', $download = true) {
        // Check if PHPSpreadsheet is available
        if (class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Add data to sheet
            $row = 1;
            foreach ($data as $rowData) {
                $col = 1;
                foreach ($rowData as $cellData) {
                    $sheet->setCellValueByColumnAndRow($col, $row, $cellData);
                    $col++;
                }
                $row++;
            }
            
            // Create Excel writer
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            
            if ($download) {
                // Set headers
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"');
                header('Cache-Control: max-age=0');
                header('Pragma: public');
                
                // Output to browser
                $writer->save('php://output');
            } else {
                // Save to file
                $writer->save($filename . '.xlsx');
            }
        } else {
            // Fallback to CSV method
            $this->createExcel($data, $filename, $download);
        }
    }
    
    // Method to create Excel from database results
    public function createExcelFromDB($db_results, $filename = 'export', $download = true) {
        $csv_data = array();
        
        if (!empty($db_results)) {
            // Get headers from first row
            $first_row = (array)$db_results[0];
            $headers = array_keys($first_row);
            $csv_data[] = $headers;
            
            // Add data rows
            foreach ($db_results as $row) {
                $csv_row = array();
                $row_array = (array)$row;
                foreach ($headers as $header) {
                    $csv_row[] = isset($row_array[$header]) ? $row_array[$header] : '';
                }
                $csv_data[] = $csv_row;
            }
        }
        
        return $this->createExcel($csv_data, $filename, $download);
    }
} 