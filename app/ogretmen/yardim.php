<?php
    session_start();
    $_SESSION['user_role'] = 'teacher';
    $page_title = "Yardım Merkezi | E-Mentor Öğretmen Paneli";
    include '../partials/header.php';
    include '../partials/sidebar.php';
?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Yardım Merkezi</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                <li class="breadcrumb-item active">Yardım</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="nav nav-pills nav-justified mb-4" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#ai-panel" type="button">Yapay Zeka Asistanı</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#faq-panel" type="button">Sık Sorulan Sorular</button></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="ai-panel" role="tabpanel">
                    <div class="row">
                        <div class="col-xl-9 mx-auto">
                            <div class="card">
                                <div class="card-header bg-light d-flex align-items-center">
                                    <img src="../assets/images/logo-sm.svg" height="28" class="me-2" alt="">
                                    <h5 class="mb-0 flex-grow-1">Gemini AI Yardım Asistanı</h5>
                                </div>
                                <div class="card-body" id="chatArea" style="height:420px; overflow-y:auto; display: flex; flex-direction: column-reverse;">
                                    <div class="d-flex mb-4">
                                        <div class="flex-shrink-0"><div class="avatar-sm"><span class="avatar-title bg-primary-subtle text-primary rounded-circle">AI</span></div></div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="p-3 border rounded bg-light">Merhaba! Ben Gemini AI. E-Mentor sistemiyle ilgili size nasıl yardımcı olabilirim?</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <form id="chatForm" class="d-flex">
                                        <input id="userInput" type="text" class="form-control me-2" placeholder="Sorunuzu buraya yazın...">
                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-send"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="faq-panel" role="tabpanel">
                    <div class="row">
                        <div class="col-xl-10 mx-auto">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Sık Sorulan Sorular</h5>
                                    <div class="accordion" id="faqAccordion">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#q1">Kişiye özel ödev nasıl atarım?</button></h2>
                                            <div id="q1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">"Ödev İşlemleri" menüsünden "Ödev Ata" sayfasına gidin. Bir sınav analizi yaptıktan sonra, her öğrencinin eksik kazanımları listelenir. İlgili kazanımın yanındaki "AI ile Ödev Oluştur" butonunu kullanarak kolayca kişiselleştirilmiş ödevler oluşturup atayabilirsiniz.</div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q2">Sınav sonuçlarını toplu olarak nasıl girebilirim?</button></h2>
                                            <div id="q2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">"Sınav İşlemleri" menüsündeki "Sonuç Girişi" sayfasına gidin. İlgili sınavı seçtikten sonra, tüm sınıf listesi cevap anahtarını girebileceğiniz bir tablo formatında karşınıza çıkacaktır.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
            if(chatForm) {
                chatForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const input = document.getElementById('userInput');
                    const messageText = input.value.trim();
                    if (!messageText) return;
                    const chatArea = document.getElementById('chatArea');
                    const userMessageHtml = `<div class="d-flex mb-4 justify-content-end"><div class="me-3"><div class="p-3 border rounded bg-primary text-white">${messageText}</div></div><div class="flex-shrink-0"><img src="../assets/images/users/avatar-1.jpg" class="avatar-sm rounded-circle" alt=""></div></div>`;
                    chatArea.insertAdjacentHTML('afterbegin', userMessageHtml);
                    input.value = '';
                    setTimeout(() => {
                        const thinkingMessageHtml = `<div class="d-flex mb-4"><div class="flex-shrink-0"><div class="avatar-sm"><span class="avatar-title bg-primary-subtle text-primary rounded-circle">AI</span></div></div><div class="flex-grow-1 ms-3"><div class="p-3 border rounded bg-light">Yanıt hazırlanıyor...</div></div></div>`;
                        chatArea.insertAdjacentHTML('afterbegin', thinkingMessageHtml);
                    }, 600);
                });
            }
        });
    </script>
</div>

<?php
    include '../partials/footer.php';
?>