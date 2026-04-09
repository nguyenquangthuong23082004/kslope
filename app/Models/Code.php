<?php

namespace App\Models;

use CodeIgniter\Model;

class Code extends Model
{
    protected $table = 'tbl_code';

    protected $primaryKey = 'code_idx';

    protected $allowedFields = [
        "code_gubun", "code_no", "code_name", "ufile1", "rfile1", "ufile2",
        "rfile2", "parent_code_no", "depth", "rolling_yn", "bestYN", "status",
        "onum", "link",
    ];

    public function getByParentAndDepth($parent_code_no, $depth)
    {
        return $this->select('*')
            ->where('parent_code_no', $parent_code_no)
            ->where('depth', $depth)
            ->where('status', 'Y')
            ->orderBy('onum', 'DESC')
            ->orderBy('code_idx', 'ASC')
            ->get();
    }

    public function getListByParentCode($parent_code_no)
    {
        return $this->select('*')
            ->where('parent_code_no', $parent_code_no)
            ->where('status', 'Y')
            ->orderBy('onum', 'DESC')
            ->orderBy('code_idx', 'ASC')
            ->findAll();
    }

    public function getByCodeNo($code_no)
    {
        return $this->where('code_no', $code_no)->first();
    }

    public function getByCodeNos($code_nos)
    {
        if (empty($code_nos)) return [];
        return $this->whereIn('code_no', $code_nos)->findAll();
    }

    public function getTotalCount($parentCodeNo = '')
    {
        $builder = $this->builder();

        if ($parentCodeNo != "") {
            $builder->where('parent_code_no', $parentCodeNo);
        } else {
            $builder->where('parent_code_no', '0');
        }

        $builder->where('code_gubun !=', 'bank');
        return $builder->countAllResults();
    }

    public function getPagedData($parentCodeNo, $nFrom, $g_list_rows)
    {
        $builder = $this->builder();

        $builder->select('*, (select ifnull(count(*),0) as cnt from tbl_code a where a.parent_code_no=tbl_code.code_no) as cnt');

        if ($parentCodeNo != "") {
            $builder->where('parent_code_no', $parentCodeNo);
        } else {
            $builder->where('parent_code_no', '0');
        }

        $builder->where('code_gubun !=', 'bank');
        $builder->orderBy('onum', 'DESC')
            ->orderBy('code_idx', 'DESC')
            ->limit($g_list_rows, $nFrom);

        return $builder->get()->getResultArray();
    }

    public function getCodeName($code_no)
    {

        $builder = $this->builder();
        $builder->select('code_name')->where('code_no', $code_no);

        $result = $builder->get()->getRow();

        return $result->code_name ?? "";
    }

    public function getCodeByIdx($code_idx)
    {
        return $this->where('code_idx', $code_idx)->first();
    }

    public function countByParentCodeNo($parent_code_no)
    {
        return $this->where('parent_code_no', $parent_code_no)->countAllResults();
    }

    public function getDepthAndCodeGubunByNo($code_no)
    {
        return $this->select('depth, code_gubun')->where('code_no', $code_no)->first();
    }

    public function getMaxCodeNo($parent_code_no, $s_parent_code_no)
    {
        return $this->select("IFNULL(MAX(code_no),'{$s_parent_code_no}00')+1 as code_no")
            ->where('parent_code_no', $parent_code_no)
            ->first();
    }

    public function getMaxCodeNoWithReserved($parent_code_no, $s_parent_code_no)
    {
        return $this->select("IFNULL(MAX(code_no),'{$s_parent_code_no}00')+2 as code_no")
            ->where('parent_code_no', $parent_code_no)
            ->first();
    }

    public function getCodesByGubunDepthAndStatus($code_gubun, $depth)
    {
        return $this->where('code_gubun', $code_gubun)
            ->where('depth', $depth)
            ->where('status', 'Y')
            ->orderBy('onum', 'ASC')
            ->orderBy('code_idx', 'ASC')
            ->findAll();
    }

    public function getCodesByParentCodeAndStatus($parent_code_no, $depth)
    {
        return $this->where('parent_code_no', $parent_code_no)
            ->where('depth', $depth)
            ->where('status', 'Y')
            ->orderBy('onum', 'ASC')
            ->orderBy('code_idx', 'ASC')
            ->findAll();
    }

