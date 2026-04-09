<?php

namespace App\Controllers;

use App\Models\Bbs;

class Sub extends BaseController
{
    protected $bbsModel;
    private $db;
    private $courseModel;
    private $memberModel;
    private $codeModel;
    private $videoModel;

    public function __construct()
    {
        $this->courseModel = model('CourseModel');
        $this->codeModel = model('Code');
        $this->memberModel = model('MemberModel');
        $this->videoModel = model('VideoModel');
        $this->bbsModel = new Bbs();
        $this->db = db_connect();
    }

    public function main_tasks()
    {
        $tab = $this->request->getVar('tab');
        $data = [
            'tab' => $tab
        ];
        return view('sub/main_tasks', $data);
    }

    public function slope_safety()
    {
        $tab = $this->request->getVar('tab');
        $data = [
            'tab' => $tab
        ];
        return view('sub/slope_safety', $data);
    }

    public function disaster_risk()
    {
        return view('sub/disaster_risk', [
            'tab' => 'risk'
        ]);
    }
    public function safety_inspection()
    {
        return view('sub/safety_inspection', [
            'tab' => 'safety'
        ]);
    }

    public function detailed_investigation()
    {
        return view('sub/detailed_investigation', [
            'tab' => 'detail'
        ]);
    }
    public function slope_topography_map()
    {
        return view('sub/slope_topography_map', [
            'tab' => 'map'
        ]);
    }

    public function greeting()
    {
        return view('sub/greeting', []);
    }

    public function ci_introduction()
    {
        return view('sub/ci_introduction', []);
    }

    public function past_presidents()
    {
        return view('sub/past_presidents', []);
    }
    public function past_presidents_detail()
    {
        return view('sub/past_presidents_detail', []);
    }

    public function history()
    {
        return view('sub/history', []);
    }

    public function organization_guide()
    {
        return view('sub/organization_guide', []);
    }

    public function vision()
    {
        return view('sub/vision', []);
    }

    public function directions()
    {
        return view('sub/directions', []);
    }

    public function recruitment_infor()
    {
        $code = 'recruitment';
        $data = $this->getAndShowData($code, 9, 302);
        return view('sub/recruitment_infor', $data);
    }

    private function getAndShowData($code, $perPage, $code_no, $ignoreCategory = false)
    {
        $page_order = $this->request->getVar('page_order') ?? 1;

        $category_no = $this->request->getVar('category_no');
        $search_name = $this->request->getVar('search_name');
        $search_word = $this->request->getVar('search_word');

        $categories = $this->codeModel->where('code_gubun', 'board')->where('parent_code_no', $code_no)->findAll();

        $where = [
            'search_name' => $search_name,
            'search_word' => $search_word,
            'code' => $code,
            'status' => 1,
        ];

        if (empty($category_no) && $code != 'recruitment') {
            $category_no = count($categories) > 0 ? $categories[0]['code_no'] : '';
        }

        if (!$ignoreCategory) {
            if (empty($category_no) && $code != 'recruitment') {
                $category_no = count($categories) > 0 ? $categories[0]['code_no'] : '';
            }

            if ($category_no && $category_no != "") {
                $where['category_no'] = $category_no;
            }
        }

        $data = $this->getBbsData($where, $perPage);

        $data['page_order'] = $page_order;
        $data['perPage'] = $perPage;
        $data['category_no'] = $category_no;
        $data['categories'] = $categories;
        $data['search_word'] = $search_word;
        $data['search_name'] = $search_name;

        return $data;
    }

    private function getBbsData($where, $perPage)
    {
        return $this->bbsModel->getListWithPager($where, $perPage);
    }

    public function recruitment_detail()
    {
        $code = 'recruitment';
        $data = $this->getDataDetail($code);
        return view('sub/recruitment_detail', $data);
    }

    private function getDataDetail($code)
    {
        $idx = $this->request->getVar('idx');

        $row = $this->bbsModel->where('bbs_idx', $idx)->where('status', 1)->first();
        if (!$row) {
            return redirect()->back();
        }
        $data['row'] = $row;

        $hit = $row['hit'] + 1;
        $this->bbsModel->update($idx, ['hit' => $hit]);

        $nextRow = $this->bbsModel
            ->where('bbs_idx >', $idx)
            ->where('onum >=', $row['onum'])
            ->where('code', $code)
            ->where('status', 1)
            ->orderBy('bbs_idx', 'ASC')
            ->first();

        $prevRow = $this->bbsModel
            ->where('bbs_idx <', $idx)
            ->where('onum <=', $row['onum'])
            ->where('code', $code)
            ->where('status', 1)
            ->orderBy('bbs_idx', 'DESC')
            ->first();

        $data['nextRow'] = $nextRow;
        $data['prevRow'] = $prevRow;

        return $data;
    }

    public function notice()
    {
        $code = 'notice';
        $data = $this->getAndShowData($code, 10, 301);
        return view('sub/notice', $data);
    }

    public function notice_detail()
    {
        $code = 'notice';
        $data = $this->getDataDetail($code);
        return view('sub/notice_detail', $data);
    }

    public function promotion()
    {
        $code = 'promotion';
        $data = $this->getAndShowData($code, 6, 303);
        return view('sub/promotion', $data);
    }

    public function promotion_detail()
    {
        $code = 'promotion';
        $data = $this->getDataDetail($code);
        return view('sub/promotion_detail', $data);
    }

