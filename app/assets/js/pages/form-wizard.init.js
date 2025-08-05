$(document).ready(function() {
    // Sihirbazı etkinleştir
    $('#progrss-wizard').bootstrapWizard({
        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index + 1;
            var $percent = ($current / $total) * 100;
            $('#progrss-wizard .progress-bar').css({ width: $percent + '%' });
        }
    });

    // Choices.js'i etkinleştir
    const courseSelect = new Choices('#course-select');
    const classSelect = new Choices('#class-select');

    // Tarih seçiciyi etkinleştir
    flatpickr("#exam-date", {
        enableTime: true,
        dateFormat: "d-m-Y H:i",
        locale: 'tr'
    });

    let questionCounter = 0;
    let learningOutcomesCache = [];

    // Ders veya Sınıf değiştiğinde kazanımları sunucudan çek
    function fetchLearningOutcomes() {
        const courseId = courseSelect.getValue(true);
        const classId = classSelect.getValue(true);
        const selectedClassOption = document.querySelector(`#class-select option[value="${classId}"]`);
        const gradeLevel = selectedClassOption ? selectedClassOption.dataset.grade : null;

        if (courseId && gradeLevel) {
            $.ajax({
                url: '../islemler/get-kazanimlar.php',
                type: 'POST',
                data: { course_id: courseId, grade_level: gradeLevel },
                dataType: 'json',
                success: function(data) {
                    learningOutcomesCache = data;
                    updateAllKazanımSelects();
                },
                error: function() {
                    learningOutcomesCache = [];
                    updateAllKazanımSelects(); // Hata durumunda listeyi boşalt
                }
            });
        }
    }

    $('#course-select').on('change', fetchLearningOutcomes);
    $('#class-select').on('change', fetchLearningOutcomes);

    // Mevcut tüm kazanım seçim kutularını güncelle
    function updateAllKazanımSelects() {
        $('.question-objective').each(function() {
            const select = this;
            const currentVal = $(this).val(); // Mevcut seçimi korumak için

            // Choices.js'i önce imha et
            if (this.choices) {
                this.choices.destroy();
            }

            select.innerHTML = '<option value="">Kazanım Seçiniz...</option>';
            learningOutcomesCache.forEach(function(item) {
                const selected = item.id == currentVal ? 'selected' : '';
                select.innerHTML += `<option value="${item.id}" ${selected}>${item.outcome_code} - ${item.description}</option>`;
            });

            // Choices.js'i yeniden başlat
            new Choices(select);
        });
    }

    // Yeni soru ekleme fonksiyonu
    function addQuestion() {
        questionCounter++;
        const questionHtml = `
            <div class="card border shadow-sm mb-4 question-card" id="question-${questionCounter}">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Soru ${questionCounter}</h5>
                    <button type="button" class="btn-close remove-question-btn"></button>
                </div>
                <div class="card-body">
                    <div class="mb-3"><label class="form-label">Soru Metni</label><textarea class="form-control" rows="3" name="questions[${questionCounter}][text]"></textarea></div>
                    <div class="row">
                        <div class="col-lg-7">
                            <label class="form-label">Seçenekler</label>
                            ${['A', 'B', 'C', 'D'].map(opt => `
                                <div class="input-group mb-2">
                                    <div class="input-group-text"><input class="form-check-input" type="radio" name="questions[${questionCounter}][correct]" value="${opt}"></div>
                                    <span class="input-group-text">${opt})</span>
                                    <input type="text" class="form-control" name="questions[${questionCounter}][options][${opt}]">
                                </div>`).join('')}
                        </div>
                        <div class="col-lg-5">
                            <div class="mb-3"><label class="form-label">Puan</label><input type="number" class="form-control" name="questions[${questionCounter}][points]" value="5"></div>
                            <div class="mb-3"><label class="form-label">Kazanım</label><select class="form-control question-objective" name="questions[${questionCounter}][outcome_id]"><option value="">Önce Ders ve Sınıf Seçin</option></select></div>
                        </div>
                    </div>
                </div>
            </div>`;
        $('#questions-container').append(questionHtml);
        updateAllKazanımSelects();
    }

    // Soru silme
    $('#questions-container').on('click', '.remove-question-btn', function() {
        $(this).closest('.question-card').remove();
        // Soru numaralarını yeniden düzenle (isteğe bağlı)
        $('.question-card').each(function(index) {
            $(this).find('.card-header h5').text(`Soru ${index + 1}`);
        });
        questionCounter = $('.question-card').length;
    });

    // Butona tıklanınca yeni soru ekle
    $('#add-question-btn').on('click', addQuestion);

    // Başlangıçta bir soru ekle
    addQuestion();
});