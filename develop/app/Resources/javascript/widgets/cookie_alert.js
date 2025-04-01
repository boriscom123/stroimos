const COOKIE_ALERT_ID = 'cookie_alert';
const STORAGE_KEYS = {
  CLOSE_COUNT: 'cookieAlertCloseCount',
  LAST_CLOSED: 'cookieAlertLastClosed'
};

// Интервалы показа в миллисекундах (1 секунда = 1000 мс)
const SHOW_INTERVALS = [
  0,            // 0 мс - первый показ сразу
  1209600000,   // 14 дней   = 14 * 24 * 60 * 60 * 1000
  2592000000,   // 30 дней   = 30 * 24 * 60 * 60 * 1000
  7776000000,   // 90 дней   = 90 * 24 * 60 * 60 * 1000
  31536000000   // 365 дней  = 365 * 24 * 60 * 60 * 1000
];

const ANIMATION_DELAY = 200; // Совпадает с CSS-анимацией
let autoHideTimer = null;    // Таймер автоскрытия

function getStoredNumber(key) {
  try {
    return parseInt(localStorage.getItem(key), 10) || 0;
  } catch (e) {
    return 0;
  }
}

function saveCloseInfo() {
  try {
    const closeCount = getStoredNumber(STORAGE_KEYS.CLOSE_COUNT) + 1;
    localStorage.setItem(STORAGE_KEYS.CLOSE_COUNT, closeCount);
    localStorage.setItem(STORAGE_KEYS.LAST_CLOSED, Date.now());
  } catch (e) {
    console.error('Ошибка localStorage:', e);
  }
}

function hideElement(element) {
  element.classList.remove('is-visible');
  
  if (autoHideTimer) {
    clearTimeout(autoHideTimer);
    autoHideTimer = null;
  }
  
  element.addEventListener('transitionend', () => {
    element.style.display = 'none';
  }, {once: true});
}

function showElement(element) {
  element.style.display = 'flex';
  requestAnimationFrame(() => {
    element.classList.add('is-visible');
  });
}

function acceptCookieAlert() {
  const cookieAlert = document.getElementById(COOKIE_ALERT_ID);
  if (!cookieAlert) return;
  
  hideElement(cookieAlert);
  saveCloseInfo();
}

function shouldShowAlert(closeCount, lastClosed) {
  const intervalIndex = Math.min(closeCount, SHOW_INTERVALS.length - 1);
  const currentInterval = SHOW_INTERVALS[intervalIndex];
  return currentInterval !== Infinity && Date.now() - lastClosed >= currentInterval;
}

document.addEventListener('DOMContentLoaded', () => {
  const cookieAlert = document.getElementById(COOKIE_ALERT_ID);
  if (!cookieAlert) return;

  const closeCount = getStoredNumber(STORAGE_KEYS.CLOSE_COUNT);
  const lastClosed = getStoredNumber(STORAGE_KEYS.LAST_CLOSED);

  if (shouldShowAlert(closeCount, lastClosed)) {
    showElement(cookieAlert);
    
    // Автоскрытие через 60 секунд без сохранения
    autoHideTimer = setTimeout(() => {
      if (cookieAlert.classList.contains('is-visible')) {
        hideElement(cookieAlert);
      }
    }, 60000);
  }

  const acceptButton = document.querySelector('[data-cookie-accept]');
  if (acceptButton) {
    acceptButton.addEventListener('click', acceptCookieAlert);
  }
});