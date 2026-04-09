<?php

namespace App\Controllers\AdmMaster;

use App\Controllers\BaseController;
use App\Models\MemberModel;

class AdminLearningController extends BaseController
{
    protected $memberModel;
    private $db;

    public function __construct()
    {
        $this->memberModel = new MemberModel();
        $this->db = db_connect();
    }

    public function list()
        {
            $request = $this->request;
            $perPage  = 10;

            $filters = [
                'search_type'     => $request->getGet('search_type')     ?? 'period',
                'year'            => $request->getGet('year')            ?? '',
                'month'           => $request->getGet('month')           ?? '',
                'period_type'     => $request->getGet('period_type')     ?? '',
                'period_range'    => $request->getGet('period_range')    ?? '',
                's_category1'     => $request->getGet('s_category1')     ?? '',
                'student_name'    => $request->getGet('student_name')    ?? '',
                'student_type'    => $request->getGet('student_type')    ?? '',
                'manager'         => $request->getGet('manager')         ?? '',
                'progress_from'   => $request->getGet('progress_from')   ?? '',
                'progress_to'     => $request->getGet('progress_to')     ?? '',
                'course_name'     => $request->getGet('course_name')     ?? '',
                'reg_date'        => $request->getGet('reg_date')        ?? '',
                'registrar'       => $request->getGet('registrar')       ?? '',
                'progress_status' => $request->getGet('progress_status') ?? '',
                'completion'      => $request->getGet('completion')      ?? '',
                'refund'          => $request->getGet('refund')          ?? '',
                'sales_org'       => $request->getGet('sales_org')       ?? '',
                'company_search'  => $request->getGet('company_search')  ?? '',
            ];

            $emptyView = fn() => view('AdmMaster/_learning/list', [
                'items'   => [],
                'num'     => 0,
                'page'    => 1,
                'perPage' => $perPage,
                'pager'   => null,
                'filters' => $filters,
                'courses' => $this->memberModel->getCourseOptions(),
            ]);

            $members = $this->memberModel->getMembers($filters);
            if (empty($members)) return $emptyView();

            $expanded     = [];
            $allCourseIds = [];

            foreach ($members as $member) {
                $courseIds = array_filter(array_map('trim', explode(',', $member['course_idx'])));
                foreach ($courseIds as $cid) {
                    $cid = (int)$cid;
                    if ($cid <= 0) continue;
                    $allCourseIds[] = $cid;
                    $expanded[]     = ['member' => $member, 'course_id' => $cid];
                }
            }

            if (empty($expanded)) return $emptyView();

            $courseMap = $this->memberModel->getCoursesByIds(
                array_unique($allCourseIds),
                $filters
            );
            

            $pairs = array_map(fn($row) => [
                'user_id'   => $row['member']['user_id'],
                'course_id' => $row['course_id'],
            ], $expanded);

            $progressMap = $this->memberModel->getProgressMap($pairs);

            $rows = [];

            foreach ($expanded as $row) {
                $member   = $row['member'];
                $courseId = $row['course_id'];

                if (!isset($courseMap[$courseId])) continue;

                $course = $courseMap[$courseId];
                $cpKey  = $member['user_id'] . '_' . $courseId;
                $cp     = $progressMap[$cpKey] ?? null;

                $status = MemberModel::resolveStatus($course, $cp);

                $cpStatus    = $cp['status'] ?? null;
                $pct         = (float)($cp['progress_percent'] ?? 0);
                $isExpired   = $status['is_expired'];
                $certificate = $status['certificate'];


                if (!empty($filters['progress_status'])) {
                    $want = $filters['progress_status'];
                    if ($want === '수료완료' && !($cpStatus === 'completed' && $certificate === 'Y'))  continue;
                    if ($want === '수강완료' && !($cpStatus === 'completed' && $certificate !== 'Y'))  continue;
                    if ($want === '수강중'   && $cpStatus !== 'in_progress')                           continue;
                    if ($want === '미수료'   && !($isExpired && $cpStatus !== 'completed'))            continue;
                    if ($want === '수강대기' && !($cpStatus === null && !$isExpired))                  continue;
                }

                if (!empty($filters['completion'])) {
                    if ($filters['completion'] === '수료'   && $cpStatus !== 'completed') continue;
                    if ($filters['completion'] === '미수료' && $cpStatus === 'completed') continue;
                }

                if ($filters['progress_from'] !== '' && $pct < (float)$filters['progress_from']) continue;
                if ($filters['progress_to']   !== '' && $pct > (float)$filters['progress_to'])   continue;

                if (!empty($filters['year']) || !empty($filters['month']) || !empty($filters['period_range'])) {
                    $dateVal = match($filters['period_type']) {
                        'start' => $course['start_date'],
                        'end'   => $course['end_date'],
                        default => $member['r_date'],
                    };

                    if (!empty($filters['year'])  && date('Y', strtotime($dateVal)) != $filters['year'])             continue;
                    if (!empty($filters['month']) && (int)date('m', strtotime($dateVal)) != (int)$filters['month']) continue;

                    if (!empty($filters['period_range'])) {
                        $today = date('Y-m-d');
                        $from  = match($filters['period_range']) {
                            'today' => $today,
                            'week'  => date('Y-m-d', strtotime('-7 days')),
                            'month' => date('Y-m-d', strtotime('-1 month')),
                            default => null,
                        };
                        if ($from) {
                            $d = date('Y-m-d', strtotime($dateVal));
                            if ($d < $from || $d > $today) continue;
                        }
                    }
                }

                $periodStr = '';
                if (!empty($course['start_date']) && !empty($course['end_date'])) {
                    $periodStr = date('Y-m-d', strtotime($course['start_date']))
                            . ' ~ '
                            . date('Y-m-d', strtotime($course['end_date']));
                }

                $rows[] = [
                    // member
                    'm_idx'               => $member['m_idx'],
                    'user_id'             => $member['user_id'],
                    'user_name'           => $member['user_name'],
                    'user_mobile'         => $member['user_mobile'],
                    'member_type'         => $member['member_type'],
                    'r_date'              => $member['r_date'],
                    'manager_name'        => $member['manager_name'],
                    'manager_user_id'     => $member['manager_user_id'],
                    'company_name'        => $member['company_name'],
                    'company_phone'       => $member['company_phone'],
                    'dept'                => $member['dept'],
                    'course_idx'          => $member['course_idx'],
                    // course
                    'course_id'           => $courseId,
                    'course_name'         => $course['course_name'],
                    'mentor'              => $course['mentor'],
                    'start_date'          => $course['start_date'],
                    'end_date'            => $course['end_date'],
                    'period_str'          => $periodStr,
                    'code_name_1'         => $course['code_name_1'] ?? '',
                    'code_name_2'         => $course['code_name_2'] ?? '',
                    'course_url'          => $course['course_url'],
                    // progress
                    'course_progress_idx' => $cp['course_progress_idx'] ?? null,
                    'progress_percent'    => $pct,
                    'cp_status'           => $cpStatus,
                    'completion_date'     => $cp['completion_date'] ?? null,

                    'display_status'      => $status['display_status'],
                    'display_status_class'=> $status['display_status_class'],
                    'completion_label'    => $status['completion_label'],
                    'completion_class'    => $status['completion_class'],
                ];
            }

            usort($rows, function ($a, $b) {
                $startA = strtotime($a['start_date'] ?? '1970-01-01');
                $startB = strtotime($b['start_date'] ?? '1970-01-01');
                if ($startA !== $startB) return $startB - $startA;

                $endA = strtotime($a['end_date'] ?? '1970-01-01');
                $endB = strtotime($b['end_date'] ?? '1970-01-01');
                return $endB - $endA;
            });

            $total  = count($rows);
            $pager  = service('pager');
            $page   = max(1, $pager->getCurrentPage('learning'));
            $offset = ($page - 1) * $perPage;
            $items  = array_slice($rows, $offset, $perPage);
            $pager->store('learning', $page, $perPage, $total);

            $filterKeys = array_keys(array_filter($filters, fn($v) => $v !== ''));
            if (!empty($filterKeys)) {
                $pager->only($filterKeys);
            }

            $categories = $this->db->table('tbl_code')
            ->where('parent_code_no', 2)
            // ->where('status', 'Y')
            ->orderBy('onum', 'DESC')
            ->get()
            ->getResultArray();

            return view('AdmMaster/_learning/list', [
                'items'   => $items,
                'num'     => $total,
                'page'    => $page,
                'perPage' => $perPage,
                'pager'   => $pager,
                'filters' => $filters,
                'categories' => $categories,
                'courses' => $this->memberModel->getCourseOptions(),
            ]);
        }
}