    public function getCodesByGubunDepthAndStatusExclude($code_gubun, $depth, $exclude)
    {
        return $this->where('code_gubun', $code_gubun)
            ->where('depth', $depth)
            ->where('status', 'Y')
            ->whereNotIn('code_no', $exclude)
            ->orderBy('onum', 'ASC')
            ->orderBy('code_idx', 'ASC')
            ->findAll();
    }

    public function getParentCodeNoByCodeNo($code_no)
    {
        $parent_code_no = $this->select('parent_code_no')->where('code_no', $code_no)->first()['parent_code_no'] ?? 0;
        return $this->where('code_no', $parent_code_no)->first();
    }

    public function getCodeTree($code_no)
    {
        $code_arr = [];
        $code_info = $this->where('code_no', $code_no)->first();
        while ($code_info) {
            $code_arr[] = $code_info;
            $code_info = $this->where('code_no', $code_info['parent_code_no'])->first();
        }
        array_pop($code_arr);
        return array_reverse($code_arr);
    }

    public function getCodeSpa($depth, $parent_code_no)
    {
        $sql = "SELECT * FROM tbl_code WHERE depth = ? AND parent_code_no = ? AND status = 'Y'";
        return $this->db->query($sql, [$depth, $parent_code_no])->getResultArray();
    }

    public function getAllDescendants(string $parentCodeNo): array
    {
        $descendants = [];

        $children = $this->where('parent_code_no', $parentCodeNo)->findAll();

        foreach ($children as $child) {
            $descendants[] = $child;

            $childDescendants = $this->getAllDescendants($child['code_no']);
            $descendants = array_merge($descendants, $childDescendants);
        }

        return $descendants;
    }

    public function getAirCodes()
    {
        return $this->where('code_gubun', 'air')
            ->where('depth', '2')
            ->orderBy('onum', 'desc')
            ->orderBy('code_idx', 'desc')
            ->findAll();
    }

