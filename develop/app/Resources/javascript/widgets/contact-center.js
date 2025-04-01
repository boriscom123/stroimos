$(document).ready(function () {
    const wrapper = document.querySelector('.contact-center-page-wrapper');

    if (!wrapper) {
        console.error('Контейнер contact-center-page-wrapper не найден.');
        return;
    }

    const introductionLink = wrapper.querySelector('#introduction-link');
    const infoGroup = wrapper.querySelector('#info-group');
    const legalRadio = wrapper.querySelector('#legal');
    const personRadio = wrapper.querySelector('#person');
    const personLegalGroup = wrapper.querySelector('.person-legal-group');
    const inputLegalGroup = personLegalGroup.nextElementSibling;
    const phoneInput = wrapper.querySelector('#phone');
    const inputs = wrapper.querySelectorAll('.input-line, .input-area') || [];
    const requiredFields = wrapper.querySelectorAll('.input-line[required], .input-area[required]') || [];
    const consentCheckbox = wrapper.querySelector('#consent');
    const submitButton = wrapper.querySelector('button[type="submit"]');
    const appealForm = wrapper.querySelector('.appeal-form');
    const successPopup = wrapper.querySelector('#success-popup');
    const errorPopup = wrapper.querySelector('#error-popup');

    // слайдер
    $(wrapper.querySelector('.js-services-slider')).slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: wrapper.querySelector('.js-prev-button'),
        nextArrow: wrapper.querySelector('.js-next-button'),
    });

    document.body.style.scrollBehavior = 'smooth !important';

    introductionLink.addEventListener('click', function (event) {
        event.preventDefault();

        const targetPosition = infoGroup.getBoundingClientRect().top + window.scrollY;
        console.log(targetPosition)
        window.scrollTo({
            top: targetPosition,
            behavior: 'smooth',
        });
    });

    // функция переключения видимости элемента
    const toggleElementVisibility = (element, displayStyle) => {
        const styleValue = displayStyle || 'flex';
        if (element.style.display === styleValue) {
            element.style.display = 'none';
        } else {
            element.style.display = styleValue;
        }
    };

    // Чек-бокс физ./юр. лицо и инпут ввода наименования юр лица
    legalRadio.addEventListener('change', () => toggleElementVisibility(inputLegalGroup));
    personRadio.addEventListener('change', () => toggleElementVisibility(inputLegalGroup));
    toggleElementVisibility(inputLegalGroup);

    // проверка заполнения обязательных полей и блокировка / разблокировка кнопки отправки формы
    function validateRequiredFields() {
        const isConsentChecked = consentCheckbox.checked;
        const areRequiredFieldsFilled = Array.from(requiredFields).every(field => field.value.trim() !== '');
        const isPhoneChecked = phoneInput.value.length >= 16;

        submitButton.disabled = !(areRequiredFieldsFilled && isPhoneChecked && isConsentChecked);
    }

    requiredFields.forEach(field => {
        field.addEventListener('input', validateRequiredFields);
    });
    consentCheckbox.addEventListener('change', validateRequiredFields);

    // добавление / удаление кнопки сброса содержимого инпута
    inputs.forEach(input => {
        const resetButton = input.parentElement.querySelector('.input-reset-button');

        if (resetButton) {
            const updateResetButtonVisibility = () => {
                resetButton.style.display = input.value.trim() !== '' ? 'block' : 'none';
            };

            input.addEventListener('input', updateResetButtonVisibility);

            resetButton.addEventListener('click', (event) => {
                event.preventDefault();
                input.value = '';
                updateResetButtonVisibility();
                validateRequiredFields();
            });

            updateResetButtonVisibility();
        }
    });

    // проверка ввода номера телефона
    const checkPhoneNumberInput = () => {
        let value = phoneInput.value.replace(/\D/g, '');
        let formattedValue = '+';

        if (value.length > 0) formattedValue += value.substring(0, 1);
        if (value.length > 1) formattedValue += '-' + value.substring(1, 4);
        if (value.length > 4) formattedValue += '-' + value.substring(4, 7);
        if (value.length > 7) formattedValue += '-' + value.substring(7, 9);
        if (value.length > 9) formattedValue += '-' + value.substring(9, 11);

        phoneInput.value = formattedValue.substring(0, 17);
    };

    phoneInput.addEventListener('input', checkPhoneNumberInput);

    validateRequiredFields();

    // открытие модального окна
    const openModal = (type) => {
        const modal = type === 'success' ? successPopup : type === 'error' ? errorPopup : null;
        if (modal) {
            document.body.classList.add('no-scroll');
            toggleElementVisibility(modal)

            const closeButton = modal.querySelector('.fetch-result-popup-close-button');
            const overlay = modal.querySelector('.fetch-result-popup-overlay');

            const handleCloseClick = (event) => {
                event.preventDefault();
                closeModal();
            };

            const closeModal = () => {
                document.body.classList.remove('no-scroll');
                toggleElementVisibility(modal);
                closeButton.removeEventListener('click', handleCloseClick);
                overlay.removeEventListener('click', handleCloseClick);
            };

            closeButton.addEventListener('click', handleCloseClick);
            overlay.addEventListener('click', handleCloseClick);
        }
    }

    // Отправка заполненной формы
    appealForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        const formData = new FormData(event.target);

        const selectedPersonLegal = wrapper.querySelector('input[name="person-legal"]:checked');

        // Преобразуем FormData в объект для отправки в формате `application/x-www-form-urlencoded`
        const data = new URLSearchParams();
        formData.forEach((value, key) => {
            if (key === 'person-legal') {
                if (selectedPersonLegal && selectedPersonLegal.id === 'legal') {
                    data.append('person-legal', 'YUL');
                } else data.append('person-legal', 'FL');
            } else {
                data.append(key, key === 'phone' ? value.replace(/-/g, '') : value);
            }
        });

        try {
            const response = await fetch(event.target.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: data.toString(), // Преобразуем данные в строку
            });

            if (response.ok) {
                const result = await response.json();
                openModal('success')
                appealForm.reset()
                legalRadio.checked = true;
                inputLegalGroup.style.display = 'flex';
                validateRequiredFields();
                // console.log('Ответ сервера:', result);
            } else {
                const error = await response.text();
                openModal('error')
                // console.error('Ошибка:', error);
            }
        } catch (error) {
            alert('Ошибка сети!');
            console.error('Ошибка сети:', error);
        }
    });
});
