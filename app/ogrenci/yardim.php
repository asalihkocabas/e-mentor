<?php
    $page_title = "Yardım Merkezi | E-Mentor Öğrenci Paneli";
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
                                            <div class="p-3 border rounded bg-light">Merhaba 👋 Ben Gemini AI. Ders, sınav veya ödevlerinle ilgili yardıma mı ihtiyacın var?</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <form id="chatForm" class="d-flex">
                                        <input id="userInput" type="text" class="form-control me-2" placeholder="Sorunu buraya yaz...">
                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-send"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="faq-panel" role="tabpanel">
                </div>
            </div>
        </div>
    </div>
    <script>
        // Basit sohbet simülasyonu
    </script>
</div>

<?php
    include '../partials/footer.php';
?>