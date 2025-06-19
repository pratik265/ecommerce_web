<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf {
    
    public function __construct() {
        // Initialize PDF library
    }
    
    public function createPDF($html, $filename = 'document', $download = true) {
        // Create a proper PDF using TCPDF or similar
        // For now, we'll use a more robust approach with proper headers
        
        // Clean HTML content
        $html_content = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>' . $filename . '</title>
            <style>
                body { 
                    font-family: Arial, sans-serif; 
                    margin: 20px; 
                    font-size: 12px;
                    line-height: 1.4;
                }
                table { 
                    width: 100%; 
                    border-collapse: collapse; 
                    margin-bottom: 20px; 
                    font-size: 11px;
                }
                th, td { 
                    border: 1px solid #ddd; 
                    padding: 6px; 
                    text-align: left; 
                    vertical-align: top;
                }
                th { 
                    background-color: #f2f2f2; 
                    font-weight: bold; 
                    font-size: 11px;
                }
                .header { 
                    text-align: center; 
                    margin-bottom: 30px; 
                    border-bottom: 2px solid #333;
                    padding-bottom: 10px;
                }
                .header h1 {
                    margin: 0;
                    color: #333;
                    font-size: 18px;
                }
                .header p {
                    margin: 5px 0;
                    color: #666;
                    font-size: 11px;
                }
                .total { 
                    font-weight: bold; 
                    background-color: #f9f9f9;
                    padding: 10px;
                    border: 1px solid #ddd;
                }
                .section {
                    margin-bottom: 25px;
                }
                .section h2 {
                    color: #333;
                    font-size: 14px;
                    border-bottom: 1px solid #ddd;
                    padding-bottom: 5px;
                }
                .stats {
                    background-color: #f9f9f9;
                    padding: 10px;
                    border: 1px solid #ddd;
                    margin-bottom: 15px;
                }
                .stats p {
                    margin: 3px 0;
                }
                @media print {
                    body { margin: 0; }
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class="no-print" style="margin-bottom: 20px; text-align: center;">
                <button onclick="window.print()" style="padding: 8px 16px; margin: 5px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Print PDF</button>
                <button onclick="window.close()" style="padding: 8px 16px; margin: 5px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Close</button>
            </div>
            ' . $html . '
        </body>
        </html>';
        
        if ($download) {
            // Set proper headers for printable HTML download
            header('Content-Type: text/html');
            header('Content-Disposition: attachment; filename="' . $filename . '.html"');
            header('Cache-Control: max-age=0');
            header('Content-Length: ' . strlen($html_content));
            
            // For now, we'll create a printable HTML file that can be saved as PDF
            // In production, you should install TCPDF or use a service like wkhtmltopdf
            echo $html_content;
        } else {
            // Display in browser
            echo $html_content;
        }
    }
    
    // Alternative method using TCPDF (if available)
    public function createPDFWithTCPDF($html, $filename = 'document', $download = true) {
        // Check if TCPDF is available
        if (class_exists('TCPDF')) {
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            
            // Set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('E-commerce System');
            $pdf->SetTitle($filename);
            
            // Set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
            
            // Set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            
            // Set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            
            // Set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            
            // Set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            
            // Set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            
            // Add a page
            $pdf->AddPage();
            
            // Set font
            $pdf->SetFont('helvetica', '', 10);
            
            // Print text using writeHTMLCell()
            $pdf->writeHTML($html, true, false, true, false, '');
            
            if ($download) {
                // Close and output PDF document
                $pdf->Output($filename . '.pdf', 'D');
            } else {
                // Output PDF to browser
                $pdf->Output($filename . '.pdf', 'I');
            }
        } else {
            // Fallback to HTML method
            $this->createPDF($html, $filename, $download);
        }
    }
} 