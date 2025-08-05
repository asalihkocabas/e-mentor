$(document).ready(function() {
    // Kurulum
    const courseSelectEl = document.getElementById('course-select');
    const classSelectEl = document.getElementById('class-select');
    const courseSelect = new Choices(courseSelectEl);
    const classSelect = new Choices(classSelectEl, { removeItemButton: true });

    flatpickr("#exam-date", { enableTime: true, dateFormat: "d-m-Y H:i", locale: 'tr' });

    let questionCounter = 0;
    let learningOutcomesCache = [];

    // Kazanımları sunucudan çek
    function fetchLearningOutcomes() {
        const courseId = courseSelect.getValue(true);
        const selectedClasses = classSelect.getValue(true);
        if (!courseId || !selectedClasses || selectedClasses.length === 0) {
            learningOutcomesCache = []; updateAllKazanımSelects(); return;
        }
        const firstClassId = selectedClasses[0];
        const gradeLevel = $(`#class-select option[value="${firstClassId}"]`).data('grade');
        if (gradeLevel) {
            $.ajax({
                url: '../islemler/get-kazanimlar.php',
                type: 'POST', data: { course_id: courseId, grade_level: gradeLevel }, dataType: 'json',
                success: function(data) { learningOutcomesCache = data; updateAllKazanımSelects(); },
                error: function() { learningOutcomesCache = []; updateAllKazanımSelects(); }
            });
        }
    }

    courseSelectEl.addEventListener('change', fetchLearningOutcomes);
    classSelectEl.addEventListener('change', fetchLearningOutcomes);

    // Tüm kazanım select'lerini güncelle
    function updateAllKazanımSelects() {
        $('.question-objective').each(function() {
            const select = this;
            const currentVal = $(this).val();
            if (this.choices) { this.choices.destroy(); }
            select.innerHTML = '<option value="">Kazanım Seçiniz...</option>';
            learningOutcomesCache.forEach(item => {
                const selected = item.id == currentVal ? 'selected' : '';
                select.innerHTML += `<option value="${item.id}" ${selected}>${item.outcome_code} - ${item.description}</option>`;
            });
            new Choices(select, { searchResultLimit: 10, shouldSort: false });
        });
    }

    // Toplam puanı güncelle
    function updateTotalPoints() {
        let total = 0;
        $('.question-points').each(function() { total += parseInt($(this).val()) || 0; });
        const totalPointsEl = $('#total-points');
        totalPointsEl.text(total);
        totalPointsEl.toggleClass('text-danger', total !== 100).toggleClass('text-success', total === 100);
    }

    // Yeni soru ekle
    function addQuestion(type) {
        questionCounter++;
        const templateId = type + '-template';
        const template = document.getElementById(templateId).innerHTML;
        const questionHtml = template.replace(/counter/g, questionCounter);
        $('#questions-container').append(questionHtml);
        updateAllKazanımSelects();
        updateTotalPoints();
        // Soru numaralarını güncelle
        $('.question-card').each((index, el) => $(el).find('.card-header h5').text(`Soru ${index + 1}`));
    }

    // Olay Dinleyicileri
    $('#questions-container').on('input', '.question-points', updateTotalPoints);
    $('#questions-container').on('click', '.remove-question-btn', function() {
        $(this).closest('.question-card').remove();
        $('.question-card').each((index, el) => $(el).find('.card-header h5').text(`Soru ${index + 1}`));
        questionCounter = $('.question-card').length;
        updateTotalPoints();
    });

    // Çoktan seçmeli şık ekle/sil
    $('#questions-container').on('click', '.add-option-btn', function() {
        const optionsContainer = $(this).closest('.col-lg-7').find('.options-container');
        const radioName = optionsContainer.find('input[type=radio]').attr('name');
        const nextChar = String.fromCharCode(65 + optionsContainer.children().length);
        if (optionsContainer.children().length < 5) {
            const newOptionHtml = `<div class="input-group mb-2"><div class="input-group-text"><input class="form-check-input" type="radio" name="${radioName}" value="${nextChar}"></div><span class="input-group-text">${nextChar})</span><input type="text" class="form-control" name="${radioName.replace('[correct]', '[options]')}[${nextChar}]"></div>`;
            optionsContainer.append(newOptionHtml);
        }
    });
    $('#questions-container').on('click', '.remove-option-btn', function() {
        const optionsContainer = $(this).closest('.col-lg-7').find('.options-container');
        if (optionsContainer.children().length > 2) {
            optionsContainer.children().last().remove();
        }
    });

    $('#add-mcq-btn').on('click', (e) => { e.preventDefault(); addQuestion('mcq'); });
    $('#add-tf-btn').on('click', (e) => { e.preventDefault(); addQuestion('tf'); });
    $('#add-open-btn').on('click', (e) => { e.preventDefault(); addQuestion('open'); });

    // Form gönderimini kontrol et
    $('#create-exam-form').on('submit', function(e) {
        if ($('.question-card').length === 0) {
            e.preventDefault();
            alert('HATA: Sınava hiç soru eklemediniz!');
            return;
        }
        const total = parseInt($('#total-points').text());
        if (total !== 100) {
            e.preventDefault();
            alert('HATA: Toplam soru puanı 100 olmalıdır! Mevcut toplam: ' + total);
        }
    });

    // Sayfa yüklendiğinde kazanımları çekmeyi dene (eğer varsayılan değerler seçiliyse)
    setTimeout(fetchLearningOutcomes, 200);
});