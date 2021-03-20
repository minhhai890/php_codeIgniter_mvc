<?php

namespace libs;

use libs\Func;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

@include Config::get('app.dir.vendor');

class Excel
{

    // Phương thức tạo tên cột tương ứng trong bảng excel
    public function getColumnsName($countColumns)
    {
        $range = range('A', 'Z');
        $result = $range;
        $index = ceil($countColumns / \count($range));
        if ($index > 1) {
            for ($i = 0; $i < $index; $i++) {
                foreach ($range as $col) {
                    if (\count($result) <= $countColumns) {
                        $result[] = $range[$i] . $col;
                    }
                }
            }
        } else {
            $result = array_slice($result, 0, $countColumns);
        }
        return $result;
    }

    // Phương thức trả về thuộc tính căn chỉnh cell value
    public function alignmentCenter()
    {
        return [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::HORIZONTAL_CENTER
        ];
    }

    // Phương thức trả về thuộc tính color
    public function fillTitle()
    {
        return [
            'fillType' => Fill::FILL_SOLID,
            'color' => ['rgb' => 'CCCCCC']
        ];
    }

    // Phương thức download file excel xlsx
    public function download($filename, $spreadsheet)
    {
        // redirect output to client browser      
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '-' . date('d-m-Y-H-i-s', time()) . '.xlsx"');
        header('Cache-Control: max-age=0');
        // // Save
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    /* Phương thức tạo một tập tin Excel (filename.xlsx)
     * $columns: là mảng gồm có key và title 
        array(
                [
                    key=>'', 
                    title=''
                ], 
                [...],
                ...
            ])

     * $data: dữ liệu ứng với columns
     * $filename: tên của tập tin
     * $params: giá trị mảng
     * - titleName: tiêu đề của tập tin excel
     * - description: thông tin miêu tả
     * - date: định dạng ngày tháng năng [key1, key2,...]
     * - number: định dạng số [key1, key2,...]
     * - insert: thêm vào trường giá trị [key1=>[k1=>v1,k2=>v2,...],...]
     */
    public function write($filename, $data, $columns, $params)
    {
        if ($filename && is_array($data) && is_array($columns) && is_array($params)) {
            $spreadsheet = new Spreadsheet();
            $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
            $spreadsheet->setActiveSheetIndex(0);
            $sheet = $spreadsheet->getActiveSheet();
            $sheetColumns = $this->getColumnsName(\count($columns));
            $row = 1;
            foreach ($data as $key => $value) {
                if ($key == 0) {
                    $colNameEnd = end($sheetColumns);
                    // Cell value title sheet
                    if (array_key_exists('titleName', $params)) {
                        $sheet->setCellValue('A' . $row, $params['titleName']);
                        $sheet->getStyle('A' . $row)->applyFromArray([
                            'font' => [
                                'size' => 16,
                                'bold' => true
                            ],
                            'alignment' => $this->alignmentCenter()
                        ]);
                        $sheet->mergeCells('A' . $row . ':' . $colNameEnd . $row);
                        $sheet->getRowDimension($row)->setRowHeight(30);
                        $row++;
                    }
                    // Cell value description
                    if (array_key_exists('description', $params)) {
                        $sheet->setCellValue('A' . $row, $params['description']);
                        $sheet->getStyle('A' . $row)->applyFromArray(['alignment' => $this->alignmentCenter()]);
                        $sheet->mergeCells('A' . $row . ':' . $colNameEnd . $row);
                        $row++;
                    }
                    if ($row > 1) $row++;
                    // Cell value title content
                    foreach ($columns as $cell => $colValue) {
                        if (isset($colValue['key']) && isset($colValue['title']) && isset($value[$colValue['key']])) {
                            $sheet->setCellValue($sheetColumns[$cell] . $row, $colValue['title']);
                        }
                    }
                    // Fill
                    $sheet->getStyle($sheetColumns[0] . $row . ':' . $colNameEnd . $row)->applyFromArray([
                        'font' => ['bold' => true],
                        'fill' => $this->fillTitle(),
                        'alignment' => $this->alignmentCenter()
                    ]);
                    $row++;
                }
                // Content
                foreach ($columns as $cell => $colValue) {
                    if (isset($colValue['key']) && isset($value[$colValue['key']])) {
                        // Cell
                        $cell = $sheetColumns[$cell] . $row;
                        // Default value
                        $cellValue = $value[$colValue['key']];
                        $sheet->getStyle($cell)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                        // Format date                  
                        if (isset($params['date']) && is_array($params['date'])) {
                            if (in_array($colValue['key'], $params['date'])) {
                                $cellValue = \date('d/m/Y',  $cellValue);
                                $sheet->getStyle($cell)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                            }
                        }
                        // Format number
                        if (isset($params['number']) && is_array($params['number'])) {
                            if (in_array($colValue['key'], $params['number'])) {
                                $cellValue = floatval($cellValue);
                                $sheet->getStyle($cell)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
                            }
                        }
                        // Insert change value
                        if (isset($params['insert']) && is_array($params['insert'])) {
                            foreach ($params['insert'] as $k => $v) {
                                if ($colValue['key'] == $k) {
                                    if (is_array($v)) {
                                        $cellValue = '';
                                        if (isset($v[$cellValue])) {
                                            $cellValue = $v[$cellValue];
                                        }
                                    } else {
                                        $cellValue = $v;
                                    }
                                    break;
                                }
                            }
                        }
                        // setCellValue
                        $sheet->setCellValue($cell, $cellValue);
                    }
                }
                $row++;
            }
            // setAutoSize;
            foreach ($sheetColumns as $column) {
                $sheet->getColumnDimension($column)->setAutoSize(true);
            }
            // redirect output to client browser      
            $this->download($filename, $spreadsheet);
        }
    }

    /* Phương thức đọc một tập tin Excel (filename.xlsx)
     * $filename: đường dẫn tập tin 
     * $columns: là mảng gồm có key và title 
     * array(
                [
                    key=>'', 
                    title=''
                ], 
                []...
            ])
     * $sheetname: tên sheet trong tập tin   
     */
    public function read($filename, $sheetname, $columns)
    {
        $result = [];
        $colKey = [];
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setLoadSheetsOnly($sheetname);
        $exel = $reader->load($filename);
        $data = $exel->getActiveSheet()->toArray(null, true, true, true);
        if ($data) {
            foreach ($data as $key => $value) {
                if ($key == 1) {
                    $colKey = $this->checkColumnTitle($columns, $value);
                    if (\count($colKey) != \count($columns)) {
                        break;
                    }
                    continue;
                }
                if (implode('', $value)) {
                    $valueNew = [];
                    foreach ($colKey as $cellCol => $cellKey) {
                        $valueNew[$cellKey] = $value[$cellCol];
                    }
                    $result[] = $valueNew;
                    continue;
                }
                break;
            }
        }
        return $result;
    }

    // Phương thức kiểm tra tên cột trước khi trả về dữ liệu
    public function checkColumnTitle($columns, $data)
    {
        $result = [];
        foreach ($columns as $col) {
            foreach ($data as $cellCol => $cellValue) {
                if (Func::convertUnicode($cellValue) ==  Func::convertUnicode($col['title'])) {
                    $result[$cellCol] = $col['key'];
                    break;
                }
            }
        }
        return $result;
    }
}