    /**
     * Get codes by gubun and depth
     * Optimized for frequently used queries
     */
    public function getCodesByGubunAndDepth($code_gubun, $depth, $code_nos = null, $status = 'Y')
    {
        $builder = $this->builder()
            ->where('code_gubun', $code_gubun)
            ->where('depth', $depth);

        if ($code_nos !== null) {
            if (is_array($code_nos)) {
                $builder->whereIn('code_no', $code_nos);
            } else {
                $builder->where('code_no', $code_nos);
            }
        }

        if ($status !== null) {
            $builder->where('status', $status);
        }

        return $builder->orderBy('code_no', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Get tour codes by depth with parent filter
     */
    public function getTourCodesByDepth($depth, $parent_code_no = null, $status = 'Y')
    {
        $builder = $this->builder()
            ->where('code_gubun', 'tour')
            ->where('depth', $depth);

        if ($parent_code_no !== null) {
            $builder->where('parent_code_no', $parent_code_no);
        }

        if ($status !== null) {
            $builder->where('status', $status);
        }

        return $builder->orderBy('code_no', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Get codes with their children in one query
     * Optimized to prevent N+1 queries
     */
    public function getCodesWithChildren($parent_code_no, $status = 'Y')
    {
        // Get parent codes
        $parents = $this->getByParentCode($parent_code_no, $status)->getResultArray();

        if (empty($parents)) {
            return [];
        }

        // Get all children in single query
        $parent_code_nos = array_column($parents, 'code_no');
        $children = $this->builder()
            ->whereIn('parent_code_no', $parent_code_nos)
            ->where('status', $status)
            ->orderBy('onum', 'ASC')
            ->orderBy('code_no', 'ASC')
            ->get()
            ->getResultArray();

        // Group children by parent
        $children_grouped = [];
        foreach ($children as $child) {
            $children_grouped[$child['parent_code_no']][] = $child;
        }

        // Assign children to parents
        foreach ($parents as $key => $parent) {
            $parents[$key]['children'] = $children_grouped[$parent['code_no']] ?? [];
        }

        return $parents;
    }

    public function getByParentCode($parent_code_no)
    {
        return $this->select('*')
            ->where('parent_code_no', $parent_code_no)
            ->where('status', 'Y')
            // hide golf
            ->where('code_no !=', '1302')
            ->orderBy('onum', 'ASC')
            ->orderBy('code_idx', 'ASC')
            ->get();
    }

    /**
     * Get hierarchical codes (parent -> children -> grandchildren)
     */
    public function getHierarchicalCodes($root_parent_code_no, $max_depth = 3, $status = 'Y')
    {
        // Get all codes that might be in this hierarchy
        $builder = $this->builder()
            ->where('status', $status)
            ->orderBy('depth', 'ASC')
            ->orderBy('onum', 'ASC')
            ->orderBy('code_no', 'ASC');

        // Get root level
        $all_codes = $builder->get()->getResultArray();

        // Build hierarchy
        $codes_by_parent = [];
        $codes_by_id = [];

        foreach ($all_codes as $code) {
            $codes_by_id[$code['code_no']] = $code;
            $codes_by_parent[$code['parent_code_no']][] = $code;
        }

        // Recursive function to build tree
        $buildTree = function ($parent_no) use (&$buildTree, $codes_by_parent) {
            if (!isset($codes_by_parent[$parent_no])) {
                return [];
            }

            $result = [];
            foreach ($codes_by_parent[$parent_no] as $code) {
                $code['children'] = $buildTree($code['code_no']);
                $result[] = $code;
            }
            return $result;
        };

        return $buildTree($root_parent_code_no);
    }

    /**
     * Get multiple parent codes with their children efficiently
     */
    public function getMultipleCodesWithChildren(array $parent_code_nos, $status = 'Y')
    {
        if (empty($parent_code_nos)) {
            return [];
        }

        // Get all parent codes
        $parents = $this->builder()
            ->whereIn('code_no', $parent_code_nos)
            ->where('status', $status)
            ->orderBy('onum', 'ASC')
            ->get()
            ->getResultArray();

        if (empty($parents)) {
            return [];
        }

        // Get all children in single query
        $children = $this->builder()
            ->whereIn('parent_code_no', $parent_code_nos)
            ->where('status', $status)
            ->orderBy('parent_code_no', 'ASC')
            ->orderBy('onum', 'ASC')
            ->get()
            ->getResultArray();

        // Group children by parent
        $children_grouped = [];
        foreach ($children as $child) {
            $children_grouped[$child['parent_code_no']][] = $child;
        }

        // Assign children to parents
        foreach ($parents as $key => $parent) {
            $parents[$key]['children'] = $children_grouped[$parent['code_no']] ?? [];
        }

        return $parents;
    }

    /**
     * Get multiple code names in single query
     * Returns array with code_no as key and code_name as value
     */
    public function getCodeNames(array $code_nos, $code_gubun = null)
    {
        if (empty($code_nos)) {
            return [];
        }

        $builder = $this->builder()
            ->select('code_no, code_name')
            ->whereIn('code_no', $code_nos);

        if ($code_gubun !== null) {
            $builder->where('code_gubun', $code_gubun);
        }

        $results = $builder->get()->getResultArray();

        return array_column($results, 'code_name', 'code_no');
    }

    /**
     * Get country codes hierarchy (country_code_1 and country_code_2)
     */
    public function getCountryCodes($depth = null, $parent_code_no = null)
    {
        $builder = $this->builder()
            ->where('code_gubun', 'country')
            ->where('status', 'Y');

        if ($depth !== null) {
            $builder->where('depth', $depth);
        }

        if ($parent_code_no !== null) {
            $builder->where('parent_code_no', $parent_code_no);
        }

        return $builder->orderBy('code_no', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Get stay codes
     */
    public function getStayCodes($depth = null)
    {
        $builder = $this->builder()
            ->where('code_gubun', 'stay')
            ->where('status', 'Y');

        if ($depth !== null) {
            $builder->where('depth', $depth);
        }

        return $builder->orderBy('code_no', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Batch get codes by multiple conditions
     * Optimized for getting multiple code types at once
     */
    public function getBatchCodesByConditions(array $conditions_array)
    {
        $results = [];

        foreach ($conditions_array as $key => $conditions) {
            $results[$key] = $this->getCodesByConditions($conditions);
        }

        return $results;
    }

    /**
     * Get codes with conditions
     */
    public function getCodesByConditions($conditions, $status = 'Y')
    {
        $builder = $this->builder();

        foreach ($conditions as $key => $value) {
            $builder->where($key, $value);
        }

        if ($status !== null) {
            $builder->where('status', $status);
        }

        return $builder->orderBy('onum', 'ASC')
            ->orderBy('code_no', 'ASC')
            ->get()
            ->getResultArray();
    }
}