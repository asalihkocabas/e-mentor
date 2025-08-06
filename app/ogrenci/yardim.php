<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';
$_SESSION['user_role'] = 'student';
$page_title = "Yapay Zeka Destek | E-Mentor Öğrenci Paneli";

include '../partials/header.php';
include '../partials/sidebar.php';

// Avatar için öğrencinin adını ve avatar verisini alalım
$student_name = $_SESSION['full_name'] ?? 'Öğrenci';
$avatar = get_avatar_data($student_name);
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Yapay Zeka Destek Asistanı</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item active">GeminiAI</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-9 mx-auto">
                        <div class="card">
                            <div class="card-header bg-light d-flex align-items-center">
                                <img src="../assets/images/logo-sm.svg" height="28" class="me-2" alt="">
                                <h5 class="mb-0 flex-grow-1">Gemini AI Asistanı</h5>
                            </div>
                            <div class="card-body" id="chatArea" style="height: 50vh; overflow-y: auto; display: flex; flex-direction: column-reverse;">
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-sm"><span class="avatar-title bg-primary-subtle text-primary rounded-circle">AI</span></div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="p-3 border rounded bg-light">
                                            Merhaba! Ben Gemini. Derslerinle, sınavlarınla veya anlamadığın bir konuyla ilgili sana nasıl yardımcı olabilirim?
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <form id="chatForm" class="d-flex">
                                    <input id="userInput" type="text" class="form-control me-2" placeholder="Sorunu buraya yaz ve Enter'a bas..." autocomplete="off">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-send"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatForm = document.getElementById('chatForm');
            const userInput = document.getElementById('userInput');
            const chatArea = document.getElementById('chatArea');

            // PHP'den gelen avatar verilerini JavaScript'e aktar
            const studentAvatarHtml = `
        <div class="avatar-sm">
            <span class="avatar-title rounded-circle <?= $avatar['color_class'] ?> text-white">
                <?= $avatar['initials'] ?>
            </span>
        </div>`;

            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const messageText = userInput.value.trim();
                if (!messageText) return;

                // Kullanıcı mesajını ekrana ekle (Dinamik Avatar ile)
                const userMessageHtml = `
            <div class="d-flex mb-4 justify-content-end">
                <div class="me-3"><div class="p-3 border rounded bg-primary text-white">${messageText}</div></div>
                <div class="flex-shrink-0">${studentAvatarHtml}</div>
            </div>`;
                chatArea.insertAdjacentHTML('afterbegin', userMessageHtml);
                userInput.value = '';
                userInput.focus();

                // AI'ın "yazıyor..." mesajı
                const thinkingMessageHtml = `<div class="d-flex mb-4" id="thinking-bubble"><div class="flex-shrink-0"><div class="avatar-sm"><span class="avatar-title bg-primary-subtle text-primary rounded-circle">AI</span></div></div><div class="flex-grow-1 ms-3"><div class="p-3 border rounded bg-light"><div class="spinner-grow spinner-grow-sm text-muted" role="status"><span class="visually-hidden">Loading...</span></div></div></div></div>`;
                chatArea.insertAdjacentHTML('afterbegin', thinkingMessageHtml);

                // AJAX ile backend'e bağlan
                $.ajax({
                    url: '../islemler/yardim-ai.php',
                    type: 'POST',
                    data: { prompt: messageText },
                    dataType: 'json',
                    success: function(response) {
                        let aiResponseText = response.success ? response.message.replace(/\n/g, '<br>') : `<span class="text-danger">${response.message}</span>`;
                        const aiMessageHtml = `<div class="d-flex mb-4"><div class="flex-shrink-0"><div class="avatar-sm"><span class="avatar-title bg-primary-subtle text-primary rounded-circle">AI</span></div></div><div class="flex-grow-1 ms-3"><div class="p-3 border rounded bg-light">${aiResponseText}</div></div></div>`;

                        $('#thinking-bubble').remove();
                        chatArea.insertAdjacentHTML('afterbegin', aiMessageHtml);
                    },
                    error: function() {
                        const errorMessageHtml = `<div class="d-flex mb-4"><div class="flex-shrink-0"><div class="avatar-sm"><span class="avatar-title bg-danger-subtle text-danger rounded-circle">H</span></div></div><div class="flex-grow-1 ms-3"><div class="p-3 border rounded bg-light">Sunucuya bağlanırken bir hata oluştu. Lütfen tekrar deneyin.</div></div></div>`;
                        $('#thinking-bubble').remove();
                        chatArea.insertAdjacentHTML('afterbegin', errorMessageHtml);
                    }
                });
            });
        });
    </script>

<?php
include '../partials/footer.php';
?>