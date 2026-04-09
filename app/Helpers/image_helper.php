<?php

if (!function_exists('simple_convert_to_webp')) {
    /**
     * Convert sang WebP với giới hạn kích thước
     * @param int $maxDimension - Giới hạn chiều dài/rộng tối đa (mặc định 10000px)
     */
    function simple_convert_to_webp($sourcePath, $quality = 80, $maxDimension = 10000)
    {
        if (!file_exists($sourcePath)) {
            return false;
        }

        // Giới hạn file size
        $fileSize = filesize($sourcePath);
        if ($fileSize > 15 * 1024 * 1024) { // 15MB
            return false;
        }

        // Kiểm tra MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $sourcePath);
        finfo_close($finfo);

        $pathInfo = pathinfo($sourcePath);
        $webpFilename = $pathInfo['filename'] . '.webp';
        $webpPath = $pathInfo['dirname'] . '/' . $webpFilename;

        // ✅ Nếu file đã là WebP, kiểm tra kích thước trước
        if ($mimeType === 'image/webp') {
            // Kiểm tra kích thước của WebP
            $info = @getimagesize($sourcePath);
            if ($info && ($info[0] > $maxDimension || $info[1] > $maxDimension)) {
                // WebP quá lớn, cần resize
                $image = @imagecreatefromwebp($sourcePath);
                if (!$image) {
                    return false;
                }
                // Sẽ xử lý resize ở dưới
            } else {
                // WebP kích thước OK, chỉ đổi tên
                if (rename($sourcePath, $webpPath)) {
                    return $webpFilename;
                }
                return false;
            }
        }

        $supportedMimes = [
            'image/jpeg',
            'image/jpg', 
            'image/png',
            'image/gif',
            'image/pjpeg',
            'image/x-jfif'
        ];
        
        if (!in_array($mimeType, $supportedMimes) && $mimeType !== 'image/webp') {
            return false;
        }

        // Tăng memory
        $oldMemory = ini_get('memory_limit');
        $oldMaxExecution = ini_get('max_execution_time');
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', '300');

        // Đọc ảnh
        $image = null;
        if ($mimeType === 'image/webp') {
            // Đã load ở trên
        } else {
            switch ($mimeType) {
                case 'image/jpeg':
                case 'image/jpg':
                case 'image/pjpeg':
                case 'image/x-jfif':
                    $image = @imagecreatefromjpeg($sourcePath);
                    break;
                case 'image/png':
                    $image = @imagecreatefrompng($sourcePath);
                    if ($image) {
                        imagealphablending($image, false);
                        imagesavealpha($image, true);
                    }
                    break;
                case 'image/gif':
                    $image = @imagecreatefromgif($sourcePath);
                    break;
            }
        }

        if (!$image) {
            ini_set('memory_limit', $oldMemory);
            ini_set('max_execution_time', $oldMaxExecution);
            return false;
        }

        // ✅ Kiểm tra và resize nếu ảnh quá lớn
        $width = imagesx($image);
        $height = imagesy($image);

        if ($width > $maxDimension || $height > $maxDimension) {
            $ratio = min($maxDimension / $width, $maxDimension / $height);
            $newWidth = (int)($width * $ratio);
            $newHeight = (int)($height * $ratio);

            $resized = imagecreatetruecolor($newWidth, $newHeight);
            
            // Preserve transparency
            if ($mimeType === 'image/png' || $mimeType === 'image/gif' || $mimeType === 'image/webp') {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
                imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $transparent);
            }

            imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $resized;
        }

        // Thử nhiều quality levels
        $qualities = [$quality, 75, 60, 50];
        $success = false;

        foreach ($qualities as $q) {
            $success = @imagewebp($image, $webpPath, $q);
            if ($success) {
                break;
            }
        }

        imagedestroy($image);
        
        // Reset settings
        ini_set('memory_limit', $oldMemory);
        ini_set('max_execution_time', $oldMaxExecution);

        if ($success) {
            @unlink($sourcePath);
            return $webpFilename;
        }

        return false;
    }
}

if (!function_exists('simple_upload_and_convert_to_webp')) {
    /**
     * Upload và convert sang WebP với giới hạn kích thước
     * @param int $maxDimension - Giới hạn chiều dài/rộng tối đa (mặc định 10000px)
     */
    function simple_upload_and_convert_to_webp($file, $uploadPath, $quality = 80, $maxDimension = 10000)
    {
        $result = [
            'success' => false,
            'filename' => '',
            'error' => '',
            'resized' => false  // Để biết có resize hay không
        ];

        if (!$file || !$file->isValid()) {
            $result['error'] = '유효하지 않은 파일입니다';
            return $result;
        }

        // Kiểm tra file size
        $fileSize = $file->getSize();
        if ($fileSize > 15 * 1024 * 1024) { // 15MB
            $result['error'] = '파일 크기가 너무 큽니다 (최대 15MB)';
            return $result;
        }

        $allowedMimes = [
            'image/jpeg', 
            'image/jpg', 
            'image/png', 
            'image/gif',
            'image/webp',
            'image/jfif',
            'image/pjpeg',
            'image/x-jfif'
        ];
        
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            $result['error'] = '이미지 파일만 업로드 가능합니다 (JPG, PNG, GIF, WEBP, JFIF)';
            return $result;
        }

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $tempName = $file->getRandomName();
        $file->move($uploadPath, $tempName);

        $tempPath = $uploadPath . $tempName;

        // ✅ Kiểm tra kích thước ảnh trước khi convert
        $imageInfo = @getimagesize($tempPath);
        if ($imageInfo && ($imageInfo[0] > $maxDimension || $imageInfo[1] > $maxDimension)) {
            $result['resized'] = true;  // Đánh dấu là ảnh bị resize
        }

        $webpFilename = simple_convert_to_webp($tempPath, $quality, $maxDimension);

        if ($webpFilename) {
            $result['success'] = true;
            $result['filename'] = $webpFilename;
            
            if ($result['resized']) {
                $result['error'] = '이미지가 너무 큽니다. 자동으로 축소되었습니다 (최대 ' . $maxDimension . 'px)';
            }
        } else {
            // Nếu convert fail, giữ lại file gốc
            $result['error'] = 'WebP 변환에 실패했습니다. 원본 파일로 저장됩니다.';
            $result['success'] = true;
            $result['filename'] = $tempName;
        }

        return $result;
    }
}