<?php

namespace App\Controllers\AdmMaster;

use App\Controllers\BaseController;
use App\Models\MemberModel;
use App\Models\OrderItemModel;
use App\Models\OrderModel;
use App\Models\CourseProgressModel;

class AdminPassController extends BaseController
{
    protected $memberModel;
    protected $orderModel;
    protected $orderItemModel;
    private $db;
    private $courseModel;
    protected $courseProgressModel;

    public function __construct()
    {
        $this->courseModel = model('CourseModel');
        $this->memberModel = new MemberModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->courseProgressModel = new CourseProgressModel();
        $this->db = db_connect();
    }

    public function list()
    {
        try {
            $keyword = $this->request->getGet('keyword') ?? '';
            $education_subject = $this->request->getGet('education_subject') ?? '';
            $company_name = $this->request->getGet('company_name') ?? '';
            $schedule_start = $this->request->getGet('schedule_start') ?? '';
            $schedule_end = $this->request->getGet('schedule_end') ?? '';
            $name = $this->request->getGet('name') ?? '';
            $page_notice = $this->request->getGet('page_notice') ?? 1;

            $where = [];

            if (!empty($keyword)) {
                $where['main'] = $keyword;
            }

            if (!empty($education_subject)) {
                $where['course_idx'] = $education_subject;
            }

            if (!empty($company_name)) {
                $where['company_name'] = $company_name;
            }

            if (!empty($schedule_start)) {
                $where['schedule_start'] = $schedule_start;
            }

            if (!empty($schedule_end)) {
                $where['schedule_end'] = $schedule_end;
            }

            if (!empty($name)) {
                $where['user_name'] = $name;
            }

            $perPage = 10;

            $data = $this->courseProgressModel->getCompletedCoursesWithPager($where, $perPage, 'notice');

            $list = $data['items'];
            $pager = $data['pager'];
            $total = $data['total'];

            $courses = $this->courseProgressModel->getCompletedCoursesList();

            $companies = $this->courseProgressModel->getCompletedCompanyList();

            $data = [
                'num' => $total,
                'items' => $list,
                'pager' => $pager,
                'perPage' => $perPage,
                'page' => $page_notice,
                'keyword' => $keyword,
                'courses' => $courses,
                'companies' => $companies,
                'filters' => [
                    'education_subject' => $education_subject,
                    'company_name' => $company_name,
                    'schedule_start' => $schedule_start,
                    'schedule_end' => $schedule_end,
                    'name' => $name,
                ]
            ];

            return view('AdmMaster/_pass/list', $data);
        } catch (\Exception $e) {
            log_message('error', 'AdminPassController::list error: ' . $e->getMessage());

            return $this
                ->response
                ->setStatusCode(500)
                ->setJSON([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
        }
    }

    // public function sendEmail()
    // {
    //     try {
    //         $courseProgressIdx = $this->request->getPost('r_idx');
    //         $userEmail = $this->request->getPost('r_email');
    //         $userName = $this->request->getPost('mail_to_name');

    //         if (empty($courseProgressIdx) || empty($userEmail)) {
    //             return $this->response->setJSON([
    //                 'success' => false,
    //                 'message' => '필수 정보가 누락되었습니다.'
    //             ]);
    //         }

    //         $courseProgress = $this->courseProgressModel->find($courseProgressIdx);
    //         if (!$courseProgress) {
    //             return $this->response->setJSON([
    //                 'success' => false,
    //                 'message' => '유효하지 않은 요청입니다.'
    //             ]);
    //         }

    //         $course = $this->courseModel->find($courseProgress['course_idx']);
    //         if (!$course) {
    //             return $this->response->setJSON([
    //                 'success' => false,
    //                 'message' => '교육 과정을 찾을 수 없습니다.'
    //             ]);
    //         }

    //         $pdfUrl = site_url("/print/certificates?user_id={$courseProgress['user_id']}&course_idx={$courseProgress['course_idx']}");
    //         $pdfPath = WRITEPATH . 'uploads/temp/certificate_' . $courseProgressIdx . '.pdf';
            
    //         if (!is_dir(dirname($pdfPath))) {
    //             mkdir(dirname($pdfPath), 0755, true);
    //         }
    
    //         $apiUrl = 'https://api.html2pdf.app/v1/generate';
    //         $postData = http_build_query([
    //             'url' => $pdfUrl,
    //             'name' => 'certificate_' . $courseProgressIdx . '.pdf',
    //             'format' => 'A4',
    //             'margin.top' => '10mm',
    //             'margin.bottom' => '10mm',
    //             'margin.left' => '10mm',
    //             'margin.right' => '10mm'
    //         ]);
    
    //         $ch = curl_init();
    //         curl_setopt($ch, CURLOPT_URL, $apiUrl);
    //         curl_setopt($ch, CURLOPT_POST, true);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    //         $pdfContent = curl_exec($ch);
    //         $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //         curl_close($ch);
    
    //         if ($httpCode == 200 && $pdfContent) {
    //             file_put_contents($pdfPath, $pdfContent);
    //         } else {
    //             return $this->response->setJSON([
    //                 'success' => false,
    //                 'message' => 'PDF 생성 실패: ' . $httpCode
    //             ]);
    //         }

    //         $code = "A14";
    //         $user_mail = $userEmail;
    //         $answer_date = date('Y-m-d H:i:s');
    //         $answer_manager = '(주)유월커뮤니케이션';
            
    //         $_tmp_fir_array = [
    //             'Education_name' => $course['course_name'],           
    //             'user_name' => $course['mentor'],                     
    //             'r_date' => date('Y-m-d', strtotime($course['start_date'])) . ' ~ ' . date('Y-m-d', strtotime($course['end_date'])), 
    //             'r_email' => $user_mail,                            
    //             'r_date_completed' => date('Y-m-d', strtotime($courseProgress['completion_date'])),
    //             'RECEIVE_NAME' => $userName,
    //             'r_file' => $pdfPath,                       
    //         ];
            
    //         if (function_exists('autoEmail')) {
    //             autoEmail($code, $user_mail, $_tmp_fir_array);
    //         } else {
    //             log_message('error', 'autoEmail function not found');
    //             return $this->response->setJSON([
    //                 'success' => false,
    //                 'message' => '이메일 발송 함수를 찾을 수 없습니다.'
    //             ]);
    //         }

    //         if (file_exists($pdfPath)) {
    //             unlink($pdfPath);
    //         }

    //         // $this->courseProgressModel->update($courseProgressIdx, [
    //         //     'certificate' => 'Y',
    //         //     'updated_at' => date('Y-m-d H:i:s')
    //         // ]);

    //         return $this->response->setJSON([
    //             'success' => true,
    //             'message' => '이메일이 성공적으로 발송되었습니다.'
    //         ]);

    //     } catch (\Exception $e) {
    //         log_message('error', 'AdminPassController::sendEmail error: ' . $e->getMessage());
    //         return $this->response->setJSON([
    //             'success' => false,
    //             'message' => '이메일 발송 중 오류가 발생했습니다: ' . $e->getMessage()
    //         ]);
    //     }
    // }

    public function sendEmail()
    {
        try {
            $courseProgressIdx = $this->request->getPost('r_idx');
            $userEmail = $this->request->getPost('r_email');
            $userName = $this->request->getPost('mail_to_name');

            if (empty($courseProgressIdx) || empty($userEmail)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => '필수 정보가 누락되었습니다.'
                ]);
            }

            $courseProgress = $this->courseProgressModel->find($courseProgressIdx);
            if (!$courseProgress) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => '유효하지 않은 요청입니다.'
                ]);
            }

            $course = $this->courseModel->find($courseProgress['course_idx']);
            if (!$course) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => '교육 과정을 찾을 수 없습니다.'
                ]);
            }

            $memberModel = model('MemberModel');
            $member = $memberModel->where('user_name', $userName)->first();
            $manager = null;
            if ($member && !empty($member['manager_id'])) {
                $manager = $memberModel->where('user_id', $member['manager_id'])->first();
            }

            $pdfPath = strtolower(rtrim(WRITEPATH, '/')) . '/uploads/temp/certificate_' . time() . '.pdf';
            if (!is_dir(dirname($pdfPath))) {
                mkdir(dirname($pdfPath), 0755, true);
            }

            $this->createCertificatePDFFromHTML($course, $courseProgress, $member, $manager, $userName, $pdfPath);

            if (!file_exists($pdfPath)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'PDF 생성 실패'
                ]);
            }

            $code = "A14";
            $user_mail = $userEmail;
            
            $_tmp_fir_array = [
                'Education_name'   => $course['course_name'],
                'user_name'        => $course['mentor'],
                'r_date'           => date('Y-m-d', strtotime($course['start_date'])) . ' ~ ' . date('Y-m-d', strtotime($course['end_date'])),
                'r_email'          => $user_mail,
                'r_date_completed' => date('Y-m-d', strtotime($courseProgress['completion_date'])),
                'RECEIVE_NAME'     => $userName,
                'r_file'           => $pdfPath,
            ];
            
            if (function_exists('autoEmail')) {
                $result = autoEmail($code, $user_mail, $_tmp_fir_array);
                log_message('info', 'Email sent result: ' . var_export($result, true));
            } else {
                log_message('error', 'autoEmail function not found');
                return $this->response->setJSON([
                    'success' => false,
                    'message' => '이메일 발송 함수를 찾을 수 없습니다.'
                ]);
            }

            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }

            $this->courseProgressModel->update($courseProgressIdx, [
                'certificate' => 'Y',
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => '이메일이 성공적으로 발송되었습니다.'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'AdminPassController::sendEmail error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => '이메일 발송 중 오류가 발생했습니다: ' . $e->getMessage()
            ]);
        }
    }

    private function createCertificatePDFFromHTML($course, $courseProgress, $member, $manager, $userName, $pdfPath)
    {
        require_once APPPATH . 'ThirdParty/tfpdf/tFPDF.php';

        if (!defined('FPDF_FONTPATH')) {
            define('FPDF_FONTPATH', APPPATH . 'ThirdParty/tfpdf/font/');
        }

        $pdf = new \tFPDF('P', 'mm', 'A4');
        $pdf->SetMargins(17, 16, 17);
        $pdf->AddPage();
        $pdf->AddFont('NanumSquare', '',  'NanumSquareR.ttf', true);
        $pdf->AddFont('NanumSquare', 'B', 'NanumSquareB.ttf', true);

        $logoPath  = FCPATH . 'img/logo_.png';
        $stampPath = FCPATH . 'img/stamp.png';

        $pdf->SetFont('NanumSquare', '', 10);
        $pdf->SetXY(17, 16);
        $pdf->Cell(176, 6, 'No. ' . str_pad($courseProgress['course_progress_idx'], 4, '0', STR_PAD_LEFT), 0, 1, 'R');

        $pdf->SetFont('NanumSquare', 'B', 40);
        $pdf->SetXY(17, 25);
        $pdf->Cell(176, 22, '교육수료증', 0, 1, 'C');
        $pdf->SetY($pdf->GetY() + 10);

        $tableX = 40;
        $tableW = 130;
        $labelW = 36;
        $valueW = $tableW - $labelW;
        $rowH   = 11;

        $rows = [
            ['성 명',    $userName],
            ['생년월일', !empty($member['birthday']) ? date('Y-m-d', strtotime($member['birthday'])) : '-'],
            ['소 속',    !empty($manager) ? $manager['user_name'] : '-'],
            ['교육과정', $course['course_name'] . '(' . $course['number_lecture'] . '/' . $course['duration'] . '일)'],
            ['교육기간', date('Y.m.d', strtotime($course['start_date'])) . ' ~ ' . date('Y.m.d', strtotime($course['end_date']))],
            ['수료일',   date('Y.m.d', strtotime($courseProgress['completion_date']))],
        ];

        foreach ($rows as $row) {
            $y = $pdf->GetY();

            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetFont('NanumSquare', '', 12);
            $pdf->SetXY($tableX, $y);
            $pdf->Cell($labelW, $rowH, '  ' . $row[0], 0, 0, 'L', true);

            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetXY($tableX + $labelW, $y);
            $pdf->Cell($valueW, $rowH, ' ' . $row[1], 0, 1, 'L', true);
        }

        $certiY = $pdf->GetY() + 20;
        $certiH = 30;

        if (file_exists($logoPath)) {
            $imgSize = getimagesize($logoPath);
            if ($imgSize) {
                $imgW = 150; 
                $imgX = (210 - $imgW) / 2;
                $pdf->Image($logoPath, $imgX, $certiY - 2, $imgW);
            }
        }

        $pdf->SetFont('NanumSquare', 'B', 19);
        $pdf->SetXY(17, $certiY + 3);
        $pdf->MultiCell(176, 10,
            '위 사람은 한국급경사지안전협회에서 실시하는' . "\n" .
            '상기 ' . date('Y', strtotime($course['end_date'])) . '년도 ' .
            $course['course_name'] . '을 이수하였음을 증명함.',
            0, 'C'
        );

        $pdf->SetY($pdf->GetY() + 25);

        $pdf->SetFont('NanumSquare', '', 10);
        $pdf->SetXY(17, $pdf->GetY());
        $pdf->Cell(176, 6, date('Y.m.d', strtotime($courseProgress['completion_date'])), 0, 1, 'C');

        $pdf->SetY($pdf->GetY() + 5);

        $orgY = $pdf->GetY();
        $pdf->SetFont('NanumSquare', 'B', 21);

        if (file_exists($stampPath)) {
            $textW = 80; 
            $centerX = 105; 
            $textStartX = $centerX - ($textW / 2);
            $stampX = $textStartX + $textW - 5; 

            $pdf->SetXY(17, $orgY);
            $pdf->Cell(176, 16, '한국급경사지안전협회', 0, 0, 'C');
            $pdf->Image($stampPath, $stampX, $orgY - 8, 28); 
        } else {
            $pdf->SetXY(17, $orgY);
            $pdf->Cell(176, 16, '한국급경사지안전협회', 0, 1, 'C');
        }

        $pdf->Output($pdfPath, 'F');
    }

