<?

namespace App\Controllers\AdmMaster;

use App\Controllers\BaseController;
use App\Models\NoticeModel;

class Bbs extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function noticeList()
    {
        $model = new NoticeModel();

        $keyword = trim((string) $this->request->getGet('keyword'));
        $onlyNotice = $this->request->getGet('notice'); // Y / N

        if ($keyword !== '') {
            $model->like('r_title', $keyword);
        }

        if ($onlyNotice === 'Y') {
            $model->where('r_notice', 'Y');
        }

        $perPage = 10;

        $total = $model->countAllResults(false);

        $rows = $model
            ->orderBy('r_notice', 'DESC') // 공지글 위
            ->orderBy('r_idx', 'DESC')
            ->paginate($perPage, 'notice');

        $pager = $model->pager;

        return view('AdmMaster/notice/notice_list', [
            'rows'    => $rows,
            'pager'   => $pager,
            'total'   => $total,
            'keyword' => $keyword,
            'notice'  => $onlyNotice,
        ]);
    }

    public function noticeWrite()
    {
        return view('AdmMaster/notice/notice_write');
    }

    public function noticeSave()
    {
        $title   = trim($this->request->getPost('r_title'));
        $content = $this->request->getPost('r_content');

        if ($title === '' || $content === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', '제목과 내용을 입력해주세요.');
        }

        $data = [
            'r_title'   => $title,
            'r_content' => $content,
            'r_name'    => '관리자',
            'r_regdate' => date('Y-m-d H:i:s'),
            'r_hit'     => 0,
        ];

        $this->db->table('jk_notice')->insert($data);

        return redirect()->to(site_url('AdmMaster/notice'))
            ->with('success', '공지사항이 등록되었습니다.');
    }

    public function noticeEdit(int $idx)
    {
        $row = $this->db->table('jk_notice')
            ->where('r_idx', $idx)
            ->get()
            ->getRowArray();

        if (!$row) {
            return redirect()->to(site_url('AdmMaster/notice'))
                ->with('error', '존재하지 않는 글입니다.');
        }

        return view('AdmMaster/notice/notice_edit', [
            'row' => $row,
        ]);
    }


    public function noticeUpdate(int $idx)
    {
        $title   = trim((string)$this->request->getPost('r_title'));
        $content = (string)$this->request->getPost('r_content');
        $name    = trim((string)$this->request->getPost('r_name'));

        if ($title === '' || $content === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', '제목과 내용을 입력해주세요.');
        }

        $this->db->table('jk_notice')
            ->where('r_idx', $idx)
            ->update([
                'r_title'   => $title,
                'r_content' => $content,
                'r_name'    => $name !== '' ? $name : '관리자',
            ]);

        return redirect()->to(site_url('AdmMaster/notice'))
            ->with('success', '공지사항이 수정되었습니다.');
    }


    public function noticeDelete($idx)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $row = $this->db->table('jk_notice')
            ->where('r_idx', $idx)
            ->get()
            ->getRowArray();

        if (!$row) {
            return $this->response->setJSON([
                'success' => false,
                'message' => '존재하지 않는 글입니다.'
            ]);
        }

        $this->db->table('jk_notice')
            ->where('r_idx', $idx)
            ->delete();

        return $this->response->setJSON([
            'success' => true
        ]);
    }
    public function uploadImage()
    {
        $file = $this->request->getFile('file');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['error' => true]);
        }

        $newName = $file->getRandomName();
        $path = FCPATH . 'uploads/notice/';

        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $file->move($path, $newName);

        return $this->response->setJSON([
            'url' => base_url('uploads/notice/' . $newName)
        ]);
    }
    public function noticeDeleteMulti()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ]);
        }

        $data = $this->request->getJSON(true);
        $ids  = $data['ids'] ?? [];

        if (!is_array($ids) || count($ids) === 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => '삭제 대상이 없습니다.'
            ]);
        }

        $this->db->table('jk_notice')
            ->whereIn('r_idx', $ids)
            ->delete();

        return $this->response->setJSON([
            'success' => true
        ]);
    }
}
