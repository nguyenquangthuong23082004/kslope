// File upload validation
function validateFileUpload(input) {
    const maxFileSize = 100 * 1024 * 1024; // 10MB
    const allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'zip', 'rar'];
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Check file size
        if (file.size > maxFileSize) {
            alert('파일 크기는 100MB를 초과할 수 없습니다.');
            input.value = '';
            return false;
        }
        
        // Check file type
        const fileExtension = file.name.split('.').pop().toLowerCase();
        if (!allowedTypes.includes(fileExtension)) {
            alert('허용되지 않는 파일 형식입니다.\n허용된 형식: ' + allowedTypes.join(', '));
            input.value = '';
            return false;
        }
        
        // Additional validation for image files
        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
            const img = new Image();
            img.onload = function() {
                if (this.width > 5000 || this.height > 5000) {
                    alert('이미지 크기는 5000x5000 픽셀을 초과할 수 없습니다.');
                    input.value = '';
                    return false;
                }
            };
            img.src = URL.createObjectURL(file);
        }
    }
    return true;
}

// Add event listeners to all file inputs when document is ready
$(document).ready(function() {
    $('input[type="file"]').on('change', function() {
        validateFileUpload(this);
    });
});