// private function createCertificatePDFFromHTML($course, $courseProgress, $member, $manager, $userName, $pdfPath)
// {
//     // Render HTML giống hệt trang certificates
//     $completionDate = date('Y.m.d', strtotime($courseProgress['completion_date']));
//     $endYear = date('Y', strtotime($course['end_date']));
//     $noStr = 'No. ' . str_pad($courseProgress['course_progress_idx'], 4, '0', STR_PAD_LEFT);

//     $html = '<!DOCTYPE html>
//     <html lang="ko">
//     <head>
//     <meta charset="UTF-8">
//     <style>
//     * { margin: 0; padding: 0; box-sizing: border-box; }
//     @page { size: 210mm 297mm; }
//     body { font-family: "Malgun Gothic", sans-serif; font-size: 9pt; padding: 60px 50px; }
//     .page { width: 100%; position: relative; }
//     .to { font-size: 10pt; font-weight: 500; text-align: right; }
//     .print_ttl { font-size: 40pt; font-weight: 500; margin: 50px 0 70px; text-align: center; }
//     .page table { width: 100%; table-layout: fixed; border-top: solid 1px #252525; margin-bottom: 40px; }
//     .page table th { background: #fafafa; }
//     .page table tr { border-bottom: solid 1px #dbdbdb; }
//     .tbst1 th { text-align: left; padding-left: 20px; font-weight: 500; }
//     .tbst1 td { padding: 15px 10px; }
//     .user_info { max-width: 450px; margin: 0 auto; }
//     .user_info dl { width: 100%; display: flex; align-items: center; }
//     .user_info dl + dl { margin-top: 22px; }
//     .user_info dl dt { width: 120px; font-size: 13pt; position: relative; }
//     .user_info dl dt::after { content: ":"; font-size: 13pt; position: absolute; top: 50%; transform: translateY(-50%); right: 0; }
//     .user_info dl dd { width: calc(100% - 120px); font-size: 13pt; padding-left: 30px; }
//     .certi { position: relative; font-size: 19pt; line-height: 1.35; text-align: center; margin: 90px auto 110px; padding: 22px 0; overflow: hidden; background: url(http://' . $_SERVER['HTTP_HOST'] . '/img/logo_.png) no-repeat center center/auto 100%; }
//     .certi_sec { text-align: center; }
//     .certi_sec p { font-size: 10pt; text-align: center; }
//     .certi_sec p.serti_name { display: inline-block; font-size: 21pt; font-weight: 700; padding: 35px 20px 35px; background-image: url(http://' . $_SERVER['HTTP_HOST'] . '/img/stamp.png); background-repeat: no-repeat; background-position: right bottom; margin-top: 20px; }
//     </style>
//     </head>
//     <body>
//     <div class="page">
//         <h2 class="to">' . $noStr . '</h2>
//         <h1 class="print_ttl">교육수료증</h1>

