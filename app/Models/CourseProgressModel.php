<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseProgressModel extends Model
{
    protected $table = 'tbl_course_progress';
    protected $primaryKey = 'course_progress_idx';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'user_id',
        'course_idx',
        'total_videos',
        'completed_videos',
        'in_progress_videos',
        'progress_percent',
        'total_watch_time',
        'enrollment_date',
        'start_date',
        'completion_date',
        'last_access_date',
        'status',
        'certificate'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getCourseProgress($userId, $courseIdx)
    {
        return $this->where('user_id', $userId)
            ->where('course_idx', $courseIdx)
            ->first();
    }

    public function updateCourseProgress($userId, $courseIdx)
    {
        $videoProgressModel = model('VideoProgressModel');
        $courseModel = model('CourseModel');

        $course = $courseModel->find($courseIdx);
        if (!$course) {
            return false;
        }

        $videoIds = !empty($course['course_url']) ? array_filter(explode(',', $course['course_url'])) : [];
        $totalVideos = count($videoIds);

        if ($totalVideos == 0) {
            return false;
        }

        $completedVideos = $videoProgressModel
            ->where('user_id', $userId)
            ->where('course_idx', $courseIdx)
            ->where('is_completed', 1)
            ->countAllResults();

        $inProgressVideos = $videoProgressModel
            ->where('user_id', $userId)
            ->where('course_idx', $courseIdx)
            ->where('progress_percent >', 0)
            ->where('is_completed', 0)
            ->countAllResults();

        $totalWatchTime = $videoProgressModel->getTotalWatchTime($userId, $courseIdx);

        $progressPercent = ($completedVideos / $totalVideos) * 100;

        $status = 'not_started';
        if ($completedVideos > 0 && $completedVideos < $totalVideos) {
            $status = 'in_progress';
        } elseif ($completedVideos == $totalVideos) {
            $status = 'completed';
        } elseif ($inProgressVideos > 0) {
            $status = 'in_progress';
        }

        $existing = $this->getCourseProgress($userId, $courseIdx);

        $saveData = [
            'user_id' => $userId,
            'course_idx' => $courseIdx,
            'total_videos' => $totalVideos,
            'completed_videos' => $completedVideos,
            'in_progress_videos' => $inProgressVideos,
            'progress_percent' => round($progressPercent, 2),
            'total_watch_time' => $totalWatchTime,
            'status' => $status,
            'last_access_date' => date('Y-m-d H:i:s')
        ];

        if ($existing) {
            // Update
            if (!$existing['start_date'] && ($completedVideos > 0 || $inProgressVideos > 0)) {
                $saveData['start_date'] = date('Y-m-d H:i:s');
            }

            if ($status == 'completed' && !$existing['completion_date']) {
                $saveData['completion_date'] = date('Y-m-d H:i:s');
            }

            $this->where('course_progress_idx', $existing['course_progress_idx'])
                ->set($saveData)
                ->update();

            return $existing['course_progress_idx'];
        } else {
            // Insert
            $saveData['enrollment_date'] = date('Y-m-d H:i:s');

            if ($completedVideos > 0 || $inProgressVideos > 0) {
                $saveData['start_date'] = date('Y-m-d H:i:s');
            }

            return $this->insert($saveData);
        }
    }

    public function getUserCourses($userId)
    {
        return $this->where('user_id', $userId)
            ->orderBy('last_access_date', 'DESC')
            ->findAll();
    }


    public function getInProgressCourses($userId)
    {
        return $this->where('user_id', $userId)
            ->where('status', 'in_progress')
            ->orderBy('last_access_date', 'DESC')
            ->findAll();
    }


    public function getCompletedCourses($userId)
    {
        return $this->where('user_id', $userId)
            ->where('status', 'completed')
            ->orderBy('completion_date', 'DESC')
            ->findAll();
    }

    public function getCompletedCoursesWithPager(array $where = [], int $perPage = 10, string $group = 'notice')
    {
        $builder = $this->db->table('tbl_course_progress');

        $builder->select([
            'tbl_course_progress.*',
            'tbl_member.user_id AS user_id',
            'tbl_member.user_name AS user_name',
            'tbl_member.user_mobile AS user_mobile',
            'tbl_member.user_email AS user_email',
            'tbl_member.manager_id AS manager_id',
            'manager.user_id AS manager_user_id',
            'manager.user_name AS company_name',
            'tbl_course.course_name AS course_name',
            'tbl_course.mentor AS mentor',
            'tbl_course.start_date AS start_date',
            'tbl_course.end_date AS end_date',
            'tbl_course.number_lecture AS number_lecture',
            'tbl_course.price AS price',
            'tbl_course.duration AS duration',
        ]);

        $builder->join('tbl_member', 'tbl_member.user_id = tbl_course_progress.user_id', 'left')
            ->join('tbl_member as manager', 'manager.user_id = tbl_member.manager_id', 'left')
            ->join('tbl_course', 'tbl_course.idx = tbl_course_progress.course_idx', 'left');

        $builder->where('tbl_course_progress.status', 'completed');

        foreach ($where as $key => $val) {
            if ($val !== null && $val !== '' && !in_array($key, ['main', 'schedule_start', 'schedule_end'])) {
                if ($key === 'course_idx') {
                    $builder->where('tbl_course_progress.course_idx', $val);
                } elseif ($key === 'company_name') {
                    $builder->where('manager.user_name', $val);
                } elseif ($key === 'user_name') {
                    $builder->where('tbl_member.user_name', $val);
                } else {
                    $builder->where($key, $val);
                }
            }
        }

        if (!empty($where['main'])) {
            $keyword = trim($where['main']);

            $builder->groupStart()
                ->like('tbl_course.course_name', $keyword)
                ->orLike('tbl_course.mentor', $keyword)
                ->orLike('tbl_member.user_name', $keyword)
                ->orLike('tbl_member.user_email', $keyword)
                ->orLike('tbl_member.user_mobile', $keyword)
                ->orLike('manager.user_name', $keyword)
                ->groupEnd();
        }

        if (!empty($where['schedule_start'])) {
            $builder->where('tbl_course_progress.completion_date >=', $where['schedule_start'] . ' 00:00:00');
        }
        if (!empty($where['schedule_end'])) {
            $builder->where('tbl_course_progress.completion_date <=', $where['schedule_end'] . ' 23:59:59');
        }

        $countBuilder = clone $builder;
        $total = $countBuilder->countAllResults();

        $pager = service('pager');
        $page = $pager->getCurrentPage($group);
        $page = max(1, $page);

        $offset = ($page - 1) * $perPage;

        $items = $builder
            ->orderBy('tbl_course_progress.completion_date', 'DESC')
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

    public function getCoursesGroupByManager(array $where = [], int $perPage = 10, string $group = 'notice')
    {
        $builder = $this->db->table('tbl_member');

        $builder->select([
            'tbl_member.user_id',
            'tbl_member.user_name',
            'tbl_member.user_mobile',
            'tbl_member.user_email',
            'tbl_member.manager_id',
            'tbl_member.course_idx AS course_idx_list',
            'manager.user_name AS company_name',
        ]);

        $builder->join('tbl_member as manager', 'manager.user_id = tbl_member.manager_id', 'left');

        if (!empty($where['user_name'])) {
            $builder->like('tbl_member.user_name', $where['user_name']);
        }

        $builder->where("manager.user_id", $where['manager_id']);

        $members = $builder
            ->orderBy('tbl_member.m_idx', 'DESC')
            ->get()
            ->getResultArray();

        // echo $this->db->getLastQuery();

        $final = [];

        foreach ($members as $row) {

            if (empty($row['course_idx_list'])) continue;

            $courseIds = array_filter(explode(',', $row['course_idx_list']));

            foreach ($courseIds as $courseId) {

                $newRow = $row;
                $newRow['course_idx'] = trim($courseId);

                $final[] = $newRow;
            }
        }

        $allCourseIds = array_unique(array_column($final, 'course_idx'));

        $courses = [];

        if (!empty($allCourseIds)) {
            $builder = $this->db->table('tbl_course');

            $builder->select([
                'tbl_course.*',
                'tbl_course_progress.course_progress_idx',
                'tbl_course_progress.total_videos',
                'tbl_course_progress.completed_videos',
                'tbl_course_progress.status',
                'tbl_course_progress.progress_percent',
                'c1.code_name as code_name_1',
                'c2.code_name as code_name_2'
            ]);

            $builder->join(
                'tbl_course_progress',
                'tbl_course.idx = tbl_course_progress.course_idx',
                'left'
            );

            $builder->join('tbl_code as c1', 'c1.code_no = tbl_course.course_code_1', 'left');
            $builder->join('tbl_code as c2', 'c2.code_no = tbl_course.course_code_2', 'left');

            $builder->whereIn('tbl_course.idx', $allCourseIds);

            if (!empty($where['course_code_2'])) {
                $builder->where('tbl_course.course_code_2', $where['course_code_2']);
            }

            if (!empty($where['course_idx'])) {
                $builder->where('tbl_course.idx', $where['course_idx']);
            }

            if (!empty($where['status'])) {
                if ($where['status'] == 'completed') {
                    $builder->where('tbl_course_progress.status', $where['status']);
                } else {
                    $builder->groupStart();
                    $builder->where('tbl_course_progress.status', $where['status']);
                    $builder->orWhere('tbl_course_progress.course_progress_idx IS NULL');
                    $builder->groupEnd();
                }
            }

            $courseList = $builder
                ->get()
                ->getResultArray();

            foreach ($courseList as $c) {
                $courses[$c['idx']] = $c;
            }
        }

        foreach ($final as $key => $row) {

            $courseId = $row['course_idx'];

            if (isset($courses[$courseId])) {
                $final[$key] = array_merge($row, $courses[$courseId]);
            } else {
                unset($final[$key]);
            }
        }

        $final = array_values($final);

        $total = count($final);

        $pager = service('pager');
        $page = $pager->getCurrentPage($group);
        $page = max(1, $page);

        $offset = ($page - 1) * $perPage;

        $items = array_slice($final, $offset, $perPage);

        $pager->store($group, $page, $perPage, $total);

        return [
            'items' => $items,
            'pager' => $pager,
            'total' => $total
        ];
    }

    public function getCompletedCompanyList()
    {
        return $this->db->table('tbl_course_progress')
            ->select('manager.user_id, manager.user_name')
            ->join('tbl_member', 'tbl_member.user_id = tbl_course_progress.user_id', 'left')
            ->join('tbl_member as manager', 'manager.user_id = tbl_member.manager_id', 'left')
            ->where('tbl_course_progress.status', 'completed')
            ->where('manager.user_name IS NOT NULL')
            ->where('manager.user_name !=', '')
            ->groupBy('manager.user_id')
            ->orderBy('manager.user_name', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getCompletedCoursesList()
    {
        return $this->db->table('tbl_course_progress')
            ->select('tbl_course.idx, tbl_course.course_name')
            ->join('tbl_course', 'tbl_course.idx = tbl_course_progress.course_idx', 'left')
            ->where('tbl_course_progress.status', 'completed')
            ->groupBy('tbl_course.idx')
            ->orderBy('tbl_course.course_name', 'ASC')
            ->get()
            ->getResultArray();
    }
}
