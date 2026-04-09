<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($site['browser_title'] ?? '') ?></title>

    <?= $this->include('AdmMaster/inc/head') ?>
</head>

<body class="<?= esc($bodyClass ?? '') ?>">
<?= $this->include('AdmMaster/inc/header') ?>

<?= $this->include('AdmMaster/inc/aside') ?>

<main class="main" id="main">
    <?= $this->renderSection('content') ?>
    <?= $this->include('AdmMaster/inc/footer') ?>
</main>
</body>
<script>
    function uploadImage(file) {
        const formData = new FormData();
        formData.append('image', file);

        fetch('<?= site_url('AdmMaster/_magazines/uploadImage') ?>', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const img = $('<img>').attr('src', data.url).addClass('img-fluid');
                    $('#contents').summernote('insertNode', img[0]);
                } else {
                    alert('이미지 업로드 실패: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('이미지 업로드 중 오류가 발생했습니다.');
            });
    }
</script>

</html>