<?php

namespace App\Models;

use CodeIgniter\Model;

class VideoProgressModel extends Model
{
    protected $table = 'tbl_video_progress';
    protected $primaryKey = 'progress_idx';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'user_id',
        'course_idx',
        'video_idx',
        'watch_duration',
        'total_duration',
        'progress_percent',
        'is_completed',
        'last_position',
        'total_watch_time',
        'watch_count',
        'first_watch_date',
        'last_watch_date'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getVideoProgress($userId, $videoIdx)
    {
        return $this->where('user_id', $userId)
                    ->where('video_idx', $videoIdx)
                    ->first();
    }

    public function updateProgress($data)
    {
        try {
            // Tính progress percent từ last_position
            $progressPercent = 0;
            if (!empty($data['total_duration']) && $data['total_duration'] > 0) {
                $progressPercent = min(100, ($data['last_position'] / $data['total_duration']) * 100);
            }

            $isCompleted = $data['is_completed'] ?? ($progressPercent >= 85 ? 1 : 0);

            // Lấy record hiện tại
            $existing = $this->where('user_id', $data['user_id'])
                             ->where('video_idx', $data['video_idx'])
                             ->first();

            if ($existing) {
                // Cập nhật record có sẵn
                // Chỉ cập nhật nếu vị trí mới >= vị trí cũ
                if ($data['last_position'] >= $existing['last_position'] || $isCompleted) {
                    $updateData = [
                        'watch_duration' => max($data['watch_duration'], $existing['watch_duration']),
                        'total_duration' => $data['total_duration'],
                        'progress_percent' => round($progressPercent, 2),
                        'is_completed' => $isCompleted,
                        'last_position' => max($data['last_position'], $existing['last_position']),
                        'total_watch_time' => max($data['total_watch_time'] ?? 0, $existing['total_watch_time']),
                        'watch_count' => $existing['watch_count'] + 1,
                        'last_watch_date' => date('Y-m-d H:i:s')
                    ];

                    $result = $this->update($existing['progress_idx'], $updateData);
                    
                    log_message('info', 'Updated video progress: ' . json_encode([
                        'progress_idx' => $existing['progress_idx'],
                        'old_position' => $existing['last_position'],
                        'new_position' => $updateData['last_position'],
                        'old_progress' => $existing['progress_percent'],
                        'new_progress' => $updateData['progress_percent']
                    ]));
                    
                    return $result;
                }
                
                log_message('info', 'Skip update - position not increased');
                return true;
            }

            // Insert mới
            $insertData = [
                'user_id' => $data['user_id'],
                'course_idx' => $data['course_idx'],
                'video_idx' => $data['video_idx'],
                'watch_duration' => $data['watch_duration'],
                'total_duration' => $data['total_duration'],
                'progress_percent' => round($progressPercent, 2),
                'is_completed' => $isCompleted,
                'last_position' => $data['last_position'] ?? 0,
                'total_watch_time' => $data['total_watch_time'] ?? 0,
                'watch_count' => 1,
                'first_watch_date' => date('Y-m-d H:i:s'),
                'last_watch_date' => date('Y-m-d H:i:s')
            ];

            $result = $this->insert($insertData);
            
            log_message('info', 'Inserted new video progress: ' . json_encode([
                'video_idx' => $data['video_idx'],
                'progress_percent' => $insertData['progress_percent']
            ]));
            
            return $result;
            
        } catch (\Exception $e) {
            log_message('error', 'VideoProgressModel::updateProgress error: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    public function getCourseVideoProgress($userId, $courseIdx)
    {
        return $this->where('user_id', $userId)
                    ->where('course_idx', $courseIdx)
                    ->findAll();
    }

    public function getCompletedVideos($userId, $courseIdx)
    {
        return $this->where('user_id', $userId)
                    ->where('course_idx', $courseIdx)
                    ->where('is_completed', 1)
                    ->findAll();
    }

    public function getInProgressVideos($userId, $courseIdx)
    {
        return $this->where('user_id', $userId)
                    ->where('course_idx', $courseIdx)
                    ->where('progress_percent >', 0)
                    ->where('is_completed', 0)
                    ->findAll();
    }

    public function getTotalWatchTime($userId, $courseIdx)
    {
        $result = $this->selectSum('total_watch_time')
                       ->where('user_id', $userId)
                       ->where('course_idx', $courseIdx)
                       ->first();
        
        return $result['total_watch_time'] ?? 0;
    }
}