//         <div class="user_info">
//             <dl>
//                 <dt>성 명</dt>
//                 <dd>' . htmlspecialchars($userName) . '</dd>
//             </dl>
//             <dl>
//                 <dt>생년월일</dt>
//                 <dd>' . (!empty($member['birthday']) ? date('Y-m-d', strtotime($member['birthday'])) : '-') . '</dd>
//             </dl>
//             <dl>
//                 <dt>소 속</dt>
//                 <dd>' . (!empty($manager) ? htmlspecialchars($manager['user_name']) : '-') . '</dd>
//             </dl>
//             <dl>
//                 <dt>교육과정</dt>
//                 <dd>' . htmlspecialchars($course['course_name']) . '(' . $course['number_lecture'] . '/' . $course['duration'] . '일)</dd>
//             </dl>
//             <dl>
//                 <dt>교육기간</dt>
//                 <dd>' . date('Y.m.d', strtotime($course['start_date'])) . ' ~ ' . date('Y.m.d', strtotime($course['end_date'])) . '</dd>
//             </dl>
//             <dl>
//                 <dt>수료일</dt>
//                 <dd>' . $completionDate . '</dd>
//             </dl>
//         </div>

//         <h3 class="certi">
//             위 사람은 한국급경사지안전협회에서 실시하는<br>
//             상기 ' . $endYear . '년도 ' . htmlspecialchars($course['course_name']) . '을 이수하였음을 증명함.
//         </h3>

//         <div class="certi_sec">
//             <p>' . $completionDate . '</p>
//             <p class="serti_name">한국급경사지안전협회</p>
//         </div>
//     </div>
//     </body>
//     </html>';

//     // Gọi Gotenberg API để convert HTML → PDF
//     $boundary = '----FormBoundary' . md5(uniqid());

//     $body = "--{$boundary}\r\n";
//     $body .= "Content-Disposition: form-data; name=\"files\"; filename=\"index.html\"\r\n";
//     $body .= "Content-Type: text/html\r\n\r\n";
//     $body .= $html . "\r\n";
//     $body .= "--{$boundary}--\r\n";

//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, 'https://demo.gotenberg.dev/forms/chromium/convert/html');
//     curl_setopt($ch, CURLOPT_POST, true);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, [
//         'Content-Type: multipart/form-data; boundary=' . $boundary,
//     ]);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_TIMEOUT, 30);

//     $pdfContent = curl_exec($ch);
//     $httpCode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//     curl_close($ch);

//     if ($httpCode === 200 && $pdfContent) {
//         file_put_contents($pdfPath, $pdfContent);
//     } else {
//         throw new \Exception('Gotenberg PDF 생성 실패: HTTP ' . $httpCode);
//     }
// }
}