    public function competition()
    {
        $code = 'competition';
        $data = $this->getAndShowData($code, 10, 304);
        return view('sub/competition', $data);
    }

    public function competition_detail()
    {
        $code = 'competition';
        $data = $this->getDataDetail($code);
        return view('sub/competition_detail', $data);
    }

    public function association_journal()
    {
        $code = 'association';
        $data = $this->getAndShowData($code, 10, 305, true);
        return view('sub/association_journal', $data);
    }

    public function member_resource()
    {
        $code = 'member_resource';
        $data = $this->getAndShowData($code, 6, '');
        return view('sub/member_resource', $data);
    }

    public function member_resource_detail()
    {
        $code = 'member_resource';
        $data = $this->getDataDetail($code);

        if (!$data) {
            return redirect()->to('/member_resource');
        }

        return view('sub/member_resource_detail', $data);
    }
    public function sign_up_instructions()
    {
        return view('sub/sign_up_instructions', []);
    }

    public function contract_information()
    {
        return view('sub/contract_information', []);
    }

    public function take_training()
    {
        $search_name = $this->request->getVar('search_name');
        $keyword = $this->request->getVar('keyword');

        $where = [];
        if ($search_name) {
            $where[$search_name] = $keyword;
        }
        $perPage = 10;

        $list = $this->courseModel->getListPaginate($where, $perPage);

        foreach ($list as &$course) {
            $firstVideo = null;

            if (!empty($course['course_url'])) {
                $videoIds = explode(',', $course['course_url']);

                $firstVideoId = trim($videoIds[0]);

                $firstVideo = $this->videoModel
                    ->where('video_idx', $firstVideoId)
                    ->where('status', 1)
                    ->orderBy('onum', 'DESC')
                    ->first();
            }

            $course['first_video'] = $firstVideo;
        }

        // $member = session()->get("member");
        // $allowedCourses = [];

        // if (!empty($member)) {
        //     $user_id = $member['id'];
        //     $memberInfo = $this->memberModel->where('user_id', $user_id)->first();

        //     if ($memberInfo && !empty($memberInfo['course_idx'])) {
        //         $allowedCourses = explode(',', $memberInfo['course_idx']);
        //     }
        // }
        $data = [
            'search_name' => $search_name,
            'keyword' => $keyword,
            'total' => $this->courseModel->counts($where),
            'list' => $list,
            'pager' => $this->courseModel->pager,
            // 'allowedCourses' => $allowedCourses,
        ];

        return view('sub/take_training', $data);
    }

    public function take_training_detail()
    {
        $idx = $this->request->getVar('idx');
        $course = $this->courseModel
            ->where('idx', $idx)
            ->where('status', 1)
            ->first();

        if (!$course) {
            return redirect()->to('/take_training');
        }

        $videos = [];
        $firstVideo = null;

        if (!empty($course['course_url'])) {
            $videoIds = array_map('trim', explode(',', $course['course_url']));

            if (!empty($videoIds)) {
                $allVideos = $this->videoModel
                    ->whereIn('video_idx', $videoIds)
                    ->where('status', 1)
                    ->findAll();

                $videoMap = [];
                foreach ($allVideos as $video) {
                    $videoMap[$video['video_idx']] = $video;
                }

                foreach ($videoIds as $videoId) {
                    if (isset($videoMap[$videoId])) {
                        $videos[] = $videoMap[$videoId];
                    }
                }

                if (!empty($videos)) {
                    $firstVideo = $videos[0];
                }
            }
        }

        $data = [
            'course' => $course,
            'videos' => $videos,
            'firstVideo' => $firstVideo,
        ];

        return view('sub/take_training_detail', $data);
    }

    public function reservation()
    {
        $idx = $this->request->getVar('course_idx');

        $course = $this->courseModel
            ->where('idx', $idx)
            ->where('status', 1)
            ->first();

        if (!$course) {
            return redirect()->to('/take_training');
        }

        $member = session()->get("member");
        if (empty($member)) {
            return redirect()->to('/login');
        }

        $user_id = $member['id'];
        $member = $this->memberModel->where('user_id', $user_id)->first();

        $data = [
            'course' => $course,
            'member' => $member,
        ];

        return view('sub/reservation', $data);
    }

    public function apply_for_training()
    {
        return view('sub/apply_for_training', []);
    }

    public function completioncert_reissue()
    {
        $categories = $this->codeModel->where('code_gubun', 'goods')
            ->where('depth', '2')
            ->orderBy('onum', 'DESC')
            ->orderBy('code_idx', 'DESC')
            ->findAll();

        $data = [
            'categories' => $categories,
        ];

        return view('sub/completioncert_reissue', $data);
    }

    public function training_information()
    {
        return view('sub/training_information', []);
    }

    public function increaseView($bbs_idx)
    {
        $cookieKey = 'viewed_' . $bbs_idx;

        if ($this->request->getCookie($cookieKey)) {
            return $this->response->setStatusCode(200)->setJSON(['status' => 'skip']);
        }

        $this->db->query("UPDATE tbl_bbs_list SET view_count = view_count + 1 WHERE bbs_idx = ?", [$bbs_idx]);

        $response = $this->response->setJSON(['status' => 'success']);
        $response->setCookie($cookieKey, '1', 86400);

        return $response;
    }


}
