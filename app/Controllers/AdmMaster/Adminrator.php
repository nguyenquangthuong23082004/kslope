<?php

namespace App\Controllers\AdmMaster;

use App\Controllers\BaseController;
use App\Models\HomeSetModel;
use App\Models\PolicyModel;

class Adminrator extends BaseController
{
    protected string $uploadPath;

    protected $policyModel;

    public function __construct()
    {
        $this->policyModel = new PolicyModel();
        $this->homeSet = new HomeSetModel();
        $this->uploadPath = FCPATH . 'uploads/home/';
    }

    public function setting()
    {
        return view('AdmMaster/_adminrator/setting', [
            'site' => $this->site,
        ]);
    }

    public function policy()
    {
        $policy = $this->policyModel->find(1);

        if (!$policy) {
            $this->policyModel->insert([
                'p_idx' => 1,
                'members' => '',
                'minfo1' => '',
                'minfo2' => '',
                'minfo3' => '',
                'minfo4' => '',
                'trans' => '',
                'emails' => '',
                'minfo4_m' => '',
                'minfo3_m' => '',
                'minfo2_m' => '',
                'minfo1_m' => '',
            ]);
            $policy = $this->policyModel->find(1);
        }

        return view('AdmMaster/_adminrator/policy', [
            'site' => $this->site,
            'policy' => $policy,
        ]);
    }

    public function policyUpdate()
    {
        $data = [
            'members' => $this->request->getPost('members'),
            'minfo1' => $this->request->getPost('minfo1'),
            'minfo2' => $this->request->getPost('minfo2'),
            'minfo3' => $this->request->getPost('minfo3'),
            'minfo4' => $this->request->getPost('minfo4'),
            'trans' => $this->request->getPost('trans'),
            'emails' => $this->request->getPost('emails'),
            'minfo4_m' => $this->request->getPost('minfo4_m'),
            'minfo3_m' => $this->request->getPost('minfo3_m'),
            'minfo2_m' => $this->request->getPost('minfo2_m'),
            'minfo1_m' => $this->request->getPost('minfo1_m'),
        ];

        $this->policyModel->update(1, $data);

        return redirect()
            ->to(site_url('AdmMaster/_adminrator/policy'))
            ->with('success', '약관정보가 수정되었습니다.');
    }

    public function update()
    {
        $data = $this->request->getPost();

        if (isset($data['language']) && is_array($data['language'])) {
            $data['language'] = '||' . implode('||', $data['language']);
        }


        $favico = $this->request->getFile('favico_img1');
        if ($favico && $favico->isValid()) {
            $newName = $favico->getRandomName();
            $favico->move($this->uploadPath, $newName);
            $data['favico_img'] = $newName;
        }

        $logo = $this->request->getFile('ufile1');
        if ($logo && $logo->isValid()) {
            $newName = $logo->getRandomName();
            $logo->move($this->uploadPath, $newName);
            $data['logos'] = $newName;
        }

        $ogImg = $this->request->getFile('ufile2');
        if ($ogImg && $ogImg->isValid()) {
            $newName = $ogImg->getRandomName();
            $ogImg->move($this->uploadPath, $newName);
            $data['og_img'] = $newName;
        }

        $footer = $this->request->getFile('ufile3');
        if ($footer && $footer->isValid()) {
            $newName = $footer->getRandomName();
            $footer->move($this->uploadPath, $newName);
            $data['logo_footer'] = $newName;
        }


        if ($this->request->getPost('dels') === 'y') {
            $data['logos'] = '';
        }

        if ($this->request->getPost('dels_f') === 'y') {
            $data['logo_footer'] = '';
        }


        $this->homeSet->update(1, $data);

        return redirect()
            ->to('/AdmMaster/_adminrator/setting')
            ->with('success', '수정하였습니다.');
    }
}
