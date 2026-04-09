<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table = 'tbl_member';

    protected $primaryKey = 'm_idx';

    protected $allowedFields = [
        "user_id",
        "user_pw",
        "user_name",
        "sms_yn",
        "user_phone",
        "user_mobile",
        "user_email",
        "user_email_yn",
        "user_level",
        "zip",
        "addr1",
        "addr2",
        "status",
        "user_ip",
        "login_date",
        "r_date",
        "birthday_type",
        "account_name",
        "bank",
        "account_num",
        "login_count",
        "sns_key",
        "company_name",
        "company_representative",
        "company_code",
        "company_file",
        "work_position",
        "member_type",
        "company_mail",
        "business_number",
        "business_type",
        "business_industry",
        "business_phone",
        "bussiness_web",
        "manager_pw",
        "manager_id",
        "user_department",
        "membership_type",
        "membership_organization",
        "membership_zip",
        "membership_addr1",
        "membership_addr2",
        "membership_phone",
        "membership_period",
        "membership_school",
        "membership_department",
        "membership_degree",
        "extra_affiliation",
        "extra_period",
        "active_period",
        "active_affiliation",
        "active_department",
        "active_position",
        "membership_photo",
        "membership_qualification",
        "qualification_file",
        "group_introduction",
        "group_history",
        "organization_name",
        "organization_director",
        "organization_zip",
        "organization_addr1",
        "organization_addr2",
        "department_name",
        "manager_name",
        "manager_phone",
        "member_name",
        "member_phone",
        "member_email",
        "course_idx",
        "approval_status"
    ];

    public function counts(array $where = [])
    {
        $builder = $this->builder();

        if (!empty($where)) {
            foreach ($where as $key => $val) {
                if ($val !== null && $val !== '' && $key != 'main') {
                    $builder->where($key, $val);
                }
            }
        }

        $builder->where('user_level >', 2);

        if (!empty($where['main'])) {

            $keyword = $where['main'];

            $builder->groupStart()
                ->like('user_name', $keyword)
                ->orLike('user_phone', $keyword)
                ->orLike('user_mobile', $keyword)
                ->orLike('user_email', $keyword)
                ->orLike('user_id', $keyword)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }


    // public function getPageWithPager(array $where = [], int $perPage = 10, string $group = 'notice')
    // {
    //     $builder = $this->builder();

    //     foreach ($where as $key => $val) {
    //         if ($val !== null && $val !== '' && $key !== 'main') {
    //             $builder->where($key, $val);
    //         }
    //     }

    //     $builder->where('user_level >', 2);

    //     if (!empty($where['main'])) {
    //         $keyword = trim($where['main']);

    //         $builder->groupStart()
    //             ->like('user_name', $keyword)
    //             ->orLike('user_phone', $keyword)
    //             ->orLike('user_mobile', $keyword)
    //             ->orLike('user_email', $keyword)
    //             ->orLike('user_id', $keyword)
    //             ->groupEnd();
    //     }

    //     $countBuilder = clone $builder;
    //     $total = $countBuilder->countAllResults();

    //     $pager = service('pager');
    //     $page = $pager->getCurrentPage($group);
    //     $page = max(1, $page);

    //     $offset = ($page - 1) * $perPage;

    //     $items = $builder
    //         ->orderBy('m_idx', 'DESC')
    //         ->limit($perPage, $offset)
    //         ->get()
    //         ->getResultArray();

    //     $pager->store($group, $page, $perPage, $total);

    //     return [
    //         'items' => $items,
    //         'pager' => $pager,
    //         'total' => $total
    //     ];
    // }

    public function getPageWithPager(array $where = [], int $perPage = 10, string $group = 'notice')
    {
        $db = \Config\Database::connect();

        $builder = $db->table('tbl_member m');

        $subQuery = $db->table('tbl_member')
            ->select('
            COALESCE(manager_id, user_id) AS group_id,
            MAX(m_idx) AS max_idx
        ')
            ->groupBy('COALESCE(manager_id, user_id)');

        $builder->select("
            m.*,
            manager.user_id   AS manager_user_id,
            manager.user_name AS manager_name,
            grp.max_idx
        ");

        $builder->join('tbl_member manager', 'manager.user_id = m.manager_id', 'left');

        $builder->join(
            "({$subQuery->getCompiledSelect()}) grp",
            "grp.group_id = COALESCE(m.manager_id, m.user_id)",
            "left",
            false
        );

        $builder->where('m.user_level >', 2);

        foreach ($where as $key => $val) {
            if ($val !== null && $val !== '' && $key !== 'main') {
                if ($key == 'member_type' && $val == 'G') {
                    $builder->groupStart();
                    $builder->where('m.member_type', 'G');
                    $builder->orWhere('m.member_type', 'S');
                    $builder->groupEnd();
                } else {
                    $builder->where('m.' . $key, $val);
                }
            }
        }

        if (!empty($where['main'])) {
            $keyword = trim($where['main']);

            $builder->groupStart()
                ->like('m.user_name', $keyword)
                ->orLike('m.user_phone', $keyword)
                ->orLike('m.user_mobile', $keyword)
                ->orLike('m.user_email', $keyword)
                ->orLike('m.user_id', $keyword)
                ->groupEnd();
        }

        $builder->orderBy('grp.max_idx', 'DESC');
        $builder->orderBy('m.m_idx', 'DESC');

        $countBuilder = clone $builder;
        $total = $countBuilder->countAllResults(false);

        $pager = service('pager');
        $page = max(1, $pager->getCurrentPage($group));
        $offset = ($page - 1) * $perPage;

        $items = $builder
            ->limit($perPage, $offset)
            ->get()
            ->getResultArray();

        $pager->store($group, $page, $perPage, $total);

        return [
            'items' => $items,
            'pager' => $pager,
            'total' => $total
        ];
    }

    public function getMembers(array $filters = []): array
    {
        $builder = $this->db->table('tbl_member m');
        $builder->select([
            'm.m_idx',
            'm.user_id',
            'm.user_name',
            'm.user_mobile',
            'm.user_email',
            'm.manager_id',
            'm.member_type',
            'm.course_idx',
            'm.r_date',
            'manager.user_name       AS manager_name',
            'manager.user_id         AS manager_user_id',
            'manager.company_name    AS company_name',
            'manager.business_phone  AS company_phone',
            'manager.user_department AS dept',
        ]);
        $builder->join('tbl_member manager', 'manager.user_id = m.manager_id', 'left');
        $builder->where('m.user_level >', 2);
        $builder->where('m.course_idx IS NOT NULL');
        $builder->where('m.course_idx !=', '');

        if (!empty($filters['student_name'])) {
            $kw = $filters['student_name'];
            $builder->groupStart()
                ->like('m.user_name', $kw)
                ->orLike('m.user_id', $kw)
                ->groupEnd();
        }
        if (!empty($filters['student_type'])) {
            $builder->where('m.member_type', $filters['student_type']);
        }
        if (!empty($filters['manager'])) {
            $kw = $filters['manager'];
            $builder->groupStart()
                ->like('manager.user_name', $kw)
                ->orLike('manager.user_id', $kw)
                ->groupEnd();
        }
        if (!empty($filters['reg_date'])) {
            $builder->where('DATE(m.r_date)', $filters['reg_date']);
        }

        if (!empty($filters['company_search'])) {
            $kw = $filters['company_search'];
            $builder->groupStart()
                ->like('manager.company_name', $kw)
                ->orLike('manager.user_name', $kw)
                ->groupEnd();
        }

        return $builder->get()->getResultArray();
    }

    public function getCoursesByIds(array $ids, array $filters = []): array
    {
        if (empty($ids)) return [];

        $builder = $this->db->table('tbl_course c');
        $builder->select([
            'c.idx',
            'c.course_name',
            'c.mentor',
            'c.number_lecture',
            'c.course_url',
            'c.start_date',
            'c.end_date',
            'c.course_code_1',
            'c.course_code_2',
            'code1.code_name AS code_name_1',
            'code2.code_name AS code_name_2',
        ]);
        $builder->join('tbl_code code1', 'code1.code_no = c.course_code_1', 'left');
        $builder->join('tbl_code code2', 'code2.code_no = c.course_code_2', 'left');
        $builder->whereIn('c.idx', $ids);

        if (!empty($filters['course_name'])) {
            $builder->like('c.course_name', $filters['course_name']);
        }
        if (!empty($filters['s_category1'])) {
            $builder->where('c.course_code_2', $filters['s_category1']);
        }

        $result = [];
        foreach ($builder->get()->getResultArray() as $c) {
            $result[$c['idx']] = $c;
        }
        return $result;
    }

    public function getProgressMap(array $pairs): array
    {
        if (empty($pairs)) return [];

        $escapedPairs = array_map(function ($pair) {
            $uid = $this->db->escapeString($pair['user_id']);
            return "('{$uid}'," . (int)$pair['course_id'] . ")";
        }, $pairs);

        $pairSql = implode(',', array_unique($escapedPairs));

        $rows = $this->db->query(
            "SELECT * FROM tbl_course_progress
             WHERE (user_id, course_idx) IN ($pairSql)"
        )->getResultArray();

        $map = [];
        foreach ($rows as $cp) {
            $key = $cp['user_id'] . '_' . $cp['course_idx'];
            $map[$key] = $cp;
        }
        return $map;
    }

    public function getCourseOptions(): array
    {
        return $this->db->table('tbl_course')
            ->select('idx, course_name')
            ->where('status', 1)
            ->orderBy('course_name', 'ASC')
            ->get()
            ->getResultArray();
    }

    public static function resolveStatus(array $course, ?array $cp): array
    {
        $cpStatus    = $cp['status'] ?? null;
        $certificate = $cp['certificate'] ?? '';
        $endDateStr  = !empty($course['end_date']) ? substr($course['end_date'], 0, 10) : '';
        $isExpired   = !empty($endDateStr) && strtotime($endDateStr . ' 23:59:59') < time();

        if ($cpStatus === 'completed' && $certificate === 'Y') {
            $displayStatus      = '수료완료';
            $displayStatusClass = 'badge-status-finish';
        } elseif ($cpStatus === 'completed') {
            $displayStatus      = '수강완료';
            $displayStatusClass = 'badge-status-done';
        } elseif ($isExpired && $cpStatus !== 'completed') {
            $displayStatus      = '미수료';
            $displayStatusClass = 'badge-status-fail';
        } elseif ($cpStatus === 'in_progress') {
            $displayStatus      = '수강중';
            $displayStatusClass = 'badge-status-progress';
        } else {
            $displayStatus      = '수강대기';
            $displayStatusClass = 'badge-status-wait';
        }

        $completionLabel = ($cpStatus === 'completed' && $certificate === 'Y') ? '수료' : '미수료';
        $completionClass = ($cpStatus === 'completed' && $certificate === 'Y') ? 'badge-blue' : 'badge-red';

        return [
            'display_status'       => $displayStatus,
            'display_status_class' => $displayStatusClass,
            'completion_label'     => $completionLabel,
            'completion_class'     => $completionClass,
            'is_expired'           => $isExpired,
            'certificate'          => $certificate,
        ];
    }
}
